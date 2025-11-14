<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DateEvenements Model
 *
 * @property \App\Model\Table\EvenementsTable|\Cake\ORM\Association\BelongsTo $Evenements
 *
 * @method \App\Model\Entity\DateEvenement get($primaryKey, $options = [])
 * @method \App\Model\Entity\DateEvenement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DateEvenement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DateEvenement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DateEvenement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DateEvenement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DateEvenement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DateEvenement findOrCreate($search, callable $callback = null, $options = [])
 */
class DateEvenementsTable extends Table
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

        $this->setTable('date_evenements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->date('date_debut')
            ->allowEmpty('date_debut');

        $validator
            ->date('date_fin')
            ->allowEmpty('date_fin');

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

    public function findFiltre(Query $query, array $options) {

        $search = $options['key'];
        $type_client = $options['type_client'];
        $antenne = $options['antenne'];
        $type_evenement = $options['type_evenement'];
        $type_animation = $options['type_animation'];

        //$query = $this->find()->select(['id']);
        $query->where(['DateEvenements.date_debut IS NOT'=> NULL, 'DateEvenements.date_fin IS NOT'=> NULL]);
        if(!empty($search)){
            $query->contain('Evenements', function ($q) use ($search){
                return $q->where(['Evenements.nom_event LIKE' => '%'.$search.'%'])->where(['Evenements.lieu_exact LIKE' => '%'.$search.'%']);
            });
            /*$query->contain('Evenements.Clients', function ($q) use ($search){
                return $q->where(['Clients.nom LIKE' => '%'.$search.'%'])->orWhere(['Clients.prenom LIKE' => '%'.$search.'%']);
            });
            $query->contain('Evenements.Antennes', function ($q) use ($search){
                return $q->where(['Antennes.ville_principale LIKE' => '%'.$search.'%']);
            });*/
        }

        if(!empty($type_evenement)){
            $query->contain('Evenements', function ($q) use ($type_evenement){
                return $q->where(['Evenements.type_evenement_id ' => $type_evenement]);
            });
        }

        if(!empty($type_animation)){
            $query->contain('Evenements', function ($q) use ($type_animation){
                return $q->where(['Evenements.type_animation_id ' => $type_animation]);
            });
        }

        if(!empty($type_client)){
            $query->matching('Evenements.Clients', function ($q) use ($type_client){
                return $q->where(['Clients.client_type ' => $type_client]);
            });
        }

        if(!empty($antenne)){
            $query->contain('Evenements', function ($q) use ($antenne){
                return $q->where(['Evenements.antenne_id ' => $antenne]);
            });
        }

        //debug($query);die;
        return $query;
    }
}
