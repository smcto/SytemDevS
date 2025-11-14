<?php echo $this->Html->css('objectifs/add.css?time='.time(), ['block' => 'css']); ?>
<?php echo $this->Html->css('table-uniforme.css', ['block' => 'css']); ?>
<?php echo $this->Html->script('objectifs/add.js?time='.time(), ['block' => 'script']); ?>


<?php 
    $titreList = $titrePage = "Objectif";
    $this->assign('title', $titrePage);
    $this->start('breadcumb');
        $this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index'] );
        $this->Breadcrumbs->add($commercial->get('FullName'));
        echo $this->element('breadcrumb',['titrePage' => $titreList. ' - '.$annee]);
    $this->end();   
?>

<?php $this->start('actionTitle'); ?>
    <a href="<?= $this->Url->build(['action' => 'view', $commercial->id]) ?>" class="btn btn-rounded pull-right hidden-sm-down btn-primary mr-2" >Liste des objectifs</a>
<?php $this->end(); ?>

<div class="card">
    <div class="card-body">
        <?= $this->Form->create($objectifsAnneeEntity); ?>
    
            <?php echo $this->Form->hidden('annee', ['value' => $annee]); ?>

            <table class="table table-bordered table-objectifs table-uniforme">
                <thead>
                    <tr>
                        <th width="10%"></th>
                        <?php foreach ($mois as $key => $moi): ?>
                            <th class="mois"><?= $moi ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($objectifs_annee_id): ?>
                        <?php echo $this->Form->hidden('id', ['value' => $objectifs_annee_id]); ?>
                        <?php foreach ($objectifsAnneeEntity->objectifs_commerciaux as $key => $objectifs_commerciaux): ?>

                            <?php $devisTypeDoc = $objectifs_commerciaux->devis_type_doc ?>
                            <?php $montants = $objectifs_commerciaux->montants ?>
                            <tr>
                                <td><?= $devisTypeDoc->nom ?></td>
                                <?php foreach ($mois as $keyMois => $moi): ?>
                                    <td class="<?= $keyMois ?>">
                                        <?= $this->Form->control("objectifs_commerciaux.$devisTypeDoc->id.montants.$keyMois", ['type' => 'number', 'value' => $montants[$keyMois] ?? '', 'step' => '0.01', 'label' => false, 'class' => 'form-control montant']); ?>
                                        <?= $this->Form->hidden("objectifs_commerciaux.$devisTypeDoc->id.devis_type_doc_id", ['value' => $devisTypeDoc->id, 'type' => 'number', 'step' => '0.01', 'label' => false]); ?>
                                        <?= $this->Form->hidden("objectifs_commerciaux.$devisTypeDoc->id.id", ['value' => $objectifs_commerciaux->id, 'type' => 'number', 'step' => '0.01', 'label' => false]); ?>
                                    </td>
                                <?php endforeach ?>
                            </tr>

                        <?php endforeach ?>
                    <?php else: ?>

                        <?php foreach ($devisTypeDocs as $key => $devisTypeDoc): ?>
                            <tr>
                                <td><?= $devisTypeDoc->nom ?></td>
                                <?php foreach ($mois as $keyMois => $moi): ?>
                                    <td class="<?= $keyMois ?>">
                                        <?= $this->Form->control("objectifs_commerciaux.$devisTypeDoc->id.montants.$keyMois", ['type' => 'number', 'step' => '0.01', 'label' => false, 'class' => 'form-control montant']); ?>
                                        <?= $this->Form->hidden("objectifs_commerciaux.$devisTypeDoc->id.devis_type_doc_id", ['value' => $devisTypeDoc->id, 'type' => 'number', 'step' => '0.01', 'label' => false]); ?>
                                    </td>
                                <?php endforeach ?>
                            </tr>
                        <?php endforeach ?>

                    <?php endif ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <?php foreach ($mois as $keyMois => $moi): ?>
                            <td class="<?= $keyMois ?>"><span class="total"></span></td>
                        <?php endforeach ?>
                    </tr>
                </tfoot>
            </table>

            <div class="clearfix">
                <b>Montant total</b> : <span class="grand-total"></span>
            </div>

            <button type="submit" class="btn btn-roundedhidden-sm-down btn-success float-right" data-toggle="modal" data-target="#ajout-obj">Enregistrer</button>
        <?= $this->form->end() ?>
    </div>
</div>