<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisFacturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisFacturesTable Test Case
 */
class DevisFacturesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisFacturesTable
     */
    public $DevisFactures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_factures',
        'app.ref_commercials',
        'app.clients',
        'app.info_bancaires',
        'app.modele_devis_factures_categories',
        'app.modele_devis_factures_sous_categories',
        'app.devis_factures_produits',
        'app.antennes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DevisFactures') ? [] : ['className' => DevisFacturesTable::class];
        $this->DevisFactures = TableRegistry::getTableLocator()->get('DevisFactures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevisFactures);

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
