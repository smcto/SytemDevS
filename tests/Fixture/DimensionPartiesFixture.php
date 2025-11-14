<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DimensionPartiesFixture
 *
 */
class DimensionPartiesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'dimension' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'poids' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'model_borne_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'partie_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'fk_dimension_parties_type_bornes1_idx' => ['type' => 'index', 'columns' => ['model_borne_id'], 'length' => []],
            'FK_dimension_parties' => ['type' => 'index', 'columns' => ['partie_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_dimension_parties' => ['type' => 'foreign', 'columns' => ['partie_id'], 'references' => ['parties', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'fk_dimension_parties_type_bornes1' => ['type' => 'foreign', 'columns' => ['model_borne_id'], 'references' => ['model_bornes', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'dimension' => 'Lorem ipsum dolor sit amet',
                'poids' => 'Lorem ipsum dolor sit amet',
                'created' => '2018-06-14 14:24:59',
                'modified' => '2018-06-14 14:24:59',
                'model_borne_id' => 1,
                'partie_id' => 1
            ],
        ];
        parent::init();
    }
}
