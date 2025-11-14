<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipementBornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipementBornesTable Test Case
 */
class EquipementBornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipementBornesTable
     */
    public $EquipementBornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipement_bornes',
        'app.equipements',
        'app.bornes',
        'app.type_equipements',
        'app.numero_series'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EquipementBornes') ? [] : ['className' => EquipementBornesTable::class];
        $this->EquipementBornes = TableRegistry::getTableLocator()->get('EquipementBornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipementBornes);

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
