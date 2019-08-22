<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use \Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class Registration extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo('App\Events\Events', 'event_id', 'source_id');
    }

    public function getImageQrCodeAttribute(){
        $link       = url('/api/u/' . $this->invoice);
        $imageLink  = 'data:image/png;base64,' . DNS2D::getBarcodePNG($link, "QRCODE",33,33);

        return $imageLink;
    }

    public function getPaymentLinkAttribute(){
        $result = [
            'ip'            => '',
            'invoice'       => $this->invoice
        ];
        $link = url('payment/?token=' . encrypt(json_encode($result)));

        return $link;
    }

    public function getTiketDownloadAttribute(){
        $inv = substr($this->invoice, 0, 3);
        $result = [
            'ip'            => '',
            'invoice'       => $this->invoice
        ];
        if ($inv !== 'RGS') {
            $link = url('tiket-download/?token=' . encrypt(json_encode($result)));
        }
        $link = 'https://importir.org/tiket-download?token=' . encrypt(json_encode($result));

        return $link;
    }
}
