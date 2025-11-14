<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParcsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParcsTable Test Case
 */
class ParcsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParcsTable
     */
    public $Parcs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parcs',
        'app.bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Parcs') ? [] : ['className' => ParcsTable::class];
        $this->Parcs = TableRegistry::getTableLocator()->get('Parcs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Parcs);

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
