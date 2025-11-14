<?php
namespace App\Test\TestCase\Form;

use App\Form\StripeForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\StripeForm Test Case
 */
class StripeFormTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Form\StripeForm
     */
    public $Stripe;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Stripe = new StripeForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Stripe);

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
