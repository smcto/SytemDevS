<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PipelinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PipelinesTable Test Case
 */
class PipelinesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PipelinesTable
     */
    public $Pipelines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pipelines',
        'app.opportunites',
        'app.pipeline_etapes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Pipelines') ? [] : ['className' => PipelinesTable::class];
        $this->Pipelines = TableRegistry::getTableLocator()->get('Pipelines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pipelines);

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
