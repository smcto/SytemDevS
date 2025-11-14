<?php $this->extend('vente_layout') ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('table-uniforme', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('ventes/materiel.css', ['block' => true]) ?>

<?php $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?php $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?php $this->Html->script('html5-editor/bootstrap-wysihtml5.fr-FR.js', ['block' => true]); ?>
<?php $this->Html->script('ventes/materiel.js?time='.time(), ['block' => 'script']); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>


<!-- Modal -->
<div class="modal fade modal-equipement" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ajout accessoire(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create(null, ['type' => 'get' ,'class'=> 'form-type-equipements form-filtre','role'=>'form', 'url' => ['controller' => 'AjaxVentes', 'action' => 'findTypeEquipementsAccessoires']]); ?>
                    <div class="row">

                        <div class="col-md-2">
                            <?= $this->Form->control('keyword', ['empty' => 'Gamme', 'label' => false, 'placeholder' => 'Rechercher par nom']); ?>
                        </div>

                        <div class="col-md-2">
                            <?= $this->Form->control('parc_id', ['label' => false, 'class' => 'selectpicker', 'empty' => 'Sélectionner type borne']); ?>
                        </div>

                        <div class="col-md-2 container-bornes d-none">
                            <?= $this->Form->control('borne_id', ['label' => false, 'class' => 'selectpicker','data-live-search' => true, 'empty' => 'Borne']); ?>
                        </div>

                        <div class="col-md-3 p-l-0">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark reset", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>

                <?= $this->Form->create(null, ['type' => 'get' ,'class'=> 'form-liste-equipements','role'=>'form']); ?>
                    <div class="clearfix container-type-equipements">
                        <!-- JS / AJAX -->
                        <?= $this->element('../AjaxVentes/find_type_equipements_accessoires') ?>
                        <p class="all-equips-selected d-none">Tous les types d'équipements ont été sélectionnés</p>
                    </div>

                    <!-- insérer notion de choix mulitples  -->
                    <div class="clearfix bloc-selected-products d-none w-100 mt-3">
                        <p class="m-0">Accessoire(s) sélectionné(s)</p>
                        <table class="table div_table_selected_produits">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</th>
                                    <th scope="col" class="d-none">Modèles</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody class="selected-produits">
                                <!-- JS -->
                            </tbody>

                            <tfoot class="d-none">
                                <tr>
                                    <td class="d-none selected-product">
                                        <!-- JS -->
                                    </td>
                                    <td class="nom"></td>
                                    <td class="select-equipm d-none"></td>
                                    <td class="qty-equipm d-none"></td>
                                    <td class="type-equipm-id d-none"></td>
                                    <td colspan="3"><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?= $this->Form->end(); ?>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary btn-rounded submit">Valider</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade modal-equipement-protection" id="modal-protection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ajout protection(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create(null, ['type' => 'get' ,'class'=> 'form-type-equipements form-filtre','role'=>'form', 'url' => ['controller' => 'AjaxVentes', 'action' => 'findTypeEquipementsProtections']]); ?>
                    <div class="row">

                        <div class="col-md-2">
                            <?= $this->Form->control('keyword', ['empty' => 'Gamme', 'label' => false, 'placeholder' => 'Rechercher par nom']); ?>
                        </div>

                        <div class="col-md-2">
                            <?= $this->Form->control('parc_id', ['label' => false, 'class' => 'selectpicker', 'empty' => 'Sélectionner type borne']); ?>
                        </div>

                        <div class="col-md-2 container-bornes d-none">
                            <?= $this->Form->control('borne_id', ['label' => false, 'class' => 'selectpicker','data-live-search' => true, 'empty' => 'Borne']); ?>
                        </div>

                        <div class="col-md-3 p-l-0">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark reset", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>

                <?= $this->Form->create(null, ['type' => 'get' ,'class'=> 'form-liste-equipements','role'=>'form']); ?>
                    <div class="clearfix container-type-equipements">
                        <!-- JS / AJAX -->
                        <?= $this->element('../AjaxVentes/find_type_equipements_protections') ?>
                        <p class="all-equips-selected d-none">Tous les types d'équipements ont été sélectionnés</p>
                    </div>

                    <!-- insérer notion de choix mulitples  -->
                    <div class="clearfix bloc-selected-products d-none w-100 mt-3">
                        <p class="m-0">Protections(s) sélectionné(s)</p>
                        <table class="table div_table_selected_produits">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nom</th>
                                    <th scope="col" class="d-none">Modèles</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody class="selected-produits">
                                <!-- JS -->
                            </tbody>

                            <tfoot class="d-none">
                                <tr>
                                    <td class="d-none selected-product">
                                        <!-- JS -->
                                    </td>
                                    <td class="nom"></td>
                                    <td class="select-equipm d-none"></td>
                                    <td class="qty-equipm d-none"></td>
                                    <td class="type-equipm-id d-none"></td>
                                    <td colspan="3"><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?= $this->Form->end(); ?>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-rounded" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary btn-rounded submit">Valider</button>
            </div>
        </div>
    </div>
</div>


<?= $this->Form->create($venteEntity, ['class' => 'step-vente']); ?>
    <div class="card">
        <div class="card-body">

            <input type="hidden" value="<?= $vente_id ?>" id="vente_id">
            <div class="clearfix">
                <h2 class="">Descriptif borne</h2>
                
                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('gamme_borne_id', ['options' => $gammesBornes, 'id' => 'gamme_borne_id', 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'label' => 'Gamme', 'data-live-search' => true]); ?>
                    </div>
                    <div id="id_loader" class="loader-vente"></div>
                    <div class="col-md-4">
                        <?= $this->Form->control('model_borne_id', ['options' => @$modelBornes, 'id' => 'model_borne_id', 'empty' => 'Sélectionner en fonction de la gamme', 'class' => 'selectpicker', 'label' => 'Type', 'data-live-search' => true]); ?>
                    </div>

                    <div class="col-md-4">
                        <?= $this->Form->control('couleur_borne_id', ['id' => 'couleur_borne_id', 'options' => $couleurBornes, 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'label' => 'Couleur', 'data-live-search' => true]); ?>
                    </div>
                </div>


                <div id="dev-equipement">
                    
                    <?php if ($gamme && $gamme->type_equipements) : ?>

                        <input type="hidden" id="nombre" value="<?= count($gamme->type_equipements) ?>" >

                        <?php foreach ($gamme->type_equipements as $key => $type_equipements) : $old_equipement = null ?>
                        
                        <?php foreach ($equipement_ventes as $equipement_vente) { 
                            if ($type_equipements->id == $equipement_vente['type_equipement_id']) {
                                $old_equipement = $equipement_vente;
                                break;
                            }
                        } ?>
                        <div class="equipement">

                            <h4><?= $type_equipements->nom ?>:</h4>
                            <hr>
                            <input type="hidden" name='<?= "equipement_ventes[$key][id]" ?>' value="<?= @$old_equipement['id'] ?>">
                            <input type="hidden" name='<?= "equipement_ventes[$key][type_equipement_id]" ?>' id='<?= "equipement-bornes-$key-type-equipement-id" ?>' value="<?= $type_equipements->id ?>">

                            <div class="row p-t-20">
                                <i class="col-md-12"></i>
                                <div class="col-md-3">
                                   <?php 
                                    echo $this->Form->control("equipement_ventes.$key.equipement_id", [
                                        'label' => 'Type ',
                                        'options' => $equipements ? $equipements[$type_equipements->id] : [],
                                        "class"=>"form-control selectpicker",
                                        "data-placeholder"=>"Choisir",
                                        'empty'=>'Séléctionner',
                                        'style' => 'width:100%',
                                        'value' => @$old_equipement['equipement_id']
                                    ]);
                                    ?>
                                </div>
                                <div class="col-md-3 m-t-40">
                                    <?php echo $this->Form->control("equipement_ventes.$key.valeur_definir", ['label' => 'Oui (valeur à définir)', 'type' => 'checkbox', 'checked' => @$old_equipement['valeur_definir'] ]); ?>
                                </div>
                                <div class="col-md-3 m-t-40">
                                    <?php echo $this->Form->control("equipement_ventes.$key.aucun", ['label' => 'Aucun(e)', 'type' => 'checkbox', 'checked' => @$old_equipement['aucun'] ]); ?>
                                </div>
                                <div class="col-md-3 m-t-40">
                                    <?php echo $this->Form->control("equipement_ventes.$key.materiel_occasion", ['label' => 'Matériel occasion', 'type' => 'checkbox', 'checked' => @$old_equipement['materiel_occasion'] ]); ?>
                                </div>

                            </div>
                        </div>

                        <?php endforeach ?>
                        <hr>
                    <?php else : ?>

                        <div class="equipement">
                            Aucun équipement pour ce gamme  <br><br>
                        </div>

                    <?php endif; ?>

                </div>
                <br>

                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('is_valise_transport', ['options' => $yes_or_no, 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'id' => 'valiseprecision', 'label' => 'Valise transport']); ?>
                    </div>
                </div>

                <div class="row clearfix <?= $venteEntity->is_valise_transport == 1 ? '' : 'd-none' ?>" id="row-valiseprecision">
                    <div class="col-md-12 mb-4"><b>Détail valise de transport</b></div> 
                    <div class="col-md-4"><?= $this->Form->control('is_valise_with_tete', ['label' => 'Tête']); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('is_valise_with_pied', ['label' => 'Pied']); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('is_valise_with_socle', ['label' => 'Socle']); ?></div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <?= $this->Form->control('is_housse_protection', ['options' => $yes_or_no, 'empty' => 'Sélectionner', 'class' => 'selectpicker', 'id' => 'housepreicsion', 'label' => 'Housse protection']); ?>
                    </div>
                </div>
                
                <div class="row clearfix <?= $venteEntity->is_housse_protection == 1 ? '' : 'd-none' ?>" id="row-housepreicsion">
                    <div class="col-md-12 mb-4"><b>Détail housse protection</b></div>
                    <div class="col-md-4"><?= $this->Form->control('is_house_with_tete', ['label' => 'Tête']); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('is_house_with_pied', ['label' => 'Pied']); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('is_house_with_socle', ['label' => 'Socle']); ?></div>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="clearfix">
                <h2 class="">Protection(s)</h2>
                
                <div class="block-protections">
                    <div class="row">
                        <div class="col-md-6 my-auto"><p class="aucun_equip_sup <?= !empty($venteEntity->equipements_protections_ventes) ? 'd-none' : '' ?>">Aucune protection supplémentaire</p></div>
                        <div class="col-md-6 my-auto"><button type="button" class="btn btn-success float-right btn-rounded" data-toggle="modal" data-target="#modal-protection"> Ajouter </button></div>
                    </div>

                    <div class="container-protections-sup container-equips <?= !empty($venteEntity->equipements_protections_ventes) ? '' : 'd-none' ?> mt-4">

                        <table class="table table-bordered table-uniforme">
                            <thead>
                                <tr>
                                    <th width="15%">Type équipement</th>
                                    <th width="25%">Modèle</th>
                                    <th width="25%">Qté</th>
                                    <th width="35%"></th>
                                </tr>
                            </thead>
                            <tbody class="default-data">
                                <!-- JS -->
                                <?php if (!empty($venteEntity->equipements_protections_ventes)): ?>
                                    <?php foreach ($venteEntity->equipements_protections_ventes as $key => $equipementsAccessoiresVente): ?>
                                        <?php $type_equipement_id = $equipementsAccessoiresVente->type_equipement_id ?>
                                        <tr>
                                            <td class="nom-equip-accessoire"><?= $equipementsAccessoiresVente->type_equipement['nom'] ?></td>
                                            <td class="select-equip-accessoire">
                                                <?= $this->Form->control('equipements_protections_ventes.'.$key.'.equipement_id', ['label' => false, 'options' => collection($equipementsAccessoiresVente->type_equipement['equipements'])->combine('id', 'valeur'), 'empty' => 'Sélectionner']); ?>
                                            </td>
                                            <td class="qty-equip-accessoire">
                                                <?= $this->Form->control('equipements_protections_ventes.'.$key.'.qty', ['label' => false, 'placeholder' => 'quantité', 'type' => 'number']); ?>
                                            </td>
                                            <td class="type-equip-accessoire-id d-none">
                                                <?= $this->Form->control('equipements_protections_ventes.'.$key.'.type_equipement_id', ['label' => false, 'type' => 'number', 'default' => $type_equipement_id]); ?>
                                                <?php if ($equipements_protections_vente_id = $equipementsAccessoiresVente->id): ?>
                                                    <?php echo $this->Form->control('equipements_protections_ventes.'.$key.'.id', ['value' => $equipements_protections_vente_id]); ?>
                                                <?php endif ?>
                                            </td>
                                            <td ><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                            <tfoot>
                                <tr class="clone d-none added-tr">
                                    <td class="nom-equip-accessoire"></td>
                                    <td class="select-equip-accessoire"></td>
                                    <td class="qty-equip-accessoire"></td>
                                    <td class="type-equip-accessoire-id d-none"></td>
                                    <td ><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="clearfix">
                <h2 class="">Accessoire(s)</h2>
                
                <div class="block-accessoires">
                    <div class="row">
                        <div class="col-md-6 my-auto"><p class="aucun_equip_sup <?= !empty($venteEntity->equipements_accessoires_ventes) ? 'd-none' : '' ?>">Aucun accessoire supplémentaire</p> </div>
                        <div class="col-md-6 my-auto"><button type="button" class="btn btn-success float-right btn-rounded" data-toggle="modal" data-target="#exampleModalLong"> Ajouter </button></div>
                    </div>

                    <div class="container-accessoires-sup container-equips <?= !empty($venteEntity->equipements_accessoires_ventes) ? '' : 'd-none' ?> mt-4">

                        <table class="table table-bordered table-uniforme">
                            <thead>
                                <tr>
                                    <th width="15%">Type équipement</th>
                                    <th width="25%">Modèle</th>
                                    <th width="25%">Qté</th>
                                    <th width="35%"></th>
                                </tr>
                            </thead>
                            <tbody class="default-data">
                                <!-- JS -->
                                <?php if (!empty($venteEntity->equipements_accessoires_ventes)): ?>
                                    <?php foreach ($venteEntity->equipements_accessoires_ventes as $key => $equipementsAccessoiresVente): ?>
                                        <?php $type_equipement_id = $equipementsAccessoiresVente->type_equipement_id ?>
                                        <tr>
                                            <td class="nom-equip-accessoire"><?= $equipementsAccessoiresVente->type_equipement['nom'] ?></td>
                                            <td class="select-equip-accessoire">
                                                <?= $this->Form->control('equipements_accessoires_ventes.'.$key.'.equipement_id', ['label' => false, 'options' => collection($equipementsAccessoiresVente->type_equipement['equipements'])->combine('id', 'valeur'), 'empty' => 'Sélectionner']); ?>
                                            </td>
                                            <td class="qty-equip-accessoire">
                                                <?= $this->Form->control('equipements_accessoires_ventes.'.$key.'.qty', ['label' => false, 'placeholder' => 'quantité', 'type' => 'number']); ?>
                                            </td>
                                            <td class="type-equip-accessoire-id d-none">
                                                <?= $this->Form->control('equipements_accessoires_ventes.'.$key.'.type_equipement_id', ['label' => false, 'type' => 'number', 'default' => $type_equipement_id]); ?>
                                                <?php if ($equipements_accessoires_vente_id = $equipementsAccessoiresVente->id): ?>
                                                    <?php echo $this->Form->hidden('equipements_accessoires_ventes.'.$key.'.id', ['value' => $equipements_accessoires_vente_id]); ?>
                                                <?php endif ?>
                                            </td>
                                            <td ><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                            <tfoot>
                                <tr class="clone d-none added-tr">
                                    <td class="nom-equip-accessoire"></td>
                                    <td class="select-equip-accessoire"></td>
                                    <td class="qty-equip-accessoire"></td>
                                    <td class="type-equip-accessoire-id d-none"></td>
                                    <td ><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="clearfix">
               <h2 class="">Options bornes</h2>

               <div class="row">
                   <div class="col-md-4">
                       <?= $this->Form->control('is_marque_blanche', ['empty' => 'Sélectionner', 'label' => 'Marque blanche']); ?>
                   </div>
               </div>

               <div class="row">
                   <div class="col-md-4">
                       <?= $this->Form->control('is_custom_gravure', ['label' => 'Gravure personnalisée']); ?>
                   </div>
               </div>

               <div class="row container-gravure-note <?= $venteEntity->is_custom_gravure == 1 ? '' : 'd-none' ?>">
                   <div class="col-md-12">
                       <?= $this->Form->control('gravure_note', ['label' => 'Note sur la gravure', 'rows' => 3]); ?>
                   </div>
               </div>
                
                <!-- A supprimer ceci -->
                <div class="clearfix container-accessories d-none">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->control('is_accessoires', ['hiddenField' => false, 'id' => 'is_accessoires', 'type' => 'checkbox', 'label' => 'Accessoires']); ?>
                        </div>
                    </div>
                    <div class="container-form-accessories">
                        <?php if ($venteEntity->is_accessoires): ?>
                        <?= $this->element('../AjaxVentes/load_accessoires_by_gamme_borne_id') ?>
                        <?php endif ?>
                    </div>
                </div>
                <!-- END -->

                 <div class="row d-none">
                     <div class="col-md-4">
                         <?= $this->Form->control('logiciel', ['label' => 'Logiciel']); ?>
                     </div>
                 </div>

                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->control('materiel_note', ['label' => 'Infos supplémentaire ',]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix mb-4">
        <?= $this->Form->submit('Suivant', ['class' => 'btn btn-primary float-right next']) ?>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-secondary float-left next">Précédent</a>
    </div>

        
<?= $this->form->end() ?>