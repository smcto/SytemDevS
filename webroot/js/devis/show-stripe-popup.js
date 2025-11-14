// === Display Stripe Popup ===

$('.booking-step-two .bottom-button-block .quotation-button:not(.no-modal)').on('click', function(){

    // Check if is-cgl-accepted is checked
    // On vire (sur une facture d’un événement passé ça n’a plus d’importance..)

    if ($('.booking-condition-block input[type="checkbox"]#is-cgl-accepted').html() === undefined) {
        // si client == pro on affiche pas le bloc de cgl
        displayStripePopup();

    } else {

        // si client == part on affiche le bloc de cgl
        if( $('.booking-condition-block input[type="checkbox"]#is-cgl-accepted').is(':checked') ) {

            displayStripePopup();

        } else {

            $('.cgl-err').removeClass('d-none');

        }
    }


});


function displayStripePopup() {
    $('.cgl-err').addClass('d-none');

    // Display Stripe Popup
    $('.payment-popup-container').addClass('display');

    // Set focus on email input
    $('.stripe-modal .email').focus();

    // Get amount to pay
    var amountToPay = $('input[name="echeance"]:checked').parents('.echeance-container').find('.amount-pay').text();
    $('.show-amount').html(amountToPay);
}

// === End of section to Display Stripe Popup ===
