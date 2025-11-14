<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StripeCsv Entity
 *
 * @property int $id
 * @property string $id_stripe
 * @property \Cake\I18n\FrozenTime $date_import
 * @property string $filename
 * @property string $filename_origin
 * @property int $description
 * @property string $seller_message
 * @property \Cake\I18n\FrozenTime $created
 * @property float $amount
 * @property float $amount_refunded
 * @property string $currency
 * @property float $converted_amount
 * @property float $converted_amount_refunded
 * @property int $fee
 * @property int $tax
 * @property string $converted_currency
 * @property string $status
 * @property string $statement_descriptor
 * @property int $customerId
 * @property string $customer_description
 * @property string $customer_email
 * @property string $captured
 * @property string $cardId
 * @property string $invoiceId
 * @property string $transfert
 * @property int $stripe_csv_file_id
 *
 * @property \App\Model\Entity\StripeExcel[] $stripe_excels
 */
class StripeCsv extends Entity
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
        'id_stripe' => true,
        'date_import' => true,
        'filename' => true,
        'filename_origin' => true,
        'description' => true,
        'seller_message' => true,
        'created' => true,
        'amount' => true,
        'amount_refunded' => true,
        'currency' => true,
        'converted_amount' => true,
        'converted_amount_refunded' => true,
        'fee' => true,
        'tax' => true,
        'converted_currency' => true,
        'status' => true,
        'statement_descriptor' => true,
        'customerId' => true,
        'customer_description' => true,
        'customer_email' => true,
        'captured' => true,
        'cardId' => true,
        'invoiceId' => true,
        'transfert' => true,
        'stripe_excels' => true
    ];
}
