<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VillesFrance Entity
 *
 * @property int $ville_id
 * @property string|null $ville_departement
 * @property string|null $ville_slug
 * @property string|null $ville_nom
 * @property string|null $ville_nom_simple
 * @property string|null $ville_nom_reel
 * @property string|null $ville_nom_soundex
 * @property string|null $ville_nom_metaphone
 * @property string|null $ville_code_postal
 * @property string|null $ville_commune
 * @property string $ville_code_commune
 * @property int|null $ville_arrondissement
 * @property string|null $ville_canton
 * @property int|null $ville_amdi
 * @property int|null $ville_population_2010
 * @property int|null $ville_population_1999
 * @property int|null $ville_population_2012
 * @property int|null $ville_densite_2010
 * @property float|null $ville_surface
 * @property float|null $ville_longitude_deg
 * @property float|null $ville_latitude_deg
 * @property string|null $ville_longitude_grd
 * @property string|null $ville_latitude_grd
 * @property string|null $ville_longitude_dms
 * @property string|null $ville_latitude_dms
 * @property int|null $ville_zmin
 * @property int|null $ville_zmax
 * @property int|null $ville_population_2010_order_france
 * @property int|null $ville_densite_2010_order_france
 * @property int|null $ville_surface_order_france
 * @property int|null $ville_population_2010_order_dpt
 * @property int|null $ville_densite_2010_order_dpt
 * @property int|null $ville_surface_order_dpt
 */
class VillesFrance extends Entity
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
        'id' => false,
        '*' => true
    ];
}
