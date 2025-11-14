<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisTypeDocs Model
 *
 * @property |\Cake\ORM\Association\HasMany $Devis
 *
 * @method \App\Model\Entity\DevisTypeDoc get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisTypeDoc newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisTypeDoc[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisTypeDoc|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisTypeDoc|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisTypeDoc patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisTypeDoc[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisTypeDoc findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevisTypeDocsTable extends Table
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

        $this->setTable('devis_type_docs');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Devis', [
            'foreignKey' => 'type_doc_id'
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
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmpty('image');

        $validator
            ->scalar('header')
            ->allowEmpty('header');

        $validator
            ->scalar('footer')
            ->allowEmpty('footer');

        $validator
            ->scalar('prefix_num')
            ->maxLength('prefix_num', 255)
            ->requirePresence('prefix_num', 'create')
            ->notEmpty('prefix_num');

        return $validator;
    }
}
