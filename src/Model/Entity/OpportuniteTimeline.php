<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OpportuniteTimeline Entity
 *
 * @property int $id
 * @property int $opportunite_id
 * @property int $time_action
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int $opportunite_action_id
 * @property int|null $user_id
 * @property int|null $pipeline_etape_id
 * @property int|null $opportunite_statut_id
 *
 * @property \App\Model\Entity\Opportunite $opportunite
 * @property \App\Model\Entity\OpportuniteAction $opportunite_action
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\PipelineEtape $pipeline_etape
 */
class OpportuniteTimeline extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'opportunite_id' => true,
        'time_action' => true,
        'created' => true,
        'opportunite_action_id' => true,
        'user_id' => true,
        'pipeline_etape_id' => true,
        'opportunite_statut_id' => true,
        'opportunite' => true,
        'opportunite_action' => true,
        'user' => true,
        'pipeline_etape' => true
    ];

    protected  function _getIlya(){
        $now = time();
        $timeCommade = $this->time_action;

        $diff = abs($now - $timeCommade); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        $retour = ' 1 s';
     
        $tmp = $diff;
        $second = $tmp % 60;
     
        $tmp = floor( ($tmp - $second) /60 );
        $minute = $tmp % 60;
     
        $tmp = floor( ($tmp - $minute)/60 );
        $hour = $tmp % 24;
     
        $tmp = floor( ($tmp - $hour)  /24 );
        $day = $tmp;
        if($day > 0){
            return $day.' j';
        }elseif($hour > 0){
            return $hour.' h';
        }elseif($minute > 0){
            return $minute.' mn';
        }else{
            return $second.' s';
        }
     
        return $retour;
    }
}
