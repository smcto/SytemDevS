<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FactureDeductionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FactureDeductionsTable Test Case
 */
class FactureDeductionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FactureDeductionsTable
     */
    public $FactureDeductions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.facture_deductions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FactureDeductions') ? [] : ['className' => FactureDeductionsTable::class];
        $this->FactureDeductions = TableRegistry::getTableLocator()->get('FactureDeductions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FactureDeductions);

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
