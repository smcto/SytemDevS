<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ClientContactsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ClientContactsTable Test Case
 */
class ClientContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ClientContactsTable
     */
    public $ClientContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.client_contacts',
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
        $config = TableRegistry::getTableLocator()->exists('ClientContacts') ? [] : ['className' => ClientContactsTable::class];
        $this->ClientContacts = TableRegistry::getTableLocator()->get('ClientContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ClientContacts);

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
