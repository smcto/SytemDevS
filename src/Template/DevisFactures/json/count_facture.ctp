<?php 
$res['total_ht'] = $this->Number->currency(0);
$res['total_ttc'] = $this->Number->currency(0);
if(!empty($facture)){
    $res['total_ht'] = $this->Number->currency($facture[0]->total_ht);
    $res['total_ttc'] = $this->Number->currency($facture[0]->total_ttc);
}
echo json_encode($res);
