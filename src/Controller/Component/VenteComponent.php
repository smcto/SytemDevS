<?php
namespace App\Controller\Component;
use Cake\Controller\Component;

class VenteComponent extends Component
{
    public function initialize(array $config)
    {
        parent::initialize($config);
    }

    function putInSession($keyInSession, $data, $arrayFields)
    {
        foreach ($arrayFields as $key => $value) {
            isset($data[$value])
                ? $this->getController()->request->getSession()->write($keyInSession.'.'.$value, $data[$value])
                : $this->getController()->request->getSession()->write($keyInSession.'.'.$value, null);
        }
        return;
    }
}
?>