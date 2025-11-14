<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OptionEvenement $optionEvenement
 */
?>
<?php
$titrePage = "Création option évenement " ;
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
                <?= $this->Form->create($optionEvenement) ?>
                    <div class="form-body">
                        <h3 class="card-title">Informations</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('nom',["id"=>"nom","label"=>"Nom *: ","class"=>"form-control"]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->control('description',["id"=>"description","label"=>"Description : ","class"=>"form-control", ]) ?>
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
        <li><?= $this->Html->link(__('List Option Evenements'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="optionEvenements form large-9 medium-8 columns content">
    <?= $this->Form->create($optionEvenement) ?>
    <fieldset>
        <legend><?= __('Add Option Evenement') ?></legend>
        <?php
            echo $this->Form->control('nom');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->
