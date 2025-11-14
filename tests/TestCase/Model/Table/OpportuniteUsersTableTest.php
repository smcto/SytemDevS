<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OpportuniteUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OpportuniteUsersTable Test Case
 */
class OpportuniteUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OpportuniteUsersTable
     */
    public $OpportuniteUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.opportunite_users',
        'app.users',
        'app.opportunites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OpportuniteUsers') ? [] : ['className' => OpportuniteUsersTable::class];
        $this->OpportuniteUsers = TableRegistry::getTableLocator()->get('OpportuniteUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OpportuniteUsers);

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
