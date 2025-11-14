<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BonsLivraisonsProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BonsLivraisonsProduitsTable Test Case
 */
class BonsLivraisonsProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BonsLivraisonsProduitsTable
     */
    public $BonsLivraisonsProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bons_livraisons_produits',
        'app.bons_livraisons',
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
        $config = TableRegistry::getTableLocator()->exists('BonsLivraisonsProduits') ? [] : ['className' => BonsLivraisonsProduitsTable::class];
        $this->BonsLivraisonsProduits = TableRegistry::getTableLocator()->get('BonsLivraisonsProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BonsLivraisonsProduits);

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
