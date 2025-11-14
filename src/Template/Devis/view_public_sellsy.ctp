<?= $this->Html->css('devis/stripe_payment.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('devis/view_public.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('/scss/icons/font-awesome/css/font-awesome.css', ['block' => 'css']); ?>

<?= $this->Html->script('devis/view_public.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/show-stripe-popup.js?'.  time(), ['block' => 'script']); ?>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script src="https://js.stripe.com/v3/"></script>

<!-- Trustpilot widget script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End of Trustpilot widget script -->

<?php $this->assign('title', 'Devis Selfizee '.$devisEntity->indent) ?>
<script src="https://js.stripe.com/v3/"></script>
<?php
    $is_cgl_accepted_checked = '';
?>

<?php if ($this->request->getQuery('test')): ?>
    <?php $devisEntity->email = 'andriam.nars@gmail.com' ?>
    <?php $is_cgl_accepted_checked = 'checked' ?>
<?php endif ?>

<?php $this->start('head') ?>
    <?php echo $this->Html->meta('robots', 'noindex, nofollow'); ?>
<?php $this->end() ?>


<?php /*debug($devisEntity);*/ ?>

<!-- === Quotation Container === -->

<!-- Vars dans js -->
<?php echo $this->Form->hidden('telecharger', ['value' => 'le devis']); ?>
<?php echo $this->Form->hidden('devis_id', ['value' => base64_encode(serialize([$devisEntity->id])), 'id' => 'devis_id']); ?>
<!-- / end -->

<?php use Cake\Routing\Router; ?>
<input type="hidden" id="id_baseUrl" value="<?php echo Router::url('/', true) ; ?>"/>

<div class="quotation-container">

    <div class="quotation-header-wrapper">

        <div class="left-quotation-header-wrapper">

            <div class="inner-left-header-wrapper" id="inner-left-header-wrapper">

                <div class="left-header-detail-wrapper">

                    <div>

                        <div class="selfizee-logo-wrap">
                            <?php echo $this->Html->image('logo-selfizee.png', ['alt' => 'Logo', "class" => ""]); ?>
                        </div>

                        <div class="quotation-type">
                            <?= $devisEntity->get('BorneTypeAsText') ?>
                        </div>

                        <div>
                            N° <?= $devisEntity->indent ?>
                        </div>

                        <div class="mobile-more-client-data">
                            <div>
                                <?php if (!empty($devisEntity->date_evenement)): ?>
                                    <!-- Date événement : <?= $devisEntity->date_evenement ?> au  <?= $devisEntity->date_evenement_fin ?> -->
                                    Week end du <?= $devisEntity->date_evenement ?> 
                                <?php else: ?>
                                    Date : <?= $devisEntity->date_crea ?>
                                <?php endif ?>
                            </div>
                            <div>
                                Contact : <?= $devisEntity->client->get('FullName2') ?>
                            </div>
                            <div>
                                <!-- Lieu de retrait : <?= $devisEntity->get('LieuRetraitFormated') ?> -->
                                <?php 
                                if(!empty($devisEntity->lieu_evenement) && $devisEntity->model_type == 'spherik' ){ 
                                    echo 'Lieu événement : '.$devisEntity->lieu_evenement;
                                }else{
                                    echo 'Lieu de retrait : '.$devisEntity->get('LieuRetraitFormated');
                                }
                                ?>
                            </div>
                        </div>

                    </div>

                </div>

                <?php if ($devisEntity->model_type): ?>
                    <div class="booth-type-logo" id="booth-type-logo">
                        <?php if ($devisEntity->model_type == 'classik'): ?>
                            <?php echo $this->Html->image('devis/classik.jpg', ['alt' => 'Classik', "class" => ""]); ?>
                        <?php elseif($devisEntity->model_type == 'spherik'): ?>
                            <?php echo $this->Html->image('devis/spherik.jpg', ['alt' => 'Spherik', "class" => ""]); ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>


                <div class="right-header-detail-wrapper hide-for-mobile">

                    <div>
                        <div>
                            <?php if (!empty($devisEntity->date_evenement)): ?>
                                <!-- Date événement : <?= $devisEntity->date_evenement ?> au  <?= $devisEntity->date_evenement_fin ?> -->
                                Week end du <?= $devisEntity->date_evenement ?> 
                            <?php else: ?>
                                Date : <?= $devisEntity->date_crea ?>
                            <?php endif ?>
                        </div>
                        <div>
                            Contact : <?= $devisEntity->client->get('FullName2') ?>
                        </div>
                        <div>
                            <?php 
                            if(!empty($devisEntity->lieu_evenement) && $devisEntity->model_type == 'spherik'){ 
                                echo 'Lieu événement : '.$devisEntity->lieu_evenement;
                            }else{
                                echo 'Lieu de retrait : '.$devisEntity->get('LieuRetraitFormated');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--<div class="right-quotation-header-wrapper hide-for-mobile">-->

        <div class="right-quotation-header-wrapper">

                <div class="top-right-quotation-header-wrapper">

                    <div class="booking-top-total-amount">
                        <?= $this->Number->currency($devisEntity->get('total_ttc'), 'EUR'); ?> <span class="ttc-icon">ttc</span>
                    </div>
                </div>
        </div>
    </div>


    <div class="quotation-main-content-container">

        <div class="quotation-side-section quotation-detail-section">

            <div class="inner-quotation-detail-section">

                <div class="booking-step-container booking-step-one">

                    <div class="booking-detail-container">

                        <div class="booking-title">
                             les infos sur les règlements :
                        </div>

                        <div class="booking-instruction-wrapper">

                            <div class="outer-instruction-container">
                                <?php if($devisEntity->devis_reglements) : ?>
                                    <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Propriétaire</th>
                                                    <th scope="col">Réference</th>
                                                    <th scope="col">Montant</th>
                                                    <th scope="col">état</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($devisEntity->devis_reglements as $reglement): ?>
                                                        <tr>
                                                            <td><?= $reglement->type_court ?></td>
                                                            <td><span data-toggle="tooltip" data-placement="top" title="<?= $reglement->created->format('H\h:i') ?>" ><?= $reglement->created->format('d/m/y') ?></span></td>
                                                            <td><?= !empty($reglement->user->full_name) ? $reglement->user->full_name : 'Automatique' ?></td>
                                                            <td>
                                                                <?php
                                                                    if(!empty($reglement->devis_factures)){
                                                                        foreach ($reglement->devis_factures as $facture) {
                                                                            echo $this->Html->link($reglement->reference,['controller'=>'DevisFactures','action'=>'view', $facture->id]).'<br>';
                                                                        }
                                                                    }else{
                                                                        echo $reglement->reference;
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td><?= $reglement->montant ?></td>
                                                            <td><i class="fa fa-circle <?= $reglement->etat ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= empty($reglement->etat) ? 'Brouillon' :$etat_reglement[$reglement->etat] ?>" ></i> <?= empty($reglement->etat) ? 'Brouillon' :$etat_reglement[$reglement->etat] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else : ?>
                                        Aucun reglements pour ce devis
                                    <?php endif; ?>
                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>

        <div class="quotation-side-section quotation-document-section">

            <div class="document-preview-wrapper quotation-preview-wrapper display hide-for-mobile">

                <?php $this->start('pdf_iframe') ?>
                    <!--<embed src="<?= $this->Url->build($devisEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf">-->

                    <!--<iframe src="https://mozilla.github.io/pdf.js/es5/web/viewer.html?file=<?= $this->Url->build($devisEntity->get('PublicPdfUrl'), true) ?>" width="100%" height="100%" class="object-pdf pdf-doc-file"></iframe>-->

                    <!--<iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $this->Url->build($devisEntity->get('PublicPdfUrl'), true) ?>" width="100%" height="100%" class="object-pdf pdf-doc-file"></iframe>-->

                    <iframe src="<?= $this->Url->build($devisEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf pdf-doc-file"></iframe>

                <?php $this->end() ?>
                <?php if (!$this->request->getQuery('test')): ?>
                    <?php echo $this->fetch('pdf_iframe') ?>
                <?php endif ?>

            </div>

            <div class="document-preview-wrapper book-preview-wrapper">
                <!--<?php if ($devisEntity->model_type == 'classik'): ?>
                    <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $documentMarketing->url_catalogue_classik ?>" width="100%" height="100%" target="_blank" class="booth-type-container"></iframe>
                <?php elseif($devisEntity->model_type == 'spherik'): ?>
                    <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $documentMarketing->url_catalogue_spherik ?>" width="100%" height="100%" target="_blank" class="booth-type-container"></iframe>
                <?php endif ?>-->

                <?php if ($devisEntity->model_type == 'classik'): ?>
                    <iframe src="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-classik.pdf" width="100%" height="100%" target="_blank" class="pdf-doc-file"></iframe>
                <?php elseif($devisEntity->model_type == 'spherik'): ?>
                    <iframe src="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-spherik.pdf" width="100%" height="100%" target="_blank" class="pdf-doc-file"></iframe>
                <?php endif ?>

            </div>

            <div class="bottom-button-block">

                <a class="quotation-button" href="<?= $this->Url->build($devisEntity->get('PublicPdfDownloadUrl')) ?>">
                    Télécharger le devis
                </a>

                <!--<div class="mobile-btn-doc-inner-full-screen">
                    <?php if ($devisEntity->model_type == 'classik'): ?>
                        <a class="quotation-button" href="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-classik.pdf" target="_blank">
                            Voir en plein écran
                        </a>
                    <?php elseif($devisEntity->model_type == 'spherik'): ?>
                        <a class="quotation-button" href="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-spherik.pdf" target="_blank">
                            Voir en plein écran
                        </a>
                    <?php endif ?>
                </div>-->

            </div>

        </div>

        <div class="quotation-side-section quotation-review-section">

            <div class="trustpilot-widget" data-locale="fr-FR" data-template-id="539adbd6dec7e10e686debee" data-businessunit-id="5c989cb5dcee3200019ec400" data-style-height="920px" data-style-width="100%" data-theme="light" data-stars="4,5" data-review-languages="fr"><a href="https://fr.trustpilot.com/review/selfizee.fr" target="_blank" rel="noopener">Trustpilot</a></div>

        </div>

    </div>

    <!--<div class="trustpilot-wrapper hide-for-mobile">

        <div class="trustpilot-widget" data-locale="fr-FR" data-template-id="53aa8912dec7e10d38f59f36" data-businessunit-id="5c989cb5dcee3200019ec400" data-style-height="130px" data-style-width="100%" data-theme="light" data-stars="4,5"> <a href="https://fr.trustpilot.com/review/selfizee.fr" target="_blank" rel="noopener">Trustpilot</a></div>

    </div>-->

    <div class="trustpilot-wrapper mobile-trustpilot-wrapper">

        <div class="trustpilot-widget" data-locale="fr-FR" data-template-id="5406e65db0d04a09e042d5fc" data-businessunit-id="5c989cb5dcee3200019ec400" data-style-height="28px" data-style-width="100%" data-theme="light"><a href="https://fr.trustpilot.com/review/selfizee.fr" target="_blank" rel="noopener">Trustpilot</a></div>

    </div>

    <div class="quotation-footer">
        Selfizee <span class="tm-icon">TM</span> est une marque de la SAS Konitys au capital de 100 000 &euro; - <a href="https://www.selfizee.fr/" target="_blank">Voir le site internet</a>
    </div>

</div>

<!-- === End of Quotation Container === -->
