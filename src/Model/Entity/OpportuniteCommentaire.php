<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OpportuniteCommentaire Entity
 *
 * @property int $id
 * @property int $opportunite_id
 * @property int|null $commentaire_id_in_sellsy
 * @property int|null $staff_id
 * @property int|null $timestamp
 * @property string|null $date_format
 * @property string|null $titre
 * @property string|null $commentaire
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Opportunite $opportunite
 * @property \App\Model\Entity\Staff $staff
 * @property \App\Model\Entity\User $user
 */
class OpportuniteCommentaire extends Entity
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
        'commentaire_id_in_sellsy' => true,
        'staff_id' => true,
        'timestamp' => true,
        'date_format' => true,
        'titre' => true,
        'commentaire' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'opportunite' => true,
        'staff' => true,
        'user' => true
    ];

    protected  function _getIlya(){
        $now = time();
        $retour = '';
        if(!empty($this->created)){
            $timeCommade = strtotime($this->created->format('Y-m-d H:i:s'));

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
        }
        return $retour;
    }
}
