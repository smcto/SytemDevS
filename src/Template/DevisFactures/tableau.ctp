<?php
$this->start('breadcumb');
$this->Breadcrumbs->add(
    'Tableau de bord',
    ['controller' => 'Dashboards', 'action' => 'index']
);

$this->Breadcrumbs->add('Tableau de board facture');

echo $this->element('breadcrumb',['titrePage' =>'Tableau de board facture']);
$this->end();
?>

 <!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TOTAL CA HT PART</h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePart[0]->total_ht); ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TOTAL CA TTC PART</h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePart[0]->total_ttc); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TOTAL CA HT PRO</h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePro[0]->total_ht); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TOTAL CA TTC PRO</h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePro[0]->total_ttc); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TOTAL CA HT </h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePart[0]->total_ht + $facturePro[0]->total_ht ); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">TOTAL CA TTC </h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePart[0]->total_ttc + $facturePro[0]->total_ttc ); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row -->