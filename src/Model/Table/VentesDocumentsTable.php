<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentesDocuments Model
 *
 * @property \App\Model\Table\VentesTable|\Cake\ORM\Association\BelongsTo $Ventes
 * @property \App\Model\Table\DocumentsTable|\Cake\ORM\Association\BelongsTo $Documents
 *
 * @method \App\Model\Entity\VentesDocument get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentesDocument newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentesDocument[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentesDocument|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesDocument|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentesDocument patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentesDocument[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentesDocument findOrCreate($search, callable $callback = null, $options = [])
 */
class VentesDocumentsTable extends Table
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

        $this->setTable('ventes_documents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Ventes', [
            'foreignKey' => 'vente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Documents', [
            'foreignKey' => 'document_id',
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
        $rules->add($rules->existsIn(['vente_id'], 'Ventes'));
        $rules->add($rules->existsIn(['document_id'], 'Documents'));

        return $rules;
    }
}
