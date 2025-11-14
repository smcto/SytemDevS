<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contacts Model
 *
 * @property \App\Model\Table\StatutsTable|\Cake\ORM\Association\BelongsTo $Statuts
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 * @property \App\Model\Table\SituationsTable|\Cake\ORM\Association\BelongsTo $Situations
 * @property \App\Model\Table\CountrysTable|\Cake\ORM\Association\BelongsTo $Countrys
 *
 * @method \App\Model\Entity\Contact get($primaryKey, $options = [])
 * @method \App\Model\Entity\Contact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Contact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Contact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contact|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Contact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Contact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Contact findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactsTable extends Table
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

        $this->setTable('contacts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Statuts', [
            'foreignKey' => 'statut_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id'
        ]);
        $this->belongsTo('Situations', [
            'foreignKey' => 'situation_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsTo('Countrys', [
            'foreignKey' => 'country_id'
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
            ->allowEmpty('nom');

        $validator
            ->scalar('prenom')
            ->maxLength('prenom', 255)
            ->allowEmpty('prenom');

        $validator
            ->scalar('telephone_portable');
            /*->maxLength('telephone_portable', 255)
            ->allowEmpty('telephone_portable');*/

        $validator
            ->add('telephone_portable', 'validFormat', [
                'rule' => function ($value, $context) {
                    $phonecode = $context['data']['phonecode'];
                    //$num = "#^\+".$phonecode."[1-9][0-9]{8}$#";
                    //debug($value);die;
                    $res = false;
                    if (preg_match("#^\\".$phonecode."[1-9][0-9]{8}$#", $value)){
                        $res = true ;
                    }
                    //debug($res);die;
                    return $res;
                },
                'message' => 'Numero téléphone invalide'
            ]);

        $validator
            ->add('telephone_fixe', 'validFormat', [
                'rule' => function ($value, $context) {
                    $phonecode = $context['data']['phonecode'];
                    //$num = "#^\+".$phonecode."[1-9][0-9]{8}$#";
                    //debug($value);die;
                    $res = false;
                    if (preg_match("#^\\".$phonecode."[1-9][0-9]{8}$#", $value)){
                        $res = true ;
                    }
                    //debug($res);die;
                    return $res;
                },
                'message' => 'Numero téléphone invalide'
            ]);

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->date('date_naissance')
            ->allowEmpty('date_naissance');

        $validator
            ->scalar('info_a_savoir')
            ->allowEmpty('info_a_savoir');

        $validator
            ->scalar('mode_renumeration')
            ->allowEmpty('mode_renumeration');

        $validator
            ->boolean('is_vehicule')
            ->allowEmpty('is_vehicule');

        $validator
            ->scalar('modele_vehicule')
            ->maxLength('modele_vehicule', 255)
            ->allowEmpty('modele_vehicule');

        $validator
            ->integer('nbr_borne_transportable_vehicule')
            ->allowEmpty('nbr_borne_transportable_vehicule');

        $validator
            ->scalar('commentaire_vehicule')
            ->allowEmpty('commentaire_vehicule');

        $validator
            ->scalar('photo_nom')
            ->maxLength('photo_nom', 45)
            ->allowEmpty('photo_nom');

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
        //$rules->add($rules->isUnique(['email']));
        /*$rules->add($rules->existsIn(['statut_id'], 'Statuts'));
        $rules->add($rules->existsIn(['antenne_id'], 'Antennes'));
        $rules->add($rules->existsIn(['situation_id'], 'Situations'));*/

        return $rules;
    }

    public function findFiltre(Query $query, array $options) {

        $search = $options['key'];

        if(!empty($search)){
            $query->where(['nom LIKE' => '%'.$search.'%'], ['nom' => 'string']);
        }

        $statut = $options['statut'];
        if(!empty($statut)){
            $query->where(['Contacts.statut_id'=>$statut]);
        }

        $antenne = $options['antenne'];
        if(!empty($antenne)){
            $query->where(['Contacts.antenne_id'=>$antenne]);
        }


        return $query;
    }
}
