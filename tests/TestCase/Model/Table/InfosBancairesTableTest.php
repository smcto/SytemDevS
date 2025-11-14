<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InfosBancairesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InfosBancairesTable Test Case
 */
class InfosBancairesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InfosBancairesTable
     */
    public $InfosBancaires;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.infos_bancaires'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InfosBancaires') ? [] : ['className' => InfosBancairesTable::class];
        $this->InfosBancaires = TableRegistry::getTableLocator()->get('InfosBancaires', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InfosBancaires);

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
