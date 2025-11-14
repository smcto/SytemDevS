<table class="table table-striped">
    <thead>
        <tr>
            <th></th>
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
        <?php if ($avoirs) : ?>
            <?php foreach ($avoirs as $key => $avoir): ?>
                <tr id="id_avoir_<?= $avoir->id ?>">

                    
                        <?php if($checkbox){ ?>
                            <td class="kl_cheboxFact">
                                <?php 
                                    echo $this->Form->control('devis_avoirs.'.$key.'.id',['type'=>'checkbox','label'=>false, 'value' => $avoir->id,'class'=>'myclass','hiddenField' => false]); 
                                ?>
                            </td>
                        <?php }else{ ?>
                            <td class="add-avoir">
                                <button type="button" class="btn btn-rounded btn-sm btn-dark"> <span aria-hidden="true">Ajouter</span> </button>
                                <input type='hidden' value='<?= $avoir->get('AvoirAsJson') ?>' class="value-avoir">
                            </td>
                        <?php } ?>

                    <td><a data-toggle="tooltip" data-html="true" data-placement="top" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'view', $avoir->id]) ?>"><?= $avoir->indent ?></a></td>
                    <td><i class="fa fa-circle <?= $avoir->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_avoirs_status[$avoir->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_avoirs_status[$avoir->status] ?> </td>
                    <td><a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $avoir->client->id]) ?>"><?= $avoir->client->nom?></a></td>
                    <td><?= $avoir->created->format('d/m/y') ?></td>
                    <td><?= $genres_short[$avoir->client->client_type] ?? '' ?></td>
                    <td> 
                        <?= $avoir->commercial->get('FullNameShort') ?> <br>
                    </td>
                    <td class="text-right"><?= $avoir->get('TotalHtWithCurrency') ?></td>
                    <td class="text-right"><?= $avoir->get('TotalTtcWithCurrency') ?></td>
                    <td class="text-right"><?= $avoir->get('ResteEcheanceImpayee') ?> €</td>

                </tr>
            <?php endforeach ?>
        <?php else : ?>
                    <tr>
                        <td colspan="9" class="text-center">Aucun résultat ne correspond à votre recherche</td>
                    </tr>
        <?php endif; ?>
    </tbody>
</table>
