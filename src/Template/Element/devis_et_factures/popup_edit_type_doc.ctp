<?= $this->Html->script('documents/edit_type_doc', ['block' => true]); ?>

<div class="modal fade" id="devis_type_doc" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modifier le type de document <span class="num_devis"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 mt-2 m-b-30">
                                <label>Document : </label>
                            </div>
                            <div class="col-md-8">
                                <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'label' => false, 'class' => 'form-control selectpicker', 'empty' => 'Type de document', 'id' => 'modif_type']); ?>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>