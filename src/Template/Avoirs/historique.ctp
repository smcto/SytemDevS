<?php 
    //debug($avoir);
    $titrePage = "Historique devis :".$avoir->indent ;
    $this->assign('title', $titrePage);

    $this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Dashboards',
        ['controller' => 'Dashboards', 'action' => 'index']
    );
    
    $this->Breadcrumbs->add(
        'Devis',
        ['controller' => 'Devis', 'action' => 'index']
    );

    $this->Breadcrumbs->add($titrePage);
    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();
?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Avoir : <?= $avoir->indent ?></h3>
                    <hr>
                    <div class="form-group row">
                        <label class="control-label col-md-6">Date de création : </label>
                        <div class="col-md-6 ">
                            <?= $avoir->created ? $avoir->created->format('d/m/Y H:i'):"" ?>
                        </div>
                        <label class="control-label col-md-6">Statut : </label>
                        <div class="col-md-6">
                            <?= @$devis_avoirs_status[$avoir->status] ?>
                        </div>
                        
                    </div>  
                </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Historique</h4>
            </div>
            <div class="card-body">
                <div class="related">
                    <?php if (!empty($avoir->statut_historiques)){ ?>
                    <table class="table table-striped" >
                        <tr>
                            <th scope="col"><?= __('Action') ?></th>
                            <th scope="col"><?= __('Date') ?></th>
                            <th scope="col"><?= __('User') ?></th>
                        </tr>
                        <?php foreach ($avoir->statut_historiques as $historique) { ?>
                        <tr>
                            <td><?= h(@$devis_avoirs_status[$historique->statut_document]) ?></td>
                            <td><?= $historique->time ?></td>
                            <td>
                                <?php if ($historique->user) : ?>
                                    <img alt="Image" src="<?= $historique->user->url_photo ?>" class="avatar" data-title="<?= $historique->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                                <?php else : ?>
                                    --
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                    <?php }else{ ?>
                        <p>Aucun historique.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>