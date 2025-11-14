<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EvenementBriefs Model
 *
 * @property \App\Model\Table\EvenementsTable|\Cake\ORM\Association\BelongsTo $Evenements
 *
 * @method \App\Model\Entity\EvenementBrief get($primaryKey, $options = [])
 * @method \App\Model\Entity\EvenementBrief newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EvenementBrief[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EvenementBrief|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EvenementBrief|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EvenementBrief patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EvenementBrief[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EvenementBrief findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EvenementBriefsTable extends Table
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

        $this->setTable('evenement_briefs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Evenements', [
            'foreignKey' => 'evenement_id',
            'joinType' => 'INNER'
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
            ->scalar('adresse_exact')
            ->maxLength('adresse_exact', 100)
            ->requirePresence('adresse_exact', 'create')
            ->notEmpty('adresse_exact');

        $validator
            ->scalar('batiment')
            ->maxLength('batiment', 50)
            ->requirePresence('batiment', 'create')
            ->notEmpty('batiment');

        $validator
            ->scalar('num_voie')
            ->maxLength('num_voie', 8)
            ->requirePresence('num_voie', 'create')
            ->notEmpty('num_voie');

        $validator
            ->scalar('code_postal')
            ->maxLength('code_postal', 15)
            ->requirePresence('code_postal', 'create')
            ->notEmpty('code_postal');

        $validator
            ->scalar('rue')
            ->maxLength('rue', 100)
            ->requirePresence('rue', 'create')
            ->notEmpty('rue');

        $validator
            ->requirePresence('acces', 'create')
            ->notEmpty('acces');

        $validator
            ->requirePresence('acces_modalite', 'create')
            ->notEmpty('acces_modalite');

        $validator
            ->scalar('contact_sp')
            ->maxLength('contact_sp', 20)
            ->requirePresence('contact_sp', 'create')
            ->notEmpty('contact_sp');

        $validator
            ->scalar('nom_sp')
            ->maxLength('nom_sp', 100)
            ->requirePresence('nom_sp', 'create')
            ->notEmpty('nom_sp');

        $validator
            ->integer('prenom_sp')
            ->requirePresence('prenom_sp', 'create')
            ->notEmpty('prenom_sp');

        $validator
            ->integer('nb_personnes')
            ->requirePresence('nb_personnes', 'create')
            ->notEmpty('nb_personnes');

        $validator
            ->scalar('horaire_debut')
            ->maxLength('horaire_debut', 8)
            ->requirePresence('horaire_debut', 'create')
            ->notEmpty('horaire_debut');

        $validator
            ->integer('horaire_fin')
            ->requirePresence('horaire_fin', 'create')
            ->notEmpty('horaire_fin');

        $validator
            ->dateTime('date_installation')
            ->requirePresence('date_installation', 'create')
            ->notEmpty('date_installation');

        $validator
            ->dateTime('date_desinstallation')
            ->requirePresence('date_desinstallation', 'create')
            ->notEmpty('date_desinstallation');

        $validator
            ->scalar('disposition_borne')
            ->maxLength('disposition_borne', 20)
            ->requirePresence('disposition_borne', 'create')
            ->notEmpty('disposition_borne');

        $validator
            ->integer('distance_borne_prise')
            ->requirePresence('distance_borne_prise', 'create')
            ->notEmpty('distance_borne_prise');

        $validator
            ->dateTime('date_retrait_ant_locale')
            ->requirePresence('date_retrait_ant_locale', 'create')
            ->notEmpty('date_retrait_ant_locale');

        $validator
            ->dateTime('date_retour_antenne_locale')
            ->requirePresence('date_retour_antenne_locale', 'create')
            ->notEmpty('date_retour_antenne_locale');

        $validator
            ->scalar('mail_nom_wifi')
            ->maxLength('mail_nom_wifi', 120)
            ->requirePresence('mail_nom_wifi', 'create')
            ->notEmpty('mail_nom_wifi');

        $validator
            ->scalar('mail_code_wifi')
            ->maxLength('mail_code_wifi', 120)
            ->requirePresence('mail_code_wifi', 'create')
            ->notEmpty('mail_code_wifi');

        $validator
            ->scalar('mail_expediteur')
            ->maxLength('mail_expediteur', 120)
            ->requirePresence('mail_expediteur', 'create')
            ->notEmpty('mail_expediteur');

        $validator
            ->scalar('mail_objet')
            ->maxLength('mail_objet', 120)
            ->requirePresence('mail_objet', 'create')
            ->notEmpty('mail_objet');

        $validator
            ->scalar('mail_message')
            ->maxLength('mail_message', 4294967295)
            ->requirePresence('mail_message', 'create')
            ->notEmpty('mail_message');

        $validator
            ->allowEmpty('form_check');

        $validator
            ->scalar('form_text')
            ->maxLength('form_text', 4294967295)
            ->allowEmpty('form_text');

        $validator
            ->scalar('fb_nom_page')
            ->maxLength('fb_nom_page', 120)
            ->requirePresence('fb_nom_page', 'create')
            ->notEmpty('fb_nom_page');

        $validator
            ->scalar('fb_titre_album')
            ->maxLength('fb_titre_album', 120)
            ->requirePresence('fb_titre_album', 'create')
            ->notEmpty('fb_titre_album');

        $validator
            ->scalar('fb_description_album')
            ->maxLength('fb_description_album', 4294967295)
            ->requirePresence('fb_description_album', 'create')
            ->notEmpty('fb_description_album');

        $validator
            ->scalar('fb_admin')
            ->maxLength('fb_admin', 120)
            ->requirePresence('fb_admin', 'create')
            ->notEmpty('fb_admin');

        $validator
            ->scalar('animation_horaire')
            ->maxLength('animation_horaire', 8)
            ->requirePresence('animation_horaire', 'create')
            ->notEmpty('animation_horaire');

        $validator
            ->scalar('animation_tenue_souhaite')
            ->maxLength('animation_tenue_souhaite', 200)
            ->requirePresence('animation_tenue_souhaite', 'create')
            ->notEmpty('animation_tenue_souhaite');

        $validator
            ->scalar('animation_objectifs')
            ->maxLength('animation_objectifs', 4294967295)
            ->requirePresence('animation_objectifs', 'create')
            ->notEmpty('animation_objectifs');

        $validator
            ->requirePresence('derniere_etape', 'create')
            ->notEmpty('derniere_etape');

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
        $rules->add($rules->existsIn(['evenement_id'], 'Evenements'));

        return $rules;
    }
}
