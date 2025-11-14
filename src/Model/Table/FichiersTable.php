<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Fichiers Model
 *
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 * @property \App\Model\Table\ActuBornesTable|\Cake\ORM\Association\BelongsTo $ActuBornes
 * @property \App\Model\Table\ModelBornesTable|\Cake\ORM\Association\BelongsTo $ModelBornes
 *
 * @method \App\Model\Entity\Fichier get($primaryKey, $options = [])
 * @method \App\Model\Entity\Fichier newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Fichier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fichier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fichier|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fichier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Fichier[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fichier findOrCreate($search, callable $callback = null, $options = [])
 */
class FichiersTable extends Table
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

        $this->setTable('fichiers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id'
        ]);

        $this->belongsTo('LotProduits', [
            'foreignKey' => 'post_id'
        ]);

        $this->belongsTo('ActuBornes', [
            'foreignKey' => 'actu_borne_id'
        ]);
        $this->belongsTo('ModelBornes', [
            'foreignKey' => 'model_borne_id'
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
            ->scalar('nom_fichier')
            ->maxLength('nom_fichier', 255)
            ->allowEmpty('nom_fichier');

        $validator
            ->scalar('chemin')
            ->maxLength('chemin', 255)
            ->allowEmpty('chemin');

        $validator
            ->scalar('nom_origine')
            ->maxLength('nom_origine', 255)
            ->allowEmpty('nom_origine');

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
        $rules->add($rules->existsIn(['antenne_id'], 'Antennes'));
        $rules->add($rules->existsIn(['post_id'], 'Posts'));
        $rules->add($rules->existsIn(['actu_borne_id'], 'ActuBornes'));
        $rules->add($rules->existsIn(['model_borne_id'], 'ModelBornes'));

        return $rules;
    }
}
