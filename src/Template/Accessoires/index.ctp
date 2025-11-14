<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('table-uniforme', ['block' => true]) ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>


<?php
$titrePage = "Liste des accessoires" ;
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

$this->start('actionTitle');
    echo $this->Html->link('Ajouter',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
$this->end();

?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                 <?= $this->Form->create(null, ['type' => 'get' ,'class'=>'','role'=>'form']); ?>
                     <div class="row">
                         <div class="col-md-2">
                             <?= $this->Form->control('gamme_borne_id', ['empty' => 'Sélectionner une gamme', 'options' => $gammesBornes, 'default' => $gamme_borne_id, 'label' => false, 'class' => 'form-control selectpicker']); ?>
                         </div>

                         <div class="col-md-3 p-l-0">
                             <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary '] );?>
                             <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                         </div>
                     </div>
                 <?= $this->Form->end(); ?>

                <div class="table-responsive">
                    <table class="table table-uniforme">
                        <thead>
                            <tr>
                                <th>Accessoire</th>
                                <th>Declinaison</th>
                                <th>Gamme</th> 
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($accessoires as $accessoire): ?>
                                <tr class="bg-light">
                                    <td><?= $this->Html->link($accessoire->nom, ['action' => 'edit', $accessoire->id]) ?></td>
                                    <td colspan="2"></td>
                                    <td>
                                        <a href="<?= $this->Url->build(['controller' => 'SousAccessoires', 'action' => 'add', $accessoire->id]) ?>">Ajouter une déclinaison</a>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $accessoire->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                    </td>
                                </tr>

                                <?php foreach ($accessoire->sous_accessoires as $key => $sous_accessoires): ?>
                                    <tr>
                                        <td></td>
                                        <td><?= $this->Html->link($sous_accessoires->name, ['controller' => 'SousAccessoires', 'action' => 'edit', $sous_accessoires->id]) ?></td>
                                        <td>
                                            <?php if ($sous_accessoires->gammes_bornes): ?>
                                                <?= $this->Text->toList($sous_accessoires->get('GammesBornesList'), '<br>', '<br>') ?>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['controller' => 'SousAccessoires', 'action' => 'delete', $sous_accessoires->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                             <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>

</div>


