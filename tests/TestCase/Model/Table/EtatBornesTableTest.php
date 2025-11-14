<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EtatBornesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EtatBornesTable Test Case
 */
class EtatBornesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EtatBornesTable
     */
    public $EtatBornes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.etat_bornes',
        'app.bornes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EtatBornes') ? [] : ['className' => EtatBornesTable::class];
        $this->EtatBornes = TableRegistry::getTableLocator()->get('EtatBornes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EtatBornes);

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
