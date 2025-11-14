<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
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
$titrePage = "Information documentation" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
'Documentation',
['controller' => 'Posts', 'action' => 'index']
);

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
                            <label>Titre : </label>
                            <?php echo $post->titre; ?>
                        </div>
                        <div class="col-md-12">
                            <label>Categorie : </label>
                            <?php $categories = [];
                                foreach($post->categories as $categorie){
                                    $categories [] = $categorie->nom;
                                }
                                echo implode('et ', $categories);
                            ?>
                        </div>
                        <div class="col-md-12">
                            <label>Statut : </label>
                            <?php $etats = ['public'=>'Publié', 'private'=>'Brouillon']; ?>
                            <?php echo $etats[$post->status]; ?>
                        </div>
                        <div class="col-md-12">
                            <label>Niveau d'accès : </label>
                            <?php
                                  $accesPar = array();
                                  foreach($post->type_profils as $typeProfil){
                                    array_push($accesPar, $typeProfil->nom);
                                  }
                                  echo $this->Text->toList($accesPar);
                            ?>
                        </div>
                        <div class="col-md-12"><br>
                            <label>Photo d'illustration : </label><br>
                            <?php
                                 if(!empty($post->url_photo_illustration)) {
                                    echo $this->Html->link($this->Html->image($post->url_photo_illustration,['class'=>'', 'width'=>'128', 'height'=>'128']), $post->url_photo_illustration, ['escape'=>false, 'target'=>'_blank']);
                                 }
                            ?>
                        </div><br>

                        <div class="col-md-12"><br>
                            <label>Documents : </label><br>
                            <?php
                             if(!empty($post->fichiers)) {
                                foreach($post->fichiers as $fichier) {
                                    if(!empty($fichier->url)) {
                                        //debug($fichier->url);
                                        echo $this->Html->link($this->Html->image($fichier->url,['class'=>'', 'width'=>'128', 'height'=>'128']), $fichier->url, ['escape'=>false, 'target'=>'_blank']);
                                    }
                                }
                            }
                            ?>
                        </div>

                        <div class="col-md-12"><br>
                            <label>Descriptions : </label>
                            <?= $post->contenu ?>
                        </div>
                        <!--/span-->
                    </div>


                </div>


            </div>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
