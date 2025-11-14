<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatutHistoriquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatutHistoriquesTable Test Case
 */
class StatutHistoriquesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StatutHistoriquesTable
     */
    public $StatutHistoriques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.statut_historiques',
        'app.devis',
        'app.devis_factures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StatutHistoriques') ? [] : ['className' => StatutHistoriquesTable::class];
        $this->StatutHistoriques = TableRegistry::getTableLocator()->get('StatutHistoriques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StatutHistoriques);

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
