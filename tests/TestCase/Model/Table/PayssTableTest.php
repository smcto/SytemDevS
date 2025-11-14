<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayssTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayssTable Test Case
 */
class PayssTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PayssTable
     */
    public $Payss;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.payss'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Payss') ? [] : ['className' => PayssTable::class];
        $this->Payss = TableRegistry::getTableLocator()->get('Payss', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Payss);

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
