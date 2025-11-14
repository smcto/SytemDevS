<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactTypesTable Test Case
 */
class ContactTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactTypesTable
     */
    public $ContactTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.contact_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContactTypes') ? [] : ['className' => ContactTypesTable::class];
        $this->ContactTypes = TableRegistry::getTableLocator()->get('ContactTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContactTypes);

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
