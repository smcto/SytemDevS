<?php

namespace App\View\Helper;

use Cake\View\Helper;

class AppHelper extends Helper
{
    public function omitLastVirg($string)
    {
        return rtrim(trim($string), ", \t\n");
    }
}
?>