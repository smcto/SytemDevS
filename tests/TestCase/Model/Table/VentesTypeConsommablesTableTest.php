<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VentesTypeConsommablesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VentesTypeConsommablesTable Test Case
 */
class VentesTypeConsommablesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VentesTypeConsommablesTable
     */
    public $VentesTypeConsommables;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ventes_type_consommables',
        'app.ventes',
        'app.type_consommables'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VentesTypeConsommables') ? [] : ['className' => VentesTypeConsommablesTable::class];
        $this->VentesTypeConsommables = TableRegistry::getTableLocator()->get('VentesTypeConsommables', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VentesTypeConsommables);

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
