<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeClientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeClientsTable Test Case
 */
class TypeClientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeClientsTable
     */
    public $TypeClients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.type_clients',
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
        $config = TableRegistry::getTableLocator()->exists('TypeClients') ? [] : ['className' => TypeClientsTable::class];
        $this->TypeClients = TableRegistry::getTableLocator()->get('TypeClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeClients);

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
