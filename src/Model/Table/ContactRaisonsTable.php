<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactRaisons Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\HasMany $Opportunites
 *
 * @method \App\Model\Entity\ContactRaison get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContactRaison newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContactRaison[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContactRaison|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContactRaison|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContactRaison patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContactRaison[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContactRaison findOrCreate($search, callable $callback = null, $options = [])
 */
class ContactRaisonsTable extends Table
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

        $this->setTable('contact_raisons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Opportunites', [
            'foreignKey' => 'contact_raison_id'
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
            ->maxLength('nom', 250)
            ->allowEmpty('nom');

        return $validator;
    }
}
