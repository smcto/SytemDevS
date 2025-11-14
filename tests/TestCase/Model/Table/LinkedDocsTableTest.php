<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LinkedDocsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LinkedDocsTable Test Case
 */
class LinkedDocsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LinkedDocsTable
     */
    public $LinkedDocs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.linked_docs',
        'app.opportunites',
        'app.devis',
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
        $config = TableRegistry::getTableLocator()->exists('LinkedDocs') ? [] : ['className' => LinkedDocsTable::class];
        $this->LinkedDocs = TableRegistry::getTableLocator()->get('LinkedDocs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LinkedDocs);

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
