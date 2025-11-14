<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BonsPreparations Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\BonsCommandesTable|\Cake\ORM\Association\BelongsTo $BonsCommandes
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\BonsPreparationsProduitsTable|\Cake\ORM\Association\HasMany $BonsPreparationsProduits
 *
 * @method \App\Model\Entity\BonsPreparation get($primaryKey, $options = [])
 * @method \App\Model\Entity\BonsPreparation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BonsPreparation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BonsPreparation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsPreparation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsPreparation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BonsPreparation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BonsPreparation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BonsPreparationsTable extends Table
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

        $this->setTable('bons_preparations');
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
        $this->hasMany('BonsPreparationsProduits', [
            'foreignKey' => 'bons_preparation_id'
        ]);
        $this->hasMany('CloneBp', [
            'className' => 'BonsPreparations',
            'foreignKey' => 'bons_preparation_id'
        ]);
        $this->hasMany('BonsLivraisons', [
            'foreignKey' => 'bons_preparation_id'
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
            ->scalar('indent')
            ->maxLength('indent', 255)
            ->requirePresence('indent', 'create')
            ->notEmpty('indent');

        $validator
            ->integer('type_date')
            ->requirePresence('type_date', 'create')
            ->notEmpty('type_date');

        $validator
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->scalar('statut')
            ->allowEmpty('statut');

        return $validator;
    }
    
    
    public function findToBonsLivraisons(Query $query, array $options) {
        
        $datas = $query->contain(['BonsPreparationsProduits'=> function ($q) {
            return $q->order(['BonsPreparationsProduits.i_position'=>'ASC']);
        }])->first()->toArray();
        
        $datas['bons_livraisons_produits'] = [];
        
        foreach ($datas['bons_preparations_produits'] as $key => $produits) {
            
            if ($produits['rest_a_livrer']) {
                unset($produits['id']);
                $datas['bons_livraisons_produits'][] = $produits;
            }
        }

        unset($datas['id']);
        unset($datas['bons_preparations_produits']);
        
        return $datas;
        
    }
    
    public function findToClone(Query $query, array $options) {
        
        $datas = $query->contain(['BonsPreparationsProduits'])->first()->toArray();
        
        $datas['bons_preparation_id'] = $datas['id'];
        $datas['produits'] = [];
        
        foreach ($datas['bons_preparations_produits'] as $key => $produits) {
            unset($produits['id']);
            $datas['produits'][] = [
                'catalog_produits_id' => $produits['catalog_produits_id'],
                'reference' => $produits['reference'],
                'nom' => $produits['nom'],
                'description_commercial' => $produits['description_commercial'],
                'quantite' => $produits['quantite'],
                'quantite_livree' => 0,
                'rest_a_livrer' => $produits['rest'],
                'rest' => $produits['rest'],
                'observation' => $produits['observation'],
                'statut' => $produits['statut'],
                'i_position' => $produits['i_position'],
            ];
        }

        $datas['bons_preparations_produits'] = $datas['produits'];
        unset($datas['id']);
        unset($datas['produits']);
        
        return $datas;
        
    }
    
    public function findComplete(Query $query, array $options)
    {
        $query->contain(['Clients', 'Users', 'BonsPreparationsProduits']);
        $query->where(['BonsPreparations.statut <>' => 'expedie'])->order(['indent' => 'DESC']);

        return $query;
    }

    
    
    public function findFiltre(Query $query, array $options)
    {
        $keyword = isset($options['keyword'])?trim($options['keyword']):null;
        $query->contain(['Clients' => 'ClientContact'])->group('BonsPreparations.id');
        if ($keyword) {
            $query->where([
                'OR' => [
                    ['BonsPreparations.indent LIKE' => '%'.$keyword.'%'],
                    ['Clients.nom LIKE' => '%'.$keyword.'%'],
                    ['Clients.telephone LIKE' => '%'.$keyword.'%'],
                    ['Clients.email LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.nom LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.prenom LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.tel LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.email LIKE' => '%'.$keyword.'%'],
                ]
            ]);
        }
        
        if(isset($options['user_id']) && $options['user_id'] != null){
            $query->where(['BonsPreparations.user_id' => $options['user_id']]);
        }
        
        if(isset($options['type_date']) && $options['type_date'] != null){
            $query->where(['BonsPreparations.type_date' => $options['type_date']]);
        }
      
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
        $rules->add($rules->existsIn(['devi_id'], 'Devis'));
        $rules->add($rules->existsIn(['bons_commande_id'], 'BonsCommandes'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
