<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatalogProduitsFilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatalogProduitsFilesTable Test Case
 */
class CatalogProduitsFilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatalogProduitsFilesTable
     */
    public $CatalogProduitsFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.catalog_produits_files',
        'app.catalog_produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CatalogProduitsFiles') ? [] : ['className' => CatalogProduitsFilesTable::class];
        $this->CatalogProduitsFiles = TableRegistry::getTableLocator()->get('CatalogProduitsFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CatalogProduitsFiles);

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
