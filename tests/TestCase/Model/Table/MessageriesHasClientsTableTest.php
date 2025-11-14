<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MessageriesHasClientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MessageriesHasClientsTable Test Case
 */
class MessageriesHasClientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MessageriesHasClientsTable
     */
    public $MessageriesHasClients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.messageries_has_clients',
        'app.messageries',
        'app.clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MessageriesHasClients') ? [] : ['className' => MessageriesHasClientsTable::class];
        $this->MessageriesHasClients = TableRegistry::getTableLocator()->get('MessageriesHasClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MessageriesHasClients);

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
