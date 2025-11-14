<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BesionBornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BesionBornesTable Test Case
 */
class BesionBornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BesionBornesTable
     */
    public $BesionBornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.besion_bornes',
        'app.opportunites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BesionBornes') ? [] : ['className' => BesionBornesTable::class];
        $this->BesionBornes = TableRegistry::getTableLocator()->get('BesionBornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BesionBornes);

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
