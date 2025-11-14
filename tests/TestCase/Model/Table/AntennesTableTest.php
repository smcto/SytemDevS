<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AntennesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AntennesTable Test Case
 */
class AntennesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AntennesTable
     */
    public $Antennes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.antennes',
        'app.lieu_types',
        'app.etats',
        'app.bornes',
        'app.contacts',
        'app.fournisseurs',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Antennes') ? [] : ['className' => AntennesTable::class];
        $this->Antennes = TableRegistry::getTableLocator()->get('Antennes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Antennes);

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
