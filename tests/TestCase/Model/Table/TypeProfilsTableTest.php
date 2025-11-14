<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeProfilsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeProfilsTable Test Case
 */
class TypeProfilsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeProfilsTable
     */
    public $TypeProfils;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.type_profils',
        'app.user_type_profils'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TypeProfils') ? [] : ['className' => TypeProfilsTable::class];
        $this->TypeProfils = TableRegistry::getTableLocator()->get('TypeProfils', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeProfils);

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
