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
                            <td>Gamme </td>
                            <td><?= ($borneEntity->model_borne != null && $borneEntity->model_borne->gammes_borne!= null)? $borneEntity->model_borne->gammes_borne->name : ''; ?></td>
                        </tr>
                        <tr>
                            <td>Modele </td>
                            <td><?= $borneEntity->model_borne != null ? $borneEntity->model_borne->nom : ''; ?></td>
                        </tr>
                        <tr>
                            <td>Couleur </td>
                            <td><?= $borneEntity->couleur != null ? h($borneEntity->couleur->couleur) : '' ?></td>
                        </tr>
                        <tr>
                            <td>Numero de série </td>
                            <td><?= $borneEntity->numero_serie ?></td>
                        </tr>
                        <tr>
                            <td>Sortie atelier </td>
                            <td><?= h($borneEntity->sortie_atelier) ?></td>
                        </tr>
                        <tr>
                            <td>Etat général </td>
                            <td><?php if(!empty($borneEntity->etat_borne->etat_general)) echo $borneEntity->etat_borne->etat_general ; ?> </td>
                        </tr>
                        <tr>
                            <td>Gravure Selfizee </td>
                            <td><?= $borneEntity->gravure?'Oui' : 'Non' ; ?> </td>
                        </tr>
                        <?php if ($borneEntity->user_id) : ?>
                            <tr>
                                <td>Opérateur</td>
                                <td><?= $borneEntity->user->full_name_short ; ?> </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php echo $this->Html->link('Modifier la borne',['action' => 'edit', $borneEntity->id],['escape'=>false,"class"=>"btn btn-rounded pull-right hidden-sm-down btn-success" ]); ?>

            </div>
        </div>
    </div>

    <?php if($borneEntity->equipement_bornes) : ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-4">Equipements</h3>

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
                                                    <?= $equipement->numero_series? '#' . $equipement->numero_series->serial_nb . '<br> ': ''; ?> 
                                                <?php else : ?>
                                                    <?= $equipement->precisions ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            
                            <?php if ($borneEntity->type_win_licence != null && false): ?>
                                <tr>
                                    <td>Type de licence windows</td>
                                    <td><?= $borneEntity->type_licence->nom; ?></td>
                                </tr>
                                <tr>
                                    <td>Numero de serie licence windows</td>
                                    <td><?= $borneEntity->licence!=null? $borneEntity->licence->numero_serie : ''; ?></td>
                                </tr>
                            <?php endif ?>
                            
                            <?php if ($borneEntity->type_win_licence != null && false): ?>
                                <tr>
                                    <td>Sérial Socialbooth</td>
                                    <td><?= $borneEntity->licences_sb != null ? $borneEntity->licences_sb->numero_serie : ''; ?></td>
                                </tr>
                            <?php endif ?>

                            <?php if ($borneEntity->numero_series_sb_licence !=null): ?>
                                <tr>
                                    <td>Version installée</td>
                                    <td><?= $borneEntity->version_installee; ?></td>
                                </tr>
                            <?php endif ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="col-md-6">
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
    </div>


    <?php if (!empty($borneEntity->equipements_protections_bornes)): ?>
        <div class="col-md-6">
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
        </div>
    <?php endif ?>
</div>