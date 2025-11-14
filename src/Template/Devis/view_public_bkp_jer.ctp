<?= $this->Html->css('devis/stripe_payment.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('devis/view_public.css?'.  time(), ['block' => 'css']); ?>
<?= $this->Html->css('/scss/icons/font-awesome/css/font-awesome.css', ['block' => 'css']); ?>

<?= $this->Html->script('devis/stripe_func.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/stripe_payment.js?'.  time(), ['block' => 'script']); ?>
<?= $this->Html->script('devis/view_public.js?'.  time(), ['block' => 'script']); ?>

<!-- Trustpilot widget script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End of Trustpilot widget script -->

<?php $this->assign('title', 'Devis Selfizee '.$devisEntity->indent) ?>
<script src="https://js.stripe.com/v3/"></script>
<?php $is_cgl_accepted_checked = '' ?>
<?php if ($this->request->getQuery('test')): ?>
    <?php $devisEntity->email = 'test@gmail.com' ?>
    <?php $is_cgl_accepted_checked = 'checked' ?>
<?php endif ?>

<div class="modal fade" id="stripe-container" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog example container-stripe-form" role="document">
        <div class="modal-content stripe-modal" data-client-public="<?= $stripeApiKeyPublic ?>">
            <?php $param = $devisEntity->status != 'paid' ?  base64_encode(serialize([$devisEntity->id])) : 0 ?>
            <?= $this->Form->create($devisEntity, ['url' => ['action' => 'makePayment', $param]]); ?>
                <div class="modal-body ">

                    <div class="selfizee-logo">
                        <?php echo $this->Html->image('logo-selfizee.png', ['alt' => 'Logo', "class" => ""]); ?>
                    </div>

                    <div class="mb-4 booking-number sous-titre"><?= $devisEntity->indent ?></div>
                    <?= $this->Form->control('email', ['label' => 'Email', 'class' => 'form-control form-control-sm email', 'required', 'placeholder' => 'email@gmail.com']); ?>
                    <!-- <?= $this->Form->control('code_postal', ['class' => 'form-control form-control-sm zip', 'required']); ?> -->

                    <div class="mb-4 booking-info">Vos informations de paiement</div>
                    <div class="clearfix">
                        <label for="email" class="control-label">Votre numéro de carte</label>
                        <div class="stripe-form field-with-icon mb-4">
                            <span class="field-icon fa fa-credit-card"></span>
                            <div id="card-number"></div>
                        </div>
                    </div>
                    <div class="row clearfix bottom-stripe-input">
                        <div class="col expiration-date-wrapper">
                            <label for="email" class="control-label">Date d'expiration</label>
                            <div class="stripe-form field-with-icon mb-4">
                                <span class="field-icon fa fa-calendar"></span>
                                <div id="card-expiry"></div>
                            </div>
                        </div>
                        <div class="col cryptogram-wrapper">
                            <label for="email" class="control-label">Cryptogramme de sécurité</label>
                            <div class="stripe-form field-with-icon mb-4 ajust-padding">
                                <span class="field-icon fa fa-lock"></span>
                                <div id="card-cvc"></div>
                            </div>
                        </div>
                    </div>
                    <div id="card-errors" role="alert" class="text-danger"></div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="mr-4 text-secondary cancel-payment" data-dismiss="modal">Annuler</a>
                    <button type="submit" class="validate">Payer 134,70 &euro;<span class="show-amount"></span></button>
                </div>
                <div class="container">
                    <p class="stripe-lock text-right"><i class="fa fa-lock"></i> Stripe</p>
                </div>
            <?= $this->form->end() ?>
        </div>
    </div>
</div>




<!--<div class="col-md-12">
    <div class=" row">
        <div class="col-md-4">
            <div class="">
                <?php echo $this->Html->image('logo-selfizee.png', ['alt' => 'Logo', "class" => ""]); ?>
            </div>
            <div class="d-bloc mt-5">
                <div class="row ">
                    <div class="container">
                        <div class="mb-4">
                            <h4><b> Devis</b></h4>
                            <h5> N° <?= $devisEntity->indent ?></h5>
                            Statut :  <i class="fa fa-circle <?= $devisEntity->status ?> font-12" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$devisEntity->status] ?>" data-original-title="Brouillon"></i> <?= @$devis_status[$devisEntity->status] ?>
                        </div>

                        <?php if ($devisEntity->status != 'paid'): ?>
                            <?php echo $this->Form->control('is_cgl_accepted', ['checked' => $is_cgl_accepted_checked, 'type' => 'checkbox', 'label' => "J'accepte les conditions générales de location."]); ?>

                            <p class="cgl-err text-danger d-none"><b>Vous devez accepter les conditions de vente avant de procéder au paiement.</b></p>

                            <?php if (!empty($devisEntity->devis_echeances)): ?>
                                <p>Choisissez une échéance à régler :</p>
                            <?php endif ?>
                        <?php endif ?>


                        <?php if ($devisEntity->status != 'paid'): ?>
                            <?php foreach ($devisEntity->devis_echeances as $key => $echeance): ?>
                                <div class="clearfix mb-2 echeance-container">
                                    <div class="row">
                                        <div class="col">
                                            <?php if ($echeance->is_payed == 0): ?>
                                                <?= $this->Form->control('echeance', ['type' => 'radio', 'options' => [[ 'value' => $echeance->id, 'text' => false]], 'label' => false, 'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}']]) ?>
                                                <label for="echeance-<?= $echeance->id ?>" class="text-success">À payer</label>
                                            <?php else: ?>
                                                <label for="echeance-<?= $echeance->id ?>" class="text-info">Payée</label>
                                            <?php endif ?>
                                        </div>
                                        <div class="col text-right"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col"><?= $echeance->date ?></div>
                                        <div class="col text-right amount-pay"><?= $this->Number->currency($echeance->montant, 'EUR'); ?></div>
                                    </div>
                                </div>

                                <?php if (next($devisEntity->devis_echeances)): ?>
                                    <hr class="m-0 mb-2">
                                <?php endif ?>
                            <?php endforeach ?>

                            <div class="clearfix mb-2 echeance-container">
                                <div class="row">
                                    <div class="col">
                                        <?php if ($devisEntity->status != 'paid'): ?>
                                            <?= $this->Form->control('echeance', ['type' => 'radio', 'default' => 'total_remaining', 'options' => [[ 'value' => 'total_remaining', 'text' => false]], 'label' => false,'templates' => ['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>', 'inputContainer' => '{{content}}'  ]]) ?>
                                            <label for="echeance-total_remaining" class="text-success">Payer le document</label>
                                        <?php else: ?>
                                            <label for="echeance-total_remaining" class="text-info">Document payé</label>
                                        <?php endif ?>
                                    </div>
                                    <div class="col text-right"></div>
                                </div>

                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col text-right amount-pay"><?= $this->Number->currency($devisEntity->get('ResteEcheanceImpayee'), 'EUR'); ?></div>
                                </div>
                            </div>
                        <?php endif ?>

                    </div>
                </div>

                <button type="button" class="<?= $devisEntity->status != 'paid' ?: 'd-none' ?> btn btn-primary mt-4" id="pay">Payer par carte bancaire</button>

            </div>
        </div>
        <div class="col-md-8 text-center">
            <?php $this->start('pdf_iframe') ?>
                <embed src="<?= $this->Url->build($devisEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf" style="width:100%">
            <?php $this->end() ?>
            <?php if (!$this->request->getQuery('test')): ?>
                <?php echo $this->fetch('pdf_iframe') ?>
            <?php endif ?>
            <div class="m-t-10 m-b-10">
                <a class="btn btn-rounded btn-primary" href="<?= $this->Url->build($devisEntity->get('PublicPdfDownloadUrl')) ?>">Télécharger le document</a>
            </div>
        </div>
    </div>
