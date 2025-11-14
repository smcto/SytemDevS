<?php $this->extend('vente_layout') ?>
<?php $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>

<?php $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?php $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?php $this->Html->script('html5-editor/bootstrap-wysihtml5.fr-FR.js', ['block' => true]); ?>
<?php $this->Html->script('ventes/consommables.js?time='.time(), ['block' => 'script']); ?>

<?= $this->Form->create($venteEntity, ['class' => 'step-vente']); ?>
    <div class="card">
        <div class="card-body">
    
            <div class="row-fluid">
                <h2 class="">Options achat à la livraison</h2>
                
                <div class="row-fluid">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <?= $this->Form->control('is_carton_bobine', ['hiddenField' => false, 'neednote', 'type' => 'checkbox', 'label' => 'Inclure des consommables à la commande']); ?>
                        </div>
                    </div>
                    
                    <div class="row hidden-precision <?= $venteEntity->is_carton_bobine == 1 ? '' : 'd-none' ?>">

                        <div class="col-md-12">
                            <div class="">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30%">Nom</th>
                                            <th width="30%">Déclinaison</th>
                                            <th width="30%">Quantité</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $k = 0 ?>
                                        <?php foreach ($typeConsommables as $kConsommable =>  $typeConsommable): ?>
                                            <tr class="bg-light tr-container-checkbox">
                                                <td>
                                                    <?= $this->Form->control('checked_consommables.'.$typeConsommable->id, ['type' => 'checkbox' ,'label' => $typeConsommable->name, 'data-target' => 'type-consommable-'.$kConsommable]); ?>
                                                </td>
                                                <td colspan="2"></td>
                                            </tr>
                                                <?php foreach ($typeConsommable->sous_types_consommables as $key => $sous_types_consommable): ?>
                                                    <tr class="bg-white d-none" id="<?= 'type-consommable-'.$kConsommable ?>">
                                                        <td></td>
                                                        <td><?= $sous_types_consommable->name ?></td>
                                                        <td>
                                                            <?php if (@$vente_mode == 'edition'): ?>
                                                                <?php $sousTypesConsommable = $ventesSousConsommables->firstMatch(['sous_types_consommable_id' => $sous_types_consommable->id, 'type_consommable_id' => $sous_types_consommable->type_consommable_id]); ?>
                                                                <?= $this->Form->control('ventes_sous_consommables.'.$k.'.id', ['type' => 'hidden', 'value' => $sousTypesConsommable->id, 'label' => false]); ?>
                                                            <?php endif ?>
                                                            <?= $this->Form->control('ventes_sous_consommables.'.$k.'.sous_types_consommable_id', ['type' => 'hidden', 'value' => $sous_types_consommable->id, 'label' => false]); ?>
                                                            <?= $this->Form->control('ventes_sous_consommables.'.$k.'.type_consommable_id', ['type' => 'hidden', 'value' => $sous_types_consommable->type_consommable_id, 'label' => false]); ?>
                                                            <?= $this->Form->control('ventes_sous_consommables.'.$k.'.qty', ['label' => false]); ?>
                                                        </td>
                                                    </tr>
                                                    <?php $k++ ?>
                                                <?php endforeach ?>
                                                
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <h4 class="mt-4">Autre</h4>
                <div class="row-fluid">
                    <?= $this->Form->control('materiel_other_note',['label' => false, "class" => "textarea_editor form-control", "rows" => 7]); ?>
                </div>


            </div>
        </div>
    </div>
    <div class="clearfix mb-4">
        <?= $this->Form->submit('Suivant', ['class' => 'btn btn-primary float-right next']) ?>
        <a href="<?= $this->Url->build(['action' => 'materiel']) ?>" class="btn btn-secondary float-left next">Précédent</a>
    </div>
<?= $this->form->end() ?>

