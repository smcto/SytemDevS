<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactCategoriesTable Test Case
 */
class ContactCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactCategoriesTable
     */
    public $ContactCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.contact_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ContactCategories') ? [] : ['className' => ContactCategoriesTable::class];
        $this->ContactCategories = TableRegistry::getTableLocator()->get('ContactCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContactCategories);

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
