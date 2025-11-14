<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OpportuniteTimelinesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OpportuniteTimelinesTable Test Case
 */
class OpportuniteTimelinesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OpportuniteTimelinesTable
     */
    public $OpportuniteTimelines;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.opportunite_timelines',
        'app.opportunites',
        'app.opportunite_actions',
        'app.users',
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
        $config = TableRegistry::getTableLocator()->exists('OpportuniteTimelines') ? [] : ['className' => OpportuniteTimelinesTable::class];
        $this->OpportuniteTimelines = TableRegistry::getTableLocator()->get('OpportuniteTimelines', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OpportuniteTimelines);

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
