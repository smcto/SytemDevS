<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Traits\AppTrait;
use Cake\ORM\TableRegistry;

/**
 * Devi Entity
 *
 * @property int $id
 * @property string|null $indent
 * @property string $objet
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
 * @property array|null $moyen_reglements
 * @property string|null $delai_reglements
 * @property array|null $echeance_date
 * @property array|null $echeance_value
 * @property string|null $text_loi
 * @property bool $is_text_loi_displayed
 * @property int|null $remise_hide_line
 * @property int|null $remise_line
 * @property float|null $remise_global_value
 * @property string|null $remise_global_unity
 * @property float|null $accompte_value
 * @property string|null $accompte_unity
 * @property array|null $col_visibility_params
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
 * @property int|null $modele_devis_categories_id
 * @property int|null $modele_devis_sous_categories_id
 * @property string|null $categorie_tarifaire
 * @property string|null $client_nom
 * @property string|null $client_cp
 * @property string|null $client_ville
 * @property string|null $client_adresse
 * @property string|null $client_country
 * @property int|null $display_tva
 * @property string|null $uuid
 *
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\InfosBancaire $infos_bancaire
 * @property \App\Model\Entity\User $commercial
 * @property \App\Model\Entity\ModeleDevisCategory $modele_devis_category
 * @property \App\Model\Entity\ModeleDevisSousCategory $modele_devis_sous_category
 * @property \App\Model\Entity\DevisProduit[] $devis_produits
 * @property \App\Model\Entity\Antenne[] $antennes
 * @property \App\Model\Entity\DevisAntenne[] $devis_antennes
 */
class Devi extends Entity
{

