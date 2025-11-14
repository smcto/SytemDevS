<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BonsLivraisonsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BonsLivraisonsTable Test Case
 */
class BonsLivraisonsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BonsLivraisonsTable
     */
    public $BonsLivraisons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bons_livraisons',
        'app.devis',
        'app.bons_preparations',
        'app.clients',
        'app.users',
        'app.bons_livraisons_produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BonsLivraisons') ? [] : ['className' => BonsLivraisonsTable::class];
        $this->BonsLivraisons = TableRegistry::getTableLocator()->get('BonsLivraisons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BonsLivraisons);

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
