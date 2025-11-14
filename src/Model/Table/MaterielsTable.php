<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Materiels Model
 *
 * @method \App\Model\Entity\Materiel get($primaryKey, $options = [])
 * @method \App\Model\Entity\Materiel newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Materiel[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Materiel|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Materiel|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Materiel patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Materiel[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Materiel findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MaterielsTable extends Table
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

        $this->setTable('materiels');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('materiel')
            ->maxLength('materiel', 255)
            ->allowEmpty('materiel');

        $validator
            ->scalar('descriptif')
            ->maxLength('descriptif', 255)
            ->allowEmpty('descriptif');

        $validator
            ->scalar('photos')
            ->maxLength('photos', 255)
            ->allowEmpty('photos');

        $validator
            ->scalar('notice_tuto')
            ->maxLength('notice_tuto', 255)
            ->allowEmpty('notice_tuto');

        $validator
            ->scalar('dimension')
            ->allowEmpty('dimension');

        $validator
            ->scalar('poids')
            ->allowEmpty('poids');

        $validator
            ->scalar('consignes')
            ->maxLength('consignes', 255)
            ->allowEmpty('consignes');

        $validator
            ->allowEmpty('variation_stok');

        return $validator;
    }
}
