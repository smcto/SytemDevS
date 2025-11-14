<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Core\Configure;

class ConfigureHelper extends Helper
{

    public function read($key)
    {
        return Configure::read($key);
    }
}
?>