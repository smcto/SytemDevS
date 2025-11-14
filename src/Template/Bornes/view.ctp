<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Borne $borne
 */
?>
<!-- Color picker plugins css -->
<?= $this->Html->css('dropify/dropify.min.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/sytle.css', ['block' => true]) ?>
<?= $this->Html->css('dropify/green.css', ['block' => true]) ?>

<!-- Plugin for this page -->
<?= $this->Html->css('jquery-asColorPicker-master/asColorPicker.css', ['block' => true]) ?>
<?= $this->Html->css('dropzone/dropzone.css', ['block' => true]) ?>
<?= $this->Html->css('html5-editor/bootstrap-wysihtml5.css', ['block' => true]) ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('antennes/antenne.css?'.  time(), ['block' => true]) ?>
<?= $this->Html->css('ventes/recap.css?'.  time(), ['block' => true]) ?>
<!-- Plugin for this page -->

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB54P6gFGfSI6_d9Tm82Ig5t2fJtbKSYOE&sensor=false&libraries=places"></script>

<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/wysihtml5-0.3.0.js', ['block' => true]); ?>
<?= $this->Html->script('html5-editor/bootstrap-wysihtml5.js', ['block' => true]); ?>
<?= $this->Html->script('bootstrap/popper.min.js', ['block' => true]) ?>
<?= $this->Html->script('bootstrap/bootstrap.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropify/dropify.min.js', ['block' => true]) ?>
<?= $this->Html->script('dropzone/dropzone.js', ['block' => true]); ?>
<?= $this->Html->script('actubornes/actubornes.js', ['block' => true]); ?>

