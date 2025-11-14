<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EvenementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EvenementsTable Test Case
 */
class EvenementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EvenementsTable
     */
    public $Evenements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.evenements',
        'app.clients',
        'app.type_evenements',
        'app.antennes',
        'app.date_evenements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Evenements') ? [] : ['className' => EvenementsTable::class];
        $this->Evenements = TableRegistry::getTableLocator()->get('Evenements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Evenements);

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
