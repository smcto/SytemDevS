<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DateEvenementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DateEvenementsTable Test Case
 */
class DateEvenementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DateEvenementsTable
     */
    public $DateEvenements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.date_evenements',
        'app.evenements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DateEvenements') ? [] : ['className' => DateEvenementsTable::class];
        $this->DateEvenements = TableRegistry::getTableLocator()->get('DateEvenements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DateEvenements);

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
