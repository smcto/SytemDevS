<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActuBornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActuBornesTable Test Case
 */
class ActuBornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ActuBornesTable
     */
    public $ActuBornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.actu_bornes',
        'app.bornes',
        'app.actu_bornes_has_medias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ActuBornes') ? [] : ['className' => ActuBornesTable::class];
        $this->ActuBornes = TableRegistry::getTableLocator()->get('ActuBornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ActuBornes);

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
