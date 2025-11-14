<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BonsCommandes Model
 *
 * @property \App\Model\Table\DevisTable|\Cake\ORM\Association\BelongsTo $Devis
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\BonsCommande get($primaryKey, $options = [])
 * @method \App\Model\Entity\BonsCommande newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BonsCommande[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BonsCommande|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsCommande|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BonsCommande patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BonsCommande[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BonsCommande findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BonsCommandesTable extends Table
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

        $this->setTable('bons_commandes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Devis', [
            'foreignKey' => 'devi_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'LEFT'
        ]);
        
        $this->hasMany('BonsCommandesProduits', [
            'foreignKey' => 'bons_commande_id',
        ]);
        
        $this->hasMany('CloneBc', [
            'className' => 'BonsCommandes',
            'foreignKey' => 'bons_commande_id'
        ]);
        $this->hasMany('BonsLivraisons', [
            'foreignKey' => 'bons_commande_id'
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
            ->maxLength('indent', 30)
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
            ->scalar('commentaire')
            ->allowEmpty('commentaire');

        return $validator;
    }
    
    
    public function findToBonsLivraisons(Query $query, array $options) {
        
        $datas = $query->contain(['BonsCommandesProduits'=> function ($q) {
            return $q->order(['BonsCommandesProduits.i_position'=>'ASC']);
        }])->first()->toArray();
        
        $datas['bons_livraisons_produits'] = [];
        
        foreach ($datas['bons_commandes_produits'] as $key => $produits) {
            
            if ($produits['rest_a_livrer']) {
                unset($produits['id']);
                $datas['bons_livraisons_produits'][] = $produits;
            }
        }

        unset($datas['id']);
        unset($datas['bons_commandes_produits']);
        
        return $datas;
        
    }
    
    public function findToClone(Query $query, array $options) {
        
        $datas = $query->contain(['BonsCommandesProduits'])->first()->toArray();
        
        $datas['bons_commande_id'] = $datas['id'];
        $datas['produits'] = [];
        
        foreach ($datas['bons_commandes_produits'] as $key => $produits) {
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

        $datas['bons_commandes_produits'] = $datas['produits'];
        unset($datas['id']);
        unset($datas['produits']);
        
        return $datas;
        
    }
    
    public function findComplete(Query $query, array $options)
    {
        $query->contain(['Clients', 'Users', 'BonsCommandesProduits']);
        $query->where(['BonsCommandes.statut <>' => 'expedie'])->order(['indent' => 'DESC']);

        return $query;
    }
    
    
    public function findFiltre(Query $query, array $options)
    {
        $keyword = isset($options['keyword'])?trim($options['keyword']):null;
        $query->contain(['Clients' => 'ClientContact'])->group('BonsCommandes.id');
        if ($keyword) {
            $query->where([
                'OR' => [
                    ['BonsCommandes.indent LIKE' => '%'.$keyword.'%'],
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
            $query->where(['BonsCommandes.user_id' => $options['user_id']]);
        }
        
        if(isset($options['type_date']) && $options['type_date'] != null){
            $query->where(['BonsCommandes.type_date' => $options['type_date']]);
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        //$rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }
}
