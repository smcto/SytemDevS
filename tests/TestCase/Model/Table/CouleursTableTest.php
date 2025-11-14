<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CouleursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CouleursTable Test Case
 */
class CouleursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CouleursTable
     */
    public $Couleurs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.couleurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Couleurs') ? [] : ['className' => CouleursTable::class];
        $this->Couleurs = TableRegistry::getTableLocator()->get('Couleurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Couleurs);

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
