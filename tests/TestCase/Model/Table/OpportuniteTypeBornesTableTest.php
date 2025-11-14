<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OpportuniteTypeBornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OpportuniteTypeBornesTable Test Case
 */
class OpportuniteTypeBornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OpportuniteTypeBornesTable
     */
    public $OpportuniteTypeBornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.opportunite_type_bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OpportuniteTypeBornes') ? [] : ['className' => OpportuniteTypeBornesTable::class];
        $this->OpportuniteTypeBornes = TableRegistry::getTableLocator()->get('OpportuniteTypeBornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OpportuniteTypeBornes);

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
