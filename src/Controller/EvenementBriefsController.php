<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\I18n\Date;
use Cake\Mailer\Email;


class EvenementBriefsController extends AppController
{
    public function initialize()
    {
		$this->loadComponent('Utilities');
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');
		$this->viewBuilder()->setLayout('client');
		
    }

    public function etape($parametre_str = ""){
		$this->loadModel('Evenements');
		$this->loadModel('EvenementBriefs');
		$fin = false;
		
		if(trim($parametre_str) == "" && $_SERVER['SERVER_ADDR'] != '127.0.0.1' && strtolower($_SERVER['SERVER_ADDR']) != 'localhost'){
			// Rédirection page non trouvée
			header("Location: https://www.selfizee.fr/page-non-trouve");
			exit;
		}
		
		
		$parametre = @unserialize($this->Utilities->slDecryption($parametre_str));
		// var_dump($parametre);exit;
		if(!$parametre && $_SERVER['SERVER_ADDR'] != '127.0.0.1' && strtolower($_SERVER['SERVER_ADDR']) != 'localhost'){
			// Rédirection page non trouvée
			header("Location: https://www.selfizee.fr/page-non-trouve");
			exit;
		}
		$onglet = ['evt', 'retrait', 'mail', 'form', 'fb', 'animation'];
		$etape_encours = $parametre['etape'];
		$id = $parametre['id'];
		
		$evenement_tp = $evenement = $this->Evenements->find('all',[
			'conditions'=>['Evenements.id'=>$id],
			'contain'=>['Clients']
		])->first();
		
		if(!$evenement_tp && $_SERVER['SERVER_ADDR'] != '127.0.0.1' && strtolower($_SERVER['SERVER_ADDR']) != 'localhost'){
			// Rédirection page non trouvée
			header("Location: https://www.selfizee.fr/page-non-trouve");
			exit;
		}
		
		// Enlever de la liste si le mail ou fb ne sont pas cochés
		if($evenement_tp['envoyer_recap'] != true && $evenement_tp->client->client_type == 'person'){
			foreach($onglet as $key => $value){
				if($value == 'mail'){
					unset($onglet[$key]);
					break;
				}
			}
		}
		if($evenement_tp['publication_fb'] != true){
			foreach($onglet as $key => $value){
				if($value == 'fb'){
					unset($onglet[$key]);
					break;
				}
			}
		}
		if($evenement_tp['animation_hotesse'] != true){
			foreach($onglet as $key => $value){
				if($value == 'animation'){
					unset($onglet[$key]);
					break;
				}
			}
		}
		if(in_array($evenement_tp['type_installation'], array(12, 13, 14)) || in_array($evenement_tp['desinstallation_id'], array(6, 7))){
			
		}else{
			foreach($onglet as $key => $value){
				if($value == 'retrait'){
					unset($onglet[$key]);
					break;
				}
			}
		}
		
		$onglet = array_values($onglet);
		$etape = $onglet[$etape_encours];

		
		// Enregistrement si post
		if($this->request->is('post') && $id){
			$briefs = $this->EvenementBriefs->find('all',[
				'conditions'=>['EvenementBriefs.evenement_id'=>$id]
			])->first();
			
			if(!$briefs){
				$briefs = $this->EvenementBriefs->newEntity();
			}
			
			$briefs = $this->EvenementBriefs->patchEntity($briefs, $this->request->getData(), ['validate' => false]);

			if($this->EvenementBriefs->save($briefs)) {
				if(($etape_encours + 1) == count($onglet) && !empty($this -> request->getData('fin'))){
					$this->Flash->success(__('The Brief has been saved.'));
					
					// $destinateur = 'pauled8250188@gmail.com';
					$destinateur = 's.mahe@konitys.fr';
					$email = new Email('default');
					$email->setViewVars(['evenement' => $evenement_tp])
						->setTemplate('brief')
						->setEmailFormat('html')
						->setFrom(["contact@konitys.fr" => 'Konitys'])
						->setSubject($evenement_tp['nom_event'] . ' : Briefing')
						->setTo($destinateur);
					if($_SERVER['SERVER_ADDR'] != '127.0.0.1' && strtolower($_SERVER['SERVER_ADDR']) != 'localhost')
						$email->send();
					
					
					$fin = true;
				}
            }else{
				$this->Flash->error(__('The Brief could not be saved. Please, try again.'));
			}
		}
		
		$evenement = $this->Evenements->find('all',[
			'conditions'=>['Evenements.id'=>$id],
			'contain'=>['EvenementBriefs', 'Clients']
		])->first();
		// debug($evenement->toArray());exit;
		if(!$evenement && $_SERVER['SERVER_ADDR'] != '127.0.0.1' && strtolower($_SERVER['SERVER_ADDR']) != 'localhost'){
			// Rédirection page non trouvée
			header("Location: https://www.selfizee.fr/page-non-trouve");
			exit;
		}
		
		$parametre_prec = $this->Utilities->slEncryption(serialize(['id' => $parametre['id'], 'etape' => ($parametre['etape'] - 1)]));
		$parametre_next = $this->Utilities->slEncryption(serialize(['id' => $parametre['id'], 'etape' => ($parametre['etape'] + 1)]));
		
		$this->set(compact('evenement', 'etape', 'onglet', 'parametre', 'parametre_prec', 'parametre_next', 'fin'));
	}
	
}
