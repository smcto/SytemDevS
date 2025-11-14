<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VentesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VentesTable Test Case
 */
class VentesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VentesTable
     */
    public $Ventes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ventes',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Ventes') ? [] : ['className' => VentesTable::class];
        $this->Ventes = TableRegistry::getTableLocator()->get('Ventes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Ventes);

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
