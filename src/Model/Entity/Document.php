<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property string $type_document
 * @property int $client_id
 * @property string $statut
 * @property string $objet
 * @property string $nom
 * @property string $montant_ht
 * @property string $montant_ttc
 * @property string $url_sellsy
 * @property \Cake\I18n\FrozenTime $date
 * @property int $id_in_sellsy
 * @property bool $deleted_in_sellsy
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Client $client
 */
class Document extends Entity
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
        'type_document' => true,
        'client_id' => true,
        'statut' => true,
        'objet' => true,
        'nom' => true,
        'montant_ht' => true,
        'montant_ttc' => true,
        'url_sellsy' => true,
        'date' => true,
        'id_in_sellsy' => true,
        'deleted_in_sellsy' => true,
        'created' => true,
        'modified' => true,
        'client' => true,
        'step' => true,
        'ident' => true,
        'is_by_webhooks' => true,
        'deleted_by_webhooks' => true,
        'is_posted_on_event'=> true 
    ];
    
    protected function _getObjet($objet)
    {
        return strip_tags($objet);
    }
    
}
