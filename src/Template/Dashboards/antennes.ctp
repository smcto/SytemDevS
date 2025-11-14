<?= $this->Html->script('chartist-js/chartist.min.js', ['block' => true]); ?>
<?= $this->Html->script('chartist-plugin-tooltip-master/chartist-plugin-tooltip.min.js', ['block' => true]); ?>
<!-- Chart JS -->
<?= $this->Html->script('echarts/echarts-all.js', ['block' => true]); ?>
<!-- Chart JS -->
<?= $this->Html->script('dashboard1.js', ['block' => true]); ?>
<?= $this->Html->script('footable/footable.all.min.js', ['block' => true]); ?>
<!--FooTable init-->
<?= $this->Html->script('footable-init.js', ['block' => true]); ?>
<?php
$titrePage = "Dashboard" ;
$this->start('breadcumb');
$this->Breadcrumbs->add('Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'antennes']
);
$this->Breadcrumbs->add($titrePage);
echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();
?>
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-12"><span class="display-6"><?= $this->Number->currency($total_CA, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?> </span>
                        <h6>Total CA</h6></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-12"><span class="display-6"><?= $this->Number->currency($total_CA_accepte, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?> </span>
                        <h6>Total CA Accepté</h6></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-12"><span class="display-6"><?= $this->Number->currency($total_CA_facture_pro, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?> </span>
                        <h6>Total CA Facturé - Pro</h6></div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-12"><span class="display-6"><?= $this->Number->currency($total_CA_facture_part, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?> </span>
                        <h6>Total CA Facturé - Particulier</h6></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><span class="display-6"><?= count($evenements); ?></span>
                        <h6>Evénements</h6></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><span class="display-6"><?= $nbrEvenementsPro; ?></span>
                        <h6>Evénements Professionnels</h6></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <!-- Row -->
                <div class="row">
                    <div class="col-8"><span class="display-6"><?= $nbrEvenementsParticulier; ?></span>
                        <h6>Evénements Particulier</h6></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block">
                    <h4 class="card-title">Stock</h4>
                    <div class="ml-auto">              
                    </div>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="table stylish-table">
                        <thead>
                        <tr>
                            <th>Antenne</th>
                            <th>Bobine DNP</th>
                            <th>Bobine Mitsu</th>
                            <th>Imprimante DNP</th>
                            <th>Imprimante Mitsu</th>
                            <th>Date recensement</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  foreach ($antennes as $antenne) {?>
                        <?php
                                        $stock_antenne = null;
                                        if(!empty($antenne->stock_antennes)){
                                        $stock_antenne_last = $antenne->stock_antennes[count($antenne->stock_antennes) - 1];
                                        $stock_antenne = $stock_antenne_last;
                        ?>
                        <tr>
                            <td><?= $antenne->ville_principale ?></td>
                            <td><?php if(!empty($stock_antenne)) { echo $stock_antenne->bobine_dnp ;} ?></td>
                            <td><?php if(!empty($stock_antenne)) { echo $stock_antenne->bobine_mitsu ;} ?></td>
                            <td><?php if(!empty($stock_antenne)) { echo $stock_antenne->imprimante_dnp ;} ?></td>
                            <td><?php if(!empty($stock_antenne)) { echo $stock_antenne->imprimante_mitsu; } ?></td>
                            <td><?php if(!empty($stock_antenne)) { echo $stock_antenne->date_recensement; }?></td>
                        </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 </div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block">
                    <h4 class="card-title">Evénements à venir</h4>
                    <div class="ml-auto">
                        <ul class="list-inline pull-right">
                            <li>
                                <h6 class="text-muted"><i class="fa fa-circle m-r-5" style="color:#51bdff"></i>Total : <?= count($evenementsAvenir); ?></h6>
                            </li>
                            <li>
                                <h6 class="text-muted"><i class="fa fa-circle m-r-5" style="color:#11a0f8"></i>Professionnels : <?= $nbrEvenementsAvenirPro; ?></h6>
                            </li>
                            <li>
                                <h6 class="text-muted"><i class="fa fa-circle m-r-5 text-info"></i>Particulier : <?= $nbrEvenementsAvenirParticulier; ?></h6>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="table stylish-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Client</th>
                            <th>Antenne</th>
                            <th>Type d'installation</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($evenementsAvenir)){
                                $options = ['1'=>'Nos soins', '2'=>'Retraits', '3'=>'Envoi transporteur'];
                                $clientType = ['corporation'=>'Professionel' , 'person'=>'Particulier' ];?>
                                <?php foreach ($evenementsAvenir as $evenement){ ?>
                                <tr>
                                    <td><?php $dates = [];
                                    if(!empty($evenement->date_evenements)) {
                                        foreach($evenement->date_evenements as $date_event) {
                                        $dates [] = $date_event->date_debut->format('d/m/y')." - ".$date_event->date_fin->format('d/m/y');
                                        }
                                        echo implode(', ',  $dates);
                                        }?>
                                    </td>
                                    <td><?= $evenement['nom_event']; ?></td>
                                    <td><?= $evenement['type_evenement']['nom']; ?></td>
                                    <td><?php // $evenement['client']['full_name']; ?>
                                        <h6><?= $evenement['client']['full_name'] ?></h6>
                                        <small class="text-muted"><?= $clientType[$evenement['client']['client_type']] ?></small>
                                    </td>
                                    <td><?= $evenement['antenne']['ville_principale']; ?></td>
                                    <td><?= $options[$evenement['type_installation']]; ?></td>
                                </tr>
                                <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Total : <?= count($evenementsAvenir); ?></h4>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Professionnels : </h4>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Particulier : </h4>

                    </div>
                </div>
            </div>
        </div>
    </div>-->
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block">
                    <h4 class="card-title">Evénements passés</h4>
                    <div class="ml-auto">
                        <ul class="list-inline pull-right">
                            <li>
                                <h6 class="text-muted"><i class="fa fa-circle m-r-5" style="color:#51bdff"></i>Total : <?= count($evenementsPasses); ?></h6>
                            </li>
                            <li>
                                <h6 class="text-muted"><i class="fa fa-circle m-r-5" style="color:#11a0f8"></i>Professionnels : <?= $nbrEvenementsPassesPro; ?></h6>
                            </li>
                            <li>
                                <h6 class="text-muted"><i class="fa fa-circle m-r-5 text-info"></i>Particulier : <?= $nbrEvenementsPassesParticulier; ?></h6>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="table stylish-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Client</th>
                            <th>Antenne</th>
                            <th>Type d'installation</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($evenementsPasses)){
                                $options = [''=>'', '1'=>'Nos soins', '2'=>'Retraits', '3'=>'Envoi transporteur'];
                                $clientType = ['corporation'=>'Professionel' , 'person'=>'Particulier' ];?>
                        <?php foreach ($evenementsPasses as $evenement){ ?>
                        <tr>
                            <td><?php $dates = [];
                                    if(!empty($evenement->date_evenements)) {
                                foreach($evenement->date_evenements as $date_event) {
                                $dates [] = $date_event->date_debut->format('d/m/y')." - ".$date_event->date_fin->format('d/m/y');
                                }
                                echo implode(', ',  $dates);
                                }?>
                            </td>
                            <td><?= $evenement['nom_event']; ?></td>
                            <td><?= $evenement['type_evenement']['nom']; ?></td>
                            <td><?php // $evenement['client']['full_name']; ?>
                                <h6><?= $evenement['client']['full_name'] ?></h6>
                                <small class="text-muted"><?= $clientType[$evenement['client']['client_type']] ?></small>
                            </td>
                            <td><?= $evenement['antenne']['ville_principale']; ?></td>
                            <td><?= $options[$evenement['type_installation']]; ?></td>
                        </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="col-lg-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Total : <?= count($evenementsPasses); ?> </h4>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Professionnels : </h4>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Particulier : </h4>

                    </div>
                </div>
            </div>

        </div>
    </div>-->
</div>

<div class="row">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block">
                    <h4 class="card-title">Factures</h4>
                    <div class="ml-auto">
                        <!--<h5 class="card-title">Total</h5>-->
                    </div>
                </div>
                <div class="table-responsive m-t-40">
                    <table class="table stylish-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Titre</th>
                            <th>Expediteur</th>
                            <th>Antenne(s)</th>
                            <th>Projet</th>
                            <th>Etat</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($factures)){ ?>
                        <?php foreach ($factures as $facture){ ?>
                            <tr>
                                <td>
                                    <?php if(!empty($facture->created)) echo ($facture->created->format('d/m/Y H:i')) ?>
                                </td>
                                <td><h6><?= $facture->titre ?></h6>
                                    <small class="text-muted"><?= $this->Number->currency($facture->montant, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                                </td>
                                <td><?php echo $facture->user->full_name ;?></td>
                                <td><?php
                                    $antennes = [];
                                    if(!empty($facture->user->antennes_rattachees)){
                                    foreach ($facture->user->antennes_rattachees as $antenne) {
                                    $antennes [] = $antenne->ville_principale;
                                    }
                                    }
                                    echo implode(', ', $antennes);
                                    ?>
                                </td>
                                <td><?php if(!empty($facture->evenement))  echo $facture->evenement->nom_event ?></td>
                                <?php $etats = ['1'=>'warning', '2'=>'success', '3'=>'danger', '4'=>'info',  ]?>
                                <td><span class="label label-light-<?= $etats[$facture->etat_facture->id] ?>"><?= $facture->etat_facture->nom ?></span></td>
                            </tr>
                        <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block">
                    <div class="d-flex no-block">
                        <h4 class="card-title">Total</h4>
                        <div class="ml-auto">
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center flex-row m-t-30">
                <table class="table no-border">
                    <tbody><tr>
                        <td>Reçues</td>
                        <td class="font-medium"><?= $nbTotal ?> <br>
                            <small class="text-muted"><?= $this->Number->currency($montantTotal, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                        </td>
                    </tr>
                    <tr>
                        <td>Réglé</td>
                        <td class="font-medium"><?= $nbTotalRegle ?> <br>
                            <small class="text-muted"><?= $this->Number->currency($montantTotalRegle, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                        </td>
                    </tr>
                    <tr>
                        <td>A régler</td>
                        <td class="font-medium"><?= $nbTotalAregler ?> <br>
                            <small class="text-muted"><?= $this->Number->currency($montantTotalAregler, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                        </td>
                    </tr>
                    <tr>
                        <td>En attente</td>
                        <td class="font-medium"><?= $nbTotalEnAttente ?><br>
                            <small class="text-muted"><?= $this->Number->currency($montantTotalEnAttente, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                        </td>
                    </tr>
                    <tr>
                        <td>Refusé</td>
                        <td class="font-medium"><?= $nbTotalRefuse ?><br>
                            <small class="text-muted"><?= $this->Number->currency($montantTotalRefuse, "EUR", ['before'=>'', 'locale'=>'fr_FR'] ) ?></small>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BORNES -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block">
                    <h4 class="card-title">Bornes</h4>
                    <div class="ml-auto">

                    </div>
                </div>
                <h6 class="card-subtitle">Total : <?= count($bornes) ?></h6>
                <div class="table-responsive">
                    <table class="table stylish-table">
                        <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Modele</th>
                            <th>Antenne</th>
                            <th>Couleur</th>
                            <th>Date expiration SB</th>
                            <th>Etat connexion</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($bornes)){ ?>
                        <?php foreach ($bornes as $borne){ ?>
                        <tr>
                            <td><?= $borne['numero'] ?></td>
                            <td><?= $borne['model_borne']['nom'] ?></td>
                            <td><?= $borne['antenne']['ville_principale'] ?></td>
                            <td><?= $borne['couleur']['couleur'] ?></td>
                            <td><?= $borne['expiration_sb'] ?></td>
                            <td>
                                <?php $etats = ["0"=>"Déconnecté", ""=>"Déconnecté", "1"=>"Connecté"];
                                        echo $etats[$borne['teamviewer_online_state']];
                                ?>
                            </td>
                        </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CONTACTS -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Contacts</h4>
                <h6 class="card-subtitle">Contacts de l'antenne
                <?php $list_antennes = []; foreach($user_connected['antennes_rattachees_list'] as $antenne){
                        $list_antennes [] = $antenne['ville_principale'];
                }
                echo implode(' et ', $list_antennes); ?>
                </h6>
                <div class="table-responsive m-t-40">
                    <table class="table table-hover v-middle">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>Type(s) profil(s)</th>
                            <th>Ville</th>
                            <th>Antenne(s)</th>
                            <th>Téléphone</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $users = $contacts; if(!empty($users)){ ?>
                        <?php foreach ($users as $user){?>
                        <tr>
                            <td><?= $this->Html->image($user['url_photo'],['class'=>'img-circle', 'width'=>'50']) ?></td>
                            <td><?= $user['full_name'] ?></td>
                            <td>
                                <?php $typeProfils = [];
                                        if(!empty($user['profils'])){
                                foreach ($user['profils'] as $typeProfil) {
                                $typeProfils [] = $typeProfil['nom'];
                                }
                                }
                                echo implode(', ', $typeProfils);
                                ?>
                            </td>
                            <td><?= $user['ville'] ?></td>
                            <td>
                                <?php
                                        $antennes = [];
                                        if(!empty($user['antennes_rattachees'])){
                                foreach ($user['antennes_rattachees'] as $antenne) {
                                $antennes [] = $antenne['ville_principale'];
                                }
                                }
                                echo implode(', ', $antennes);
                                ?>
                            </td>
                            <td><?= $user['telephone_portable'] ?></td>
                        </tr>
                        <?php } } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>


