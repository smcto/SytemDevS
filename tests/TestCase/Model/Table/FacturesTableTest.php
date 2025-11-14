<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FacturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FacturesTable Test Case
 */
class FacturesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FacturesTable
     */
    public $Factures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.factures',
        'app.anntennes',
        'app.installateurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Factures') ? [] : ['className' => FacturesTable::class];
        $this->Factures = TableRegistry::getTableLocator()->get('Factures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Factures);

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
