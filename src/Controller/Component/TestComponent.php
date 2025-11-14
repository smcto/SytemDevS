<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Datasource\ModelAwareTrait;
/**
 * Pour effectuer divers fonctions de test
 */
class TestComponent extends Component
{
    use ModelAwareTrait;

    public $components = ['Utilities'];

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->loadModel('Devis');
    }

    // si en cas de debug
    public function relistIndentDevis()
    {
        $listeDevis = $this->Devis->find()->order(['Devis.id' => 'asc']);
        foreach ($listeDevis as $key => $devis) {
            $this->Devis->updateAll(['indent' => substr($devis->indent, 0, 12).sprintf("%05d", $key+1)], ['id' => $devis->id]);
        }
        die();
    }

    public function majTypeCommercial()
    {
        $this->Devis->Clients->updateAll(['type_commercial' => 'client'], ['type_commercial IS' => null]);
    }
}
?>