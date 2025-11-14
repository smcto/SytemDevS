<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatalogProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatalogProduitsTable Test Case
 */
class CatalogProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatalogProduitsTable
     */
    public $CatalogProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.catalog_produits',
        'app.catalog_sous_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CatalogProduits') ? [] : ['className' => CatalogProduitsTable::class];
        $this->CatalogProduits = TableRegistry::getTableLocator()->get('CatalogProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CatalogProduits);

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
