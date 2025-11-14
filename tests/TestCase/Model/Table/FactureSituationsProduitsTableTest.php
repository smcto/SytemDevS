<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FactureSituationsProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FactureSituationsProduitsTable Test Case
 */
class FactureSituationsProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FactureSituationsProduitsTable
     */
    public $FactureSituationsProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.facture_situations_produits',
        'app.catalog_unites',
        'app.facture_situations',
        'app.catalog_produits',
        'app.unites_clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FactureSituationsProduits') ? [] : ['className' => FactureSituationsProduitsTable::class];
        $this->FactureSituationsProduits = TableRegistry::getTableLocator()->get('FactureSituationsProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FactureSituationsProduits);

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
