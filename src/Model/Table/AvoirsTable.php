<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Chronos\Chronos;
use DateTime;

/**
 * Avoirs Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $RefCommercials
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\InfoBancairesTable|\Cake\ORM\Association\BelongsTo $InfoBancaires
 * @property \App\Model\Table\ModeleAvoirsCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleAvoirsCategories
 * @property \App\Model\Table\ModeleAvoirsSousCategoriesTable|\Cake\ORM\Association\BelongsTo $ModeleAvoirsSousCategories
 * @property \App\Model\Table\SellsyClientsTable|\Cake\ORM\Association\BelongsTo $SellsyClients
 * @property \App\Model\Table\SellsyDocsTable|\Cake\ORM\Association\BelongsTo $SellsyDocs
 * @property \App\Model\Table\AvoirsTable|\Cake\ORM\Association\BelongsTo $Avoirs
 * @property \App\Model\Table\SellsyEstimatesTable|\Cake\ORM\Association\BelongsTo $SellsyEstimates
 * @property \App\Model\Table\ClientContactsTable|\Cake\ORM\Association\BelongsTo $ClientContacts
 * @property \App\Model\Table\AvoirsProduitsTable|\Cake\ORM\Association\HasMany $AvoirsProduits
 *
 * @method \App\Model\Entity\Avoir get($primaryKey, $options = [])
 * @method \App\Model\Entity\Avoir newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Avoir[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Avoir|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Avoir|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Avoir patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Avoir[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Avoir findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AvoirsTable extends Table
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

        $this->setTable('avoirs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
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
        $this->belongsTo('SellsyClients', [
            'foreignKey' => 'sellsy_client_id'
        ]);
        $this->belongsTo('SellsyDocs', [
            'foreignKey' => 'sellsy_doc_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DevisFactures', [
            'foreignKey' => 'devis_facture_id'
        ]);
        $this->belongsTo('SellsyEstimates', [
            'foreignKey' => 'sellsy_estimate_id'
        ]);
        $this->belongsTo('AvoirsClientContacts', [
            'foreignKey' => 'client_contact_id',
            'className' => 'ClientContacts',
        ]);
        $this->hasMany('AvoirsProduits', [
            'foreignKey' => 'avoir_id'
        ]);

        $this->belongsToMany('AvoirsReglements', [
            'className' => 'Reglements',
            'joinTable' => 'reglements_has_avoirs',
            'targetForeignKey' =>'reglements_id',
            'foreignKey' => 'avoir_id'
        ]);

        $this->belongsTo('Commercial', [
            'className' => 'Users',
            'foreignKey' => 'ref_commercial_id'
        ]);
        $this->belongsTo('RefCommercials', [
            'foreignKey' => 'ref_commercial_id'
        ]);
        
        $this->belongsTo('DevisTypeDocs', [
            'foreignKey' => 'type_doc_id',
            // 'joinType' => 'INNER'
        ]);
        
        $this->hasMany('StatutHistoriques', [
            'foreignKey' => 'avoir_id',
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
            ->allowEmpty('objet');

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
            ->scalar('echeance_date')
            ->maxLength('echeance_date', 4294967295)
            ->allowEmpty('echeance_date');

        $validator
            ->scalar('echeance_value')
            ->maxLength('echeance_value', 4294967295)
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
            ->scalar('col_visibility_params')
            ->maxLength('col_visibility_params', 350)
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
            ->scalar('categorie_tarifaire')
            ->allowEmpty('categorie_tarifaire');

        $validator
            ->scalar('client_nom')
            ->maxLength('client_nom', 255)
            ->allowEmpty('client_nom');

        $validator
            ->scalar('client_email')
            ->maxLength('client_email', 255)
            ->allowEmpty('client_email');

        $validator
            ->scalar('client_ville')
            ->maxLength('client_ville', 255)
            ->allowEmpty('client_ville');

        $validator
            ->scalar('client_adresse')
            ->maxLength('client_adresse', 255)
            ->allowEmpty('client_adresse');

        $validator
            ->scalar('client_adresse_2')
            ->maxLength('client_adresse_2', 255)
            ->allowEmpty('client_adresse_2');

        $validator
            ->scalar('client_country')
            ->maxLength('client_country', 255)
            ->allowEmpty('client_country');

        $validator
            ->allowEmpty('display_tva');

        $validator
            ->scalar('sellsy_echeances')
            ->maxLength('sellsy_echeances', 4294967295)
            ->allowEmpty('sellsy_echeances');

        $validator
            ->boolean('is_in_sellsy')
            ->allowEmpty('is_in_sellsy');

        $validator
            ->scalar('sellsy_public_url')
            ->maxLength('sellsy_public_url', 500)
            ->allowEmpty('sellsy_public_url');

        $validator
            ->scalar('commentaire_client')
            ->allowEmpty('commentaire_client');

        $validator
            ->scalar('commentaire_commercial')
            ->allowEmpty('commentaire_commercial');

        $validator
            ->scalar('client_tel')
            ->maxLength('client_tel', 250)
            ->allowEmpty('client_tel');

        $validator
            ->boolean('display_virement')
            ->notEmpty('display_virement');

        $validator
            ->boolean('display_cheque')
            ->notEmpty('display_cheque');

        return $validator;  
    }
    
    public function findComplete(Query $query, array $options)
    {
        $query
            ->contain([
                'AvoirsReglements',
                'Clients' => 'ClientContacts',
                'AvoirsClientContacts',
                'DevisFactures',
                'Commercial',
                'Langues',
                'AvoirsProduits'=> function ($q) {
                    return $q->contain(['CatalogUnites'])->order(['AvoirsProduits.i_position'=>'ASC']);
                }
        ])
        ->order(['Avoirs.indent' => 'DESC']);

        return $query;
    }

    public function findAsModele(Query $query, array $options)
    {
        $query = $query->contain(['Clients', 'AvoirsProduits'=> function ($q) {
            return $q->order(['AvoirsProduits.i_position'=>'ASC']);
        }])->first();
        
        unset($query->id);
        unset($query->devis_facture_id);
        unset($query->indent);
        unset($query->client);
        unset($query->client_id);
        unset($query->client_contact_id);
        unset($query->facture_client_contact);
        unset($query->date_crea);
        unset($query->date_validite);
        unset($query->date_sign_before);
        unset($query->model_name);
        unset($query->status);
        unset($query->modele_devis_factures_category_id);
        unset($query->modele_devis_factures_sous_category_id);
        unset($query->ref_commercial_id);
        if (!empty($query->devis_factures_produits)) {
            foreach ($query->devis_factures_produits as $key => $devis_factures_produits) {
                unset($devis_factures_produits->id);
            }
        }
        return $query;
    }

    public function findFiltre(Query $query, array $options)
    {
        $keyword = isset($options['keyword'])?trim($options['keyword']):null;
        if ($keyword) {
            $query->contain(['Clients' => 'ClientContact']);
            $query->where([
                'OR' => [
                    ['Avoirs.indent LIKE' => '%'.$keyword.'%'],
                    ['Avoirs.total_ttc' => $keyword],
                    ['Avoirs.total_ht' => $keyword],
                    ['Clients.nom LIKE' => '%'.$keyword.'%'],
                    ['Clients.telephone LIKE' => '%'.$keyword.'%'],
                    ['Clients.email LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.nom LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.prenom LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.tel LIKE' => '%'.$keyword.'%'],
                    ['ClientContact.email LIKE' => '%'.$keyword.'%'],
                ]
            ])->group('Avoirs.id');
        }
        
        if(isset($options['type_doc_id']) && $options['type_doc_id'] != null) {
            $query->where(['Avoirs.type_doc_id' => $options['type_doc_id']]);
        }
        if(isset($options['is_in_sellsy'])){
            $query->where(['Avoirs.is_in_sellsy' => $options['is_in_sellsy']]);
        }
        if (!empty($options['indent'])) {
            $query->where(['Avoirs.indent LIKE' => '%' . $options['indent'] . '%']);
        }
        if (!empty($options['ref_commercial_id'])) {
            $query->where(['ref_commercial_id' => $options['ref_commercial_id']]);
        }

        if (!empty($options['client_id'])) {
            $query->where(['Avoirs.client_id' => $options['client_id']]);
        }
        
        if (!empty($options['client_type'])) {
            $query->where(['Clients.client_type' => $options['client_type']]);
        }
        
        if (!empty($options['status'])) {
            $query->where(['Avoirs.status' => $options['status']]);
        }

        if (!empty($options['created'])) {
            $query->where(["Avoirs.created LIKE" => '%'.$options['created'].'%']);
        }

        if (!empty($options['date_evenement'])) {
            $query->where(["Avoirs.date_evenement" => $options['date_evenement']]);
        }

        if (!empty($options['antenne_id'])) {
            $query->contain(['AvoirsAntennes'])->matching('AvoirsAntennes')->where(['AvoirsAntennes.antenne_id' => $options['antenne_id']]);
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
            })->group('Avoirs.id');
        }

        $periode = !empty($options['periode'])?$options['periode']:null;
        if ($periode) {
            if ($periode == 'current_month') {
                $query->where([
                    'Avoirs.date_crea >=' => Chronos::now()->startOfMonth()
                ]);
            }

            if ($periode == 'last_month') {
                $query->where([
                    'Avoirs.date_crea >=' => Chronos::now()->subMonth(1)->startOfMonth(),
                    'Avoirs.date_crea <=' => Chronos::now()->subMonth(1)->endOfMonth(),
                ]);
            }

            if ($periode == 'list_month') {
                $nMois = $options['mois_id']+1;
                $annee_mois = date('Y').'-'.sprintf('%02d', $nMois);
                $query
                    ->select(['annee_mois' => 'DATE_FORMAT(Avoirs.date_crea, "%Y-%m")'])->enableAutoFields(true)
                    ->having([
                        'annee_mois LIKE' => $annee_mois,
                    ])
                ;
            }

            if ($periode == 'current_year') {
                $query->where([
                    'Avoirs.date_crea >=' => Chronos::now()->startOfYear(),
                ]);
            }

            if ($periode == 'last_year') {
                $query->where([
                    'Avoirs.date_crea >=' => Chronos::now()->subYear(1)->startOfYear(),
                    'Avoirs.date_crea <=' => Chronos::now()->subYear(1)->endOfYear(),
                ]);
            }   


            if ($periode == 'custom_threshold') {
                $thresholdExplodedPeriod = explode(' - ', $options['date_threshold']);

                $query->where([
                    'Avoirs.date_crea >=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[0]),
                    'Avoirs.date_crea <=' => DateTime::createFromFormat('d/m/Y', $thresholdExplodedPeriod[1])
                ]);
            }
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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        return $rules;
    }
}
