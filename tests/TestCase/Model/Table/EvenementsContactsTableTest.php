<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EvenementsContactsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EvenementsContactsTable Test Case
 */
class EvenementsContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EvenementsContactsTable
     */
    public $EvenementsContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.evenements_contacts',
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
        $config = TableRegistry::getTableLocator()->exists('EvenementsContacts') ? [] : ['className' => EvenementsContactsTable::class];
        $this->EvenementsContacts = TableRegistry::getTableLocator()->get('EvenementsContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EvenementsContacts);

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
