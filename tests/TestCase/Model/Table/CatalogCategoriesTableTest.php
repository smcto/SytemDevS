<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatalogCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatalogCategoriesTable Test Case
 */
class CatalogCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatalogCategoriesTable
     */
    public $CatalogCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.catalog_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CatalogCategories') ? [] : ['className' => CatalogCategoriesTable::class];
        $this->CatalogCategories = TableRegistry::getTableLocator()->get('CatalogCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CatalogCategories);

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
