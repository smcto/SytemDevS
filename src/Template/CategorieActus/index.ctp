<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategorieActus[]|\Cake\Collection\CollectionInterface $categorieActus
 */
?>
<?php
$titrePage = "Liste des catégories de ticket" ;
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
    echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-rounded btn-success" ]);
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
                                <th scope="col"><?= $this->Paginator->sort('titre') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($categorieActus as $categorieActu): ?>
                                <tr>
                                   <td><?= $this->Html->link($categorieActu->titre, ['action' => 'edit', $categorieActu->id]) ?></td>
                                    <td><?= h($categorieActu->created) ?></td>
                                    <td>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $categorieActu->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
