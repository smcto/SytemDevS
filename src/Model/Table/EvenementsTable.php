<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Evenements Model
 *
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\TypeEvenementsTable|\Cake\ORM\Association\BelongsTo $TypeEvenements
 * @property \App\Model\Table\AntennesTable|\Cake\ORM\Association\BelongsTo $Antennes
 * @property \App\Model\Table\DateEvenementsTable|\Cake\ORM\Association\HasMany $DateEvenements
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\BelongsTo $Bornes
 *
 * @method \App\Model\Entity\Evenement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Evenement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Evenement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Evenement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Evenement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Evenement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Evenement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Evenement findOrCreate($search, callable $callback = null, $options = [])
 */
class EvenementsTable extends Table
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

        $this->setTable('evenements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TypeInstallations', [
			'className' => 'Evenements.TypeInstallations',
			'propertyName' => 'Installation',
            'foreignKey' => 'type_installation',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeInstallations', [
			'className' => 'Evenements.TypeInstallations',
			'propertyName' => 'Desinstallation',
            'foreignKey' => 'desinstallation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeEvenements', [
            'foreignKey' => 'type_evenement_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('NatureEvenements', [
            'foreignKey' => 'nature_evenement_id',
            //'joinType' => 'INNER'
        ]);
        $this->belongsTo('TypeAnimations', [
            'foreignKey' => 'type_animation_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Antennes', [
            'foreignKey' => 'antenne_id',
            'joinType' => 'INNER'
        ]);

		$this->hasOne('EvenementBriefs',[
			'foreignKey' => 'evenement_id',
			'dependent' => true
		]);
		
        $this->hasMany('DateEvenements', [
            'foreignKey' => 'evenement_id'
        ]);

        $this->hasMany('EvenementBornes', [
            'foreignKey' => 'evenement_id'
        ]);

        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsToMany('Documents', [
            'className' => 'Documents',
            'joinTable' => 'evenement_documents',
            'targetForeignKey' =>'document_id',
            'foreignKey' => 'evenement_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsToMany('Contacts', [
            'className' => 'Users',
            'through' => 'EvenementsHasContacts',
            'joinTable' => 'evenements_has_contacts',
            'foreignKey' =>'evenement_id',
            'targetForeignKey' => 'user_id',
            'conditions' => ['EvenementsHasContacts.is_responsable' => false]
        ]);

        $this->belongsToMany('Responsables', [
            'className' => 'Users',
            'through' => 'EvenementsHasContacts',
            'joinTable' => 'evenements_has_contacts',
            'foreignKey' =>'evenement_id',
            'targetForeignKey' => 'user_id',
            'conditions' => ['EvenementsHasContacts.is_responsable' => true]
        ]);

        $this->belongsTo('Bornes', [
            'foreignKey' => 'borne_id',
            //'joinType' => 'INNER'
        ]);
        $this->belongsTo('OptionFondVerts', [
            'foreignKey' => 'option_fond_vert_id'
        ]);
        $this->belongsTo('BesionBornes', [
            'foreignKey' => 'besion_borne_id'
        ]);
         $this->belongsTo('OpportuniteTypeBornes', [
            'foreignKey' => 'opportunite_type_borne_id'
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
            ->scalar('nom_event')
            ->maxLength('nom_event', 255)
            ->allowEmpty('nom_event');

        $validator
            ->scalar('lieu_exact')
            ->maxLength('lieu_exact', 255)
            ->allowEmpty('lieu_exact');

        $validator
            ->date('date_debut_immobilisation')
            ->allowEmpty('date_debut_immobilisation');

        $validator
            ->date('date_fin_immobilisation')
            ->allowEmpty('date_fin_immobilisation');

        $validator
            ->scalar('type_installation')
            ->maxLength('type_installation', 255)
            ->allowEmpty('type_installation');

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
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['type_evenement_id'], 'TypeEvenements'));
        $rules->add($rules->existsIn(['antenne_id'], 'Antennes'));

        return $rules;
    }

    public function findFiltre(Query $query, array $options) {

        $search = $options['key'];

        if(!empty($search)){
            $query->where(['nom_event LIKE' => '%'.$search.'%'], ['nom_event' => 'string']);
        }

        $antenne = $options['antenne'];
        if(!empty($antenne)){
            $query->where(['Evenements.antenne_id'=>$antenne]);
        }

        $type_evenement = $options['type_evenement'];
        if(!empty($type_evenement)){
            $query->where(['Evenements.type_evenement_id'=>$type_evenement]);
        }

        $type_animation = $options['type_animation'];
        if(!empty($type_animation)){
            $query->where(['Evenements.type_animation_id'=>$type_animation]);
        }

        $type_client = $options['type_client'];
        if(!empty($type_client)){
            $query->contain('Clients', function ($q) use($type_client) {
                return $q->where(['Clients.client_type IN' => $type_client]);
            });
        }

        $periodeType = $options['periodeType'];
        if(!empty($periodeType)){
            $periodeType = explode('_', $periodeType);
            if($periodeType['0'] == "w"){

                $query->matching('DateEvenements', function ($q) use($periodeType) {
                    return $q->where(['WEEK(DateEvenements.date_debut)'=> $periodeType['1'], 'WEEK(DateEvenements.date_fin)'=> $periodeType['1']]);
                });

            } elseif($periodeType['0'] == "m"){
                $query->matching('DateEvenements', function ($q) use($periodeType) {
                    return $q->where(['MONTH(DateEvenements.date_debut)'=> $periodeType['1'], 'MONTH(DateEvenements.date_fin)'=> $periodeType['1']]);
                });

            }
        }

        /*$numero_borne = $options['numero_borne'];
        if(!empty($numero_borne)){
            $query->contain('Bornes', function ($q) use($numero_borne) {
                return $q->where(['Bornes.numero' => $numero_borne]);
            });
        }*/

        $numero_borne = $options['numero_borne'];
        if(!empty($numero_borne)){
            $query->innerJoinWith('Bornes', function ($q) use($numero_borne) {
                return $q->where(['Bornes.numero' => $numero_borne]);
            });
        }

        //debug($query);die;

        return $query;
    }
}
