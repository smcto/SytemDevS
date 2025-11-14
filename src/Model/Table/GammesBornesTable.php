<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * GammesBornes Model
 *
 * @method \App\Model\Entity\GammesBorne get($primaryKey, $options = [])
 * @method \App\Model\Entity\GammesBorne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\GammesBorne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\GammesBorne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GammesBorne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\GammesBorne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\GammesBorne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\GammesBorne findOrCreate($search, callable $callback = null, $options = [])
 */
class GammesBornesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('gammes_bornes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');


        $this->belongsToMany('Accessoires', [
            'foreignKey' => 'gamme_borne_id',
            'targetForeignKey' => 'accessoire_id',
            'joinTable' => 'accessoires_gammes',
            'through' => 'AccessoiresGammes',
            'className' => 'Accessoires', 
        ]);

        
        $this->hasMany('ModelBornes', [
            'className' => 'ModelBornes',
            'foreignKey' => 'gamme_borne_id'
        ]);
        
        $this->hasMany('Ventes', [
            'className' => 'Ventes',
            'foreignKey' => 'gamme_borne_id'
        ]);
        
        $this->hasMany('AccessoiresGammes', [
            'foreignKey' => 'gamme_borne_id'
        ]);
        
        
        $this->belongsToMany('TypeEquipements', [
            'foreignKey' => 'gamme_borne_id',
            'targetForeignKey' => 'type_equipement_id',
            'joinTable' => 'type_equipements_gammes', // où type_equipements_gammes possède les champs type_equipement_id et gamme_borne_id
            'through' => 'TypeEquipementsGammes',
            'className' => 'TypeEquipements', 
        ]);
    }

    public function findCountByVentes(Query $query, array $options)
    {
        $query = $query
            ->select(['nb' => $query->func()->count('Ventes.id')])
            ->leftJoinWith('Ventes')
            ->group(['GammesBornes.id'])
            ->enableAutoFields(true)
        ;
        return $query;
    }

    public function findCountByVentesByDate(Query $query, array $options)
    {
        $query = $query
            ->select([
                'nb' => $query->func()->count('Ventes.id'), 
                'month' => "DATE_FORMAT(Ventes.created, '%M %Y')",
                'x' => "DATE_FORMAT(Ventes.created, '%m')"
            ])
            ->leftJoinWith('Ventes')
            ->group(['GammesBornes.id',"DATE_FORMAT(Ventes.created, '%M %Y')"])
            ->order(['Ventes.created' => 'ASC'])
            ->limit(12)
            ->enableAutoFields(true)
        ;
        return $query;
    }
    
    public function findFiltre(Query $query, array $options){
        
        if(isset($options['mensuel']) && !empty($options['mensuel'])){
            $query->where(["DATE_FORMAT(Ventes.created, '%m-%Y') LIKE" => $options['mensuel']]);
        }
        if(isset($options['annuel']) && !empty($options['annuel'])){
            $query->where(["DATE_FORMAT(Ventes.created, '%Y') LIKE" => $options['annuel']]);
        }
        if(isset($options['dateDebut']) && !empty($options['dateDebut']) && isset($options['dateFin']) && !empty($options['dateFin'])){
            $query->where(["Ventes.created >=" => $options['dateDebut'], "Ventes.created <=" => $options['dateFin']]);
        }
        
        return $query;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->notEmpty('name');

        return $validator;
    }
}
