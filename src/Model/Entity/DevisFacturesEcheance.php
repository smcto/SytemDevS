<?php 
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * DevisFacturesEcheance Entity
 *
 * @property int $id
 * @property float|null $montant
 * @property \Cake\I18n\FrozenDate|null $date
 * @property bool $is_payed
 * @property bool $is_accompte
 * @property int|null $devis_id
 * @property \Cake\I18n\FrozenDate|null $date_paiement
 *
 * @property \App\Model\Entity\Devi $devi
 */
class DevisFacturesEcheance extends Entity
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
        'id' => false
    ];

    public $defaultTva = false;

    public function _getEcheanceSansTva()
    {
        $tva = $this->getDefaultTvaDecimal();
        return round($this->montant / (1+$tva), 2);
    }


    public function getDefaultTvaDecimal()
    {
        if (!$this->defaultTva) {
            return $this->defaultTva = @TableRegistry::get('Tvas')->findByIsDefault(1)->first()->get('Decimal') ?? 0.2;
        }
    }

    public function _getPercentValue()
    {
        if (isset($this->devis_facture)) {
            return round($this->montant/$this->devis_facture->total_ttc*100, 2);
        }
    }

}
