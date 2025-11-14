<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OptionFondVerts Model
 *
 * @property \App\Model\Table\OpportunitesTable|\Cake\ORM\Association\HasMany $Opportunites
 *
 * @method \App\Model\Entity\OptionFondVert get($primaryKey, $options = [])
 * @method \App\Model\Entity\OptionFondVert newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OptionFondVert[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OptionFondVert|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OptionFondVert|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OptionFondVert patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OptionFondVert[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OptionFondVert findOrCreate($search, callable $callback = null, $options = [])
 */
class OptionFondVertsTable extends Table
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

        $this->setTable('option_fond_verts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Opportunites', [
            'foreignKey' => 'option_fond_vert_id'
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
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        return $validator;
    }
}