    use AppTrait;

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
        '*' => true
    ];

    protected $_virtual = ['client_type'];
    
    protected function _setUuid($value) {
        if($this->isNew()) {
            return uniqid();
        } else if(! trim($value)) {
            return uniqid();
        }
        return $value;
    }

    protected function _getColVisibilityParamsAsArray()
    {
        return json_decode($this->col_visibility_params);
    }

    protected function _getThHidev()
    {
        $colVisibilityParams = $this->_getColVisibilityParamsAsArray();
        if($this->categorie_tarifaire == 'ttc') {
            $colVisibilityParams->qty = 1;
            $colVisibilityParams->remise = 1;
            $colVisibilityParams->prix_unit_ht = 1;
            $colVisibilityParams->tva = 1;
            $colVisibilityParams->montant_ht = 1;
        } else {
            $colVisibilityParams->montant_ttc = 1;
        }

        $thHidev = 0;
        if($colVisibilityParams){
            foreach ($colVisibilityParams as $col) {
                if($col) {
                    $thHidev++;
                }
            }
        }

        return $thHidev;
    }


    protected function _getMoyenReglementsAsArray()
    {
        $value = array_filter($this->moyen_reglements);
        return array_keys($value);
    }

    public function _getTotalHtWithCurrency()
    {
        return $this->total_ht ? $this->total_ht.' €' : '';
    }

    public function _getTotalTtcWithCurrency()
    {
        return $this->total_ttc ? $this->total_ttc.' €' : '';
    }

    public function _getListeAntennes()
    {
        if (isset($this->antennes)) {
            return join(', ', collection($this->antennes)->extract('ville_principale')->toArray());
        }
    }

    public function _getSellsyDocUrl()
    {
        $path = 'uploads/devis/'.$this->indent.'.pdf';
        if (file_exists(WWW_ROOT.$path)) {
            return '/'.$path;
        }
        return '#';
    }

    public function _getPublicPdfUrl()
    {
        return ['controller' => 'Devis', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'pdfversion', 'id' => $this->id])), 'forceGenerate' => 1];
    }

    public function _getPublicPdfDownloadUrl()
    {
        return ['controller' => 'Devis', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'pdfversion', 'id' => $this->id, 'download' => true]))];
    }

    public function _getEncryptedUrl()
    {
        return ['controller' => 'Devis', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'view-public', 'id' => $this->id]))];
    }

    public function _getEncryptedUrlWithDownload()
    {
        return ['controller' => 'Devis', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'view-public', 'id' => $this->id, 'download' => true]))];
    }

    public function _getEcheances()
    {
        $echeances = [];
        if (is_array($this->echeance_date) && is_array($this->echeance_value)) {
            
            foreach ($this->echeance_date as $key => $date) {
                $echeances[$key] = [
                    'date' => $date,
                    'montant' => $this->echeance_value[$key],
                ];
            }
        }

        return $echeances;
    }

    public function _getEcheancesRadio()
    {
        $echeances = [];
        if (is_array($this->echeance_date) && is_array($this->echeance_value)) {
            
            foreach ($this->echeance_date as $key => $date) {
                $echeances[$key] = [
                    'value' => $key,
                    'text' => ' '.$this->echeance_value[$key].' €, le '.$date,
                ];
            }
        }

        $echeances['-1']['value'] = -1;
        $echeances['-1']['text'] = ' '.$this->total_ttc.' €, Payer la totalité';

        return $echeances;
    }

    public function _getNbEcheancePaid()
    {
        if (isset($this->devis_echeances)) {
            return collection($this->devis_echeances)->match(['is_payed' => 1])->count();
        }
        
    }
    
    public function _getResteEcheanceMontant()
    {
        return $this->total_ttc - $this->_getTotalEcheances();
    }

    /*public function _getResteEcheanceImpayee()
    {
        if (isset($this->devis_echeances)) {
            return $this->total_ttc - collection($this->devis_echeances)->match(['is_payed' => 1])->sumOf('montant');;
        }
    }*/

    public function _getResteEcheanceImpayee()
    {
        if (isset($this->devis_reglements)) {
            return $this->total_ttc - collection($this->devis_reglements)->sumOf('montant');
        }
    }

    public function _getTotalEcheances()
    {
        if (isset($this->devis_echeances)) {
            return collection($this->devis_echeances)->sumOf('montant');
        }

        return 0.00;
    }

    public function _getLieuRetraitFormated()
    {
        if ($this->lieu_retrait == null) {
            if(isset($this->antennes)) {
                $extractedLieus = collection($this->antennes)->extract('ville_principale')->toArray();
                $lieu = join($extractedLieus, ',');
            }
            elseif ($this->model_type == 'spherik') {
                $lieu = '';
            } elseif ($this->model_type == 'classik') {
                $lieu = 'Antenne Selfizee';
            }
        } else {
            return $this->lieu_retrait;
        }

        return trim($lieu);
    }

    public function _getAccompteFormated()
    {
        $accompte = $this->accompte_value;
        if($this->accompte_unity == '%') {
            $accompte = $this->total_ttc * $this->accompte_value / 100;
        }

        return round($accompte, 2);
    }

    public function _getBorneTypeAsText()
    {
        if ($this->model_type == 'classik') {
            return 'Devis Selfizee Classik';
        } elseif($this->model_type == 'spherik') {
            return 'Devis Selfizee Spherik';
        } else{
            return 'Devis Selfizee';
        }
    }
    
    public function _getObjetAsTitle() {
        $return = strip_tags($this->objet);
        $return = str_replace("'", "&apos;", $return);
        return $return;
    }
    
    public function _getObjetToPdf() {
        $searchP = strpos($this->objet,"<p>");
        if($searchP !== 0){
            return '<p>' . $this->objet . '</p>';
        }
        return $this->objet;
    }

    /**
     * mety hisy zvt hafa eto,z ay no antony ity
     * @return [type] [description]
     */
    public function _getIsPartiallyPaid()
    {
        return $this->status == 'partially_paid';
    }

    public function _getClientType()
    {
        return isset($this->client) ? $this->client->client_type : '';
    }

    public function _getResteEcheanceImpayeeSansTva()
    {
        $tva = $this->getDefaultTvaDecimal();
        return round($this->_getResteEcheanceImpayee() / (1+$tva), 2);
    }

    public function getDefaultTvaDecimal()
    {
        if (!$this->defaultTva) {
            return $this->defaultTva = @TableRegistry::get('Tvas')->findByIsDefault(1)->first()->get('Decimal') ?? 0.2;
        }
    }
}
