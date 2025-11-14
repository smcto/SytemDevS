<?php
/**
 * Created by PhpStorm.
 * User: Cell
 * Date: 07/07/2018
 * Time: 19:36
 */

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\TeamviewerAPIComponent;

class TeamviewerShell extends Shell
{
    public function updateStatusDevices(){
        $this->out('Lancement');
        $this->loadModel('Bornes');
        $this->teamviewerAPIComponent = new TeamviewerAPIComponent(new ComponentRegistry());
        $result = $this->teamviewerAPIComponent->getDevice("");
        if($result != null) {
            foreach ($result['devices'] as $device) {
                $borne = $this->Bornes->find('all', ['conditions' => ['teamviewer_device_id' => $device['device_id']]])->first();
                if ($borne) {
                    $this->out('Borne => '.$device['device_id']);
                    if ($device['online_state'] == 'Online') {
                        $borne->teamviewer_online_state = 1;
                    } else {
                        $borne->teamviewer_online_state = 0;
                    }
                    if($this->Bornes->save($borne)){
                        $this->out('Device => '.$device['device_id']);
                        $this->out('Borne '.$borne->numero.' => Status on line : '.$borne->teamviewer_online_state);
                    };
                }
                else {
                    $this->out('Device => '.$device['device_id'].'  Non assigné');
                }
            }
        } else {
            $this->out('Pas de resultat');
        }
        $this->out('Fin');
    }
}