<?php 
    $titreList = $titrePage = "Objectifs commerciaux";
    $this->assign('title', $titrePage);
    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index'] );
        $this->Breadcrumbs->add($titrePage);
        echo $this->element('breadcrumb',['titrePage' => $titreList]);
    $this->end();   
?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="90%">Nom</th>
                        <th width="5%"></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($commerciaux as $key => $commercial): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link($this->Html->image($commercial->url_photo,['class'=> 'avatar']).'  '.$commercial->full_name, ['controller' => 'users', 'action' => 'view', $commercial->id], ['escape'=>false]) ?>
                            </td>
                            <td>
                                <!-- <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['controller' => 'Users', 'action' => 'delete', $commercial->id, $group_user], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?> -->
                                <a href="<?= $this->Url->build(['controller' => 'Objectifs', 'action' => 'view', $commercial->id])?>" class="btn btn-sm btn-rounded btn-dark">Voir les objectifs</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>