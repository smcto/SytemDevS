<?php
namespace App\Test\TestCase\Controller;

use App\Controller\OpportunitesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\OpportunitesController Test Case
 */
class OpportunitesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.opportunites',
        'app.opportunite_statuts',
        'app.pipelines',
        'app.pipeline_etapes',
        'app.type_clients',
        'app.source_leads',
        'app.contact_raisons',
        'app.type_evenements',
        'app.opportunite_clients'
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
