<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessoiresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessoiresTable Test Case
 */
class AccessoiresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessoiresTable
     */
    public $Accessoires;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.accessoires',
        'app.accessoires_gammes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Accessoires') ? [] : ['className' => AccessoiresTable::class];
        $this->Accessoires = TableRegistry::getTableLocator()->get('Accessoires', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Accessoires);

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
