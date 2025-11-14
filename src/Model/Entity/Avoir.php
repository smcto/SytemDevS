<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Avoir Entity
 *
 * @property int $id
 * @property string|null $indent
 * @property string|null $objet
 * @property int|null $adresse
 * @property int|null $cp
 * @property int|null $ville
 * @property int|null $pays
 * @property string|null $nom_societe
 * @property \Cake\I18n\FrozenDate|null $date_crea
 * @property \Cake\I18n\FrozenDate|null $date_sign_before
 * @property string|null $ref_commercial_id
 * @property string|null $note
 * @property int|null $client_id
 * @property \Cake\I18n\FrozenDate|null $date_validite
 * @property string|null $moyen_reglements
 * @property string|null $delai_reglements
 * @property string|null $echeance_date
 * @property string|null $echeance_value
 * @property string|null $text_loi
 * @property bool $is_text_loi_displayed
 * @property int|null $remise_hide_line
 * @property int|null $remise_line
 * @property float|null $remise_global_value
 * @property string|null $remise_global_unity
 * @property float|null $accompte_value
 * @property string|null $accompte_unity
 * @property string|null $col_visibility_params
 * @property int|null $info_bancaire_id
 * @property string $status
 * @property string|null $position_type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property float|null $total_ttc
 * @property float|null $total_ht
 * @property float|null $total_reduction
 * @property float|null $total_remise
 * @property float|null $total_tva
 * @property bool|null $is_model
 * @property string|null $model_name
 * @property int|null $modele_avoirs_category_id
 * @property int|null $modele_avoirs_sous_category_id
 * @property string|null $categorie_tarifaire
 * @property string|null $client_nom
 * @property string|null $client_email
 * @property string|null $client_ville
 * @property string|null $client_adresse
 * @property string|null $client_adresse_2
 * @property string|null $client_country
 * @property int|null $display_tva
 * @property string|null $uuid
 * @property string|null $sellsy_echeances
 * @property int|null $sellsy_client_id
 * @property bool $is_in_sellsy
 * @property string|null $sellsy_public_url
 * @property int $sellsy_doc_id
 * @property int|null $devis_facture_id
 * @property string|null $commentaire_client
 * @property string|null $commentaire_commercial
 * @property string|null $client_tel
 * @property int|null $sellsy_estimate_id
 * @property bool $display_virement
 * @property bool $display_cheque
 * @property int|null $client_contact_id
 *
 * @property \App\Model\Entity\RefCommercial $ref_commercial
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\InfoBancaire $info_bancaire
 * @property \App\Model\Entity\ModeleAvoirsCategory $modele_avoirs_category
 * @property \App\Model\Entity\ModeleAvoirsSousCategory $modele_avoirs_sous_category
 * @property \App\Model\Entity\SellsyClient $sellsy_client
 * @property \App\Model\Entity\SellsyDoc $sellsy_doc
 * @property \App\Model\Entity\DevisFacture $devis_facture
 * @property \App\Model\Entity\SellsyEstimate $sellsy_estimate
 * @property \App\Model\Entity\ClientContact $client_contact
 * @property \App\Model\Entity\AvoirsProduit[] $avoirs_produits
 */
class Avoir extends Entity
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
    
    
    protected function _getColVisibilityParamsAsArray()
    {
        return json_decode($this->col_visibility_params);
    }

    protected function _getMoyenReglementsAsArray()
    {
        $value = array_filter($this->moyen_reglements);
        return array_keys($value);
    }

    public function _getTotalHtWithCurrency()
    {
        return $this->total_ht ? $this->total_ht.' €' : '--';
    }

    public function _getTotalTtcWithCurrency()
    {
        return $this->total_ttc ? $this->total_ttc.' €' : '--';
    }

    public function _getListeAntennes()
    {
        if (isset($this->antennes)) {
            return join(', ', collection($this->antennes)->extract('ville_principale')->toArray());
        }
    }
    
    protected function _getAvoirAsJson()
    {
        $array = [
            'id' => $this->id,
            'indent' => $this->indent,
            'total_ht' => $this->total_ht,
            'total_ttc' => $this->total_ttc,
            'reste_du' => $this->get('ResteEcheanceImpayee')
        ];
        return json_encode($array);
    }

    public function _getSellsyDocUrl()
    {
        $path = 'uploads/avoirs/'.$this->indent.'.pdf';
        if (file_exists(WWW_ROOT.$path)) {
            return '/'.$path;
        }
        return '#';
    }
  
    
    public function _getResteEcheanceImpayee()
    {
        if (isset($this->avoirs_reglements)) {
            return $this->total_ttc - collection($this->avoirs_reglements)->sumOf('montant');
        }
    }

}
