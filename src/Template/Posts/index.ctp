<?php
$titrePage = "Documentation" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link(__('Create'),['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);                           
$this->end();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-body">
                    <div class="row">
                        <?php
                        echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);
                        echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']);
                        echo $this->Form->control('etat', ['label' => false ,'options'=>$etats, 'value'=> $etat, 'class'=>'form-control' ,'empty'=>'Sélectionner un état'] );
                        echo $this->Form->control('categorie', ['label' => false ,'options'=>$categories, 'value'=> $categorie, 'class'=>'form-control' ,'empty'=>'Sélectionner une catégorie'] );

                        echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary','style'=>'margin: 0 10px 0 10px'] );
                        echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);

                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('titre') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('status', 'Etat') ?></th>
                                <th scope="col"><a href="#">Catégorie</a></th>
                                <th scope="col"><?= $this->Paginator->sort('status','Niveaux d’accès') ?></th>
                             
                            </tr>
                        </thead>
                        <tbody>
                             <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td>
                                        <?php if(in_array("admin", $user_connected["typeprofils"])) {
                                            echo $this->Html->link($post->titre, ['action' => 'edit', $post->id]);
                                        } else {
                                            echo $this->Html->link($post->titre, ['action' => 'view', $post->id]);
                                        } ?>
                                    </td>
                                    <td><?php $etats = ['public'=>'Publié', 'private'=>'Brouillon']; echo $etats[$post->status]; ?></td>
                                    <td>
                                        <?php
                                            $cat = array();
                                            foreach($post->categories as $categorie){
                                                array_push($cat, $categorie->nom);
                                            }
                                            echo $this->Text->toList($cat);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $accesPar = array();
                                            foreach($post->type_profils as $typeProfil){
                                                array_push($accesPar, $typeProfil->nom);
                                            }
                                            echo $this->Text->toList($accesPar);
                                        ?>
                                    </td>
                                    <td>
                                        <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $post->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                    </td>
                                </tr>
                             <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?= $this->element('tfoot_pagination') ?>
                </div>
            </div>
        </div>
    </div>

</div>