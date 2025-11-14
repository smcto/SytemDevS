<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FactureSituationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FactureSituationsTable Test Case
 */
class FactureSituationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FactureSituationsTable
     */
    public $FactureSituations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.facture_situations',
        'app.devis',
        'app.ref_commercials',
        'app.clients',
        'app.facture_situations_produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FactureSituations') ? [] : ['className' => FactureSituationsTable::class];
        $this->FactureSituations = TableRegistry::getTableLocator()->get('FactureSituations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FactureSituations);

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
