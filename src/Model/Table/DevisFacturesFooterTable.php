<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisFacturesFooter Model
 *
 * @method \App\Model\Entity\DevisFacturesFooter get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisFacturesFooter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisFacturesFooter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesFooter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesFooter|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesFooter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesFooter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesFooter findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisFacturesFooterTable extends Table
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

        $this->setTable('devis_factures_footer');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('text')
            ->requirePresence('text', 'create')
            ->notEmpty('text');

        return $validator;
    }
}
