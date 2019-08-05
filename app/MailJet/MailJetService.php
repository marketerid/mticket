<?php
namespace App\MailJet;

use \Mailjet\Resources;
class MailJetService{
    protected $from_email, $from_name;
    public function __construct()
    {
        $this->from_email   = "susan@wasend.id";
        $this->from_name    = "Susanti Advertiser";
    }

    public function send($email, $name, $subject, $message){
        $mj = new \Mailjet\Client(env('MJ_APIKEY_PUBLIC'), env('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->from_email,
                        'Name'  => $this->from_name
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            'Name'  => $name
                        ]
                    ],
                    'Cc' => [
                        [
                            'Email' => "mail@mjniuz.com",
                            'Name' => "CS Team"
                        ]
                    ],
                    'Subject'   => $subject,
                    'TextPart'  => strip_tags($message),
                    'HTMLPart'  => $message
                ]
            ]
        ];
        try{
            $response = $mj->post(Resources::$Email, ['body' => $body]);
        }catch (\Exception $exception){
            return false;
        }

        return $response->success() && $response->getData();
    }
}