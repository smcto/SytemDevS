<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SmsAutos Model
 *
 * @method \App\Model\Entity\SmsAuto get($primaryKey, $options = [])
 * @method \App\Model\Entity\SmsAuto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SmsAuto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SmsAuto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SmsAuto|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SmsAuto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SmsAuto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SmsAuto findOrCreate($search, callable $callback = null, $options = [])
 */
class SmsAutosTable extends Table
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

        $this->setTable('sms_autos');
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
            ->scalar('lien_pdf_classik')
            ->maxLength('lien_pdf_classik', 255)
            ->requirePresence('lien_pdf_classik', 'create')
            ->notEmpty('lien_pdf_classik');

        $validator
            ->scalar('lien_pdf_spherik')
            ->maxLength('lien_pdf_spherik', 255)
            ->requirePresence('lien_pdf_spherik', 'create')
            ->notEmpty('lien_pdf_spherik');

        $validator
            ->scalar('contenu')
            ->requirePresence('contenu', 'create')
            ->notEmpty('contenu');

        return $validator;
    }
}
