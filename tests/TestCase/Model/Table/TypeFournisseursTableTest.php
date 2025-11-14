<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeFournisseursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeFournisseursTable Test Case
 */
class TypeFournisseursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeFournisseursTable
     */
    public $TypeFournisseurs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.type_fournisseurs',
        'app.fournisseurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TypeFournisseurs') ? [] : ['className' => TypeFournisseursTable::class];
        $this->TypeFournisseurs = TableRegistry::getTableLocator()->get('TypeFournisseurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeFournisseurs);

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
