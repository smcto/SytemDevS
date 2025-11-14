<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Chronos\Chronos;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DateTime;

/**
 * Reglements Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\MoyenReglementsTable|\Cake\ORM\Association\BelongsTo $MoyenReglements
 *
 * @method \App\Model\Entity\Reglement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reglement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reglement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reglement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reglement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reglement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reglement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reglement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReglementsTable extends Table
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

        $this->setTable('reglements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('MoyenReglements', [
            'foreignKey' => 'moyen_reglement_id',
        ]);
        
        $this->belongsTo('InfosBancaires', [
            'foreignKey' => 'info_bancaire_id'
        ]);
        
        $this->belongsToMany('DevisFactures', [
            'className' => 'DevisFactures',
            'joinTable' => 'reglements_has_devis_factures',
            'targetForeignKey' =>'devis_factures_id',
            'foreignKey' => 'reglements_id',
        ]);

        $this->belongsToMany('Devis', [
            'className' => 'Devis',
            'joinTable' => 'reglements_has_devis',
            'targetForeignKey' =>'devis_id',
            'foreignKey' => 'reglements_id',
        ]);

        $this->belongsToMany('Avoirs', [
            'className' => 'Avoirs',
            'joinTable' => 'reglements_has_avoirs',
            'targetForeignKey' =>'avoir_id',
            'foreignKey' => 'reglements_id',
        ]);
        
        $this->hasMany(
            'ReglementsHasDevisFactures', [
                'foreignKey' => 'reglements_id',
            ]
        );
        $this->hasMany(
            'ReglementsHasDevis', [
                'foreignKey' => 'reglements_id',
            ]
        );
        $this->hasMany(
            'ReglementsHasAvoirs', [
                'foreignKey' => 'reglements_id',
            ]
        );
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT'
        ]);

    }

    public function findToDashboard(Query $query, array $options) {

        $query->group(['DATE_FORMAT(date, "%Y-%m")']);
        $query->contain(['Clients', 'ReglementsHasDevisFactures'])->select(['annee' => 'DATE_FORMAT(date, "%Y")', 'annee_mois' => 'DATE_FORMAT(date, "%Y-%m")'])->enableAutoFields(true);
        $query->where(['Reglements.id in (SELECT reglements_id FROM reglements_has_devis_factures)']);
        
        if ($options) {
            $query->where($options);
        }

        return $query;
    }
    
    public function findHasAvoirs(Query $query, array $options)
    {
        $query->contain(['Avoirs'])->matching('Avoirs');
        return $query;
    }

    public function findComplete(Query $query, array $options)
    {

        $query
            ->enableAutoFields(true)
            ->contain([
                'Clients',
                'MoyenReglements',
                'DevisFactures' => ['Antennes','Commercial','FactureReglements'],
                'Devis' => ['Antennes','Commercial'],
                'ReglementsHasDevisFactures',
                'Users',
                'Avoirs' => ['Commercial'],
                'ReglementsHasAvoirs',
                'InfosBancaires'
            ])
            ->enableAutoFields(true)
            ->select([
                'contact_nom' => "CONCAT(COALESCE(Clients.prenom, ''), ' ' ,COALESCE(Clients.nom, ''), ' ' ,COALESCE(Clients.enseigne, ''))",
            ])
            ->enableAutoFields(true)
        ;

        return $query;
    }
    
    
    public function findFiltre(Query $query, array $options)
    {
        $key = isset($options['key'])?$options['key']:null;
        if($key) {
            $query->where([
                'OR' => [
                    'Clients.nom LIKE' => '%'.$key.'%',
                    'Clients.telephone LIKE' => '%'.$key.'%',
                    'Reglements.reference LIKE' => '%'.$key.'%',
                ]
            ]);
        }
        
        $moyen_reglement_id = isset($options['moyen_reglement_id'])?$options['moyen_reglement_id']:null;
        if($moyen_reglement_id) {
            $query->where(['Reglements.moyen_reglement_id' => $moyen_reglement_id,]);
        }
        
        $user_id = isset($options['user_id'])?$options['user_id']:null;
        if($user_id) {
            $query->where(['Reglements.user_id' => $user_id]);
        }
        
        $info_bancaire_id = isset($options['info_bancaire_id'])?$options['info_bancaire_id']:null;
        if($info_bancaire_id) {
            $query->where(['Reglements.info_bancaire_id' => $info_bancaire_id]);
        }
        
        $hasFacture = isset($options['has_facture'])?$options['has_facture']:null;
        if ($hasFacture) {
            
            if ($hasFacture == 1) {
                $query->matching('DevisFactures');
            }else {
                $query->notMatching('DevisFactures');
            }
        }
        
        $type_doc_id = isset($options['type_doc_id'])?$options['type_doc_id']:null;
        if ($type_doc_id) {
            
            $query->matching('DevisFactures')->where(['DevisFactures.type_doc_id' => $type_doc_id]);
        }
        
        $genre = isset($options['genre'])?$options['genre']:null;
        if ($genre) {
            
            $query->where(['Clients.client_type' => $genre]);
        }

        $periode = isset($options['periode']) ? $options['periode'] : null;
        if ($periode) {
            if ($periode == 'current_month') {
                $query->where([
                    'Reglements.date >' => Chronos::now()->startOfMonth()
                ]);
            }

            if ($periode == 'last_month') {
                $query->where([
                    'Reglements.date >' => Chronos::now()->subMonth(1)->startOfMonth(),
                    'Reglements.date <' => Chronos::now()->subMonth(1)->endOfMonth(),
                ]);
            }

            if ($periode == 'current_year') {
                $query->where([
                    'Reglements.date >' => Chronos::now()->startOfYear(),
                ]);
            }

            if ($periode == 'last_year') {
                $query->where([
                    'Reglements.date >' => Chronos::now()->subYear(1)->startOfYear(),
                    'Reglements.date <' => Chronos::now()->subYear(1)->endOfYear(),
                ]);
            }   


            if ($periode == 'custom_threshold') {
                $thresholdExplodedPeriod = explode(' - ', $options['date_threshold']);
                $query->where([
                    'Reglements.date >=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[0])->format('Y-m-d'),
                    'Reglements.date <=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[1])->format('Y-m-d')
                ]);
            }
        }
        
        return $query;
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
            ->scalar('type')
            ->notEmpty('type');

        $validator
            ->date('date')
            ->notEmpty('date');

        $validator
            ->decimal('montant')
            ->notEmpty('montant');

        $validator
            ->scalar('reference')
            ->maxLength('reference', 255)
            ->allowEmpty('reference');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

        $validator
            ->scalar('etat')
            ->allowEmpty('etat');

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
        return $rules;
    }
}
