<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AvoirsProduitsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AvoirsProduitsTable Test Case
 */
class AvoirsProduitsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AvoirsProduitsTable
     */
    public $AvoirsProduits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.avoirs_produits',
        'app.catalog_unites',
        'app.avoirs',
        'app.catalog_produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AvoirsProduits') ? [] : ['className' => AvoirsProduitsTable::class];
        $this->AvoirsProduits = TableRegistry::getTableLocator()->get('AvoirsProduits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AvoirsProduits);

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
