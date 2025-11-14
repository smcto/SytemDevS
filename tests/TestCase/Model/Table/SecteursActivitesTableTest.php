<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SecteursActivitesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SecteursActivitesTable Test Case
 */
class SecteursActivitesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SecteursActivitesTable
     */
    public $SecteursActivites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.secteurs_activites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SecteursActivites') ? [] : ['className' => SecteursActivitesTable::class];
        $this->SecteursActivites = TableRegistry::getTableLocator()->get('SecteursActivites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SecteursActivites);

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
