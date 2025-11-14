<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Posts Model
 *
 * @property \App\Model\Table\PostCategoriesTable|\Cake\ORM\Association\HasMany $PostCategories
 * @property \App\Model\Table\FichiersTable|\Cake\ORM\Association\HasMany $Fichiers
 * @property |\Cake\ORM\Association\HasMany $PostTypeProfils
 *
 * @method \App\Model\Entity\Post get($primaryKey, $options = [])
 * @method \App\Model\Entity\Post newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Post[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Post|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Post patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Post[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Post findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PostsTable extends Table
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

        $this->setTable('posts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

       /* $this->hasMany('PostCategories', [
            'foreignKey' => 'post_id'
        ]);
        $this->hasMany('PostTypeProfils', [
            'foreignKey' => 'post_id'
        ]);*/

        $this->hasMany('Fichiers', [
            'foreignKey' => 'post_id'
        ]);
        
    
        $this->belongsToMany('Categories',[
            'className' => 'Categories',
            'joinTable' => 'post_categories',
            'targetForeignKey' =>'post_id',
            'foreignKey' => 'categorie_id'
        ]);

        
         $this->belongsToMany('TypeProfils',[
            'className' => 'TypeProfils',
            'joinTable' => 'post_type_profils',
            'foreignKey' =>'post_id',
            'targetForeignKey' => 'type_profil_id'
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
            ->scalar('titre')
            ->requirePresence('titre', 'create')
            ->notEmpty('titre');

        $validator
            ->scalar('contenu')
            ->maxLength('contenu', 4294967295)
            ->allowEmpty('contenu');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }


    public function findFiltre(Query $query, array $options)
    {
        $categorie = $options['categorie'];
        if (!empty($categorie)) {
            $query
                ->matching('Categories')
                ->where([
                    'Categories.id IN' => $categorie
                ]);
        }

        $etat = $options['etat'];
        if (!empty($etat)) {
            $query
                ->where([
                    'Posts.status' => $etat
                ]);
        }

        $search = $options['key'];
        if (!empty($search)) {
            $query
                ->where(
                    ['Posts.titre LIKE' => '%' . $search . '%']
                );
        }

        $typeprofil_ids = $options['typeprofil_ids'];
        if(!empty($typeprofil_ids)) {
            //=== profils antenne : 4
            $query->matching('TypeProfils', function ($q) use ($typeprofil_ids) {
                if (in_array(4, $typeprofil_ids)) {
                        $q->where(['TypeProfils.id' => 4]);
                }
                return $q;
            });
        }
        return $query;
    }
}
