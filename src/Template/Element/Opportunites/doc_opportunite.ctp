<table class="table">
    <thead>
    <tr>
        <th scope="col">Nom</th>
        <th scope="col">Statut</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($opportunite->linked_docs as $doc){?>
    <tr>
        <?php if(!empty($doc->devi)){ ?>
            <td><a href="<?= !$doc->devi->is_in_sellsy ? $this->Url->build(['controller'=>'Devis','action' => 'view', $doc->devi->id]) : $this->Url->build($doc->devi->get('SellsyDocUrl'))  ?>"><?= $doc->devi->indent ?></a></td>
            <td><a href="<?= !$doc->devi->is_in_sellsy ? $this->Url->build(['controller'=>'Devis','action' => 'view', $doc->devi->id]) : $this->Url->build($doc->devi->get('SellsyDocUrl'))  ?>"><?= @$devis_status[$doc->devi->status] ?></a></td>
        <?php }elseif(!empty($doc->devis_facture)){ ?>
            <td><a href="<?= !$doc->devis_facture->is_in_sellsy ? $this->Url->build(['controller'=>'DevisFactures','action' => 'view', $doc->devis_facture->id]) : $this->Url->build($doc->devis_facture->get('SellsyDocUrl'))  ?>"><?= $doc->devis_facture->indent ?></a></td>
            <td><a href="<?= !$doc->devis_facture->is_in_sellsy ? $this->Url->build(['controller'=>'DevisFactures','action' => 'view', $doc->devis_facture->id]) : $this->Url->build($doc->devis_facture->get('SellsyDocUrl'))  ?>"><?= @$devis_factures_status[$doc->devis_facture->status]  ?></a></td>
        <?php } ?>
    </tr>
    <?php } ?>
    </tbody>
</table>