<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<!-- Footable -->
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>

<?php
$titrePage = "Liste des utilisateurs" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Dashboards',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link('Create',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
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
                        echo $this->Form->control('typeprofil',[
                            'type' => 'select',
                            'label' => false,
                            'options'=>$typeProfils,
                            'required'=>false,
                            'empty'=>'Séléctionner un type profil',
                            'id'=>'type_profil']);
                        echo $this->Form->control('antenne', ['label' => false ,'options'=>$antennes, 'value'=> $antenne, 'class'=>'form-control' ,'empty'=>'Séléctionnez une antenne'] );

                        echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-primary'] );
                        echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-success", "escape"=>false]);

                        echo $this->Form->end();
                        ?>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenoms</th>
                            <th scope="col">Type(s) profil(s)</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Antenne rattaché</th>
                            <th scope="col">Téléphone</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                        <?php if (!empty($user->contacts)){ ?>
                        <tr>
                            <td><?= $this->Html->link($user->contacts[0]->nom, ['action' => 'view', $user->id]) ?></td>
                            <td><?= $this->Html->link($user->contacts[0]->prenom, ['action' => 'view', $user->id]) ?></td>
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
                            <td><?= h($user->contacts[0]->ville) ?></td>
                            <td><?php if(!empty($user->contacts[0]->antenne)) echo  $user->contacts[0]->antenne->ville_excate ?></td>
                            <td><?= h($user->contacts[0]->telephone) ?></td>
                            <td></td>
                            <td></td>
                            <td>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php endforeach; ?>
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
            </div>
        </div>
    </div>

</div>