<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisFacturesPreferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisFacturesPreferencesTable Test Case
 */
class DevisFacturesPreferencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisFacturesPreferencesTable
     */
    public $DevisFacturesPreferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_factures_preferences',
        'app.info_bancaires',
        'app.adresses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DevisFacturesPreferences') ? [] : ['className' => DevisFacturesPreferencesTable::class];
        $this->DevisFacturesPreferences = TableRegistry::getTableLocator()->get('DevisFacturesPreferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevisFacturesPreferences);

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
