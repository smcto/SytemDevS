<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisTable Test Case
 */
class DevisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisTable
     */
    public $Devis;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis',
        'app.clients',
        'app.infos_bancaires',
        'app.commercial',
        'app.modele_devis_categories',
        'app.modele_devis_sous_categories',
        'app.devis_produits',
        'app.antennes',
        'app.devis_antennes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Devis') ? [] : ['className' => DevisTable::class];
        $this->Devis = TableRegistry::getTableLocator()->get('Devis', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Devis);

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
     * Test findComplete method
     *
     * @return void
     */
    public function testFindComplete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findAsModele method
     *
     * @return void
     */
    public function testFindAsModele()
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
