<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\FrozenTime;

class Vente extends Entity
{
    protected $_accessible = [
        'id' => false,
        '*' => true
    ];

    protected $_virtual = ['facturation_accord_signature_path'];

    public function _setLivraison_date_first_usage($field)
    {
        return $field != null ? FrozenTime::parse($field) : null;
    }

    public function _getFacturationAccordSignaturePath()
    {
        return 'uploads/ventes/accord_signatures/'.$this->facturation_accord_signature_file;
    }

    public function _getBonDeLivraisonPath()
    {
        if($this->bon_de_livraison && is_file(WWW_ROOT.'/uploads/ventes/bons_de_livraison/'.$this->bon_de_livraison)) {
            return '/uploads/ventes/bons_de_livraison/'.$this->bon_de_livraison;
        }
        return '';
    }

    public function _setFacturationDateSignature($field)
    {
        return $field ? FrozenTime::parse($field) : null; 
    }

    public function _setLivraisonDate($field)
    {
        return $field ? FrozenTime::parse($field) : null; 
    }

    public function _setDateDepartAtelier($field)
    {
        return !is_null($field) ? FrozenTime::parse($field) : null; 
    }

    public function _setDateReceptionClient($field)
    {
        return !is_null($field) ? FrozenTime::parse($field) : null; 
    }

    public function _setDateFacturation($field)
    {
        return !is_null($field) ? FrozenTime::parse($field) : null; 
    }

    /**
     * Seb : en fait le lieu, c'est juste la ville + les 2 premiers chiffres du CP
     * @return [type] [description]
     */
    public function _getLieuLivraison()
    {
        $cp = @$this->client->cp ? ' ('.substr(@$this->client->cp, 0, 2).')' : '';
        return $this->is_livraison_adresse_diff_than_client_addr == 1 
            ? $this->livraison_client_ville. ' (' .substr($this->livraison_client_cp, 0, 2).')'
            : (isset($this->client) ? $this->client->ville. $cp : '')
        ;
    }
}
