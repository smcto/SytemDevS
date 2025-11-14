// === Display Redirect to Stripe ===

$('.booking-step-two .bottom-button-block .quotation-button:not(.no-modal)').on('click', function(){

    // Check if is-cgl-accepted is checked
    // On vire (sur une facture d’un événement passé ça n’a plus d’importance..)

    if ($('.booking-condition-block input[type="checkbox"]#is-cgl-accepted').html() === undefined) {
        // si client == pro on affiche pas le bloc de cgl
        redirectToStripe();

    } else {

        // si client == part on affiche le bloc de cgl
        if( $('.booking-condition-block input[type="checkbox"]#is-cgl-accepted').is(':checked') ) {

            redirectToStripe();

        } else {

            $('.cgl-err').removeClass('d-none');

        }
    }


});


function redirectToStripe() {

//    $('.cgl-err').addClass('d-none');
//
//    // Display payment popup container
//    $('.payment-popup-container').addClass('display');
//
//    // Set focus on email input
//    $('.stripe-modal .email').focus();
//
//    // Get amount to pay
    var apiKeyPublic = $('#apiKeyPublic').val();
    var amountToPay = $('input[name="echeance"]:checked').parents('.echeance-container').find('.amount-pay').text();
    var totalRemaining = $('input[name="echeance"]:checked').val();
    var devis_id = $('#devis_id').val();
    var facture_id = $('#facture_id').val();
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var is_test = urlParams.get('test');
//    $('.show-amount').html(amountToPay);

    var srcUrl = $("#id_baseUrl").attr('value');
    var entity = $('#entity').val();

//    Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe(apiKeyPublic);

    fetch(srcUrl + "fr/" + entity + "/paiement-session", {
        method: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            montant: amountToPay,
            echeance:totalRemaining,
            devis_id: devis_id,
            facture_id: facture_id,
            is_test: is_test
        })
    })
    .then(function (response) {
      return response.json();
    })
    .then(function (session) {
        return stripe.redirectToCheckout({ sessionId: session.id });
    })
    .then(function (result) {
        // If redirectToCheckout fails due to a browser or network
        // error, you should display the localized error message to your
        // customer using error.message.
        if (result.error) {
          alert(result.error.message);
        }
    })
    .catch(function (error) {
      console.error("Error:", error);
    });

}

// === End of section to Display Redirect to Stripe ===
