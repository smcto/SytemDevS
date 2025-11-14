<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pays[]|\Cake\Collection\CollectionInterface $payss
 */
?>
<?php
$titrePage = "Listes des pays";
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
                            <th>Nom</th>
                            <th>Phone code</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($payss as $pays): $iso = strtolower($pays->iso) ;?>
                        <tr>
                            <td><?= $this->Html->link('<i class="flag-icon flag-icon-'.$iso.'" id="'.$iso.'"></i> '.$pays->name_fr, ['action' => 'edit', $pays->id], ['escape'=>false]) ?></td>
                            <td><?= '+'.$pays->phonecode ?></td>
                            <td>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $pays->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
