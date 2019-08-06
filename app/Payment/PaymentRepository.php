<?php

namespace App\Payment;

use Illuminate\Support\Facades\Auth;
use App\Events\EventsRepository;

class PaymentRepository
{
    public function findInvoice($inv = '')
    {
        return Payment::with([])->where('invoice_id', $inv)->first();
    }

    public function savePaymentMidtrans($invoice, $request)
    {
        $data = $this->findInvoice($invoice);
        if (!$data) {
            return '';
        }
        $json = json_decode(json_encode($request['data']));
        $data->transaction_id = $json->transaction_id;
        $data->transaction_time = $json->transaction_time;
        $data->payment_type = $json->payment_type;
        $data->gross_amount = $json->gross_amount;
        $data->status_message = $json->status_message;
        $data->transaction_status = $json->transaction_status;
        $data->fraud_status = $json->fraud_status;
        $data->pdf_url = $json->pdf_url;
        $data->save();

        return '';
    }

    public function makePaymentMidtrans($invoice, $type){
        if(!$invoice){
            return false;
        }

        $data      = $this->findInvoice($invoice);
        if($data AND $data->status == 'success'){
            // already success
            return false;
        }

        if(!$data){
            // create new
            $data                       = new Payment();
            $data->invoice_id           = $invoice;
            $data->transaction_status   = 'requested';
            $data->transaction_time     = date("Y-m-d H:i:s");
            $data->paid_by              = 'midtrans';
            $data->save();
        }

        return $data;
    }

    public function notifyStatusMidtrans($invoiceNo, $status = 'pending')
    {
        $data       = $this->findInvoice($invoiceNo);
        if(!$data){
            return false;
        }
        if($data AND $data->transaction_status == 'success'){
            // already success
            return false;
        }

        $data->transaction_status    = $status;
        $data->save();

        return $data;
    }
}