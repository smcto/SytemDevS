<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DevisStripeHistoric Entity
 *
 * @property int $id
 * @property string|null $object
 * @property string|null $payment_id
 * @property string|null $transaction_id
 * @property string|null $description
 * @property int|null $amount
 * @property string|null $failure_message
 * @property string|null $payment_method
 * @property string|null $receipt_email
 * @property string|null $receipt_url
 * @property string|null $status
 * @property int|null $created
 * @property int|null $devis_id
 * @property int|null $devis_echeance_id
 *
 * @property \App\Model\Entity\Payment $payment
 * @property \App\Model\Entity\Transaction $transaction
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\DevisEcheance $devis_echeance
 */
class DevisStripeHistoric extends Entity
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
        'object' => true,
        'payment_id' => true,
        'transaction_id' => true,
        'description' => true,
        'amount' => true,
        'failure_message' => true,
        'payment_method' => true,
        'receipt_email' => true,
        'receipt_url' => true,
        'status' => true,
        'created' => true,
        'devis_id' => true,
        'devis_echeance_id' => true,
        'payment' => true,
        'transaction' => true,
        'devi' => true,
        'devis_echeance' => true
    ];
}
