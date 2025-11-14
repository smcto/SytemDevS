<?= $this->Html->css('devis/stripe_payment.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('devis/view_public.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('/scss/icons/font-awesome/css/font-awesome.css', ['block' => 'css']); ?>

<?= $this->Html->script('devis/view_public.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/redirect-to-stripe.js?'.  time(), ['block' => 'script']); ?>
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script src="https://js.stripe.com/v3/"></script>

<!-- Trustpilot widget script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End of Trustpilot widget script -->

<?php $this->assign('title', 'Facture Selfizee '.$devisFacturesEntity->indent) ?>
<?php
    $is_cgl_accepted_checked = '';
?>

<?php if ($this->request->getQuery('test')): ?>
    <?php $devisFacturesEntity->email = 'andriam.nars@gmail.com' ?>
    <?php $is_cgl_accepted_checked = 'checked' ?>
<?php endif ?>

<?php $this->start('head') ?>
    <?php echo $this->Html->meta('robots', 'noindex, nofollow'); ?>
<?php $this->end() ?>

<?php /*debug($devisFacturesEntity);*/ ?>

<!-- Vars dans js -->
<?php echo $this->Form->hidden('telecharger', ['value' => 'la facture']); ?>
<?php echo $this->Form->hidden('facture_id', ['value' => base64_encode(serialize([$devisFacturesEntity->id])), 'id' => 'facture_id']); ?>
<?php echo $this->Form->hidden('entity', ['value' => 'factures', 'id' => 'entity']); ?>
<!-- / end -->

<?php use Cake\Routing\Router; ?>
<input type="hidden" id="id_baseUrl" value="<?php echo Router::url('/', true) ; ?>"/>

<!-- === Quotation Container === -->

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
                            <?= $devisFacturesEntity->get('BorneTypeAsText') ?>
                        </div>

                        <div>
                            N° <?= $devisFacturesEntity->indent ?>
                        </div>

                        <div class="mobile-more-client-data">
                            <div>
                                <?php if (!empty($devisFacturesEntity->date_evenement)): ?>
                                    Date : <?= $devisFacturesEntity->get('DateEvenementAsHtml') ?>
                                <?php else: ?>
                                    Date : <?= $devisFacturesEntity->date_crea ?>
                                <?php endif ?>
                            </div>
                            <div>
                                Contact : <?= $devisFacturesEntity->client->get('FullName2') ?>
                            </div>
                            <?php if (!empty($devisFacturesEntity->get('LieuRetraitFormated'))): ?>
                                <?php if($devisFacturesEntity->model_type == 'spherik') : ?>
                                    Lieu événement : <?= $devisFacturesEntity->lieu_evenement ?>
                                <?php else: ?>
                                    Lieu de retrait :  <?= $devisFacturesEntity->get('LieuRetraitFormated') ?>
                                 <?php endif; ?>
                            <?php endif ?>
                        </div>

                    </div>

                </div>

                <?php if($devisFacturesEntity->is_in_sellsy) : ?>

                    <?php if ($devisFacturesEntity->get('ModelTypeSellsy')): ?>
                        <div class="booth-type-logo" id="booth-type-logo">
                            <?php if ($devisFacturesEntity->get('ModelTypeSellsy') == 'classik'): ?>
                                <?php echo $this->Html->image('devis/classik.jpg', ['alt' => 'Classik', "class" => ""]); ?>
                            <?php elseif($devisFacturesEntity->get('ModelTypeSellsy') == 'spherik'): ?>
                                <?php echo $this->Html->image('devis/spherik.jpg', ['alt' => 'Spherik', "class" => ""]); ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                <?php else : ?>
                
                    <?php if ($devisFacturesEntity->model_type): ?>
                        <div class="booth-type-logo" id="booth-type-logo">
                            <?php if ($devisFacturesEntity->model_type == 'classik'): ?>
                                <?php echo $this->Html->image('devis/classik.jpg', ['alt' => 'Classik', "class" => ""]); ?>
                            <?php elseif($devisFacturesEntity->model_type == 'spherik'): ?>
                                <?php echo $this->Html->image('devis/spherik.jpg', ['alt' => 'Spherik', "class" => ""]); ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>


                <div class="right-header-detail-wrapper hide-for-mobile">

                    <div>
                        <div>
                            <?php if (!empty($devisFacturesEntity->date_evenement)): ?>
                                Date : <?= $devisFacturesEntity->get('DateEvenementAsHtml') ?>
                            <?php else: ?>
                                Date : <?= $devisFacturesEntity->date_crea ?>
                            <?php endif ?>
                        </div>
                        <div>
                            Contact : <?= $devisFacturesEntity->client->get('FullName2') ?>
                        </div>
                        <?php if (!empty($devisFacturesEntity->get('LieuRetraitFormated'))): ?>
                            <?php if($devisFacturesEntity->model_type == 'spherik') : ?>
                                Lieu événement : <?= $devisFacturesEntity->get('LieuRetraitFormated') ?>
                            <?php else: ?>
                                Lieu de retrait :  <?= $devisFacturesEntity->get('LieuRetraitFormated') ?>
                             <?php endif; ?>
                        <?php endif ?>
                    </div>
                </div>

            </div>

        </div>

        <!--<div class="right-quotation-header-wrapper hide-for-mobile">-->

        <div class="right-quotation-header-wrapper">

            <?php if ($devisFacturesEntity->status == 'paid'): ?>

                <div class="top-right-quotation-header-wrapper">

                    <div class="booking-top-total-amount">
                        <?= $this->Number->currency($devisFacturesEntity->get('total_ttc'), 'EUR'); ?> <span class="ttc-icon">ttc</span>
                    </div>

                    <h6 class="green-sombre bolder my-auto true-bold">COMMANDE FINALISÉE</h6>
                </div>

                <div class="bottom-right-quotation-header-wrapper reduce-margin">
                    Réservation finalisée : règlement complet
                </div>

            <?php elseif ($devisFacturesEntity->get('IsPartiallyPaid')): ?>

                <div class="top-right-quotation-header-wrapper">

                    <div class="booking-top-total-amount">
                        <?= $this->Number->currency($devisFacturesEntity->get('total_ttc'), 'EUR'); ?> <span class="ttc-icon">ttc</span>
                    </div>

                    <h6 class="warning-sombre bolder my-auto true-bold">COMMANDE RÉSERVÉE</h6>
                </div>

                <div class="bottom-right-quotation-header-wrapper reduce-margin">
                    Réservation effectuée : en attente du règlement du solde
                </div>

            <?php else: /* si aucun paiement */ ?>

                <div class="top-right-quotation-header-wrapper">

                    <div class="booking-top-total-amount">
                        <?= $this->Number->currency($devisFacturesEntity->get('total_ttc'), 'EUR'); ?> <span class="ttc-icon">ttc</span>
                    </div>

                    <div class="header-booking-button-block">

                            <div class="quotation-button" id="btn-header-booking-borne">

                                <div class="outer-top-text">

                                    <div class="top-text">
                                        Réserver ma borne !
                                    </div>

                                    <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

                                </div>

                                <div class="outer-bottom-text">
                                    <?php if (count($devisFacturesEntity->devis_factures_echeances) == 0 || $isFirstFindedEcheanceSameAsTotalDevisAmount): ?>
                                        <p>
                                            <span class="bold">En réglant aujourd'hui la commande</span>
                                        </p>
                                    <?php else: ?>
                                        <p>
                                            En réglant aujourd'hui l'acompte de <?= $this->Number->currency($devisFacturesEntity->get('AccompteFormated'), 'EUR') ?>
                                        </p>
                                    <?php endif ?>
                                </div>

                            </div>

                    </div>

                </div>

                <div class="bottom-right-quotation-header-wrapper">
                    Réservation toujours disponible : en attente de votre validation
                </div>

            <?php endif ?>

        </div>

    </div>

    
    <div class="header-option-wrapper hide-for-mobile">

        <div class="inner-header-option-wrapper">

            <div class="option-block option-block-border quotation-option-block <?= $devisFacturesEntity->get('IsPartiallyPaid') || $devisFacturesEntity->status == 'paid' ? '' : 'current'; /*je suis sur une facture pro, et on affiche le bloc de paiement direct,*/ ?>">

                <div class="text top-text">
                    Votre facture
                </div>

                <!--<div class="text middle-text">
                    Votre devis personnalisé
                </div>-->

                <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

            </div>

            <?php if($devisFacturesEntity->is_in_sellsy) : ?>
            
                <?php if ($devisFacturesEntity->get('ModelTypeSellsy') != null): /*si y'a pas de borne liée au modèle , ne pas afficher l'onglet brochure*/ ?>
                    <div class="option-block option-block-border presentation-book-block">

                        <div class="text top-text">
                            Brochure
                        </div>

                        <!--<div class="text middle-text">
                            Détails de la prestation
                        </div>-->

                        <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

                    </div>
                <?php endif ?>
            <?php else : ?>
                <?php if ($devisFacturesEntity->model_type != null): /*si y'a pas de borne liée au modèle , ne pas afficher l'onglet brochure*/ ?>
                    <div class="option-block option-block-border presentation-book-block">

                        <div class="text top-text">
                            Brochure
                        </div>

                        <!--<div class="text middle-text">
                            Détails de la prestation
                        </div>-->

                        <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

                    </div>
                <?php endif ?>
            <?php endif ?>

            <div class="option-block option-block-border client-review-block">

                <div class="text top-text">
                    Avis clients
                </div>

                <!--<div class="text middle-text">
                    Retrouvez les avis de nos clients
                </div>-->

                <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

            </div>

            <div class="option-block booking-option-block <?= !$devisFacturesEntity->get('IsPartiallyPaid') || $devisFacturesEntity->status == 'paid' ? '' : 'current'; /*je suis sur une facture pro, et on affiche le bloc de paiement direct,*/ ?>">

                <div class="text top-text">
                    Réservation
                </div>

                <!--<div class="text middle-text">
                    Votre devis personnalisé
                </div>-->

                <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

            </div>

        </div>

    </div>

    <div class="mobile-option-menu-container">

        <div class="mobile-option-block mobile-quotation-block current">
            <div class="text">
                Votre facture
            </div>
        </div>

        <?php if ($devisFacturesEntity->is_in_sellsy) : ?>
        
            <div class="mobile-option-block mobile-presentation-block">
                <div class="text">
                    Brochure
                </div>
            </div>
        <?php else : ?>
            <?php if ($devisFacturesEntity->model_type != null): /*si y'a pas de borne liée au modèle , ne pas afficher l'onglet brochure*/ ?>

                <div class="mobile-option-block mobile-presentation-block">
                    <div class="text">
                        Brochure
                    </div>
                </div>

            <?php endif ?>
        <?php endif ?>

        <div class="mobile-option-block mobile-booking-block">
            <div class="text">
                Réservation
            </div>
        </div>

    </div>

    <div class="quotation-main-content-container">

        <div class="quotation-side-section quotation-detail-section">

            <div class="inner-quotation-detail-section">

                <div class="mobile-document-preview-wrapper">

                    <?php $this->start('pdf_iframe') ?>
                        <!--<embed src="<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf">-->

                        <!--<iframe src="https://mozilla.github.io/pdf.js/es5/web/viewer.html?file=<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl'), true) ?>&download=false&print=false&openfile=false" width="100%" height="100%" target="_blank"></iframe>-->

                        <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl'), true) ?>&download=false&print=false&openfile=false" width="100%" height="100%" target="_blank"></iframe>

                    <?php $this->end() ?>
                    <?php if (!$this->request->getQuery('test')): ?>
                        <?php echo $this->fetch('pdf_iframe') ?>
                    <?php endif ?>

                </div>

                <div class="booking-step-container booking-step-one <?= $devisFacturesEntity->get('IsPartiallyPaid') || $devisFacturesEntity->status == 'paid' || $devisFacturesEntity->get('ClientType') == 'corporation' ? 'hide-step' : ''; /*je suis sur une facture pro, et on affiche le bloc de paiement direct,*/ ?>">

                    <div class="booking-detail-container">

                        <div class="booking-title">
                            L' essentiel de la proposition :
                        </div>

                        <div class="booking-instruction-wrapper">

                            <div class="outer-instruction-container">

                                <div class="instruction-block">

                                    <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                    <div class="indication-text">

                                        <p class="bold">
                                            Impression professionnelle très rapide en 8 secondes !
                                        </p>
                                        <p>
                                            Certains confrères proposent des bornes qui impriment en 45 s. Le rendu photo de ces imprimantes est peu qualitatif et il faut recharger très souvent la bobine de papier.
                                        </p>
                                        <p>
                                            Chez Selfizee, nous voulons que le souvenir imprimé de votre événement soit exceptionnel !
                                        </p>

                                    </div>

                                </div>

                                <div class="instruction-block">

                                    <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                    <div class="indication-text">

                                        <p class="bold">
                                            Personnalisation de la photo dédiée selon vos logos, graphisme et textes
                                        </p>
                                        <p>
                                            1 à 4 poses par tirage c’est vous qui choisissez et le changement de format n’est donc pas en option chez nous. Nous réalisons pour vous la personnalisation de la photo à partir d’un large choix de modèles d’inspiration.
                                        </p>

                                    </div>

                                </div>

                                <div class="instruction-block">

                                    <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                    <div class="indication-text">

                                        <p class="bold">
                                            400 impressions 10x15 cm (ou 800 impressions 5x15 cm) sans recharge
                                        </p>
                                        <p>
                                            Avec notre borne, vous allez offrir un souvenir marquant et palpable à vos invités.
                                        </p>
                                        <p>
                                            La qualité de notre imprimante vous assure une longue durée dans le temps des couleurs sur vos photos.
                                        </p>

                                    </div>

                                </div>

                                <div class="instruction-block">

                                    <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                    <div class="indication-text">

                                        <p class="bold">
                                            Shooting photo numérique en illimité
                                        </p>
                                        <p>
                                            L'intégralité des photos numériques seront accessibles sur votre galerie souvenir privée. La galerie est consultable par vous et vos invités et vous pourrez y télécharger l’ensemble des photos pour une réimpression future. Vos invités pourront même vous laisser un message sur l’onglet « Livre d'Or » de la galerie.
                                        </p>

                                    </div>

                                </div>

                                <div class="instruction-block">

                                    <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                    <div class="indication-text">

                                        <p class="bold">
                                            Hotline téléphonique
                                        </p>
                                        <p>
                                            Nous vous assistons, de l’installation à l’utilisation de la borne, afin de vous rassurer et de vous assurer un événement réussi.
                                        </p>

                                    </div>

                                </div>

                                <div class="instruction-block">

                                    <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                    <div class="indication-text">

                                        <p class="bold">
                                            Location pour le week-end complet
                                        </p>
                                        <p>
                                            Profitez pleinement de la borne pendant tout votre événement. Au lieu de vous la louer que le samedi, nous préférons vous offrir la location du dimanche en l’incluant dans le tarif.
                                        </p>

                                    </div>

                                </div>

                                <div class="instruction-block">

                                    <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                    <div class="indication-text">

                                        <p class="bold">
                                            Fabrication française
                                        </p>
                                        <p>
                                            Nos bornes Selfizee sont imaginées et fabriquées en Bretagne/France et nous créons donc des emplois sur le territoire.
                                        </p>

                                    </div>

                                </div>

                            </div>

                            <div class="mobile-bottom-button-block">

                                <a class="quotation-button" target="_blank" href="<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl'), true) ?>">
                                    Voir la facture en plein écran
                                </a>

                            </div>

                            <div class="bottom-indication-wrap">
                                <?php if (count($devisFacturesEntity->devis_factures_echeances) == 0 || $isFirstFindedEcheanceSameAsTotalDevisAmount): ?>
                                    <p>
                                        <span class="bold">Réglez votre commande  aujourd'hui pour bloquer votre date !</span>
                                    </p>
                                <?php else: ?>
                                    <p class="sub-top-text bold">Réglez uniquement un acompte de <?= $this->Number->currency($devisFacturesEntity->get('AccompteFormated'), 'EUR') ?> aujourd'hui pour bloquer votre date !</p>
                                    <p>Notre équipe prendre contact avec vous par la suite pour la mise en place de notre animation.
                                    </p>
                                <?php endif ?>
                            </div>

                        </div>

                    </div>

                    <div class="outer-bottom-button-block">

                        <div class="bottom-button-block">

                            <div class="quotation-button" id="btn-bottom-booking-borne">
                                Réserver la borne Selfizee !
                            </div>

                        </div>

                        <div class="stripe-payment-method-wrap hide-for-mobile">
                            <?php echo $this->Html->image('devis/stripe.png', ['alt' => 'Stripe', "class" => ""]); ?>
                        </div>

                    </div>

                </div>

                <div class="booking-step-container booking-step-two  <?= !($devisFacturesEntity->get('IsPartiallyPaid') || $devisFacturesEntity->status == 'paid' || $devisFacturesEntity->get('ClientType') == 'corporation') ? 'hide-step' : ''; /*je suis sur une facture pro, et on affiche le bloc de paiement direct,*/ ?>">

                    <div class="booking-detail-container">

                        <div class="outer-booking-title">

                            <svg viewBox="0 0 512 512" class="btn-booking-back"><path d="M256 0C114.618 0 0 114.618 0 256s114.618 256 256 256 256-114.618 256-256S397.382 0 256 0zm0 469.333c-117.818 0-213.333-95.515-213.333-213.333S138.182 42.667 256 42.667 469.333 138.182 469.333 256 373.818 469.333 256 469.333z"/><path d="M401.067 268.761c.227-.303.462-.6.673-.915.203-.304.379-.619.565-.93.171-.286.35-.565.508-.86.17-.317.313-.643.466-.967.145-.308.299-.61.43-.925.13-.314.235-.635.349-.953.122-.338.251-.672.356-1.018.096-.318.167-.642.248-.964.089-.353.188-.701.259-1.061.074-.372.117-.748.171-1.122.045-.314.105-.622.136-.941.138-1.4.138-2.81 0-4.21-.031-.318-.091-.627-.136-.941-.054-.375-.097-.75-.171-1.122-.071-.359-.17-.708-.259-1.061-.081-.322-.152-.645-.248-.964-.105-.346-.234-.68-.356-1.018-.114-.318-.219-.639-.349-.953-.131-.315-.284-.618-.43-.925-.153-.324-.296-.65-.466-.967-.158-.294-.337-.574-.508-.86-.186-.311-.362-.626-.565-.93-.211-.315-.446-.612-.673-.915-.19-.254-.366-.514-.569-.761-.443-.54-.91-1.059-1.403-1.552l-.01-.011-85.333-85.333c-8.331-8.331-21.839-8.331-30.17 0s-8.331 21.839 0 30.17l48.915 48.915H128c-11.782 0-21.333 9.551-21.333 21.333s9.551 21.333 21.333 21.333h204.497l-48.915 48.915c-8.331 8.331-8.331 21.839 0 30.17 8.331 8.331 21.839 8.331 30.17 0l85.333-85.333.01-.011c.493-.494.96-1.012 1.403-1.552.203-.247.379-.508.569-.761z"/></svg>

                            <div class="booking-title">
                                Réservation et règlement
                            </div>

                        </div>

                        <div class="booking-instruction-wrapper">

                            <?php if ($devisFacturesEntity->status == 'paid'): ?>
                                <p class="bold">
                                    Votre commande est finalisée !
                                </p>
                                <p >
                                    Récapitulatif de vos règlements :
                                </p>
                            <?php elseif ($devisFacturesEntity->get('IsPartiallyPaid')): ?>
                                <p class="bold">
                                    Réglez la suite de la commande pour finaliser votre réservation :
                                </p>
                            <?php else: ?>
                                <p class="bold">
                                    Pour valider votre réservation et bloquer au plus vite la borne pour votre date :
                                </p>
                                <?php if (count($devisFacturesEntity->devis_factures_echeances) == 0 || $isFirstFindedEcheanceSameAsTotalDevisAmount): ?>
                                    <p>
                                        Veuillez régler la commande via le module ci-dessous
                                    </p>
                                <?php else: ?>
                                    <p>
                                        Veuillez régler l'acompte minimum de 30% via le module ci-dessous ou, si vous souhaitez, réglez dès à présent l'intégralité.
                                    </p>
                                <?php endif ?>
                                <p>
                                    Un email de confirmation vous sera immédiatement envoyé et notre équipe prendra contact avec vous pour la suite de la mise en place.
                                </p>
                            <?php endif ?>

                        </div>

                        <?php if ($devisFacturesEntity->status != 'paid'): ?>

                            <div class="bottom-payment-choice-wrapper mt-4 mb-0">

                                <?php if (!empty($devisFacturesEntity->devis_factures_echeances)): ?>
                                    <p>Choisissez une échéance à régler :</p>
                                <?php endif ?>

                            </div>

                        <?php endif ?>

                        <div class="booking-detail-list-wrapper">

                            <?php if ($paiementAutresQueCartes->count() > 0): ?>
                                <?php foreach ($paiementAutresQueCartes as $key => $paiementAutre): ?>
                                    <div class="booking-block echeance-container">
                                        <label class="inner-booking-block">
                                            <div class="outer-booking-info-wrap">
                                                <div class="booking-info-wrap top-booking-info-wrap">
                                                    <div class="booking-type to-pay-type bold">
                                                        <label for="echeance-<?= $paiementAutre->id ?>" class="text-secondary">Règlement par <?= mb_strtolower($paiementAutre->moyen_reglement->name) ?> effectué le <?= $paiementAutre->date ?></label>
                                                    </div>
                                                    <div class="booking-amount medium-bold darker-gray-text">
                                                        <span class="amount-pay"> <?= $this->Number->currency($paiementAutre->montant, 'EUR'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>

                            <?php $findedFirstEcheanceUnpaid = collection($devisFacturesEntity->devis_factures_echeances)->match(['is_payed' => 0])->first() ?>

                            <?php if (!($devisFacturesEntity->get('NbEcheancePaid') == 0 && $devisFacturesEntity->status == 'paid')): /*si aucune echéance payée mais directement sur paiement totalité, on n'affiche pas*/ ?>
                                <?php foreach ($devisFacturesEntity->devis_factures_echeances as $key => $echeance): ?>

                                    <?php if ($key == 0): /* 1ère echeance = accompte */ ?>
                                        <?php if (!$isFirstFindedEcheanceSameAsTotalDevisAmount): ?>
                                            <div class="booking-block echeance-container">
                                                <label class="inner-booking-block">
                                                    <div class="outer-booking-info-wrap">
                                                        <div class="booking-info-wrap top-booking-info-wrap">
                                                            <div class="booking-type to-pay-type bold">

                                                                <?php if ($echeance->is_payed == 0): ?>
                                                                    <?= $this->Form->control('echeance', ['type' => 'radio', 'default' => $echeance->id, 'options' => [[ 'value' => $echeance->id, 'text' => false]], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}']]) ?>
                                                                    <label for="echeance-<?= $echeance->id ?>" class="text-success">Acompte de réservation</label>
                                                                <?php else: ?>
                                                                    <label for="echeance-<?= $echeance->id ?>" class="text-secondary">Acompte réglé le <?= $echeance->date_paiement ?></label>
                                                                <?php endif ?>

                                                            </div>
                                                            <div class="booking-amount medium-bold darker-gray-text">
                                                                <span class="amount-pay"> <?= $this->Number->currency($echeance->montant, 'EUR'); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="booking-info-wrap">
                                                            <?php if ($echeance->is_payed == 0): ?>
                                                                <div class="medium-bold darker-gray-text">
                                                                    À régler maintenant pour valider la commande. <br>
                                                                    Le solde sera à régler avant le <?= @$devisFacturesEntity->devis_factures_echeances[$key+1]->date ?>.
                                                                </div>
                                                            <?php endif ?>

                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <div class="booking-block echeance-container">
                                            <label class="inner-booking-block">
                                                <div class="outer-booking-info-wrap">
                                                    <div class="booking-info-wrap top-booking-info-wrap">
                                                        <div class="booking-type to-pay-type bold">

                                                            <?php if ($echeance->is_payed == 0): ?>
                                                                <?= $this->Form->control('echeance', ['type' => 'radio', 'default' => $findedFirstEcheanceUnpaid->id, 'options' => [[ 'value' => $echeance->id, 'text' => false]], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}']]) ?>
                                                                <label for="echeance-<?= $echeance->id ?>" class="text-success"><?= $key+1 ?>ème règlement</label>
                                                            <?php else: ?>
                                                                <label for="echeance-<?= $echeance->id ?>" class="text-secondary"><?= $key+1 ?>ème règlement effectué le <?= $echeance->date_paiement ?></label>
                                                            <?php endif ?>
                                                        </div>

                                                        <div class="booking-amount medium-bold darker-gray-text">
                                                            <span class="amount-pay"> <?= $this->Number->currency($echeance->montant, 'EUR'); ?></span>
                                                        </div>
                                                    </div>
                                                    <?php if ($echeance->is_payed != 'paid'): ?>
                                                        <div class="booking-info-wrap">
                                                            <div class="medium-bold darker-gray-text">
                                                                <?= $echeance->date? "À régler avant le " . $echeance->date : "" ?>.
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            </label>
                                        </div>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>

                            <?php if (!$isLastFindedEcheanceSameAsTotalDevisAmount || $devisFacturesEntity->get('NbEcheancePaid') == 0): /* si la derniere echeance à payer = le solde , ne pas rajouter une ligne supplémentaire "régler la totalité du document", car ça revient au même.*/ ?>
                                <div class="booking-block echeance-container">

                                    <label class="inner-booking-block">
                                        <div class="outer-booking-info-wrap">

                                            <?php if ($devisFacturesEntity->status != 'paid'): ?>
                                                
                                                <div class="booking-info-wrap top-booking-info-wrap mt-2">
                                                    <div class="booking-type to-pay-type bold">
                                                        <?php if ($devisFacturesEntity->status != 'paid'): ?>
                                                            <?= $this->Form->control('echeance', ['type' => 'radio', 'default' => (empty($devisFacturesEntity->devis_factures_echeances) || $isFirstFindedEcheanceSameAsTotalDevisAmount ? 'total_remaining' : ''), 'options' => [[ 'value' => 'total_remaining', 'text' => false]], 'label' => false,'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}'  ]]) ?>
                                                            <?php if (count($devisFacturesEntity->facture_reglements) > 0): ?>
                                                                <label for="echeance-total_remaining">Reste à solder</label>
                                                            <?php else: ?>
                                                                <label for="echeance-total_remaining">Totalité du document</label>
                                                            <?php endif ?>
                                                        <?php endif ?>
                                                    </div>
                                                    <div class="booking-amount medium-bold darker-gray-text">
                                                        <span class="amount-pay"> <?= $this->Number->currency($devisFacturesEntity->get('ResteEcheanceImpayee'), 'EUR'); ?></span>
                                                    </div>
                                                </div>

                                            <?php else: ?>

                                                <?php if (
                                                    (!empty($this->devis_factures_echeances) && $devisFacturesEntity->montant_total_paid != $lastFindEcheance->montant) || /* cas echeances : et prendre en compte aussi du cas payé */ 
                                                    $devisFacturesEntity->delai_reglements != 'echeances' || /* Afficher si le delai different*/
                                                    $devisFacturesEntity->get('NbEcheancePaid') == 0 /*cas : si aucune echéance payée mais directement sur paiement totalité, on n'affiche*/
                                                ): ?>
                                                    <?php $factureReglement = collection($devisFacturesEntity->facture_reglements)->first() ?>
                                                    <div class="booking-info-wrap">
                                                        <div class="medium-bold reglement-complet">
                                                            <label for="echeance-total_remaining">Règlement complet </label>
                                                        </div>
                                                        <div class="booking-amount medium-bold darker-gray-text">
                                                            <span class="amount-pay"></span>
                                                        </div>
                                                    </div>
                                                <?php endif ?>
                                                
                                            <?php endif ?>
                                        </div>
                                    </label>

                                </div>
                            <?php endif ?>
                        </div>
                    </div>



                    <?php if ($devisFacturesEntity->status != 'paid'): ?>
                        <?php if (!empty($devisFacturesEntity->model_type)): ?>
                            <div class="booking-condition-block">

                                <?php echo $this->Form->control('is_cgl_accepted', ['checked' => $is_cgl_accepted_checked, 'type' => 'checkbox', 'label' => '']); ?>

                                <label for="is-cgl-accepted" class="booking-gen-conditions-label medium-bold darker-gray-text">
                                    J'accepte les <span class="booking-condition-link">Conditions Générales de Location (CGL)</span>.
                                </label>

                                <p class="cgl-err text-danger d-none">
                                    Vous devez accepter les Conditions Générales de Location avant de procéder au paiement.
                                </p>

                            </div>
                        <?php endif ?>


                        <div class="bottom-button-block">

                            <button type="button" class="quotation-button <?php $devisFacturesEntity->status != 'paid' ?: 'd-none' ?>" id="pay">
                                <?php if ($devisFacturesEntity->status == 'paid' || $devisFacturesEntity->get('IsPartiallyPaid') ) { ?>
                                    Régler par carte bancaire
                                <?php } else { ?>
                                    Réserver et payer par carte bancaire
                                <?php } ?>
                            </button>

                        </div>
                    <?php else: ?>
                        <div class="booking-condition-block">

                            <label for="is-cgl-accepted" class="booking-gen-conditions-label medium-bold darker-gray-text mx-auto">
                                <span class="booking-condition-link">Voir les Conditions Générales de Location (CGL)</span>
                            </label>

                        </div>
                    <?php endif ?>

                    <div class="stripe-payment-method-wrap">
                        <?php echo $this->Html->image('devis/stripe.png', ['alt' => 'Stripe', "class" => ""]); ?>
                    </div>

                </div>

            </div>

        </div>

        <div class="quotation-side-section quotation-document-section">

            <div class="document-preview-wrapper quotation-preview-wrapper display hide-for-mobile">

                <?php $this->start('pdf_iframe') ?>
                    <!--<embed src="<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf">-->

                    <!--<iframe src="https://mozilla.github.io/pdf.js/es5/web/viewer.html?file=<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl'), true) ?>" width="100%" height="100%" class="object-pdf pdf-doc-file"></iframe>-->

                    <!--<iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl'), true) ?>" width="100%" height="100%" class="object-pdf pdf-doc-file"></iframe>-->

                    <iframe src="<?= $this->Url->build($devisFacturesEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf pdf-doc-file"></iframe>

                <?php $this->end() ?>
                <?php if (!$this->request->getQuery('test')): ?>
                    <?php echo $this->fetch('pdf_iframe') ?>
                <?php endif ?>

            </div>

            <div class="document-preview-wrapper book-preview-wrapper">
                
                <?php if($devisFacturesEntity->is_in_sellsy) : ?>
                    <!--<?php if ($devisFacturesEntity->get('ModelTypeSellsy') == 'classik'): ?>
                    <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $documentMarketing->url_catalogue_classik ?>" width="100%" height="100%" target="_blank" class="booth-type-container"></iframe>
                    <?php elseif($devisFacturesEntity->get('ModelTypeSellsy') == 'spherik'): ?>
                        <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $documentMarketing->url_catalogue_spherik ?>" width="100%" height="100%" target="_blank" class="booth-type-container"></iframe>
                    <?php endif ?>-->

                    <?php if ($devisFacturesEntity->get('ModelTypeSellsy') == 'classik'): ?>
                        <iframe src="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-classik.pdf" width="100%" height="100%" target="_blank" class="pdf-doc-file"></iframe>
                    <?php elseif($devisFacturesEntity->get('ModelTypeSellsy') == 'spherik'): ?>
                        <iframe src="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-spherik.pdf" width="100%" height="100%" target="_blank" class="pdf-doc-file"></iframe>
                    <?php endif ?>
                <?php else : ?>
                    <!--<?php if ($devisFacturesEntity->model_type == 'classik'): ?>
                        <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $documentMarketing->url_catalogue_classik ?>" width="100%" height="100%" target="_blank" class="booth-type-container"></iframe>
                    <?php elseif($devisFacturesEntity->model_type == 'spherik'): ?>
                        <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $documentMarketing->url_catalogue_spherik ?>" width="100%" height="100%" target="_blank" class="booth-type-container"></iframe>
                    <?php endif ?>-->

                    <?php if ($devisFacturesEntity->model_type == 'classik'): ?>
                        <iframe src="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-classik.pdf" width="100%" height="100%" target="_blank" class="pdf-doc-file"></iframe>
                    <?php elseif($devisFacturesEntity->model_type == 'spherik'): ?>
                        <iframe src="https://selfizee.fr/pdfjs/web/viewer.html?file=https://selfizee.fr/docs/brochure-selfizee-spherik.pdf" width="100%" height="100%" target="_blank" class="pdf-doc-file"></iframe>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <div class="bottom-button-block">

                <a class="quotation-button" href="<?= $this->Url->build($devisFacturesEntity->get('PublicPdfDownloadUrl')) ?>">
                    Télécharger la facture
                </a>
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




<!-- === Condition Popup Container === -->

<div class="popup-container condition-popup-container">

    <div class="outer-popup-container">

        <div class="popup-close-wrap">

            <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

        </div>

        <div class="inner-popup-container customized-scrollbar">

            <div class="col-md-12 m-t-15">

                <?php if($devisFacturesEntity->is_in_sellsy) : ?>
                
                    <?php
                        if($devisFacturesEntity->get('ModelTypeSellsy') == 'classik'){
                            echo $documentMarketing->cgl_classik_part;
                        }elseif($devisFacturesEntity->get('ModelTypeSellsy') == 'spherik'){
                            echo $documentMarketing->cgl_spherik_part;
                        }
                    ?>
                <?php else : ?>
                    <?php if ($devisFacturesEntity->devi): ?>
                        <?php
                            if($devisFacturesEntity->devi->model_type == 'classik'){
                                echo $documentMarketing->cgl_classik_part;
                            }elseif($devisFacturesEntity->devi->model_type == 'spherik'){
                                echo $documentMarketing->cgl_spherik_part;
                            }
                        ?>
                    <?php endif ?>
                <?php endif ?>
            </div>

        </div>

    </div>

</div>

<!-- === End of Condition Popup Container === -->




<!-- === Payment Popup Container === -->

<div class="popup-container payment-popup-container container-stripe-form" id="stripe-container">

    <div class="outer-popup-container">

        <div class="popup-close-wrap">

            <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

        </div>

        <div class="inner-popup-container stripe-modal customized-scrollbar stripe-modal" data-client-public="<?= $stripeApiKeyPublic ?>">

            <?php $param =  base64_encode(serialize([$devisFacturesEntity->id])) ?>
            <?= $this->Form->create($devisFacturesEntity, ['url' => ['controller' => 'devisFactures', 'action' => 'makePayment', $param, 'lang' => 'fr'], 'class' => 'form-payment']); ?>

            <div class="outer-payment-detail-container">

                <div class="side-payment-popup-wrapper">

                    <div class="popup-indicaton-label payment-popup-block-margin">
                        Votre réservation
                    </div>

                    <div class="side-top-detail-wrapper">

                        <div class="payment-popup-block-margin">
                            <div class="side-label">
                                 Montant
                            </div>
                            <div class="side-value">
                                <span class="show-amount"></span>
                            </div>
                        </div>

                        <div>
                            <div class="side-label">
                                N&deg; commande
                            </div>
                            <div class="side-value">
                                <?= $devisFacturesEntity->indent ?>
                            </div>
                        </div>

                    </div>

                    <div class="side-security-info">
                        100% sécurisé
                    </div>

                    <div class="side-security-description">
                        <p>
                            Vos données bancaires sont sécurisées selon les dernières normes via la plateforme sécurisée Stripe.
                        </p>
                        <p>
                            Vos données ne sont pas sauvegardées.
                        </p>
                    </div>

                    <div class="popup-stripe-logo-wrap">
                        <i class="fa fa-lock"></i><span class="logo-text">Stripe</span>
                    </div>

                </div>

                <div class="main-payment-popup-wraper">

                    <div class="popup-selfizee-logo payment-popup-block-margin">
                        <?php echo $this->Html->image('logo-selfizee.png', ['alt' => 'Logo', "class" => ""]); ?>
                    </div>

                    <!--<div class="popup-booking-number payment-popup-block-margin">
                        <?= $devisFacturesEntity->indent ?>
                    </div>-->

                    <div class="popup-indicaton-label payment-popup-block-margin">
                        Votre email
                    </div>

                    <div class="payment-popup-block-margin">
                        <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control form-control-sm email', 'required', 'placeholder' => 'email@gmail.com']); ?>
                    </div>

                    <div class="popup-indicaton-label payment-popup-block-margin">
                        Vos informations de paiement
                    </div>

                    <div class="payment-popup-block-margin">

                        <label for="email" class="control-label">Votre numéro de carte</label>
                        <div class="stripe-form field-with-icon">
                            <span class="field-icon fa fa-credit-card"></span>
                            <div id="card-number"></div>
                        </div>

                    </div>

                    <div class="two-col-data-wrapper">

                        <div class="popup-side-column">

                            <label for="email" class="control-label">Date d'expiration</label>
                            <div class="stripe-form field-with-icon">
                                <span class="field-icon fa fa-calendar"></span>
                                <div id="card-expiry"></div>
                            </div>

                        </div>

                        <div class="popup-side-column">

                            <label for="email" class="control-label">Cryptogramme de sécurité</label>
                            <div class="stripe-form field-with-icon">
                                <span class="field-icon fa fa-lock"></span>
                                <div id="card-cvc"></div>
                            </div>

                        </div>

                    </div>

                    <div id="card-errors" role="alert" class="text-danger"></div>

                    <div class="payment-button-wrapper">

                        <div class="stipe-logo-wrap hide-for-mobile">
                            <?php echo $this->Html->image('devis/stripe.png', ['alt' => 'Stripe', "class" => ""]); ?>
                        </div>

                        <div class="popup-submit-wrapper">

                            <div class="popup-cancel-button cancel-payment">
                                Annuler
                            </div>

                            <div class="popup-submit-wrap">

                                <button type="submit" class="validate">Payer <span class="show-amount"></span></button>

                            </div>

                        </div>

                        <div class="mobile-stripe-logo-wrap">
                            <?php echo $this->Html->image('devis/stripe.png', ['alt' => 'Stripe', "class" => ""]); ?>
                        </div>

                    </div>

                    <!--<div class="popup-stripe-logo-wrap mobile-stripe-logo-wrap">
                        <i class="fa fa-lock"></i><span class="logo-text">Stripe</span>
                    </div>-->

                </div>

            </div>

            <?= $this->form->end() ?>

        </div>

    </div>

</div>


<!-- === End of Payment Popup Container === -->
















