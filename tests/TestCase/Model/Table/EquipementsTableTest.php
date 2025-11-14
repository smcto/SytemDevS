<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipementsTable Test Case
 */
class EquipementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipementsTable
     */
    public $Equipements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipements',
        'app.type_equipements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Equipements') ? [] : ['className' => EquipementsTable::class];
        $this->Equipements = TableRegistry::getTableLocator()->get('Equipements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Equipements);

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
