<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypeEquipements Model
 *
 * @property \App\Model\Table\EquipementsTable|\Cake\ORM\Association\HasMany $Equipements
 *
 * @method \App\Model\Entity\TypeEquipement get($primaryKey, $options = [])
 * @method \App\Model\Entity\TypeEquipement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TypeEquipement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TypeEquipement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypeEquipement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TypeEquipementsTable extends Table
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

        $this->setTable('type_equipements');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Equipements', [
            'foreignKey' => 'type_equipement_id'
        ]);

        $this->hasMany('EquipementBornes', [
            'foreignKey' => 'type_equipement_id'
        ]);

        $this->hasMany('FacturesProduits', [
            'foreignKey' => 'type_equipement_id'
        ]);

        $this->belongsToMany('GammesBornes', [
            'foreignKey' => 'type_equipement_id',
            'targetForeignKey' => 'gamme_borne_id',
            'joinTable' => 'type_equipements_gammes', // où type_equipements_gammes possède les champs type_equipement_id et gamme_borne_id
            'through' => 'TypeEquipementsGammes',
            'className' => 'GammesBornes', 
        ]);

        $this->hasMany(
            'TypeEquipementsGammes', [
                'className' => 'TypeEquipementsGammes',
                'foreignKey' => 'type_equipement_id',
            ]
        );
    }

    public function findFiltre(Query $query, array $options)
    {
        $keyword = isset($options['keyword']) ? trim($options['keyword']) : null;
        $parc_id = isset($options['parc_id']) ? trim($options['parc_id']) : null;

        if ($keyword) {
            $query->where([
                'nom LIKE' => "%$keyword%"
            ]);
        }

        if ($parc_id) {
            $query->leftJoinWith('EquipementBornes', function ($q) use($parc_id)
            {
                return $q->leftJoinWith('Bornes');
            })->where(['Bornes.parc_id' => $parc_id])->group('TypeEquipements.id');
        }
        return $query;
    }

    public function findByGamme(Query $query, array $options)
    {
        $query
        ->contain(['TypeEquipementsGammes', 'Equipements'])
        ->matching('TypeEquipementsGammes');
        return $query;
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
}
