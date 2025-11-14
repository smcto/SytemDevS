<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DimensionPartiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DimensionPartiesTable Test Case
 */
class DimensionPartiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DimensionPartiesTable
     */
    public $DimensionParties;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dimension_parties',
        'app.model_bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DimensionParties') ? [] : ['className' => DimensionPartiesTable::class];
        $this->DimensionParties = TableRegistry::getTableLocator()->get('DimensionParties', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DimensionParties);

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
