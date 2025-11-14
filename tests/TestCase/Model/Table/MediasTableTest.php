<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MediasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MediasTable Test Case
 */
class MediasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MediasTable
     */
    public $Medias;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.medias',
        'app.actu_bornes_has_medias',
        'app.bornes_has_medias',
        'app.model_bornes_has_medias'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Medias') ? [] : ['className' => MediasTable::class];
        $this->Medias = TableRegistry::getTableLocator()->get('Medias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Medias);

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
