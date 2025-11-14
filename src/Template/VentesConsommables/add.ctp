<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('table-uniforme', ['block' => 'css']) ?>
<?= $this->Html->script('ventes_consommables/add.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('devis/view.js?time='.time(), ['block' => true]); ?>


<?php
    $this->assign('title', 'Ventes consommables');
    $titrePage = "Créer vente option / consommable" ;
    if ($id) {
        $titrePage = "Edition vente consommable" ;
    }
    $this->start('breadcumb');
        $this->Breadcrumbs->add(
            'Tableau de bord',
            ['controller' => 'Dashboards', 'action' => 'index']
        );

        $this->Breadcrumbs->add($titrePage);

        echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();
?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Informations</h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($ventesConsommable) ?>
                    <?php /*debug($ventesConsommable);*/ ?>
                    <div class="form-body ">
                        <div class="row">

                            <div class="col-md-6">
                                <?= $this->Form->control('user_id', ['default' => $currentUser['id'], 'empty' => 'Sélectionner', 'label' => 'Commercial *', 'required', 'class' => 'selectpicker']) ?>
                            </div>

                            <div class="col-md-6 bloc-client">
                                <?= $this->Form->control('client_id', ['empty' => 'Rechercher', 'label' => 'Client *', 'required', 'class' => 'load-ajax-client form-control']) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('parc_id', ['empty' => 'Sélectionner', 'class' => 'selectpicker', 'label' => 'Parc de destination *', 'required']); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label" for="livraison-date">Date de livraison souhaitée *</label> 
                                <?= $this->Form->text('livraison_date', ['type' => 'date', 'required', 'value' => $ventesConsommable->livraison_date == null ?: $ventesConsommable->livraison_date->format('Y-m-d')]); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->Form->control('commentaire') ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->Form->control('lieu_livraison', ['label' => 'Lieu de livraison']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $this->Form->control('devis_id', ['label' => 'Devis du client', 'class' => 'form-control selectpicker', 'empty' => 'Sélectionner par rapport au client']) ?>
                            </div>
                        </div>

                        <div class="row-fluid clearfix mb-4">
                            <h3 class="mb-4 border-bottom border-secondary">Accessoires</h3>
                        </div>
                        

                        <div class="row-fluid container-accessoires">
                            <?php if ($id): ?>
                                <?= $this->element('/../AjaxVentesConsommables/get_devis_and_produits', ['devisEntity' => $devisEntityWithAccessoires]) ?>
                            <?php endif ?>
                        </div>

                        <div class="row-fluid clearfix mb-4">
                            <h3 class="mb-4 border-bottom border-secondary">Consommables</h3>
                        </div>

                        <div class="row-fluid container-consommables">
                            <?php if ($id): ?>
                                <?= $this->element('/../AjaxVentesConsommables/get_devis_and_produits', ['devisEntity' => $devisEntityWithConsommables]) ?>
                            <?php endif ?>
                        </div>

                        <div class="form-actions">
                            <?= $this->Form->button(__('Save'), ["class" => "btn btn-rounded btn-success", 'escape' => false]) ?>
                            <?= $this->Form->button(__('Cancel'), ["type" => "reset", "class" => "btn btn-rounded btn-inverse", 'escape' => false]) ?>
                        </div>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>