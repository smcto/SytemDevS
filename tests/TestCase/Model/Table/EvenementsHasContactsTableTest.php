<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EvenementsHasContactsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EvenementsHasContactsTable Test Case
 */
class EvenementsHasContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EvenementsHasContactsTable
     */
    public $EvenementsHasContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.evenements_has_contacts',
        'app.evenements',
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
        $config = TableRegistry::getTableLocator()->exists('EvenementsHasContacts') ? [] : ['className' => EvenementsHasContactsTable::class];
        $this->EvenementsHasContacts = TableRegistry::getTableLocator()->get('EvenementsHasContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EvenementsHasContacts);

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
