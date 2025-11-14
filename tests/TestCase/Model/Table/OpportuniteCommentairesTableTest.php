<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OpportuniteCommentairesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OpportuniteCommentairesTable Test Case
 */
class OpportuniteCommentairesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OpportuniteCommentairesTable
     */
    public $OpportuniteCommentaires;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.opportunite_commentaires',
        'app.opportunites',
        'app.staffs',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OpportuniteCommentaires') ? [] : ['className' => OpportuniteCommentairesTable::class];
        $this->OpportuniteCommentaires = TableRegistry::getTableLocator()->get('OpportuniteCommentaires', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OpportuniteCommentaires);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
