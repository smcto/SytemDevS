<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Opportunites Model
 *
 * @property \App\Model\Table\OpportuniteStatutsTable|\Cake\ORM\Association\BelongsTo $OpportuniteStatuts
 * @property \App\Model\Table\PipelinesTable|\Cake\ORM\Association\BelongsTo $Pipelines
 * @property \App\Model\Table\PipelineEtapesTable|\Cake\ORM\Association\BelongsTo $PipelineEtapes
 * @property \App\Model\Table\TypeClientsTable|\Cake\ORM\Association\BelongsTo $TypeClients
 * @property \App\Model\Table\SourceLeadsTable|\Cake\ORM\Association\BelongsTo $SourceLeads
 * @property \App\Model\Table\ContactRaisonsTable|\Cake\ORM\Association\BelongsTo $ContactRaisons
 * @property \App\Model\Table\TypeEvenementsTable|\Cake\ORM\Association\BelongsTo $TypeEvenements
 * @property \App\Model\Table\OpportuniteClientsTable|\Cake\ORM\Association\HasMany $OpportuniteClients
 *
 * @method \App\Model\Entity\Opportunite get($primaryKey, $options = [])
 * @method \App\Model\Entity\Opportunite newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Opportunite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Opportunite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Opportunite|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Opportunite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Opportunite[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Opportunite findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OpportunitesTable extends Table
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

        $this->setTable('opportunites');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('OpportuniteStatuts', [
            'foreignKey' => 'opportunite_statut_id'
        ]);
        $this->belongsTo('Pipelines', [
            'foreignKey' => 'pipeline_id'
        ]);
        $this->belongsTo('PipelineEtapes', [
            'foreignKey' => 'pipeline_etape_id'
        ]);
        $this->belongsTo('TypeClients', [
            'foreignKey' => 'type_client_id'
        ]);
        $this->belongsTo('SourceLeads', [
            'foreignKey' => 'source_lead_id'
        ]);
        $this->belongsTo('ContactRaisons', [
            'foreignKey' => 'contact_raison_id'
        ]);
        $this->belongsTo('TypeEvenements', [
            'foreignKey' => 'type_evenement_id'
        ]);
        $this->hasMany('OpportuniteClients', [
            'foreignKey' => 'opportunite_id'
        ]);
        $this->hasMany('LinkedDocs', [
            'foreignKey' => 'opportunite_id',
            'saveStrategy' => 'replace'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id'
        ]);
        $this->belongsToMany('Staffs', [
            'className' => 'Staffs',
            'joinTable' => 'opportunite_staffs',
            'targetForeignKey' =>'staff_id',
            'foreignKey' => 'opportunite_id'
        ]);
        $this->belongsToMany('Users', [
            'className' => 'Users',
            'joinTable' => 'opportunite_users',
            'targetForeignKey' =>'user_id',
            'foreignKey' => 'opportunite_id'
        ]);
        $this->hasMany('OpportuniteCommentaires', [
            'foreignKey' => 'opportunite_id',
        ]);
        $this->belongsTo('OpportuniteTypeBornes', [
            'foreignKey' => 'opportunite_type_borne_id'
        ]);
        $this->belongsTo('Evenements', [
            'foreignKey' => 'evenement_id'
        ]);
        $this->belongsTo('OptionFondVerts', [
            'foreignKey' => 'option_fond_vert_id'
        ]);
        $this->belongsTo('BesionBornes', [
            'foreignKey' => 'besion_borne_id'
        ]);
        $this->hasMany('OpportuniteTags', [
            'foreignKey' => 'opportunite_id',
        ]);
        $this->hasMany('OpportuniteTimelines', [
            'foreignKey' => 'opportunite_id',
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
            ->integer('id_in_sellsy')
            ->allowEmpty('id_in_sellsy');

        $validator
            ->scalar('numero')
            ->maxLength('numero', 250)
            ->requirePresence('numero', 'create');
            //->notEmpty('numero');

        $validator
            ->scalar('nom')
            ->maxLength('nom', 500)
            ->requirePresence('nom', 'create');
            //->notEmpty('nom');

        $validator
            ->decimal('montant_potentiel')
            ->allowEmpty('montant_potentiel');

        $validator
            ->date('date_echeance')
            ->allowEmpty('date_echeance');

        $validator
            ->decimal('probabilite')
            ->allowEmpty('probabilite');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

        $validator
            ->scalar('brief')
            ->allowEmpty('brief');

        $validator
            ->scalar('type_demande')
            ->allowEmpty('type_demande');

        $validator
            ->scalar('antenne_retrait')
            ->maxLength('antenne_retrait', 500)
            ->allowEmpty('antenne_retrait');

        $validator
            ->scalar('antenne_retrait_secondaire')
            ->maxLength('antenne_retrait_secondaire', 500)
            ->allowEmpty('antenne_retrait_secondaire');

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
        $rules->add($rules->existsIn(['opportunite_statut_id'], 'OpportuniteStatuts'));
        $rules->add($rules->existsIn(['pipeline_id'], 'Pipelines'));
        $rules->add($rules->existsIn(['pipeline_etape_id'], 'PipelineEtapes'));
        $rules->add($rules->existsIn(['type_client_id'], 'TypeClients'));
        $rules->add($rules->existsIn(['source_lead_id'], 'SourceLeads'));
        $rules->add($rules->existsIn(['contact_raison_id'], 'ContactRaisons'));
        $rules->add($rules->existsIn(['type_evenement_id'], 'TypeEvenements'));
        $rules->add($rules->existsIn(['cient_id'], 'Clients'));

        return $rules;
    }
    public function findFiltre(Query $query, array $option) {


        if(!empty($option['keyword'])){
            $query->where(['OR' => [
                    'Opportunites.id_in_sellsy' => $option['keyword'],
                    'Opportunites.numero LIKE' => '%'.$option['keyword'].'%',
                    'Opportunites.nom LIKE' => '%'.$option['keyword'].'%',
                    'Opportunites.brief LIKE' => '%'.$option['keyword'].'%',
                    'Opportunites.antenne_retrait LIKE' => '%'.$option['keyword'].'%',
                    'Opportunites.antenne_retrait_secondaire LIKE' => '%'.$option['keyword'].'%',
                    'Opportunites.montant_potentiel LIKE' => '%'.$option['keyword'].'%',
                    'Opportunites.probabilite LIKE' => '%'.$option['keyword'].'%'
                ]
            ])->leftJoinWith('Clients', function ($q) use ($option) {
                return $q->where(['OR'=>[
                    'Clients.nom LIKE' => '%'.$option['keyword'].'%',
                    'Clients.prenom LIKE' => '%'.$option['keyword'].'%',
                ]]);
            });

        }

        if(!empty($option['opportunite_statut_id'])){
            $query->where(['Opportunites.opportunite_statut_id' =>$option['opportunite_statut_id']]);
        }

        if(!empty($option['pipeline_id'])){
            $query->where(['Opportunites.pipeline_id' =>$option['pipeline_id']]);
        }

        if(!empty($option['pipeline_etape_id'])){
            $query->where(['Opportunites.pipeline_etape_id' =>$option['pipeline_etape_id']]);
        }

        if(!empty($option['type_demande'])){
            $query->where(['Opportunites.type_demande' =>$option['type_demande']]);
        }

        if(!empty($option['type_client_id'])){
            $query->where(['Opportunites.type_client_id' =>$option['type_client_id']]);
        }

        if(!empty($option['type_evenement_id'])){
            $query->where(['Opportunites.type_evenement_id' =>$option['type_evenement_id']]);
        }

        if(!empty($option['staff_id'])){
            $query->matching('Staffs', function ($q) use ($option)  {
                return $q->where(['Staffs.id' => $option['staff_id']]);
            });
        }

        if(!empty($option['user_id'])){
            $query->matching('Users', function ($q) use ($option)  {
                return $q->where(['Users.id' => $option['user_id']]);
            });
        }

        

        return $query;
    }
}
