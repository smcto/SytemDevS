<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Documents Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 *
 * @method \App\Model\Entity\Document get($primaryKey, $options = [])
 * @method \App\Model\Entity\Document newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Document[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Document|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Document|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Document patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Document[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Document findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DocumentsTable extends Table
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

        $this->setTable('documents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
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
            ->scalar('type_document')
            ->requirePresence('type_document', 'create')
            ->notEmpty('type_document');

        $validator
            ->scalar('statut')
            ->maxLength('statut', 45)
            ->allowEmpty('statut');

        $validator
            ->scalar('objet')
            ->maxLength('objet', 255)
            ->requirePresence('objet', 'create')
            ->notEmpty('objet');

        $validator
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->allowEmpty('nom');

        $validator
            ->scalar('montant_ht')
            ->maxLength('montant_ht', 255)
            ->allowEmpty('montant_ht');

        $validator
            ->scalar('montant_ttc')
            ->maxLength('montant_ttc', 255)
            ->allowEmpty('montant_ttc');

        $validator
            ->scalar('url_sellsy')
            ->maxLength('url_sellsy', 4294967295)
            ->requirePresence('url_sellsy', 'create')
            ->notEmpty('url_sellsy');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->integer('id_in_sellsy')
            ->requirePresence('id_in_sellsy', 'create')
            ->notEmpty('id_in_sellsy');

        $validator
            ->boolean('deleted_in_sellsy')
            ->requirePresence('deleted_in_sellsy', 'create')
            ->notEmpty('deleted_in_sellsy');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }
    
    public function findFiltre(Query $query, array $options) {
        
        $typeDocument = $options['typeDocument'];
      
        if(!empty($typeDocument)){
            $query->where(['type_document' => $typeDocument]);
        }
        
        $key = $options['key'];
        if(!empty($key)){
            $query->where(['objet LIKE' => '%'.$key.'%']);
        }

        
        return $query;
    }
}
