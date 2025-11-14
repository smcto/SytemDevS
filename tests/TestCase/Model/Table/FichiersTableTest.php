<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FichiersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FichiersTable Test Case
 */
class FichiersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FichiersTable
     */
    public $Fichiers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fichiers',
        'app.antennes',
        'app.posts',
        'app.actu_bornes',
        'app.model_bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Fichiers') ? [] : ['className' => FichiersTable::class];
        $this->Fichiers = TableRegistry::getTableLocator()->get('Fichiers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fichiers);

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
