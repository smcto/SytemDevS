<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModelesMailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModelesMailsTable Test Case
 */
class ModelesMailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModelesMailsTable
     */
    public $ModelesMails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modeles_mails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ModelesMails') ? [] : ['className' => ModelesMailsTable::class];
        $this->ModelesMails = TableRegistry::getTableLocator()->get('ModelesMails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModelesMails);

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
