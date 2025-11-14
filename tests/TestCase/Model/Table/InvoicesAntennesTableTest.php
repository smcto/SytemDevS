<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisFacturesAntennesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisFacturesAntennesTable Test Case
 */
class DevisFacturesAntennesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisFacturesAntennesTable
     */
    public $DevisFacturesAntennes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_factures_antennes',
        'app.devis_factures',
        'app.antennes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DevisFacturesAntennes') ? [] : ['className' => DevisFacturesAntennesTable::class];
        $this->DevisFacturesAntennes = TableRegistry::getTableLocator()->get('DevisFacturesAntennes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevisFacturesAntennes);

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
