<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CatalogUniteTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CatalogUniteTable Test Case
 */
class CatalogUniteTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CatalogUniteTable
     */
    public $CatalogUnite;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.catalog_unites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CatalogUnite') ? [] : ['className' => CatalogUniteTable::class];
        $this->CatalogUnite = TableRegistry::getTableLocator()->get('CatalogUnite', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CatalogUnite);

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
