<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipementsDocuments Model
 *
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\BelongsTo $Equipements
 *
 * @method \App\Model\Entity\EquipementsDocument get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipementsDocument newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipementsDocument[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsDocument|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementsDocument|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementsDocument patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsDocument[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsDocument findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EquipementsDocumentsTable extends Table
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

        $this->setTable('equipements_documents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id',
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
            ->maxLength('nom_origine', 255)
            ->allowEmpty('nom_origine');

        $validator
            ->scalar('titre')
            ->maxLength('titre', 255)
            ->allowEmpty('titre');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

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
        $rules->add($rules->existsIn(['equipement_id'], 'Equipements'));

        return $rules;
    }
}
