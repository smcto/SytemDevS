<?php
$titrePage = "Liste opportunités" ;
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
                <?= $this->Form->create(null, ['type' => 'GET', 'class' => 'mt-4']); ?>
                    <div class="filter-list-wrapper opportunite-filter-wrapper custom_threshold">
                        <div class="filter-block">
                            <?= $this->Form->control('keyword', ['label' => false, 'default' => $option['keyword'], 'placeholder' => 'Rechercher']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('type_client_id', ['options' => $typeClients, 'label' => false, 'default' => $option['type_client_id'], 'class' => 'selectpicker', 'empty' => 'Type de société']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('opportunite_statut_id', ['options' => $opportuniteStatuts, 'label' => false, 'default' => $option['opportunite_statut_id'], 'class' => 'selectpicker', 'empty' => 'Statut']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('pipeline_id', ['options' => $pipelines, 'label' => false, 'default' => $option['pipeline_id'], 'class' => 'selectpicker', 'empty' => 'Pipeline']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('pipeline_etape_id', ['options' => $pipelineEtapes, 'label' => false, 'default' => $option['pipeline_etape_id'], 'class' => 'selectpicker', 'empty' => 'Pipeline Etape']); ?>
                        </div>
                        <div class="filter-block">
                            <?php 
                            $typeDemandes = ['devis'=>'Devis','contact' => 'Contact'];
                            echo $this->Form->control('type_demande', ['options' => $typeDemandes, 'label' => false, 'default' => $option['type_demande'], 'class' => 'selectpicker', 'empty' => 'Type de demande']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('type_evenement_id', ['options' => $typeEvenements, 'label' => false, 'default' => $option['type_evenement_id'], 'class' => 'selectpicker', 'empty' => 'Type de Evénement']); ?>
                        </div>
                        <div class="filter-block">
                            <?= $this->Form->control('user_id', ['options' => $users, 'label' => false, 'default' => $option['user_id'], 'class' => 'selectpicker', 'empty' => 'Collaborateur']); ?>
                        </div>
                        <div class="filter-block col-filter">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>

                <div class="row-fluid d-block clearfix mt-3">
                </div>
                                    
                <table class="table table-striped table-opportunites" id="div_table_bornes">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Statut</th>
                            <th class="th-client">Client / prospect</th>
                            <th class="th-societe">Type de société</th>
                            <th>Collaborateur</th>
                            <th>Pipeline</th>
                            <th>Etape</th>
                            <th class="th-montant">Potentiel</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //debug($opportunites); die;
                         foreach ($opportunites as $opportunite): ?>
                            <tr>
                                <td><a href="<?= $this->Url->build(['controller' => 'Opportunites', 'action' => 'view', $opportunite->id]) ?>"><?= h($opportunite->nom) ?></a></td>
                                <td><?= @$opportunite->opportunite_statut->nom ?></td>
                                <td><?= @$opportunite->client->full_name ?></td>
                                <td><?= @$opportunite->type_client->nom ?></td>
                                <td>
                                    <?php
                                        if(!empty($opportunite->users)){
                                            $collection = new \Cake\Collection\Collection($opportunite->users);
                                            $names = $collection->extract('full_name')->toList();
                                            echo $this->Text->toList($names);
                                        }
                                    ?>
                                </td>
                                <td><?= @$opportunite->pipeline->nom ?></td>
                                <td><?= @$opportunite->pipeline_etape->nom ?></td>
                                <td><?= $this->Number->format($opportunite->montant_potentiel).' €' ?></td>
                                <td><?= $opportunite->created ?></td>
                               
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="mt-4 clearfix"><?= $this->element('tfoot_pagination') ?></div>
            </div>
        </div>
    </div>
</div>


