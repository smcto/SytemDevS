<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Stripe Form.
 */
class StripeForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema;
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator
            ->requirePresence('email', true, 'Champ email obligatoire')->notEmpty('email', 'Champ email obligatoire')->email('email')
            ->notEmpty('echeance')
            // ->requirePresence('montant', true, 'Aucun montant n\'a été défini')
            ->requirePresence('stripeToken', true, 'Stripe token empty')->notEmpty('stripeToken')
        ;
        return $validator;
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data)
    {
        return true;
    }
}
