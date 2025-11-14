<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AvoirsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AvoirsTable Test Case
 */
class AvoirsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AvoirsTable
     */
    public $Avoirs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.avoirs',
        'app.ref_commercials',
        'app.clients',
        'app.info_bancaires',
        'app.modele_avoirs_categories',
        'app.modele_avoirs_sous_categories',
        'app.sellsy_clients',
        'app.sellsy_docs',
        'app.devis_factures',
        'app.sellsy_estimates',
        'app.client_contacts',
        'app.avoirs_produits'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Avoirs') ? [] : ['className' => AvoirsTable::class];
        $this->Avoirs = TableRegistry::getTableLocator()->get('Avoirs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Avoirs);

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
