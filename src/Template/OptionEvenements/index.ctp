<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OptionEvenement[]|\Cake\Collection\CollectionInterface $optionEvenements
 */
?>

<?php
$titrePage = "Liste des options événements" ;
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
echo $this->Html->link(__('Create'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
$this->end();

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('nom', 'Nom') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($optionEvenements as $optionEvenement): ?>
                        <tr>
                            <td><?= h($optionEvenement->nom) ?></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-pencil text-inverse"></i>', ['action' => 'edit', $optionEvenement->id], ['escape'=>false]) ?>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $optionEvenement->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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

