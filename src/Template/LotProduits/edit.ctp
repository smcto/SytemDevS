<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LotProduit $lotProduit
 */
?>

<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>

<?= $this->Html->script('LotProduits/add.js?'.time(), ['block' => true]); ?>

<?php
$titrePage = "Modification d'un produit" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Stock : Vue détail',
    ['controller' => 'LotProduits', 'action' => 'detail']
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
                        
                        <div class="col-md-3 for-event <?= $lotProduit->is_event? '' : 'hide' ?>">
                            <?php echo $this->Form->control('type_docs._ids', [
                                'label' => 'Univers ', 
                                'options' => $univers, 
                                'class'=>'form-control select2', 
                                'empty' => 'Choisir', 
                                'data-placeholder' => 'Choisir',
                                'style' => 'width:100%',
                            ]); 
                            ?>
                        </div>

                        <div class="col-md-3 for-event <?= $lotProduit->is_event? '' : 'hide' ?>">
                            <?php echo $this->Form->control('antenne_id', [
                                'label' => 'Emplacement ', 
                                'options' => $antennes, 
                                'class'=>'form-control select2', 
                                'empty' => 'Choisir', 
                                'data-placeholder' => 'Choisir',
                                'style' => 'width:100%',
                            ]); ?>
                        </div>   
                    </div>
                        
                    <div class="row">
                        
                        <div class="col-md-6">
                            <?= $this->Form->control('type_equipement_id', [
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
                            <?= $this->Form->control('fournisseur_id', [
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
                            <?php 
                                echo $this->Form->control('equipement_id', 
                                        ['label' => 'Equipement *', 
                                        'options' => [],
                                        'empty'=>'Séléctionner',
                                        'required' => true,
                                        'data-placeholder'=>'Equipement', 
                                        'class'=>'form-control select2', 
                                        'style' => 'width:100%'
                                ]); 
                            ?>
                            
                        <input type="hidden" value=<?= $lotProduit->equipement_id ?> id="value_equipement_id">
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('etat', ['options' => $etat_stocks,'empty' => 'Séléctionner', 'class' => 'selectpicker']); ?>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->control('numero_facture'); ?>
                        </div>
                        <input type="hidden" value="<?= $lotProduit->numero_facture ?>" name="old_numero_facture">
                        <!--div class="col-md-3">
                            <?= $this->Form->input('date_facture', ['class'=>'form-control']); ?>
                        </div-->
                        <div class="col-md-6">
                            <label for="date_facture">Date de facture</label>
                            <input type="date" id="date_facture" name="date_facture" class="form-control" placeholder="dd/mm/yyyy" id="date_facture"
                                   value="<?php if(!empty($date_facture)) echo $lotProduit->date_facture->format("Y-m-d") ?>" style="width: 100%">
                        </div>

                        <div class="col-md-3 hide">
                            <?= $this->Form->input('date_stock', ['class'=>'form-control']); ?>
                        </div>

                        <div class="col-md-6 hide">
                            <?= $this->Form->control('facture_file_name', ['label' => 'Facture(s) liée(s)', 'class' => 'vertical-spin form-control']); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('serial_nb', ['label' => 'Numéro de série *', 'class' => 'vertical-spin form-control']); ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('facture_file[]',["id"=>"photo_id","label"=>"Facture fichier ","class"=>"form-control", "type"=>"file", "accept"=>".pdf", "multiple" =>true]) ?>
                        </div>
                        
                        <div class="col-md-4">
                            <?= $this->Form->control('tarif_achat_ht', ['label' => 'Achat HT', 'class' => 'vertical-spin form-control', 'required']); ?>
                        </div>
                        
                        <div class="col-md-2 bootstrap-tagsinput m-t-40">
                            <?php echo $this->Form->control('tarif_approximatif',["label"=>"Tarif approximatif ","id"=>"tarif_approximatif", 'type' => 'checkbox']) ?>
                        </div>
                        
                        <div class="col-md-3">
                            <?= $this->Form->control('user_id', ['label' => 'Ajouté par', 'class' => 'selectpicker', 'options' => $users, 'empty' => 'Séléctionner']); ?>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="date_stock">Date entrée en stock</label>
                            <input type="date" name="date_stock" class="form-control" placeholder="dd/mm/yyyy" id="date_stock"
                               value="<?php if(!empty($date_stock)) echo $date_stock ?>" >
                        </div>
                        
                    </div>
                </div>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Html->link('Annuler',['controller' => 'LotProduits', 'action' => 'view',$lotProduit->id],['escape'=>false,"class"=>"btn btn-rounded btn-secondary"]),' '; ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var equipements = <?= json_encode($equipements); ?>;
</script>