<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DebitInternetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DebitInternetsTable Test Case
 */
class DebitInternetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DebitInternetsTable
     */
    public $DebitInternets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.debit_internets'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DebitInternets') ? [] : ['className' => DebitInternetsTable::class];
        $this->DebitInternets = TableRegistry::getTableLocator()->get('DebitInternets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DebitInternets);

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
