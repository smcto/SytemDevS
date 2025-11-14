<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StripeCsvFilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StripeCsvFilesTable Test Case
 */
class StripeCsvFilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StripeCsvFilesTable
     */
    public $StripeCsvFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.stripe_csv_files',
        'app.stripe_csvs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StripeCsvFiles') ? [] : ['className' => StripeCsvFilesTable::class];
        $this->StripeCsvFiles = TableRegistry::getTableLocator()->get('StripeCsvFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StripeCsvFiles);

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
