<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaulsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaulsTable Test Case
 */
class PaulsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PaulsTable
     */
    public $Pauls;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pauls'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Pauls') ? [] : ['className' => PaulsTable::class];
        $this->Pauls = TableRegistry::getTableLocator()->get('Pauls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pauls);

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
