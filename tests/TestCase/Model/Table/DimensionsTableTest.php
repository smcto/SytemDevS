<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DimensionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DimensionsTable Test Case
 */
class DimensionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DimensionsTable
     */
    public $Dimensions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dimensions',
        'app.model_bornes',
        'app.parties'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Dimensions') ? [] : ['className' => DimensionsTable::class];
        $this->Dimensions = TableRegistry::getTableLocator()->get('Dimensions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dimensions);

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
