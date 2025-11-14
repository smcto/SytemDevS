<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailsHasUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailsHasUsersTable Test Case
 */
class EmailsHasUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailsHasUsersTable
     */
    public $EmailsHasUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.emails_has_users',
        'app.emails',
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
        $config = TableRegistry::getTableLocator()->exists('EmailsHasUsers') ? [] : ['className' => EmailsHasUsersTable::class];
        $this->EmailsHasUsers = TableRegistry::getTableLocator()->get('EmailsHasUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailsHasUsers);

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
