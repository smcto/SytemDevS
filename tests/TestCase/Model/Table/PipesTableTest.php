<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PipesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PipesTable Test Case
 */
class PipesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PipesTable
     */
    public $Pipes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pipes',
        'app.pipe_etapes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Pipes') ? [] : ['className' => PipesTable::class];
        $this->Pipes = TableRegistry::getTableLocator()->get('Pipes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pipes);

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
}
