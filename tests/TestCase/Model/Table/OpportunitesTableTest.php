<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OpportunitesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OpportunitesTable Test Case
 */
class OpportunitesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OpportunitesTable
     */
    public $Opportunites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.opportunites',
        'app.opportunite_statuts',
        'app.pipelines',
        'app.pipeline_etapes',
        'app.type_clients',
        'app.source_leads',
        'app.contact_raisons',
        'app.type_evenements',
        'app.opportunite_clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Opportunites') ? [] : ['className' => OpportunitesTable::class];
        $this->Opportunites = TableRegistry::getTableLocator()->get('Opportunites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Opportunites);

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
