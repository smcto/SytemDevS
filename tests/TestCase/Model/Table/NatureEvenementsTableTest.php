<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NatureEvenementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NatureEvenementsTable Test Case
 */
class NatureEvenementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NatureEvenementsTable
     */
    public $NatureEvenements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.nature_evenements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('NatureEvenements') ? [] : ['className' => NatureEvenementsTable::class];
        $this->NatureEvenements = TableRegistry::getTableLocator()->get('NatureEvenements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NatureEvenements);

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
