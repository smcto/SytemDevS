<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Traits\AppTrait;
use Cake\Chronos\Chronos;
use Cake\ORM\TableRegistry;


/**
 * DevisFacture Entity
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
 * @property int|null $modele_devis_factures_category_id
 * @property int|null $modele_devis_factures_sous_category_id
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
 * @property \App\Model\Entity\ModeleDevisFacturesCategory $modele_devis_factures_category
 * @property \App\Model\Entity\ModeleDevisFacturesSousCategory $modele_devis_factures_sous_category
 * @property \App\Model\Entity\DevisFacturesProduit[] $devis_factures_produits
 * @property \App\Model\Entity\Antenne[] $antennes
 * @property \App\Model\Entity\DevisFacturesAntenne[] $devis_factures_antennes
 */
class DevisFacture extends Entity
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
    
    protected $_virtual = ['client_type', 'reste_echeance_impayee', 'nb_jour_retard_entite'];
    
    protected function _setUuid($value) {
        if($this->isNew()) {
            return uniqid();
        } else if(! trim($value)) {
            return uniqid();
        }
        return $value;
    }
    
    
    protected function _getDayForCreated() {
        
        $datetime1 = $this->date_crea ? : $this->created;
        $datetime2 = new \Cake\I18n\Date();
        $interval = $datetime1->diff($datetime2);
        return $interval->days;
    }
    
    
    protected function _getDayFromRetard() {
        
        $datetime1 = $this->date_prevu_echeance;
        if ($datetime1) {
            
            $datetime2 = new \Cake\I18n\Date();
            $interval = $datetime1->diff($datetime2);
            return $interval->days;
        }
        
        return 0;
    }
    
    

    // commenté temporairement    
    // protected function _getIndent() 
    // {
    //     return 'FK-' . sprintf("%05d", $this->id);
    // }

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
    
    protected function _getFactureAsJson()
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
        $path = 'uploads/factures_vente/'.$this->indent.'.pdf';
        if (file_exists(WWW_ROOT.$path)) {
            return '/'.$path;
        }
        return '#';
    }
    
    
    public function _getPublicPdfUrl()
    {
        return ['controller' => 'DevisFactures', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'pdfversion', 'id' => $this->id])), 'forceGenerate' => 1];
    }

    public function _getPublicPdfDownloadUrl()
    {
        return ['controller' => 'DevisFactures', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'pdfversion', 'id' => $this->id, 'download' => true]))];
    }

    public function _getEncryptedUrl()
    {
        return ['controller' => 'DevisFactures', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'view-public', 'id' => $this->id]))];
    }

    public function _getEncryptedUrlWithDownload()
    {
        return ['controller' => 'DevisFactures', 'action' => 'decodeUrl', $this->slEncryption(serialize(['action' => 'view-public', 'id' => $this->id, 'download' => true]))];
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
    
    public function _getObjetTronquer() {
        
        // Récupération de la position du dernier espace (afin déviter de tronquer un mot)
        $position_br = strpos($this->objet, "<br />");   
        
        $objet = $this->objet;
        
        if ($position_br) {
            
            $objet = substr($this->objet, 0, $position_br);
        }
        
        $objet = str_replace(['<p>', '</p>'], ['', ''], $objet);
        return $objet;
    }
    
    public function _getModelTypeSellsy() {
        /* 
         * - pour afficher la borne : il suffit de regarder le montant de la facture globale. 
            les classik sont généralement de 450 ou 449 €TTC.
            et spherik dans les 3XX.
         */
        if($this->total_ttc > 400) {
            return 'classik';
        } else {
            return 'spherik';
        }
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

    public function _getBorneTypeAsText()
    {
        if ($this->model_type == 'classik') {
            return 'Facture Selfizee Classik';
        } elseif($this->model_type == 'spherik') {
            return 'Facture Selfizee Spherik';
        }
        if($this->is_in_sellsy) {
            if ($this->_getModelTypeSellsy() == 'classik') {
                return 'Facture Selfizee Classik';
            } elseif($this->_getModelTypeSellsy() == 'spherik') {
                return 'Facture Selfizee Spherik';
            }
        }
        return 'Facture Selfizee';
    }

    public function _getNbEcheancePaid()
    {
        if (isset($this->devis_factures_echeances)) {
            return collection($this->devis_factures_echeances)->match(['is_payed' => 1])->count();
        }
        
    }
    
    public function _getResteEcheanceMontant()
    {
        return $this->total_ttc - $this->_getTotalEcheances();
    }

    public function _getResteEcheanceImpayeeSansTva()
    {
        $tva = $this->getDefaultTvaDecimal();
        return round($this->_getResteEcheanceImpayee() / (1+$tva), 2);
    }

    public function _getResteEcheanceImpayee()
    {
        if (isset($this->facture_reglements)) {

            $resultat = $this->total_ttc - collection($this->facture_reglements)->sumOf(function ($reglement) {
                return $reglement->moyen_reglement_id == 5 ? $reglement->montant : $reglement->_joinData->montant_lie;
            });
            
            return $resultat < 0 ? 0 : $resultat;
        }
    }

    public function _getResteMontantTotal()
    {
        $total = $this->total_ttc;
        $totalReglements = 0;
        $totalAvoirs = 0;

        if (isset($this->facture_reglements)) {
            $totalReglements = collection($this->facture_reglements)->sumOf("_joinData.montant_lie");
        }
        
        if (isset($this->avoirs)) {
            $totalAvoirs = collection($this->avoirs)->sumOf("total_ttc");
        }

        $reste = $total - $totalReglements - $totalAvoirs;
        return $reste < 0 ? 0 : $reste;
    }

    public function _getTotalEcheances()
    {
        if (isset($this->devis_factures_echeances)) {
            return collection($this->devis_factures_echeances)->sumOf('montant');
        }

        return 0.00;
    }

    public function _getIsPartiallyPaid()
    {
        return $this->status == 'partial-payment';
    }

    public function _getClientType()
    {
        return isset($this->client) ? $this->client->client_type : '';
    }

    public function getDefaultTvaDecimal()
    {
        if (!$this->defaultTva) {
            return $this->defaultTva = @TableRegistry::get('Tvas')->findByIsDefault(1)->first()->get('Decimal') ?? 0.2;
        }
    }

    public function _getDateEvenementAsHtml()
    {
        $debut = $this->date_evenement ? 'Week en du ' . $this->date_evenement : '';
        // $fin = $this->date_evenement_fin ? ' au '.$this->date_evenement_fin : '';
        return $debut/*.' '.$fin*/;
    }

    public function _getAccompteFormated()
    {
        $accompte = $this->accompte_value;
        if($this->accompte_unity == '%') {
            $accompte = $this->total_ttc * $this->accompte_value / 100;
        }

        return round($accompte, 2);
    }

    /**
     * methode par entité limité si  bcp de requete sql
     * @return [type] [description]
     */
    public function _getNbJourRetardEntite()
    {
        $now = Chronos::now();
        $diffJours = 0;

        return $diffJours = $now->diffInDays($this->date_crea);
        if ($this->delai_reglements != 'echeances' &&  $this->date_crea < $now) {
            $diffJours = $now->diffInDays($this->date_crea);
        } elseif ($this->delai_reglements == 'echeances' &&  $this->date_crea < $now) {
            if ($this->devis_factures_echeances) {
                $prochaineEcheance = collection($this->devis_factures_echeances ?? [])->firstMatch(['is_payed' => 0]);
                if ($prochaineEcheance) {
                    $diffJours = $now->diffInDays($prochaineEcheance->date);
                }
            } else {
                return 'aucune_liaison_echeances';
            }
            
        }
        
        return $diffJours;
    }

    // Source du problème :
    //  - parfois le total affiché est celui calculé avec les remises (autre champ de la bdd)
    // Solution apportée :
    //  - ajout de condition que si il n'y a pas eu de remise, on affiche le champ total sans remise
    /**
     * final version épurée avec remise au lieu de TotalHtWithCurrency
     * 
     * @return [type] [float]
     */
    public function _getMontantHT()
    {
        return $this->total_remise_client ? $this->total_remise_client .' €' : ($this->total_remise != 0 ? $this->total_remise .' €' : $this->_getTotalHtWithCurrency());
    }

}
