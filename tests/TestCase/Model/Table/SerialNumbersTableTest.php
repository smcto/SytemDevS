<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SerialNumbersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SerialNumbersTable Test Case
 */
class SerialNumbersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SerialNumbersTable
     */
    public $SerialNumbers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.serial_numbers',
        'app.lot_produits',
        'app.bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SerialNumbers') ? [] : ['className' => SerialNumbersTable::class];
        $this->SerialNumbers = TableRegistry::getTableLocator()->get('SerialNumbers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SerialNumbers);

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
