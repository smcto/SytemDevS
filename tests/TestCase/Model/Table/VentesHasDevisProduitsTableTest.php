<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VentesHasDevisProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VentesHasDevisProduitsTable Test Case
 */
class VentesHasDevisProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VentesHasDevisProduitsTable
     */
    public $VentesHasDevisProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ventes_has_devis_produits',
        'app.devis_produits',
        'app.ventes_consommables'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VentesHasDevisProduits') ? [] : ['className' => VentesHasDevisProduitsTable::class];
        $this->VentesHasDevisProduits = TableRegistry::getTableLocator()->get('VentesHasDevisProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VentesHasDevisProduits);

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
