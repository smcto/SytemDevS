<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StripeExcelsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StripeExcelsTable Test Case
 */
class StripeExcelsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StripeExcelsTable
     */
    public $StripeExcels;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stripe_excels',
        'app.stripe_csvs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StripeExcels') ? [] : ['className' => StripeExcelsTable::class];
        $this->StripeExcels = TableRegistry::getTableLocator()->get('StripeExcels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StripeExcels);

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
