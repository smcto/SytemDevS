<?php
namespace App\Model\Table;

use Cake\Utility\Inflector;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ObjectifsCommerciaux Model
 *
 * @property \App\Model\Table\DevisTypeDocsTable|\Cake\ORM\Association\BelongsTo $DevisTypeDocs
 * @property |\Cake\ORM\Association\BelongsTo $ObjectifAnnees
 *
 * @method \App\Model\Entity\ObjectifsCommerciaux get($primaryKey, $options = [])
 * @method \App\Model\Entity\ObjectifsCommerciaux newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ObjectifsCommerciaux[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ObjectifsCommerciaux|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ObjectifsCommerciaux|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ObjectifsCommerciaux patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ObjectifsCommerciaux[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ObjectifsCommerciaux findOrCreate($search, callable $callback = null, $options = [])
 */
class ObjectifsCommerciauxTable extends Table
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

        $this->setTable('objectifs_commerciaux');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('DevisTypeDocs', [
            'foreignKey' => 'devis_type_doc_id'
        ]);
        $this->belongsTo('ObjectifAnnees', [
            'foreignKey' => 'objectif_annee_id'
        ]);
    }

    protected function _initializeSchema($schema)
    {
        $schema->setColumnType('montants', 'json');
        return $schema;
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
            ->allowEmpty('montants');

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
// //         $rules->add($rules->existsIn(['devis_type_doc_id'], 'DevisTypeDocs'));
// //         $rules->add($rules->existsIn(['objectif_annee_id'], 'ObjectifAnnees'));
// 
        return $rules;
    }
}
