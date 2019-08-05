<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\EventsRepository;
use App\Payment\PaymentRepository;
use App\Veritrans\MidtransService;

class ApiController extends Controller
{
    protected $event;
    public function __construct(EventsRepository $event) {
        $this->event    = $event;
    }

    public function checkoutMidtrans(Request $request) {
        $data                   = file_get_contents('php://input');
        $dataJson               = \GuzzleHttp\json_decode($data);
        $register               = $this->event->findInvoice($dataJson->invoice);

        $payment                = new PaymentRepository();
        $merchantMakePayment    = $payment->makePaymentMidtrans($dataJson->invoice, $dataJson->type);
        if(!$merchantMakePayment){
            return response()->json([
                'status'    => false,
                'message'   => "Payment Not Available"
            ]);
        }

        $midtrans   = new MidtransService();
        $result     = $midtrans->getSnapTokens($register->invoice, $register->total);
        return response()->json([
            'token' => $result
        ]);
    }

    public function savePaymentMidtrans($invoice, Request $request) {
        $payment = new PaymentRepository();
        $result = $payment->savePaymentMidtrans($invoice, $request->all());
        return '';
    }

    public function midtransNotification(Request $request) {
        $method         = $request->getRealMethod();
        /*Log::error("Midtrans Notif: " . json_encode([$method, $request->all()]));*/
        if($method == 'POST'){
            return $this->paymentNotificationMidtrans();
        }

        $order_id       = !empty($_GET['order_id']) ? $_GET['order_id'] : null;
        $statusCode     = !empty($_GET['status_code']) ? $_GET['status_code'] : null;
        $transaction    = !empty($_GET['transaction_status']) ? $_GET['transaction_status'] : null;

        $paymentRepo            = new PaymentRepository();
        $paymentData            = $paymentRepo->getMyshortcartByTransmer($order_id);
        $order_id               = ($paymentData) ? $paymentData->com_invoice_id : 0;


        if($transaction == 'capture') {
            // echo "<p>Transaksi berhasil.</p>";

            return redirect(url('cart/view/com-invoice/' . $order_id .'?status=' . $transaction));

        }
        // Deny
        else if($transaction == 'deny') {
            // echo "<p>Transaksi ditolak.</p>";

            return redirect(url('cart/view/com-invoice/' . $order_id.'?status=' . $transaction));

        }
        // Challenge
        else if($transaction == 'challenge') {
            // echo "<p>Transaksi challenge.</p>";

            return redirect(url('cart/view/com-invoice/' . $order_id.'?status=' . $transaction));

        }
        // Error
        else {
            // echo "<p>Terjadi kesalahan pada data transaksi yang dikirim.</p>";

            return redirect(url('cart/view/com-invoice/' . $order_id.'?status=' . $transaction));
        }
    }

