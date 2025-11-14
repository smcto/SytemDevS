<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PipeEtape $pipeEtape
 */
?>
<?php
$titrePage = "Modification d'une  étape" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Etapes Pipeline',
    ['action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>



<div class="row">
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Informations</h4>
        </div>
        <div class="card-body">
            <?= $this->Form->create($pipeEtape) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
                                echo $this->Form->control('pipe_id', ['options' => $pipes,'required'=>true]);
                                echo $this->Form->control('nom',['required'=>true]);
                                //echo $this->Form->control('ordre',['required'=>true]);
                            ?>
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




