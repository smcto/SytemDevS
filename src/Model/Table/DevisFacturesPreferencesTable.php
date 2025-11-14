<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevisFacturesPreferences Model
 *
 * @property \App\Model\Table\InfoBancairesTable|\Cake\ORM\Association\BelongsTo $InfoBancaires
 * @property \App\Model\Table\AdressesTable|\Cake\ORM\Association\BelongsTo $Adresses
 *
 * @method \App\Model\Entity\DevisFacturesPreference get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevisFacturesPreference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevisFacturesPreference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesPreference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesPreference|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevisFacturesPreference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesPreference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevisFacturesPreference findOrCreate($search, callable $callback = null, $options = [])
 */
class DevisFacturesPreferencesTable extends Table
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

        $this->setTable('devis_factures_preferences');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('InfosBancaires', [
            'className' => 'InfosBancaires',
            'foreignKey' => 'info_bancaire_id'
        ]);

        $this->belongsTo('Adresses', [
            'className' => 'Adresses',
            'foreignKey' => 'adress_id'
        ]);
    }

    protected function _initializeSchema($schema)
    {
        $schema->setColumnType('moyen_reglements', 'json');
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
            ->scalar('moyen_reglements')
            ->allowEmpty('moyen_reglements');

        $validator
            ->scalar('delai_reglements')
            ->allowEmpty('delai_reglements');

        $validator
            ->decimal('accompte_value')
            ->allowEmpty('accompte_value');

        $validator
            ->scalar('accompte_unity')
            ->allowEmpty('accompte_unity');

        $validator
            ->boolean('is_text_loi_displayed')
            ->requirePresence('is_text_loi_displayed', 'create')
            ->notEmpty('is_text_loi_displayed');

        $validator
            ->scalar('text_loi')
            ->allowEmpty('text_loi');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

        return $validator;
    }

    public function findComplete(Query $query, array $options)
    {
        $query->contain(['InfosBancaires', 'Adresses']);
        return $query;
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
        $rules->add($rules->existsIn(['info_bancaire_id'], 'InfoBancaires'));
        $rules->add($rules->existsIn(['adress_id'], 'Adresses'));

        return $rules;
    }
}
