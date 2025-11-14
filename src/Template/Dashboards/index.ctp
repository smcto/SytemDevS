<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\View\Helper\SessionHelper;
?>


<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->


<!--Dynamic Bread Cumb -->
<?php
$titrePage = "Dashboard" ;
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add($titrePage);


echo $this->element('breadcrumb',['titrePage' => $titrePage]);
$this->end();

//debug($user_connected);die;
?>

<!-- End Dynamic Bread Cumb -->

<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Antennes</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbAntennes ?></h2>
                    <span class="text-muted"></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bornes - Parc Locatif</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbBornesParcLocatifs ?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bornes - Parc de vente</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbBornesParcVentes ?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Factures recues</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbFactures ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Evenements Pro</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbrEvenementsPro ?? 0 ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Evenements Particuliers</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbrEvenementsParticulier ?? 0 ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Contacts </h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbContacts ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Contacts Konitys</h4>
                <div class="text-right">
                    <h2 class="font-light m-b-0"><?= $nbContactsKonitys ?></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
