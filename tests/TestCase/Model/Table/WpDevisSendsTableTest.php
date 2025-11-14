<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WpDevisSendsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WpDevisSendsTable Test Case
 */
class WpDevisSendsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WpDevisSendsTable
     */
    public $WpDevisSends;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wp_devis_sends'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('WpDevisSends') ? [] : ['className' => WpDevisSendsTable::class];
        $this->WpDevisSends = TableRegistry::getTableLocator()->get('WpDevisSends', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WpDevisSends);

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
