<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipementVentesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipementVentesTable Test Case
 */
class EquipementVentesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipementVentesTable
     */
    public $EquipementVentes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipement_ventes',
        'app.ventes',
        'app.type_equipements',
        'app.equipements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EquipementVentes') ? [] : ['className' => EquipementVentesTable::class];
        $this->EquipementVentes = TableRegistry::getTableLocator()->get('EquipementVentes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipementVentes);

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
