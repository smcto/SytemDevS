<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NumeroSeriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NumeroSeriesTable Test Case
 */
class NumeroSeriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NumeroSeriesTable
     */
    public $NumeroSeries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.numero_series',
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
        $config = TableRegistry::getTableLocator()->exists('NumeroSeries') ? [] : ['className' => NumeroSeriesTable::class];
        $this->NumeroSeries = TableRegistry::getTableLocator()->get('NumeroSeries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NumeroSeries);

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
