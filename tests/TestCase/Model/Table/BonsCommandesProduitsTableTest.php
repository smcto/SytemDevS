<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BonsCommandesProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BonsCommandesProduitsTable Test Case
 */
class BonsCommandesProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BonsCommandesProduitsTable
     */
    public $BonsCommandesProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bons_commandes_produits',
        'app.bons_commandes',
        'app.produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BonsCommandesProduits') ? [] : ['className' => BonsCommandesProduitsTable::class];
        $this->BonsCommandesProduits = TableRegistry::getTableLocator()->get('BonsCommandesProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BonsCommandesProduits);

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
