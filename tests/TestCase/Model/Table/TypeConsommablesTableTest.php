<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeConsommablesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeConsommablesTable Test Case
 */
class TypeConsommablesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeConsommablesTable
     */
    public $TypeConsommables;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.type_consommables'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TypeConsommables') ? [] : ['className' => TypeConsommablesTable::class];
        $this->TypeConsommables = TableRegistry::getTableLocator()->get('TypeConsommables', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeConsommables);

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