</div>-->




<!-- === Quotation Container === -->

<div class="quotation-container">

    <div class="quotation-side-section quotation-detail-section">

        <div class="inner-quotation-detail-section">

            <div class="quotation-header-wrapper">

                <div class="selfizee-logo-wrap">
                    <?php echo $this->Html->image('logo-selfizee.png', ['alt' => 'Logo', "class" => ""]); ?>
                </div>

                <div class="quotation-header-detail-wrap">

                    <div class="quotation-type">
                         Devis Selfizee Spherik
                    </div>

                    <div class="header-detail-wrap">
                        N° <?= $devisEntity->indent ?>
                        <br>
                        Date : week end du 03/07/20
                        <br>
                        Contact : Raymond Dupont
                        <br>
                        Lieu de retrait : Paris
                    </div>

                    <div class="booth-type-logo">
                        <?php echo $this->Html->image('devis/spherik.jpg', ['alt' => 'Spherik', "class" => ""]); ?>
                    </div>

                </div>

            </div>

            <div class="booking-status-wrap">

                <i class="fa fa-circle <?= $devisEntity->status ?>" data-toggle="tooltip" data-placement="top" title="<?= @$devis_status[$devisEntity->status] ?>" data-original-title="Brouillon"></i>

                <div class="booking-status-info">
                    <?= @$devis_status[$devisEntity->status] ?>
                </div>

            </div>

            <div class="booking-top-total-amount">
                389 &euro; <span class="ttc-icon">ttc</span>
            </div>

            <div class="booking-step-container booking-step-one">

                <div class="booking-detail-container">

                    <div class="booking-title">
                        L'ESSENTIEL DE LA PROPOSITION :
                    </div>

                    <div class="booking-instruction-wrapper">

                        <div class="outer-instruction-container">

                            <div class="instruction-block">

                                <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                <div class="indication-text">

                                    <p class="bold">
                                        Impression professionnelle très rapide en 7s !
                                    </p>
                                    <p>
                                        Attention certaines bornes bas de gamme impriment en 4s, avec une qualité médiocre et un rechargement en consommable fréquent.
                                    </p>

                                </div>

                            </div>

                            <div class="instruction-block">

                                <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                <div class="indication-text">

                                    <p class="bold">
                                        400 impressions 10x15 (ou 800 impressions 5x15) sans recharge
                                    </p>
                                    <p>
                                        Méfiez-vous des offres impression illimitée, c'est un argument marketing car il est déjà difficile d'atteindre 400 impressions !
                                    </p>

                                </div>

                            </div>

                            <div class="instruction-block">

                                <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                <div class="indication-text">

                                    <p class="bold">
                                        Prise de photo numérique illimitée
                                    </p>

                                </div>

                            </div>

                            <div class="instruction-block">

                                <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                <div class="indication-text">

                                    <p>
                                        <span class="bold">Remise de l'intégralité des photos numériques après votre évènement</span> via une galerie consultable et partageable auprès de vos invites !
                                    </p>

                                </div>

                            </div>

                            <div class="instruction-block">

                                <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                <div class="indication-text">

                                    <p class="bold">
                                        Hotline pour installation et problèmes techniques
                                    </p>

                                </div>

                            </div>

                            <div class="instruction-block">

                                <svg viewBox="0 0 512 512"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm129.75 201.75-138.667969 138.664062c-4.160156 4.160157-9.621093 6.253907-15.082031 6.253907s-10.921875-2.09375-15.082031-6.253907l-69.332031-69.332031c-8.34375-8.339843-8.34375-21.824219 0-30.164062 8.339843-8.34375 21.820312-8.34375 30.164062 0l54.25 54.25 123.585938-123.582031c8.339843-8.34375 21.820312-8.34375 30.164062 0 8.339844 8.339843 8.339844 21.820312 0 30.164062zm0 0"/></svg>

                                <div class="indication-text">

                                    <p>
                                        <span class="bold">Personnalisation de la photo dédiée selon vos logos, graphisme et textes</span> (1 à 4 poses par tirage)
                                    </p>
                                    <p>
                                        Nous réalisons pour vous le design de la personnalisation de la photo et préparons la borne. Il est possible de reprendre les graphismes de faire-part ou invitation.
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="bottom-indication-wrap">

                            <p>
                                <span class="bold">Réglez uniquement un acompte de 116 &euro; aujourd'hui pour bloquer votre date !</span> Notre équipe prendre contact avec vous par la suite pour la mise en place de notre animation.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="outer-bottom-button-block">

                    <div class="bottom-button-block">

                        <div class="quotation-button">
                            Réserver la borne Selfizee !
                        </div>

                    </div>

                    <div class="stripe-payment-method-wrap">
                        <?php echo $this->Html->image('devis/stripe.jpg', ['alt' => 'Spherik', "class" => ""]); ?>
                    </div>

                </div>

                <div class="trutpilot-wrapper">

                    <div class="trustpilot-widget" data-locale="fr-FR" data-template-id="5406e65db0d04a09e042d5fc" data-businessunit-id="5c989cb5dcee3200019ec400" data-style-height="28px" data-style-width="100%" data-theme="light"><a href="https://fr.trustpilot.com/review/selfizee.fr" target="_blank" rel="noopener">Trustpilot</a></div>

                    <!--<div class="trustpilot-widget" data-locale="fr-FR" data-template-id="53aa8912dec7e10d38f59f36" data-businessunit-id="5c989cb5dcee3200019ec400" data-style-height="130px" data-style-width="100%" data-theme="light" data-stars="4,5"> <a href="https://fr.trustpilot.com/review/selfizee.fr" target="_blank" rel="noopener">Trustpilot</a></div>-->

                </div>

            </div>

            <div class="booking-step-container booking-step-two hide-step">

                <div class="booking-detail-container">

                    <div class="outer-booking-title">

                        <svg viewBox="0 0 512 512"><path d="M256 0C114.618 0 0 114.618 0 256s114.618 256 256 256 256-114.618 256-256S397.382 0 256 0zm0 469.333c-117.818 0-213.333-95.515-213.333-213.333S138.182 42.667 256 42.667 469.333 138.182 469.333 256 373.818 469.333 256 469.333z"/><path d="M401.067 268.761c.227-.303.462-.6.673-.915.203-.304.379-.619.565-.93.171-.286.35-.565.508-.86.17-.317.313-.643.466-.967.145-.308.299-.61.43-.925.13-.314.235-.635.349-.953.122-.338.251-.672.356-1.018.096-.318.167-.642.248-.964.089-.353.188-.701.259-1.061.074-.372.117-.748.171-1.122.045-.314.105-.622.136-.941.138-1.4.138-2.81 0-4.21-.031-.318-.091-.627-.136-.941-.054-.375-.097-.75-.171-1.122-.071-.359-.17-.708-.259-1.061-.081-.322-.152-.645-.248-.964-.105-.346-.234-.68-.356-1.018-.114-.318-.219-.639-.349-.953-.131-.315-.284-.618-.43-.925-.153-.324-.296-.65-.466-.967-.158-.294-.337-.574-.508-.86-.186-.311-.362-.626-.565-.93-.211-.315-.446-.612-.673-.915-.19-.254-.366-.514-.569-.761-.443-.54-.91-1.059-1.403-1.552l-.01-.011-85.333-85.333c-8.331-8.331-21.839-8.331-30.17 0s-8.331 21.839 0 30.17l48.915 48.915H128c-11.782 0-21.333 9.551-21.333 21.333s9.551 21.333 21.333 21.333h204.497l-48.915 48.915c-8.331 8.331-8.331 21.839 0 30.17 8.331 8.331 21.839 8.331 30.17 0l85.333-85.333.01-.011c.493-.494.96-1.012 1.403-1.552.203-.247.379-.508.569-.761z"/></svg>

                        <div class="booking-title">
                            RÉSERVATION ET RÈGLEMENT
                        </div>

                    </div>

                    <div class="booking-instruction-wrapper">

                        <p class="bold">
                            Pour valider votre réservation et bloquer au plus vite votre date :
                        </p>
                        <p>
                            Veuillez régler l'acompte minimum via le module ci-dessous.
                        </p>
                        <p>
                            Un email de confirmation vous sera immédiatement envoyé et notre équipe prendra contact avec vous pour la suite de la mise en place.
                        </p>

                    </div>

                    <div class="booking-detail-list-wrapper">

                        <div class="booking-block echeance-container">

                            <label class="inner-booking-block">

                                <input type="radio" name="rdb-booking-type" checked />

                                <div class="outer-booking-info-wrap">

                                    <div class="booking-info-wrap top-booking-info-wrap">

                                        <div class="booking-type to-pay-type bold">
                                            À régler
                                        </div>

                                        <div class="booking-amount medium-bold darker-gray-text">
                                            134,70 &euro;
                                        </div>

                                    </div>

                                    <div class="booking-info-wrap">

                                        <div class="medium-bold darker-gray-text">
                                            09/07/2020
                                        </div>

                                        <div class="booking-amount medium-bold darker-gray-text">
                                            : 134,70 &euro;
                                        </div>

                                    </div>

                                </div>

                            </label>

                        </div>

                        <div class="booking-block echeance-container">

                            <label class="inner-booking-block">

                                <input type="radio" name="rdb-booking-type" />

                                <div class="outer-booking-info-wrap">

                                    <div class="booking-info-wrap top-booking-info-wrap">

                                        <div class="booking-type to-pay-type bold">
                                            À régler
                                        </div>

                                        <div class="booking-amount medium-bold darker-gray-text">
                                            314,30 &euro;
                                        </div>

                                    </div>

                                    <div class="booking-info-wrap">

                                        <div class="medium-bold darker-gray-text">
                                            10/09/2020
                                        </div>

                                        <div class="booking-amount medium-bold darker-gray-text">
                                            : 314,30 &euro;
                                        </div>

                                    </div>

                                </div>

                            </label>

                        </div>

                        <div class="booking-block echeance-container">

                            <label class="inner-booking-block">

                                <input type="radio" name="rdb-booking-type" />

                                <div class="outer-booking-info-wrap">

                                    <div class="booking-info-wrap">

                                        <div class="medium-bold darker-gray-text">
                                            Payer la totalité du document
                                        </div>

                                        <div class="booking-amount medium-bold darker-gray-text">
                                            449,00 &euro;
                                        </div>

                                    </div>

                                </div>

                            </label>

                        </div>

                    </div>

                    <!--<div class="booking-condition-block medium-bold darker-gray-text">-->

                    <div class="booking-condition-block">

                        <?php if ($devisEntity->status != 'paid'): ?>

                            <?php echo $this->Form->control('is_cgl_accepted', ['checked' => $is_cgl_accepted_checked, 'type' => 'checkbox', 'label' => '']); ?>

                            <label for="is-cgl-accepted" class="booking-gen-conditions-label medium-bold darker-gray-text">
                                J'accepte les <span class="booking-condition-link">conditions générales de location</span>.
                            </label>

                            <p class="cgl-err text-danger d-none">
                                <b>Vous devez accepter les conditions de vente avant de procéder au paiement.</b>
                            </p>

                            <!--<?php if (!empty($devisEntity->devis_echeances)): ?>
                                <p>Choisissez une échéance à régler :</p>
                            <?php endif ?>-->

                        <?php endif ?>

                    </div>

                </div>

                <div class="bottom-button-block">

                    <button type="button" class="quotation-button <?= $devisEntity->status != 'paid' ?: 'd-none' ?>" id="pay">
                        Réserver et payer par carte bancaire
                    </button>

                </div>

                <div class="stripe-payment-method-wrap">
                    <?php echo $this->Html->image('devis/stripe.jpg', ['alt' => 'Spherik', "class" => ""]); ?>
                </div>

            </div>

        </div>

    </div>

    <div class="quotation-side-section quotation-document-section">

        <div class="document-option-wrapper">

            <div class="option-block quotation-option-block current">

                <div class="text top-text">
                    Votre devis
                </div>

                <div class="text middle-text">
                    Votre devis personnalisé
                </div>

                <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

            </div>

            <div class="option-block presentation-book-block">

                <div class="text top-text">
                    Book de présentation
                </div>

                <div class="text middle-text">
                    Détails de la prestation et présentation de la borne FAQ...
                </div>

                <svg viewBox="0 0 451.847 451.847"><path d="M225.923 354.706c-8.098 0-16.195-3.092-22.369-9.263L9.27 151.157c-12.359-12.359-12.359-32.397 0-44.751 12.354-12.354 32.388-12.354 44.748 0l171.905 171.915 171.906-171.909c12.359-12.354 32.391-12.354 44.744 0 12.365 12.354 12.365 32.392 0 44.751L248.292 345.449c-6.177 6.172-14.274 9.257-22.369 9.257z"/></svg>

            </div>

        </div>

        <div class="document-preview-wrapper quotation-preview-wrapper display">

            <?php $this->start('pdf_iframe') ?>
                <embed src="<?= $this->Url->build($devisEntity->get('PublicPdfUrl')) ?>" type="application/pdf" title="devis" class="object-pdf">
            <?php $this->end() ?>
            <?php if (!$this->request->getQuery('test')): ?>
                <?php echo $this->fetch('pdf_iframe') ?>
            <?php endif ?>

        </div>

        <div class="document-preview-wrapper book-preview-wrapper">

            <iframe src="https://www.selfizee.fr/docs/brochure-selfizee-classik.pdf" class="booth-type-container classik-document-container"></iframe>

            <iframe src="https://www.selfizee.fr/docs/brochure-selfizee-spherik.pdf" class="booth-type-container spherik-document-container"></iframe>

        </div>

        <div class="bottom-button-block">

            <a class="quotation-button" href="<?= $this->Url->build($devisEntity->get('PublicPdfDownloadUrl')) ?>">
                Télécharger le devis
            </a>

        </div>

    </div>

