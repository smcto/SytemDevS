<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeEvenementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeEvenementsTable Test Case
 */
class TypeEvenementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeEvenementsTable
     */
    public $TypeEvenements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.type_evenements',
        'app.evenements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TypeEvenements') ? [] : ['className' => TypeEvenementsTable::class];
        $this->TypeEvenements = TableRegistry::getTableLocator()->get('TypeEvenements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeEvenements);

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
