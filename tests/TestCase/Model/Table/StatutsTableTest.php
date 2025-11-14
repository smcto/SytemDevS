<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatutsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatutsTable Test Case
 */
class StatutsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StatutsTable
     */
    public $Statuts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.statuts',
        'app.contacts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Statuts') ? [] : ['className' => StatutsTable::class];
        $this->Statuts = TableRegistry::getTableLocator()->get('Statuts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Statuts);

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
