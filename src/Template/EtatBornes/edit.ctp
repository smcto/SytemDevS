<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne $etatBorne
 */
?>
<?php
$titrePage = "Modifier état borne " ;
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
                <?= $this->Form->create($etatBorne) ?>
                    <div class="form-body">
                        <h3 class="card-title">Informations</h3>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $this->Form->control('etat_general',["id"=>"etat_general","label"=>"Etat général *: ","class"=>"form-control"]) ?>
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
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $etatBorne->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $etatBorne->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Etat Bornes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bornes'), ['controller' => 'Bornes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Borne'), ['controller' => 'Bornes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="etatBornes form large-9 medium-8 columns content">
    <?= $this->Form->create($etatBorne) ?>
    <fieldset>
        <legend><?= __('Edit Etat Borne') ?></legend>
        <?php
            echo $this->Form->control('etat_general');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->
