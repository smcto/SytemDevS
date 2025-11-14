<?= $this->Html->css('devis/stripe_payment.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('devis/view_public.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('/scss/icons/font-awesome/css/font-awesome.css', ['block' => 'css']); ?>

<?= $this->Html->script('devis/stripe_func.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/stripe_payment.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/view_public.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/show-stripe-popup.js?'.  time(), ['block' => 'script']); ?>

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
<!-- / end -->

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

            <?php if ($devisEntity->status == 'paid'): ?>

                <div class="top-right-quotation-header-wrapper">

                    <div class="booking-top-total-amount">
                        <?= $this->Number->currency($devisEntity->get('total_ht'), 'EUR'); ?> <span class="ttc-icon">ht</span>
                    </div>

                    <h6 class="green-sombre bolder my-auto true-bold">Réglé</h6>
                </div>

            <?php else: /* si aucun paiement */ ?>

                <div class="top-right-quotation-header-wrapper">

                    <div class="booking-top-total-amount">
                        <?= $this->Number->currency($devisEntity->get('total_ht'), 'EUR'); ?> <span class="ttc-icon">ht</span>
                    </div>

                    <h6 class="warning-sombre bolder my-auto true-bold">En attente de votre règlement</h6>
                </div>

            <?php endif ?>

        </div>

    </div>

    <div class="header-option-wrapper hide-for-mobile">

        <div class="inner-header-option-wrapper">

            <div class="option-block booking-option-block current">

                <div class="text top-text">
                    Votre devis
                </div>

                <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

            </div>

        </div>

    </div>

    <div class="mobile-option-menu-container">

        <div class="mobile-option-block mobile-quotation-block current">
            <div class="text">
                Votre devis
            </div>
        </div>

    </div>

    <div class="quotation-main-content-container">

        <div class="quotation-side-section quotation-detail-section">

            <div class="inner-quotation-detail-section">

                <div class="mobile-document-preview-wrapper">

                    <?php $this->start('pdf_iframe') ?>
                        <!--<embed src="<?= $this->Url->build($devisEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf">-->

                        <!--<iframe src="https://mozilla.github.io/pdf.js/es5/web/viewer.html?file=<?= $this->Url->build($devisEntity->get('PublicPdfUrl'), true) ?>&download=false&print=false&openfile=false" width="100%" height="100%" target="_blank"></iframe>-->

                        <iframe src="https://mozilla.github.io/pdf.js/web/viewer.html?file=<?= $this->Url->build($devisEntity->get('PublicPdfUrl'), true) ?>&download=false&print=false&openfile=false" width="100%" height="100%" target="_blank"></iframe>

                    <?php $this->end() ?>
                    <?php if (!$this->request->getQuery('test')): ?>
                        <?php echo $this->fetch('pdf_iframe') ?>
                    <?php endif ?>

                </div>


                <div class="booking-step-container booking-step-two">

                    <div class="booking-detail-container">

                        <div class="outer-booking-title">

                            <div class="booking-title">
                                Réservation et règlement
                            </div>

                        </div>

                        <div class="booking-instruction-wrapper">

                            <?php if ($devisEntity->status == 'paid'): ?>
                                <p class="thicker-bold larger-text">
                                    Votre commande est finalisée !
                                </p>
                                <p >
                                    Récapitulatif de vos règlements :
                                </p>
                            <?php elseif ($devisEntity->get('IsPartiallyPaid')): ?>
                                <p class="thicker-bold larger-text">
                                    Réglez la suite de la commande pour finaliser votre réservation :
                                </p>
                            <?php else: ?>
                                <p class="thicker-bold larger-text">
                                    Pour valider votre réservation et bloquer au plus vite la borne pour votre date :
                                </p>
                                <?php if (count($devisEntity->devis_echeances) == 0 || $isFirstFindedEcheanceSameAsTotalDevisAmount): ?>
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

                        
                        <?php if ($devisEntity->status != 'paid'): ?>

                            <div class="bottom-payment-choice-wrapper mt-4 mb-0">

                                <?php if (!empty($devisEntity->devis_echeances)): ?>
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

                            <?php $findedFirstEcheanceUnpaid = collection($devisEntity->devis_echeances)->match(['is_payed' => 0])->first() ?>

                            <?php if (!($devisEntity->get('NbEcheancePaid') == 0 && $devisEntity->status == 'paid')): /*si aucune echéance payée mais directement sur paiement totalité, on n'affiche pas*/ ?>
                                <?php foreach ($devisEntity->devis_echeances as $key => $echeance): ?>
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
                                                                <span class="amount-pay"> <?= $this->Number->currency($echeance->get('EcheanceSansTva'), 'EUR'); ?> HT</span>
                                                            </div>
                                                        </div>
                                                        <div class="booking-info-wrap">
                                                            <?php if ($echeance->is_payed == 0): ?>
                                                                <div class="medium-bold darker-gray-text">
                                                                    À régler maintenant pour valider la commande. <br>
                                                                    Le solde sera à régler avant le <?= @$devisEntity->devis_echeances[$key+1]->date ?>.
                                                                </div>

                                                                <div class="booking-amount medium-bold darker-gray-text">
                                                                    <span class="amount-pay"> <?= $this->Number->currency($echeance->montant, 'EUR'); ?> TTC</span>
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
                                                                <label for="echeance-<?= $echeance->id ?>" class="text-success"><?= $key+1 == '1' ? '1er' : ($key+1).'ème' ?> règlement</label>
                                                            <?php else: ?>
                                                                <label for="echeance-<?= $echeance->id ?>" class="text-secondary"><?= $key+1 ?>ème règlement effectué le <?= $echeance->date_paiement ?></label>
                                                            <?php endif ?>
                                                        </div>

                                                        <div class="booking-amount medium-bold darker-gray-text">
                                                            <span> <?= $this->Number->currency($echeance->get('EcheanceSansTva'), 'EUR'); ?> HT</span>
                                                        </div>
                                                    </div>

                                                    <?php if ($echeance->is_payed != 'paid'): ?>
                                                        <div class="booking-info-wrap">
                                                            <div class="medium-bold darker-gray-text">
                                                                À régler avant le <?= $echeance->date ?>.
                                                            </div>

                                                            <div class="booking-amount medium-bold darker-gray-text">
                                                                <span class="amount-pay"> <?= $this->Number->currency($echeance->montant, 'EUR'); ?> TTC</span>
                                                            </div>
                                                        </div>
                                                    <?php endif ?>

                                                </div>
                                            </label>
                                        </div>
                                    <?php endif ?>
                                    
                                <?php endforeach ?>
                            <?php endif ?>

                            <?php if (!$isLastFindedEcheanceSameAsTotalDevisAmount || $devisEntity->get('NbEcheancePaid') == 0): /*quand le dernier acompte à payer = le solde , ne pas rajouter une ligne supplémentaire "régler la totalité du document", car ça revient au même.*/ ?>
                                    <div class="booking-block echeance-container">

                                        <label class="inner-booking-block">
                                            <div class="outer-booking-info-wrap">

                                                <?php if ($devisEntity->status != 'paid'): ?>
                                                    
                                                    <div class="booking-info-wrap top-booking-info-wrap mt-2">
                                                        <div class="booking-type to-pay-type bold">
                                                            <?php if ($devisEntity->status != 'paid'): ?>
                                                                <?= $this->Form->control('echeance', ['type' => 'radio', 'default' => (empty($devisEntity->devis_echeances) || $isFirstFindedEcheanceSameAsTotalDevisAmount ? 'total_remaining' : ''), 'options' => [[ 'value' => 'total_remaining', 'text' => false]], 'label' => false,'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}'  ]]) ?>
                                                                <?php if (count($devisEntity->devis_reglements) > 0): ?>
                                                                    <label for="echeance-total_remaining">Reste à solder</label>
                                                                <?php else: ?>
                                                                    <label for="echeance-total_remaining">Totalité du document</label>
                                                                <?php endif ?>
                                                            <?php endif ?>
                                                        </div>
                                                        <div class="booking-amount medium-bold darker-gray-text">
                                                            <div class="booking-amount medium-bold darker-gray-text">
                                                                <span> <?= $this->Number->currency($devisEntity->get('ResteEcheanceImpayeeSansTva'), 'EUR'); ?> HT</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="booking-info-wrap">
                                                        <div class="medium-bold darker-gray-text">
                                                            
                                                        </div>

                                                        <div class="booking-amount medium-bold darker-gray-text">
                                                            <span class="amount-pay"> <?= $this->Number->currency($devisEntity->get('ResteEcheanceImpayee'), 'EUR'); ?> TTC</span>
                                                        </div>
                                                    </div>

                                                <?php else: ?>

                                                    <?php if (
                                                        (!empty($this->devis_echeances) && $devisEntity->montant_total_paid != $lastFindEcheance->montant) || /* cas echeances : et prendre en compte aussi du cas payé */ 
                                                        $devisEntity->delai_reglements != 'echeances' || /* Afficher si le delai different*/
                                                        $devisEntity->get('NbEcheancePaid') == 0 /*cas : si aucune echéance payée mais directement sur paiement totalité, on n'affiche*/
                                                    ): ?>
                                                        <?php $factureReglement = collection($devisEntity->devis_reglements)->first() ?>
                                                        <div class="booking-info-wrap">
                                                            <div class="medium-bold darker-gray-text">
                                                                <label for="echeance-total_remaining">Document payé le <?= $factureReglement->created->format('d/m/Y') ?></label>
                                                            </div>
                                                            <div class="booking-amount medium-bold darker-gray-text">
                                                                <span class="amount-pay"> <?= $this->Number->currency($factureReglement->montant, 'EUR'); ?></span>
                                                            </div>
                                                        </div>
                                                    <?php endif ?>
                                                    
                                                <?php endif ?>
                                            </div>
                                        </label>

                                    </div>
                            <?php endif ?>

                        </div>

                        <?php if ($devisEntity->status != 'paid'): ?>
                        
                            <!-- SI PRO ON AFFFICHE LES CHOIX MOYENS DE REGLEMENTS -->
                            <div class="bottom-payment-choice-wrapper mt-4 mb-0">

                                <p>Mode de règlement :</p>

                            </div>
                        
                            <div class="booking-detail-list-wrapper bloc-moyen-reglement">

                                <div class="booking-block echeance-container">
                                    <div class="inner-booking-block">
                                        <div class="outer-booking-info-wrap">
                                            <div class="booking-info-wrap top-booking-info-wrap">
                                                <div class="booking-type to-pay-type bold">
                                                    <?= $this->Form->control('moyen_reglement', ['type' => 'radio', 'default' => false, 'options' => [[ 'value' => 'carte', 'id' => 'paiement-carte', 'text' => false]], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}']]) ?>
                                                    <label for="paiement-carte" class="text-dark">Carte bancaire (réservation immédiate - paiement sécurisé)</label>
                                                </div>
                                            </div>
                                            
                                            <div class="booking-info-wrap top-booking-info-wrap mt-2">
                                                <div class="booking-type to-pay-type bold">
                                                    <?= $this->Form->control('moyen_reglement', ['type' => 'radio', 'default' => false, 'options' => [[ 'value' => 'virement', 'id' => 'paiement-virement', 'text' => false]], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}']]) ?>
                                                    <label for="paiement-virement" class="text-dark">Virement bancaire (quelques jours de traitement)</label>
                                                </div>
                                            </div>

                                            <div class="booking-info-wrap top-booking-info-wrap mt-2">
                                                <div class="booking-type to-pay-type bold">
                                                    <?= $this->Form->control('moyen_reglement', ['type' => 'radio', 'default' => false, 'options' => [[ 'value' => 'cheque', 'id' => 'paiement-cheque', 'text' => false]], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}']]) ?>
                                                    <label for="paiement-cheque" class="text-dark">Chèque (quelques jours de traitement)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        <?php endif; ?>
                    </div>



                    <?php if ($devisEntity->status != 'paid'): ?>

                        <div class="booking-condition-block">

                            <?php echo $this->Form->control('is_cgl_accepted', ['checked' => $is_cgl_accepted_checked, 'type' => 'checkbox', 'label' => '']); ?>

                            <label for="is-cgl-accepted" class="booking-gen-conditions-label medium-bold darker-gray-text">
                                J'accepte les <span class="booking-condition-link">Conditions Générales de Location (CGL)</span>.
                            </label>

                            <p class="cgl-err text-danger d-none">
                                Vous devez accepter les Conditions Générales de Location avant de procéder au paiement.
                            </p>

                        </div>


                        <div class="bottom-button-block btn-pay-direct">

                            <button type="button" class="quotation-button <?php $devisEntity->status != 'paid' ?: 'd-none' ?>" id="pay">
                                <?php if ($devisEntity->status == 'paid' || $devisEntity->get('IsPartiallyPaid') ) { ?>
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

                    <!-- Affiche les coordonnées bancaires -->
                    <div class="bottom-button-block btn-etape-reglement d-none">

                        <button type="button" class="quotation-button no-modal">
                            Suivant
                        </button>

                    </div>

                    <div class="stripe-payment-method-wrap">
                        <?php echo $this->Html->image('devis/stripe.png', ['alt' => 'Stripe', "class" => ""]); ?>
                    </div>

                </div>

                
                <div class="booking-step-container booking-step-three hide-step">
                    <div class="booking-instruction-wrapper">

                        <?= $this->Form->create($devisEntity, ['url' => ['controller' => 'devisFactures', 'action' => 'makeReglement', $devisEntity->id, 'lang' => 'fr'], 'class' => 'form-other-payment']); ?>
                             
                            <p class="bold">
                                Pour régler par chèque, veuillez nous faire parvenir votre règlement à l'adresse suivante :
                            </p>

                            <p class="">
                                Montant : <?= $this->Number->currency($devisEntity->total_ttc, 'EUR'); ?>
                            </p>

                            <p class="">
                                Référence : <?= $devisEntity->indent; ?>
                            </p>

                            <p class="">
                                Ordre : Konitys
                            </p>

                            <p class="">
                                Adresse : <?= $devisPreferenceEntity->adress->adresse ?> <?= $devisPreferenceEntity->adress->cp ?> <?= $devisPreferenceEntity->adress->ville ?>
                            </p>

                            <!-- En fait pour le moment on va désactiver l’affichage du commentaire et du bouton -->
                            <div class="d-none">
                                <p class="">
                                    Message / Commentaire :
                                </p>

                                <div class="clearfix mt-2"><?= $this->Form->control('commentaire_paiement', ['label' => false]); ?></div>

                                <div class="bottom-button-block btn-etape-reglement d-none">
                                
                                    <button type="submit" class="quotation-button no-modal">
                                        Valider
                                    </button>
                                
                                </div>
                            </div>

                        <?= $this->form->end() ?>


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




<!-- === Condition Popup Container === -->

<div class="popup-container condition-popup-container">

    <div class="outer-popup-container">

        <div class="popup-close-wrap">

            <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

        </div>

        <div class="inner-popup-container customized-scrollbar">

            <div class="col-md-12 m-t-15">
                <?php
                    if($devisEntity->model_type == 'classik'){
                        echo $documentMarketing->cgl_classik_part;
                    }elseif($devisEntity->model_type == 'spherik'){
                        echo $documentMarketing->cgl_spherik_part;
                    }elseif ($devisEntity->get('ClientType') == 'corporation') {
                        echo $documentMarketing->cgl_pro;
                    }
                ?>
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

            <?php $param =  base64_encode(serialize([$devisEntity->id])) ?>
            <?= $this->Form->create($devisEntity, ['url' => ['controller' => 'devis', 'action' => 'makePayment', $param, 'lang' => 'fr'], 'class' => 'form-payment']); ?>

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
                                <?= $devisEntity->indent ?>
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
                        <?= $devisEntity->indent ?>
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
















