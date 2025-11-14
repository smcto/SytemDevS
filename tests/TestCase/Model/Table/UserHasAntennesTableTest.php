<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserHasAntennesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserHasAntennesTable Test Case
 */
class UserHasAntennesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserHasAntennesTable
     */
    public $UserHasAntennes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_has_antennes',
        'app.users',
        'app.antennes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserHasAntennes') ? [] : ['className' => UserHasAntennesTable::class];
        $this->UserHasAntennes = TableRegistry::getTableLocator()->get('UserHasAntennes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserHasAntennes);

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
