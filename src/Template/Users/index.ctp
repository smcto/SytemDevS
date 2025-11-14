<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>
<?= $this->Html->script('users/users.js', ['block' => true]); ?>

<?php
$titrePage = "Liste des utilisateurs" ;
if($group_user == 1){
    $titrePage = "Liste des contacts" ;
    $this->assign('title', 'Contacts');
} else if($group_user == 2){
    $titrePage = "Liste des utilisateurs" ;
    $this->assign('title', 'Utilisateurs');
} else {
    $this->assign('title', 'Utilisateurs');
}

$this->start('breadcumb');
$this->Breadcrumbs->add('Tableau de bord',['controller' => 'Dashboards', 'action' => 'index']);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

unset($customFinderOptions['group_user']);
unset($customFinderOptions['typeProfil']);
$customFinderOptions['typeprofil'] = $typeProfil;
$customFinderOptions['exportxlsx'] = 1;
$customFinderOptions['action'] = 'index';
$customFinderOptions[] = $group_user;

$this->start('actionTitle');
echo $this->Html->link(__('Create'),['action'=>'add', $group_user],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success m-l-5" ]);
echo $this->Html->link('Export excel',$customFinderOptions,['escape'=>false,"class"=>"btn btn-rounded pull-right btn-secondary m-l-5"]);
echo $this->Html->link('Vue map',['action'=>'map', $group_user],['escape'=>false,"class"=>"btn btn-rounded pull-right btn-secondary"]);

$this->end();

?>
<input value="<?= $group_user ?>" id="group_user" type="hidden">
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- .left-right-aside-column-->
            <div class="contact-page-aside">
                <!-- .left-aside-column-->
                <div class="left-aside">
                    <ul class="list-style-none">
                        <li class="box-label"><a href="javascript:void(0)"><?= $group_user == 1?"Contacts":"Utilisateurs" ?> <span><?= count($users) ?></span></a></li>
                        <li class="divider"></li>
                        <?php foreach($typeProfils as $profil)  : ?>
                            <li><?= $this->Html->link($profil->nom.'<span>'.count($profil->users).'</span>', ['action' => 'index/'.$group_user.'?typeprofil='.$profil->id], ["escape"=>false]) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <!-- /.left-aside-column-->
                <div class="right-aside">
                    <div class="right-page-header">
                        <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']); ?>
                        <div class="filter-list-wrapper user-contact-filter-wrapper">
                            <div class="col-md-3">
                                <?= $this->Form->control('key',[
                                    'value'=>$key, 
                                    'label'=>false, 
                                    'class'=>'form-control search',
                                    'placeholder'=>'Rechercher...', 
                                    'id'=>'key', 
                                    'style' => 'width:100%'
                                ]); ?>
                            </div>
                            
                            <?php if($group_user == 1) : ?>
                                <div class="col-md-3">
                                    <?= $this->Form->control('antenne',[
                                        'type' => 'select',
                                        'label' => false ,
                                        'options'=>$antennes,
                                        'value'=> $antenne,
                                        'required'=>false,
                                        'empty'=>'Sélectionner une antenne', 
                                        'class' => 'select2' , 
                                        'style' => 'width:100%'
                                    ]);?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="col-md-3">
                                <?php echo $this->Form->control('typeprofil',[
                                'type' => 'select',
                                'label' => false,
                                'options'=>$typeProfilsList,
                                'value'=> $typeProfil,
                                'required'=>false,
                                'empty'=>'Sélectionner un type profil',
                                'id'=>'type_profil']); ?>
                            </div>
                            
                            <div class="col-md-3">
                                <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] ); ?>
                                <?php echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index', $group_user], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]); ?>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                    <div class="table-responsive">
                        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded footable" >
                            <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Type(s) profil(s)</th>
                                <th scope="col">Ville</th>
                                <?php if($group_user == 1){ ?> <th scope="col">Antenne(s)</th> <?php  }?>
                                <th scope="col" class="hide"></th>
                                <th scope="col" class="hide"></th>
                                <th scope="col" class="hide"></th>
                                <th scope="col">Téléphone</th>
                            </tr>
                            </thead>
                            <tbody>
                            <input type="text" class="hide"  id="nbusers" value="<?= count($users)?>"/>
                            <?php $i= 0;
                            foreach ($users as $user) : ?>
                            <tr>
                                <td>
                                    <?= $this->Html->link($this->Html->image($user->url_photo,['class'=>'img-circle']).'  '.$user->full_name, ['action' => 'view', $user->id], ['escape'=>false]) ?>
                                </td>
                                <td>
                                    <?php $typeProfils = [];
                                        if(!empty($user->profils)){
                                            foreach ($user->profils as $typeProfil) {
                                                $typeProfils [] = $typeProfil->nom;
                                            }
                                        }
                                        echo implode(', ', $typeProfils);
                                    ?>
                                </td>
                                <td><?= h($user->ville) ?></td>
                                <!--<td><?php if(!empty($user->antenne)) echo  $user->antenne->ville_principale ?></td>-->

                                <?php if($group_user == 1){ ?>
                                <td>
                                    <?php
                                        $antennes = [];
                                        if(!empty($user->antennes_rattachees)){
                                            foreach ($user->antennes_rattachees as $antenne) {
                                                $antennes [] = $antenne->ville_principale;
                                            }
                                        }
                                        echo implode(', ', $antennes);
                                    ?>
                                </td>
                                <?php  }?>
                                <td class="hide"><input  id="nom_<?= $i ?>" value="<?= h($user->nom)?>" /></td>
                                <td class="hide"><input id="lat_<?= $i ?>" value="<?php if(!empty($user->antenne)) echo $user->antenne->latitude ?>"/></td>
                                <td class="hide"><input id="lgt_<?= $i ?>" value="<?php if(!empty($user->antenne)) echo $user->antenne->longitude ?>"/></td>
                                <td><?= h($user->telephone_portable) ?></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['action' => 'delete', $user->id, $group_user], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
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
</div>

<div class="form-group row" id="div_map_users">
    <div class="col-md-12">
        <div id="mapCanvas" style="width:auto; height:400px;"></div>
        <div class="kl_infoForm"></div>
    </div>
</div>

