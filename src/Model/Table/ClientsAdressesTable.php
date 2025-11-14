<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientsAdresses Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\PaysTable|\Cake\ORM\Association\BelongsTo $Pays
 *
 * @method \App\Model\Entity\ClientsAdress get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientsAdress newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientsAdress[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientsAdress|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientsAdress|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientsAdress patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientsAdress[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientsAdress findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientsAdressesTable extends Table
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

        $this->setTable('clients_adresses');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('Payss', [
            'foreignKey' => 'pays_id'
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->allowEmpty('nom');

        $validator
            ->scalar('cp')
            ->maxLength('cp', 255)
            ->allowEmpty('cp');

        $validator
            ->scalar('ville')
            ->maxLength('ville', 255)
            ->allowEmpty('ville');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->allowEmpty('adresse');

        $validator
            ->scalar('adresse_2')
            ->maxLength('adresse_2', 255)
            ->allowEmpty('adresse_2');

        $validator
            ->scalar('adresse_3')
            ->maxLength('adresse_3', 255)
            ->allowEmpty('adresse_3');

        $validator
            ->scalar('adresse_4')
            ->maxLength('adresse_4', 255)
            ->allowEmpty('adresse_4');

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

        return $rules;
    }
}
