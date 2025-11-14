<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EvenementPipeEtapesFixture
 *
 */
class EvenementPipeEtapesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'pipe_etape_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'evenement_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'FK_evenement_pipe_etapes' => ['type' => 'index', 'columns' => ['pipe_etape_id'], 'length' => []],
            'FK_evenement_pipe_etapes_1' => ['type' => 'index', 'columns' => ['evenement_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'FK_evenement_pipe_etapes' => ['type' => 'foreign', 'columns' => ['pipe_etape_id'], 'references' => ['pipe_etapes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'FK_evenement_pipe_etapes_1' => ['type' => 'foreign', 'columns' => ['evenement_id'], 'references' => ['evenements', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'pipe_etape_id' => 1,
                'evenement_id' => 1
            ],
        ];
        parent::init();
    }
}
