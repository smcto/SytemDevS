<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentsAntennesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentsAntennesTable Test Case
 */
class DocumentsAntennesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentsAntennesTable
     */
    public $DocumentsAntennes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.documents_antennes',
        'app.antennes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentsAntennes') ? [] : ['className' => DocumentsAntennesTable::class];
        $this->DocumentsAntennes = TableRegistry::getTableLocator()->get('DocumentsAntennes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentsAntennes);

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
