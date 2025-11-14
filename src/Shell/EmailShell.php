<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\I18n\Date;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Routing\Router;

/**
 * Simple console wrapper around Psy\Shell.
 */
class EmailShell extends Shell
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

  
    public function relanceEvenement($type = null)
    {
        $this->out('Lancement');
        $this->loadModel('DateEvenements');
        $now =  date("Y-m-d"); // === new Date(date("Y-m-d")); $interval = $this->dateDifference($now2, $now);
        $nbr_jrs_avant = 2;
        $nbr_jrs_apres = 2;
        $date_reference_avant = date("Y-m-d", strtotime($now. "+".$nbr_jrs_avant." days"));
        $date_reference_apres = date("Y-m-d", strtotime($now. "-".$nbr_jrs_apres." days"));
        //debug($date_reference_avant);//debug($date_reference_apres);die;

        $date_evenements = $this->DateEvenements->find('all', [
            'contain' =>
                [
                    'Evenements' => [
                        'TypeEvenements',
                        'Antennes',
                        'Clients' => function ($q)  use ($type)  {
                            $q->where(['Clients.client_type' => 'person']);
                            $q->matching('Documents', function ($qq) use ($type) {
                                if($type == 1) { // avant
                                    $qq->where(['Documents.deleted_in_sellsy IS' => false, 'OR' => [['Documents.step =' => 'late'], ['Documents.step =' => 'payinprogress']]]);
                                }
                                return $qq;
                            });
                            return $q;
                        }
                    ]
                ]
        ])->group('DateEvenements.id');
        if($type == 1){ // >= // avant
            $date_evenements = $date_evenements->where(['is_sent_relance_av IS' => false]);
            $date_evenements = $date_evenements->where(['date_debut =' => $date_reference_avant]);
        }
        if($type == 2){ // <= // apres
            $date_evenements = $date_evenements->where(['is_sent_relance_ap IS' => false]);
            $date_evenements = $date_evenements->where(['date_fin =' => $date_reference_apres]);
        }
        $date_evenements = $date_evenements->toArray();

        /*debug($date_evenements);
        debug(count($date_evenements));die;*/

        $result = "NULL";
        if(!empty($date_evenements)) {
            foreach ($date_evenements as $key => $date_evenement) {
                //debug($date_evenement->evenement->client);
                if (!empty($date_evenement->evenement->client->email)) {
                    $destinateur = $date_evenement->evenement->client->email;
                    $email = new Email('default');
                    $email->setViewVars(['date_evenement' => $date_evenement, 'type' => $type])
                        ->setTemplate('relance')
                        ->setEmailFormat('html')
                        ->setFrom(["contact@konitys.fr" => 'Konitys'])
                        ->setSubject('Konitys')
                        ->setTo('s.mahe@loesys.fr');
                        //->setTo($destinateur);
                    if ($email->send()) {
                        
                        $date_evenement = $this->DateEvenements->get($date_evenement->id);
                        if($type == 1) {
                            $date_evenement->is_sent_relance_av = true;
                            $date_evenement->date_relance_av = $now;
                        } else
                        if($type == 2) {
                            $date_evenement->is_sent_relance_ap = true;
                            $date_evenement->date_relance_ap = $now;
                        }
                        $this->DateEvenements->save($date_evenement);

                        $result = 'Sent... | '.$key;
                        $this->out($result);
                    }
                }
            }
        }

        $this->out('Terminer...');
    }

    public function relanceEvenement2($type = null)
    {
        $this->out('Lancement');
        $this->loadModel('DateEvenements');
        $now =  date("Y-m-d"); // === new Date(date("Y-m-d")); $interval = $this->dateDifference($now2, $now);

        $nbr_jrs_avant = 2;
        $nbr_jrs_apres = 2;
        $date_reference_avant = date("Y-m-d", strtotime($now. "+".$nbr_jrs_avant." days"));
        $date_reference_apres = date("Y-m-d", strtotime($now. "-".$nbr_jrs_apres." days"));
        //debug($date_reference_avant); //debug($date_reference_apres);die;
        $date_evenements = $this->DateEvenements->find('all', [
            'contain' =>
                [
                    'Evenements' => [
                        'TypeEvenements',
                        'Antennes',
                        'Clients' => function ($q)  use ($type)  {
                            $q->where(['Clients.client_type' => 'person']);
                            $q->matching('Documents', function ($qq) use ($type) {
                                if($type == 1) {
                                    //$qq->where(['Documents.deleted_in_sellsy IS' => false, 'OR' => [['Documents.step =' => 'late'], ['Documents.step =' => 'payinprogress']]]);
                                }
                                return $qq;
                            });
                            return $q;
                        }
                    ]
                ]
        ])->group('DateEvenements.id');
        if($type == 1){ // >=
            $date_evenements = $date_evenements->where(['is_sent_relance_av IS' => false]);
            $date_evenements = $date_evenements->where(['date_debut >=' => $date_reference_avant]);
        }
        if($type == 2){ // <=
            $date_evenements = $date_evenements->where(['is_sent_relance_ap IS' => false]);
            $date_evenements = $date_evenements->where(['date_fin <=' => $date_reference_apres]);
        }
        $date_evenements = $date_evenements->toArray();

        /*debug($date_evenements);
        debug(count($date_evenements));die;*/

        $result = "NULL";
        if(!empty($date_evenements)) {
            foreach ($date_evenements as $key => $date_evenement) {
                //debug($date_evenement->evenement->client);
                if (!empty($date_evenement->evenement->client->email)) {
                    $destinateur = $date_evenement->evenement->client->email;
                    $email = new Email('default');
                    $email->setViewVars(['date_evenement' => $date_evenement, 'type' => $type])
                        ->setTemplate('relance')
                        ->setEmailFormat('html')
                        ->setFrom(["contact@konitys.fr" => 'Konitys'])
                        ->setSubject('Konitys')
                        ->setTo('celest1.pr@gmail.com');
                    //->setTo($destinateur);
                    if ($email->send()) {
                        $date_evenement = $this->DateEvenements->get($date_evenement->id);
                        if($type == 1) {
                            $date_evenement->is_sent_relance_av = true;
                            $date_evenement->date_relance_av = $now;
                        } else
                        if($type == 2) {
                            $date_evenement->is_sent_relance_ap = true;
                            $date_evenement->date_relance_ap = $now;
                        }
                        $this->DateEvenements->save($date_evenement);
                        $result = 'Sent... | '.$key;
                        $this->out($result);
                    }
                }
            }
        }

        $this->out('Terminer...');
    }
}
