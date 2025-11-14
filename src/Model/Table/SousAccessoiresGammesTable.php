<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccessoiresGammes Model
 *
 * @property \App\Model\Table\AccessoiresTable|\Cake\ORM\Association\BelongsTo $Accessoires
 * @property \App\Model\Table\GammeBornesTable|\Cake\ORM\Association\BelongsTo $GammeBornes
 *
 * @method \App\Model\Entity\AccessoiresGamme get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccessoiresGamme newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccessoiresGamme[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessoiresGamme|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessoiresGamme|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessoiresGamme patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccessoiresGamme[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessoiresGamme findOrCreate($search, callable $callback = null, $options = [])
 */
class SousAccessoiresGammesTable extends Table
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

        $this->setTable('sous_accessoires_gammes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SousAccessoires', [
            'foreignKey' => 'sous_accessoire_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('GammeBornes', [
            'foreignKey' => 'gamme_borne_id',
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
        $rules->add($rules->existsIn(['sous_accessoire_id'], 'SousAccessoires'));
        $rules->add($rules->existsIn(['gamme_borne_id'], 'GammesBornes'));

        return $rules;
    }
}
