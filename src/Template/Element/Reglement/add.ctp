<!-- Modal add -->
<div class="modal font-14" id="add_reglement" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($new_reglement); ?>
            <input type="hidden" id="position" value="bottom">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Ajouter un réglement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label class="control-label col-md-4 m-t-5">Type de réglement</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('type',[
                                'type'=>'radio',
                                'options'=>$type_reglement,
                                'label'=>false,
                                'required'=>true,
                                'hiddenField'=>false,
                                'legend'=>false,
                                'templates' => [
                                    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                                    'radioWrapper' => '<div class="radio radio-success radio-inline">{{label}}</div>'
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <div class="row hide">
                        <label class="control-label col-md-4">Etat</label>
                        <div class="col-md-8">
                            <?php
                            $etatReglement = ['draft'=>'Brouillon','validate' => 'Validé','confirmed' => 'Confirmé'];
                            echo  $this->Form->control('etat',['options' => $etatReglement, 'default' => 'validate', 'class' => 'form-control', 'label' => false,'style' => 'width:100%', 'id'=> 'etat_reglement']);
                            ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Client</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('client_id',['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control test', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher", 'required' => 'required','id'=> 'client_liste']) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Date de réglement</label>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="date" name="date" id="date" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Nom de la banque</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('info_bancaire_id', ['empty' => 'Sélectionner', 'options' => $infosBancaires, 'label' => false, 'class' => 'selectpicker coord_bq']); ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Moyen de paiement</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('moyen_reglement_id',['label' => false, 'options' => $moyen_reglements]) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Montant de réglement</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('montant',['label' => false]) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Référence</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('reference',['label' => false]) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Note</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('note',['label' => false,'type' => 'textarea', 'class' => 'summernote form-control']) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <?= $this->Form->control('lie_reglment',['type' => 'checkbox','label'=>'Lier à une facture','id'=>'id_lie_regelement']) ?>
                        </div>
                    </div>
                    <div class="row custom-col-width hide" id="id_tolinkReglement">
                            <h3 class="col-md-12">Sélection de facture(s) </h3>
                            <hr>

                            <div class="col-md-3">
                                <?= $this->Form->control('indent', ['label' => false, 'placeholder' => 'Num facture','id'=>'id_indentValue']); ?>
                            </div>

                            <div class="col-md-4">
                                <input type="button" class="btn btn-primary" id="id_chercheFactByClientAnd" value="Rechercher">
                                <div id="id_loader"></div>
                            </div>
                            <div class="col-md-12" id="">
                                <table class="table table-striped" id="id_listeAddClientRegelement">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Etat</th>
                                            <th>Client</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Contact</th>
                                            <th class="text-right">HT</th>
                                            <th class="text-right">TTC</th>
                                            <th width="1%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="9" class="text-center">Rechercher pour afficher la liste</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
            </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>
