<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MessageriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MessageriesTable Test Case
 */
class MessageriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MessageriesTable
     */
    public $Messageries;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.messageries'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Messageries') ? [] : ['className' => MessageriesTable::class];
        $this->Messageries = TableRegistry::getTableLocator()->get('Messageries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Messageries);

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
