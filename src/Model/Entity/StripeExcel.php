<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StripeExcel Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date
 * @property string $piece
 * @property string $compte
 * @property string $libelle
 * @property string $description
 * @property float $debit
 * @property float $credit
 * @property int $stripe_csv_id
 * @property int $stripe_csv_file_id
 *
 * @property \App\Model\Entity\StripeCsv $stripe_csv
 */
class StripeExcel extends Entity
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
        'date' => true,
        'piece' => true,
        'compte' => true,
        'libelle' => true,
        'description' => true,
        'debit' => true,
        'credit' => true,
        'stripe_csv_id' => true,
        'stripe_csv' => true
    ];
}
