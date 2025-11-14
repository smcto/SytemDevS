<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PipeEtapesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PipeEtapesTable Test Case
 */
class PipeEtapesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PipeEtapesTable
     */
    public $PipeEtapes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pipe_etapes',
        'app.pipes',
        'app.evenement_pipe_etapes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PipeEtapes') ? [] : ['className' => PipeEtapesTable::class];
        $this->PipeEtapes = TableRegistry::getTableLocator()->get('PipeEtapes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PipeEtapes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
