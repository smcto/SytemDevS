<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LotProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LotProduitsTable Test Case
 */
class LotProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LotProduitsTable
     */
    public $LotProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lot_produits',
        'app.type_equipements',
        'app.equipements',
        'app.fournisseurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LotProduits') ? [] : ['className' => LotProduitsTable::class];
        $this->LotProduits = TableRegistry::getTableLocator()->get('LotProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LotProduits);

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
