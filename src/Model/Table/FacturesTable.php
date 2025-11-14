<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Factures Model
 *
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Facture get($primaryKey, $options = [])
 * @method \App\Model\Entity\Facture newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Facture[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Facture|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Facture|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Facture patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Facture[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Facture findOrCreate($search, callable $callback = null, $options = [])
 */
class FacturesTable extends Table
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

        $this->setTable('factures');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
        ]);

        $this->belongsTo('Installateurs', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('MessageTypeFactures', [
            'foreignKey' => 'message_type_facture_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Fournisseurs', [
            'foreignKey' => 'fournisseur_id',
        ]);

        $this->belongsTo('EtatFactures', [
            'foreignKey' => 'etat_facture_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Evenements', [
            'foreignKey' => 'evenement_id',
            //'joinType' => 'INNER'
        ]);

        $this->hasMany(
            'FacturesProduits', [
                'className' => 'FacturesProduits',
                'foreignKey' => 'facture_id',
                'dependent' => true, // pour les suppressions automatiques des associations
                'cascadeCallbacks' => true,
            ]
        );
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
            ->scalar('titre')
            ->maxLength('titre', 255)
            ->allowEmpty('titre');

        $validator
            ->numeric('montant')
            ->allowEmpty('montant');

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
        /*$rules->add($rules->existsIn(['antenne_id'], 'Antennes'));
        $rules->add($rules->existsIn(['installateur_id'], 'Installateurs'));*/

        return $rules;
    }

    public function findFournisseurs(Query $query, array $options)
    {
        $query
            ->where([
                'fournisseur_id IS NOT' => NULL
            ])
            ->contain(['Fournisseurs', 'FacturesProduits' => ['Equipements', 'TypeEquipements', 'Parcs']])
        ;
        return $query;
    }

    public function findFiltre(Query $query, array $options) {

        $typeprofil_ids = $options['typeprofil_ids'];
        $user_id = $options['user_id'];

        if(!empty($typeprofil_ids)){
            //=== profils antenne : 4
           if(in_array(4, $typeprofil_ids)) {
                $query->matching('Users.Profils', function ($query) {
                    return $query->where(['Profils.id IN' => 4]);
                });
               /*$antenne_id = $options['antenne_id'];
               if(!empty($antenne_id)){
                   $query->contain('Users', function ($q) use ($antenne_id){
                       return $q->where(['Users.antenne_id'=>$antenne_id]);
                   });
               }*/
               $antennes_rattachees = $options['antennes_rattachees']; //=== antenne(s) user connecté
               if(!empty($antennes_rattachees)){
                   $query->matching('Users.AntennesRattachees', function ($q) use ($antennes_rattachees){
                       return $q->where(['AntennesRattachees.id IN'=>$antennes_rattachees]);
                   });
               }
           } else
           //=== profils installateur : 5
           if(in_array(5, $typeprofil_ids)) {
                $query->matching('Users.Profils', function ($query) {
                    return $query->where(['Profils.id IN' => 5]);
                });
            }
        }
        //==== Filtre
        $search = $options['key'];
        if(!empty($search)){
            $query->where(['Factures.titre LIKE' => '%'.$search.'%']);
        }

        $antenne = $options['antenne'];
        if(!empty($antenne)){
            /*$query->contain('Users', function ($q) use ($antenne){
                return $q->where(['Users.antenne_id'=>$antenne]);
            });*/
            $query->matching('Users.AntennesRattachees', function ($q) use ($antenne){
                return $q->where(['AntennesRattachees.id IN'=>$antenne]);
            });
        }

        $etat = $options['etat'];
        if(!empty($etat)){
            $query->contain(['EtatFactures'=> function ($q) use($etat) { return $q->where(['EtatFactures.id'=> $etat]);}]);
        }

        $date_debut = $options['date_debut'];
        $date_fin = $options['date_fin'];
        if(!empty($date_debut) && !empty($date_fin)){
            $query->where(function ($q) use($date_fin, $date_debut) {
                return $q->between('Factures.created', $date_debut, $date_fin);
            });
        }
        //debug($query->count());die;
        return $query;
    }
}
