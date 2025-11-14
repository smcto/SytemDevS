<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Facture $facture
 */
?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('factures/factures.css', ['block' => true]) ?>

<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>
<?= $this->Html->script('factures/factures.js',['block'=>true]) ?>
<?= $this->Html->script('factures/produits.js',['block'=>true]) ?>
<?php
$titrePage = "Modifier un facture" ;
$this->start('breadcumb');
if(in_array("admin", $user_connected["typeprofils"])) {
$this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'index']);
} else
if(in_array("antenne", $user_connected["typeprofils"])) {
$this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'antennes']);
} else
if(in_array("installateur", $user_connected["typeprofils"])) {
$this->Breadcrumbs->add('Tableau de bord', ['controller' => 'Dashboards', 'action' => 'installateurs']);
}

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
                <?= $this->Form->create($facture, ['type' => 'file']) ?>
                <div class="form-body">
                    <?php if(in_array("admin", $user_connected["typeprofils"])) { ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php //echo $this->Form->control('antenne_id',['label' => 'Antenne *','type'=>'select', 'options'=>$antennes, 'empty'=>'Sélectionner']); ?>
                        </div>
                    </div>
                    <?php } else {?>
                    <?php echo $this->Form->control('user_id',['type'=>'hidden', 'value'=>$user_connected["id"]]); ?>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('titre',['label' => 'Titre *','type'=>'text']); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('evenement_id',['label' => 'Projet *','type'=>'select', 'options'=>$evenements, 'empty'=>'Sélectionner']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('montant',['label'=>'Montant ', 'type'=>'number']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('facture_file',["id"=>"facture_id","label"=>"Facture ","class"=>"dropify", "type"=>"file", 'data-default-file'=>$facture->url]) ?>
                            <?php  if(!empty($facture->url)) {
                            echo $this->Html->link('Visualiser', $facture->url,['escape' => false,"class"=>"", 'target'=>'_blank']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('commentaire',['label'=>'Commentaire :', 'type'=>'textarea']); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('fournisseur_id', ['empty' => 'Sélectionner', 'required', 'label'=> 'Fournisseurs * :']); ?>
                        </div>
                    </div>

                    <div class="row-fluid">
                        <button type="button" class="btn btn-primary add-products float-right mt-2 mb-4">Ajouter un produit</button>

                        <table class="table mt-2">
                            <thead>
                                <tr>
                                    <th width="20%">Type equipement *</th>
                                    <th width="20%">Equipement *</th>
                                    <th width="20%">Quantité</th>
                                    <th width="20%">Type de contrat *</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="products-table">
                                <?php foreach ($facture->factures_produits as $key => $facture_produit): ?>
                                    <tr>
                                        <td class="d-none"><?= $this->Form->hidden("factures_produits.$key.id", ['input-name' => 'id', 'value' => $facture_produit->id]); ?></td>
                                        <td><?= $this->Form->select("factures_produits.$key.type_equipement_id", $typeEquipements, ['empty' => 'Sélectionner', 'input-name' => 'type_equipement_id', 'required', 'class' => 'form-control', 'id' => 'type_equipement_id']); ?></td>
                                        <td><?= $this->Form->select("factures_produits.$key.equipement_id", $equipements, ['input-name' => 'equipement_id', 'required', 'class' => 'form-control', 'id' => 'equipement_id']); ?></td>
                                        <td><?= $this->Form->control("factures_produits.$key.qty", ['input-name' => 'qty', 'type' => 'number', 'label' => false, 'class' => 'form-control', 'id' => 'qty']); ?></td>
                                        <td><?= $this->Form->select("factures_produits.$key.parc_id", $parcs, ['input-name' => 'parc_id', 'type' => 'number', 'label' => false, 'required', 'class' => 'form-control', 'id' => 'qty']); ?></td>
                                        <td><a href="javascript:void(0);" class="mt-2 d-block" id="remove-prod" data-id="<?= $facture_produit->id ?>"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr class="d-none clone added-tr">
                                    <td><?= $this->Form->select('type_equipement_id', $typeEquipements, ['empty' => 'Sélectionner', 'input-name' => 'type_equipement_id', 'class' => 'form-control', 'id' => 'type_equipement_id']); ?></td>
                                    <td><?= $this->Form->select('equipement_id', [], ['input-name' => 'equipement_id', 'class' => 'form-control', 'id' => 'equipement_id']); ?></td>
                                    <td><?= $this->Form->control('qty', ['input-name' => 'qty', 'type' => 'number', 'label' => false, 'class' => 'form-control', 'id' => 'qty']); ?></td>
                                    <td><?= $this->Form->select('parc_id', $parcs,['input-name' => 'parc_id', 'type' => 'number', 'label' => false, 'class' => 'form-control', 'id' => 'qty']); ?></td>
                                    <td><a href="javascript:void(0);" class="mt-2 d-block" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>


