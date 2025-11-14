<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShortLinksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShortLinksTable Test Case
 */
class ShortLinksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ShortLinksTable
     */
    public $ShortLinks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.short_links',
        'app.devis'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ShortLinks') ? [] : ['className' => ShortLinksTable::class];
        $this->ShortLinks = TableRegistry::getTableLocator()->get('ShortLinks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShortLinks);

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
