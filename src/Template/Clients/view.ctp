<?php

$this->assign('title', 'Fiche client ' . $client->full_name) ;

$titrePage = "Détail client" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
'Tableau de bord',
['controller' => 'Dashboards', 'action' => 'index']
);
$this->Breadcrumbs->add($titrePage);
echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h2 class="m-b-0 text-white">INFORMATION DU CLIENT</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <?php if (!empty($client->nom)): ?>
                    <label for="exampleInputuname2"><?= h($client->nom) ?></label>
                    <?php endif ?>
                    <?php if (!empty($client->prenom)): ?>
                    <div class="input-group">
                        <label for="exampleInputuname"><?= h($client->prenom) ?></label>
                    </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <?php if (!empty($client->adresse)): ?>
                    <label for="exampleInputuname2"><?= h($client->adresse) ?></label>
                    <?php endif ?>
                    <?php if (!empty($client->ville)): ?>
                    <div class="input-group">
                        <label for="exampleInputuname"><?= h($client->ville) ?></label>
                    </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <?php if (!empty($client->email)): ?>
                    <label for="exampleInputuname2"><?= h($client->email) ?></label>
                    <?php endif ?>
                    <?php if (!empty($client->siren)): ?>
                    <div class="input-group">
                        <label for="exampleInputuname"><?= h($client->siren) ?></label>
                    </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <?php if (!empty($client->siret)): ?>
                    <label for="exampleInputuname2"><?= h($client->siret) ?></label>
                    <?php endif ?>
                    <?php if (!empty($client->mobile)): ?>
                    <div class="input-group">
                        <label for="exampleInputuname"><?= h($client->mobile) ?></label>
                    </div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <?php if (!empty($client->cp)): ?>
                    <label for="exampleInputuname2"><?= $this->Number->format($client->cp) ?></label>
                    <?php endif ?>
                    <?php if (!empty($client->telephone)): ?>
                    <div class="input-group">
                        <label for="exampleInputuname"><?= $this->Number->format($client->telephone) ?></label>
                    </div>
                    <?php endif ?>
                </div>
                <?php if (!empty($client->id_in_sellsy)): ?>
                <div class="form-group">
                    <label for="exampleInputuname"><?= $this->Number->format($client->id_in_sellsy) ?></label>
                </div>
                <?php endif ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">ADDRESS 2</h4>
                            </div>
                            <div class="card-body">
                                <?= $this->Text->autoParagraph(h($client->adresse_2)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h2 class="m-b-0 text-white">CONTACT(S)</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="related">
                    <?php if (!empty($client->client_contacts)): ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        <?php foreach ($client->client_contacts as $clientContacts): ?>
                        <tr>
                            <td><?= h($clientContacts->nom) ?></td>
                            <td>&nbsp;</td>
                            <td><?= h($clientContacts->prenom) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h2 class="m-b-0 text-white">BORNE(S)</h2>
                </div>
                <div class="card-body">
                    <div class="related">
                        <?php if (!empty($client->bornes)): ?>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th scope="col"><?= __('Numero') ?></th>
                            </tr>
                            <?php foreach ($client->bornes as $bornes): ?>
                            <tr>
                                <td><?= h($bornes->numero) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Liste des documents</h4>
            </div>
            <div class="card-body">
                <div class="related">
                    <?php if (!empty($client->documents)): ?>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <th scope="col"><?= __('Types') ?></th>
                            <th scope="col"><?= __('Client Id') ?></th>
                            <th scope="col"><?= __('Statut') ?></th>
                            <th scope="col"><?= __('Nom') ?></th>
                            <th scope="col"><?= __('Montant Ht') ?></th>
                            <th scope="col"><?= __('Montant Ttc') ?></th>
                        </tr>
                        <?php foreach ($client->documents as $documents): ?>
                        <tr>
                            <td><?= h($documents->types) ?></td>
                            <td><?= h($documents->client_id) ?></td>
                            <td><?= h($documents->statut) ?></td>
                            <td><?= h($documents->nom) ?></td>
                            <td><?= h($documents->montant_ht) ?></td>
                            <td><?= h($documents->montant_ttc) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>