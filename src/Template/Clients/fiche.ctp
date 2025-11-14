<?= $this->Html->css('table-uniforme', ['block' => true]); ?>
<?= $this->Html->css('clients/commentaire.css?'.time(), ['block' => 'css']); ?>
<?= $this->Html->css('fontawesome5/css/all.min.css', ['block' => 'css']); ?>
<?= $this->Html->css('bootstrap-select/bootstrap-select.min.css', ['block' => true]) ?>
<?= $this->Html->css('devis/index.css?' . time(), ['block' => 'script']); ?>
<?= $this->Html->css('gif/gif.css', ['block' => true]) ?>


<?= $this->Html->script('Clients/add.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('bootstrap-select/bootstrap-select.min.js', ['block' => true]); ?>
<?= $this->Html->script('tinymce/tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('tinymce/jquery.tinymce.min.js', ['block' => true,"referrerpolicy"=>"origin"]); ?>
<?= $this->Html->script('Clients/fiche.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('Clients/autocomplet-addresse.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('documents/duplicate.js?time='.time(), ['block' => true]); ?>
<?= $this->Html->script('gif/gif.js', ['block' => true]); ?>

<?php 

    $this->assign('title', 'Fiche ' . ($type_commercials[$clientEntity->type_commercial] ?? '') . ' ' . $clientEntity->full_name);
    $titrePage = "Fiche client #$clientEntity->id" ;

    $this->start('breadcumb');
    $this->Breadcrumbs->add(
        'Tableau de bord',
        ['controller' => 'Dashboards', 'action' => 'index']
    );
    
    $this->Breadcrumbs->add(
        'Clients',
        ['controller' => 'Clients', 'action' => 'liste']
    );

    $this->Breadcrumbs->add($titrePage);

    echo $this->element('breadcrumb',['titrePage' => $titrePage]);
    $this->end();

    $modalFormCommentaireTemplate = [
        'inputContainer'      => '<div class="form-group row">{{content}}</div>',
        'label'               => '<label{{attrs}} class="col-md-2 col-form-label">{{text}}</label>',
        'input'               => '<div class="col-md-10"> <input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/></div>',
        'textarea'            => '<div class="col-md-10"><textarea name="{{name}}"{{attrs}} class="form-control" >{{value}}</textarea></div>',
        'error'               => '<div class="form-control-feedback">{{content}}</div>',
        'inputContainerError' => '<div class="form-group {{type}}{{required}} has-danger">{{content}}{{error}}</div>',
        'checkbox'            => '<input type="checkbox" name="{{name}}" value="{{value}}" class="custom-control-input" {{attrs}}>',
        'nestingLabel'        => '{{hidden}}<label{{attrs}} class="custom-control custom-checkbox">{{input}}<span class="custom-control-label">{{text}}</span></label>',        
    ];
?>  

<?php $this->start('actionTitle'); ?>
    <?= $this->Form->postLink('Supprimer', ['action' => 'delete-client', $clientEntity->id], ['confirm' => __('Êtes-vous sûr de vouloir supprimer?'), 'escape' => false, "class"=>"btn btn-rounded pull-right hidden-sm-down btn-secondary mr-2" ]) ?>
<?php $this->end(); ?>

<div class="card mb-4">
    <div class="card-body hide-table-empty">
        <div class="row">
            <div class="col-md-6">
                <div class="row-fluid mb-4">
                    <h3 class="mb-4">Information</h3>

                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="50%" class="p-0"></th>
                                <th width="50%" class="p-0"></th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Genre</td>
                                <td><?= $genres[$clientEntity->client_type] ?? '' ?></td>
                            </tr>
                            <?php if($clientEntity->client_type == 'corporation') : ?>
                                <tr>
                                    <td>Raison sociale</td>
                                    <td><?= $clientEntity->nom ?></td>
                                </tr>
                                <tr>
                                    <td>Enseigne</td>
                                    <td><?= $clientEntity->enseigne ?></td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td>Nom</td>
                                    <td><?= $clientEntity->nom ?></td>
                                </tr>
                                <tr>
                                    <td>Prénom</td>
                                    <td><?= $clientEntity->prenom ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td>Adresse</td>
                                <td>
                                    <span class="br"><?= $clientEntity->adresse ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Adresse complémentaire</td>
                                <td>
                                    <?= $clientEntity->adresse_2 ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Code postal</td>
                                <td><?= $clientEntity->cp ?></td>
                            </tr>
                            <tr>
                                <td>Ville</td>
                                <td><?= $clientEntity->ville ?></td>
                            </tr>
                            <tr>
                                <td>Téléphone entreprise</td>
                                <td><?= $clientEntity->telephone ?></td>
                            </tr>
                            <tr>
                                <td>Email général</td>
                                <td><?= $clientEntity->email ?></td>
                            </tr>
                            <tr>
                                <td>Tva Intracommunautaire</td>
                                <td><?= $clientEntity->tva_intra_community?$clientEntity->tva_intra_community . ' %':''?></td>
                            </tr>
                            <tr>
                                <td>Siren</td>
                                <td><?= $clientEntity->siren ?></td>
                            </tr>
                            <tr>
                                <td>Siret</td>
                                <td><?= $clientEntity->siret ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php if ($clientEntity->id_in_wp): ?>
                        Compte crée automatiquement le : <i><?= $clientEntity->created->format('d/m/Y') ?></i>
                    <?php elseif($clientEntity->user_id): ?>
                        Compte crée par <i><?= $clientEntity->user->get('FullName') ?></i> le : <i><?= $clientEntity->created->format('d/m/Y') ?></i>
                    <?php elseif($clientEntity->get('CommercialDuPremierDevis')): ?>
                        Compte crée par <i><?= $clientEntity->get('CommercialDuPremierDevis') ?></i> le : <i><?= $clientEntity->created->format('d/m/Y') ?></i>
                    <?php else: ?>
                        Compte crée le : <i><?= $clientEntity->created->format('d/m/Y') ?></i>
                    <?php endif ?>
                </div>
            </div>

            <div class="col-md-6">
                <h3 class="mb-4">Qualification</h3>
                
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="50%" class="p-0"></th>
                            <th width="50%" class="p-0"></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Type commercial</td>
                            <td><?= $type_commercials[$clientEntity->type_commercial] ?? '' ?></td>
                        </tr>
                        <tr>
                            <td>Brandeet</td>
                            <td><?= $clientEntity->is_brandeet ? 'Oui' : '-'?></td>
                        </tr>
                        <tr>
                            <td>Digitea</td>
                            <td><?= $clientEntity->is_digitea ? 'Oui' : '-'?></td>
                        </tr>
                        <tr>
                            <td>Selfizee part</td>
                            <td><?= $clientEntity->is_selfizee_part ? 'Oui' : '-'?></td>
                        </tr>
                        <tr>
                            <td>Location event</td>
                            <td><?= $clientEntity->is_location_event ? 'Oui' : '-'?></td>
                        </tr>
                        <tr>
                            <td>Location financière</td>
                            <td><?= $clientEntity->is_location_financiere ? 'Oui' : '-' ?></td>
                        </tr>
                        <tr>
                            <td>Location longue durée</td>
                            <td><?= $clientEntity->is_location_lng_duree ? 'Oui' : '-' ?></td>
                        </tr>
                        <tr>
                            <td>Vente</td>
                            <td><?= $clientEntity->is_vente ? 'Oui' : '-' ?></td>
                        </tr>
                        <tr>
                            <td>Occasion</td>
                            <td><?= $clientEntity->is_borne_occasion ? 'Oui' : '-' ?></td>
                        </tr>
                        <tr>
                            <td>Groupes de clients</td>
                            <td><?= @$clientEntity->groupe_client->nom ?></td>
                        </tr>
                        <tr>
                            <td>Secteur d'activité</td>
                            <td><?= @$clientEntity->get('listeSecteursActivites') ?></td>
                        </tr>
                        <tr>
                            <td>Comment a-t-il connu Selfizee ?</td>
                            <td><?= $connaissance_selfizees[$clientEntity->connaissance_selfizee] ?? '' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-actions">
            <a class="btn btn btn-rounded pull-right hidden-sm-down btn-success" href="javascript:void(0);" data-toggle="modal" data-target="#modifier_client">Modifier client</a>
            <!--?= $this->Html->link('Modifier client',['controller' => 'Clients', 'action' => 'add', $clientEntity->id],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ]); ?-->
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Bornes</h3>

            <?php if (!empty($clientEntity->bornes)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Borne</th>
                            <th>Parc</th>
                            <th>Client</th>
                            <th>Réseau</th>
                            <th>Ville</th>
                            <th>Gamme</th>
                            <th>Modèle</th>
                            <th>Sortie atelier</th>
                            <th>Opérateur</th>
                            <th></a>Actions</a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientEntity->bornes as $key => $borne): ?>
                            <tr>
                                <td>
                                    <?php 
                                        $text = $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->notation.$borne->numero : $borne->numero;
                                        echo $this->Html->link(($text), ['controller' => 'Bornes', 'action' => 'view', $borne->id])
                                    ?>
                                </td>
                                <td><?= $borne->parc->nom == 'Location'?'Parc locatif':$borne->parc->nom;?></td>
                                <td><?= $borne->has('client') ?$borne->client->nom:($borne->has('antenne') ? 'Selfizee':'-');?></td>
                                <td><?= $borne->has('client') ? ($borne->client->groupe_client?$borne->client->groupe_client->nom:'-') : '-' ?></td>
                                <td><?= $borne->has('client') ? $borne->client->ville : ($borne->has('antenne') ? $borne->antenne->ville_principale:'') ?></td>
                                <td><?= $borne->has('model_borne') ? @$borne->model_borne->gammes_borne->name : '' ?></td>
                                <td><?= $borne->has('model_borne') ? $borne->model_borne->nom : '' ?></td>
                                <td><?= $borne->sortie_atelier?$borne->sortie_atelier->format('d/m/y'):"-" ?> </td>
                                <td><?= $borne->has('user') ? $borne->user->full_name_short : '' ?></td>
                                
                                <td>
                                    <div class="dropdown d-inline container-bornes-actions">
                                        <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Bornes', 'action' => 'addActuborne', $borne->id, $borne->parc_id]) ?>">Ticket</a>
                                            <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Bornes', 'action' => 'edit', $borne->id]) ?>">Modifier fiche</a>
                                            <?= $this->Form->postLink('Supprimer', ['controller' => 'Bornes', 'action' => 'delete', $borne->id], ['class' => 'dropdown-item', 'confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php else: ?>
                Aucune borne associée
            <?php endif ?>
        </div>

    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Contact(s) associé(s)</h3>

            <?php if (!empty($clientEntity->client_contacts)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prénom (*)</th>
                            <th>Nom (*)</th>
                            <th>Fonction </th>
                            <th>Email (*)</th>
                            <th>Téléphone Portable</th>
                            <th>Téléphone Fixe</th>
                            <th>Type</th>
                        </tr>

                        <?php foreach ($clientEntity->client_contacts as $key => $clientContact): ?>
                            <tr>
                                <td><?= $clientContact->prenom ?></td>
                                <td><?= $clientContact->nom ?></td>
                                <td><?= $clientContact->position ?></td>
                                <td><?= $clientContact->email ?></td>
                                <td><?= $clientContact->tel ?></td>
                                <td><?= $clientContact->telephone_2 ?></td>
                                <td><?= $clientContact->contact_type->nom ?? '' ?></td>
                            </tr>
                        <?php endforeach ?>
                    </thead>
                </table>
            <?php else: ?>
                Aucun contact associé
            <?php endif ?>
        </div>
        <a class="btn btn btn-rounded pull-right hidden-sm-down btn-success" href="javascript:void(0);" data-toggle="modal" data-target="#modifier_contact">Gérer les contacts</a>
        <!--?= $this->Html->link('Gérer les contacts',['controller' => 'Clients', 'action' => 'add', $clientEntity->id, '#' => 'contacts'],['escape'=>false,"class"=>"btn btn btn-rounded pull-right hidden-sm-down btn-success" ]); ?-->

    </div>
</div>


<?php if ($has_devis): ?>
<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Total devis</h3>
                <div class="row mt-40">
                    <div class="col-md-6">
                        <table class="table table-uniforme">
                            <thead class="">
                                <tr>
                                    <th width="25%"></th>
                                    <th width="25%"  class="text-right"> Nombre devis</th>
                                    <th width="25%"  class="text-right"> Total HT</th>
                                    <th width="25%"  class="text-right"> Total TTC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right"><?= $countDevis['total'] ?></td>
                                    <td class="text-right"><?= $this->Number->format($totalDevis) ?> €</td>
                                    <td class="text-right"><?= $this->Number->format($totalDevis * 1.2) ?> €</td>
                                </tr>
                                <tr>
                                    <td>Total en attente</td>
                                    <td class="text-right"><?= $countDevis['attente'] ?></td>
                                    <td class="text-right"><?= $this->Number->format($totalAttente) ?> €</td>
                                    <td class="text-right"><?= $this->Number->format($totalAttente * 1.2) ?> €</td>
                                </tr>
                                <tr>
                                    <td>Total accepté</td>
                                    <td class="text-right"><?= $countDevis['done'] ?></td>
                                    <td class="text-right"><?= $this->Number->format($totalDone) ?> €</td>
                                    <td class="text-right"><?= $this->Number->format($totalDone * 1.2) ?> €</td>
                                </tr>
                                <tr>
                                    <td>Total refusé</td>
                                    <td class="text-right"><?= $countDevis['refused'] ?></td>
                                    <td class="text-right"><?= $this->Number->format($totalRefused) ?> €</td>
                                    <td class="text-right"><?= $this->Number->format($totalRefused * 1.2) ?> €</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<?php endif ?>

<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Devis</h3>

            <?php if ($has_devis): ?>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                                <th>N°</th>
                                <th>Client/Prospect</th>
                                <th>Antenne(s)</th>
                                <th>Type</th> <!-- Corporation (pro) ou person (particulier) -->
                                <th>Borne</th>
                                <th>Event</th>
                                <th>Document</th>
                                <th>Contact</th>
                                <th>Date devis</th>
                                <th class="text-right">HT</th>
                                <th class="text-right">TTC</th>
                                <th>Expire</th>
                                <th>Etat</th>
                                <th width="1%"></th>
                        </tr>
                        <?php foreach ($clientEntity->devis as $key => $devis): ?>
                        <?php if( ! $devis->is_model) : ?>
                            <tr>
                                <td>
                                        <a data-toggle="tooltip" data-html="true" data-placement="top" title="<?= $devis->get('ObjetAsTitle') ?>" href="<?= $this->Url->build(['controller'=>'Devis', 'action' => 'view', $devis->id]) ?>"><?= $devis->indent ?></a>
                                        <?php if ($this->request->getQuery('test')): ?>
                                            <a  href="<?= $devis->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <?php if ($devis->client): ?>
                                            <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $devis->client->id]) ?>"><?= $devis->client->nom ?> <?= $devis->client->enseigne ?></a>
                                        <?php else: ?>
                                            <?= $devis->client_nom ?>
                                        <?php endif ?>
                                    </td>
                                    <td><?= $devis->get('ListeAntennes'); ?></td>
                                    <td><?= @$genres[$devis->client->client_type] ?? '' ?></td>
                                    <td><?= @$type_bornes[$devis->model_type] ?? '' ?></td>
                                    <td>
                                            <?= $devis->date_evenement?$devis->date_evenement->format('d/m/y'):"--" ?>
                                    </td>
                                    <td><?= @$type_docs[$devis->type_doc_id] ?? '--' ?></td>
                                    <td> 
                                        <?php if ($devis->commercial) : ?>
                                            <img alt="Image" src="<?= $devis->commercial->url_photo ?>" class="avatar" data-title="<?= $devis->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                        <?php else : ?>
                                            --
                                        <?php endif; ?>
                                    </td>
                                    <td><?= (empty($devis->id_in_wp) && !empty($devis->date_crea) ) ? $devis->date_crea->format('d/m/y') : $devis->date_crea->format('d/m/y') ?></td>
                                    <td class="text-right"><?= $devis->get('TotalHtWithCurrency') ?></td>
                                    <td class="text-right"><?= $devis->get('TotalTtcWithCurrency') ?></td>
                                    <!-- <td><?php /*count($devis->devis_reglements)*/ ?></td> -->
                                    <td>
                                        <?php if (!$devis->is_in_sellsy): ?>
                                            <?= $devis->date_sign_before ? $devis->date_sign_before->format('d/m/y') : '' ?>
                                        <?php else: ?>
                                            <?= $devis->date_validite ? $devis->date_validite->format('d/m/y') : '' ?>
                                        <?php endif ?>
                                    </td>
                                    <td><i class="fa fa-circle <?= $devis->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$devis->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_status[$devis->status] ?></td>
                                <td>
                                    <?php if (!$devis->is_in_sellsy): ?>
                                        <div class="dropdown d-inline container-ventes-actions">
                                            <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $devis->id]) ?>" >Voir le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'historique', $devis->id]) ?>" >Voir l'historique</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'view', $devis->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'add', $devis->id, 1]) ?>">Modifier le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'pdfversion', $devis->id]) ?>" target="_blank">Imprimer le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'pdfversion', $devis->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'pdfversion', $devis->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build($devis->get('EncryptedUrl')) ?><?= $this->request->getQuery('test') ? '&test=1' : '' ?>">Voir la version web</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_status" data-href="<?= $this->Url->build(['controller'=>'Devis', 'action' => 'editEtat', $devis->id, $clientEntity->id]) ?>" data-value='<?= $devis->status ?>' data-indent='<?= $devis->indent ?>' data-devis="<?= $devis->id ?>">Modifier l'état</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['controller'=>'Devis','action' => 'EditTypeDoc', $devis->id]) ?>" data-value='<?= $devis->type_doc_id ?>' data-indent='<?= $devis->indent ?>'>Modifier le type doc</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $devis->indent ?>)" data-type="devi_id" data-href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'editClient']) ?>" data-doc="<?= $devis->id ?>">Affecter à un autre client</a>                                                    
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#duplicate_doc" data-title="Dupliquer le devis" data-submit="Dupliquer" data-href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'duplicatDevis', $devis->id]) ?>">Dupliquer le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'toFacture', $devis->id]) ?>">Facturer ce devis</a>
                                                <?= $this->Form->postLink('Supprimer', ['controller'=>'Devis','action'=>'delete',$devis->id,'Clients','fiche',$clientEntity->id],['confirm'=>'Etes vous sûr de vouloire supprimer ?',"class"=>"dropdown-item"]); ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="dropdown d-inline container-ventes-actions">
                                            <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build($devis->get('SellsyDocUrl')) ?>" >Voir le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'pdfversion', $devis->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'pdfversion', $devis->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build($devis->get('EncryptedUrl')) ?><?= $this->request->getQuery('test') ? '&test=1' : '' ?>">Voir la version web</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_status" data-href="<?= $this->Url->build(['controller'=>'Devis', 'action' => 'editEtat', $devis->id]) ?>" data-value='<?= $devis->status ?>' data-indent='<?= $devis->indent ?>'>Modifier l'état</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['controller'=>'Devis','action' => 'EditTypeDoc', $devis->id]) ?>" data-value='<?= $devis->type_doc_id ?>' data-indent='<?= $devis->indent ?>'>Modifier le type doc</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $devis->indent ?>)" data-type="devi_id" data-href="<?= $this->Url->build(['controller' => 'Devis', 'action' => 'editClient']) ?>" data-doc="<?= $devis->id ?>">Affecter à un autre client</a>
                                                <?= $this->Form->postLink('Supprimer', ['controller'=>'Devis','action'=>'delete',$devis->id,'Clients','fiche',$clientEntity->id],['confirm'=>'Etes vous sûr de vouloire supprimer ?',"class"=>"dropdown-item"]); ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endif ?>
                        <?php endforeach ?>
                    </thead>
                </table>
            <?php else: ?>
                Aucun devis pour ce client
            <?php endif ?>

        </div>
        
        <div class="form-actions">
            <a class="btn btn btn-rounded pull-right hidden-sm-down btn-success create-devis" data-toggle="modal" data-controller="Devis" data-title="Création devis" data-submit="Créer le devis" href="#creation_doc">Créer un devis pour ce client</a>
        </div>
    </div>
