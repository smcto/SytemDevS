<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;


/**
 * Clients Model
 *
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\HasMany $Bornes
 * @property \App\Model\Table\ClientContactsTable|\Cake\ORM\Association\HasMany $ClientContacts
 * @property \App\Model\Table\DocumentsTable|\Cake\ORM\Association\HasMany $Documents
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Client get($primaryKey, $options = [])
 * @method \App\Model\Entity\Client newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Client[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Client|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Client|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Client patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Client[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Client findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClientsTable extends Table
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

        $this->setTable('clients');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Bornes', [
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('ClientContacts', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('ClientContact', [
            'joinTable' => 'client_contacts', 
            'joinType' => 'LEFT',
            'bindingKey' => 'client_id',
            'foreignKey' => 'id',
            'className' => 'ClientContacts',
        ]);
        $this->hasOne('MainContact', [ // utilisé dans création vente
            'className' => 'ClientContacts',
            'foreignKey' => 'client_id'
        ]);
        $this->hasMany('Documents', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'client_id'
        ]);

        $this->belongsTo('Users', [ // pour reconnaitre qui a crée le profil
            'foreignKey' => 'user_id'
        ]);

        $this->hasMany('Reglements', [
            'foreignKey' => 'client_id',
            'sort' => ['Reglements.id' => 'DESC']
        ]);

        $this->hasMany('Opportunites', [
            'foreignKey' => 'client_id',
            'sort' => ['Opportunites.id' => 'DESC']
        ]);

        $this->hasMany('Evenements', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('Ventes', [
            'foreignKey' => 'client_id'
        ]);
        
        $this->hasMany('Devis', [
            'foreignKey' => 'client_id',
            'sort' => ['Devis.indent' => 'DESC']
        ]);
        
        $this->hasMany('Avoirs', [
            'foreignKey' => 'client_id',
            'sort' => ['Avoirs.indent' => 'DESC']
        ]);
        
        $this->hasMany('DevisFactures', [
            'foreignKey' => 'client_id',
            'sort' => ['DevisFactures.indent' => 'DESC'],
            'conditions' => ['DevisFactures.is_situation <>' => 1],
        ]);
        
        $this->hasMany('DevisFactures2', [
            'className' => 'DevisFactures',
            'foreignKey' => 'client_id_2',
            'sort' => ['DevisFactures2.indent' => 'DESC'],
            'conditions' => ['DevisFactures2.is_situation <>' => 1],
        ]);
        
        $this->hasMany('ClientsAdresses', [
            'foreignKey' => 'client_id'
        ]);
        
        $this->hasMany('CommentairesClients', [
            'foreignKey' => 'client_id'
        ]);
        
        $this->belongsTo('GroupeClients', [
            'foreignKey' => 'groupe_client_id',
        ]);

        $this->belongsTo('Payss', [
            'foreignKey' => 'pays_id',
        ]);

//        $this->belongsTo('SecteursActivites', [
//            'foreignKey' => 'secteurs_activite_id',
//        ]);
        

        $this->belongsToMany('SecteursActivites', [
            'className' => 'SecteursActivites',
            'joinTable' => 'clients_has_secteurs_activites',
            'targetForeignKey' =>'secteurs_activite_id',
            'foreignKey' => 'client_id'
        ]);

        $this->belongsTo('GroupeClients', [
            'foreignKey' => 'groupe_client_id',
        ]);
        $this->belongsTo('SourceLeads', [
            'foreignKey' => 'source_lead_id',
            'joinType' => 'LEFT'
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            // ->requirePresence('nom', 'create')
            ->allowEmpty('nom');

        $validator
            ->scalar('prenom')
            ->maxLength('prenom', 255)
            ->allowEmpty('prenom');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->allowEmpty('adresse');

        $validator
            ->scalar('ville')
            ->maxLength('ville', 255)
            ->allowEmpty('ville');

        $validator
            ->scalar('cp')
            ->allowEmpty('cp');

        $validator
            ->scalar('telephone')
            ->allowEmpty('telephone');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('adresse_2')
            ->allowEmpty('adresse_2');

        $validator
            ->scalar('siren')
            ->maxLength('siren', 255)
            ->allowEmpty('siren');

        $validator
            ->scalar('siret')
            ->maxLength('siret', 255)
            ->allowEmpty('siret');

        $validator
            ->integer('id_in_sellsy')
            ->allowEmpty('id_in_sellsy');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 255)
            ->allowEmpty('mobile');

        $validator
            ->scalar('country')
            ->maxLength('country', 255)
            ->allowEmpty('country');

        return $validator;
    }

    /**
     * beforeSave callback
     *
     * @param $options array
     * @return boolean
     */
    public function beforeSave($event, $entity, $options) {
        if ($entity->isNew() == true) {
            $user_id = (new Session)->read('Auth.User.id');
            if ($user_id) {
                $entity->set('user_id', $user_id);
            }
        }
        
        if($entity->telephone) {
            $telephone = str_replace([" ", "."], ["", ""], $entity->telephone);
            $entity->set('telephone', $telephone);
        }

        $villesFrancesTable = TableRegistry::get('VillesFrances');
        $findedVille = $villesFrancesTable->findByVilleNom(strtoupper($entity->ville))->select(['ville_nom', 'ville_code_postal'])->first();
        if (!$findedVille) {
            // evite le ralentissement, ne pas utiliser les patch, save entity
            $villesFrancesTable->query()->insert(['ville_nom', 'ville_code_postal'])->values(['ville_nom' => $entity->ville, 'ville_code_postal' => $entity->cp])->execute();
        }
            
        return true;
    }
    

    public function findComplete(Query $query, array $options)
    {
        $query->contain([
            'Reglements' => 'MoyenReglements', 
            'CommentairesClients' => function ($query) {
                return $query->order(['CommentairesClients.created' => 'DESC']);
            }, 
            'ClientsAdresses' => 'Payss', 
            'Bornes', 
            'Documents', 
            'Users', 
            'GroupeClients',
            'Devis' => ['Antennes','Commercial', 'Clients'], 
            'DevisFactures' => ['Antennes','Commercial', 'Clients' ,'Client2', 'FactureReglements'], 
            'DevisFactures2' => ['Antennes','Commercial', 'Clients' ,'Client2', 'FactureReglements'], 
            'SecteursActivites', 
            'ClientContacts' => function ($q) {
                return $q->contain(['ContactTypes'])->where(['ClientContacts.nom >' => '']);
            }
        ])
        ;
        
        $query->where(['deleted <>' => 1]);
        $query->group('Clients.id');
        
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
        //$rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function findNomEnseigne(Query $query, array $options)
    {
        $query->find('list', ['valueField' => function ($e) {
            
            if($e->client_type == 'corporation') {
                return $e->enseigne ? $e->nom ." - ".$e->enseigne : $e->nom ;
            }
            return $e->prenom . " " . $e->nom;
        }]);
        return $query;
    }

    public function findCorporationList(Query $query, array $options)
    {
        $query->where(['client_type' => 'corporation'])->find('list');
        $query->where(['deleted <>' => 1]);
        return $query;
    }
    
    public function findFiltre(Query $query, array $options) {
        
        $search = isset($options['key'])?$options['key']:null;

        $searchContactKey = isset($options['contact_key'])?$options['contact_key']:null;
      
        if(!empty($search)){
            
            $ipos = stripos($search, '"');
            $rpos = strrpos($search, '"');
            $pos = strpos($search, '"');

            if ($pos !== false) {
                
                $search = str_replace('"', '', $search);
                if($pos == 0 && $ipos == $pos && $rpos == $pos) {

                    $query->where([
                        'OR' => [
                            ['Clients.nom LIKE' => "$search%"],
                            ['Clients.enseigne LIKE' => "$search%"],
                        ],
                    ])->group('Clients.id');
                } elseif ($pos > 0 && $ipos == $pos && $rpos == $pos) {

                    $query->where([
                        'OR' => [
                            ['Clients.nom LIKE' => "%$search"],
                            ['Clients.enseigne LIKE' => "%$search"],
                        ],
                    ])->group('Clients.id');
                } else {
                    
                    $query->where([
                        'OR' => [
                            ['Clients.nom LIKE' => "$search"],
                            ['Clients.enseigne LIKE' => "$search"],
                        ],
                    ])->group('Clients.id');
                }
                
            } else {
                $query->where([
                    'OR' => [
                        ['Clients.nom LIKE' => '%'.$search.'%'],
                        ['Clients.enseigne LIKE' => '%'.$search.'%'],
                    ],
                ])->group('Clients.id');
            }
        }

        if(!empty($searchContactKey)){
            $query->contain(['ClientContact']);
            $query->where([
                'OR' => [
                    ['ClientContact.nom LIKE' => '%'.$searchContactKey.'%'],
                    ['ClientContact.prenom LIKE' => '%'.$searchContactKey.'%'],
                    ['ClientContact.tel LIKE' => '%'.$searchContactKey.'%'],
                    ['ClientContact.email LIKE' => '%'.$searchContactKey.'%'],
                ],
            ])->group('Clients.id');
        }
        
        $commercial_id = isset($options['ref_commercial_id'])?$options['ref_commercial_id']:null;
        if($commercial_id) {
            
            $query->matching('Devis', function ($q) use($commercial_id){
                    return $q->where(['Devis.ref_commercial_id' => $commercial_id]);}
            );
        }
        
        $adresse  = isset($options['adresse_key'])?$options['adresse_key']:null;
        if(!empty($adresse)){
            if($adresse == 'non') {
                $query->where([
                    'OR' => [
                        ['Clients.cp is null'],
                        ['Clients.cp' => ''],
                        ['Clients.cp = ' => '0']
                    ]
                ]);
                $query->where([
                    'OR' => [
                        ['Clients.ville is null'],
                        ['Clients.ville' => '']
                    ]
                ]);
            }
            if($adresse == 'oui') {
                $query->where([
                    'OR' => [
                        ['Clients.cp is not null', 'Clients.cp <>' => ''],
                        ['Clients.ville is not null', 'Clients.ville <>' => '', 'Clients.ville !=' => '0'],
                    ]
                ]);
            }
        }
        
        $secteurs_activite  = isset($options['secteurs_activite'])?$options['secteurs_activite']:null;
        if(!empty($secteurs_activite)){
            $query->matching('SecteursActivites')->where(['SecteursActivites.id IN' => $secteurs_activite]);
        }
        
        $type  = isset($options['type'])?$options['type']:null;
        if(!empty($type)){
            $query->where(['Clients.client_type' => $type]);
        }
        
        $groupe_client_id = isset($options['groupe_client_id'])?$options['groupe_client_id']:null;
        if(!empty($groupe_client_id)) {
            $query->where(['groupe_client_id' => $groupe_client_id]);
        }

        $type_contrats = isset($options['type_contrats']) ? $options['type_contrats']['_ids'] : null;
        if ($type_contrats) {
            $params = [];
            foreach ($type_contrats as $type_contrat) {
                $params[] = [$type_contrat => 1];
            }
            $query->where(['OR' => $params]);
        }

        $type_commercial = isset($options['type_commercial']) ? $options['type_commercial'] : null;
        if ($type_commercial) {
            $query->where(['type_commercial' => $type_commercial]);
        }
        
        $sort = isset($options['sort']) ? $options['sort'] : null;
        $direction = isset($options['direction']) ? $options['direction'] : null;

        if($sort && $direction) {
            $query->order([$sort => $direction]);
        }
     
        $query->where(['deleted <>' => 1]);
        $query->group('Clients.id');
        
        return $query;
    }
}
