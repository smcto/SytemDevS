<?php if ($gamme && $gamme->type_equipements) : ?>

    <input type="hidden" id="nombre" value="<?= count($gamme->type_equipements) ?>" >

    <?php foreach ($gamme->type_equipements as $key => $type_equipements) : ?>
        <?php $old_equipement = isset($old_equipements[$type_equipements->id])?$old_equipements[$type_equipements->id]:null;?>
        <div class="equipement">

            <h4><?= $type_equipements->nom ?>:</h4>
            <hr>
            <input type="hidden" name='<?= "equipement_bornes[$key][id]" ?>'value="<?= $old_equipement?$old_equipement->id:'' ?>">
            <input type="hidden" name='<?= "equipement_bornes[$key][type_equipement_id]" ?>' id='<?= "equipement-bornes-$key-type-equipement-id" ?>' value="<?= $type_equipements->id ?>">

        <div class="row p-t-20">
            <i class="col-md-12"></i>
            <div class="col-md-6 <?= $key . '-exist' ?> <?= ($old_equipement && $old_equipement->aucun)?'hide':''?>">
               <?php 
                echo $this->Form->control("equipement_bornes.$key.equipement_id", [
                    'label' => 'Type ',
                    'options' => [],
                    "class"=>"form-control select2",
                    "data-placeholder"=>"Choisir",
                    'empty'=>'Séléctionner',
                    'style' => 'width:100%'
                ]);
                ?>
                <input type="hidden" name='<?= "equipement_bornes[$key][old_equipement_id]" ?>' id='<?= "equipement-bornes-$key-old-equipement-id" ?>' value="<?= $old_equipement?$old_equipement->equipement_id:'' ?>">
            </div>
            <div class="col-md-6 <?= $key . '-exist' ?> <?= $key . '-hide-stock' ?> <?= ($old_equipement && $old_equipement->aucun)?'hide':''?>">
               <?php 
                echo $this->Form->control("equipement_bornes.$key.numero_serie_id", [
                    'label' => 'Numéro de serie',
                    'options' => [],
                    "class"=>"form-control select2",
                    "data-placeholder"=>"Choisir",
                    'empty'=>'Séléctionner',
                    'style' => 'width:100%'
                ]);
                ?>
                <input type="hidden" name='<?= "equipement_bornes[$key][old_numero_serie_id]" ?>' id='<?= "equipement-bornes-$key-old-numero-serie-id" ?>' value="<?= $old_equipement?$old_equipement->numero_serie_id:'' ?>">
            </div>

            <div class="col-md-4 hide <?= $key . '-stock' ?>">
                <?php
                    echo $this->Form->control("equipement_bornes.$key.new_numero_series", [
                        'label' => 'Nouveau numéro série',
                        "placeholder" => "Numéro série",
                        'style' => 'width:100%'
                    ]);
                ?>
            </div>

            <div class="col-md-4 hide <?= $key . '-stock' ?>">
                <?php
                    echo $this->Form->control("equipement_bornes.$key.fournisseur", [
                        'label' => 'Fournisseur',
                        'empty' => 'Séléctionner',
                        'options' => $fournisseur,
                        "class" => "form-control select2",
                        "data-placeholder" => "Choisir",
                        'style' => 'width:100%'
                    ]);
                ?>
            </div>
            <div class="col-md-6 <?= $key . '-aucun' ?> <?= ($old_equipement && $old_equipement->aucun)?'':'hide'?>">
                <?php echo $this->Form->control("equipement_bornes.$key.precisions",['label' => 'Précision','type'=>'text', 'value' => $old_equipement?$old_equipement->precisions:'']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 <?= $key . '-hide-stock' ?>">
                <?php echo $this->Form->control("equipement_bornes.$key.aucun",['label' => 'Aucun(e)' ,'type'=>'checkbox', 'checked' => ($old_equipement && $old_equipement->aucun)?true:false]); ?>
            </div>
            <div class="col-md-6  <?= $key . '-exist' ?> <?= ($old_equipement && $old_equipement->aucun)?'hide':''?>">
                <?php echo $this->Form->control("equipement_bornes.$key.new_stock", ['label' => 'Ajouter nouveau stock', 'type' => 'checkbox']); ?>
            </div>
        </div>
    </div>
</div>

<?php endforeach ?>
<?php else : ?>

    <div class="equipement">
        Aucune gamme séléctionné <br><br>
    </div>

<?php endif; ?>