    public function paymentNotificationMidtrans() {
        $midtrans   = new MidtransService();
        $response   = $midtrans->notification();

        /*Log::error("Midtrans paymentNotificationMidtrans: " . json_encode([$response]));*/
        if(is_null($response['orderId'])){
            // something error
            return response()->json([
                'status'    => false,
                'message'   => "Something error"
            ]);
        }


        $paymentRepo            = new PaymentRepository();
        $paymentData            = $paymentRepo->notifyStatusMidtrans($response['orderId'], $response['status_server']);

        if(!$paymentData){
            return response()->json([
                'status'    => false,
                'message'   => "Already paid"
            ]);
        }

        if($paymentData->trxstatus == 'success'){
            // mark as paid
            $inputs['paid_with']    = 'Midtrans-' . $response['type'];
            $inputs['paid_amount']  = $paymentData->totalamount;

            $typeTransaction    = 'BP';
            if (strpos($response['orderId'], 'BS') !== false) {
                $typeTransaction = 'BS';
            } else if (strpos($response['orderId'], 'BMO') !== false) {
                $typeTransaction = 'BMO';
            }
            /*Log::error("type midtrans " . $typeTransaction);*/

            if ($typeTransaction == 'BP') {
                $orderId                = $paymentData->com_invoice_id;
                $bill = new ComInvoiceRepository();
                // Check is null
                if ($paymentData->com_invoice->order_id == 0) {
                    DB::beginTransaction();
                    $billResult = $bill->confirmBillUpdateBill($orderId, $inputs);
                    foreach ($paymentData->com_invoice->comInvoiceList as $comInvLis) {
                        $result = $bill->confirmBillPerOrder($comInvLis->yg_order_id, $billResult);
                        if (!$result) {
                            return response()->json([
                                'status' => false,
                                'message' => "Pembayaran gagal"
                            ]);
                        }
                    }
                    DB::commit();
                } else {
                    $result = $bill->confirmBill($paymentData->com_invoice->order_id, $orderId, $inputs);
                    //Log::error("Midtrans confirmBill: " . json_encode([$result,$paymentData->com_invoice->order_id, $orderId, $inputs]));
                    if (!$result) {
                        return response()->json([
                            'status' => false,
                            'message' => "Pembayaran gagal"
                        ]);
                    }
                }
            } else if ($typeTransaction == 'BS') {
                $orderId                = $paymentData->custom_invoices_id;
                $bill   = new CustomBillRepository();
                $result = $bill->confirmBill($paymentData->custom_invoices->shipping_id, $orderId, $inputs);
                if (!$result) {
                    return response()->json([
                        'status' => false,
                        'message' => "Pembayaran gagal"
                    ]);
                }
                $result = $paymentData->custom_invoices->shipping;
            } else {
                $orderId                = $paymentData->member_orders_id;
                $bill   = new MemberOrderRepository();
                $result = $bill->confirmBill($orderId, $inputs);
                if (!$result) {
                    return response()->json([
                        'status' => false,
                        'message' => "Pembayaran gagal"
                    ]);
                }
                $newMo  = $result;

                $orgRepo        = new OrgUserRepository();
                $countryCode    = 'id';
                $orgRepo->createBulkUser(1, $newMo->email, 'importirbaru', 0, 'transaction_fee', 1, 'ORG', $newMo->price_idr, $countryCode,  true);

                $bcc[]          = $newMo->email;
                $password = 'importirbaru';
                $view   = view('mail.shipping.sendgrid-bulk', compact('password'))->render();

                $css    = asset('css/org-mail.css');
                $view   = new CssInliner($view, file_get_contents($css));

                $send = $orgRepo->sendBulkSendGrid($bcc,$view->convert());
                $email  = new EmailService();
                $messageSubject = Lang::get('messages.Order updated', [
                    'invoice'   => ''
                ], $result->lang);
                $messageEmail   = $newMo->promo->after_paid_email;
                $messageEmail   = $bill->replaceDynamicVarMO($messageEmail, $newMo);
                $user   = new \stdClass();
                $user->email    = $result->email;
                $user->phone    = $result->phone;
                $user->name     = $result->full_name;
                $resultEmail = $email->generalMail($user, $messageSubject, $messageEmail);
                // sms
                $sms        = new ZenzivaService();
                $messagePhone   = $newMo->promo->after_paid_sms;
                $messagePhone   = $bill->replaceDynamicVarMO($messagePhone, $newMo);
                $resultSms = $sms->send($messagePhone, $user->phone);

                $this->segment->track($result->user, 'Purchased', [
                    "invoice"   => "Bill-" . $orderId,
                    "price"     => $result->total_price
                ]);

                return response()->json([
                    'status'    => true,
                    'message'   => "Pembayaran sukses"
                ]);
            }


            $email  = new EmailService();
            $messageSubject = Lang::get('messages.Order updated', [
                'invoice'   => ''
            ], $result->user->language);
            $messageEmail   = Lang::get('messages.Your bill has been paid off and confirmed by the admin, please log in to your Importer.com Dashboard to monitor orders',
                [], $result->user->language);
            $email->generalMail($result->user, $messageSubject, $messageEmail);
            // sms
            $sms        = new ZenzivaService();
            $messagePhone   = Lang::get('messages.Bill for for Invoice has paid off, please log in to your account to monitor orders !. NO REPLY',
                ['bpnumber' => 'BP' . $result->id, 'invoice' => $result->invoice_no], $result->user->language);
            $sms->send($messagePhone, $result->user->phone);

            $this->segment->track($result->user, 'Purchased', [
                "invoice"   => "Bill-" . $orderId,
                "price"     => $result->total_price
            ]);

            return response()->json([
                'status'    => true,
                'message'   => "Pembayaran sukses"
            ]);
        }
        // process here

        return response()->json([
            'status'    => false,
            'message'   => "Pembayaran pending"
        ]);
    }

    public function getImportir() {
        $data = file_get_contents("https://importir.com/api/seminar-json?key=faizalganteng");
        $array = json_decode($data, true);
        foreach($array as $row){
            $id = $row['id'];
            if($row['seminar_type'] == 'event') {
                $type = 'seminar';
            } else {
                $type = $row['seminar_type'];
            }
            $events = [
                'source_id'             =>  $row['id'],
                'type'                  => $type,
                'title'                 => $row['seminar_title'],
                'description'           => $row['info']['desc'],
                'image'                 => $row['info']['maps'],
                'city'                  => $row['city'],
                'price'                 => $row['info']['one_person_fee'],
                'event_date'            => $row['info']['event_date'],
                'before_paid_sms'       => $row['info']['before_paid_sms'],
                'after_paid_sms'        => $row['info']['after_paid_sms'],
                'before_paid_email'     => $row['info']['before_paid_email'],
                'after_paid_email'      => $row['info']['after_paid_email'],
                'is_full'               => $row['info']['is_full'],
                'status'                => $row['info']['status']
            ];
            $this->event->cronjob($id, $events);
        }
        $json['message'] = 'success';
        return response()->json($json);
    }
}