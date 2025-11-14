<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentsAntennes Model
 *
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 *
 * @method \App\Model\Entity\DocumentsAntenne get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentsAntenne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentsAntenne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentsAntenne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentsAntenne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentsAntenne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentsAntenne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentsAntenne findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentsAntennesTable extends Table
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

        $this->setTable('documents_antennes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
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
            ->scalar('nom_origine')
            ->maxLength('nom_origine', 255)
            ->allowEmpty('nom_origine');

        $validator
            ->scalar('chemin')
            ->maxLength('chemin', 255)
            ->allowEmpty('chemin');

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
        $rules->add($rules->existsIn(['antenne_id'], 'Antennes'));

        return $rules;
    }
}
