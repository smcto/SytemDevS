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
<div class="row">
    <h3 class="col-md-12">CA PART</h3>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total facturation HT <?= $currentYear ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePart[0]->total_ht); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total PCA HT <?= $currentYear ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= !empty($pca) ? $this->Number->currency($pca->pca_part) : '0,00 €' ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total PCA HT <?= $currentYear +1 ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"><?= $this->Number->currency($facturePartN1[0]->total_ht); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total déduction <?= $currentYear-1 ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= !empty($deduction) ? $this->Number->currency($deduction->pca_part) : '0,00 €' ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total réel HT <?= $currentYear ?></h4>
                <div class="text-center">
                    <?php
                        $v1 = !empty($pca) ? $pca->pca_part : 0;
                        $d = !empty($deduction) ? $deduction->pca_part : 0;
                        $totalpartHt = $facturePart[0]->total_ht + $v1 - $facturePartN1[0]->total_ht - $d;

                    ?>
                    <h2 class="font-light m-b-0"> <?=$this->Number->currency($totalpartHt) ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total réel TTC <?= $currentYear ?></h4>
                <div class="text-center">
                    <?php
                        $totalpartTtc =  $totalpartHt * 1.2;

                    ?>
                    <h2 class="font-light m-b-0"> <?=$this->Number->currency($totalpartTtc) ?></h2>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h3 class="col-md-12">CA PRO</h3>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total facturation HT <?= $currentYear ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= $this->Number->currency($facturePro[0]->total_ht); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total PCA HT <?= $currentYear ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= !empty($pca) ? $this->Number->currency($pca->pca_pro) : '0,00 €' ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total PCA HT <?= $currentYear +1 ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"><?= $this->Number->currency($factureProN1[0]->total_ht); ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total déduction <?= $currentYear-1 ?></h4>
                <div class="text-center">
                    <h2 class="font-light m-b-0"> <?= !empty($deduction) ? $this->Number->currency($deduction->pca_pro) : '0,00 €' ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total réel HT <?= $currentYear ?></h4>
                <div class="text-center">
                    <?php
                        $v1 = !empty($pca) ? $pca->pca_pro : 0;
                        $d = !empty($deduction) ? $deduction->pca_pro : 0;
                        $totalProHt = $facturePro[0]->total_ht + $v1 - $factureProN1[0]->total_ht - $d;

                    ?>
                    <h2 class="font-light m-b-0"> <?=$this->Number->currency($totalProHt) ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Total réel TTC <?= $currentYear ?></h4>
                <div class="text-center">
                    <?php
                        $totalpartTtc =  $totalProHt * 1.2;

                    ?>
                    <h2 class="font-light m-b-0"> <?=$this->Number->currency($totalpartTtc) ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>