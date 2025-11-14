<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StripeCsvsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StripeCsvsTable Test Case
 */
class StripeCsvsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StripeCsvsTable
     */
    public $StripeCsvs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stripe_csvs',
        'app.stripe_excels'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StripeCsvs') ? [] : ['className' => StripeCsvsTable::class];
        $this->StripeCsvs = TableRegistry::getTableLocator()->get('StripeCsvs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StripeCsvs);

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
