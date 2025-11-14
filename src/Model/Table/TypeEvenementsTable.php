<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeEvenements Model
 *
 * @property \App\Model\Table\EvenementsTable|\Cake\ORM\Association\HasMany $Evenements
 *
 * @method \App\Model\Entity\TypeEvenement get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeEvenement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeEvenement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeEvenement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEvenement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEvenement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEvenement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEvenement findOrCreate($search, callable $callback = null, $options = [])
 */
class TypeEvenementsTable extends Table
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

        $this->setTable('type_evenements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Evenements', [
            'foreignKey' => 'type_evenement_id'
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
            ->scalar('description')
            ->allowEmpty('description');

        return $validator;
    }
    
    public function findIdTypeEvenement(Query $query, array $options) {
        $query = $query->where(['nom LIKE' =>"%" . $options['nom'] . "%"])->first();
        if($query){
            return $query->id;
        }
        return null;
    }
}
