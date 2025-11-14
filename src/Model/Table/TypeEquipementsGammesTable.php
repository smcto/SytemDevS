<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeEquipementsGammes Model
 *
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 * @property \App\Model\Table\GammeBornesTable|\Cake\ORM\Association\BelongsTo $GammeBornes
 *
 * @method \App\Model\Entity\TypeEquipementsGamme get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeEquipementsGamme newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsGamme[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsGamme|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipementsGamme|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipementsGamme patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsGamme[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipementsGamme findOrCreate($search, callable $callback = null, $options = [])
 */
class TypeEquipementsGammesTable extends Table
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

        $this->setTable('type_equipements_gammes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id',
        ]);
        $this->belongsTo('GammesBornes', [
            'foreignKey' => 'gamme_borne_id',
            'className' => 'GammesBornes'
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
        $rules->add($rules->existsIn(['type_equipement_id'], 'TypeEquipements'));
        $rules->add($rules->existsIn(['gamme_borne_id'], 'GammesBornes'));

        return $rules;
    }
}
