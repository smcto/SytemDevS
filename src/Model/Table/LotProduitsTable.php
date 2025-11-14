<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Network\Session;

/**
 * LotProduits Model
 *
 * @property \App\Model\Table\TypeEquipementsTable|\Cake\ORM\Association\BelongsTo $TypeEquipements
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\BelongsTo $Equipements
 * @property \App\Model\Table\FournisseursTable|\Cake\ORM\Association\BelongsTo $Fournisseurs
 *
 * @method \App\Model\Entity\LotProduit get($primaryKey, $options = [])
 * @method \App\Model\Entity\LotProduit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LotProduit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LotProduit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LotProduit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LotProduit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LotProduit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LotProduit findOrCreate($search, callable $callback = null, $options = [])
 */
class LotProduitsTable extends Table
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

        $this->setTable('lot_produits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_equipement_id'
        ]);
        $this->belongsTo('MarqueEquipements', [
            'foreignKey' => 'marque_equipement_id'
        ]);
        $this->belongsTo('Equipements', [
            'foreignKey' => 'equipement_id'
        ]);
        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
        ]);
        $this->belongsTo('Fournisseurs', [
            'foreignKey' => 'fournisseur_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Fichiers', [
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('NumeroSeries', [
            'foreignKey' => 'lot_produit_id'
        ]);
        
        $this->hasMany('LotProduitsHasUnivers', [
            'foreignKey' => 'lot_produit_id'
        ]);
        
        $this->belongsToMany('TypeDocs', [
            'className' => 'DevisTypeDocs',
            'joinTable' => 'lot_produits_has_univers',
            'targetForeignKey' =>'type_doc_id',
            'foreignKey' => 'lot_produit_id'
        ]);
        
        $this->belongsTo('Stock', [
            'joinTable' => 'numero_series', 
            'joinType' => 'INNER',
            'bindingKey' => 'lot_produit_id',
            'foreignKey' => 'id',
            'className' => 'NumeroSeries',
            'conditions' => ['Stock.borne_id is null', 'Stock.is_event <>' => 1]
        ]);
        
        $this->belongsTo('StockHs', [
            'joinTable' => 'numero_series', 
            'joinType' => 'INNER',
            'bindingKey' => 'lot_produit_id',
            'foreignKey' => 'id',
            'className' => 'NumeroSeries',
            'conditions' => [
                'or' => [
                    ['StockHs.borne_id' => 0],
                    ['LotProduits.etat' => 'rebus'],
                ]
            ]
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
            ->scalar('etat')
            ->maxLength('etat', 255)
            ->requirePresence('etat', 'create')
            ->notEmpty('etat');

        // $validator
        //     ->date('date_facture')
        //     ->requirePresence('date_facture', 'create')
        //     ->notEmpty('date_facture');

        // $validator
        //     ->scalar('numero_facture')
        //     ->maxLength('numero_facture', 255)
        //     ->requirePresence('numero_facture', 'create')
        //     ->notEmpty('numero_facture');

        $validator
            ->integer('quantite')
            ->requirePresence('quantite', 'create')
            ->notEmpty('quantite');

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
        $rules->add($rules->existsIn(['fournisseur_id'], 'Fournisseurs'));

        return $rules;
    }

    /**
     * beforeSave callback
     *
     * @param $options array
     * @return boolean
     */
    public function beforeSave($event, $entity, $options) {
        
        if ($entity->isNew() == true && !$entity->user_id) {
            $user_id = (new Session)->read('Auth.User.id');
            if ($user_id) {
                $entity->set('user_id', $user_id);
            }
        }
        
        return true;
    }
    
    
    public function findFiltre(Query $query, array $options)
    {
        $search = $options['key'];
        if(!empty($search)){
            // $query->where(['Equipements.valeur LIKE' => '%'.$search.'%'])->orWhere(['LotProduits.serial_nb LIKE' => '%'.$search.'%']);
             $query->where([
                'OR' => [
                    'Equipements.valeur LIKE' => '%'.$search.'%',
                    'LotProduits.serial_nb LIKE' => '%'.$search.'%'
                ]
            ]);
        }

        $type_equipement = $options['type_equipement'];
        if(!empty($type_equipement)){
            $query->where(['Equipements.type_equipement_id'=>$type_equipement]);
        }

        $marque_equipement = $options['marque_equipement'];
        if(!empty($marque_equipement)){
            $query->where(['Equipements.marque_equipement_id'=>$marque_equipement]);
        }

        $etat = $options['etat'];
        if(!empty($etat)){
            $query->where(['etat'=>$etat]);
        }
        
        $is_destock = $options['is_destock'];
        if(!empty($is_destock)){
            $query->where(['etat IN'=> ['Hs', 'rebus']]);
        } else {
            // et du coup ressortir du stock les produits "rebus"
            $query->where(['etat NOT IN'=> ['rebus']]);
        }
        
        $is_event = isset($options['is_event'])?$options['is_event']:0;
        if($is_event) {
            $query->where(['LotProduits.is_event'=>$is_event]);
        } else {
            $query->where(['LotProduits.is_event <>'=>1]);
        }
        
        $antenne_id = isset($options['antenne_id'])?$options['antenne_id']:null;
        if($antenne_id) {
            $query->where(['LotProduits.antenne_id'=>$antenne_id]);
        }
        
        $type_doc_ids = isset($options['type_doc_ids']) ? $options['type_doc_ids'] : null;
        if($type_doc_ids) {
            $query->matching('TypeDocs');
            $query->where(['TypeDocs.id IN'=>$type_doc_ids]);
        }

        return $query;
    }
}
