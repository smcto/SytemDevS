<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MoyenReglementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MoyenReglementsTable Test Case
 */
class MoyenReglementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MoyenReglementsTable
     */
    public $MoyenReglements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.moyen_reglements',
        'app.reglements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MoyenReglements') ? [] : ['className' => MoyenReglementsTable::class];
        $this->MoyenReglements = TableRegistry::getTableLocator()->get('MoyenReglements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MoyenReglements);

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
