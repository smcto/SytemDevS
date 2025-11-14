<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Client Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $adresse
 * @property string $ville
 * @property int $cp
 * @property int $telephone
 * @property string $email
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $adresse_2
 * @property string $siren
 * @property string $siret
 * @property int $id_in_sellsy
 * @property string $mobile
 * @property string $country
 *
 * @property \App\Model\Entity\Borne[] $bornes
 * @property \App\Model\Entity\ClientContact[] $client_contacts
 * @property \App\Model\Entity\Document[] $documents
 * @property \App\Model\Entity\User[] $users
 */
class Client extends Entity
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
        '*' => true   
    ];

    protected $_virtual = ['name_to_pdf','full_name', 'count_devis', 'count_factures', 'count_avoirs', 'nom_enseigne', 'factures', /*'secteurs_activites_ids'*/];

    protected function _getNameToPdf()
    {
        if($this->client_type == 'corporation') {
            return $this->nom;
        }
        return $this->prenom . " " . $this->nom;
    }
    
    protected function _getFullName()
    {
        if($this->client_type == 'corporation') {
            return $this->enseigne ? $this->nom ." - ".$this->enseigne : $this->nom ;
            // return $this->prenom . " " . $this->nom. " - " . $this->enseigne;
        }
        return $this->prenom . " " . $this->nom;
    }

    protected function _getFullName2()
    {
        return trim($this->prenom . " " . $this->nom);
    }

    protected function _getFullAdress()
    {
        return trim($this->adresse.' '.$this->ville.' '.$this->cp);
    }

    protected function _getFullAdress2()
    {
        return trim($this->adresse.' '.$this->cp.' '.$this->ville.' '.(isset($this->pays) ? $this->pays->nicename : ''));
    }
    
    protected function _getHasAdress()
    {
        if(trim($this->ville) || trim($this->cp)) {
            return true;
        }
        return false;
    }

    protected function _getCountDevis()
    {
        if (isset($this->devis)) {
            return collection($this->devis)->match(['is_model' => 0])->count();
        }
    }

    protected function _getCountFactures()
    {
        if (isset($this->devis_factures)) {
            return collection($this->devis_factures)->match(['is_model' => 0])->count();
        }
    }


    protected function _getCountAvoirs()
    {
        if (isset($this->avoirs)) {
            return count($this->avoirs);
        }
    }

    protected function _getNomEnseigne()
    {
        return $this->enseigne ? $this->nom ." - ".$this->enseigne : $this->nom ;
    }
    
    protected function _getFactures() {
        
        if (isset($this->devis_factures)) {
            
            if (isset($this->devis_factures2)) {
                return array_merge($this->devis_factures, $this->devis_factures2);
            }
            return $this->devis_factures;
        }
        return [];
    }

    public function _getCommercialDuPremierDevis()
    {
        if (isset($this->devis) && !empty($this->devis)) {
            $firstDevis = current($this->devis);

            if (isset($firstDevis->commercial)) {
                $commercial = $firstDevis->commercial;
                return $commercial->get('FullName');
            }
        }
        return false;
    }

    
    public function _getListeSecteursActivites()
    {
        if (isset($this->secteurs_activites)) {
            return join('<br>', collection($this->secteurs_activites)->extract('name')->toArray());
        }
    }
    
    // public function _getSecteursActivitesIds()
    // {
    //     $return = [];
    //     if (isset($this->secteurs_activites)) {
    //         foreach ($this->secteurs_activites as $secteurs_activites) {
    //             $return[] = $secteurs_activites->id;
    //         }
    //     }
    //     return $return;
    // }
}
