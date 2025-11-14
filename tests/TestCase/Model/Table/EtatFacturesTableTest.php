<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EtatFacturesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EtatFacturesTable Test Case
 */
class EtatFacturesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EtatFacturesTable
     */
    public $EtatFactures;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.etat_factures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EtatFactures') ? [] : ['className' => EtatFacturesTable::class];
        $this->EtatFactures = TableRegistry::getTableLocator()->get('EtatFactures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EtatFactures);

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
