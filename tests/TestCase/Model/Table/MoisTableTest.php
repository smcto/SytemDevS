<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MoisTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MoisTable Test Case
 */
class MoisTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MoisTable
     */
    public $Mois;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mois'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Mois') ? [] : ['className' => MoisTable::class];
        $this->Mois = TableRegistry::getTableLocator()->get('Mois', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mois);

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
