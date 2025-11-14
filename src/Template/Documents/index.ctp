
<?php
$titrePage = "Liste des factures" ;
if($typeDocument == 'estimate'){
    $titrePage = 'Liste des devis';
}
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
    'Réglages',
    ['controller' => 'Dashboards', 'action' => 'reglages']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-body">
                      <div class="row">
                       <?php  
                        echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);   
                            echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); 
                            
                           /* $classType ="";
                            if(!empty($typeDocument)){
                                $classType ="hidden";
                            }*/
                                $optionType = array('invoice'=>'Factures','estimate'=>'Devis');
                                echo $this->Form->control('type', ['label' => false ,'options'=>$optionType, 'value'=> $typeDocument, 'class'=>'form-control ' ,'empty'=>'Séléctionnez un modèle','style'=>'display:none;'] );
                            
            
                            echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary','style'=>'margin: 0 10px 0 10px'] );
                            echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index','?'=>['typeDocument'=>$typeDocument]], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false,'style'=>'margin: 0 10px 0 0']);            
        
                        echo $this->Form->end(); 
                          ?>
                        </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Objet</th>
                                <th>Motant TTC</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($documents as $document ): ?>
                                <tr>
                                    <td><?= $document->objet ?></td>
                                    <td><?= h($document->montant_ttc).' €' ?></td>
                                    <td><?= $document->has('client') ? $this->Html->link($document->client->nom, ['controller' => 'Clients', 'action' => 'view', $document->client->id]) : '' ?></td>
                                    <td><?= $document->date ?></td>
                                    <td>
                                        <a href="<?= $document->url_sellsy ?>">Télécharger</a>
                                    </td>
                                </tr>
                             <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>

</div>