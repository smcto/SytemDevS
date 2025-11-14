<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]); ?>
<?= $this->Html->script('DocumentMarketings/add.js', ['block' => true]); ?>
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>


<?php
$titrePage = "Documents commerciaux & marketing" ;
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
            <div class="card-body">
                <?php 
                    /*$defaultUrl = '';
                    if(!empty($documentMarketing->catalogue_spherik)){
                        $defaultUrl = 'default-file="'.$documentMarketing->url_catalogue_spherik.'"';
                    } 
                    debug($defaultUrl);*/

                    echo $this->Form->create($documentMarketing,['type'=>'file']);


                    echo $this->Form->control('catalogue_spherik_file_2020',[
                        'type'=>'file',
                        'class'=>'dropify',
                        'label'=>'Catalogue Sphérik 2020',
                        'data-allowed-file-extensions'=>'pdf',
                        'data-default-file'=>$documentMarketing->get('UrlCatalogueSpherik2020')
                    ]);

                    echo $this->Form->control('catalogue_spherik_file',[
                            'type'=>'file',
                            'class'=>'dropify',
                            'label'=>'Catalogue Sphérik 2021' ,
                            'data-allowed-file-extensions'=>'pdf', 
                            'data-default-file'=>$documentMarketing->url_catalogue_spherik
                        ]);
                    echo $this->Form->control('catalogue_classik_file',[
                        'type'=>'file',
                        'class'=>'dropify',
                        'label'=>'Catalogue Classik',
                        'data-allowed-file-extensions'=>'pdf',
                        'data-default-file'=>$documentMarketing->url_catalogue_classik
                    ]);
                    echo $this->Form->control('cgl_classik_part',[
                        'type'=>'textarea',
                        'rows' => 15,
                        'class'=>'textarea_editor',
                        'label'=>'CGL Classik Particulier',
                    ]);
                    echo $this->Form->control('cgl_spherik_part',[
                        'type'=>'textarea',
                        'rows' => 15,
                        'class'=>'textarea_editor',
                        'label'=>'CGL Spérik Particulier',
                    ]);
                    echo $this->Form->control('cgl_pro',[
                        'type'=>'textarea',
                        'rows' => 15,
                        'class'=>'textarea_editor',
                        'label'=>'CGL Pro',
                    ]);
                    echo $this->Form->button(__('Enregistrer'),['class'=>'btn btn-primary']) ;
                    echo $this->Form->end();

                ?>
            </div>
        </div>
    </div>
</div>




