<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypeLicencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypeLicencesTable Test Case
 */
class TypeLicencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TypeLicencesTable
     */
    public $TypeLicences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.type_licences'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TypeLicences') ? [] : ['className' => TypeLicencesTable::class];
        $this->TypeLicences = TableRegistry::getTableLocator()->get('TypeLicences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TypeLicences);

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
