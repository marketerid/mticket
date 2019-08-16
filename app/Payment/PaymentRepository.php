<?php

namespace App\Payment;

use Illuminate\Support\Facades\Auth;
use App\Events\Registration;

class PaymentRepository
{
    public function getRegisters()
    {
        return Registration::with(['payment'])->get();
    }
    
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
        $data->transaction_id       = $json->transaction_id;
        $data->transaction_time     = $json->transaction_time;
        $data->payment_type         = $json->payment_type;
        $data->gross_amount         = $json->gross_amount;
        $data->transaction_status   = $json->transaction_status;
        $data->fraud_status         = $json->fraud_status;
        $data->paid_by              = 'MIDTRANS';
        $data->dump                 = $request['data'];
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
            $data->paid_by              = 'MIDTRANS';
            $data->save();
        }

        return $data;
    }

    public function notifyStatusMidtrans($response)
    {
        $data       = $this->findInvoice($response['order_id']);
        if(!$data){
            return false;
        }
        if($data AND $data->transaction_status == 'success'){
            // already success
            return false;
        }

        $dump = json_decode($response['dump']);

        $data->invoice_id           = $dump->order_id;
        $data->transaction_id       = $dump->transaction_id;
        $data->transaction_time     = $dump->transaction_time;
        $data->payment_type         = $dump->payment_type;
        $data->gross_amount         = $dump->gross_amount;
        $data->transaction_status   = $response['status_server'];
        $data->fraud_status         = $dump->fraud_status;
        $data->paid_by              = 'MIDTRANS';
        $data->dump                 = $response['dump'];
        $data->save();

        return $data;
    }
}