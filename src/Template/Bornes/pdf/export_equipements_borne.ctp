<?php use Cake\Routing\Router; ?>

<?= $this->Html->css(['pdf/bootstrap.min.css', 'pdf/basscss.min.css', 'pdf/bornes.css?' . time(), ], ['fullBase' => true]) ?>

<?php $this->start('footer') ?>
    <div class="footer-text">
        Document confidentiel appartenant à la société Konitys <br>
        Toute divulgation de ce document sans autorisation officielle est formellement interdite 
    </div>
<?php $this->end() ?>
    
<main>
<div class="row" id="body_borne">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table-header" >
                    <tbody>
                        <tr>
                            <td width="12cm">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="row-fluid">
                                            <div class="bloc-addr">
                                                <span class="text-borne">Borne <?= @$borneEntity->model_borne->gammes_borne->name; ?> #<?= $borneEntity->numero ?> </span> <br>
                                                Sortie atelier : <?= h($borneEntity->sortie_atelier) ?> <br>
                                                <?php if (@$borneEntity->operateur->full_name) : ?>
                                                Opérateur : <?= @$borneEntity->operateur->full_name ? : '- -' ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="infos row-fluid">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="vertical-align: top;">
                                <div>
                                    Parc : <?= @$borneEntity->parc->nom2; ?><br>
                                    <?php if ($borneEntity->client) : ?>
                                        Client : <?= $borneEntity->client->full_name; ?> <br>
                                        
                                        <?php if ($borneEntity->contrat_debut) : ?>
                                        
                                            Début contrat : <?= $borneEntity->contrat_debut ?><br>
                                        <?php elseif (@$borneEntity->ventes[0]->contrat_debut) : ?>
                                            
                                            Début contrat : <?= date_format(@$borneEntity->ventes[0]->contrat_debut, "d/m/Y") ?><br>
                                        <?php endif; ?>
                                        
                                        <?php if (@$borneEntity->user->full_name) : ?>
                                            
                                            Commercial : <?= @$borneEntity->user->full_name; ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        Ville actuelle : <?= @$borneEntity->antenne->ville_principale; ?>
                                    <?php endif; ?>
                                        <br><br>
                                    <span style="color:#95999c">
                                    En date du <?= $now ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <br>
                <div class="table-responsive" id="div_table_bornes">
                    <h4>Composants : </h4>
                    <table class="table pdf-table-0">
                        <thead>
                            <tr>
                                <th>Type équipement</th>
                                <th>Équipement</th>
                                <th class="text-right">Tarif achat HT </th>
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
                                    <td class="text-right"><?= $this->Utilities->formatCurrency(@$equipement->numero_series->lot_produit->tarif_achat_ht) ?></td>
                                </tr>
                                <?php endif ?>
                            <?php endforeach ?>

                            <tr>
                                <td><b>Sous-total</b></td>
                                <td></td>
                                <td class="text-right"><b><?= $this->Utilities->formatCurrency($totalComposant) ?></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="table-responsive" id="div_table_bornes">
                    <h4>Equipement de protection : </h4>
                    <table class="table pdf-table-0">
                        <thead>
                            <tr>
                                <th>Type équipement</th>
                                <th>Équipement</th>
                                <th class="text-right">Tarif achat HT </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php if (count($borneEntity->equipements_protections_bornes)) : ?>

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
                                        <td class="text-right"><?= $this->Utilities->formatCurrency(@$equipement->numero_series->lot_produit->tarif_achat_ht) ?></td>
                                    </tr>
                                    <?php endif ?>
                                <?php endforeach ?>

                                <tr>
                                    <td><b>Sous-total </b></td>
                                    <td></td>
                                    <td class="text-right"><b><?= $this->Utilities->formatCurrency($totalProtection) ?></b></td>
                                </tr>
                            <?php else : ?>

                                <tr>
                                    <td colspan="3" class="text-center">Aucun équipement de protection</td>
                                </tr>
                                
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <br>
                <table class="table-note-total">
                    <tbody>
                        <tr style="vertical-align: top">
                            <td width="12cm"></td>
                            <td>
                                <div class="note text-right">
                                    <b>Total équipement </b> (hors main d'oeuvre) : <br><b><?= $this->Utilities->formatCurrency($totalProtection + $totalComposant) ?> HT </b>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</main>