<?= $this->Html->script('bornes/view.js?'. time(), ['block' => true]); ?>
<?= $this->Html->script('bornes/viewborne.js?'.time(), ['block' => true]); ?>
<?= $this->Html->script('Clients/add.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>

<?php

$gammeName = ($borneEntity->model_borne != null && $borneEntity->model_borne->gammes_borne!= null)? $borneEntity->model_borne->gammes_borne->name : '';
$this->assign('title', 'Borne ' . $gammeName . ' ' . $borneEntity->get('FormatNumero') . ' - ' . $borneEntity->parc->nom) ;

$titrePage = "Information borne" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add(
    'Bornes',
    ['controller' => 'Bornes', 'action' => 'index']
);

$this->Breadcrumbs->add(
    $borneEntity->parc->nom,
    ['controller' => 'Bornes', 'action' => 'index',$borneEntity->parc_id]
);

$this->Breadcrumbs->add($titrePage);

echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

?>

<?php if($borneEntity->parc_id == 3) : ?>
        <?= $this->element('../Bornes/view_borne_tampon') ?>
<?php else : ?>

    <div class="row table-recap hide-table-empty">
        <div class="col-md-6">

            <div class="card">
                <div class="card-body">
                    
                    <h2>BORNE #<?= $this->Number->format($borneEntity->numero) ?></h2>

                    <h3 class="mb-4" id="retour">Infos génerales</h3>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Gamme</td>
                                <td><?= ($borneEntity->model_borne != null && $borneEntity->model_borne->gammes_borne!= null)? $borneEntity->model_borne->gammes_borne->name : ''; ?></td>
                            </tr>
                            <tr>
                                <td>Modèle</td>
                                <td>
                                    <?= $borneEntity->model_borne != null ? $borneEntity->model_borne->nom : ''; ?>
                                    <!--<?= $borneEntity->has('model_borne') ? $this->Html->link($borneEntity->model_borne->nom, ['controller' => 'ModelBornes', 'action' => 'view', $borneEntity->model_borne->id]) : '' ?>-->
                                </td>
                            </tr>
                            <tr>
                                <td>Numero de série</td>
                                <td>
                                    <?= $borneEntity->numero_serie ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Couleur</td>
                                <td>
                                    <?= $borneEntity->couleur != null ? h($borneEntity->couleur->couleur) : '' ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Sortie atelier</td>
                                <td><?= h($borneEntity->sortie_atelier) ?></td>
                            </tr>
                            <tr>
                                <td>Etat général</td>
                                <td><?php if(!empty($borneEntity->etat_borne->etat_general)) echo $borneEntity->etat_borne->etat_general ; ?></td>
                            </tr>

                            <?php if($borneEntity->parc_id != 2 && $borneEntity->is_sous_louee) : ?>

                                <tr>
                                    <td>Sous location</td>
                                    <td><?php echo !empty($borneEntity->is_sous_louee)?'Oui':'Non' ?></td>
                                </tr>
                                <tr>
                                    <td>Antenne</td>
                                    <td><?php echo $borneEntity->antenne?$this->Html->link($borneEntity->antenne->ville_principale,['controller' => 'Antennes','action' => 'edit', $borneEntity->antenne_id],['escape'=>false,"class"=>"" ,]):'--' ;?></td>
                                </tr>

                            <?php endif; ?>
                            
                        </tbody>
                    </table>
                    
                    <?php echo $this->Html->link('Modifier la borne',['action' => 'edit', $borneEntity->id],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ,'style' => "margin:0 10px 0 10px"]); ?>
                </div>
            </div>

            <?php if($borneEntity->equipement_bornes) : ?>
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4" id="retour">Equipements</h3>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="50%" class="p-0"></th>
                                    <th width="50%" class="p-0"></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($borneEntity->equipement_bornes as $equipement) : ?>
                                    <?php if($equipement->equipement || $equipement->precisions) : ?>

                                        <tr>
                                            <td><?= $equipement->type_equipement->nom ?></td>
                                            <td>
                                                <?php if($equipement->equipement) : ?>
                                                    <?= $equipement->equipement->valeur ?>
                                                    <?= @$equipement->numero_series->serial_nb? '#' . $equipement->numero_series->serial_nb . '<br> ': ''; ?>
                                                <?php else : ?>
                                                    <?= $equipement->precisions ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                    <?php endif ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif ?>
                    
            <?php if (!empty($borneEntity->equipements_protections_bornes)): ?>
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4" id="retour">Protections(s) supplémentaire(s)</h3>
                        <table class="table table-bordered table-uniforme">
                            <thead>
                                <tr>
                                    <th width="35%" class="p-0"></th>
                                    <th width="35%" class="p-0"></th>
                                    <th width="25%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody class="default-data">
                                <tr>
                                    <td><b>Type équipement</b></td>
                                    <td><b>Modèle</b></td>
                                    <td><b>Qté</b></td>
                                </tr>
                                <!-- JS -->
                                <?php foreach ($borneEntity->equipements_protections_bornes as $key => $equipementsProtectionBorne): ?>
                                <?php $type_equipement_id = $equipementsProtectionBorne->type_equipement_id ?>
                                <tr class="show">
                                    <td class="nom-equip-accessoire"><?= $equipementsProtectionBorne->type_equipement->nom ?? ''?></td>
                                    <td class="select-equip-accessoire">
                                        <?= $equipementsProtectionBorne->equipement->valeur ?? '   ' ?>
                                    </td>
                                    <td class="qty-equip-accessoire">
                                        <?= $equipementsProtectionBorne->qty ?>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif ?>
                    
                    
            <?php if($borneEntity->licences_bornes) : ?>
                <div class="card">
                    <div class="card-body">

                        <h3 class="mb-4" id="retour">Licence(s)</h3>
                        
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="50%" class="p-0"></th>
                                    <th width="50%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($borneEntity->licences_bornes as $licences_bornes) : ?>
                                    <tr>
                                        <td>Licence <?= $licences_bornes->type_licence->nom ?></td>
                                        <td>
                                            <?= $licences_bornes->numero_serie ?>
                                            <?= $licences_bornes->type_licence->id == 1 ? ' / ' . $licences_bornes->email : '' ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            <?php endif ?>
                    
            <?php if ($borneEntity->checked_accessories && !empty(array_filter($borneEntity->checked_accessories))) : ?>
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4" id="retour">Option(s) borne</h3>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="50%" class="p-0"></th>
                                    <th width="50%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($borneEntity->bornes_accessoires as $key => $bornes_accessoires): ?>
                                    <?php if($bornes_accessoires->qty) : ?>
                                        <tr>
                                            <td><?= @$sousAccessoires[$bornes_accessoires->sous_accessoire_id]->name ?></td>
                                            <td>
                                                <?= $licences_bornes->numero_serie ?>
                                                <?= $bornes_accessoires->qty ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif ?>
            
            
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="mb-4" id="retour">Coût total de fabrication</h3>
                        </div>
                        <div class="col-md-6">
                            <h3>
                                <span class="float-right"><?= $totalMontantAchat ?? 0 ?> €</span>
                            </h3>
                        </div>
                    </div>
                    <?php echo $this->Html->link('Exporter en pdf',['action' => 'exporterEquipements', $borneEntity->id],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ,'style' => "margin:0 10px 0 10px", 'target'=>"_blank"]); ?>
                    <a href="javascript:void(0);" class="btn btn btn-rounded pull-right hidden-sm-down btn-success detail-fabrication mb-4">Voir le détail</a>

                    
                    <?php if($borneEntity->equipement_bornes) : ?>

                        <div class=" table-detail-fabrication hide">
                            <table class="table table-bordered table-hover mt-5">
                                <thead>
                                    <tr>
                                        <th width="30%" class="p-0"></th>
                                        <th width="50%" class="p-0"></th>
                                        <th width="20%" class="p-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  foreach ($borneEntity->equipement_bornes as $equipement) : ?>
                                    <?php if($equipement->equipement) : ?>
                                    <tr>
                                        <td><?= $equipement->type_equipement->nom ?></td>
                                        <td>
                                            <?php if($equipement->equipement) : ?>
                                            <?= $equipement->equipement->valeur ?>
                                            <?= @$equipement->numero_series->serial_nb? '<br>#' . $equipement->numero_series->serial_nb . '<br> ': ''; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $this->Utilities->formatCurrency(@$equipement->numero_series->lot_produit->tarif_achat_ht) ?></td>
                                    </tr>
                                    <?php endif ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    
                    <?php endif ?>
                    
                    <?php if($borneEntity->equipements_protections_bornes) : ?>

                        <div class=" table-detail-fabrication hide">
                            Protection(s) : 
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="30%" class="p-0"></th>
                                        <th width="50%" class="p-0"></th>
                                        <th width="20%" class="p-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  foreach ($borneEntity->equipements_protections_bornes as $equipement) : ?>
                                    <?php if($equipement->equipement) : ?>
                                    <tr>
                                        <td><?= $equipement->type_equipement->nom ?></td>
                                        <td>
                                            <?php if($equipement->equipement) : ?>
                                            <?= $equipement->equipement->valeur ?>
                                            <?= @$equipement->numero_series->serial_nb? '<br>#' . $equipement->numero_series->serial_nb . '<br> ': ''; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $this->Utilities->formatCurrency(@$equipement->numero_series->lot_produit->tarif_achat_ht) ?></td>
                                    </tr>
                                    <?php endif ?>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    
                    <?php endif ?>
                </div>
            </div>
            

            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4" id="retour">Ticket(s) borne</h3>
                    
                    <?php if ($borneEntity->actu_bornes) : ?>
                        <table class="table table-bordered table-uniforme">
                            <thead>
                                <tr>
                                    <th width="30%" class="p-0"></th>
                                    <th width="30%" class="p-0"></th>
                                    <th width="30%" class="p-0"></th>
                                    <th width="10%" class="p-0"></th>
                                </tr>
                            </thead>
                            <tbody class="default-data">
                                <tr>
                                    <td><b>Titre</b></td>
                                    <td><b>Categorie</b></td>
                                    <td><b>Créé le</b></td>
                                    <td></td>
                                </tr>
                                    <!-- JS -->
                                    <?php foreach ($borneEntity->actu_bornes as $actu_borne) : ?>
                                    <tr>
                                        <td><?= $this->Html->link($actu_borne->titre, ['controller' => 'ActuBornes', 'action' => 'edit', $actu_borne->id]) ?></td>
                                        <td><?= $actu_borne->has('categorie_actus') ? $this->Html->link($actu_borne->categorie_actus->titre, ['controller' => 'CategorieActus', 'action' => 'edit', $actu_borne->categorie_actus->id]) : '' ?></td>
                                        <td><?= h($actu_borne->created) ?></td>
                                        <td>
                                            <?= $this->Form->postLink('<i class="mdi mdi-delete text-inverse"></i>', ['controller' => 'ActuBornes', 'action' => 'delete', $actu_borne->id, $borneEntity->id], ['confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        Aucun ticket pour cette borne
                    <?php endif ?>
                    <a class="btn btn btn-rounded pull-right hidden-sm-down btn-success" data-toggle="modal" href="#ticket_borne">Créer un ticket d'intervention</a>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <?php if($borneEntity->parc_id == 2 && $borneEntity->antenne != null):  ?>
                <div class="card">
                    <div class="card-body">
                            
                        <div class="clearfix">
                            <h3 class="mb-4">Antenne <span style="color: red"><?= $borneEntity->antenne->is_deleted?"(Déjà supprimé)" : '' ?></h3>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="50%" class="p-0"></th>
                                        <th width="50%" class="p-0"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>Type de lieu : </td>
                                        <td>
                                            <?= $borneEntity->antenne->lieu_type->nom; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Adresse : </td>
                                        <td>
                                            <?= $borneEntity->antenne->adresse; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ville exacte : </td>
                                        <td>
                                            <?= $borneEntity->antenne->ville_excate; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cp : </td>
                                        <td>
                                            <?= $borneEntity->antenne->cp; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ville principale :</td>
                                        <td>
                                            <?= $borneEntity->antenne->ville_principale; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pays :</td>
                                        <td>
                                            <?= $borneEntity->antenne->pays?$borneEntity->antenne->pays->name:"--"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Secteur Geographique :</td>
                                        <td>
                                            <?= $borneEntity->antenne->secteur_geographique?$borneEntity->antenne->secteur_geographique->nom:"--"; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email comercial :</td>
                                        <td>
                                            <?= $borneEntity->antenne->email_commercial; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Telephone :</td>
                                        <td>
                                            <?= $borneEntity->antenne->telephone; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Etat :</td>
                                        <td>
                                            <?= $borneEntity->antenne->etat?$borneEntity->antenne->etat->valeur:"--"; ?>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>

                        <div class="hide">
                            <div class="hide">
                                <label class="control-label">Adresse *</label>
                                <div id="infoPanel"><?php echo $this->Form->control('adresse',['label' => false,'class'=>'form-control controls','id'=>'searchTextField']);?></div>
                                <input id="info" type="text" size="50" value="" class="hide" />
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Latitude</label>
                                <?php
                                if($borneEntity->antenne != null && !empty($borneEntity->antenne->latitude)){
                                echo $this->Form->control('latitude',["id"=>"txtLatitude",'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$borneEntity->antenne->latitude]);
                                }elseif(!empty($borneEntity->latitude)) {
                                echo $this->Form->control('latitude',["id"=>"txtLatitude",'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$borneEntity->latitude]);
                                }
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Longitude</label>
                                <?php
                                if($borneEntity->antenne != null && !empty($borneEntity->antenne->longitude)){
                                echo $this->Form->control('longitude',["id"=>"txtLongitude", 'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$borneEntity->antenne->longitude]);
                                }elseif(!empty($borneEntity->longitude)) {
                                echo $this->Form->control('longitude',["id"=>"txtLongitude", 'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$borneEntity->longitude]);
                                }
                                ?>
                            </div>
                        </div>

                        <div class="my-4">
                            <?= $this->Html->link('Edit Antenne',['controller' => 'Antennes', 'action' => 'edit', $borneEntity->antenne_id],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ]);  ?>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

            <?php if($borneEntity->parc_id != 2 && $borneEntity->client != null) : ?>
                <div class="card">
                    <div class="card-body">
                    
                        <?php if (!$borneEntity->is_contrat_modified) : ?>
                            <?php if(count($borneEntity->ventes)) : ?>
                                <?php $vente = $borneEntity->ventes[0]; ?>

                                <?php if($vente && $vente->parc_id == $borneEntity->parc_id) : ?>

                                    <h3><?=$borneEntity->parc->nom?></h3>

                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="50%" class="p-0"></th>
                                                <th width="50%" class="p-0"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="<?= $vente->parc_duree!=null? '' : 'hide' ;?>">
                                                <td>Durée</td>
                                                <td><?= $vente->parc_duree->valeur; ?></td>
                                            </tr>
                                            <?php if($vente->contrat_debut != null) : ?>
                                                <tr>
                                                    <td >Début contrat </td>
                                                    <td >
                                                        <?= date_format($vente->contrat_debut,"d/m/Y") ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>


                                            <?php if($vente->contrat_fin != null) : ?>
                                                <tr>
                                                    <td>Fin contrat </td>
                                                    <td>
                                                        <?=  date_format($vente->contrat_fin,"d/m/Y") ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <?php if($vente->contrat_fin != null) : ?>
                                                <tr>
                                                    <td>Date limite de résiliation</td>
                                                    <td>
                                                        <?=  $vente->contrat_fin->subMonth(6)->format('d/m/Y') ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                            <tr>
                                                <td>Commercial</td>
                                                <td><?= $vente->user!=null?$vente->user->prenom . ' ' . $vente->user->nom : ''; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <!-- Lien BL Uploadé -->
                                    <?php if (!empty($vente->get('bon_de_livraison_path'))): ?>
                                        <a class="pl-3" href="#modal-bl" data-href="<?= $this->Url->build($vente->get('bon_de_livraison_path')) ?>" data-toggle="modal" data-target="#modal-bl">Aperçu bon de livraison</a>
                                    <?php endif ?>

                                    <!-- End Lien -->
                                <?php endif ?>

                            <?php elseif(false) : ?>
                            
                                <h3><?=$borneEntity->parc->nom?></h3>

                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50%" class="p-0"></th>
                                            <th width="50%" class="p-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Durée</td>
                                            <td>--</td>
                                        </tr>
                                        <tr>
                                            <td>Début contrat</td>
                                            <td>--</td>
                                        </tr>
                                        <tr>
                                            <td>Fin contrat</td>
                                            <td>--</td>
                                        </tr>
                                        <tr>
                                            <td>Commercial</td>
                                            <td>--</td>
                                        </tr>
                                    </tbody>
                                </table>

                            <?php else : ?>

                                <!-- Si vente -->
                                <h3 class="mb-4"><?=$borneEntity->parc->nom?></h3>
                                <!--  -->
                            <?php endif ?>

                        <?php else: ?>

                            <h3 class="mb-4"><?=$borneEntity->parc->nom?></h3>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="50%" class="p-0"></th>
                                        <th width="50%" class="p-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!$borneEntity->is_parc_vente): ?>
                                        <tr>
                                            <td>Durée</td>
                                            <td><?= $borneEntity->parc_duree->valeur ?? '' ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Début contrat</td>
                                            <td><?= $borneEntity->contrat_debut ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Fin contrat</td>
                                            <td><?= $borneEntity->contrat_fin ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Date limite de résiliation</td>
                                            <td><?= $borneEntity->get('DateResiliation') ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Commercial</td>
                                            <td><?= $borneEntity->user ? $borneEntity->user->get('FullName') : ''; ?></td>
                                        </tr>
                                        
                                    <?php else: ?>
                                        <tr>
                                            <td>Durée</td>
                                            <td><?= $borneEntity->get('GarantieDureeMois') ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Date début garantie</td>
                                            <td><?= $borneEntity->contrat_debut ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Date fin garantie</td>
                                            <td><?= $borneEntity->contrat_fin ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Commercial</td>
                                            <td><?= $borneEntity->user ? $borneEntity->user->get('FullName') : ''; ?></td>
                                        </tr>
                                        
                                    <?php endif ?>
                                </tbody>
                            </table>

                        <?php endif ?>

                        <div class="container-fluid">
                            <div class="clearfix">
                                <?php if ($borneEntity->parc_id != 1): ?>
                                    <a class="btn btn-rounded float-right hidden-sm-down btn-success text-white" data-toggle="modal" data-target="#edit_contrat">Modifier contrat de location</a>
                                    <!-- a href="<?= $this->Url->build(['controller' => 'bornes', 'action' => 'editContrat', $borneEntity->id,])?>" class="btn btn-rounded float-right hidden-sm-down btn-success">Modifier contrat de location </a-->
                                <?php else: ?>
                                    <a class="btn btn-rounded float-right hidden-sm-down btn-success text-white" data-toggle="modal" data-target="#edit_garantie">Modifier les informations de vente</a>
                                    <!--a href="<?= $this->Url->build(['controller' => 'bornes', 'action' => 'editGarantie', $borneEntity->id,])?>" class="btn btn btn-rounded float-right hidden-sm-down btn-success">Modifier les informations de vente</a-->
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php if ($borneEntity->client != null): ?>
                    <div class="card">
                        <div class="card-body">
                            
                            <h3 class="mb-4" id="retour">Client</h3>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="50%" class="p-0"></th>
                                        <th width="50%" class="p-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Genre</td>
                                        <td><?= $genres[$borneEntity->client->client_type] ?? '' ?></td>
                                    </tr>
                                    <?php if($borneEntity->client->client_type == 'corporation') : ?>
                                        <?php if ($borneEntity->client->enseigne): ?>
                                            <tr>
                                                <td>Enseigne</td>
                                                <td><?= $borneEntity->client->enseigne ?></td>
                                            </tr>
                                        <?php endif ?>
                                        <?php if ($borneEntity->client->nom): ?>
                                            <tr>
                                                <td>Raison sociale</td>
                                                <td><?= $borneEntity->client->nom ?></td>
                                            </tr>
                                        <?php endif ?>
                                    <?php else : ?>
                                        <?php if ($borneEntity->client->nom): ?>
                                            <tr>
                                                <td>Nom</td>
                                                <td><?= $borneEntity->client->nom ?></td>
                                            </tr>
                                        <?php endif ?>
                                        <?php if ($borneEntity->client->prenom): ?>
                                            <tr>
                                                <td>Prénom</td>
                                                <td><?= $borneEntity->client->prenom ?></td>
                                            </tr>
                                        <?php endif ?>
                                    <?php endif; ?>
                                    <?php if($borneEntity->client->adresse): ?>
                                        <tr>
                                            <td>Adresse</td>
                                            <td>
                                                <span class="br"><?= $borneEntity->client->adresse ?></span>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if($borneEntity->client->cp): ?>
                                        <tr>
                                            <td>Code postal</td>
                                            <td><?= $borneEntity->client->cp ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if($borneEntity->client->ville): ?>
                                        <tr>
                                            <td>Ville</td>
                                            <td><?= $borneEntity->client->ville ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if($borneEntity->clien): ?>
                                        <tr>
                                            <td>Adresse complémentaire</td>
                                            <td>
                                                <?= $borneEntity->client->adresse_2 ?>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if($borneEntity->client->telephone): ?>
                                        <tr>
                                            <td>Téléphone entreprise</td>
                                            <td><?= $borneEntity->client->telephone ?></td>
                                        </tr>
                                    <?php endif ?>
                                    <?php if($borneEntity->client->email): ?>
                                        <tr>
                                            <td>Email général</td>
                                            <td><?= $borneEntity->client->email ?></td>
                                        </tr>
                                    <?php endif ?>

                                    <?php if ($borneEntity->client->groupe_client): ?>
                                        <tr>
                                            <td>Groupe de client</td>
                                            <td><?= $borneEntity->client->groupe_client != null ? 'Groupe : ' . $borneEntity->client->groupe_client->nom : ''; ?></td>
                                        </tr>
                                    <?php endif ?>
                                    
                                </tbody>
                            </table>
                            
                            <div class="hide">
                                <div class="hide">
                                    <label class="control-label">Adresse *</label>
                                    <div id="infoPanel">
                                        <?php
                                            $valueSearchTextField = '';
                                            if(!empty($borneEntity->client->adresse)) {
                                                $valueSearchTextField = $borneEntity->client->adresse . ', ' .$borneEntity->client->nom . ' ' . $borneEntity->client->prenom .', '. $borneEntity->client->cp.', '.$borneEntity->client->ville;
                                            }elseif(!empty($borneEntity->adresse) && trim($borneEntity->adresse) != ' ') {
                                                $valueSearchTextField = $borneEntity->adresse;
                                            }
                                            echo $this->Form->control('adresse',['label' => false,'class'=>'form-control controls','id'=>'searchTextField','value' => $valueSearchTextField]);
                                        ?>
                                    </div>
                                    <input id="info" type="text" size="50" value="" class="hide" />
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Latitude</label>
                                    <?php
                                        $valueTxtLatitude = '';
                                        if(!empty($borneEntity->client->addr_lat)) {
                                            $valueTxtLatitude = $borneEntity->client->addr_lat;
                                        }elseif(!empty($borneEntity->latitude)) {
                                            $valueTxtLatitude = $borneEntity->latitude;
                                        }
                                        echo $this->Form->control('latitude',["id"=>"txtLatitude",'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$valueTxtLatitude]);
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Longitude</label>
                                    <?php
                                        $valueTxtLongitude = '';
                                        if(!empty($borneEntity->client->addr_lng)) {
                                            $valueTxtLongitude = $borneEntity->client->addr_lng;
                                        }elseif(!empty($borneEntity->longitude)) {
                                            $valueTxtLongitude = $borneEntity->longitude;
                                        } 
                                        echo $this->Form->control('longitude',["id"=>"txtLongitude", 'type'=>'text', 'label' => false,'class'=>'form-control ', "readonly"=>"true", "value"=>$valueTxtLongitude]);
                                    ?>
                                </div>
                            </div>

                            <div id="mapCanvas" style="width:auto; height:250px;"></div>
    
                            <div class="my-4">
                                <a class="btn btn-rounded pull-right hidden-sm-down btn-success m-l-5 text-white" data-toggle="modal" data-target="#change_client">Changer le client</a>
                                <a class="btn btn-rounded pull-right hidden-sm-down btn-success m-l-5 text-white" data-toggle="modal" data-target="#modifier_client">Modifier le client</a>
                                <?= $this->Html->link('Voir la fiche client',['controller' => 'Clients', 'action' => 'fiche', $borneEntity->client_id],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]); ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

            <?php endif ?>

        </div>
                 
    </div>
<?php endif ?>

<div id="popup1" class="overlay">
    <div class="popup">
            <?= $this->Form->create($borneEntity, ['id' => 'borne-antenne']) ?>
            <h2>Antenne</h2>
            <a class="close" href="#retour">&times;</a>
            <div class="content">
                <div class="row" style="margin-right: 5px;">
                    <div class="col-md-6" style="margin-left: 10px;">
                        <?php
                        echo $this->Form->control('antenne_id', [
                            'label' => 'Antenne',
                            'empty' => 'Séléctionner',
                            'options' => $antennes,
                            "class" => "form-control select2",
                            "data-placeholder" => "Choisir",
                            'style' => 'width:100%'
                        ]);
                        ?>
                    </div>

                    <div class="form-actions"style=" margin: 0px 0px 10px 25px;">
                        <?= $this->Form->button(__('Save'), ["class" => "btn btn-rounded btn-success", 'id' => 'save-submit', 'escape' => false]) ?>
                        <?php  echo $this->Html->link('Créer une fiche antenne',['controller' => 'Antennes','action' => 'add?borne='. $borneEntity->id . '&client='.$borneEntity->client_id],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ,'style' => "margin:0 10px 0 10px"]); ?>
                    </div>
                </div>
            </div>
            <?= $this->Form->end() ?>      
    </div>
</div>

<div class="modal fade" id="ticket_borne" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($actuBorne, ['url' => ['controller' => 'ActuBornes', 'action' => 'add', $borneEntity->id], 'type'=>'file']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Créé un ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <?php echo $this->Form->control('titre',['label' => 'Titre * ','type'=>'text', 'required'=>'true']); ?>
                        </div>
                        <div class="col-md-6">
                            <?php echo $this->Form->control('categorie_actus_id',['id'=>'categorie_actus_id','label' => 'Catégorie *', 'options'=> $categorietickets,'empty'=>'Séléctionner', 'required'=>'required']); ?>
                        </div>
                        <div class="col-md-4 hide">
                             <?= $this->Form->control('borne_id',['value' => $borneEntity->id, 'type' => 'text']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                           <?php echo $this->Form->control('contenu',['id' => 'contenu', 'label'=>'Contenu',"class"=>"textarea_editor form-control", "rows"=>"10",'type'=>'textarea']); ?>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                             <label>Photos</label>
                             <div class="dropzone" id="id_dropzone"> </div>
                         </div>
                    </div>
                    <input type="hidden" value="Devis" name="controller">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <button type="submit" class="btn btn-primary">Créer le ticket</button>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-bl" tabindex="-1" role="dialog" aria-labelledby="id-modal-bl" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="id-modal-bl">Aperçu du bon de livraison</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-iframe-bl"><!-- JS IFRAME --></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-primary btn" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="edit_contrat" tabindex="-1" role="dialog" aria-labelledby="id-modal-bl" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($borneEntity, ['url' => ['action' => 'editContrat', $borneEntity->id]]) ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="id-modal-bl">Modification du contrat de borne : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= $this->element('../Bornes/form_edit_contrat') ?>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded  btn-success",'escape'=>false]) ?>
                    <button type="button" class="btn-dark btn-rounded btn" data-dismiss="modal">Annuler</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="edit_garantie" tabindex="-1" role="dialog" aria-labelledby="id-modal-bl" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($borneEntity, ['url' => ['action' => 'editGarantie', $borneEntity->id]]) ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="id-modal-bl">Modification du contrat de borne : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= $this->element('../Bornes/form_edit_garantie') ?>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded  btn-success",'escape'=>false]) ?>
                    <button type="button" class="btn-dark btn-rounded btn" data-dismiss="modal">Annuler</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="change_client" tabindex="-1" role="dialog" aria-labelledby="id-modal-bl" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($borneEntity, ['url' => ['action' => 'editClient', $borneEntity->id]]) ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="id-modal-bl">Changer le client : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required']) ?>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->button(__('Save'),["class"=>"btn btn-rounded  btn-success",'escape'=>false]) ?>
                    <button type="button" class="btn-dark btn-rounded btn" data-dismiss="modal">Annuler</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>


<!-- MODAL MODIFICATION CLIENT -->
<div class="modal fade" id="modifier_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($borneEntity->client, ['url' => ['controller' => 'Clients', 'action' => 'add', $borneEntity->client->id, 'referer']]) ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modification client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <?= $this->element('../Clients/form_edit') ?>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

