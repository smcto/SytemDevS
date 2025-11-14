<?= $this->Html->script('devis/stripe.js', ['block' => true]); ?>
<script src="https://js.stripe.com/v3/"></script>
<h1 class="text-center mt-5">REDIRECTION VERS LA PAGE DE PAIEMENT</h1>
<p class="text-center mt-4"><b>Veuiller patienter ...</b></p>
<input type="hidden" class="stripeApiKeyPublic" value="<?= $stripeApiKeyPublic  ?>">
<input type="hidden" class="sessionId" value="<?= $session->id  ?>">
