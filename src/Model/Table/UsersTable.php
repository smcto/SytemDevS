<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

/**
 * Users Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 * @property \App\Model\Table\FournisseursTable|\Cake\ORM\Association\BelongsTo $Fournisseurs
 * @property \App\Model\Table\UserTypeProfilsTable|\Cake\ORM\Association\HasMany $UserTypeProfils
 * @property \App\Model\Table\ContactsTable|\Cake\ORM\Association\HasMany $Contacts
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsTo('Fournisseurs', [
            'foreignKey' => 'fournisseur_id'
        ]);
        $this->hasMany('UserTypeProfils', [
            'foreignKey' => 'user_id'
        ]);

        $this->hasMany('Contacts', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Profils', [
            'className' => 'TypeProfils',
            'through' => 'UserTypeProfils',
            'joinTable' => 'user_type_profils',
            'targetForeignKey' =>'type_profil_id',
            'foreignKey' => 'user_id'
        ]);

        $this->hasMany('Factures', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsTo('Statuts', [
            'foreignKey' => 'statut_id',
        ]);

        $this->belongsTo('Situations', [
            'foreignKey' => 'situation_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Countrys', [
            'foreignKey' => 'country_id'
        ]);

        $this->belongsTo('Payss', [
            'foreignKey' => 'pays_id'
        ]);

        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
        ]);

        $this->hasMany('UserHasAntennes', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        /*$this->hasOne('Imaps', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT'
        ]);*/

        $this->belongsToMany('AntennesRattachees', [
            'className' => 'Antennes',
            'through' => 'UserHasAntennes',
            'joinTable' => 'user_has_antennes',
            'targetForeignKey' =>'antenne_id',
            'foreignKey' => 'user_id'
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
            ->email('email')
            /*->requirePresence('email', 'create')
            ->notEmpty('email')*/;

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        /*$validator
            ->add('telephone_portable', 'validFormat', [
                'rule' => function ($value, $context) {
                    $phonecode = isset($context['data']['phonecode']) ? $context['data']['phonecode'] : '';
                    $res = false;
                    if (preg_match("#^\\".$phonecode."[1-9][0-9]{8}$#", $value)){ // exemple [+32]123456789
                        $res = true ;
                    }
                    //debug($res);die;
                    return $res;
                },
                'message' => 'Numero téléphone invalide'
            ]);*/

        /*$validator
            ->scalar('telephone_fixe')
            ->allowEmpty('telephone_fixe')
            ->add('telephone_fixe', 'validFormat', [
                'rule' => function ($value, $context) {
                    $phonecode = $context['data']['phonecode'];
                    //debug($value);die;
                    $res = false;
                    if (preg_match("#^\\".$phonecode."[1-9][0-9]{8}$#", $value)){ // exemple [+32]123456789
                        $res = true ;
                    }
                    //debug($res);die;
                    return $res;
                },
                'message' => 'Numero téléphone invalide'
            ]);*/

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['antenne_id'], 'Antennes'));
        $rules->add($rules->existsIn(['fournisseur_id'], 'Fournisseurs'));

        return $rules;
    }

    public function findCommercial(Query $query, array $options)
    {
        $query->find('filtre', ['group_user' => 3])->find('list', ['valueField' => 'full_name'])->where(['toujours_present' => 1]); // profile Konitys Commercial
        return $query;
    }

    public function findFiltre(Query $query, array $options) {


        $search = isset($options['key']) ? $options['key'] : [];
        $typeprofil = isset($options['typeProfil']) ? $options['typeProfil'] : [];
        $antenne = isset($options['antenne']) ? $options['antenne'] : [];
        $group_user = isset($options['group_user']) ? $options['group_user'] : [];

        $typeProfilKonitys = Configure::read('typeProfilKonitys');
        
        if(!empty($group_user)) {
            if($group_user == 1) {
                $query->matching('Profils', function ($q) use ($typeProfilKonitys) {
                    return $q->where(['Profils.id NOT IN' => $typeProfilKonitys]);
                });
                //debug($query->toArray());die;
            } else if($group_user == 2) {
                $query->matching('Profils', function ($q) use ($typeProfilKonitys) {
                    return $q->where(['Profils.id IN' => $typeProfilKonitys]);
                });
            } else if($group_user == 3) { // Profil Commercial
                $query->matching('Profils', function ($q) use ($typeProfilKonitys) {
                    return $q->where(['Profils.id IN' => [11]]);
                });
            } else if($group_user == 4) { // Profil Konitys compta
                $query->matching('Profils', function ($q) use ($typeProfilKonitys) {
                    return $q->where(['Profils.id IN' => [12]]);
                });
            } else {
                return $query;
            }
        }

        if(!empty($search)){
            $query->where(['Users.nom LIKE' => '%'.$search.'%'])->orWhere(['Users.prenom LIKE' => '%'.$search.'%']);
        }


        if(!empty($typeprofil)){
            $query->matching('Profils', function ($q) use ($typeprofil){
                return $q->where(['Profils.id' => $typeprofil]);
            });
        }

        if(!empty($antenne)){
            //$query->where(['Users.antenne_id ' => $antenne]);
            $query->matching('AntennesRattachees', function ($q) use ($antenne){
                return $q->where(['AntennesRattachees.id IN'=>$antenne]);
            });
        }

        return $query;
    }

    public function findLikeName(Query $query, array $options)
    {
        $term = $options['term'];
        $query->where(function ($exp, $q) use($term) {
            $concat = $q->func()->concat([
                'nom' => 'literal', ' ', 'prenom' => 'literal'
            ]);
            // return $exp->like($concat, $term);
            return $exp->like($concat, '%'.$term.'%');
        });
        return $query;
    }

    public function findFiltreOld(Query $query, array $options) {

        $search = $options['key'];
        $typeprofil = $options['typeProfil'];
        $antenne = $options['antenne'];

        $query->innerJoinWith('Contacts');

        if(!empty($search)){
            $query->contain('Contacts', function ($q) use ($search){
                return $q->where(['Contacts.nom LIKE' => '%'.$search.'%'])->orWhere(['Contacts.prenom LIKE' => '%'.$search.'%']);
            });
        }

        if(!empty($typeprofil)){
            $query->matching('Profils', function ($q) use ($typeprofil){
                return $q->where(['Profils.id' => $typeprofil]);
            });
        }

        if(!empty($antenne)){
            $query->contain('Contacts', function ($q) use ($antenne){
                return $q->where(['Contacts.antenne_id ' => $antenne]);
            });
        }

        return $query;
    }
}
