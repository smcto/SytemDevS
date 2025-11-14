<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BonsLivraison Entity
 *
 * @property int $id
 * @property int $devi_id
 * @property int $bons_preparation_id
 * @property int $client_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenDate|null $date_depart_atelier
 * @property \Cake\I18n\FrozenDate $created
 * @property \Cake\I18n\FrozenDate $modified
 *
 * @property \App\Model\Entity\Devi $devi
 * @property \App\Model\Entity\BonsPreparation $bons_preparation
 * @property \App\Model\Entity\Client $client
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\BonsLivraisonsProduit[] $bons_livraisons_produits
 */
class BonsLivraison extends Entity
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
    
    
    public function _getPublicPdfUrl()
    {
        return ['controller' => 'BonsLivraisons', 'action' => 'pdfversion', $this->id];
    }
    
    
    public function _getDocUrl()
    {
        $path = 'uploads/devis/'.$this->indent.'.pdf';
        if (file_exists(WWW_ROOT.$path)) {
            return '/'.$path;
        }
        return '#';
    }
}
