<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MessageriesHasUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MessageriesHasUsersTable Test Case
 */
class MessageriesHasUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MessageriesHasUsersTable
     */
    public $MessageriesHasUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.messageries_has_users',
        'app.messageries',
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
        $config = TableRegistry::getTableLocator()->exists('MessageriesHasUsers') ? [] : ['className' => MessageriesHasUsersTable::class];
        $this->MessageriesHasUsers = TableRegistry::getTableLocator()->get('MessageriesHasUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MessageriesHasUsers);

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
