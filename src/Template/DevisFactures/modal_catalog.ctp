<?= $this->Html->script("devisFactures/modal_catalog.js?" . time(), ['block' => 'script'] ); ?>

<!-- BEGIN MODAL -->
<div class="modal fade font-14" id="devis_factures_catalog" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xxl" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['class' => '']); ?>
            <input type="hidden" id="position" value="bottom">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Catalogue produits et services</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-2 mt-1">
                            <?= $this->Form->control('key', ['id' => 'key', 'label' => false, 'class' => 'input-in-modal form-control', 'placeholder' => 'Rechercher']) ?>
                        </div>
                        <div class="col-md-2 mt-1">
                            <?= $this->Form->control('categorie', ['id' => 'categorie', 'label' => false, 'options' => $categorie, 'empty' => 'Toutes les catégories', 'class' => 'input-in-modal form-control']) ?>
                        </div>
                        <div class="col-md-2 mt-1">
                            <?= $this->Form->control('sous_categorie', ['id' => 'sous-categorie', 'label' => false, 'options' => [], 'empty' => 'Toutes les sous catégories', 'class' => 'input-in-modal form-control']) ?>
                        </div>
                        <div class="col-md-2 mt-1">
                            <?= $this->Form->control('sous_sous_category_id', ['id' => 'sous-sous-categorie', 'label' => false, 'options' => [], 'empty' => 'Toutes les sous sous catégories', 'class' => 'input-in-modal form-control']) ?>
                        </div>
                        <div class="col-md-4">
                            <input type="button" class="btn btn-primary" id="search-catalog" value="Rechecher">
                            <input type="reset" class="btn btn-dark" id="cancel-search" value="Annuler ma recherche">
                        </div>
                    </div>
                    
                    <div id="div_table_catalog" class="clearfix w-100">
                        <div class="table-responsive mt-1">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col"> </th>
                                        <th scope="col">Nom interne</th>
                                        <th scope="col">PU HT </th>
                                        <th scope="col">PU TTC </th>
                                        <th scope="col">Code Comptable</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                        
                    <!-- insérer notion de choix mulitples autre version  -->
                    <div class="clearfix bloc-selected-products w-100 mt-3 d-none">
                        <p class="m-0"><b>Produit(s) sélectionné(s)</b></p>
                        <table class="table w-100 mt-3 div_table_selected_produits">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Nom interne</th>
                                    <th scope="col">PU HT </th>
                                    <th scope="col">PU TTC </th>
                                    <th scope="col">Code Comptable</th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody class="selected-produits">
                                
                            </tbody>

                            <tfoot class="d-none">
                                <tr>
                                    <td class="d-none selected-product"></td>
                                    <td class="nom_interne"></td>
                                    <td class="prix_reference_ht"></td>
                                    <td class="prix_reference_ttc"></td>
                                    <td class="code_comptable"></td>
                                    <td><a href="javascript:void(0);" class="delete-selected"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <button type="button" class="btn btn-rounded btn-success" id="submit-catalog"> <span aria-hidden="true"><?= __('Valider') ?></span> </button>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

