<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SecteurGeographiquesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SecteurGeographiquesTable Test Case
 */
class SecteurGeographiquesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SecteurGeographiquesTable
     */
    public $SecteurGeographiques;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.secteur_geographiques',
        'app.antennes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SecteurGeographiques') ? [] : ['className' => SecteurGeographiquesTable::class];
        $this->SecteurGeographiques = TableRegistry::getTableLocator()->get('SecteurGeographiques', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SecteurGeographiques);

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
