<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Chronos\Chronos;
use App\Traits\AppTrait;
use \Mailjet\Resources;

class SendSmsShell extends Shell
{
    
    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    public function main()
    {
        $this->out('Choisir la methode à lancer');
    }

    /**
     * send sms (copie de sendSms dans DevisController)
     * @param type $telephone
     * @param string $text
     */   
    public function send($telephone, $text = null){
        
        if(!empty($telephone) ){
            $numeroDestinataire = trim(trim($telephone));
            $_2PremierLettre = substr($numeroDestinataire,0,2);
            $_3PremierLettre = substr($numeroDestinataire,0,3);
            $numeroDestinataire = str_replace(" ", "", $numeroDestinataire);
            if($_2PremierLettre == "06" || $_2PremierLettre == "07" || $_3PremierLettre == "+33"){ // On fait de l'envoi pour la france seulement
                    $codepaysDefault   = "+33";
                    if (strpos($numeroDestinataire, "+") === false) {
                        $numeroDest         = substr($numeroDestinataire, 1);
                        $numeroDestinataire = $codepaysDefault . $numeroDest;
                    } else {
                        $numeroDestinataire = $numeroDestinataire;
                    }
                    
                    $body = ['From' => 'SELFIZEE', 'To'=>$numeroDestinataire, 'Text'=>$text];
                    $mjsms = new \Mailjet\Client('01fa19fab78948018b2d162083aa391f',
                      NULL, true, 
                      ['url' => "api.mailjet.com", 'version' => 'v4', 'call' => false]
                    );
                    $response = $mjsms->post(Resources::$SmsSend, ['body' => $body] );
                    // $response->success() && var_dump($response->getData());
            } else {
                $this->out('Erreur num phon');
            }
        } else {
            $this->out('Num phon vide');
        }
    }
    
    
    /**
     *  preparer le sms
     */
    function preparerSms() {
        
        $this->loadModel('Devis');
        $this->loadModel('SmsAutos');
        
        $day = Chronos::now()->format('l');
        $listDevis = [];
        
        // checker si jeudi (Thursday) : envoyer tout les sms du we
        if ($day == 'Thursday') {
            
            $listDevis = $this->Devis->find('all')
                ->where([
                    'Clients.client_type' => 'person', 
                    'Devis.is_in_sellsy <>' => 1,
                    'OR' => [
                        'Devis.status IN' => ['paid', 'billed'], 
                        'DevisFacture.status' => 'paid'
                    ]
                ])
                ->where([
                    'OR' => [
                        ['Devis.date_evenement' => Chronos::now()->addDay(1)->format('Y-m-d'),], // vendredi
                        [
                            'Devis.date_evenement IN' => [Chronos::now()->addDay(2)->format('Y-m-d'),Chronos::now()->addDay(3)->format('Y-m-d')], // samedi et dimanche
                            'Devis.objet LIKE' => '%week-end%'
                        ]
                    ],
                ])
                ->contain(['Clients' => 'ClientContacts', 'DevisFacture'])->toArray();
                
        } else {
            
            $listDevis = $this->Devis->find('all')
                ->where([
                    'Clients.client_type' => 'person', 
                    'Devis.is_in_sellsy <>' => 1,
                    'Devis.date_evenement' => Chronos::now()->addDay(1)->format('Y-m-d'),
                    'Devis.objet NOT LIKE' => '%week-end%',
                    'OR' => [
                        'Devis.status IN' => ['paid', 'billed'], 
                        'DevisFacture.status' => 'paid'
                    ]
                ])
                ->contain(['Clients' => 'ClientContacts', 'DevisFacture'])->toArray();
                ;
        }
        
        foreach ($listDevis as $devis) {
            $client = $devis->client;
            $telephone = $client->telephone;
            if(! $telephone) {
                foreach ($client->client_contacts as $client_contacts) {
                    if($client_contacts->tel) {
                        $telephone = $client_contacts->tel;
                        break;
                    }
                }
            }
            // si num phon exist
            if($telephone) {
                
                $this->out('Tel : ' . $telephone);
                $typeBorne = $devis->model_type;
                $sms = $this->SmsAutos->findById(1)->first();
                $manuelBorne = $sms->lien_pdf_classik;
                if ($typeBorne == 'spherik') {
                    $manuelBorne = $sms->lien_pdf_spherik;
                }

                $text = str_replace('#MANUEL_BORNE#', $manuelBorne, $sms->contenu);
                // debug($text);die;
                $this->send($telephone, $text);
            }
        
        }
    }
    
}
