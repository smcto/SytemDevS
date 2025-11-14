<div class="modal fade" id="affectation-borne" role="dialog">
    <div class="modal-dialog">
        <form name="form_edit" id="form-edit" method="post" accept-charset="utf-8">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une borne dans cette vente.</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label id="label-parc"></label>
                    <div class="row p-t-20">
                        <div class="col-md-12">
                            <?= $this->Form->control('borne_id', ['label' => false, 'empty' => 'Sélectionner', 'options' => [], "class" => "form-control select2", "data-placeholder" => "Choisir le numero de borne", 'style' => 'width:100%']); ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php echo $this->Form->button(__('Save'), ['label' => false ,'class' => 'btn btn-primary'] );?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>