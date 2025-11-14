<?= $this->Html->script('devisFactures/model_list.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->css('select2/select2.min.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->script('select2/select2.full.min.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>

<?php

$titrePage = "Liste modèles devis" ;

$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add(
    'Réglases',
    ['controller' => 'Dashboards', 'action' => 'reglages']
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

$this->start('actionTitle');
    echo $this->Html->link('Créer un nouveau',['action'=>'add', 'is_model' => 1],['escape'=>false,"class"=>"btn pull-right hidden-sm-down btn-rounded btn-success" ]);                           
$this->end();
?>

<div class="row" id="body_borne">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <?= $this->Form->create(false, ['type' => 'GET', 'class' => 'mt-4']); ?>
                    <input type="hidden" id="id_baseUrl" value="<?= $this->Url->build('/', true) ?>"/>
                    <div class="row">
                        <div class="col-md-3">
                            <?= $this->Form->control('category', ['options' => $categories, 'label' => false, 'default' => $cat, 'empty' => 'Catégorie ']); ?>
                        </div>

                        <div class="col-md-3">
                            <?= $this->Form->control('sous-category', ['label' => false, 'options' => [], 'default' => $sousCat, 'empty' => 'Sous Catégorie ']); ?>
                        </div>
                        
                        <div class="col-md-2">
                            <?= $this->Form->button('<i class="fa fa-search"></i> Filtrer', ['label' => false, 'class' => 'btn btn-outline-primary'] );?>
                            <?= $this->Html->link('<i class="fa fa-refresh"></i>', ['?' => false], ["data-toggle" => "tooltip", "title" => "Réinitialiser", "class" => "btn btn-outline-dark", "escape" => false]);?>
                        </div>
                    </div>
                <?= $this->Form->end(); ?>
                    
                <table class="table table-striped" id="div_table_bornes">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Dossier</th>
                            <th class="text-right">HT</th>
                            <th class="text-right">TTC</th>
                            <th width="1%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listeDevisFactures as $key => $devis): ?>
                            <tr>
                                <td><a href="<?= $this->Url->build(['action' => 'view', $devis->id]) ?>"><?= $devis->model_name ?></a></td>
                                <td><?= $devis->modele_devis_facturescategory?$devis->modele_devis_facturescategory->name:"" ?> <?= $devis->modele_devis_facturessous_category?" / " . $devis->modele_devis_facturessous_category->name : ""?></td>
                                <td class="text-right"><?= $devis->get('TotalHtWithCurrency') ?></td>
                                <td class="text-right"><?= $devis->get('TotalTtcWithCurrency') ?></td>
                                <td>
                                    <div class="dropdown d-inline container-ventes-actions">
                                        <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $devis->id]) ?>" >Voir le document</a>
                                            <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'view', $devis->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                            <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'add', $devis->id]) ?>">Modifier le document</a>
                                            <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $devis->id]) ?>" target="_blank">Imprimer le document</a>
                                            <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'pdfversion', $devis->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                            <!-- <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $devis->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes vous sur de vouloir supprimer ?'] ); ?> -->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var modelSousCategories = <?php echo json_encode($sousCategories); ?>;
</script>
