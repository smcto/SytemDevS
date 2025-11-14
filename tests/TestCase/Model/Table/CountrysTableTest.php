<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CountrysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CountrysTable Test Case
 */
class CountrysTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CountrysTable
     */
    public $Countrys;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.countrys'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Countrys') ? [] : ['className' => CountrysTable::class];
        $this->Countrys = TableRegistry::getTableLocator()->get('Countrys', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Countrys);

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
