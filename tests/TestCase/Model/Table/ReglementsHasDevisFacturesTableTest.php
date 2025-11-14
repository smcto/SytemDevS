<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReglementsHasDevisFacturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReglementsHasDevisFacturesTable Test Case
 */
class ReglementsHasDevisFacturesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ReglementsHasDevisFacturesTable
     */
    public $ReglementsHasDevisFactures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.reglements_has_devis_factures',
        'app.reglements',
        'app.devis_factures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ReglementsHasDevisFactures') ? [] : ['className' => ReglementsHasDevisFacturesTable::class];
        $this->ReglementsHasDevisFactures = TableRegistry::getTableLocator()->get('ReglementsHasDevisFactures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ReglementsHasDevisFactures);

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
