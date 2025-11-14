<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserTypeProfilsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserTypeProfilsTable Test Case
 */
class UserTypeProfilsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserTypeProfilsTable
     */
    public $UserTypeProfils;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_type_profils',
        'app.users',
        'app.type_profils'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserTypeProfils') ? [] : ['className' => UserTypeProfilsTable::class];
        $this->UserTypeProfils = TableRegistry::getTableLocator()->get('UserTypeProfils', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserTypeProfils);

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
