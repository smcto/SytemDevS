<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mois Model
 *
 * @method \App\Model\Entity\Mois get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mois newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mois[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mois|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mois|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mois patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mois[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mois findOrCreate($search, callable $callback = null, $options = [])
 */
class MoisTable extends Table
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

        $this->setTable('mois');
        $this->setDisplayField('nom');
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
            ->scalar('nom')
            ->maxLength('nom', 15)
            ->allowEmpty('nom');

        return $validator;
    }

    public function findMoisUntilNow(Query $query, array $options)
    {
        $query->select(['id', 'nom', 'mois_annee' => 'concat(nom, ". ", "'.date('y').'")'])->order(['id' => 'DESC']);
        return $query;
    }

    /**
     * Courbe generale, total, par pro, part
     * @param  Query  $query   [description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function findReglementsGeneral(Query $query, array $options) 
    {
        $year = $options['year'] ?? null;
        $client_type = $options['client_type'] ?? null; // person ou corporation

        $concat_annee_mois = 'concat('.$year.', "-", Mois.id)';
        $montant_par_mois = 'coalesce(sum(r.montant), 0)';

        $joinConditions = [
            'r' => [
                'table' => 'reglements',
                'type' => 'LEFT',
                'conditions' => [
                    'Mois.id = MONTH(r.date)', 
                    'year(r.date)' => $year,
                ],
            ],
            'c' => [
                'table' => 'clients',
                'type' => 'INNER',
                'conditions' => [
                    'c.id = r.client_id',
                ]
            ]
        ];

        if ($client_type) {
            $joinConditions['c']['conditions']['c.client_type'] = $client_type;
        }
        
        $query
            ->select(['annee_mois' => $concat_annee_mois, 'x' => $concat_annee_mois, 'id', 'nom', 'total_par_mois' => $montant_par_mois, 'y' => $montant_par_mois, 'client_type' => 'c.client_type'])
            ->join($joinConditions)
            ->group(['Mois.nom'])
            ->order(['Mois.id' => 'ASC'])
        ;
        // debug($query ->sql());
        // debug($query ->toArray());
        // die();
        return $query;
    }


    /**
     * Courbe avec mois pouvant avoir 0 montant
     * @param  Query  $query   [description]
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function findReglementsParBanque(Query $query, array $options)
    {
        $year = $options['year'] ?? null;
        $info_bancaire_id = $options['info_bancaire_id'] ?? null;
        $moyen_reglement_id = $options['moyen_reglement_id'] ?? null;

        $concat_annee_mois = 'concat('.$year.', "-", Mois.id)';
        $montant_par_mois = 'coalesce(sum(reglements.montant), 0)';

        $joinConditions = [
            'Mois.id = MONTH(reglements.date)', 
            'year(reglements.date)' => $year,
        ];

        if ($info_bancaire_id) {
            $joinConditions['reglements.info_bancaire_id'] = $info_bancaire_id;
        }
        
        if ($moyen_reglement_id) {
            $joinConditions['moyen_reglement_id'] = $moyen_reglement_id;
        }

        $query
            ->select(['annee_mois' => $concat_annee_mois, 'x' => $concat_annee_mois, 'id', 'nom', 'total_par_mois' => $montant_par_mois, 'y' => $montant_par_mois,])
            ->join([
                'table' => 'reglements',
                'type' => 'LEFT',
                'conditions' => $joinConditions
            ])
            ->group(['Mois.nom'])
            ->order(['Mois.id' => 'ASC'])
        ;

        return $query;
    }

    public function findReglementsParTypeFacture(Query $query, array $options)
    {
        $year = $options['year'] ?? null;
        $client_type = $options['client_type'] ?? null; // person ou corporation
        $type_doc_id = $options['type_doc_id'] ?? null; 
        $client_type = $options['client_type'] ?? null; 

        $concat_annee_mois = 'concat('.$year.', "-", Mois.id)';
        $montant_par_mois = 'coalesce(sum(reglements_has_devis_factures.montant_lie), 0)';

        $joinConditions = [
            'reglements_has_devis_factures' => [
                'table' => 'reglements_has_devis_factures',
                'type' => 'LEFT',
                'conditions' => [
                    'Mois.id = MONTH(reglements_has_devis_factures.created)', 
                    'year(reglements_has_devis_factures.created)' => $year,
                ],
            ],
            'devis_factures' => [
                'table' => 'devis_factures',
                'type' => 'INNER',
                'conditions' => [
                    'devis_factures.id = reglements_has_devis_factures.devis_factures_id',
                    'devis_factures.type_doc_id' => $type_doc_id
                ]
            ],
        ];

        if (isset($options['client_type'])) { // pas de type_doc_id
            $joinConditions['devis_factures'] = [
               'table' => 'devis_factures',
               'type' => 'INNER',
               'conditions' => [
                   'devis_factures.id = reglements_has_devis_factures.devis_factures_id',
               ]
            ];
            $joinConditions['clients'] = [
                'table' => 'clients',
                'type' => 'INNER',
                'conditions' => [
                    'clients.id = devis_factures.client_id',
                    'clients.client_type' => $client_type
                ]
            ];
        }

        $query
            ->select(['annee_mois' => $concat_annee_mois, 'x' => $concat_annee_mois, 'id', 'nom', 'total_par_mois' => $montant_par_mois, 'y' => $montant_par_mois])
            ->join($joinConditions)
            ->group(['Mois.nom'])
            ->order(['Mois.id' => 'ASC'])
        ;

        return $query;
    }


}
