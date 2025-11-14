<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TvasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TvasTable Test Case
 */
class TvasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TvasTable
     */
    public $Tvas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tvas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tvas') ? [] : ['className' => TvasTable::class];
        $this->Tvas = TableRegistry::getTableLocator()->get('Tvas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tvas);

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
