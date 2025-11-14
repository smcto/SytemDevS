<?php
namespace App\Test\TestCase\Controller;

use App\Controller\DevisFacturesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\DevisFacturesController Test Case
 */
class DevisFacturesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.devis_factures',
        'app.ref_commercials',
        'app.clients',
        'app.info_bancaires',
        'app.modele_devis_factures_categories',
        'app.modele_devis_factures_sous_categories',
        'app.devis_factures_produits',
        'app.antennes',
        'app.devis_factures_antennes'
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
