<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Statut $statut
 */
?>

<?php
$titrePage = "Modifier type de contact" ;
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
                <?= $this->Form->create($statut) ?>
                    <div class="form-body">
                        <h3 class="card-title">Informations</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('titre',["id"=>"titre","label"=>"Type de contact *: ","class"=>"form-control"]) ?>
                            </div>
                        </div>

                       <div class="form-actions">
                       <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                       <?= $this->Form->button(__('Cancel'),["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
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
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $statut->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $statut->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Statuts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contacts'), ['controller' => 'Contacts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contact'), ['controller' => 'Contacts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="statuts form large-9 medium-8 columns content">
    <?= $this->Form->create($statut) ?>
    <fieldset>
        <legend><?= __('Edit Statut') ?></legend>
        <?php
            echo $this->Form->control('titre');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->
