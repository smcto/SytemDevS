<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Opportunite Entity
 *
 * @property int $id
 * @property int|null $id_in_sellsy
 * @property string $numero
 * @property string $nom
 * @property int|null $opportunite_statut_id
 * @property float|null $montant_potentiel
 * @property \Cake\I18n\FrozenDate|null $date_echeance
 * @property int|null $pipeline_id
 * @property int|null $pipeline_etape_id
 * @property float|null $probabilite
 * @property string|null $note
 * @property string|null $brief
 * @property int|null $type_client_id
 * @property int|null $source_lead_id
 * @property int|null $contact_raison_id
 * @property int|null $type_evenement_id
 * @property string|null $type_demande
 * @property string|null $antenne_retrait
 * @property string|null $antenne_retrait_secondaire
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\OpportuniteStatut $opportunite_statut
 * @property \App\Model\Entity\Pipeline $pipeline
 * @property \App\Model\Entity\PipelineEtape $pipeline_etape
 * @property \App\Model\Entity\TypeClient $type_client
 * @property \App\Model\Entity\SourceLead $source_lead
 * @property \App\Model\Entity\ContactRaison $contact_raison
 * @property \App\Model\Entity\TypeEvenement $type_evenement
 * @property \App\Model\Entity\OpportuniteClient[] $opportunite_clients
 */
class Opportunite extends Entity
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
        'id_in_sellsy' => true,
        'numero' => true,
        'nom' => true,
        'opportunite_statut_id' => true,
        'montant_potentiel' => true,
        'date_echeance' => true,
        'pipeline_id' => true,
        'pipeline_etape_id' => true,
        'probabilite' => true,
        'note' => true,
        'brief' => true,
        'type_client_id' => true,
        'source_lead_id' => true,
        'contact_raison_id' => true,
        'type_evenement_id' => true,
        'type_demande' => true,
        'antenne_retrait' => true,
        'antenne_retrait_secondaire' => true,
        'created' => true,
        'modified' => true,
        'opportunite_statut' => true,
        'pipeline' => true,
        'pipeline_etape' => true,
        'type_client' => true,
        'source_lead' => true,
        'contact_raison' => true,
        'type_evenement' => true,
        'opportunite_clients' => true,
        'linked_docs' => true,
        'client_id' => true,
        'staffs' => true,
        'users' => true,
        'client_id_in_sellsy' => true,
        'id_in_wp' => true,
        'nom_evenement' => true,
        'nbr_participants' => true,
        'date_debut_event' => true,
        'date_fin_event' => true,
        'demande_precision' => true,
        'nbr_borne' => true,
        'option_fond_vert' => true,
        'opportunite_type_borne_id' => true,
        'impression' => true,
        'lieu_evenement' => true,
        'evenement_id' => true,
        'evenement' => true,
        'besion_borne_id' => true,
        'option_fond_vert_id' => true,
    ];

    protected  function _getIlya(){
        $now = time();
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
     
        return $retour;
    }

 
}
