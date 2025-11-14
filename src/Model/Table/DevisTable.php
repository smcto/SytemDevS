<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Chronos\Chronos;
use DateTime;

/**
 * Devis Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $RefCommercials
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property |\Cake\ORM\Association\BelongsTo $InfoBancaires
 * @property \App\Model\Table\ModeleDevisCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleDevisCategories
 * @property \App\Model\Table\ModeleDevisSousCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleDevisSousCategories
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsToMany $Antennes
 *
 * @method \App\Model\Entity\Devi get($primaryKey, $options = [])
 * @method \App\Model\Entity\Devi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Devi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Devi|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Devi|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Devi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Devi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Devi findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevisTable extends Table
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

        $this->setTable('devis');
        $this->setDisplayField('nom_societe');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            // 'joinType' => 'INNER'
        ]);

        $this->belongsTo('InfosBancaires', [
            'foreignKey' => 'info_bancaire_id'
        ]);

        $this->belongsTo('Langues', [
            'foreignKey' => 'langue_id'
        ]);

        $this->belongsTo('DevisClientContacts', [
            'className' => 'ClientContacts',
            'foreignKey' => 'client_contact_id'
        ]);

        $this->belongsTo('Commercial', [
            'className' => 'Users',
            'foreignKey' => 'ref_commercial_id'
        ]);

        $this->belongsTo('ModeleDevisCategories', [
            'foreignKey' => 'modele_devis_categories_id'
        ]);

        $this->belongsTo('ModeleDevisSousCategories', [
            'foreignKey' => 'modele_devis_sous_categories_id'
        ]);

        $this->belongsTo('DevisTypeDocs', [
            'foreignKey' => 'type_doc_id',
            // 'joinType' => 'INNER'
        ]);
        
        $this->hasMany(
            'DevisProduits', [
                'className' => 'DevisProduits',
                'foreignKey' => 'devis_id',
            ]
        );

        $this->hasMany(
            'ShortLinks', [
                'className' => 'ShortLinks',
                'foreignKey' => 'devi_id',
            ]
        );

        $this->belongsToMany('Antennes', [
            'className' => 'Antennes',
            'joinTable' => 'devis_antennes',
            'targetForeignKey' =>'antennes_id',
            'foreignKey' => 'devis_id'
        ]);

        $this->belongsToMany('DevisReglements', [
            'className' => 'Reglements',
            'joinTable' => 'reglements_has_devis',
            'targetForeignKey' =>'reglements_id',
            'foreignKey' => 'devis_id'
        ]);

        $this->hasMany(
            'DevisAntennes', [       
                'foreignKey' => 'devis_id'
            ]
        );

        $this->hasMany(
            'DevisEcheances', [       
                'foreignKey' => 'devis_id',
                'dependent' => true,
                'saveStrategy' => 'replace',
                'sort' => ['DevisEcheances.id' => 'ASC']
            ]
        );
        
        $this->hasMany('DevisFactures', [       
                'foreignKey' => 'devis_id',
                'dependent' => true,
                'conditions' => ['DevisFactures.is_situation <>' => 1],
            ]
        );
        
        $this->hasMany('FactureSituations', [       
                'className' => 'DevisFactures',
                'foreignKey' => 'devis_id',
                'dependent' => true,
                'conditions' => ['FactureSituations.is_situation' => 1],
                'sort' => ['FactureSituations.id' => 'ASC']
            ]
        );
        
        $this->belongsTo('DevisFacture', [
            'joinTable' => 'devis_factures', 
            'joinType' => 'LEFT',
            'bindingKey' => 'devis_id',
            'foreignKey' => 'id',
            'className' => 'DevisFactures'
        ]);

        $this->belongsTo('Tvas', [
            'foreignKey' => 'tva_id'
        ]);

        $this->hasMany('DevisStripeHistorics', [
            'foreignKey' => 'devis_id'
        ]);
        
        $this->hasMany('BonsCommandes', [
            'foreignKey' => 'devi_id'
        ]);

        $this->belongsTo('RefCommercials', [
            'foreignKey' => 'ref_commercial_id'
        ]);

        $this->hasMany('StatutHistoriques', [
            'foreignKey' => 'devi_id',
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
            ->notEmpty('status');

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

    public function findWithProduitsBySouscategorie(Query $query, array $options)
    {
        $catalog_sous_category_id = $options['catalog_sous_category_id'];
        
        $query->contain(['DevisProduits' => function ($q) use ($catalog_sous_category_id)
        {
            return $q->contain(['CatalogProduits' => 'CatalogProduitsHasCategories'])->matching('CatalogProduits.CatalogProduitsHasCategories', function ($q) use ($catalog_sous_category_id)
            {
                return $q->where(['CatalogProduitsHasCategories.catalog_sous_category_id' => $catalog_sous_category_id]);
            });
        }]);
        return $query;
    }

    public function findComplete(Query $query, array $options)
    {
        $query
            ->where(['OR' => ['is_model is null', 'is_model' => 0]])
            ->contain([
                'DevisEcheances',
                'DevisReglements',
                'Clients' => 'ClientContacts',
                'InfosBancaires',
                'DevisFactures',
                'ShortLinks',
                'Commercial',
                'DevisClientContacts',
                'ModeleDevisCategories',
                'ModeleDevisSousCategories',
                'DevisReglements' => 'MoyenReglements',
                'DevisProduits'=> function ($q) {
                    return $q->contain(['CatalogUnites'])->order(['DevisProduits.i_position'=>'ASC']);
                },
                'Antennes'
            ])
        ;

        // debug($query ->toArray());
        // die();
        return $query;
    }

    public function findListModel(Query $query, array $options)
    {
        $query->contain([
            'ModeleDevisCategories',
            'ModeleDevisSousCategories'
        ]);
        $query->where(['is_model' => 1]);
        
        if ($options['keyword_model']) {
            $query->where(['model_name LIKE' => '%'.trim($options['keyword_model']).'%']);
        }
        
        $model_type = !empty($options['model_type'])?$options['model_type']:null;
        if($model_type) {
            $query->where(['Devis.model_type' => $model_type]);
        }
        
        $cat = !empty($options['cat'])?$options['cat']:null;
        if($cat) {
            $query->where(['Devis.modele_devis_categories_id' => $cat]);
        }
        
        $sousCat = !empty($options['sous-cat'])?$options['sous-cat']:null;
        if($sousCat) {
            $query->where(['Devis.modele_devis_sous_categories_id' => $sousCat]);
        }
                
        return $query;
    }
    
    public function findModeleWithType(Query $query, array $options) {
        $query->where(['model_type is not null']);
        return $query;
    }

    public function findAsModele(Query $query, array $options)
    {
        $query = $query->contain([
            'Clients', 
            'Antennes',
            'DevisEcheances' => function ($q) {
                return $q->order(['DevisEcheances.date'=>'ASC']);
            },
            'DevisProduits'=> function ($q) {
            return $q->order(['DevisProduits.i_position'=>'ASC']);
        }])->first();
        
        $removedClient = isset($options['removed_client'])?$options['removed_client']:1;
        if($removedClient) {
            unset($query->client);
            unset($query->client_id);
            // unset($query->client_id_2);
            unset($query->client_nom);
            unset($query->client_adresse);
            unset($query->client_cp);
            unset($query->client_ville);
            unset($query->client_country);
            unset($query->client_contact_id);
            unset($query->devis_client_contact);
        }
        
        $toFacture = isset($options['to_facture'])?$options['to_facture']:0;
        if($toFacture) {
            $devis_factures_echeances = [];
            if (!empty($query->devis_echeances)) {
                foreach ($query->devis_echeances as $devis_echeance) {
                    unset($devis_echeance->id);
                    $devis_factures_echeances[] = $devis_echeance;
                }
            }
            $query->devis_factures_echeances = $devis_factures_echeances;
        } else {
            unset($query->ref_commercial_id);
        }
        
        unset($query->id);
        unset($query->indent);
        unset($query->is_model);
        unset($query->date_crea);
        unset($query->date_validite);
        unset($query->date_sign_before);
        unset($query->model_name);
        unset($query->uuid);
        unset($query->status);
        unset($query->modele_devis_categories_id);
        unset($query->modele_devis_sous_categories_id);
        if (!empty($query->devis_produits)) {
            foreach ($query->devis_produits as $key => $devis_produits) {
                unset($query->devis_produits[$key]->id);
            }
        }
        
        return $query;
    }
    
    
    public function findToSituation(Query $query, array $options)
    {
        $query = $query->contain([
            'Clients', 'Antennes', 'FactureSituations' => ['DevisFacturesProduits' => function ($q) {
                return $q->order(['DevisFacturesProduits.i_position'=>'ASC']);
            }],
            'DevisEcheances' => function ($q) {
                return $q->order(['DevisEcheances.date'=>'ASC']);
            },
            'DevisProduits'=> function ($q) {
                return $q->contain(['CatalogUnites'])->order(['DevisProduits.i_position'=>'ASC']);
            }])
            ->first()->toArray();
        
        $query['devis_factures_produits'] = [];
        
        if (!empty($query['devis_produits'])) {
            foreach ($query['devis_produits'] as $key => $devis_produits) {
                unset($query['devis_produits'][$key]['id']);
                $query['devis_factures_produits'][$key] = $query['devis_produits'][$key];
                $query['devis_factures_produits'][$key]['facture_pourcentage'] = 1;
                $query['devis_factures_produits'][$key]['avancement_pourcentage'] = 0;
                $query['devis_factures_produits'][$key]['facture_euro'] = 0;
                $query['devis_factures_produits'][$key]['avancement_euro'] = 0;
            }

            foreach ($query['facture_situations'] as $situation) {
                if (!empty($situation['devis_factures_produits'])) {
                    foreach ($situation['devis_factures_produits'] as $key => $produits) {
                        $query['devis_factures_produits'][$key]['facture_pourcentage'] += $produits['avancement_pourcentage'];
                        $query['devis_factures_produits'][$key]['facture_euro'] += $produits['avancement_euro'];
                    }
                }
            }
        }
        
        unset($query['id']);
        unset($query['indent']);
        unset($query['is_model']);
        unset($query['date_crea']);
        unset($query['date_validite']);
        unset($query['date_sign_before']);
        unset($query['model_name']);
        unset($query['uuid']);
        unset($query['status']);
        unset($query['modele_devis_categories_id']);
        unset($query['modele_devis_sous_categories_id']);
        
        return $query;
    }
    
    
    public function findToBonsCommande(Query $query, array $options)
    {
        $data = $query->contain([
            'DevisProduits'=> function ($q) {
            return $q->order(['DevisProduits.i_position'=>'ASC']);
        }])->first()->toArray();
        
        $newData = [
           'devi_id' => $data['id'],
           'client_id' => $data['client_id'],
           'user_id' => $data['ref_commercial_id'],
        ];
        
        $newData['bons_commandes_produits'] = [];
        
        if (!empty($data['devis_produits'])) {
            
            foreach ($data['devis_produits'] as $key => $devis_produits) {
                
                if ($devis_produits['type_ligne'] == 'produit' && $devis_produits['is_consommable']) {
                    
                    $newData['bons_commandes_produits'][] = [
                        'catalog_produits_id' => $devis_produits['catalog_produits_id'],
                        'reference' => $devis_produits['reference'],
                        'nom' => $devis_produits['nom_commercial'],
                        'description_commercial' => $devis_produits['description_commercial'],
                        'quantite' => $devis_produits['quantite_usuelle'],
                        'quantite_livree' => 0,
                        'rest_a_livrer' => $devis_produits['quantite_usuelle'],
                        'rest' => $devis_produits['quantite_usuelle'],
                    ];
                }
            }
        }
                
        return $newData;
    }
    
    
    public function findFiltre(Query $query, array $options)
    {
        $keyword = isset($options['keyword'])? trim($options['keyword']) : null;
        $client = isset($options['client'])? trim($options['client']) : null;
        $contact_client = isset($options['contact_client'])? trim($options['contact_client']) : null;

        $query->contain(['Clients' => 'ClientContact'])->group('Devis.id');
        if ($keyword) {
            $query->where([
                'OR' => [
                    ['Devis.indent LIKE' => '%'.$keyword.'%'],
                    ['Clients.nom LIKE' => '%' . $keyword . '%'],
                    ['Clients.prenom LIKE' => '%' . $keyword . '%'],
                    ['Clients.enseigne LIKE' => '%' . $keyword . '%'],
                ]
            ]);
        }

        if ($client) {
            if (strpos($client, '"') !== false) {
                $client = str_replace('"', '', $client);
                $query->where([
                    'OR' => [
                        ['Clients.nom LIKE' => $client],
                        ['Clients.prenom LIKE' => $client],
                        ['Clients.enseigne LIKE' => $client],
                    ]
                ]);
            } else {
                $query->where([
                    'OR' => [
                        ['Clients.nom LIKE' => '%'.$client.'%'],
                        ['Clients.enseigne LIKE' => '%'.$client.'%'],
                    ]
                ]);
            }
        }
        
        if ($contact_client) {
            $query->where([
                'OR' => [
                    ['ClientContact.nom LIKE' => '%'.$contact_client.'%'],
                    ['ClientContact.prenom LIKE' => '%'.$contact_client.'%'],
                    ['ClientContact.tel LIKE' => '%'.$contact_client.'%'],
                    ['ClientContact.email LIKE' => '%'.$contact_client.'%'],
                ]
            ]);
        }
        
        $montant = isset($options['montant']) ? trim($options['montant']) : null;
        if($montant) {
            $query->where([
                'OR' => [
                    ['CAST(Devis.total_ht as CHAR) LIKE' => '%'.$montant.'%'],
                    ['CAST(Devis.total_ttc as CHAR) LIKE' => '%'.$montant.'%'],
                ]
            ]);
        }

        $type_doc = isset($options['type_doc_id']) ? $options['type_doc_id'] : null;
        if ($type_doc) {
            $query->where(['Devis.type_doc_id' => $type_doc]);
        }

        $refCom = isset($options['ref_commercial_id']) ? $options['ref_commercial_id'] : null;
        if ($refCom) {
            $query->where(['ref_commercial_id' => $refCom]);
        }

        $client_type = isset($options['client_type']) ? $options['client_type'] : null;
        if ($client_type) {
            $query->where(['Clients.client_type' => $client_type]);
        }
        
        $status = isset($options['status']) ? $options['status'] : null;
        if ($status) {
            $query->where(['Devis.status' => $status]);
        }

        $created = isset($options['created'])?$options['created']:null;
        if ($created) {
            $query->where(["Devis.created LIKE" => '%'.$created.'%']);
        }
        
        $date_crea = isset($options['date_crea'])?$options['date_crea']:null;
        if ($date_crea) {
            $query->where(["Devis.date_crea LIKE" => '%'.$date_crea.'%']);
        }

        $antennes_id = isset($options['antennes_id'])?$options['antennes_id']:null;
        if ($antennes_id) {
            $query->contain(['DevisAntennes'])->matching('DevisAntennes')->where(['DevisAntennes.antennes_id' => $antennes_id]);
        }

        $periode = isset($options['periode']) ? $options['periode'] : null;
        if ($periode) {
            if ($periode == 'current_month') {
                $query->where([
                    'Devis.date_crea >=' => Chronos::now()->startOfMonth()
                ]);
            }

            if ($periode == 'last_month') {
                $query->where([
                    'Devis.date_crea >=' => Chronos::now()->subMonth(1)->startOfMonth(),
                    'Devis.date_crea <=' => Chronos::now()->subMonth(1)->endOfMonth(),
                ]);
            }

            if ($periode == 'list_month') {
                $nMois = $options['mois_id']+1;
                $annee_mois = date('Y').'-'.sprintf('%02d', $nMois);
                $query
                    ->select(['annee_mois' => 'DATE_FORMAT(Devis.date_crea, "%Y-%m")'])->enableAutoFields(true)
                    ->having([
                        'annee_mois LIKE' => $annee_mois,
                    ])
                ;
            }

            if ($periode == 'current_year') {
                $query->where([
                    'Devis.date_crea >=' => Chronos::now()->startOfYear(),
                ]);
            }

            if ($periode == 'last_year') {
                $query->where([
                    'Devis.date_crea >=' => Chronos::now()->subYear(1)->startOfYear(),
                    'Devis.date_crea <=' => Chronos::now()->subYear(1)->endOfYear(),
                ]);
            }   


            if ($periode == 'custom_threshold') {
                $thresholdExplodedPeriod = explode(' - ', $options['date_threshold']);

                $query->where([
                    'Devis.date_crea >=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[0]),
                    'Devis.date_crea <=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[1])
                ]);
            }
        }
        
        
        $sort = isset($options['sort']) ? $options['sort'] : null;
        $direction = isset($options['direction']) ? $options['direction'] : null;

        if($sort && $direction) {
            $query->order([$sort => $direction]);
        } else {
            $query->order(['Devis.indent' => 'DESC']);
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
        return $rules;
    }
    
    

    /**
     * beforeSave callback
     *
     * @param $options array
     * @return boolean
     */
    public function beforeSave($event, $entity, $options) {
                
        if($entity->devis_produits) {
            
            foreach ($entity->devis_produits as $devis_produit) {
                
                if ($devis_produit->is_consommable) {
                    $entity->set('is_consommable', 1);
                }
            }
        }
        
        return true;
    }
    
    /**
     * afterSave callback
     *
     * @param $options array
     * @return boolean
     */
    public function afterSave($event, $devisEntity, $options) {
        
        if( ! $devisEntity->is_model) {

            if($devisEntity->client_id) {
                $client = $this->Clients->findById($devisEntity->client_id)->contain(['Devis', 'Bornes'])->first();
                if($client) {
            
                    $data = [
                        'is_location_event' => 0,
                        'is_location_financiere' => 0,
                        'is_vente' => 0,
                        'is_selfizee_part' => 0,
                        'is_digitea' => 0,
                        'is_brandeet' => 0,
                    ];
                    
                    if(count($client->devis)) {

                        foreach ($client->devis as $devis) {
                            if( ! $devis->is_model) {
                                
                                switch ($devis->type_doc_id) {
                                    case 1 : { $data['is_selfizee_part'] = 1; break;}
                                    case 2 : { $data['is_digitea'] = 1; break;}
                                    case 3 : { $data['is_brandeet'] = 1; break;}
                                    case 4 : { $data['is_location_event'] = 1; break;}
                                    case 5 : { $data['is_vente'] = 1; break;}
                                    case 6 : { $data['is_location_financiere'] = 1;break;}
                                    default : break;
                                }
                            }
                        }
                    }
                    
                    if(count($client->bornes)) {

                        foreach ($client->bornes as $borne) {
                                
                            switch ($borne->parc_id) {
                                case 1 : { $data['is_vente'] = 1; break;}
                                case 4 : { $data['is_location_financiere'] = 1; break;}
                                default : break;
                            }
                        }
                    }
                    
                    $editClient = $this->Clients->patchEntity($client, $data, ['validate' => false]);
                    $this->Clients->save($editClient);
                }
            }
        }
    }

}
