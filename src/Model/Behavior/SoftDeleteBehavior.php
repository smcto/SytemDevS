<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Utility\Inflector;

/**
 * mbola tsy voa géré le softDelete am hasMany otrn am HBTM, zay n aton le classe
 * class msuppr auto ny enregistrement censé supprimé via patchEntity eo amina rel° hasMany
 * supposé oe id ny PK any lé table associé
 * fapisana azy de tsotra $this->addBehavior('SoftDelete', array $associatedTablesHasnmany)
 * exemple any am model tina ho greffena azy $this->addBehavior('SoftDelete', ['DevisEcheances'])
 * tsy mande vao tsy mitovy amle clé anle hasmany('DevisEcheances') na le $entity->{"devis_echeances"}
 */
class SoftDeleteBehavior extends Behavior
{
    protected $_defaultConfig = [];

    protected $tables;

    public function initialize(array $config = [])
    {
        parent::initialize($config);
        foreach ($config as $key => $table) {
            $this->tables[] = Inflector::underscore($table, '_');
            $this->associatedTables[] = $table;
        }
    }

    public function afterSave($event, $entity, $options) {
        foreach ($this->tables as $key => $table) {
            if (isset($entity->{$table})) {
                $originalRecords = collection($entity->getOriginal($table))->extract('id')->toArray();
                $definedRecords = collection($entity->{$table})->extract('id')->toArray();

                $diffs = $this->getArrayDiff($originalRecords , $definedRecords);
                $associatedTableName = $this->associatedTables[$key];

                if (!empty($diffs)) {
                    // mbola mety mila amboarina any arina satria tsy micheck ra misy validations eo amle table associated
                    $this->_table->{$associatedTableName}->deleteAll(['id IN' => $diffs]);
                }
            }
        }

    }

    public function getArrayDiff($arr1, $arr2) 
    { 
        return array_diff(array_merge($arr1, $arr2), array_intersect($arr1, $arr2)); 
    } 
    

}
