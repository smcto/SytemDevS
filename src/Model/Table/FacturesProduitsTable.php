<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacturesProduits Model
 *
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\BelongsTo $Equipements
 * @property \App\Model\Table\FacturesTable|\Cake\ORM\Association\BelongsTo $Factures
 *
 * @method \App\Model\Entity\FacturesProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\FacturesProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FacturesProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FacturesProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacturesProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacturesProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FacturesProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FacturesProduit findOrCreate($search, callable $callback = null, $options = [])
 */
class FacturesProduitsTable extends Table
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

        $this->setTable('factures_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id'
        ]);
        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id'
        ]);
        $this->belongsTo('Factures', [
            'foreignKey' => 'facture_id'
        ]);
        $this->belongsTo('Parcs', [
            'foreignKey' => 'parc_id'
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
        $rules->add($rules->existsIn(['type_equipement_id'], 'TypeEquipements'));
        $rules->add($rules->existsIn(['equipement_id'], 'Equipements'));
        $rules->add($rules->existsIn(['facture_id'], 'Factures'));

        return $rules;
    }

    public function findGroupByEquipements(Query $query, array $options)
    {
        return $query
            ->group(['equipement_id', 'parc_id'])
            ->contain(['TypeEquipements', 'Equipements', 'Parcs'])
            ->map(function ($item)
            {
                $item->qtyEquipement = $this->findByEquipementId($item->equipement_id)->sumOf('qty');
                return $item;
            })
        ;
    }

    public function findGroupByTypeEquipements(Query $query, array $options)
    {
        return $query
            ->group(['FacturesProduits.type_equipement_id', 'FacturesProduits.equipement_id'])
            ->contain(['TypeEquipements', 'Equipements'])
            ->map(function ($item)
            {
                $item->factures_produits = $this->find()
                    ->where(['FacturesProduits.type_equipement_id' => $item->type_equipement_id, 'FacturesProduits.equipement_id' => $item->equipement_id, 'FacturesProduits.parc_id IS NOT' => NULL])
                    ->contain(['Parcs', 'Equipements' => ['Bornes', 'MarqueEquipements']])
                    ->groupBy('parc.nom')
                    ->toArray()
                ;

                return $item;
            })
        ;
    }
}
