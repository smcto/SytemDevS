<?php
namespace App\Test\TestCase\Model\Behavior;

use App\Model\Behavior\SoftDeleteBehavior;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Behavior\SoftDeleteBehavior Test Case
 */
class SoftDeleteBehaviorTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Behavior\SoftDeleteBehavior
     */
    public $SoftDelete;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->SoftDelete = new SoftDeleteBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SoftDelete);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
