<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Fournisseurs Model
 *
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 * @property \App\Model\Table\TypeFournisseursTable|\Cake\ORM\Association\BelongsTo $TypeFournisseurs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Fournisseur get($primaryKey, $options = [])
 * @method \App\Model\Entity\Fournisseur newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Fournisseur[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fournisseur|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fournisseur|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fournisseur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Fournisseur[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fournisseur findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FournisseursTable extends Table
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

        $this->setTable('fournisseurs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
        ]);
        $this->belongsTo('TypeFournisseurs', [
            'foreignKey' => 'type_fournisseur_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'fournisseur_id'
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->requirePresence('adresse', 'create')
            ->allowEmpty('adresse');

        $validator
            ->integer('cp')
            ->requirePresence('cp', 'create')
            ->allowEmpty('cp');

        $validator
            ->scalar('ville')
            ->maxLength('ville', 255)
            ->requirePresence('ville', 'create')
            ->allowEmpty('ville');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('commentaire')
            ->allowEmpty('commentaire');

        $validator
            ->scalar('antenne_id')
            ->allowEmpty('antenne_id');

        $validator
            ->scalar('type_fournisseur_id')
            ->notEmpty('type_fournisseur_id');

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
        $rules->add($rules->existsIn(['type_fournisseur_id'], 'TypeFournisseurs'));

        return $rules;
    }

    public function findFiltre(Query $query, array $options)
    {
        $search = $options['key'];
        if(!empty($search)){
            $query->where(['fournisseurs.nom LIKE' => '%'.$search.'%']);
        }

        $type_fournisseur = $options['type_fournisseur'];
        if(!empty($type_fournisseur)){
            $query->where(['type_fournisseur_id'=>$type_fournisseur]);
        }

        return $query;
    }
}
