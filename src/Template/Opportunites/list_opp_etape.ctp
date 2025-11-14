<?php
if(!empty($etape["opportunites"])){
    foreach ($etape["opportunites"] as $key => $opportunite) {
        echo $this->element('Opportunites/one_opportunite',['opportunite'=>$opportunite,'page'=>$etape['page']]); 
    }
}
?>