<div class="modal fade" id="addEvenement_<?= $etape->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Séléctionner un événement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <?php echo $this->Form->create($evenementPipeEtape, ['url' => ['controller'=>'EvenementPipeEtapes','action' => 'add', $etape->pipe_id]]); ?>
                <div class="modal-body">
                    
                        <div class="form-group">
                            <!--<input type="text" class="form-control" name="nom">-->
                            <?php 
                            echo $this->Form->control('pipe_etape_id', ['value'=>$etape->id,'type'=>'hidden']);
                            echo $this->Form->select(
                                'evenement_id',
                                $evenements,
                                ['empty' => 'Choisissez','required'=>true, "class" => 'select2 selectpicker']
                            );
                            ?>
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
             <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
