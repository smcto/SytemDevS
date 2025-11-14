<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModeleDevisSousCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModeleDevisSousCategoriesTable Test Case
 */
class ModeleDevisSousCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModeleDevisSousCategoriesTable
     */
    public $ModeleDevisSousCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modele_devis_sous_categories',
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
        $config = TableRegistry::getTableLocator()->exists('ModeleDevisSousCategories') ? [] : ['className' => ModeleDevisSousCategoriesTable::class];
        $this->ModeleDevisSousCategories = TableRegistry::getTableLocator()->get('ModeleDevisSousCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModeleDevisSousCategories);

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
     * Test findFiltre method
     *
     * @return void
     */
    public function testFindFiltre()
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
