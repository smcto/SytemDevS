<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Messagery[]|\Cake\Collection\CollectionInterface $messageries
 */
?>

<?php
$titrePage = "Liste des SMS" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link(__('Envoyer un SMS'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
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
                            <th>Uilisateur(s)</th>
                            <th>Client(s)</th>
                            <th>Destinateur</th>
                            <th>Sms Test</th>
                            <th>Envoyé</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($messageries as $messagerie): ?>
                        <tr>
                            <td>
                                <?php  if(!empty($messagerie->users)) {
                                    $users = [];
                                    foreach ($messagerie->users as $user){
                                        $users[] = $user->nom;
                                    }
                                    echo implode(', ', $users);
                                }
                                ?>
                            </td>
                            <td>
                                <?php  if(!empty($messagerie->clients)) {
                                    $clients = [];
                                    foreach ($messagerie->clients as $client){
                                        $clients[] = $client->nom;
                                    }
                                    echo implode(', ', $clients);
                                }
                                ?>
                            </td>
                            <td><?= $messagerie->destinateur ?></td>
                            <td><?php $etats = [''=>'Non', '0'=>'Non', '1'=>'Oui']; echo $etats[$messagerie->is_test] ?></td>
                            <td><?php echo $etats[$messagerie->is_sent] ?></td>
                            <td>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $messagerie->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
