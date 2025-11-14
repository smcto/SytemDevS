<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OptionFondVertsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OptionFondVertsTable Test Case
 */
class OptionFondVertsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OptionFondVertsTable
     */
    public $OptionFondVerts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.option_fond_verts',
        'app.opportunites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OptionFondVerts') ? [] : ['className' => OptionFondVertsTable::class];
        $this->OptionFondVerts = TableRegistry::getTableLocator()->get('OptionFondVerts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OptionFondVerts);

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
