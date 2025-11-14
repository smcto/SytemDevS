<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModelesMailsPjsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModelesMailsPjsTable Test Case
 */
class ModelesMailsPjsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModelesMailsPjsTable
     */
    public $ModelesMailsPjs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modeles_mails_pjs',
        'app.modeles_mails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ModelesMailsPjs') ? [] : ['className' => ModelesMailsPjsTable::class];
        $this->ModelesMailsPjs = TableRegistry::getTableLocator()->get('ModelesMailsPjs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModelesMailsPjs);

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
