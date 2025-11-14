<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LinkedDoc Entity
 *
 * @property int $id
 * @property string|null $context
 * @property string|null $doc_doctype
 * @property int|null $doc_docid_in_sellsy
 * @property string|null $doc_label
 * @property string|null $step_label
 * @property int $opportunite_id
 * @property int|null $devi_id
 * @property int|null $facture_id
 * @property int|null $linkedid_in_sellsy
 * @property string|null $ident_in_sellsy
 *
 * @property \App\Model\Entity\Opportunite $opportunite
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\Facture $facture
 */
class LinkedDoc extends Entity
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
        'context' => true,
        'doc_doctype' => true,
        'doc_docid_in_sellsy' => true,
        'doc_label' => true,
        'step_label' => true,
        'opportunite_id' => true,
        'devi_id' => true,
        'facture_id' => true,
        'linkedid_in_sellsy' => true,
        'ident_in_sellsy' => true,
        'opportunite' => true,
        'devi' => true,
        'facture' => true
    ];
}
