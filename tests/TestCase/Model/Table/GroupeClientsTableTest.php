<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupeClientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupeClientsTable Test Case
 */
class GroupeClientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupeClientsTable
     */
    public $GroupeClients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.groupe_clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('GroupeClients') ? [] : ['className' => GroupeClientsTable::class];
        $this->GroupeClients = TableRegistry::getTableLocator()->get('GroupeClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GroupeClients);

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
