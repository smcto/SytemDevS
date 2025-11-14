<table class="table">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('Clients.nom', 'Client') ?></th>
            <th><?= $this->Paginator->sort('GroupeClients.nom', 'Groupe Client') ?></th>
            <th><?= $this->Paginator->sort('GammesBornes.name', 'Type') ?></th>
            <th><?= $this->Paginator->sort('numero', 'Numéro') ?></th>
            <th>Début</th>
            <th>Fin</th>
            <th>Date limite résiliation</th>
            <th>Commercial</th>
            <th></a>Actions</a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bornes as $key => $borne): ?>
            <?php if (count($borne->ventes)): ?>
                <?php $vente = $borne->ventes[0] ?>
            <?php endif ?>
            <tr>
                <td><?= $borne->has('client') ?$this->Html->link(($borne->client->enseigne ? $borne->client->nom . ' - ' . $borne->client->enseigne : $borne->client->nom), ['controller' => 'Clients', 'action' => 'fiche', $borne->client->id]):'' ?></td>
                <td><?= $borne->has('client') ? ($borne->client->groupe_client?$borne->client->groupe_client->nom:'-') : '-' ?></td>
                <td><?= @$borne->model_borne->gammes_borne->name ?></td>
                <td>
                    <?php
                        $text = $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->notation.$borne->numero : $borne->numero;
                        echo $this->Html->link(($text), ['action' => 'view', $borne->id])
                    ?>
                </td>
                <td>
                    <?php if (!$borne->is_contrat_modified && isset($vente)): ?>
                        <?= $vente->contrat_debut !=null ? $vente->contrat_debut->format("d/m/Y") : '' ?>
                    <?php else: ?>
                        <?= $borne->contrat_debut ?>
                    <?php endif ?>
                </td>
                <td>
                    <?php if (!$borne->is_contrat_modified && isset($vente)): ?>
                        <?= $vente->contrat_fin !=null ? $vente->contrat_fin->format("d/m/Y") : '' ?>
                    <?php else: ?>
                        <?= $borne->contrat_fin ?>
                    <?php endif ?>
                </td>
                <td>
                    <?php if (!$borne->is_contrat_modified && isset($vente)): ?>
                        <?= $vente->contrat_fin !=null ? $vente->contrat_fin->subMonth(6)->format('d/m/Y') : '' ?>
                    <?php else: ?>
                        <?= $borne->contrat_fin != null ? $borne->contrat_fin->subMonth(6)->format('d/m/Y') : '' ?>
                    <?php endif ?>
                </td>
                <td>
                    <?php if ($borne->user) : ?>
                        <img alt="commercial avatar" src="<?= $borne->user->url_photo ?>" class="avatar" data-title="<?= $borne->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                    <?php endif; ?>
                </td>
                <td>
                    <div class="dropdown d-inline container-bornes-actions">
                        <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'addActuborne', $borne->id, $borne->parc_id]) ?>">Ticket</a>
                            <a class="dropdown-item" href="<?= $this->Url->build(['action' => 'edit', $borne->id]) ?>">Modifier fiche</a>
                            <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $borne->id], ['class' => 'dropdown-item', 'confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?= $this->element('tfoot_pagination') ?>