<table class="table">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('numero', 'Borne') ?></th>
            <th><?= $this->Paginator->sort('numero_serie', 'Num série') ?></th>
            <th><?= $this->Paginator->sort('Antennes.ville_principale', 'Antenne') ?></th>
            <th><?= $this->Paginator->sort('GammesBornes.name', 'Gamme') ?></th>
            <th><?= $this->Paginator->sort('ModelBornes.nom', 'Modèle') ?></th>
            <th><?= $this->Paginator->sort('sortie_atelier', 'Sortie atelier') ?></th>
            <th><?= $this->Paginator->sort('Couleurs.couleur', 'Couleur') ?></th>
            <th><?= $this->Paginator->sort('EtatBornes.etat_general', 'Etat') ?></th>
            <th></a>Actions</a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bornes as $key => $borne): ?>
            <tr>
                <td>
                        <?php 
                            $text = $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->notation.$borne->numero : $borne->numero;
                            echo $this->Html->link(($text), ['action' => 'view', $borne->id])
                        ?>
                </td>
                <td><?= $borne->numero_serie; ?></td>
                <td><?= $borne->has('antenne') ? $borne->antenne->ville_principale : '' ?></td>
                <td><?= @$borne->model_borne->gammes_borne->name ?></td>
                <td><?= $borne->has('model_borne') ? $borne->model_borne->nom : '' ?></td>
                <td><?= $borne->sortie_atelier?$borne->sortie_atelier->format('d/m/y'):"-" ?> </td>
                <td><?= $borne->has('couleur') ? $borne->couleur->couleur : '' ?></td>
                <td><?= $borne->has('etat_borne') ? $borne->etat_borne->etat_general:''; ?></td>
                <td>
                    <div class="dropdown d-inline container-bornes-actions">
                        <button class="btn btn-default dropdown-toggle btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
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