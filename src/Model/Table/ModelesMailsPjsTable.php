<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModelesMailsPjs Model
 *
 * @property \App\Model\Table\ModelsMailsTable|\Cake\ORM\Association\BelongsTo $ModelsMails
 *
 * @method \App\Model\Entity\ModelesMailsPj get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModelesMailsPj newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModelesMailsPj[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModelesMailsPj|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModelesMailsPj|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModelesMailsPj patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModelesMailsPj[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModelesMailsPj findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ModelesMailsPjsTable extends Table
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

        $this->setTable('modeles_mails_pjs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ModelesMails', [
            'foreignKey' => 'modeles_mails_id',
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
            ->scalar('nom_fichier')
            ->maxLength('nom_fichier', 255)
            ->requirePresence('nom_fichier', 'create')
            ->notEmpty('nom_fichier');

        $validator
            ->scalar('chemin')
            ->maxLength('chemin', 255)
            ->requirePresence('chemin', 'create')
            ->notEmpty('chemin');

        $validator
            ->scalar('nom_origine')
            ->maxLength('nom_origine', 250)
            ->allowEmpty('nom_origine');

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
        $rules->add($rules->existsIn(['modeles_mails_id'], 'ModelesMails'));

        return $rules;
    }
}