</div>


<?php if ($has_factures): ?>
<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Total factures</h3>
                <div class="row mt-40">
                    <div class="col-md-6">
                        <table class="table table-uniforme">
                            <thead class="">
                                <tr>
                                    <th width="35%"></th>
                                    <th width="20%"  class="text-right"> Nombre</th>
                                    <th width="20%"  class="text-right"> Total HT</th>
                                    <th width="20%"  class="text-right"> Total TTC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total</td>
                                    <td class="text-right"><?= $totalFactures['count'] ?></td>
                                    <td class="text-right"><?= $this->Number->format($totalFactures['total_ht']) ?> €</td>
                                    <td class="text-right"><?= $this->Number->format($totalFactures['total_ttc']) ?> €</td>
                                </tr>
                                <?php  foreach ($factures as $status => $facture) : ?>
                                    <tr>
                                        <td><?= @@$facture_status[$status] ?></td>
                                        <td class="text-right"><?= $facture['count'] ?></td>
                                        <td class="text-right"><?= $this->Number->format($facture['total_ht']) ?> €</td>
                                        <td class="text-right"><?= $this->Number->format($facture['total_ttc']) ?> €</td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</div>
<?php endif ?>

<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Factures</h3>

            <?php if ($has_factures): ?>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="10%">N°</th>
                            <th>Date</th>
                            <th>Event</th>
                            <th>Antenne(s)</th>
                            <th>Type</th> <!-- Corporation (pro) ou person (particulier) -->
                            <th>Document</th>
                            <th>Contact</th>
                            <th class="text-right">HT</th>
                            <th class="text-right">TTC</th>
                            <th>Règlements</th>
                            <th>Restant dû</th>
                            <th>Etat</th>
                            <th></th>
                        </tr>
                        <?php foreach ($clientEntity->factures as $key => $facture): ?>
                        <?php if( ! $facture->is_model) : ?>
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-html="true" data-placement="top" title='<?= $facture->get('ObjetAsTitle') ?>' href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $facture->id]) ?>"><?= $facture->indent ?></a>
                                    <?php if($facture->client_id != $clientEntity->id) : ?>
                                        <br>Client principal : <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $facture->client->id]) ?>"><?= $facture->client->full_name?></a>
                                    <?php elseif ($facture->client2) : ?>
                                        <br>Lié au client : <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $facture->client2->id]) ?>"><?= $facture->client2->full_name?></a>
                                    <?php endif; ?>                      
                                </td>
                                <td><?= $facture->date_crea? $facture->date_crea->format('d/m/y') : "-" ?></td>
                                <td><?= $facture->date_evenement ?></td>
                                <td><?= $facture->get('ListeAntennes'); ?></td>
                                <td><?= @$genres[$facture->client->client_type] ?? '' ?></td>
                                <td><?= @$type_docs[$facture->type_doc_id] ?? '--' ?></td>
                                <td> 
                                    <?php if ($facture->commercial) : ?>
                                        <img alt="Image" src="<?= $facture->commercial->url_photo ?>" class="avatar" data-title="<?= $facture->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        --
                                    <?php endif; ?>
                                </td>
                                <td class="text-right"><?= $facture->get('TotalHtWithCurrency') ?></td>
                                <td class="text-right"><?= $facture->get('TotalTtcWithCurrency') ?></td>
                                <td><?= count($facture->facture_reglements) ?></td>
                                <td><?= $facture->reste_echeance_impayee ?> €</td>
                                <td><i class="fa fa-circle <?= $facture->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$facture_status[$facture->status] ?>" data-original-title="Brouillon"></i> <?= @$facture_status[$facture->status] ?> </td>
                                <td>
                                    <?php if (!$facture->is_in_sellsy): ?>
                                        <div class="dropdown d-inline container-ventes-actions">
                                            <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $facture->id]) ?>" >Voir le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'historique', $facture->id]) ?>" >Voir l'historique</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'view', $facture->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'add', $facture->id, 1]) ?>">Modifier le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'pdfversion', $facture->id]) ?>" target="_blank">Imprimer le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'pdfversion', $facture->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'pdfversion', $facture->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build($facture->get('EncryptedUrl')) ?>">Voir la version web</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['controller' => 'devisFactures', 'action' => 'EditEtat', $facture->id, $clientEntity->id]) ?>" data-value='<?= $facture->status ?>' data-indent='<?= $facture->indent ?>'>Modifier l'état</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['controller'=>'devisFactures','action' => 'EditTypeDoc', $facture->id]) ?>" data-value='<?= $facture->type_doc_id ?>' data-indent='<?= $facture->indent ?>'>Modifier le type doc</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $facture->indent ?>)" data-type="facture_id" data-href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'editClient']) ?>" data-doc="<?= $facture->id ?>">Affecter à un autre client</a>                                                
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#duplicate_doc" data-title="Dupliquer la facture" data-href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'duplicatFacture', $facture->id]) ?>">Dupliquer le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'toAvoir', $facture->id]) ?>">Ajouter avoir</a>
                                                <?php if ($this->request->getQuery('test')): ?>
                                                    <?= $this->Form->postLink('Supprimer', ['controller' => 'DevisFactures', 'action' => 'delete', $facture->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes-vous sur de vouloir supprimer ?'] ); ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="dropdown d-inline container-ventes-actions">
                                            <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build($facture->get('SellsyDocUrl')) ?>" >Voir le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'pdfversion', $facture->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'pdfversion', $facture->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build($facture->get('EncryptedUrl')) ?>">Voir la version web</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['controller' => 'devisFactures', 'action' => 'EditEtat', $facture->id]) ?>" data-value='<?= $facture->status ?>' data-indent='<?= $facture->indent ?>'>Modifier l'état</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#devis_type_doc" data-href="<?= $this->Url->build(['controller'=>'devisFactures','action' => 'EditTypeDoc', $facture->id]) ?>" data-value='<?= $facture->type_doc_id ?>' data-indent='<?= $facture->indent ?>'>Modifier le type doc</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $facture->indent ?>)" data-type="facture_id" data-href="<?= $this->Url->build(['controller' => 'DevisFactures', 'action' => 'editClient']) ?>" data-doc="<?= $facture->id ?>">Affecter à un autre client</a>
                                                <?php if ($this->request->getQuery('test')): ?>
                                                    <?= $this->Form->postLink('Supprimer', ['controller' => 'DevisFactures', 'action' => 'delete', $facture->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes vous sur de vouloir supprimer ?'] ); ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endif ?>
                        <?php endforeach ?>
                    </thead>
                </table>
            <?php else: ?>
                Aucune facture pour ce client
            <?php endif ?>

        </div>
        <div class="form-actions">
            <a class="btn btn-rounded pull-right hidden-sm-down btn-success create-facture" data-toggle="modal" data-controller="DevisFactures" data-title="Création facture" data-submit="Créer la facture" href="#creation_doc">Créer une facture pour ce client</a>
        </div>
    </div>
</div>



<div class="card mb-4">
    <div class="card-body">

        <div class="row-fluid">
            <h3 class="mb-4">Opportunités</h3>

            <?php if ($clientEntity->opportunites): ?>

                <table class="table table-striped" id="div_table_bornes">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Statut</th>
                            <th>Collaborateur</th>
                            <th>Pipeline</th>
                            <th>Etape</th>
                            <th>Potentiel</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         foreach ($clientEntity->opportunites as $opportunite): ?>
                            <tr>
                                <td><a href="<?= $this->Url->build(['controller' => 'Opportunites', 'action' => 'view', $opportunite->id]) ?>"><?= h($opportunite->nom) ?></a></td>
                                <td><?= @$opportunite->opportunite_statut->nom ?></td>
                                <td>
                                    <?php
                                        if(!empty($opportunite->staffs)){
                                            $collection = new \Cake\Collection\Collection($opportunite->staffs);
                                            $names = $collection->extract('full_name')->toList();
                                            echo $this->Text->toList($names);
                                        }
                                    ?>
                                </td>
                                <td><?= @$opportunite->pipeline->nom ?></td>
                                <td><?= @$opportunite->pipeline_etape->nom ?></td>
                                <td><?= $this->Number->format($opportunite->montant_potentiel).' €' ?></td>
                                <td><?= $opportunite->date_crea ?></td>

                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                Aucune opportunités pour ce client
            <?php endif ?>

        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Règlements</h3>

            <?php if ($clientEntity->reglements): ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Date</th>
                        <!-- <th scope="col">Client/fournisseur/collaborateur</th> -->
                        <th scope="col">Moyen de paiement</th>
                        <th scope="col">Propriétaire</th>
                        <th scope="col">Réference</th>
                        <th scope="col" class="text-right">Montant</th>
                        <th scope="col" class="text-right">Restant à solder</th>
                        <!-- <th scope="col">Docs liés</th> -->
                        <th scope="col">état</th>
                        <th class="actions" ></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientEntity->reglements as $reglement): ?>
                            <?php /*debug($reglement);*/ ?>
                            <tr>

                                <td><?= @$type_reglements[$reglement->type] ?></td>
                                <td><span data-toggle="tooltip" data-placement="top" title="<?= $reglement->created->format('H\h:i') ?>" ><?= $reglement->created->format('d/m/Y') ?></span></td>
                                <!-- <td><a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $reglement->client_id]) ?>"><?= $reglement->has('client') ? ($reglement->client->nom ?? '') : $reglement->sellsy_client_name ?></a></td> -->
                                <td><?= @$reglement->moyen_reglement->name ?></td>

                                <td>
                                    <?php if ($reglement->user) : ?>
                                        <img alt="Image" src="<?= $reglement->user->url_photo ?>" class="avatar" data-title="<?= $reglement->user->get('FullNameShort') ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        <img alt="Image" src="<?= $commercial->url_photo ?>" class="avatar" data-title="Automatique" data-toggle="tooltip" />
                                    <?php endif; ?>
                                </td>
                                <td><?= $reglement->reference ?></td>
                                <td class="text-right"><?= $this->Utilities->formatCurrency($reglement->montant) ?></td>
                                <td class="text-right"><?= $this->Utilities->formatCurrency($reglement->solde_disponible ?? 0) ?></td>
                                <!-- <td><?php /*$reglement->devis_factures?count($reglement->devis_factures):"--"*/ ?></td> -->
                                <td><i class="fa fa-circle <?= $reglement->etat ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$etat_reglements[$reglement->etat] ?>" data-original-title="Brouillon"></i> <?= @$etat_reglement[$reglement->etat] ?></td>
                                <td class="">
                                    <div class="dropdown d-inline container-ventes-actions">
                                        <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Reglements', 'action' => 'view', $reglement->id, $reglement->parc_id]) ?>">Voir</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Reglements', 'action' => 'edit', $reglement->id]) ?>">Modifier</a>
                                                <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $reglement->id], ['class' => 'dropdown-item', 'confirm' => __('Are you sure you want to delete ?'), 'escape'=>false]) ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                Aucun règlement
            <?php endif ?>
        </div>
        
        <div class="form-actions">
            <a class="btn btn btn-rounded pull-right hidden-sm-down btn-success" data-toggle="modal" href="#add_reglement">Ajouter un réglement</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        
        <div class="row-fluid">
            <h3 class="mb-4">Avoir</h3>

            <?php if ($clientEntity->avoirs): ?>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="10%">N°</th>
                            <th>Lié à </th>
                            <th>Date</th>
                            <th>Date événement</th>
                            <th>Contact</th>
                            <th class="text-right">HT</th>
                            <th class="text-right">TTC</th>
                            <th>Règlements</th>
                            <th>Restant dû</th>
                            <th>Etat</th>
                            <th width="1%"></th>
                        </tr>
                        <?php foreach ($clientEntity->avoirs as $key => $avoirs): ?>
                            <tr>
                                <td>
                                    <a data-toggle="tooltip" data-html="true" data-placement="top" title="<?= $avoirs->get('ObjetAsTitle') ?>" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'view', $avoirs->id]) ?>"><?= $avoirs->indent ?></a>
                                    <?php if ($this->request->getQuery('test')): ?>
                                        <a  href="<?= $avoirs->sellsy_public_url ?>" target="_blank">(url sellsy)</a>
                                    <?php endif ?>
                                </td>
                                <td><?= $avoirs->devis_facture?$this->Html->link($avoirs->devis_facture->indent, ['controller' => 'DevisFactures', 'action' => 'view', $avoirs->devis_facture->id]) : "--" ?></td>
                                <td><?= $avoirs->date_crea?$avoirs->date_crea->format('d/m/y') : "--" ?></td>
                                <td><?= $avoirs->date_evenement ?></td>
                                <td> 
                                    <?php if ($avoirs->commercial) : ?>
                                        <img alt="Image" src="<?= $avoirs->commercial->url_photo ?>" class="avatar" data-title="<?= $avoirs->commercial->get('FullNameShort') ?>" data-toggle="tooltip" />
                                    <?php else : ?>
                                        --
                                    <?php endif; ?>
                                </td>
                                <td class="text-right"><?= $avoirs->get('TotalHtWithCurrency') ?></td>
                                <td class="text-right"><?= $avoirs->get('TotalTtcWithCurrency') ?></td>
                                <td><?= $avoirs->avoirs_reglements?count($avoirs->avoirs_reglements):"--" ?></td>
                                <td><?= $avoirs->get('ResteImpayee') ?> €</td>
                                <td><i class="fa fa-circle <?= $avoirs->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$facture_status[$avoirs->status] ?>" data-original-title="Brouillon"></i> <?= @$facture_status[$avoirs->status] ?> </td>
                                <td>
                                    <?php if (!$avoirs->is_in_sellsy): ?>
                                        <div class="dropdown d-inline container-ventes-actions">
                                            <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'view', $avoirs->id]) ?>" >Voir le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'view', $avoirs->id]) ?>" target="_blank">Voir dans un nouvel onglet</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'historique', $avoirs->id]) ?>" >Voir l'historique</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'add', $avoirs->id, 1]) ?>">Modifier le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'pdfversion', $avoirs->id]) ?>" target="_blank">Imprimer le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'pdfversion', $avoirs->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'EditEtat', $avoirs->id, $clientEntity->id]) ?>" data-value='<?= $avoirs->status ?>' data-indent='<?= $avoirs->indent ?>'>Modifier l'état</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $avoirs->indent ?>)" data-type="avoir_id" data-href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'editClient']) ?>" data-doc="<?= $avoirs->id ?>">Affecter à un autre client</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#duplicate_doc" data-title="Dupliquer l'Avoir" data-href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'duplicatAvoir', $avoirs->id]) ?>">Dupliquer le document</a>
                                                <?php if ($this->request->getQuery('test')): ?>
                                                    <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $avoirs->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes-vous sur de vouloir supprimer ?'] ); ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="dropdown d-inline container-ventes-actions">
                                            <button class="btn btn-default  btn-sm " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-chevron-down"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="<?= $this->Url->build($avoirs->get('SellsyDocUrl')) ?>" >Voir le document</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'pdfversion', $avoirs->id]) ?><?= $this->request->getQuery('test') ? '?test=1' : '' ?>" target="_blank">Voir la version pdf</a>
                                                <a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Avoirs','action' => 'pdfversion', $avoirs->id, 'download' => 'true']) ?>">Télécharger le document</a>
                                                <!--a class="dropdown-item" href="<?= $this->Url->build($avoirs->get('EncryptedUrl')) ?>">Voir la version web</a-->
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#facture_status" data-href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'EditEtat', $avoirs->id, $clientEntity->id]) ?>" data-value='<?= $avoirs->status ?>' data-indent='<?= $avoirs->indent ?>'>Modifier l'état</a>
                                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" data-target="#edit_client" data-title="Affecter à un autre client (<?= $avoirs->indent ?>)" data-type="avoir_id" data-href="<?= $this->Url->build(['controller' => 'Avoirs', 'action' => 'editClient']) ?>" data-doc="<?= $avoirs->id ?>">Affecter à un autre client</a>
                                                <?php if ($this->request->getQuery('test')): ?>
                                                    <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $avoirs->id], ['class' => 'dropdown-item', 'escape' => false, 'confirm' => 'Êtes vous sur de vouloir supprimer ?'] ); ?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </thead>
                </table>
            <?php else: ?>
                Aucun avoir pour ce client
            <?php endif ?>

        </div>
        <div class="form-actions">
            <a class="btn btn-rounded pull-right hidden-sm-down btn-success create-facture" data-toggle="modal" data-controller="Avoirs" data-title="Ajouter un avoir" data-submit="Ajouter l'avoir" href="#creation_doc">Ajouter un avoir</a>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="card mb-4">
    <div class="card-body">
        
        <div class="clearfix">
            <div class="row clearfix my-4">
                <div class="col-md-6 my-auto"><h3 class="m-0">Commentaires</h3></div>
                <div class="col-md-6 my-auto">
                    <a class="btn btn btn-rounded pull-right hidden-sm-down btn-success new-comment" data-toggle="modal" href="#modal-commentaire">Ajouter un commentaire</a>
                </div>
            </div>

            <?php if ($clientEntity->has('commentaires_clients')): ?>
                <?php foreach ($clientEntity->commentaires_clients as $key => $commentaire): ?>
                    <div class="card block-commentaire">
                        <div class="card-body">
                            <div class="row header">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-start">
                                        <div class="my-auto">
                                            <img src="<?= $commentaire->user->url_photo ?>" class="img-circle" width="50px" alt="">
                                        </div>
                                        <div class="my-auto">
                                            <h6 class="m-0 ml-2"><?= $commentaire->titre ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-auto">
                                    <div class="d-flex justify-content-end">
                                        <div><?= $commentaire->created->format('d/m/Y à H\\h:i') ?></div>
                                        <div class="ml-2">
                                            <a class="" id="opt-com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fas fa-ellipsis-v text-primary"></span>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="opt-com">
                                                <li class="dropdown-submenu dropright option">
                                                    <a class="dropdown-item"  data-toggle="modal" data-target="#modal-commentaire" data-id="<?= $commentaire->id ?>" data-href="<?= $this->Url->build(['action' => 'ajoutCommentaire', $clientEntity->id, $commentaire->id]) ?>" href="javascript:void(0);">Editer</a>
                                                    <a class="dropdown-item text-danger"  href="<?= $this->Url->build(['action' => 'deleteCommentaire', $clientEntity->id, $commentaire->id]) ?>" onclick='return confirm("Êtes-vous sûr de vouloir supprimer?")'>Supprimer</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix body py-4">
                                <?= $commentaire->content ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                Aucun commentaire pour ce client
            <?php endif ?>

        </div>
    </div>
