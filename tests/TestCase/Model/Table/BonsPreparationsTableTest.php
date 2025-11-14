<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BonsPreparationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BonsPreparationsTable Test Case
 */
class BonsPreparationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BonsPreparationsTable
     */
    public $BonsPreparations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bons_preparations',
        'app.devis',
        'app.bons_commandes',
        'app.clients',
        'app.users',
        'app.bons_preparations_produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BonsPreparations') ? [] : ['className' => BonsPreparationsTable::class];
        $this->BonsPreparations = TableRegistry::getTableLocator()->get('BonsPreparations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BonsPreparations);

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
