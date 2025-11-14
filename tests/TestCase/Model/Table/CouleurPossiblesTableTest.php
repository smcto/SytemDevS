<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CouleurPossiblesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CouleurPossiblesTable Test Case
 */
class CouleurPossiblesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CouleurPossiblesTable
     */
    public $CouleurPossibles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.couleur_possibles',
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
        $config = TableRegistry::getTableLocator()->exists('CouleurPossibles') ? [] : ['className' => CouleurPossiblesTable::class];
        $this->CouleurPossibles = TableRegistry::getTableLocator()->get('CouleurPossibles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CouleurPossibles);

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
