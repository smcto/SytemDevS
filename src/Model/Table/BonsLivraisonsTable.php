<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BonsLivraisons Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\BonsCommandesTable|\Cake\ORM\Association\BelongsTo $BonsCommandes
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\BonsLivraisonsProduitsTable|\Cake\ORM\Association\HasMany $BonsLivraisonsProduits
 *
 * @method \App\Model\Entity\BonsLivraison get($primaryKey, $options = [])
 * @method \App\Model\Entity\BonsLivraison newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BonsLivraison[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BonsLivraison|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsLivraison|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsLivraison patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BonsLivraison[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BonsLivraison findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BonsLivraisonsTable extends Table
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

        $this->setTable('bons_livraisons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Devis', [
            'foreignKey' => 'devi_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('BonsCommandes', [
            'foreignKey' => 'bons_commande_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('BonsLivraisonsProduits', [
            'foreignKey' => 'bons_livraison_id'
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
            ->date('date_depart_atelier')
            ->allowEmpty('date_depart_atelier');

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
        $rules->add($rules->existsIn(['devi_id'], 'Devis'));
        $rules->add($rules->existsIn(['bons_commande_id'], 'BonsCommandes'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
