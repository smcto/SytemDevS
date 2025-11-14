<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SourceLeads Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\HasMany $Opportunites
 *
 * @method \App\Model\Entity\SourceLead get($primaryKey, $options = [])
 * @method \App\Model\Entity\SourceLead newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SourceLead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SourceLead|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SourceLead|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SourceLead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SourceLead[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SourceLead findOrCreate($search, callable $callback = null, $options = [])
 */
class SourceLeadsTable extends Table
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

        $this->setTable('source_leads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Opportunites', [
            'foreignKey' => 'source_lead_id'
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
            ->maxLength('nom', 250)
            ->allowEmpty('nom');

        return $validator;
    }
    
    
    public function getIdSourceLead($nom){
        $sourceLead = $this->find()
                                ->where(['nom LIKE' =>"%".$nom."%"])
                                ->first();
        if(!empty($sourceLead)){
            return $sourceLead->id;
        }
        return null;
    }
}
