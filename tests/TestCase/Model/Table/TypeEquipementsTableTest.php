<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeEquipementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeEquipementsTable Test Case
 */
class TypeEquipementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeEquipementsTable
     */
    public $TypeEquipements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::getTableLocator()->exists('TypeEquipements') ? [] : ['className' => TypeEquipementsTable::class];
        $this->TypeEquipements = TableRegistry::getTableLocator()->get('TypeEquipements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeEquipements);

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
}
