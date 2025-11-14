<?php

$titrePage = "Liste bons de livraison" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);
    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<div class="row" id="body_borne">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'form-filtre mt-4']); ?>
                    <input type="hidden" id="id_baseUrl" value="<?= $this->Url->build('/', true) ?>"/>
                    <div class="filter-list-wrapper devis-filter-wrapper">
                        
                        <div class="col-md-3">
                            <?= $this->Form->control('keyword', ['label' => false, 'default' => @$keyword, 'placeholder' => 'Rechercher']); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $this->Form->control('user_id', ['type' => 'select', 'label' => false, 'default' => @$user_id, 'options' => $commercials, 'class' => 'selectpicker', 'empty' => 'Contact ']); ?>
                        </div>

                        <div class="col-md-3">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>

                    <div class="table-responsive clearfix">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?= $this->Paginator->sort('indent', 'N°') ?></th>
                                    <th><?= $this->Paginator->sort('Clients.nom', 'Clients') ?></th>
                                    <th><?= $this->Paginator->sort('User.nom', 'Contact') ?></th>
                                    <th><?= $this->Paginator->sort('created', 'Date commande') ?></th>
                                    <th>Date depart atelier</th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bonsLivraisons as $key => $livraison): ?>
                                    
                                    <tr>
                                        <td>
                                            <a href="<?= $this->Url->build(['action' => 'view', $livraison->id]) ?>"><?= $livraison->indent ?></a>
                                        </td>
                                        <td>
                                            <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $livraison->client_id]) ?>"><?= $livraison->client?$livraison->client->full_name : '--' ?></a>
                                        </td>
                                        <td>
                                            <?php if ($livraison->user) : ?>
                                                <img alt="Image" src="<?= $livraison->user->url_photo ?>" class="avatar" data-title="<?= $livraison->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $livraison->created ? $livraison->created->format('d/m/Y'):"--" ?></td>
                                        <td><?= $livraison->date_depart_atelier ? $livraison->date_depart_atelier->format('d-m-Y') : '--' ?></td>
                                        <td>
                                                <div class="dropdown d-inline container-ventes-actions">
                                                    <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item delete-bc" href="javascript:void(0);">Supprimer</a>
                                                        <input type="hidden" value="<?= $livraison->id ?>" id="delete-bc-id">
                                                        <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $livraison->id]) ?>" >Voir le document</a>
                                                    </div>
                                                </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <div class="mt-4 clearfix"><?= $this->element('tfoot_pagination') ?></div>
            </div>
        </div>
    </div>
</div>

