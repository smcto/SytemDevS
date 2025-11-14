<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
 use Cake\Routing\Router;
?>
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
<?= $this->Html->script('posts/posts.js', ['block' => true]); ?>
<?= $this->Html->script('factures/factures.js',['block'=>true]) ?>

<?php
$titrePage = "Ajout d'un document" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Documentation',
    ['controller' => 'Posts', 'action' => 'index']
);

$this->Breadcrumbs->add('Ajouter');

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<?= $this->Form->create($post, ['type' => 'file']) ?>
<div class="row">
<div class="col-lg-8">
    <div class="card card-outline-info">
        <div class="card-body">
                <div class="form-body">
                    <div class="row p-t-20">
                        <div class="col-md-12">
                            <?php echo $this->Form->control('titre',['label' => 'Titre *','type'=>'text']); ?>
                        </div>
                        <div class="col-md-12">
                            <label>Documents</label>
                            <div class="dropzone" id="id_dropzone"> </div>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('photo_file',["id"=>"photo_id","label"=>"Photo d'illustration ","class"=>"dropify", "type"=>"file", "accept"=>"image/*"]) ?>
                        </div>
                        <!--/span-->
                        <div class="col-md-12">
                           <?php echo $this->Form->control('contenu',['label' => 'Description',"class"=>"textarea_editor form-control", "rows"=>"15",'type'=>'textarea']); ?>
                        </div>
                        <!--/span-->
                    </div>
                    
                
                </div>
                
            
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php 
                    /*echo $this->Form->control('categories._ids', [
                        'type' => 'select',
                        'options' => $categories,
                        'label'=>'Catégorie',
                        'multiple' => true,
                        "class"=>"select2Cat form-control select2-multiple ",
                    ]);*/
                  
                    echo $this->Form->control('categories.0.id', [
                        'type' => 'select',
                        'options' => $categories,
                        'label'=>'Catégorie',
                        "class"=>"select2Cat form-control ",
                        'required' => true,
                        'empty' => 'Séléctionnez'
                    ]);
                    
                     ?>
                    
                    <?php 
                        //$optStatus = array('private'=>'Privée', 'public'=>'Public');
                        $optStatus = array('private'=>'Brouillon', 'public'=>'Publié');
                        echo $this->Form->control('status', [
                            'type' => 'select',
                            'options' => $optStatus,
                            'label'=>'Statut',
                            'id'=>'id_statuChange'
                        ]);
                    
                     ?>
                     <div class="kl_visiblepar ">
                        <?php
                        echo $this->Form->control('type_profils._ids', [
                            'type' => 'select',
                            'options' => $typeProfils,
                            'label'=>'Niveaux d’accès',
                            'multiple' => true,
                            'data-placeholder'=>'Séléctionner',
                            "class"=>"select2 form-control select2-multiple select2CustomEvent",
                        ]);
                        ?>
                     </div>
                     
                     <div class="form-actions">
                        <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded btn-success",'escape'=>false]) ?>
                        <?= $this->Form->button(__('Cancel'),["type"=>"reset", "class"=>"btn btn-rounded btn-inverse",'escape'=>false]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->Form->end() ?>