<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevisFacturesPreference Entity
 *
 * @property int $id
 * @property string|null $moyen_reglements
 * @property string|null $delai_reglements
 * @property int|null $info_bancaire_id
 * @property float|null $accompte_value
 * @property string|null $accompte_unity
 * @property bool $is_text_loi_displayed
 * @property string|null $text_loi
 * @property string|null $note
 * @property int|null $adress_id
 *
 * @property \App\Model\Entity\InfoBancaire $info_bancaire
 * @property \App\Model\Entity\Adress $adress
 */
class DevisFacturesPreference extends Entity
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
        'moyen_reglements' => true,
        'delai_reglements' => true,
        'info_bancaire_id' => true,
        'accompte_value' => true,
        'accompte_unity' => true,
        'is_text_loi_displayed' => true,
        'text_loi' => true,
        'note' => true,
        'adress_id' => true,
        'info_bancaire' => true,
        'adress' => true
    ];
}
