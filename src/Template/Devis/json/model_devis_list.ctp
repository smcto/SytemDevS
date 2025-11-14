<?php
$theJson = json_encode($listeDevis);
$callBack = $this->request->getQuery('callback');
if(!empty($callBack)){
    echo $callBack.'('.$theJson.')';
}else{
    echo $theJson;
}