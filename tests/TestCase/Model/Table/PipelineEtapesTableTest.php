<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PipelineEtapesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PipelineEtapesTable Test Case
 */
class PipelineEtapesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PipelineEtapesTable
     */
    public $PipelineEtapes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pipeline_etapes',
        'app.pipelines',
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
        $config = TableRegistry::getTableLocator()->exists('PipelineEtapes') ? [] : ['className' => PipelineEtapesTable::class];
        $this->PipelineEtapes = TableRegistry::getTableLocator()->get('PipelineEtapes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PipelineEtapes);

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
