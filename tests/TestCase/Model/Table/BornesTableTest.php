<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BornesTable Test Case
 */
class BornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BornesTable
     */
    public $Bornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bornes',
        'app.parcs',
        'app.model_bornes',
        'app.antennes',
        'app.clients',
        'app.actu_bornes',
        'app.borne_logiciels',
        'app.bornes_has_medias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Bornes') ? [] : ['className' => BornesTable::class];
        $this->Bornes = TableRegistry::getTableLocator()->get('Bornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bornes);

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
