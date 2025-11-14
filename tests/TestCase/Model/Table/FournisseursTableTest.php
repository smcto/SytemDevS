<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FournisseursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FournisseursTable Test Case
 */
class FournisseursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FournisseursTable
     */
    public $Fournisseurs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fournisseurs',
        'app.antennes',
        'app.type_fournisseurs',
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
        $config = TableRegistry::getTableLocator()->exists('Fournisseurs') ? [] : ['className' => FournisseursTable::class];
        $this->Fournisseurs = TableRegistry::getTableLocator()->get('Fournisseurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fournisseurs);

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
