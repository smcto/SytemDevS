<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EquipementVentes Model
 *
 * @property \App\Model\Table\VentesTable|\Cake\ORM\Association\BelongsTo $Ventes
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\BelongsTo $Equipements
 *
 * @method \App\Model\Entity\EquipementVente get($primaryKey, $options = [])
 * @method \App\Model\Entity\EquipementVente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EquipementVente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EquipementVente|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementVente|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EquipementVente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementVente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EquipementVente findOrCreate($search, callable $callback = null, $options = [])
 */
class EquipementVentesTable extends Table
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

        $this->setTable('equipement_ventes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Ventes', [
            'foreignKey' => 'vente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id'
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
            ->boolean('aucun')
            ->requirePresence('aucun', 'create')
            ->notEmpty('aucun');

        $validator
            ->boolean('materiel_occasion')
            ->requirePresence('materiel_occasion', 'create')
            ->notEmpty('materiel_occasion');

        $validator
            ->boolean('valeur_definir')
            ->requirePresence('valeur_definir', 'create')
            ->notEmpty('valeur_definir');

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
