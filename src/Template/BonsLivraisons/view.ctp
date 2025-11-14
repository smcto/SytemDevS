<?= $this->Html->css('devis/view.css?time='.time(), ['block' => 'script']); ?>
<?php $this->assign('title', 'Bons de livraison') ; ?>

<div class="pdf-content-view-wrapper row m-t-20">
    <div class="col-3">
        <div class="card pdf-main-info-wrapper">
            <div class="card-body">
                <h4>Bons de livraison</h4>
                <hr>
                <div class="inner-pdf-detail-wrapper">
                    <div class="pdf-info-wrap">
                        Numero <br>
                        <b><?= $bonsLivraison->indent ?></b>
                    </div>
                    <div class="pdf-info-wrap">
                        Client <br>
                        <?php if ($bonsLivraison->client) : ?>
                            <a href="<?= $this->Url->build(['controller' => 'Clients', 'action' => 'fiche', $bonsLivraison->client->id]) ?>"><?= $bonsLivraison->client->full_name?></a>
                        <?php else : ?>
                            <?= $bonsLivraison->client_nom ?>
                        <?php endif; ?>
                    </div>
                    <div class="pdf-info-wrap">
                        Date depart atelier <br>
                        <b><?= $bonsLivraison->date_depart_atelier?$bonsLivraison->date_depart_atelier->format('d/m/Y') : '--'?></b>
                    </div>

                    <div class="pdf-info-wrap">
                        <h4 style="border-bottom: 1px solid grey;">Total </h4>
                        <div class="m-t-15">
                            Nombre de palette(s) : <br>
                            <b><?= $this->Utilities->formatNumber($bonsLivraison->nombre_palettes) ?></b>
                        </div>
                        <div class="m-t-15">
                            Nombre de carton(s) : <br>
                            <b><?= $this->Utilities->formatNumber($bonsLivraison->nombre_cartons) ?></b>
                        </div>
                        <div class="m-t-15">
                            Poids : <br>
                            <b><?= $this->Utilities->formatNumber($bonsLivraison->poids) ?></b>
                        </div>

                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-9">
        <iframe src="<?= $this->Url->build($bonsLivraison->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf"></iframe>
    </div>
</div>
