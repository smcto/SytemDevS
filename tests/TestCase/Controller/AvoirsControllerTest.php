<?php
namespace App\Test\TestCase\Controller;

use App\Controller\AvoirsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\AvoirsController Test Case
 */
class AvoirsControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
