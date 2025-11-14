<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WpDevisSends Model
 *
 * @method \App\Model\Entity\WpDevisSend get($primaryKey, $options = [])
 * @method \App\Model\Entity\WpDevisSend newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WpDevisSend[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WpDevisSend|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WpDevisSend|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WpDevisSend patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WpDevisSend[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WpDevisSend findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WpDevisSendsTable extends Table
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

        $this->setTable('wp_devis_sends');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('id_post_wp')
            ->requirePresence('id_post_wp', 'create')
            ->notEmpty('id_post_wp');

        $validator
            ->boolean('is_send')
            ->requirePresence('is_send', 'create')
            ->notEmpty('is_send');

        return $validator;
    }
}
