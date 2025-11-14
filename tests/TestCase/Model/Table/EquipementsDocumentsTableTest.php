<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipementsDocumentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipementsDocumentsTable Test Case
 */
class EquipementsDocumentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipementsDocumentsTable
     */
    public $EquipementsDocuments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.equipements_documents',
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
        $config = TableRegistry::getTableLocator()->exists('EquipementsDocuments') ? [] : ['className' => EquipementsDocumentsTable::class];
        $this->EquipementsDocuments = TableRegistry::getTableLocator()->get('EquipementsDocuments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EquipementsDocuments);

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
