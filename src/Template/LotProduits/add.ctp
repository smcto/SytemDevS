<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LotProduit $lotProduit
 */
?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?php echo $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>

<?= $this->Html->script('LotProduits/add.js?'.time(), ['block' => true]); ?>

<?php
$titrePage = "Ajout d'un lot de produits" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Lot de produits',
    ['controller' => 'LotProduits', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();


?>


<div class="row">
<div class="col-lg-12">
    <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Ajout</h4>
        </div>
        <div class="card-body">
            <?= $this->Form->create($lotProduit,['type' => 'file']) ?>
                <div class="form-body">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('is_event', [
                                'label' => 'Destination  *', 
                                'class'=>'form-control selectpicker', 
                                'options' => ['Composants', 'Event'], 
                                'required' => true
                            ]); 
                            ?>
                        </div>
                        
                        <div class="for-event hide row col-md-6">
                            <div class="col-md-6">
                                <?php echo $this->Form->control('type_docs._ids', [
                                    'label' => 'Univers ', 
                                    'options' => $univers, 
                                    'class'=>'form-control select2', 
                                    'empty' => 'Choisir', 
                                    'data-placeholder' => 'Choisir',
                                    'style' => 'width:100%',
                                    'disabled' => true
                                ]); 
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?php echo $this->Form->control('antenne_id', [
                                    'label' => 'Emplacement ', 
                                    'options' => $antennes, 
                                    'class'=>'form-control select2', 
                                    'empty' => 'Choisir', 
                                    'data-placeholder' => 'Choisir',
                                    'style' => 'width:100%',
                                    'disabled' => true
                                ]); ?>
                            </div>                   
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('type_equipement_id', [
                                'label' => 'Type Equipement *', 
                                'class'=>'form-control select2', 
                                'options' => $typeEquipements, 
                                'required' => true,
                                "empty"=>"Choisir",
                                'style' => 'width:100%'
                            ]); 
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('fournisseur_id', [
                                'label' => 'Fournisseur *', 
                                'options' => $fournisseurs, 
                                'class'=>'form-control select2', 
                                'empty' => 'Choisir', 
                                'required' => true,
                                'style' => 'width:100%'
                            ]); 
                            ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?php echo $this->Form->control('equipement_id', [
                                'label' => 'Equipement *', 
                                'options' => [], 
                                'required' => true, 
                                'class'=>'form-control select2', 
                                'style' => 'width:100%'
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('etat', ['options' => $etat_stocks,'empty' => 'Séléctionner', 'class' => 'selectpicker']); ?>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('numero_facture'); ?>
                        </div>
                        <div class="col-md-3">
                            <label for="date_facture">Date de facture</label>
                            <input type="date" name="date_facture" class="form-control" placeholder="dd/mm/yyyy" id="date_debut"
                               value="<?php if(!empty($date_facture)) echo $date_facture ?>" >
                        </div>
                        
                        <div class="col-md-3">
                            <label for="date_stock">Date entrée en stock</label>
                            <input type="date" name="date_stock" class="form-control" placeholder="dd/mm/yyyy" id="date_stock"
                               value="<?php if(!empty($date_stock)) echo $date_stock ?>" >
                        </div>

                        <div class="col-md-6">
                            <?php echo $this->Form->control('quantite', ['label' => 'Quantité *', 'class' => 'vertical-spin form-control', 'required' => true, 'value' => 1]); ?>
                        </div>

                        <div class="col-md-3">
                            <?php echo $this->Form->control('facture_file[]',["id"=>"photo_id","label"=>"Facture fichier ","class"=>"form-control", "type"=>"file", "accept"=>".pdf", "multiple" =>true]) ?>
                        </div>
                        
                        <div class="col-md-3">
                            <?= $this->Form->control('user_id', ['label' => 'Ajouté par', 'class' => 'selectpicker', 'options' => $users, 'empty' => 'Séléctionner', 'default' => $user_id]); ?>
                        </div>
                        
                        <div class="col-md-6 bootstrap-tagsinput" id="bloc_serial">
                            <label for="serial_nb">Numéro de série</label>
                            <input type="text" placeholder="Serial 1" id="serial_nb_0" name="serial_nb[0]" class="form-control" style="margin-bottom: 10px;">
                        </div>
                        <div class="col-md-6 bootstrap-tagsinput tarif_ht">
                            <label for="serial_nb">Tarif achat HT</label>
                            <input type="number" placeholder="Tarif achat HT" id="tarif_ht" name="tarif_ht" class="form-control" style="margin-bottom: 10px;" required>
                        </div>
                        <div class="col-md-6 bootstrap-tagsinput hide tarif-nb-label" id="bloc_tarif">
                            <label for="serial_nb">Tarif achat HT</label>
                            <input type="number" placeholder="Tarif achat HT pour le numero de serie 1" id="tarif_nb_0" name="tarif_nb[0]" class="form-control tarif_nb  inp-tarif" style="margin-bottom: 10px;">
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3 bootstrap-tagsinput m-t-40">
                            <?php echo $this->Form->control('tarif_identique',["label"=>"Tarif identique ","id"=>"tarif_identique", 'type' => 'checkbox', 'checked' => true]) ?>
                        </div>
                        <div class="col-md-3 bootstrap-tagsinput m-t-40">
                            <?php echo $this->Form->control('tarif_approximatif',["label"=>"Tarif approximatif ","id"=>"tarif_approximatif", 'type' => 'checkbox', 'checked' => false]) ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
            <div class="hide">
                <input type="text" id="inp-reference" name="" class="form-control inp-reference" style="margin-bottom: 10px;">
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var equipements = <?php echo json_encode($equipements); ?>;
</script>