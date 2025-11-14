<?php 
$res['count_devise'] = $this->Number->currency(0);
if(!empty($devis)){
    $res['count_devise'] = $this->Number->currency($devis[0]->total_devise);
}
echo json_encode($res);
