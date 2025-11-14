<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModelBornes Model
 *
 * @property \App\Model\Table\BornesTable|\Cake\ORM\Association\HasMany $Bornes
 * @property \App\Model\Table\FichiersTable|\Cake\ORM\Association\HasMany $Fichiers
 * @property \App\Model\Table\DocumentsModelBornesTable|\Cake\ORM\Association\HasMany $Documents
 * @property \App\Model\Table\ModelBornesHasMediasTable|\Cake\ORM\Association\HasMany $ModelBornesHasMedias
 *
 * @method \App\Model\Entity\ModelBorne get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModelBorne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModelBorne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModelBorne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModelBorne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModelBorne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModelBorne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModelBorne findOrCreate($search, callable $callback = null, $options = [])
 */
class ModelBornesTable extends Table
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

        $this->setTable('model_bornes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Bornes', [
            'foreignKey' => 'model_borne_id'
        ]);
        $this->hasMany('ModelBornesHasMedias', [
            'foreignKey' => 'model_borne_id'
        ]);
        
        /*$this->hasMany('CouleurPossibles', [
            'foreignKey' => 'model_borne_id'
        ]);*/
        
        $this->hasMany('Dimensions', [
            'foreignKey' => 'model_borne_id'
        ]);

        $this->hasMany('Fichiers', [
            'foreignKey' => 'model_borne_id'
        ]);
        
        $this->hasMany('ModelBorneHasEquipements', [
            'foreignKey' => 'model_borne_id'
        ]);

        $this->hasMany('Documents', [
            'className' => 'DocumentsModelBornes',
            'foreignKey' => 'model_borne_id'
        ]);
        
        $this->belongsTo('GammesBornes', [
            'foreignKey' => 'gamme_borne_id',
            'joinType' => 'LEFT'
        ]);
        
         $this->belongsToMany('Couleurs', [
            'className' => 'Couleurs',
            'joinTable' => 'model_bornes_has_couleurs',
            'targetForeignKey' =>'couleur_id',
            'foreignKey' => 'model_borne_id'
        ]);
        
        $this->belongsTo('Equipements', [
            'foreignKey' => 'type_imprimante_id',
        ]);
      
        $this->belongsTo('TypeEquipements', [
            'foreignKey' => 'type_appareil_photo_id',
        ]);
      
        $this->belongsTo('EquipementPieds', [
            'foreignKey' => 'pied_id',
            'joinTable' => 'Equipements'
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
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->scalar('version')
            ->maxLength('version', 255)
            ->requirePresence('version', 'create')
            ->notEmpty('version');

        $validator
            ->date('date_sortie')
            ->requirePresence('date_sortie', 'create')
            ->notEmpty('date_sortie');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        $validator
            ->scalar('taille_ecran')
            ->maxLength('taille_ecran', 255)
            ->requirePresence('taille_ecran', 'create')
            ->notEmpty('taille_ecran');

        $validator
            ->scalar('modele_imprimante')
            ->maxLength('modele_imprimante', 255)
            ->requirePresence('modele_imprimante', 'create')
            ->notEmpty('modele_imprimante');

        $validator
            ->scalar('model_appareil_photo')
            ->maxLength('model_appareil_photo', 255)
            ->requirePresence('model_appareil_photo', 'create')
            ->notEmpty('model_appareil_photo');

        $validator
            ->scalar('note_complementaire')
            ->maxLength('note_complementaire', 255)
            ->allowEmpty('note_complementaire');

        
        $validator
            ->scalar('gamme_borne_id')
            ->allowEmpty('gamme_borne_id');
        

        return $validator;
    }
}
