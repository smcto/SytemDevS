<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use \Mailjet\Resources;


class MailjetComponent extends Component
{

    private $apikey = '4413cf13ca9e713fafba8cbd5e902da1';
    private $apisecret = '845250b037479ebf644c97559456906a';

    public function sendEmail($destinataire, $subject, $message, $attachements =null, $cc = null , $sender = 'contact@konitys.fr', $sendername ='Selfizee', $campaign = 'DEVIS'){

    
        $mj = new \Mailjet\Client($this->apikey, $this->apisecret, true, ['version' => 'v3.1']);

        $body = [
                    'Messages' => [
                        [
                            'From' => [
                                'Email' => $sender,
                                'Name' => $sendername
                            ],
                            'To' => [
                                [
                                    'Email' => $destinataire,
                                ]
                            ],
                            'Subject' => $subject,
                            'HTMLPart' => $message,
                            'CustomCampaign' => $campaign,
                            'X-Mailjet-TrackOpen'=>1,
                            'X-Mailjet-TrackClick'=>1,
                            'Attachments' => $attachements
                        ]
                    ]
                ];
    
        /*var_dump($attachements);
        if(!empty($attachements)){
            $body['Attachments'] = $attachements ;
        }*/
    
        //var_dump($body); die;
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();

        return $response->getData();
    }


}