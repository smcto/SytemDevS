<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentMarketings Model
 *
 * @method \App\Model\Entity\DocumentMarketing get($primaryKey, $options = [])
 * @method \App\Model\Entity\DocumentMarketing newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DocumentMarketing[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentMarketing|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentMarketing|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DocumentMarketing patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentMarketing[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentMarketing findOrCreate($search, callable $callback = null, $options = [])
 */
class DocumentMarketingsTable extends Table
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

        $this->setTable('document_marketings');
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
            ->scalar('catalogue_spherik')
            //->maxLength('catalogue_spherik', 500)
            ->allowEmpty('catalogue_spherik');

        $validator
            ->scalar('catalogue_classik')
            //->maxLength('catalogue_classik', 500)
            ->allowEmpty('catalogue_classik');

        $validator
            ->scalar('cgl_classik_part')
            //->maxLength('cgl_classik_part', 500)
            ->allowEmpty('cgl_classik_part');

        $validator
            ->scalar('cgl_spherik_part')
            //->maxLength('cgl_spherik_part', 500)
            ->allowEmpty('cgl_spherik_part');

        $validator
            ->scalar('cgl_pro')
            //->maxLength('cgl_pro', 500)
            ->allowEmpty('cgl_pro');

        return $validator;
    }
}
