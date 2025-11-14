<table class="table table-striped" id="div_table_factures">
    <thead>
        <tr>
            <th></th>
            <?php if($checkbox){ ?>
            <th class="montant-lie hide">Montant lié</th>
            <?php } ?>
            <th>N°</th>
            <th>Etat</th>
            <th>Client</th>
            <th>Date</th>
            <th>Type</th> <!-- Corporation (pro) ou person (particulier) -->
            <th>Contact</th>
            <th class="text-right">HT</th>
            <th class="text-right">TTC</th>
            <th class="text-right">Restant dû</th>
            <th width="1%"></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($factures) : ?>
            <?php foreach ($factures as $key => $facture): ?>
                <tr id="id_facture_<?= $facture->id ?>">

                    
                        <?php if($checkbox){ ?>
                            <td class="kl_cheboxFact">
                                <?= $this->Form->control('devis_factures.'.$key.'.id',['type'=>'checkbox','label'=>false, 'value' => $facture->id, 'class'=>'myclass checkbox-facture','hiddenField' => false]); ?>
                                <input type='hidden' value='<?= $facture->get('FactureAsJson') ?>' class="value-facture">
                            </td>
                            <td class="montant-lie hide">
                                <?= $this->Form->control('devis_factures.'.$key.'._joinData.montant_lie',['type'=>'number','label'=>false, 'class' => 'montant-lie-value', 'step' => '0.01']); ?>
                            </td>
                        <?php }else{ ?>
                            <td class="add-facture">
                                <button type="button" class="btn btn-rounded btn-sm btn-dark"> <span aria-hidden="true">Ajouter</span> </button>
                                <input type='hidden' value='<?= $facture->get('FactureAsJson') ?>' class="value-facture">
                            </td>
                        <?php } ?>

                    <td><a data-toggle="tooltip" data-html="true" data-placement="top" title='<?= $facture->get('ObjetAsTitle') ?>' href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $facture->id]) ?>"><?= $facture->indent ?></a></td>
                    <td><i class="fa fa-circle <?= $facture->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_factures_status[$facture->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_factures_status[$facture->status] ?> </td>
                    <td><a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $facture->client->id]) ?>"><?= $facture->client->nom?></a></td>
                    <td><?= $facture->created->format('d/m/y') ?></td>
                    <td><?= @$genres_short[$facture->client->client_type] ?></td>
                    <td> 
                        <?= $facture->commercial->get('FullNameShort') ?> <br>
                    </td>
                    <td class="text-right"><?= $facture->get('TotalHtWithCurrency') ?></td>
                    <td class="text-right"><?= $facture->get('TotalTtcWithCurrency') ?></td>
                    <td class="text-right"><?= $facture->get('ResteEcheanceImpayee') ?> €</td>

                </tr>
            <?php endforeach ?>
        <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">Aucun résultat ne correspond à votre recherche</td>
                    </tr>
        <?php endif; ?>
    </tbody>
</table>
