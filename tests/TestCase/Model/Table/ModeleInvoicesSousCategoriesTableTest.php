<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModeleDevisFacturesSousCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModeleDevisFacturesSousCategoriesTable Test Case
 */
class ModeleDevisFacturesSousCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModeleDevisFacturesSousCategoriesTable
     */
    public $ModeleDevisFacturesSousCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modele_devis_factures_sous_categories',
        'app.modele_devis_factures_categories',
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
        $config = TableRegistry::getTableLocator()->exists('ModeleDevisFacturesSousCategories') ? [] : ['className' => ModeleDevisFacturesSousCategoriesTable::class];
        $this->ModeleDevisFacturesSousCategories = TableRegistry::getTableLocator()->get('ModeleDevisFacturesSousCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModeleDevisFacturesSousCategories);

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
