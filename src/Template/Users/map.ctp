<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('users/listusers.js', ['block' => true]); ?>


<!-- Footable -->
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>

<?php
$titrePage = "Liste des utilisateurs" ;
if($group_user == 1){
$titrePage = "Liste des contacts" ;
} else if($group_user == 2){
$titrePage = "Liste des utilisateurs" ;
}
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link(__('Create'),['action'=>'add', $group_user],['escape'=>false,"class"=>"btn pull-right btn-rounded hidden-sm-down btn-success" ]);
$this->end();

?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="button-group">
                        <?php echo $this->Html->link(__('Vue liste'),['action'=>'index', $group_user],['escape'=>false,"class"=>"btn btn-rounded btn-primary btn-success" ]);  ?>
                <div><hr>
            </div>
            <!-- .left-right-aside-column-->
            <div class="contact-page-aside">
                <!-- .left-aside-column-->
                <div class="left-aside">
                    <ul class="list-style-none">
                        <li class="box-label"><a href="javascript:void(0)"><?php if($group_user == 1){ echo "Contacts"; } else { echo "Utilisateurs" ;} ?> <span><?= count($users) ?></span></a></li>
                        <li class="divider"></li>
                        <?php foreach($typeProfils as $profil) { ?>
                        <!--<li><a href="javascript:void(0)"><?= $profil->nom ?><span><?= count($profil->users) ?></span></a></li>-->
                            <li><?= $this->Html->link($profil->nom.'<span>'.count($profil->users).'</span>', ['action' => 'index?typeprofil='.$profil->id], ["escape"=>false]) ?></li>
                        <?php }?>
                    </ul>
                </div>
                <!-- /.left-aside-column-->
                <div class="right-aside">
                    <div class="right-page-header">
                        <div class="row">
                            <?php
                        echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']);
                            echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']);
                            echo $this->Form->control('typeprofil',[
                            'type' => 'select',
                            'label' => false,
                            'options'=>$typeProfilsList,
                            'value'=> $typeProfil,
                            'required'=>false,
                            'empty'=>'Sélectionner un type profil',
                            'id'=>'type_profil']);
                            if($group_user != 2){
                                echo $this->Form->control('antenne',[
                                'type' => 'select',
                                'label' => false ,
                                'options'=>$antennes,
                                'value'=> $antenne,
                                'required'=>false,
                                'empty'=>'Sélectionner une antenne',
                                'id'=>'antennes'] );
                            }

                            echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] );
                            echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'map', $group_user], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]);

                            echo $this->Form->end();
                            ?>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row" id="div_map_users">
                        <div class="col-md-12">
                            <div id="mapCanvas" style="width:auto; height:400px;"></div>
                            <div class="kl_infoForm"></div>
                        </div>
                    </div>

                    <div class="hide">
                        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded footable" >
                            <thead>
                            <tr>
                                <th scope="col" class="hide">Id</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Type(s) profil(s)</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Antenne</th>
                                <th scope="col" class="hide"></th>
                                <th scope="col" class="hide"></th>
                                <th scope="col" class="hide"></th>
                                <th scope="col">Téléphone</th>
                                <th scope="col" class="hide">URL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <input type="text" class="hide"  id="nbusers" value="<?= count($users)?>"/>
                            <?php
                            $i=-1;
                            foreach ($users as $user){
                            $i= $i+1;//debug($user);
                            ?>
                            <tr>
                                <td class="hide"><input id="id_<?= $i ?>" value="<?php if(!empty($user->id)) echo ($user->id) ?>"/></td>
                                <td><?= $this->Html->link($this->Html->image($user->url_photo,['class'=>'img-circle']).'  '.$user->full_name,
                                    ['action' => 'view', $user->id], ['escape'=>false]) ?>
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
                                <td><?php if(!empty($user->antenne)) echo  $user->antenne->ville_principale ?></td>
                                <td class="hide"><input  id="nom_<?= $i ?>" value="<?= h($user->full_name)?>" /></td>
                                <td class="hide"><input id="lat_<?= $i ?>" value="<?php if(!empty($user->antenne)) echo $user->antenne->latitude ?>"/></td>
                                <td class="hide"><input id="lgt_<?= $i ?>" value="<?php if(!empty($user->antenne)) echo $user->antenne->longitude ?>"/></td>
                                <td><?= h($user->telephone_portable) ?></td>
                                <td class="hide"><input id="img_<?= $i ?>" value="<?php if(!empty($user->url_photo)) echo $user->url_photo ?>"/></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="text-right">
                                        <ul class="pagination">
                                            <?= $this->Paginator->first('<< ' . __('first')) ?>
                                            <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                            <?= $this->Paginator->numbers() ?>
                                            <?= $this->Paginator->next(__('next') . ' >') ?>
                                            <?= $this->Paginator->last(__('last') . ' >>') ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!--<div class="form-group row">
                         <div class="col-md-12">
                               <div id="mapCanvas" style="width:auto; height:400px;"></div>
                                 <div class="kl_infoForm"></div>
                          </div>
                    </div>-->
                 </div>
                <!-- /.left-right-aside-column-->
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

