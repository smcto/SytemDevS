<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentMarketingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentMarketingsTable Test Case
 */
class DocumentMarketingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentMarketingsTable
     */
    public $DocumentMarketings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.document_marketings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentMarketings') ? [] : ['className' => DocumentMarketingsTable::class];
        $this->DocumentMarketings = TableRegistry::getTableLocator()->get('DocumentMarketings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentMarketings);

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
