<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EtatBorne[]|\Cake\Collection\CollectionInterface $etatBornes
 */
?>

<?php
$titrePage = "Liste des groupes des clients" ;

$this->assign('title', 'Groupe clients');

$this->start('breadcumb');
$this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
        'Réglages',
        ['controller' => 'Dashboards', 'action' => 'reglages']
);
$this->Breadcrumbs->add(
        'Clients',
        ['controller' => 'Clients', 'action' => 'index']
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
                            <th scope="col">Groupe</th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($groupeClients as $groupe): ?>
                        <tr>

                            <td><?= $this->Html->link($groupe->nom, ['action' => 'add', $groupe->id]) ?></td>
                            <td>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $groupe->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
