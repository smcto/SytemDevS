<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EvenementPipeEtapesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EvenementPipeEtapesTable Test Case
 */
class EvenementPipeEtapesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EvenementPipeEtapesTable
     */
    public $EvenementPipeEtapes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.evenement_pipe_etapes',
        'app.pipe_etapes',
        'app.evenements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EvenementPipeEtapes') ? [] : ['className' => EvenementPipeEtapesTable::class];
        $this->EvenementPipeEtapes = TableRegistry::getTableLocator()->get('EvenementPipeEtapes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EvenementPipeEtapes);

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
