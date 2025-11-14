<?= $this->Html->css(['pdf/bornes.css?' . time(), ], ['fullBase' => true]) ?>

<?php $this->start('header') ?>
<div class="header-text">LISTE DES BORNES</div>
<?php $this->end() ?>
    
<main>
<div class="row" id="body_borne">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="div_table_bornes">

                        <table class="table pdf-table-0">
                            <thead>
                                <tr>
                                    <th>Borne</th>
                                    <th>Num série</th>
                                    <th>Parc</th>
                                    <th>Client</th>
                                    <th>Réseau</th>
                                    <th>Ville</th>
                                    <th>Modèle</th>
                                    <th>Sortie atelier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bornes as $key => $borne): ?>
                                    <tr>
                                        <td>
                                            <?php
                                                $text = $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->notation.$borne->numero : $borne->numero;
                                                echo $text;
                                            ?>
                                        </td>
                                        <td><?= $borne->numero_serie; ?></td>
                                        <td><?= $borne->parc->nom == 'Location'?'Parc locatif':$borne->parc->nom;?></td>
                                        <td><?= $borne->has('client') ? ($borne->client->enseigne ? $borne->client->nom . ' - ' . $borne->client->enseigne : $borne->client->nom) :($borne->has('antenne') ? 'Selfizee':'-');?></td>
                                        <td><?= $borne->has('client') ? ($borne->client->groupe_client?$borne->client->groupe_client->nom:'-') : '-' ?></td>
                                        <td><?= $borne->has('client') ? $borne->client->ville : ($borne->has('antenne') ? $borne->antenne->ville_principale:'') ?></td>
                                        <td><?= $borne->has('model_borne') ? $borne->model_borne->nom : '' ?></td>
                                        <td><?= $borne->sortie_atelier?$borne->sortie_atelier->format('d/m/y'):"-" ?> </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
</main>


