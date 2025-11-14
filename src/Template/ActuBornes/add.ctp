<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActuBorne $actuBorne
 */
  use Cake\Routing\Router;
?>
<!-- Color picker plugins css -->
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('multiselect/multi-select.css', ['block' => true]) ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>

<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('multiselect/jquery.multi-select.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('actubornes/actubornes.js?'.  time(), ['block' => true]); ?>

<?php
$categorietickets_options = array();
$categoriedescription = array();
if(count($categorietickets->toArray())){
    foreach($categorietickets as $categorie_item){
        $categorietickets_options[$categorie_item['id']] = $categorie_item['titre'];
        $categoriedescription[$categorie_item['id']] = [$categorie_item['description']];
    }
}


$titrePage = "Ajout ticket borne" ;
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
            <?= $this->Form->create($actuBorne, ['type'=>'file']) ?>
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <?php echo $this->Form->control('titre',['label' => 'Titre * ','type'=>'text', 'required'=>'true']); ?>
                        </div>
                        <div class="col-md-4">
                            <?php echo $this->Form->control('categorie_actus_id',['id'=>'categorie_actus_id','label' => 'Catégorie *', 'options'=>$categorietickets_options,'empty'=>'Séléctionner', 'required'=>'required']); ?>
                        </div>
                        <div class="col-md-4">
                             <?php echo $this->Form->control('borne_id',[
                                 'id'=>'borne_id',
                                 'label' => 'Borne *', 
                                 'options'=>$bornes,
                                 'empty'=>'Séléctionner',
                                 "class" => "form-control select2",
                                 "data-placeholder" => "Choisir",
                                 'required'=>'required']
                            ); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                           <?php echo $this->Form->control('contenu',['id' => 'contenu', 'label'=>'Contenu',"class"=>"textarea_editor form-control", "rows"=>"10",'type'=>'textarea']); ?>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                             <label>Photos</label>
                             <div class="dropzone" id="id_dropzone"> </div>
                         </div>
                    </div>

                </div></br>
                <div class="form-actions">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
                    <?= $this->Form->button('Cancel',["type"=>"reset", "class"=>"btn btn btn-rounded btn-inverse",'escape'=>false]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var categoriedescription = <?php echo json_encode($categoriedescription); ?>;
</script>