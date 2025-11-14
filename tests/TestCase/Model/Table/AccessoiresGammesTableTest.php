<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessoiresGammesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessoiresGammesTable Test Case
 */
class AccessoiresGammesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessoiresGammesTable
     */
    public $AccessoiresGammes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.accessoires_gammes',
        'app.accessoires',
        'app.gammes_bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AccessoiresGammes') ? [] : ['className' => AccessoiresGammesTable::class];
        $this->AccessoiresGammes = TableRegistry::getTableLocator()->get('AccessoiresGammes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccessoiresGammes);

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
