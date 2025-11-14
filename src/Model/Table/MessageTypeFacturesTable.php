<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MessageTypeFactures Model
 *
 * @property \App\Model\Table\EtatFacturesTable|\Cake\ORM\Association\BelongsTo $EtatFactures
 * @property \App\Model\Table\FacturesTable|\Cake\ORM\Association\HasMany $Factures
 *
 * @method \App\Model\Entity\MessageTypeFacture get($primaryKey, $options = [])
 * @method \App\Model\Entity\MessageTypeFacture newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MessageTypeFacture[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MessageTypeFacture|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MessageTypeFacture|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MessageTypeFacture patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MessageTypeFacture[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MessageTypeFacture findOrCreate($search, callable $callback = null, $options = [])
 */
class MessageTypeFacturesTable extends Table
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

        $this->setTable('message_type_factures');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('EtatFactures', [
            'foreignKey' => 'etat_facture_id'
        ]);
        $this->hasMany('Factures', [
            'foreignKey' => 'message_type_facture_id'
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
            ->scalar('message')
            ->allowEmpty('message');

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
        $rules->add($rules->existsIn(['etat_facture_id'], 'EtatFactures'));

        return $rules;
    }
}
