<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevisFacturesFooterTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevisFacturesFooterTable Test Case
 */
class DevisFacturesFooterTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DevisFacturesFooterTable
     */
    public $DevisFacturesFooter;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_factures_footer'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DevisFacturesFooter') ? [] : ['className' => DevisFacturesFooterTable::class];
        $this->DevisFacturesFooter = TableRegistry::getTableLocator()->get('DevisFacturesFooter', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DevisFacturesFooter);

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
