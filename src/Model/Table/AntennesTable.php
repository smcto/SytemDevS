<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Antennes Model
 *
 * @property \App\Model\Table\LieuTypesTable|\Cake\ORM\Association\BelongsTo $LieuTypes
 * @property \App\Model\Table\EtatsTable|\Cake\ORM\Association\BelongsTo $Etats
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\HasMany $Bornes
 * @property \App\Model\Table\ContactsTable|\Cake\ORM\Association\HasMany $Contacts
 * @property \App\Model\Table\FournisseursTable|\Cake\ORM\Association\HasMany $Fournisseurs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\Antenne get($primaryKey, $options = [])
 * @method \App\Model\Entity\Antenne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Antenne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Antenne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Antenne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Antenne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Antenne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Antenne findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AntennesTable extends Table
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

        $this->setTable('antennes');
        $this->setDisplayField('ville_principale');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LieuTypes', [
            'foreignKey' => 'lieu_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Etats', [
            'foreignKey' => 'etat_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('DebitInternets', [
            'foreignKey' => 'debit_internet_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Bornes', [
            'foreignKey' => 'antenne_id'
        ]);
        $this->hasMany('Fournisseurs', [
            'foreignKey' => 'antenne_id'
        ]);
        
        $this->hasMany('LotProduits', [
            'foreignKey' => 'antenne_id'
        ]);
        
//        $this->hasMany('Users', [
//            'foreignKey' => 'antenne_id'
//        ]);
        $this->hasMany('Evenements', [
            'foreignKey' => 'antenne_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Fichiers', [
            'foreignKey' => 'antenne_id'
        ]);
        $this->hasMany('Responsables', [
            'className' => 'Contacts',
            'foreignKey' => 'antenne_id',
            'conditions' => ['statut_id'=>1]
        ]);
        $this->hasMany('Contacts', [
            'foreignKey' => 'antenne_id'
        ]);
        $this->hasMany('UserHasAntennes', [
            'foreignKey' => 'antenne_id'
        ]);

        $this->belongsToMany('Users', [
            'className' => 'Users',
            'through' => 'UserHasAntennes',
            'joinTable' => 'user_has_antennes',
            'targetForeignKey' =>'user_id',
            'foreignKey' => 'antenne_id'
        ]);

        $this->hasMany('StockAntennes', [
            'foreignKey' => 'antenne_id'
        ]);
        
        $this->hasMany('DocumentsAntennes', [
            'foreignKey' => 'antenne_id'
        ]);


        $this->belongsTo('Payss', [
            'foreignKey' => 'pays_id'
        ]);

        $this->belongsTo('ParentAntennes', [
            'className' => 'Antennes',
            'foreignKey' => 'antenne_id'
        ]);

         $this->belongsTo('SecteurGeographiques', [
            'foreignKey' => 'secteur_geographique_id'
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
            ->scalar('ville_principale')
            ->maxLength('ville_principale', 45)
            ->notEmpty('ville_principale');

        $validator
            ->scalar('ville_excate')
            ->maxLength('ville_excate', 255)
            ->allowEmpty('ville_excate');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->notEmpty('adresse');

        $validator
            ->scalar('cp')
            ->allowEmpty('cp');

        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 255)
            ->allowEmpty('longitude');

        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 255)
            ->allowEmpty('latitude');

        $validator
            ->scalar('horaire_accueil')
            ->allowEmpty('horaire_accueil');

        $validator
            ->scalar('horaire_dispos')
            ->allowEmpty('horaire_dispos');

        $validator
            ->scalar('photo_lieu')
            ->allowEmpty('photo_lieu');

        $validator
            ->scalar('precision_lieu')
            ->allowEmpty('precision_lieu');

        $validator
            ->scalar('commentaire')
            ->allowEmpty('commentaire');

        $validator
            ->scalar('etat_id')
            ->maxLength('etat_id', 255)
            ->notEmpty('etat_id');

        $validator
            ->scalar('lieu_type_id')
            ->maxLength('lieu_type_id', 255)
            ->notEmpty('lieu_type_id');

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
        $rules->add($rules->existsIn(['lieu_type_id'], 'LieuTypes'));
        $rules->add($rules->existsIn(['etat_id'], 'Etats'));

        return $rules;
    }

    public function findListByCity(Query $query, array $options)
    {
        $query->find('list', ['valueField' => 'ville_principale'])->order(['ville_principale' => 'asc'])->where(['is_deleted' => false]);
        return $query;
    }

    public function findFiltre(Query $query, array $options) {

        $query->where(['Antennes.is_deleted' =>false]);

        $search = isset($options['key'])?$options['key']:null;
        $etat = isset($options['etat'])?$options['etat']:null;
        $ville_principale = isset($options['ville_principale'])?$options['ville_principale']:null;
        $fondvert = isset($options['fondvert'])?$options['fondvert']:null;
        $sous_antenne = isset($options['sous_antenne'])?$options['sous_antenne']:null;

        if(!empty($search)){
            $query->contain('Contacts', function ($q) use ($search){
                return $q->where(['OR' => ['Contacts.nom LIKE' => '%'.$search.'%','Contacts.prenom LIKE' => '%'.$search.'%']]);
            });
            $query->where(['OR' => ['Antennes.ville_principale LIKE' => '%'.$search.'%','Antennes.ville_excate LIKE' => '%'.$search.'%']]);
        }

        if(!empty($ville_principale)){
            $query->where(['Antennes.ville_principale LIKE ' =>$ville_principale]);
            //$query->where(['Antennes.id = ' =>$ville_principale]);
        }

        if(!empty($etat)){
            $query->where(['Antennes.etat_id' =>$etat]);
        }
        
        if(!empty($sous_antenne)){
            if($sous_antenne == 1){
                $query->where(['Antennes.sous_antenne' => 1]);
            }else{
                $query->where(['Antennes.sous_antenne <>' => 1]);
            }
        }

        if(!empty($fondvert)){
            if($fondvert == "1"){
                $fond_vert = NULL;
            } else {
                $fond_vert = true;
            }
            $query->where(['Antennes.fond_vert IS' =>$fond_vert]);
        }

        return $query;
    }
}
