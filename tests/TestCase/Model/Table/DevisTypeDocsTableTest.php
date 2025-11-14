<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisTypeDocsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisTypeDocsTable Test Case
 */
class DevisTypeDocsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisTypeDocsTable
     */
    public $DevisTypeDocs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_type_docs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DevisTypeDocs') ? [] : ['className' => DevisTypeDocsTable::class];
        $this->DevisTypeDocs = TableRegistry::getTableLocator()->get('DevisTypeDocs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevisTypeDocs);

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
