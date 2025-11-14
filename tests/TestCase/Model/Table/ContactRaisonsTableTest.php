<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactRaisonsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactRaisonsTable Test Case
 */
class ContactRaisonsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactRaisonsTable
     */
    public $ContactRaisons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.contact_raisons',
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
        $config = TableRegistry::getTableLocator()->exists('ContactRaisons') ? [] : ['className' => ContactRaisonsTable::class];
        $this->ContactRaisons = TableRegistry::getTableLocator()->get('ContactRaisons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContactRaisons);

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
