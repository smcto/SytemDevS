<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('calendar/dist/lib/jquery-ui.min.js', ['block' => 'script']); ?>
<?= $this->Html->script('bons/bons-prepa.js?'. time(), ['block' => 'script']); ?>
    
<?= $this->Html->css('bons/bons-prepa.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('table-uniforme.css?'. time(), ['block' => 'css']); ?>
<?= $this->Html->css('fontawesome5/css/all.min.css', ['block' => 'css']); ?>

<?php
$total = 0;
$titrePage = "Modification - Bons de préparation" ;
?>

<?php $this->assign('custom_title', '<h1 class="m-0 top-title">' . $titrePage . '</h1>'); ?>
<?php $this->assign('title', $titrePage) ?>

<?php $this->start('bloc_btn') ?>
    <div class="float-right">
        <a href="javascript:void(0);" class="btn btn-sm btn-rounded btn-primary save">Enregistrer</a>
        <a href="<?= $this->Url->build(['controller' => 'BonsPreparations', 'action' => 'index']) ?>" class="btn btn-sm btn-rounded btn-inverse">Annuler</a>
    </div>
<?php $this->end() ?>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                
                <?= $this->Form->create($bonsPrepa, ['class' => 'form_prepa']); ?>

                    <div class="row col-6">
                        <label for="" class="col-md-4">Numero BP : </label>
                        <div class="col-md-8"><?= $bonsPrepa->indent ?> </div>
                    </div>

                    <div class="row col-6">
                        <label for="" class="col-md-4">Date de livraison souhaitée: </label>
                        <div class="col-md-8"><?= @$type_date[$bonsPrepa->type_date] ?> </div>
                    </div>

                    <div class="row col-6">
                        <label for="" class="col-md-4">Client : </label>
                        <div class="col-md-8">
                            <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $bonsPrepa->client_id]) ?>"><?= $bonsPrepa->client?$bonsPrepa->client->full_name : '-' ?></a> 
                        </div>
                    </div>

                    <div class="row col-6">
                        <label for="" class="col-md-4">Commentaire : </label>
                        <div class="col-md-8"><?= $bonsPrepa->commentaire ?> </div>
                    </div>

                    <br>
                    
                    <div class="row col-6">
                        <label for="" class="col-md-4">Date depart atelier : </label>
                        <div class="col-md-8"> <?= $this->Form->text('date_depart_atelier', ['type' => 'date', 'value' => $bonsPrepa->date_depart_atelier?$bonsPrepa->date_depart_atelier->format('Y-m-d') : '']) ?></div>
                    </div>
                    
                    <br>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th scope="col">Ref </th>
                                <th scope="col" width="40%">Libellé </th>
                                <th scope="col">Qté commandé </th>
                                <th scope="col" class="<?= $bonsPrepa->bons_preparation_id ? : 'hide' ?>">Restant à expédier </th>
                                <th scope="col" width="7%">Qté livrée </th>
                                <th scope="col" width="7%" class="hide">Rest </th>
                                <th scope="col">Observation </th>
                                <th scope="col" width="10%">Etat </th>
                            </tr>
                            </thead>
                            <tbody class="default-data" id="sortable">
                            <?php foreach ($bonsPrepa->bons_preparations_produits as $key => $produit): $total += $produit->quantite ?>
                                
                                <tr class="tr-<?=$produit->statut ?>">
                                    <td>
                                        <div class="mx-auto">
                                            <div class="col p-0 text-center order-ico">
                                                <a class=" fas fa-arrows-alt-v text-primary align-middle" href="javascript:void(0);"></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $produit->reference ?>
                                        <?= $this->Form->hidden("bons_preparations_produits.$key.reference") ?>
                                        <?= $this->Form->hidden("bons_preparations_produits.$key.id") ?>
                                        <?= $this->Form->hidden("bons_preparations_produits.$key.i_position", ['input-name' => 'i_position', 'label' => false, 'class' => 'i-position']); ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->control("bons_preparations_produits.$key.description_commercial", ['label' => false, 'class' => 'tinymce']) ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $produit->quantite ?>
                                        <?= $this->Form->hidden("bons_preparations_produits.$key.quantite", ['class' => 'quantite']) ?>
                                    </td>
                                    <td class="text-center <?= $bonsPrepa->bons_preparation_id ? : 'hide' ?>">
                                        <?= $produit->rest_a_livrer ?>
                                        <?= $this->Form->hidden("bons_preparations_produits.$key.rest_a_livrer", ['class' => 'rest_a_livrer']) ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->control("bons_preparations_produits.$key.quantite_livree", ['input-name' => 'quantite_livree', 'label' => false, 'max' => $produit->rest_a_livrer, 'min' => 0, 'disabled' => $produit->statut == 'complet' ? true : false]) ?>
                                        <br>
                                        <a href="javascript:void(0);" class="set-complet"><u> Complet</u></a>
                                    </td>
                                    <td class="text-center hide">
                                        <div class="rest-text"><?= is_numeric($produit->rest) ? $produit->rest : $produit->rest_a_livrer ?></div>
                                        <?= $this->Form->hidden("bons_preparations_produits.$key.rest", ['class' => 'rest', 'value' => is_numeric($produit->rest) ? $produit->rest : $produit->rest_a_livrer]) ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->control("bons_preparations_produits.$key.observation", ['label' => false, 'class' => 'tinymce']) ?>
                                    </td>
                                    <td>
                                        <div class="status-text <?=$produit->statut ?>"><?= @$statut_ligne[$produit->statut] ?></div>
                                        <?= $this->Form->hidden("bons_preparations_produits.$key.statut", ['label' => false, 'class' => 'status']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row m-t-40">
                        <div class="col-md-8">

                            <div class="row col-6">
                                <label for="" class="col-md-6">Nombre de palette(s) : </label>
                                <div class="col-md-6"><?= $this->Form->control("nombre_palettes", ['label' => false]) ?> </div>
                            </div>
                            <div class="row col-6">
                                <label for="" class="col-md-6">Nombre de carton(s) : </label>
                                <div class="col-md-6"><?= $this->Form->control("nombre_cartons", ['label' => false]) ?> </div>
                            </div>
                            <div class="row col-6">
                                <label for="" class="col-md-6">Poids : </label>
                                <div class="col-md-6"><?= $this->Form->control("poids", ['label' => false]) ?> </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <table class="table table-uniforme">
                                <thead class="">
                                    <tr class="hide">
                                        <th width="90%"></th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right">Total commandé : </td>
                                        <td class="text-right"><?= $total ?></td>
                                        <?= $this->Form->hidden('total_commande', ['id' => 'total_commande', 'value' => $total]) ?>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Total livré : </td>
                                        <td class="text-right total_livre"></td>
                                        <?= $this->Form->hidden('total_livre', ['id' => 'total_livre']) ?>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Rest à livré : </td>
                                        <td class="text-right rest_livre"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-actions hide">
                        <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                        <?= $this->Html->link('Annuler', ['action' => 'index'], ["class" => "btn btn-rounded btn-inverse", "escape" => false]);?>
                   </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