</div>

<div class="modal fade" id="edit_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($clientEntity, ['id' => 'edit_client_form']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Affecter à un autre client </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client m-r-5">
                            <label class="col-md-3">Genre : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client-genre', 'empty' => 'Sélectionner' , 'value' => 'corporation']) ?>
                                <input type="hidden" id="doc_id">
                            </div>
                        </div>
                        
                        <div class="row row-client  m-r-5">
                            <label class="col-md-3">Client : </label>
                            <div class="col-md-9">
                                <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required', 'id' => 'edit_client_id']) ?>
                                <input type="hidden" id="doc_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Changer le client'), ['class' => 'btn btn-rounded btn-success btn-submit-client','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>
        
<div class="modal fade" id="creation_doc" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($clientEntity, ['class' => '']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Création devis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="row row-client for-devis">
                        <div class="col-md-5 m-t-10">
                            <label class=""> Catégorie modèle devis</label>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('category_model_devis_id', ['id' => 'category', 'options' => $modelCategories, 'label' => false, 'empty' => 'Catégorie du modèle', 'data-placeholder' => 'Catégorie du modèle', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                        </div>
                    </div>
                    <div class="row row-client hide sous-cat m-t-10">
                        <div class="col-md-5 m-t-10">
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('sous_category_model_devis_id', ['id' => 'sous_category', 'options' => [], 'label' => false, 'empty' => 'Sous catégorie du modèle', 'data-placeholder' => 'Sous catégorie du modèle', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                        </div>
                    </div>
                    <div class="row row-client for-devis m-t-10">
                        <div class="col-md-5 m-t-10">
                            <label class=""> Créer à partir du modèle </label>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('model_devis_id', ['id' => 'model_devis_list', 'options' => $modelDevis, 'label' => false, 'empty' => 'Modèle devis', 'data-placeholder' => 'Modèle devis', 'class' => 'form-control select2','style' => 'width:100%']); ?>
                        </div>
                    </div>
                    <div class="row row-client m-t-30">
                        <div class="col-md-5 m-t-10">
                            <label class=""> Catégorie tarifaire </label>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('categorie_tarifaire', ['options' => $categorie_tarifaires, 'label' => false, 'empty' => 'Catégorie tarifaire', 'default' => 'ht']); ?>
                        </div>
                    </div>
                    <div class="row row-client m-t-30">
                        <div class="col-md-5 m-t-10">
                            <label class=""> Type de document </label>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->control('type_doc_id', ['options' => $type_docs, 'label' => false, 'empty' => 'Type de document', 'required']); ?>
                        </div>
                    </div>
                    <input type="hidden" value="Devis" name="controller" id="controller_id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-submit">Créer le devis</button>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="devis_status" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'form-edit-status']); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modifier l'état du devis <span class="num_devis"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 mt-2 m-b-30">
                                <label>Etat : </label>
                            </div>
                            <div class="col-md-8">
                                <?= $this->Form->control('status', ['id' => 'modif_status', 'options' => $devis_status, 'empty' => 'Sélectionner', 'label' => false,'required']) ?>
                                <input type="hidden" name="devis_id" id="devis_id">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="facture_status" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Modifier l'état du document <span class="num_facture"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 mt-2 m-b-30">
                                <label>Etat : </label>
                            </div>
                            <div class="col-md-8 existing-client">
                                <?= $this->Form->control('status', ['id' => 'modif_status', 'options' => $facture_status, 'empty' => 'Sélectionner', 'label' => false,'required']) ?>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<!-- Modal add -->
<div class="modal font-14" id="add_reglement" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($new_reglement, ['url' => ['controller' => 'Reglements', 'action' => 'add', 'client', $clientEntity->id]]); ?>
            <input type="hidden" id="position" value="bottom">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Ajouter un réglement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <?= $this->Form->hidden('client_id', ['value' => $clientEntity->id]) ?>
                    <div class="row">
                        <label class="control-label col-md-4 m-t-5">Type de réglement</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('type',[
                                'type'=>'radio',
                                'options'=>$type_reglement,
                                'label'=>false,
                                'required'=>true,
                                'hiddenField'=>false,
                                'legend'=>false,
                                'templates' => [
                                    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                                    'radioWrapper' => '<div class="radio radio-success radio-inline">{{label}}</div>'
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Date de réglement</label>
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="date" name="date" id="date" class="form-control" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Moyen de paiement</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('moyen_reglement_id',['label' => false, 'options' => $moyen_reglements]) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Montant de réglement</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('montant',['label' => false]) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Référence</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('reference',['label' => false]) ?>
                        </div>
                    </div>
                    <div class="row reglement-row">
                        <label class="control-label col-md-4 m-t-5">Note</label>
                        <div class="col-md-8">
                            <?= $this->Form->control('note',['label' => false,'type' => 'textarea', 'class' => 'tinymce form-control']) ?>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                <?= $this->Form->button(__('Save'),["class"=>"btn btn btn-rounded btn-success",'escape'=>false]) ?>
            </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="duplicate_doc" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($clientEntity); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Créer un devis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row row-client">
                            <div class="col-md-5 mt-2 m-b-30">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input radios-client-3" id="group_radios_client_3" name="client" value="3">
                                    <label class="custom-control-label" for="group_radios_client_3">Pour ce même client </label>
                                </div>
                            </div>
                        </div>

                        <div class="row row-client">
                            <div class="col-md-5 mt-3 m-b-30">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input radios-client-1" id="group_radios_client_1" name="client" value="1" checked>
                                    <label class="custom-control-label" for="group_radios_client_1">Pour un client / prospect existant </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 row col-md-12 existing-client">
                            <div class="col-md-6 row">
                                <label class="control-label col-md-2 m-t-5">Genre</label>
                                <div class="col-md-10">
                                    <?= $this->Form->control('client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client-genre', 'empty' => 'Sélectionner' , 'value' => 'corporation']) ?>
                                </div>
                            </div>

                            <div class="col-md-6 row">
                                <label class="control-label col-md-2 m-t-5">Client</label>
                                <div class="col-md-10">
                                    <?= $this->Form->control('client_id', ['empty' => 'Sélectionner', 'class' => 'js-data-client-ajax form-control test', 'label' => false,'style' => 'width:100%',"data-placeholder"=>"Rechercher",'required']) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="custom-control custom-radio mt-3">
                            <input type="radio" class="custom-control-input radios-client-2" id="group_radios_client_2" value="2" name="client">
                            <label class="custom-control-label" for="group_radios_client_2">Pour un nouveau client / prospect</label>
                        </div>

                        <div class="mt-4 hide nouveau-client">

                            <h3 class="pb-2 mb-3 bordered">Informations client</h3>

                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Genre</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.client_type', ['options' => $genres, 'class' => 'selectpicker', 'label' => false, 'id' => 'client-type']) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5 client-name">Raison sociale (*)</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.nom', ['label' => false, 'class' => 'client-required form-control']); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 edit-client-lastname hide row">
                                    <label class="control-label col-md-4 m-t-5">Prénom (*)</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.prenom', ['label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Adresse</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.adresse', ['type'=>'text', 'class' => 'form-control new-clients','label' => false, 'id' => 'adresse', 'maxlength' => 255]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Adresse complémentaire</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.adresse_2', ['type' => 'text', 'class' => 'form-control new-clients','label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Code postal</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.cp', ['type'=>'text', 'class' => 'form-control cp', 'label' => false , 'maxlength' => 255]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row ">
                                    <label class="control-label col-md-4 m-t-5">Ville</label>
                                    <div class="col-md-8 bloc-ville">
                                        <?= $this->Form->control('is_ville_manuel', ['label' => 'Saisir manuellement', 'id' => 'is_ville_manuel_1', 'type' => 'checkbox']); ?>
                                        <div class="container-fluid">
                                            <div class="clearfix select"><?= $this->Form->control('new_client.ville', ['empty' => 'Sélectionner par rapport au code postal', 'options' => $villesFrances, 'class' => 'form-control selectpicker list_ville', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                            <div class="clearfix input d-none"><?= $this->Form->control('new_client.ville', ['label' => false, 'disabled']); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Pays</label>
                                    <div class="col-md-8">
                                        <div class="clearfix select"><?= $this->Form->control('new_client.pays_id', ['options' => $payss, 'default' => 5, 'empty' => 'Sélectionner', 'class' => 'form-control selectpicker', 'id' => 'country', 'data-live-search' => true, 'label' => false, 'type' => 'select']); ?></div>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5 client-tel">Tél entreprise</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.telephone', ['type'=>'text', 'class' => 'form-control','label' => false ]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5 client-mail">Email général</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.email', ['class' => 'form-control','label' => false ]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Tva Intracommunautaire</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.tva_intra_community', ['class' => 'form-control pro','label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Siren</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.siren', ['class' => 'form-control pro','label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Siret</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.siret', ['class' => 'form-control pro','label' => false]); ?>
                                    </div>
                                </div>
                            </div>

                            <h3 class="pb-2 mb-3 bordered">Qualification client</h3>

                            <div class="row">
                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4 m-t-5">Type commercial *</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.type_commercial', ['options' => $type_commercials, 'class' => 'client-required selectpicker', 'empty' => 'Sélectionner', 'label' => false]) ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Type</label>
                                    <div class="col-md-8 row my-auto" id="types">
                                        <div class="col-6 mt-2"><?= $this->Form->control('new_client.is_location_event', ['type' => 'checkbox' ,'label' => 'Location event']); ?></div>
                                        <div class="col-3 mt-2"><?= $this->Form->control('new_client.is_vente', ['type' => 'checkbox' ,'label' => 'Vente']); ?></div>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Groupes de clients</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.groupe_client_id', ['empty' => 'Sélectionner', 'class' => 'selectpicker form-control client_id', 'data-live-search' => true, 'label' => false]); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row client-pro">
                                    <label class="control-label col-md-4 m-t-5">Secteur d'activité</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.secteurs_activites._ids', ['multiple'=> "multiple", 'class' => 'select2 secteurs_activites client-required  form-control', 'label' => false, 'options' => $secteursActivites, 'style' => 'width:100%']); ?>
                                    </div>
                                </div>

                                <div class="col-md-6 row">
                                    <label class="control-label col-md-4">Comment a-t-il connu Selfizee ?</label>
                                    <div class="col-md-8">
                                        <?= $this->Form->control('new_client.connaissance_selfizee', ['label' => false , 'options' => $connaissance_selfizee, 'empty' => 'Sélectionner']); ?>
                                    </div>
                                </div>
                            </div>

                            <h3 class="pb-2 mb-3 bordered">Contacts associés</h3>

                            <div class="row-fluid">
                                <div class="d-block clearfix">
                                    <button type="button" class="btn btn-success add-data float-right mt-2">Ajouter un contact</button>
                                </div>

                                <table class="tables mt-2">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prénom</th>
                                            <th>Fonction </th>
                                            <th>Email</th>
                                            <th>Tél. Portable</th>
                                            <th>Tél. Fixe</th>
                                        </tr>
                                    </thead>

                                    <tbody class="default-data">
                                        <?php $init = 0 ?>
                                        <tr>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.nom", ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.prenom", ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                            <td><?= $this->Form->control("new_client.client_contacts.$init.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                            <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tbody>

                                    <tfoot>
                                        <tr class="d-none clone added-tr">
                                            <td><?= $this->Form->control('new_client.client_contacts.nom', ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.prenom', ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.position', ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.email', ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.tel', ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                            <td><?= $this->Form->control('new_client.client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                            <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                            <hr>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Dupliquer le document'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<!-- MODAL MODIFICATION CLIENT -->
<div class="modal fade" id="modifier_client" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($clientEntity, ['url' => ['action' => 'add', $clientEntity->id]]) ?>
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


<!-- MODAL CONTACT -->
<div class="modal fade" id="modifier_contact" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <?= $this->Form->create($clientEntity, ['url' => ['action' => 'add', $clientEntity->id]]) ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Contacts associés</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">

                    <div class="row-fluid">
                        <button type="button" class="btn btn-primary add-data float-right mt-2 mb-4">Ajouter un contact</button>

                        <table class="table mt-2">
                            <thead>
                                <tr>
                                    <th>Prénom (*)</th>
                                    <th>Nom (*)</th>
                                    <th>Fonction </th>
                                    <th>Email (*)</th>
                                    <th>Téléphone Portable </th>
                                    <th>Téléphone Fixe</th>
                                    <th>Type</th>
                                </tr>
                            </thead>

                            <tbody class="default-data">
                                <?php if ($clientEntity->client_contacts): ?>
                                    <?php foreach ($clientEntity->client_contacts as $key => $client_contact): ?>
                                        <?php if (!$client_contact->get('IsInfosEmpty')):?>
                                            <tr>
                                                <td class="hide"><?= $this->Form->hidden("client_contacts.$key.id", ['input-name' => 'id', 'label' => false, 'id' => 'email']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.prenom", ['required', 'input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.nom", ['required', 'input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                                <td><?= $this->Form->control("client_contacts.$key.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                                <td><a href="javascript:void(0);" data-href="<?= $this->Url->build(['controller' => 'AjaxClients', 'action' => 'deleteContact', $client_contact->id]) ?>" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                            </tr>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>

                                <?php $init = isset($key) ? $key+1 : 0 ?>

                                <tr>
                                    <td><?= $this->Form->control("client_contacts.$init.prenom", ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>

                                    <td><?= $this->Form->control("client_contacts.$init.nom", ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.position", ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.email", ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.tel", ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.telephone_2", ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.$init.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                    <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="d-none clone added-tr">
                                    <td><?= $this->Form->control('client_contacts.prenom', ['input-name' => 'prenom', 'label' => false, 'id' => 'prenom']); ?></td>

                                    <td><?= $this->Form->control('client_contacts.nom', ['input-name' => 'nom', 'label' => false, 'id' => 'nom']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.position', ['input-name' => 'position', 'label' => false, 'id' => 'position']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.email', ['input-name' => 'email', 'label' => false, 'id' => 'email']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.tel', ['input-name' => 'tel', 'label' => false, 'id' => 'tel']); ?></td>
                                    <td><?= $this->Form->control('client_contacts.telephone_2', ['input-name' => 'telephone_2', 'label' => false, 'id' => 'telephone_2']); ?></td>
                                    <td><?= $this->Form->control("client_contacts.contact_type_id", ['input-name' => 'contact_type_id', 'label' => false, 'id' => 'contact_type_id', 'class' => 'form-control', 'empty' => 'Sélectionner']); ?></td>
                                    <td><a href="javascript:void(0);" id="remove-prod"><i class="mdi mdi-delete text-inverse"></i></a></td>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-dark" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">Annuler</span> </button>
                    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-rounded btn-success btn-submit','escape' => false]) ?>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<?= $this->element('devis_et_factures/popup_edit_type_doc') ?>

<div class="modal fade" id="modal-commentaire" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?= $this->Form->create($commentaireClientEntity, ['default-url' => $this->Url->build(['action' => 'ajoutCommentaire', $clientEntity->id]), 'url' => ['action' => 'ajoutCommentaire', $clientEntity->id], 'class' => '', 'templates' => $modalFormCommentaireTemplate]); ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nouveau commentaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                    <?= $this->Form->control('titre'); ?>
                    <?= $this->Form->control('content', ['label' => 'Message']); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Enregistrer</button>
                </div>

            <?= $this->form->end() ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    var modelDevis = <?php echo json_encode($modelDevis); ?>;
    var modelSousCategories = <?php echo json_encode($modelSousCategories); ?>;
</script>
