<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModelesMails Model
 *
 * @method \App\Model\Entity\ModelesMail get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModelesMail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModelesMail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModelesMail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModelesMail|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModelesMail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModelesMail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModelesMail findOrCreate($search, callable $callback = null, $options = [])
 */
class ModelesMailsTable extends Table
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

        $this->setTable('modeles_mails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('nom_interne')
            ->maxLength('nom_interne', 255)
            ->requirePresence('nom_interne', 'create')
            ->notEmpty('nom_interne');

        $validator
            ->scalar('objet')
            ->maxLength('objet', 255)
            ->requirePresence('objet', 'create')
            ->notEmpty('objet');

        $validator
            ->scalar('contenu')
            ->requirePresence('contenu', 'create')
            ->notEmpty('contenu');

        $this->hasMany('ModelesMailsPjs', [
            'foreignKey' => 'modeles_mails_id'
        ]);
        
        return $validator;
    }
}
