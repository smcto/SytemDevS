<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BonsPreparationsProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BonsPreparationsProduitsTable Test Case
 */
class BonsPreparationsProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BonsPreparationsProduitsTable
     */
    public $BonsPreparationsProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bons_preparations_produits',
        'app.bons_preparations',
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
        $config = TableRegistry::getTableLocator()->exists('BonsPreparationsProduits') ? [] : ['className' => BonsPreparationsProduitsTable::class];
        $this->BonsPreparationsProduits = TableRegistry::getTableLocator()->get('BonsPreparationsProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BonsPreparationsProduits);

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
