<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact[]|\Cake\Collection\CollectionInterface $contacts
 */
?>
<?php
$titrePage = "Liste des contacts" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
echo $this->Html->link('Créer',['action'=>'add'],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]);
$this->end();

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-body">
                      <div class="row">
                          <?php echo $this->Form->create(null, ['type' => 'get' ,'class'=>'form-inline','role'=>'form']); ?>
                          <?php echo $this->Form->control('key',['value'=>$key, 'label'=>false, 'class'=>'form-control search','placeholder'=>'Rechercher...']); ?>
                          <?php echo $this->Form->control('statut', ['label' => false ,'options'=>$statuts, 'value'=> $statut, 'class'=>'form-control' ,'empty'=>'Séléctionnez type contact'] ); ?>
                          <?php echo $this->Form->control('antenne', ['label' => false ,'options'=>$antennes, 'value'=> $antenne, 'class'=>'form-control' ,'empty'=>'Séléctionnez une antenne'] ); ?>
                          <?php echo $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false ,'class' => 'btn btn-outline-primary'] ); ?>
                          <?php echo $this->Html->link('<i class="fa fa-refresh"></i>', ['action' => 'index'], ["data-toggle"=>"tooltip", "title"=>"Réinitialiser", "class"=>"btn btn-outline-dark", "escape"=>false]); ?>
                          <?php echo $this->Form->end(); ?>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Type contact</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Antenne</th>
                            <th scope="col">Situation</th>
                            <th class="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($contacts as $contact):?>
                        <tr>

                            <td><?= h($contact->statut->titre) ?></td>
                            <td><?= h($contact->nom) ?></td>
                            <td><?= h($contact->prenom) ?></td>
                            <td><?= h($contact->telephone_portable) ?></td>
                            <td><?= h($contact->email) ?></td>
                            <td><?= $contact->has('antenne') ? $this->Html->link($contact->antenne->ville_excate, ['controller' => 'Antennes', 'action' => 'edit', $contact->antenne->id]) : '' ?></td>
                            <td><?php if(!empty($contact->situation)) echo ($contact->situation->titre) ?></td>
                            <td>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contact->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete ?')]) ?>
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




<!--<div class="contacts index large-9 medium-8 columns content">
    <h3><?= __('Contacts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('statut_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('prenom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('telephone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_naissance') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_vehicule') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modele_vehicule') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nbr_borne_transportable_vehicule') ?></th>
                <th scope="col"><?= $this->Paginator->sort('antenne_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('photo_nom') ?></th>
                <th scope="col"><?= $this->Paginator->sort('situation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?= $this->Number->format($contact->id) ?></td>
                <td><?= $contact->has('statut') ? $this->Html->link($contact->statut->id, ['controller' => 'Statuts', 'action' => 'view', $contact->statut->id]) : '' ?></td>
                <td><?= h($contact->nom) ?></td>
                <td><?= h($contact->prenom) ?></td>
                <td><?= h($contact->telephone) ?></td>
                <td><?= h($contact->email) ?></td>
                <td><?= h($contact->date_naissance) ?></td>
                <td><?= h($contact->is_vehicule) ?></td>
                <td><?= h($contact->modele_vehicule) ?></td>
                <td><?= $this->Number->format($contact->nbr_borne_transportable_vehicule) ?></td>
                <td><?= $contact->has('antenne') ? $this->Html->link($contact->antenne->id, ['controller' => 'Antennes', 'action' => 'view', $contact->antenne->id]) : '' ?></td>
                <td><?= h($contact->photo_nom) ?></td>
                <td><?= $contact->has('situation') ? $this->Html->link($contact->situation->id, ['controller' => 'Situations', 'action' => 'view', $contact->situation->id]) : '' ?></td>
                <td><?= h($contact->created) ?></td>
                <td><?= h($contact->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contact->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contact->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contact->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>-->
