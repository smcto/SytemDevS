<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MessageTypeFacturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MessageTypeFacturesTable Test Case
 */
class MessageTypeFacturesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MessageTypeFacturesTable
     */
    public $MessageTypeFactures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.message_type_factures',
        'app.etat_factures',
        'app.factures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MessageTypeFactures') ? [] : ['className' => MessageTypeFacturesTable::class];
        $this->MessageTypeFactures = TableRegistry::getTableLocator()->get('MessageTypeFactures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MessageTypeFactures);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
