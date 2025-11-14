<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisAntennes Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 *
 * @method \App\Model\Entity\DevisAntenne get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisAntenne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisAntenne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisAntenne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisAntenne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisAntenne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisAntenne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisAntenne findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisAntennesTable extends Table
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

        $this->setTable('devis_antennes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devis', [
            'foreignKey' => 'devis_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Antennes', [
            'foreignKey' => 'antennes_id',
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
        $rules->add($rules->existsIn(['devis_id'], 'Devis'));
        $rules->add($rules->existsIn(['antennes_id'], 'Antennes'));

        return $rules;
    }
}
