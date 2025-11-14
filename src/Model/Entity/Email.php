<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Email Entity
 *
 * @property int $id
 * @property string $objet
 * @property string $contenu
 * @property bool $is_sent
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\EmailsHasUser[] $emails_has_users
 */
class Email extends Entity
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
        /*'objet' => true,
        'contenu' => true,
        'is_sent' => true,
        'created' => true,
        'modified' => true,
        'emails_has_users' => true*/
        'id' => false,
        '*' => true
    ];
}
