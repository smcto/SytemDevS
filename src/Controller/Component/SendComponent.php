<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;

class SendComponent extends Component{
    
    public $components = ['Smsenvoi'];
    
    public function sms($photo,  $contact, $smsConfiguration,  $forceToSend = false){
        
        $this->Envois = TableRegistry::get('Envois');
        $isAlreadySent = $this->Envois->find()
                                        ->where(['contact_id' => $contact->id, 'envoi_type' => 'sms'])
                                        ->first();
        if($forceToSend){
            $isAlreadySent = false;
        }
        
        //var_dump($isAlreadySent);
        
        if(!$isAlreadySent && in_array($contact->telephone,['+261342109101','+33630682013','033630682013','33630682013','630682013','0630682013'])){
            
            $nomEvenement = $photo->evenement->nom;
    
            
            $nomEmmetteur = 'SELFIZEE';
            $message = 'Retrouvez votre photo '.$nomEvenement.': [[lien_partage]] ';
            if(!empty($smsConfiguration->toArray())){
                
                if(!empty($smsConfiguration->expediteur)){
                    $nomEmmetteur = $smsConfiguration->expediteur;
                }
                
                if(empty($smsConfiguration->contenu)){
                    $message = $smsConfiguration->contenu;
                }
                
            }
            
            
            
            $shareLink = $photo->url_photo_souvenir_shell;
            $message = str_replace('[[lien_partage]]', $shareLink, $message);
            
            $numeroDestinataire = trim($contact->telephone);
            $numeroDestinataire = str_replace(" ", "", $numeroDestinataire);
            $codepaysDefault   = "+33";
            if (strpos($numeroDestinataire, "+") !== false) {
                $numeroDestinataire = $numeroDestinataire;
            } else {
                $numeroDest         = substr($numeroDestinataire, 1);
                $numeroDestinataire = $codepaysDefault . $numeroDest;
            }
            
            $result = $this->Smsenvoi->sendSMS($numeroDestinataire, $message, 'PREMIUM', $nomEmmetteur);
            //debug($result);
            if($result['success']){
                $dataEnvoi['contact_id'] = $contact->id;
                $dataEnvoi['envoi_type'] = 'sms';
                $dataEnvoi['is_force_envoi'] =  $forceToSend;
                $envoi = $this->Envois->newEntity($dataEnvoi);
                $this->Envois->save($envoi);
            }
        }
        
        
    }
    
    public function email($photo, $contact , $emailConfiguration, $forceToSend = false){
        $this->Envois = TableRegistry::get('Envois');
        $isAlreadySentExiste = $this->Envois->find()
                                ->where(['contact_id' => $contact->id, 'envoi_type' => 'email'])
                                ->first();
        
        if($forceToSend){
            $isAlreadySentExiste = false;
        }
         //var_dump($isAlreadySentExiste); 
        if(!$isAlreadySentExiste && in_array($contact->email,['jeanyves@loesys.fr','zanakolonajym@gmail.com','s.mahe@loesys.fr','s.mahe@konitys.fr'])){
            
            //var_dump($emailConfiguration->toArray()); 
            $message = "Bonjour,<br>  <p>Voici votre photo. Cliquer <a hre='[[lien_partage]]'>ici</a> </p><p><em>[[miniature]]</em><br></p>";
            $subject = 'Votre photo depuis SELFIZEE';
            $sender = "contact@selfizee.fr";
            $sendername = "SELFIZEE";
            if(!empty($emailConfiguration->toArray())){
                //debug($emailConfiguration->toArray()); die;
                if(!empty($emailConfiguration->content)){
                    $message = $emailConfiguration->content;
                }
                
                if(!empty($emailConfiguration->objet)){
                    $subject = $emailConfiguration->objet;
                }
                
                if(!empty($emailConfiguration->email_expediteur)){
                    $sender = $emailConfiguration->email_expediteur;
                }
                
                if(!empty($emailConfiguration->nom_expediteur)){
                    $sendername = $emailConfiguration->nom_expediteur;
                }
            }
            $miniature = '<img src="'.$photo->url_photo_shell.'" alt="Votre photo"  width="200px" style="dislpay:block;"/>';
            $minlink    = '<a href="' .$photo->url_photo_souvenir_shell.'" >'.$miniature.'</a>';
           
            $message    = str_replace('[[nom]]', $contact->nom, $message);
            $message    = str_replace('[[email]]', $contact->email, $message);
            $message    = str_replace('[[prenom]]', $contact->prenom, $message);
            $message    = str_replace('[[miniature]]', $miniature, $message);
            $message    = str_replace('[[lien_partage]]', $photo->url_photo_souvenir_shell, $message);
            $message    = str_replace('[[lien_partage_img]]', $photo->url_photo_souvenir_shell, $message);
            $message    = str_replace('[[miniature_lien]]', $minlink, $message);
            
            $destinataire = $contact->email;
            
            $email = new Email();
            $email
                ->setDomain('manager.selfizee.fr')
                ->setViewVars(['content' => $message,'evenement'=>$photo->evenement])
                ->setTemplate('remotevent')
                ->setEmailFormat('html')
                ->setSender($sender,$sendername)
                ->setTo($destinataire);
                
            if ($emailConfiguration->is_photo_en_pj) {
                $email->setAttachments($photo->uri_photo);
            }
    
            $email->setSubject($subject)
                ->setTransport('mailjet')
                ->setHeaders(
                    array(
                        "X-Mailjet-Campaign" => $photo->evenement->slug,
                        "X-MJ-CustomID" => $destinataire,
                        "X-Mailjet-TrackOpen" => 1,
                        "X-Mailjet-TrackClick" => 1)
                );
            
            //var_dump($email);
            
            if ($email->send()) {
                $dataEnvoi['contact_id'] = $contact->id;
                $dataEnvoi['envoi_type'] = 'email';
                $dataEnvoi['is_force_envoi'] =  $forceToSend;
                $envoi = $this->Envois->newEntity($dataEnvoi);
                $this->Envois->save($envoi);
                
            }
            var_dump($contact->email);
        }
        
        
    }

}