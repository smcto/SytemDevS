<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatalogProduitsHasCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatalogProduitsHasCategoriesTable Test Case
 */
class CatalogProduitsHasCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatalogProduitsHasCategoriesTable
     */
    public $CatalogProduitsHasCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.catalog_produits_has_categories',
        'app.catalog_produits',
        'app.catalog_categories',
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
        $config = TableRegistry::getTableLocator()->exists('CatalogProduitsHasCategories') ? [] : ['className' => CatalogProduitsHasCategoriesTable::class];
        $this->CatalogProduitsHasCategories = TableRegistry::getTableLocator()->get('CatalogProduitsHasCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CatalogProduitsHasCategories);

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
