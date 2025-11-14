<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeAnimationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeAnimationsTable Test Case
 */
class TypeAnimationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeAnimationsTable
     */
    public $TypeAnimations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.type_animations',
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
        $config = TableRegistry::getTableLocator()->exists('TypeAnimations') ? [] : ['className' => TypeAnimationsTable::class];
        $this->TypeAnimations = TableRegistry::getTableLocator()->get('TypeAnimations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeAnimations);

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
