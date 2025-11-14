<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SmsAutosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SmsAutosTable Test Case
 */
class SmsAutosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SmsAutosTable
     */
    public $SmsAutos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sms_autos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SmsAutos') ? [] : ['className' => SmsAutosTable::class];
        $this->SmsAutos = TableRegistry::getTableLocator()->get('SmsAutos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SmsAutos);

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
