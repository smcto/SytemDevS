<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use \Cake\Chronos\Chronos;

/**
 * Bornes Model
 *
 * @property \App\Model\Table\ParcsTable|\Cake\ORM\Association\BelongsTo $Parcs
 * @property \App\Model\Table\ModelBornesTable|\Cake\ORM\Association\BelongsTo $ModelBornes
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\ActuBornesTable|\Cake\ORM\Association\HasMany $ActuBornes
 * @property \App\Model\Table\BorneLogicielsTable|\Cake\ORM\Association\HasMany $BorneLogiciels
 * @property \App\Model\Table\BornesHasMediasTable|\Cake\ORM\Association\HasMany $BornesHasMedias
 *
 * @method \App\Model\Entity\Borne get($primaryKey, $options = [])
 * @method \App\Model\Entity\Borne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Borne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Borne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Borne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Borne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Borne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Borne findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BornesTable extends Table
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

        $this->setTable('bornes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Parcs', [
            'foreignKey' => 'parc_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('ParcsLocatif', [
            'className' => 'Parcs',
            'foreignKey' => 'parc_id',
            'conditions' => ['ParcsLocatif.nom'=>'Location']
        ]);

        $this->belongsTo('ParcsVente', [
            'className' => 'Parcs',
            'foreignKey' => 'parc_id',
            'conditions' => ['ParcsVente.nom'=>'Vente']
        ]);
        
        $this->belongsTo('Operateur', [
            'className' => 'Users',
            'foreignKey' => 'operateur_id',
        ]);
        
        $this->belongsTo('ParcDurees', [
            'foreignKey' => 'parc_duree_id',
        ]);

        $this->belongsTo('ModelBornes', [
            'foreignKey' => 'model_borne_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id',
            //'conditions' => ['Antennes.is_deleted'=>false]
        ]);

        $this->hasMany('EquipementsProtectionsBornes', [
            'foreignKey' => 'borne_id',
        ]);
        
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        
        $this->belongsTo('EtatBornes', [
            'foreignKey' => 'etat_borne_id'
        ]);
        
        $this->hasMany('ActuBornes', [
            'foreignKey' => 'borne_id'
        ]);
        
        $this->hasMany('Ventes', [
            'foreignKey' => 'borne_id'
        ]);
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        
        $this->belongsToMany('Logiciels', [
            'className' => 'Logiciels',
            'joinTable' => 'borne_logiciels',
            'targetForeignKey' =>'logiciel_id',
            'foreignKey' => 'borne_id'
        ]);
         
        $this->belongsTo('Couleurs', [
            'foreignKey' => 'couleur_id',
            'joinTable' => 'couleurs'
        ]);
      
        $this->belongsToMany('Equipements', [
            'className' => 'Equipements',
            'joinTable' => 'equipement_bornes',
            'targetForeignKey' =>'equipement_id',
            'foreignKey' => 'borne_id'
        ]);

        $this->hasMany('EquipementBornes', [
            'className' => 'EquipementBornes',
            'foreignKey' => 'borne_id'
        ]);

        $this->belongsToMany('NumeroSeries', [
          'className' => 'NumeroSeries',
          'foreignKey' => 'borne_id',
          'targetForeignKey' => 'serial_id',
          'joinTable' => 'borne_numero_series',
        ]);

        
        $this->belongsToMany('LicencesBornes', [
            'className' => 'Licences',
            'joinTable' => 'licence_bornes',
            'targetForeignKey' =>'licence_id',
            'foreignKey' => 'borne_id'
        ]);

        $this->belongsTo('Licences',[
            'foreignKey' => 'numero_series_win_licence',
            'joinTable' => 'licences'
        ]);
        
        $this->belongsTo('LicencesSb',[
                'className' => 'Licences',
                'foreignKey' => 'numero_series_sb_licence',
        ]);
        
        $this->belongsTo('TypeLicences', [
                'foreignKey' => 'type_win_licence',
                'joinTable' => 'type_licences'
        ]);

        $this->belongsTo('TypeContrats', [
            'foreignKey' => 'type_contrat_id',
            'joinTable' => 'type_contrats'
        ]);

        $this->belongsTo(
            'GammesBornes', [
                'className' => 'GammesBornes',
                'foreignKey' => 'gamme_borne_id', // FK pour la table courante ex: category_id
            ]
        );
        
        $this->hasMany('BornesAccessoires', [
            'foreignKey' => 'borne_id',
            'dependent' => true, // pour les suppressions automatiques des associations
            'cascadeCallbacks' => true,
        ]);
        
        /*
         *  POUR DYNAMISER : EquipementBornes
         * 
        $this->belongsTo('EquipementsTypePc', [
                'className' => 'Equipements',
                'foreignKey' => 'type_pc',
        ]);
        $this->belongsTo('EquipementsModelAppareil', [
                'className' => 'Equipements',
                'foreignKey' => 'model_appareil',
        ]);
        $this->belongsTo('EquipementsTypeEcran', [
                'className' => 'Equipements',
                'foreignKey' => 'type_ecran',
        ]);
        $this->belongsTo('EquipementsTypePrint', [
                'className' => 'Equipements',
                'foreignKey' => 'type_print',
        ]);
        
        
        $this->belongsTo('NumeroSeriesTypePc', [
                'className' => 'NumeroSeries',
                'foreignKey' => 'numero_series_pc',
        ]);
        $this->belongsTo('NumeroSeriesModelAppareil', [
                'className' => 'NumeroSeries',
                'foreignKey' => 'numero_series_aphoto',
        ]);
        $this->belongsTo('NumeroSeriesTypeEcran', [
                'className' => 'NumeroSeries',
                'foreignKey' => 'numero_series_ecran',
        ]);
        $this->belongsTo('NumeroSeriesTypePrint', [
                'className' => 'NumeroSeries',
                'foreignKey' => 'numero_series_print',
        ]);
        $this->belongsTo('NumeroSeriesBorne', [
                'className' => 'NumeroSeries',
                'foreignKey' => 'numero_series_bornier',
        ]);
         * 
         */
    }

    
    protected function _initializeSchema($schema)
    {
        $schema->setColumnType('checked_accessories', 'json');
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
        
        // $validator
        //     ->integer('id')
        //     ->allowEmpty('id', 'create');

        // $validator
        //     ->integer('numero')
        //     ->requirePresence('numero', 'create')
        //     ->notEmpty('numero');

        // $validator
        //     ->scalar('couleur')
        //     ->maxLength('couleur', 255)
        //     ->allowEmpty('couleur');

        // $validator
        //     ->date('expiration_sb')
        //     ->allowEmpty('expiration_sb');

        // $validator
        //     ->scalar('commentaire')
        //     ->maxLength('commentaire', 255)
        //     ->allowEmpty('commentaire');

        // $validator
        //     ->boolean('is_prette')
        //     ->requirePresence('is_prette', 'create')
        //     ->notEmpty('is_prette');

        // $validator
        //     ->date('date_arrive_estime')
        //     ->allowEmpty('date_arrive_estime');

        // $validator
        //     ->scalar('ville')
        //     ->maxLength('ville', 255)
        //     ->allowEmpty('ville');

        // $validator
        //     ->scalar('longitude')
        //     ->maxLength('longitude', 225)
        //     ->allowEmpty('longitude');

        // $validator
        //     ->scalar('latitude')
        //     ->maxLength('latitude', 225)
        //     ->allowEmpty('latitude');

        
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
        $rules->add($rules->existsIn(['parc_id'], 'Parcs'));
        $rules->add($rules->existsIn(['model_borne_id'], 'ModelBornes'));
        $rules->add($rules->existsIn(['antenne_id'], 'Antennes'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }

    public function findWithAnnotation(Query $query, array $options)
    {
        $query->contain(['ModelBornes' => 'GammesBornes'])->enableAutoFields(true)->select(['annotation_numero' => 'concat(coalesce(GammesBornes.notation, ""), "", Bornes.numero)']);
        return $query;
    }
    
    public function findFiltre(Query $query, array $options) {
        
        $search = isset($options['key'])?$options['key']:null;
        if(!empty($search)){
            $query->where([
                'OR' => [
                    ['CAST(numero as CHAR) LIKE' => '%'.$search.'%'],
                    ['CAST(numero as CHAR) LIKE' => '%'.str_replace(['c', 's'], ['', ''], $search).'%'],
                    ['numero_serie LIKE' => '%'.$search.'%'],
                    ['Clients.nom LIKE' => '%'.$search.'%'],
                    ['Clients.prenom LIKE' => '%'.$search.'%']
                ]
            ]);
        }

        $parc_type = isset($options['parc_type'])?$options['parc_type']:null;
        if(!empty($parc_type)){
            
            if($parc_type != 1 && $parc_type != 2 && $parc_type != 3 && $parc_type != 4 && $parc_type != 9 && $parc_type != 11){
                return $query;
            }
            $query->contain(['Parcs'=> function ($q) use ($parc_type){
                return $q->where(['Parcs.id'=>$parc_type]);
            }]);
        }

        $contrat = isset($options['contrat']) ? $options['contrat'] : null;
        if(!empty($contrat)){
           $query->where(['type_contrat_id' => $contrat]);
        }
        
        $user_id = isset($options['user_id']) ? $options['user_id'] : null;
        if(!empty($user_id)){
           $query->where(['Bornes.user_id' => $user_id]);
        }
     
        $model = isset($options['model'])?$options['model']:null;
        if(!empty($model)){
            $query->where(['Bornes.model_borne_id'=>$model]);
        }

        $gamme = $options['gamme'];
        if(!empty($gamme)){
            $query->where(['GammesBornes.id'=> $gamme]);
        }
        
        $antenne = isset($options['antenne'])?$options['antenne']:null;
        if(!empty($antenne)){
                $query->where(['Antennes.ville_principale LIKE' => '%'.$antenne.'%']);
            //$query->where(['Bornes.antenne_id'=>$antenne]);
        }
        
        $parc = isset($options['parc'])?$options['parc']:null;
        if(!empty($parc)){
            $query->where(['Bornes.parc_id'=>$parc]);
        }
        
        $couleur = isset($options['couleur'])?$options['couleur']:null;
        if(!empty($couleur)){
            $query->where(['Bornes.couleur_id'=>$couleur]);
        }

        $connexion = isset($options['connexion'])?$options['connexion']:null;
        if(!empty($connexion)){
            $query->where(['teamviewer_online_state'=>$connexion]);
        }
        
        $is_sous_louee = isset($options['is_sous_louee']) ? $options['is_sous_louee'] : null;
        if($is_sous_louee != null){
           $query->where(['is_sous_louee' => $is_sous_louee]);
        }
        
        $groupe_clients = isset($options['groupe_clients'])?$options['groupe_clients']:null;

        if(!empty($groupe_clients)){
            $query->where(['GroupeClients.id = ' =>$groupe_clients]);
        }

        //if(!empty($searchstate)){
           // $query->where(['teamviewer_online_state LIKE' => '%'.$searchstate.'%'], ['teamviewer_online_state' => 'string']);
        //}
        
        $equipement = isset($options['equipement'])?$options['equipement']:null;
		
		if(!empty($equipement)){
			foreach($equipement as $id => $value){
				if(trim($value) == ''){
					unset($equipement[$id]);
				}
			}
		}
		
        if(!empty($equipement)){
			$query->matching('Equipements', function ($q) use($equipement) {
				return $q->where(['Equipements.id IN' => $equipement]);
			});
        }
        return $query;
    }
    
    /**
     * 
     * @param type $event
     * @param type $borneEntity
     * @param type $options
     */
    public function beforeSave($event, $borneEntity, $options) {
        
        if(! $borneEntity->numero_serie && $borneEntity->sortie_atelier) {
            $bornes = $this->find('all')->where(['DATE_FORMAT(sortie_atelier, "%y-%m") = ' => $borneEntity->sortie_atelier->format('y-m'), 'WEEK(Bornes.sortie_atelier, 1) = ' => $borneEntity->sortie_atelier->format('W')])->toArray();

            $date = Chronos::parse($borneEntity->sortie_atelier->format('Y-m-d'));

            $semaine = $date->format('W');
            $annee = $date->format('y');
            $i = count($bornes) + 1;

            $gamme = @$borneEntity->model_borne->gammes_borne->notation;
            if (! $gamme) {
                $model = $this->ModelBornes->findById($borneEntity->model_borne_id)->contain(['GammesBornes'])->first();
                $gamme = @$model->gammes_borne->notation;
            }

            $numSerie = "$gamme$annee$semaine" . sprintf("%02d", $i);

            $borneEntity->numero_serie = $numSerie;
        }
    }

    public function findListForVentes(Query $query, array $options)
    {
        $query
            ->find('list',[
                'valueField'=>function ($e) {
                    return $e->model_borne->gammes_borne->notation.$e->numero;
                },
                'groupField' => function ($e) {
                    return $e->parc_id. ';' .$e->model_borne->gamme_borne_id;
                },
            ])
            ->contain(['Parcs' ,'ModelBornes' => 'GammesBornes'])
            ->order(['numero' => 'ASC'])
        ;
        return $query;
    }

    /**
     * afterSave callback
     *
     * @param $options array
     * @return boolean
     */
    public function afterSave($event, $borneEntity, $options) {
        
        if($borneEntity->client_id) {
            $client = $this->Clients->findById($borneEntity->client_id)->contain(['Devis', 'Bornes'])->first();
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
                            case 9 : { $data['is_location_lng_duree'] = 1; break;}
                            case 10 : { $data['is_borne_occasion'] = 1; break;}
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
