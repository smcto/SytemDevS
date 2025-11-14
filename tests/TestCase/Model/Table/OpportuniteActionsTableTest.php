<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OpportuniteActionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OpportuniteActionsTable Test Case
 */
class OpportuniteActionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OpportuniteActionsTable
     */
    public $OpportuniteActions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.opportunite_actions',
        'app.opportunite_timelines'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OpportuniteActions') ? [] : ['className' => OpportuniteActionsTable::class];
        $this->OpportuniteActions = TableRegistry::getTableLocator()->get('OpportuniteActions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OpportuniteActions);

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
