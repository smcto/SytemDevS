<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DebitInternet $debitInternet
 */
?>

<?php
$titrePage = "Création d'un nouveau débit " ;
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
                <?= $this->Form->create($debitInternet) ?>
                    <div class="form-body">
                        <h3 class="card-title">Informations</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('valeur',["id"=>"valeur","label"=>"Valeur *: ","class"=>"form-control"]) ?>
                            </div>
                            <div class="col-sm-6 hide">
                                <?= $this->Form->control('information',["id"=>"information","label"=>"Information : ","class"=>"form-control"]) ?>
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



<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Debit Internets'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="debitInternets form large-9 medium-8 columns content">
    <?= $this->Form->create($debitInternet) ?>
    <fieldset>
        <legend><?= __('Add Debit Internet') ?></legend>
        <?php
            echo $this->Form->control('valeur');
            echo $this->Form->control('information');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->
