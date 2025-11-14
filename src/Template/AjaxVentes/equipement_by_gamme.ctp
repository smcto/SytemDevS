<?php if ($gamme && $gamme->type_equipements) : ?>
    
    <input type="hidden" id="nombre" value="<?= count($gamme->type_equipements) ?>" >

    <?php foreach ($gamme->type_equipements as $key => $type_equipements) : ?>
    <?php $old_equipement = isset($old_equipements[$type_equipements->id])?$old_equipements[$type_equipements->id]:null;?>
    <div class="equipement">

        <h4><?= $type_equipements->nom ?>:</h4>
        <hr>
        <input type="hidden" name='<?= "equipement_ventes[$key][id]" ?>' value="<?= $old_equipement?$old_equipement->id:'' ?>">
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
                    'value' => $old_equipement?$old_equipement->equipement_id:''
                ]);
                ?>
            </div>
            <div class="col-md-3 m-t-40">
                <?php echo $this->Form->control("equipement_ventes.$key.valeur_definir", ['label' => 'Demandé, mais valeur à définir', 'type' => 'checkbox', 'checked' => $old_equipement?$old_equipement->valeur_definir: false]); ?>
            </div>
            <div class="col-md-3 m-t-40">
                <?php echo $this->Form->control("equipement_ventes.$key.aucun", ['label' => 'Aucun(e)', 'type' => 'checkbox', 'checked' => $old_equipement?$old_equipement->aucun: false]); ?>
            </div>
            <div class="col-md-3 m-t-40">
                <?php echo $this->Form->control("equipement_ventes.$key.materiel_occasion", ['label' => 'Matériel occasion', 'type' => 'checkbox', 'checked' => $old_equipement?$old_equipement->materiel_occasion: false]); ?>
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
