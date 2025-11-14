<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;


/**
 * DevisEcheance Entity
 *
 * @property int $id
 * @property float|null $montant
 * @property \Cake\I18n\FrozenDate $date
 * @property bool $is_payed
 */
class DevisEcheance extends Entity
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

    public function _getPercentValue()
    {
        if (isset($this->devi)) {
            return round($this->montant/$this->devi->total_ttc*100, 2);
        }
    }

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
}
