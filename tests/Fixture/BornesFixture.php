<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BornesFixture
 *
 */
class BornesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'numero' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'couleur' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'expiration_sb' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'commentaire' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'is_prette' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'parc_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'model_borne_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date_arrive_estime' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'antenne_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'client_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'ville' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'long' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'lat' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'fk_bornes_parcs1_idx' => ['type' => 'index', 'columns' => ['parc_id'], 'length' => []],
            'fk_bornes_model_bornes1_idx' => ['type' => 'index', 'columns' => ['model_borne_id'], 'length' => []],
            'fk_bornes_antennes1_idx' => ['type' => 'index', 'columns' => ['antenne_id'], 'length' => []],
            'fk_bornes_clients1_idx' => ['type' => 'index', 'columns' => ['client_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_bornes_antennes1' => ['type' => 'foreign', 'columns' => ['antenne_id'], 'references' => ['antennes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_bornes_clients1' => ['type' => 'foreign', 'columns' => ['client_id'], 'references' => ['clients', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_bornes_model_bornes1' => ['type' => 'foreign', 'columns' => ['model_borne_id'], 'references' => ['model_bornes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_bornes_parcs1' => ['type' => 'foreign', 'columns' => ['parc_id'], 'references' => ['parcs', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'numero' => 1,
                'couleur' => 'Lorem ipsum dolor sit amet',
                'expiration_sb' => '2018-06-12 18:32:40',
                'commentaire' => 'Lorem ipsum dolor sit amet',
                'is_prette' => 1,
                'parc_id' => 1,
                'model_borne_id' => 1,
                'date_arrive_estime' => '2018-06-12 18:32:40',
                'antenne_id' => 1,
                'client_id' => 1,
                'ville' => 'Lorem ipsum dolor sit amet',
                'long' => 'Lorem ipsum dolor sit amet',
                'lat' => 'Lorem ipsum dolor sit amet',
                'created' => '2018-06-12 18:32:40',
                'modified' => '2018-06-12 18:32:40'
            ],
        ];
        parent::init();
    }
}
