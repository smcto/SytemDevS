<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisAntennesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisAntennesTable Test Case
 */
class DevisAntennesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisAntennesTable
     */
    public $DevisAntennes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_antennes',
        'app.devis',
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
        $config = TableRegistry::getTableLocator()->exists('DevisAntennes') ? [] : ['className' => DevisAntennesTable::class];
        $this->DevisAntennes = TableRegistry::getTableLocator()->get('DevisAntennes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevisAntennes);

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
