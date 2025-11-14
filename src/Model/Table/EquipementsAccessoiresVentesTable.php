<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipementsAccessoiresVentes Model
 *
 * @property \App\Model\Table\VentesTable|\Cake\ORM\Association\BelongsTo $Ventes
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\BelongsTo $Equipements
 *
 * @method \App\Model\Entity\EquipementsAccessoiresVente get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipementsAccessoiresVente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipementsAccessoiresVente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsAccessoiresVente|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementsAccessoiresVente|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementsAccessoiresVente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsAccessoiresVente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementsAccessoiresVente findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipementsAccessoiresVentesTable extends Table
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

        $this->setTable('equipements_accessoires_ventes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Ventes', [
            'foreignKey' => 'vente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id',
            'joinType' => 'LEFT'
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
            ->integer('qty')
            ->allowEmpty('qty');

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
        $rules->add($rules->existsIn(['type_equipement_id'], 'TypeEquipements'));
        $rules->add($rules->existsIn(['equipement_id'], 'Equipements'));

        return $rules;
    }
}
