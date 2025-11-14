<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LieuTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LieuTypesTable Test Case
 */
class LieuTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LieuTypesTable
     */
    public $LieuTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lieu_types',
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
        $config = TableRegistry::getTableLocator()->exists('LieuTypes') ? [] : ['className' => LieuTypesTable::class];
        $this->LieuTypes = TableRegistry::getTableLocator()->get('LieuTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LieuTypes);

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
