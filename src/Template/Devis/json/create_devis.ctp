<?php
$theJson = json_encode($return);
$callBack = $this->request->getQuery('callback');
if(!empty($callBack)){
    echo $callBack.'('.$theJson.')';
}else{
    echo $theJson;
}