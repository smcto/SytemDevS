<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * Reglement Entity
 *
 * @property int $id
 * @property string $type
 * @property int|null $client_id
 * @property \Cake\I18n\FrozenTime $date
 * @property int $moyen_reglement_id
 * @property float $montant
 * @property string|null $reference
 * @property string|null $note
 * @property string|null $etat
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\MoyenReglement $moyen_reglement
 * @property \App\Model\Entity\DevisFactures[] $devis_factures
 * @property \App\Model\Entity\ReglementsHasDevisFacture[] $reglements_has_devis_facture
 */
class Reglement extends Entity
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
        '*' => true,
    ];
    
    
    protected function _getReglementAsJson()
    {
        $json = [
            'type' => $this->type,
            'client_id' => $this->client_id,
            'date' => $this->date->format('d-m-Y'),
            'moyen_reglement_id' => $this->moyen_reglement_id,
            'sellsy_moyen_reglement' => $this->sellsy_moyen_reglement,
            'montant' => $this->montant,
            'reference' => $this->reference,
            'note' => $this->note,
            'etat' => $this->etat,
            'created' => $this->created,
            'modified' => $this->modified,
            'client' => $this->client,
            'moyen_reglement' => $this->moyen_reglement,
            'devis_factures' => [],
            'solde_disponible' => $this->solde_disponible,
            'avoirs' => []
            //'montant_lie' => $this->
        ];
        if($this->devis_factures) {
            foreach ($this->devis_factures as $devis_factures) {
                $json['devis_factures'][] = [ 
                    'id' => $devis_factures->id,
                    'indent' => $devis_factures->indent,
                    'total_ht' => $devis_factures->total_ht,
                    'total_ttc' => $devis_factures->total_ttc
                ];
            }
        }

        if($this->avoirs) {
            foreach ($this->avoirs as $avoir) {
                $json['avoirs'][] = [ 
                    'id' => $avoir->id,
                    'indent' => $avoir->indent,
                    'total_ht' => $avoir->total_ht,
                    'total_ttc' => $avoir->total_ttc
                ];
            }
        }

        if($this->reglements_has_devis_factures){
            foreach ($this->reglements_has_devis_factures as $reglements_has_devis_facture) {
                //$json['montan_lie_id_facture_'.$reglements_has_devis_facture->devis_factures_id] = $reglements_has_devis_facture->montant_lie;
                $json['montant_lie'][$reglements_has_devis_facture->devis_factures_id] = $reglements_has_devis_facture->montant_lie;
            }
        } elseif($this->reglements_has_avoirs) {
            foreach ($this->reglements_has_avoirs as $reglements_has_avoirs) {
                $json['montant_lie'][$reglements_has_avoirs->avoir_id] = $reglements_has_avoirs->montant_lie;
            }
        }


        $return = json_encode($json);
        return str_replace("'",  " ", $return);
    }

    public function _getClientName()
    {
        if ($this->is_in_sellsy) {

            if (isset($this->devis_factures) &&!empty($this->devis_factures)) {
                $firstFacture = current($this->devis_factures);
                $url = Router::url(['controller' => 'Clients', 'action' => 'fiche', $firstFacture->client_id]);
                return '<a href="'.$url.'">'.$firstFacture->client->nom.'</a>';
            } else {
                return $this->sellsy_client_name;
            }
        } 
        else {

            $client = $this->client ? $this->client->nom : "--";
            $url = Router::url(['controller' => 'Clients', 'action' => 'fiche', $this->client_id]);
            return '<a href="'.$url.'">'.$client.'</a>';
        }

        return $client ?? '';
    }

    public function _getCountLinkedDocs()
    {
        $docs = 0;
        if ($this->devis_factures) {
            $docs += count($this->devis_factures);   
        }

        if ($this->devis) {
            $docs += count($this->devis);   
        }

        return $docs;
    }

    public function _getTypeCourt(){
        return strtoupper(substr($this->type, 0, 1));
    }


    protected function _getReference($reference)
    {
        return strtoupper($reference);
    }

    protected function _setMontant($montant){
        if($this->isNew()){
            $this->set('solde_disponible', $montant);
        }
        return $montant;
    }
    
    
}
