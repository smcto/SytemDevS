<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModeleDevisCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModeleDevisCategoriesTable Test Case
 */
class ModeleDevisCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModeleDevisCategoriesTable
     */
    public $ModeleDevisCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modele_devis_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ModeleDevisCategories') ? [] : ['className' => ModeleDevisCategoriesTable::class];
        $this->ModeleDevisCategories = TableRegistry::getTableLocator()->get('ModeleDevisCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModeleDevisCategories);

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
