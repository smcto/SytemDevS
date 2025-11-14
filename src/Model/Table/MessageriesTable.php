<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Messageries Model
 *
 * @method \App\Model\Entity\Messagery get($primaryKey, $options = [])
 * @method \App\Model\Entity\Messagery newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Messagery[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Messagery|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Messagery|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Messagery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Messagery[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Messagery findOrCreate($search, callable $callback = null, $options = [])
 */
class MessageriesTable extends Table
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

        $this->setTable('messageries');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('MessageriesHasUsers', [
            'foreignKey' => 'messagerie_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Users', [
            'className' => 'Users',
            'through' => 'MessageriesHasUsers',
            'joinTable' => 'messageries_has_users',
            'targetForeignKey' =>'user_id',
            'foreignKey' => 'messagerie_id'
        ]);

        $this->hasMany('MessageriesHasCliens', [
            'foreignKey' => 'messagerie_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Clients', [
            'className' => 'Clients',
            'through' => 'MessageriesHasClients',
            'joinTable' => 'messageries_has_clients',
            'targetForeignKey' =>'client_id',
            'foreignKey' => 'messagerie_id'
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
            ->scalar('destinateur')
            ->maxLength('destinateur', 255)
            ->allowEmpty('destinateur');

        $validator
            ->add('destinateur', 'validFormat', [
                'rule' => function ($value, $context) {
                    $phonecode = $context['data']['phonecode'];
                    $phonecodes = $context['data']['phonecodes'];
                    //debug($phonecode);die;
                    $res = false;
                    if (in_array($phonecode, $phonecodes) && preg_match("#^\\".$phonecode."[1-9][0-9]{8}$#", $value)){
                        $res = true ;
                    }
                    //debug($res);die;
                    return $res;
                },
                'message' => 'Numero téléphone destinateur invalide'
            ]);

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmpty('message');

        $validator
            ->boolean('is_test')
            ->allowEmpty('is_test');

        return $validator;
    }
}
