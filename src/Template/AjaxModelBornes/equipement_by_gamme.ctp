<?php if ($gamme && $gamme->type_equipements) : ?>
    
    <?php foreach ($gamme->type_equipements as $key => $type_equipements) : ?>
    <?php $old_equipement = isset($old_equipements[$type_equipements->id])?$old_equipements[$type_equipements->id]:null;?>

        <input type="hidden" name='<?= "model_borne_has_equipements[$key][id]" ?>'value="<?= $old_equipement?$old_equipement->id:'' ?>">
        <input type="hidden" name='<?= "model_borne_has_equipements[$key][type_equipement_id]" ?>' id='<?= "equipement-bornes-$key-type-equipement-id" ?>' value="<?= $type_equipements->id ?>">

            <div class="col-md-6">
               <?php 
                echo $this->Form->control("model_borne_has_equipements.$key.equipement_id", [
                    'label' => $type_equipements->nom,
                    'options' => isset($equipements[$type_equipements->id]) ? $equipements[$type_equipements->id]:[],
                    "class"=>"form-control select2",
                    'value' => $old_equipement?$old_equipement->equipement_id : null,
                    "data-placeholder"=>"Choisir",
                    'empty'=>'Séléctionner',
                    'style' => 'width:100%'
                ]);
                ?>
            </div>

    <?php endforeach ?>
<?php else : ?>

    <div class="equipement">
        Aucune gamme séléctionné <br><br>
    </div>

<?php endif; ?>
