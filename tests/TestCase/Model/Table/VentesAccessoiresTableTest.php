<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VentesAccessoiresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VentesAccessoiresTable Test Case
 */
class VentesAccessoiresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VentesAccessoiresTable
     */
    public $VentesAccessoires;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ventes_accessoires',
        'app.ventes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('VentesAccessoires') ? [] : ['className' => VentesAccessoiresTable::class];
        $this->VentesAccessoires = TableRegistry::getTableLocator()->get('VentesAccessoires', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VentesAccessoires);

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
