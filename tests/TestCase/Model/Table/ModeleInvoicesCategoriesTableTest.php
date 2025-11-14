<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModeleDevisFacturesCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModeleDevisFacturesCategoriesTable Test Case
 */
class ModeleDevisFacturesCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModeleDevisFacturesCategoriesTable
     */
    public $ModeleDevisFacturesCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modele_devis_factures_categories',
        'app.devis_factures',
        'app.modele_devis_factures_sous_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ModeleDevisFacturesCategories') ? [] : ['className' => ModeleDevisFacturesCategoriesTable::class];
        $this->ModeleDevisFacturesCategories = TableRegistry::getTableLocator()->get('ModeleDevisFacturesCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModeleDevisFacturesCategories);

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
