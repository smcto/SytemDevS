<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogicielsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogicielsTable Test Case
 */
class LogicielsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LogicielsTable
     */
    public $Logiciels;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.logiciels',
        'app.borne_logiciels'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Logiciels') ? [] : ['className' => LogicielsTable::class];
        $this->Logiciels = TableRegistry::getTableLocator()->get('Logiciels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Logiciels);

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
