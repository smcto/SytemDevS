<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('langues/langues.js', ['block' => 'script']); ?>

<?php
$titrePage = "Ajouter une nouvelle langue " ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"><?= $titrePage ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($langue) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('nom',["label"=>"Nom *: ","class"=>"form-control"]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $this->Form->control('code',["label"=>"Code *: ","class"=>"form-control"]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $this->Form->control('note',["label"=>"Note par défaut *: ","class"=>"tinymce",]) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $this->Form->control('retard',["label"=>"Texte en bas sur les retards de paiement *: ","class"=>"tinymce",]) ?>
                            </div>
                        </div>

                       <div class="form-actions">
                       <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                       <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                   </div>
               <?= $this->Form->end() ?>
                    </div>
            </div>
        </div>
    </div>
</div>



