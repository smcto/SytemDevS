<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FactureDeduction $factureDeduction
 */
?>

<?php
$titrePage = "Ajout chiffre" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Tableu de board facturation',
    ['controller' => 'FactureDeductions', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Informations générales</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($factureDeduction) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                           <?php 
                           $annee = ["2019" => "2019", "2020" => "2020","2021" => "2021", "2022" => "2022" ];
                           echo $this->Form->control('annee',['id'=>'anne','label' => 'Année *', 'options'=>$annee,'empty'=>'Séléctionner','required'=>true]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                           <?php echo $this->Form->control('ca_ht_deduire',['label' => 'CA HT à déduire','type'=>'text']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('avoir_ht_deduire',['label' => 'Avoirs HT à déduire','type'=>'text']); ?>
                        </div>
                   </div>
                   <div class="row">
                        <div class="col-md-6">
                           <?php echo $this->Form->control('pca_part',['label' => 'PCA PART  N-1 à ajouter ','type'=>'text']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('pca_pro',['label' => ' PCA PRO  N-1 à ajouter ','type'=>'text']); ?>
                        </div>
                   </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
