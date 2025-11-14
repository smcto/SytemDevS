<?php echo $this->Html->script('objectifs/view.js?time='.time(), ['block' => 'script']); ?>
<?php 
    $titreList = $titrePage = "Objectifs commerciaux";
    $this->assign('title', $titrePage);
    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index'] );
        $this->Breadcrumbs->add($commercial->get('FullName'));
        echo $this->element('breadcrumb',['titrePage' => $titreList]);
    $this->end();   
?>

<?php $this->start('actionTitle'); ?>
    <button type="button" class="btn btn-rounded pull-right hidden-sm-down btn-success mr-2" data-toggle="modal" data-target="#ajout-obj">Créer un objectif</button>
<?php $this->end(); ?>

<div class="modal fade" id="ajout-obj">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->create(false, ['class' => 'form-modal-add', 'type' => 'GET', 'url' => ['controller' => 'Objectifs', 'action'=> 'add', $commercial->id]]); ?>
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un objectif - <?= $commercial->get('FullName') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
                <div class="modal-body">
                    <?= $this->Form->control('annee', ['default' => date('Y'), 'options' => $annees]); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-rounded" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary btn-rounded">Soumettre</button>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="90%">Année</th>
                        <th width="5%"></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($objectifsAnnees as $key => $objectifsAnnee): ?>
                        <tr>
                            <td>
                                <?= $objectifsAnnee->annee ?>
                            </td>
                            <td>
                                <a href="<?= $this->Url->build(['controller' => 'Objectifs', 'action' => 'add', $commercial->id, $objectifsAnnee->id, 'annee' => $objectifsAnnee->annee])?>" class=""><i class="mdi mdi-pencil text-inverse"></i></a>
                                <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['controller' => 'ObjectifsAnnees', 'action' => 'delete', $objectifsAnnee->id, $commercial->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>