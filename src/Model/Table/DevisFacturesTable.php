<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Chronos\Chronos;
use DateTime;

/**
 * DevisFactures Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $RefCommercials
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property |\Cake\ORM\Association\BelongsTo $InfoBancaires
 * @property \App\Model\Table\ModeleDevisFacturesCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleDevisFacturesCategories
 * @property \App\Model\Table\ModeleDevisFacturesSousCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleDevisFacturesSousCategories
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsToMany $Antennes
 *
 * @method \App\Model\Entity\Invoice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invoice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invoice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invoice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invoice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invoice findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevisFacturesTable extends Table
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

        $this->setTable('devis_factures');
        $this->setDisplayField('nom_societe');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        
        $this->belongsTo('Client2', [
            'className' => 'Clients',
            'foreignKey' => 'client_id_2'
        ]);

        $this->belongsTo('InfosBancaires', [
            'foreignKey' => 'info_bancaire_id'
        ]);

        $this->belongsTo('Langues', [
            'foreignKey' => 'langue_id'
        ]);
        
        $this->belongsTo('Commercial', [
            'className' => 'Users',
            'foreignKey' => 'ref_commercial_id'
        ]);

        $this->belongsTo('ModeleDevisFacturesCategories', [
            'foreignKey' => 'modele_devis_factures_category_id'
        ]);

        $this->belongsTo('ModeleDevisFacturesSousCategories', [
            'foreignKey' => 'modele_devis_factures_sous_category_id'
        ]);

        $this->belongsTo('FactureClientContacts', [
            'className' => 'ClientContacts',
            'foreignKey' => 'client_contact_id'
        ]);
        
        $this->belongsTo('DevisTypeDocs', [
            'foreignKey' => 'type_doc_id',
            // 'joinType' => 'INNER'
        ]);
        
        $this->hasMany('Avoirs', [       
                'foreignKey' => 'devis_facture_id',
                'dependent' => true,
            ]
        );
        
        $this->hasMany('CommentairesFactures', [       
                'foreignKey' => 'facture_id',
                'dependent' => true,
            ]
        );
                
        $this->hasMany(
            'DevisFacturesProduits', [
                'className' => 'DevisFacturesProduits',
                'foreignKey' => 'devis_facture_id',
            ]
        );

        $this->hasMany(
            'DevisFacturesEcheances', [       
                'foreignKey' => 'devis_facture_id',
                'saveStrategy' => 'replace'
            ]
        );
        
        $this->hasMany(
            'ReglementsHasFevisFactures', [
                'className' => 'ReglementsHasFevisFactures',
                'foreignKey' => 'devis_facture_id',
            ]
        );

        $this->hasMany(
            'ShortLinks', [
                'className' => 'ShortLinks',
                'foreignKey' => 'devis_facture_id',
            ]
        );

        $this->belongsToMany('Antennes', [
            'className' => 'Antennes',
            'joinTable' => 'devis_factures_antennes',
            'targetForeignKey' =>'antenne_id',
            'foreignKey' => 'devis_facture_id'
        ]);

        $this->hasMany(
            'DevisFacturesAntennes', [       
                'foreignKey' => 'devis_facture_id'
            ]
        );

        $this->hasMany(
            'Reglements', [       
                'foreignKey' => 'devis_facture_id'
            ]
        );
        
        
        $this->belongsToMany('FactureReglements', [
            'className' => 'Reglements',
            'joinTable' => 'reglements_has_devis_factures',
            'targetForeignKey' =>'reglements_id',
            'foreignKey' => 'devis_factures_id'
        ]);
        
        $this->belongsTo('RefCommercials', [
            'foreignKey' => 'ref_commercial_id'
        ]);
        
        $this->belongsTo('Devis', [
            'foreignKey' => 'devis_id'
        ]);

        $this->hasMany('StatutHistoriques', [
            'foreignKey' => 'devis_facture_id',
            'sort' => ['StatutHistoriques.id' => 'DESC','StatutHistoriques.time' => 'DESC']
        ]);
    }
    
    
    protected function _initializeSchema($schema)
    {
        $schema->setColumnType('col_visibility_params', 'json');
        $schema->setColumnType('moyen_reglements', 'json');
        $schema->setColumnType('echeance_date', 'json');
        $schema->setColumnType('echeance_value', 'json');
        return $schema;
    }

    public function beforeSave($event, $factureEntity, $options) {
        if(! $factureEntity->indent) {
            $indent = 'FK-';
            $lastfacture = $this->find()->orderAsc('indent')->last();
            $lastIndent = str_replace('FK-', '', $lastfacture->indent);
            $lastIndent++;
            $indent .= sprintf("%05d", $lastIndent);
            $factureEntity->indent = $indent;
        }
        
        if($factureEntity->client_id) {
            $client = $this->Clients->findById($factureEntity->client_id)->first();
            if($client) {
                $client = $this->Clients->patchEntity($client, ['type_commercial' => 'client'], ['validate' => false]);
                $this->Clients->save($client);
            }
        }
        
        if($factureEntity->client_id_2) {
            $client = $this->Clients->findById($factureEntity->client_id_2)->first();
            if($client) {
                $client = $this->Clients->patchEntity($client, ['type_commercial' => 'client'], ['validate' => false]);
                $this->Clients->save($client);
            }
        }
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
            ->maxLength('indent', 100)
            ->allowEmpty('indent');

        $validator
            ->scalar('objet')
            ->requirePresence('objet', 'create')
            ->notEmpty('objet');

        $validator
            ->integer('adresse')
            ->allowEmpty('adresse');

        $validator
            ->integer('cp')
            ->allowEmpty('cp');

        $validator
            ->integer('ville')
            ->allowEmpty('ville');

        $validator
            ->integer('pays')
            ->allowEmpty('pays');

        $validator
            ->scalar('nom_societe')
            ->maxLength('nom_societe', 255)
            ->allowEmpty('nom_societe');

        $validator
            ->date('date_crea')
            ->allowEmpty('date_crea');

        $validator
            ->date('date_sign_before')
            ->allowEmpty('date_sign_before');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

        $validator
            ->date('date_validite')
            ->allowEmpty('date_validite');

        $validator
            ->allowEmpty('moyen_reglements');

        $validator
            ->scalar('delai_reglements')
            ->allowEmpty('delai_reglements');

        $validator
            ->allowEmpty('echeance_date');

        $validator
            ->allowEmpty('echeance_value');

        $validator
            ->scalar('text_loi')
            ->allowEmpty('text_loi');

        $validator
            ->boolean('is_text_loi_displayed')
            ->requirePresence('is_text_loi_displayed', 'create')
            ->notEmpty('is_text_loi_displayed');

        $validator
            ->allowEmpty('remise_hide_line');

        $validator
            ->allowEmpty('remise_line');

        $validator
            ->decimal('remise_global_value')
            ->allowEmpty('remise_global_value');

        $validator
            ->scalar('remise_global_unity')
            ->allowEmpty('remise_global_unity');

        $validator
            ->decimal('accompte_value')
            ->allowEmpty('accompte_value');

        $validator
            ->scalar('accompte_unity')
            ->allowEmpty('accompte_unity');

        $validator
            ->allowEmpty('col_visibility_params');

        $validator
            ->scalar('status')
            ->allowEmpty('status');

        $validator
            ->scalar('position_type')
            ->allowEmpty('position_type');

        $validator
            ->decimal('total_ttc')
            ->allowEmpty('total_ttc');

        $validator
            ->decimal('total_ht')
            ->allowEmpty('total_ht');

        $validator
            ->decimal('total_reduction')
            ->allowEmpty('total_reduction');

        $validator
            ->decimal('total_remise')
            ->allowEmpty('total_remise');

        $validator
            ->decimal('total_tva')
            ->allowEmpty('total_tva');

        $validator
            ->boolean('is_model')
            ->allowEmpty('is_model');

        $validator
            ->scalar('model_name')
            ->maxLength('model_name', 255)
            ->allowEmpty('model_name');

        $validator
            ->scalar('categorie_tarifaire')
            ->allowEmpty('categorie_tarifaire');

        $validator
            ->scalar('client_nom')
            ->maxLength('client_nom', 255)
            ->allowEmpty('client_nom');

        $validator
            ->scalar('client_cp')
            ->maxLength('client_cp', 255)
            ->allowEmpty('client_cp');

        $validator
            ->scalar('client_ville')
            ->maxLength('client_ville', 255)
            ->allowEmpty('client_ville');

        $validator
            ->scalar('client_adresse')
            ->maxLength('client_adresse', 255)
            ->allowEmpty('client_adresse');

        $validator
            ->scalar('client_country')
            ->maxLength('client_country', 255)
            ->allowEmpty('client_country');

        $validator
            ->allowEmpty('display_tva');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 50)
            ->allowEmpty('uuid')
            ->add('uuid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    public function findComplete(Query $query, array $options)
    {
        $query
            ->where(['OR' => ['DevisFactures.is_model is null', 'DevisFactures.is_model' => 0]])
            ->contain([
            'DevisFacturesEcheances' => function ($q) {
                return $q->order(['DevisFacturesEcheances.id'=>'ASC']);
            },
            'Clients' => 'ClientContacts',
            'Client2',
            'FactureClientContacts',
            'InfosBancaires',
            'ShortLinks',
            'Antennes',
            'Commercial',
            'Avoirs',
            'Langues',
            'ModeleDevisFacturesCategories',
            'ModeleDevisFacturesSousCategories',
            'FactureReglements' => 'MoyenReglements',
            'DevisFacturesProduits'=> function ($q) {
                return $q->contain(['CatalogUnites'])->order(['DevisFacturesProduits.i_position'=>'ASC']);
            }
        ]);

        $is_situation = !empty($options['is_situation'])?$options['is_situation']:null;
        if($is_situation) {
            $query->where(['DevisFactures.is_situation' => 1]);
        } else {
            $query->where(['DevisFactures.is_situation <>' => 1]);
        }
        
        return $query;
    }

    public function findListModel(Query $query, array $options)
    {
        $query->contain([
            'ModeleDevisFacturesCategories',
            'ModeleDevisFacturesSousCategories'
        ]);
        $query->where(['is_model' => 1]);
        
        $cat = !empty($options['cat'])?$options['cat']:null;
        if($cat) {
            $query->where(['DevisFactures.modele_devis_factures_category_id' => $cat]);
        }
        
        $sousCat = !empty($options['sous-cat'])?$options['sous-cat']:null;
        if($sousCat) {
            $query->where(['DevisFactures.modele_devis_factures_sous_category_id' => $sousCat]);
        }
                
        return $query;
    }

    public function findAsModele(Query $query, array $options)
    {
        $query = $query->contain(['Clients', 'Antennes', 'DevisFacturesProduits'=> function ($q) {
            return $q->order(['DevisFacturesProduits.i_position'=>'ASC']);
        }])->first();
        
        
        $removedClient = isset($options['removed_client'])?$options['removed_client']:1;
        if($removedClient) {
            unset($query->client);
            unset($query->client_id);
            unset($query->client_id_2);
            unset($query->client_nom);
            unset($query->client_adresse);
            unset($query->client_cp);
            unset($query->client_ville);
            unset($query->client_country);
            unset($query->client_contact_id);
            unset($query->devis_client_contact);
        }
        
        $toFacture = isset($options['to_facture'])?$options['to_facture']:0;
        if(! $toFacture) {
            unset($query->ref_commercial_id);
        }
        
        unset($query->id);
        unset($query->devis_id);
        unset($query->indent);
        unset($query->is_model);
        unset($query->date_crea);
        unset($query->date_validite);
        unset($query->date_sign_before);
        unset($query->model_name);
        unset($query->uuid);
        unset($query->status);
        unset($query->modele_devis_factures_category_id);
        unset($query->modele_devis_factures_sous_category_id);
        if (!empty($query->devis_factures_produits)) {
            foreach ($query->devis_factures_produits as $key => $devis_factures_produits) {
                unset($devis_factures_produits->id);
            }
        }
        return $query;
    }

    
    public function findAsSituation(Query $query, array $options)
    {
        $query = $query->contain(['Devis', 'Commercial', 'Clients', 'DevisFacturesProduits'])->first();
        
        unset($query->id);
        if (!empty($query->devis_factures_produits)) {
            foreach ($query->devis_factures_produits as $key => $produits) {
                unset($query->devis_factures_produits[$key]->id);
                $query->devis_factures_produits[$key]->facture_pourcentage = $query->devis_factures_produits[$key]->avancement_pourcentage;
                $query->devis_factures_produits[$key]->avancement_pourcentage = 0;
                $query->devis_factures_produits[$key]->facture_euro = $query->devis_factures_produits[$key]->avancement_euro;
                $query->devis_factures_produits[$key]->avancement_euro = 0;
            }
        }
        
        return $query;
    }
    
    public function findFiltre(Query $query, array $options)
    {
        $keyword = isset($options['keyword']) ? trim($options['keyword']) : null;
        $query->contain(['Clients' => 'ClientContact'])->group('DevisFactures.id');

        if ($keyword) {
            $query->where([
                'OR' => [
                    ['DevisFactures.indent LIKE' => '%'.$keyword.'%'],
                    ['DevisFactures.total_ttc' => $keyword],
                    ['DevisFactures.total_ht' => $keyword],
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
        
        if(isset($options['type_doc_id']) && $options['type_doc_id'] != null){
            $query->where(['DevisFactures.type_doc_id' => $options['type_doc_id']]);
        }
        if(isset($options['is_in_sellsy'])){
            $query->where(['DevisFactures.is_in_sellsy' => $options['is_in_sellsy']]);
        }
        if (!empty($options['indent'])) {
            $query->where(['DevisFactures.indent LIKE' => '%' . $options['indent'] . '%']);
        }
        if (!empty($options['ref_commercial_id'])) {
            $query->where(['ref_commercial_id' => $options['ref_commercial_id']]);
        }

        if (!empty($options['client_id'])) {
            $query->where(['DevisFactures.client_id' => $options['client_id']]);
        }
        
        if (!empty($options['client_type'])) {
            $query->where(['Clients.client_type' => $options['client_type']]);
        }
        
        if (!empty($options['progression'])) {
            if ($options['progression'] == 'en_retard') {
                
                $query->where(['OR' => ['DevisFactures.progression' => $options['progression'], 'DevisFactures.progression is null']]);
            } else {
                
                $query->where(['DevisFactures.progression' => $options['progression']]);
            }
        }
        
        if (!empty($options['status'])) {
            $status = $options['status'];
            if ($status == 'en_attente') {
                $query->find('NonReglees');
            } else {
                $query->where(['DevisFactures.status' => $options['status']]);
            }
        }

        if (!empty($options['created'])) {
            $query->where(["DevisFactures.created LIKE" => '%'.$options['created'].'%']);
        }

        if (!empty($options['created'])) {
            $query->where(["DevisFactures.created LIKE" => '%'.$options['created'].'%']);
        }

        if (!empty($options['is_in_sellsy'])) {
            $query->where(["DevisFactures.is_in_sellsy" => $options['is_in_sellsy']]);
        }

        if (!empty($options['date_evenement'])) {
            $query->where(["DevisFactures.date_evenement" => $options['date_evenement']]);
        }

        if (!empty($options['antenne_id'])) {
            $query->contain(['DevisFacturesAntennes'])->matching('DevisFacturesAntennes')->where(['DevisFacturesAntennes.antenne_id' => $options['antenne_id']]);
        }

        if (!empty($options['client_keyword'])) {
            $query->matching('Clients.ClientContacts', function ($q) use($options)
            {
                return $q->where([
                    'OR' => [
                        ['Clients.nom LIKE' => '%'.$options['client_keyword'].'%'],
                        ['Clients.prenom LIKE' => '%'.$options['client_keyword'].'%'],
                        ['ClientContacts.nom LIKE' => '%'.$options['client_keyword'].'%'],
                        ['ClientContacts.prenom LIKE' => '%'.$options['client_keyword'].'%'],
                    ]
                ]);
            });
        }

        $periode = !empty($options['periode'])?$options['periode']:null;
        if ($periode) {
            if ($periode == 'current_month') {
                $query->where([
                    'DevisFactures.created >=' => Chronos::now()->startOfMonth()
                ]);
            }

            if ($periode == 'last_month') {
                $query->where([
                    'DevisFactures.created >=' => Chronos::now()->subMonth(1)->startOfMonth(),
                    'DevisFactures.created <=' => Chronos::now()->subMonth(1)->endOfMonth(),
                ]);
            }

            if ($periode == 'list_month') {
                $nMois = $options['mois_id']+1;
                $annee_mois = date('Y').'-'.sprintf('%02d', $nMois);
                $query
                    ->select(['annee_mois' => 'DATE_FORMAT(DevisFactures.created, "%Y-%m")'])->enableAutoFields(true)
                    ->having([
                        'annee_mois LIKE' => $annee_mois,
                    ])
                ;
            }

            if ($periode == 'current_year') {
                $query->where([
                    'DevisFactures.created >=' => Chronos::now()->startOfYear(),
                ]);
            }

            if ($periode == 'last_year') {
                $query->where([
                    'DevisFactures.created >=' => Chronos::now()->subYear(1)->startOfYear(),
                    'DevisFactures.created <=' => Chronos::now()->subYear(1)->endOfYear(),
                ]);
            }   

            if ($periode == 'custom_threshold') {
                $thresholdExplodedPeriod = explode(' - ', $options['date_threshold']);

                $query->where([
                    'DevisFactures.created >=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[0]),
                    'DevisFactures.created <=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[1])
                ]);
            }
        }
        
        
        $sort = isset($options['sort']) ? $options['sort'] : null;
        $direction = isset($options['direction']) ? $options['direction'] : null;

        if($sort && $direction) {
            $query->order([$sort => $direction]);
        } else {
            $query->order(['DevisFactures.indent' => 'DESC']);
        }

        return $query;
    }

    /**
     * autre cas de figure, dans les cas de plusieurs échéances de règlement, 
     * si on est en retard que sur 1 échéance (mais qu'il en reste d'autres sur lesquelles on est pas en retard), 
     * il faut compter uniquement le montant de l'échéance en retard.
     * @param  Query  $query   [description]
     */
    public function findRetard(Query $query, array $options)
    {
        $query
            ->contain(['DevisFacturesEcheances', 'FactureReglements', 'Avoirs' => function ($q) {
                return $q->where(['status' => 'paid']);
            }]) 
            ->where(['DevisFactures.status' => 'delay']) // delay ou partial-payment
            ->order(['DevisFactures.id' => 'DESC'])
        ;

        return $query;
    }

    /**
     * Retard +
     * si typ delai echeance on prend la 1ere echeance non réglé, il faut compter uniquement le montant de l'échéance en retard. pareil que retard
     * @param  Query  $query   [description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function findAvecJrRetard(Query $query, array $options)
    {
        $query
            ->distinct(['DevisFactures.id'])
            ->contain(['FactureReglements', 'Avoirs' => function ($q) {
                return $q->where(['status' => 'paid']);
            }]) 
            ->leftJoinWith('DevisFacturesEcheances')
            ->enableAutoFields(true)
            ->select([
                'nb_jour_retard' => '
                    (
                        CASE 
                            WHEN delai_reglements = "echeances" 
                            THEN abs(DATEDIFF(DevisFacturesEcheances.date, "'.date('Y-m-d').'"))
                            WHEN date_crea is not null
                            THEN abs(DATEDIFF(date_crea, "'.date('Y-m-d').'"))
                            ELSE abs(DATEDIFF(DevisFactures.created, "'.date('Y-m-d').'"))
                        END
                    )
                ',
                'date_retard_echeance' => '
                    (
                        CASE 
                            WHEN delai_reglements = "echeances" 
                            THEN DevisFacturesEcheances.date
                            WHEN date_crea is not null
                            THEN date_crea
                            ELSE DevisFactures.created
                        END
                    )
                '
            ])
            ->where(['OR' => ['DevisFacturesEcheances.is_payed is null', 'DevisFacturesEcheances.is_payed' => 0]])
            ->where(['DevisFactures.status' => 'delay'])
            ->having(['date_retard_echeance <' => date('Y-m-d')])
        ;

        if ($options) {
            $query->having($options);
        }
        return $query;
    }

    /**
     * "en délai" = factures qui sont pas encore en retard mais qui sont pas réglées
     * @return [type]          [description]
     */
    public function findDelai(Query $query, array $options)
    {
        $query
            ->contain(['FactureReglements', 'Avoirs' => function ($q) {
                return $q->where(['status' => 'paid']);
            }]) 
            ->where(['DevisFactures.status not IN' => ['delay', 'paid', 'canceled']])
            ->order(['DevisFactures.id' => 'DESC'])
        ;
        return $query;
    }

    /**
     * "Total factures en attente de règlement" = total des factures non réglées (peut importe le statut, sauf "annulé" qu'on ne tient pas compte)
     * @return [type]          [description]
     */
    public function findNonReglees(Query $query, array $options)
    {
        $query
            ->contain(['FactureReglements', 'Avoirs' => function ($q) {
                return $q->where(['status' => 'paid']);
            }]) 
            ->where(['DevisFactures.status not IN' => ['canceled', 'paid']])
        ;
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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        return $rules;
    }

}
