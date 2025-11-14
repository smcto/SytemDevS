<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OptionEvenementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OptionEvenementsTable Test Case
 */
class OptionEvenementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OptionEvenementsTable
     */
    public $OptionEvenements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.option_evenements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OptionEvenements') ? [] : ['className' => OptionEvenementsTable::class];
        $this->OptionEvenements = TableRegistry::getTableLocator()->get('OptionEvenements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OptionEvenements);

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
