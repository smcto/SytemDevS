<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentsModelBornes Model
 *
 * @property \App\Model\Table\ModelBornesTable|\Cake\ORM\Association\BelongsTo $ModelBornes
 *
 * @method \App\Model\Entity\DocumentsModelBorne get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentsModelBorne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentsModelBorne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentsModelBorne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentsModelBorne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentsModelBorne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentsModelBorne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentsModelBorne findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentsModelBornesTable extends Table
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

        $this->setTable('documents_model_bornes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ModelBornes', [
            'foreignKey' => 'model_borne_id'
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
            ->allowEmpty('nom_fichier');

        $validator
            ->scalar('titre')
            ->maxLength('titre', 255)
            ->allowEmpty('titre');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('chemin')
            ->maxLength('chemin', 255)
            ->allowEmpty('chemin');

        $validator
            ->scalar('nom_origine')
            ->maxLength('nom_origine', 255)
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
        $rules->add($rules->existsIn(['model_borne_id'], 'ModelBornes'));

        return $rules;
    }
}
