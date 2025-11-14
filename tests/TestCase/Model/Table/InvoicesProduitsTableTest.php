<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisFacturesProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisFacturesProduitsTable Test Case
 */
class DevisFacturesProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisFacturesProduitsTable
     */
    public $DevisFacturesProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_factures_produits',
        'app.catalog_unites',
        'app.devis_factures',
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
        $config = TableRegistry::getTableLocator()->exists('DevisFacturesProduits') ? [] : ['className' => DevisFacturesProduitsTable::class];
        $this->DevisFacturesProduits = TableRegistry::getTableLocator()->get('DevisFacturesProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevisFacturesProduits);

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