</div>

<!-- === End of Quotation Container === -->




<!-- === Condition Popup Container === -->

<div class="popup-container contion-popup-container">

    <div class="inner-popup-container">

        <div class="popup-close-wrap">

            <svg viewBox="0 0 512 512"><path d="m256 512c-141.160156 0-256-114.839844-256-256s114.839844-256 256-256 256 114.839844 256 256-114.839844 256-256 256zm0-475.429688c-120.992188 0-219.429688 98.4375-219.429688 219.429688s98.4375 219.429688 219.429688 219.429688 219.429688-98.4375 219.429688-219.429688-98.4375-219.429688-219.429688-219.429688zm0 0"/><path d="m347.429688 365.714844c-4.679688 0-9.359376-1.785156-12.929688-5.359375l-182.855469-182.855469c-7.144531-7.144531-7.144531-18.714844 0-25.855469 7.140625-7.140625 18.714844-7.144531 25.855469 0l182.855469 182.855469c7.144531 7.144531 7.144531 18.714844 0 25.855469-3.570313 3.574219-8.246094 5.359375-12.925781 5.359375zm0 0"/><path d="m164.570312 365.714844c-4.679687 0-9.355468-1.785156-12.925781-5.359375-7.144531-7.140625-7.144531-18.714844 0-25.855469l182.855469-182.855469c7.144531-7.144531 18.714844-7.144531 25.855469 0 7.140625 7.140625 7.144531 18.714844 0 25.855469l-182.855469 182.855469c-3.570312 3.574219-8.25 5.359375-12.929688 5.359375zm0 0"/></svg>

        </div>

    </div>

</div>

<!-- === End of Condition Popup Container === -->
















