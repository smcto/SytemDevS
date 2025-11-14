<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SourceLeadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SourceLeadsTable Test Case
 */
class SourceLeadsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SourceLeadsTable
     */
    public $SourceLeads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.source_leads',
        'app.opportunites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SourceLeads') ? [] : ['className' => SourceLeadsTable::class];
        $this->SourceLeads = TableRegistry::getTableLocator()->get('SourceLeads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SourceLeads);

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
