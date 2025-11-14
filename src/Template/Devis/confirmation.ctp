<?= $this->Html->css('devis/confirmation.css'); ?>

<?= $this->Html->script('devis/confirmation.js'); ?>
<?php $this->assign('title', 'Commande confirmée') ?>



<div class="confirmed-payment-section">

    <div class="inner-confirmed-payment-section">

        <div class="top-confirmation-img-wrap">

            <?php echo $this->Html->image('devis/confirmation-image.jpg', ['alt' => 'Image', "class" => ""]); ?>

        </div>

        <div class="payment-confirmation-info-wrap">

            Votre règlement a bien été enregistré.
            <br>
            Une confirmation de votre réservation vous a été envoyée par email.
            <br>
            Notre équipe prendra contact ultérieurement pour la mise en place de votre évènement.

                <div class="selfizee-team-text">
                    L'équipe Selfizee.
                </div>

        </div>

        <div class="payment-selfizee-signation-wrap">

            <?php echo $this->Html->image('devis/selfizee-signature.jpg', ['alt' => 'Signature Selfizee', "class" => ""]); ?>

        </div>

    </div>

</div>
