<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentsModelBornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentsModelBornesTable Test Case
 */
class DocumentsModelBornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentsModelBornesTable
     */
    public $DocumentsModelBornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.documents_model_bornes',
        'app.model_bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentsModelBornes') ? [] : ['className' => DocumentsModelBornesTable::class];
        $this->DocumentsModelBornes = TableRegistry::getTableLocator()->get('DocumentsModelBornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentsModelBornes);

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
