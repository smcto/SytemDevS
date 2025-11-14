<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Licences Model
 *
 * @property \App\Model\Table\TypeLicencesTable|\Cake\ORM\Association\BelongsTo $TypeLicences
 * @property |\Cake\ORM\Association\HasMany $LicenceBornes
 *
 * @method \App\Model\Entity\Licence get($primaryKey, $options = [])
 * @method \App\Model\Entity\Licence newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Licence[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Licence|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Licence|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Licence patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Licence[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Licence findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LicencesTable extends Table
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

        $this->setTable('licences');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TypeLicences', [
            'foreignKey' => 'type_licence_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('LicenceBornes', [
            'foreignKey' => 'licence_id'
        ]);
        
        $this->belongsToMany('', [
            'className' => 'Licences',
            'joinTable' => 'licence_bornes',
            'targetForeignKey' =>'borne_id',
            'foreignKey' => 'licence_id'
        ]);
        
        $this->belongsTo('BornesLicences', [
            'joinTable' => 'licence_bornes', 
            'joinType' => 'LEFT',
            'bindingKey' => 'licence_id',
            'foreignKey' => 'id',
            'className' => 'LicenceBornes',
        ]);
        
        $this->belongsToMany('Bornes', [
            'className' => 'Bornes',
            'joinTable' => 'licence_bornes',
            'targetForeignKey' =>'borne_id',
            'foreignKey' => 'licence_id'
        ]);
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
            ->date('date_achat')
            ->allowEmpty('date_achat');

        $validator
            ->date('date_renouvellement')
            ->allowEmpty('date_renouvellement');

        $validator
            ->scalar('numero_serie')
            ->maxLength('numero_serie', 50)
            ->requirePresence('numero_serie', 'create')
            ->notEmpty('numero_serie');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('version')
            ->maxLength('version', 50)
            ->allowEmpty('version');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        //$rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['type_licence_id'], 'TypeLicences'));

        return $rules;
    }

    public function findFiltre(Query $query, array $options) {

        $search = $options['key'];

        if(!empty($search)){
            $query->where(['numero_serie LIKE' => '%'.$search.'%']);
        }

        $type = $options['type'];
        if(!empty($type)){
            $query->where(['Licences.type_licence_id'=>$type]);
        }

        $email = $options['email'];
        if(!empty($email)){
            $query->where(['Licences.email'=>$email]);
        }

        $version = $options['version'];
        if(!empty($version)){
            $query->where(['Licences.version'=>$version]);
        }
        
        $version = $options['version'];
        if(!empty($version)){
            $query->where(['Licences.version'=>$version]);
        }

        $dispo = isset($options['dispo'])?$options['dispo']:null;
        if($dispo != null){
            $query->where(['Licences.dispo' => $dispo]);
        }
        $query->distinct();
        return $query;
    }
}
