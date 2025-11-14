<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModelBornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModelBornesTable Test Case
 */
class ModelBornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModelBornesTable
     */
    public $ModelBornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.model_bornes',
        'app.bornes',
        'app.model_bornes_has_medias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ModelBornes') ? [] : ['className' => ModelBornesTable::class];
        $this->ModelBornes = TableRegistry::getTableLocator()->get('ModelBornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModelBornes);

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
