var setHeight = function() {
    var topOffset = 120;
    var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
    height = height - topOffset;
    if (height < 1)
        height = 1;
    if (height > topOffset) {
        $(".object-pdf").css("min-height", (height) + "px");
    }
};

$(window).ready(setHeight);
$(window).on("resize", setHeight);


/*

$('#stripe-container').off().on('show.bs.modal', function(event) {
    event.stopPropagation();

    if (!$('#is-cgl-accepted').is(':checked')) {
        $('.cgl-err').removeClass('d-none');
        return false;
    } else {
        $('.cgl-err').addClass('d-none');
        return;
    }
});
$('#pay').on('click', function(event) {
    if (!$('#is-cgl-accepted').is(':checked')) {
        $('.cgl-err').removeClass('d-none');
    } else {
        $('#stripe-container').modal('show')
        $('#stripe-container').on('shown.bs.modal', function(event) {
            $('.stripe-modal .email').focus();
            amountToPay = $('input[name="echeance"]:checked').parents('.echeance-container').find('.amount-pay').text();
            $('button.validate .show-amount').html(amountToPay);
        });
    }  
});

*/

$('#is-cgl-accepted').click(function(event) {
    if ($(this).is(':checked')) {
        $('.cgl-err').addClass('d-none');
    }
});



// === Check if browser is safari ===

/*

if( navigator.userAgent.indexOf("Safari") != -1 ) {

    $('.quotation-container .quotation-document-section .pdf-safari-desktop').addClass('display');

} else {

    $('.quotation-container .quotation-document-section .pdf-desktop-all').addClass('display');
}

*/

// === End of section to Check if browser is safari ===






// Declare and initialize variables
var initialQuotationHref = $('.quotation-document-section .bottom-button-block .quotation-button').attr('href');
var documentSrc = '';


// === Remove container-fluid class from parent of Quotation Container ===

$('.quotation-container').parents('.container-fluid').removeClass('container-fluid');

// === End of section to Remove container-fluid class from parent of Quotation Container ===



// === Check if booth type logo exists on page within left quotation header wrapper ===

if( !document.querySelector('#booth-type-logo') ) {

    $('#inner-left-header-wrapper').addClass('reduce-width');

} else {

    $('#inner-left-header-wrapper').removeClass('reduce-width');
}

// === End of section to Check if booth type logo exists on page within left quotation header wrapper ===



// === Check if order is complete ===

/*

if( document.querySelector('.quotation-container .quotation-header-wrapper .right-quotation-header-wrapper .order-paid') ) {

    $('.quotation-container .quotation-header-wrapper .right-quotation-header-wrapper .bottom-right-quotation-header-wrapper').addClass('reduce-margin');

} else {

    $('.quotation-container .quotation-header-wrapper .right-quotation-header-wrapper .bottom-right-quotation-header-wrapper').removeClass('reduce-margin');
}

*/


// === End of section to check if order is complete ===



// === Switch between steps in Quotation Detail Section ===


$('#btn-header-booking-borne, .quotation-container .header-option-wrapper .booking-option-block, #btn-bottom-booking-borne').on('click', function(){

    $('.quotation-container .header-option-wrapper .option-block').removeClass('current');
    $('.quotation-container .header-option-wrapper .booking-option-block').addClass('current');

    $('.quotation-container .quotation-detail-section .booking-step-one').addClass('hide-step');
    $('.quotation-container .quotation-detail-section .booking-step-two').removeClass('hide-step');
    $('.quotation-container .quotation-detail-section .booking-step-three').addClass('hide-step');


    $(window).scrollTop(0);


    // Check if on mobile
    if( window.matchMedia("(max-width: 800px)").matches ) {

        $('.mobile-option-menu-container .mobile-option-block').removeClass('current');

        // Hide preview for quotation
        $('.mobile-document-preview-wrapper').addClass('hide-within-mobile');

        $('.mobile-option-menu-container .mobile-booking-block').addClass('current');
    }

});

$('.booking-step-two .btn-etape-reglement .quotation-button').click(function(event) {

    $('.quotation-container .quotation-detail-section .booking-step-one').addClass('hide-step');
    $('.quotation-container .quotation-detail-section .booking-step-two').addClass('hide-step');
    $('.quotation-container .quotation-detail-section .booking-step-three').removeClass('hide-step');

});

$('.booking-step-two .booking-detail-container .btn-booking-back').on('click', function(){

    // Remove message on general condition
    //$('.cgl-err').addClass('d-none');

    $('.quotation-container .header-option-wrapper .option-block').removeClass('current');
    $('.quotation-container .header-option-wrapper .quotation-option-block').addClass('current');

    $('.quotation-container .quotation-detail-section .booking-step-two').addClass('hide-step');
    $('.quotation-container .quotation-detail-section .booking-step-one').removeClass('hide-step');

});

$('.booking-step-three .booking-detail-container .btn-booking-back').on('click', function(){

    // Remove message on general condition
    //$('.cgl-err').addClass('d-none');

    $('.quotation-container .quotation-detail-section .booking-step-three').addClass('hide-step');
    $('.quotation-container .quotation-detail-section .booking-step-two').removeClass('hide-step');
    $('.quotation-container .quotation-detail-section .booking-step-one').addClass('hide-step');

});

// === End of section to Switch between steps in Quotation Detail Section ===



// === Display booking section when clicking Booking button on top ===

$('.quotation-container .header-option-wrapper .booking-option-block, #btn-header-booking-borne').on('click', function(){

    // Remove message on general condition
    $('.cgl-err').addClass('d-none');

    $('.quotation-container .header-option-wrapper .option-block').removeClass('current');
    $('.quotation-container .header-option-wrapper .booking-option-block').addClass('current');

    // Call function to display booking section
    displayBookingSection();

});

// === End fo section to Display booking section when clicking Booking button on top ===


// === Function to display booking section ===

function displayBookingSection() {

    $('.quotation-container .quotation-detail-section').removeClass('hide-block');
    $('.quotation-container .quotation-document-section').removeClass('increase-width');
    $('.quotation-container .quotation-review-section').removeClass('display');
    $('.quotation-container .book-preview-wrapper').removeClass('display');

    $('.quotation-container .quotation-document-section').show();

    $('.quotation-container .quotation-document-section .bottom-button-block').show();

    $('.quotation-container .quotation-document-section .quotation-preview-wrapper').addClass('display');

    // Set document src
    documentSrc = initialQuotationHref;

    $('.quotation-document-section .bottom-button-block .quotation-button').attr('target', '_self');

    $('.quotation-document-section .bottom-button-block .quotation-button').html('Télécharger '+$('[name="telecharger"]').val());

}

// === End of function to Function to display booking section ===




// === Switch between Option Blocks ===

$('.quotation-container .header-option-wrapper .option-block').on('click', function(){

    $('.quotation-container .header-option-wrapper .option-block').removeClass('current');
    $('.quotation-container .quotation-document-section .document-preview-wrapper').removeClass('display');


    // Add current class to current option block
    $(this).addClass('current');


    // Check current option block
    if( $(this).hasClass('quotation-option-block') ) {

        // Call function to display booking section
        displayBookingSection();

        // Display step one
        $('.quotation-container .quotation-detail-section .booking-step-container').removeClass('hide-step');
        $('.quotation-container .quotation-detail-section .booking-step-two').addClass('hide-step');


    } else if( $(this).hasClass('presentation-book-block') ) {

        $('.quotation-container .quotation-detail-section').addClass('hide-block');
        $('.quotation-container .quotation-document-section').addClass('increase-width');
        $('.quotation-container .quotation-review-section').removeClass('display');

        $('.quotation-container .quotation-document-section').show();

        $('.quotation-container .quotation-document-section .book-preview-wrapper').addClass('display');

        $('.quotation-container .quotation-document-section .bottom-button-block').show();

        $('.quotation-document-section .bottom-button-block .quotation-button').attr('target', '_blank');

        //$('.quotation-document-section .bottom-button-block .quotation-button').html('Télécharger le document');

        $('.quotation-document-section .bottom-button-block .quotation-button').html('Voir en plein écran');

        // Set document src
        documentSrc = $('.quotation-document-section .book-preview-wrapper iframe').attr('src');

    } else if( $(this).hasClass('client-review-block') ) {

        $('.quotation-container .quotation-detail-section').addClass('hide-block');
        $('.quotation-container .quotation-document-section').addClass('increase-width');

        $('.quotation-container .quotation-document-section').hide();

        $('.quotation-container .quotation-document-section .quotation-preview-wrapper').removeClass('display');
        $('.quotation-container .quotation-document-section .book-preview-wrapper').removeClass('display');

        $('.quotation-container .quotation-document-section .bottom-button-block').hide();

        $('.quotation-container .quotation-review-section').addClass('display');

    } else if( $(this).hasClass('booking-option-block') ) {

        // Call function to display booking section
        displayBookingSection();

    }


    // Set href for quotation button
    $('.quotation-document-section .bottom-button-block .quotation-button').attr('href', documentSrc);


});

// === End of section to Switch between Option Blocks ===



// === Display Condition Popup Container ===

$('.booking-condition-block label .booking-condition-link').on('click', function(){

    $(this).parents('.booking-gen-conditions-label').attr('for', '');

    $('.condition-popup-container').addClass('display');

});


// Get id for checkbox related to general conditions
var chkGeneralConditionsId = $('.quotation-detail-section .booking-condition-block .booking-gen-conditions-label').attr('for');


$('.quotation-detail-section .booking-condition-block .booking-gen-conditions-label').on('click', function(e){

    if( $(e.target).closest( $('.booking-condition-block label .booking-condition-link') ).length === 0 ) {

        // Reset value for 'for' attribute of booking general condition label
        $(this).attr('for', chkGeneralConditionsId);

    }

});

// === End of section to Display Condition Popup Container ===



// === Close Condition Popup Container ===

$('.popup-close-wrap svg').on('click', function(){

    $(this).parents('.popup-container').removeClass('display');

});



$('.popup-container').on('click', function(e){

    if( $(e.target).closest( $('.popup-container .inner-popup-container') ).length === 0 ) {

        $(this).removeClass('display');
    }

});



$(document).keydown(function(e){

    // Check if escape key is pressed
    if (e.key === "Escape") {

        $('.popup-container').removeClass('display');
    }

});


// === End of section to Close Condition Popup Container ===


/*

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

*/



// === Close Payment Popup Container ===

$('.payment-popup-container .payment-button-wrapper .popup-cancel-button').on('click', function(){

    $('.payment-popup-container').removeClass('display');

});


// === End of section to Close Payment Popup Container ===



// === Switch between mobile option blocks ===

$('.mobile-option-menu-container .mobile-option-block').on('click', function(){

    $('.mobile-option-menu-container .mobile-option-block').removeClass('current');

    $(this).addClass('current');

    // Check current mobile option block

    if( $(this).hasClass('mobile-quotation-block') ) {

        $('.quotation-container .quotation-detail-section .booking-status-wrap, .quotation-detail-section .booking-top-total-amount').removeClass('hide-within-mobile');
        $('.mobile-document-preview-wrapper').removeClass('hide-within-mobile');
        $('.quotation-container .quotation-detail-section .booking-step-container').removeClass('hide-step');
        $('.quotation-container .quotation-detail-section .booking-step-two').addClass('hide-step');
        $('.quotation-container .quotation-detail-section').removeClass('remove-padding');
        $('.quotation-container .quotation-document-section').removeClass('display');
        $('.quotation-container .quotation-document-section .document-preview-wrapper').addClass('display');
        $('.quotation-container .quotation-document-section .book-preview-wrapper').removeClass('display');


    } else if( $(this).hasClass('mobile-presentation-block') ) {

        $('.quotation-container .quotation-detail-section .booking-status-wrap, .quotation-detail-section .booking-top-total-amount').addClass('hide-within-mobile');
        $('.mobile-document-preview-wrapper').addClass('hide-within-mobile');
        $('.quotation-container .quotation-detail-section .booking-step-container').addClass('hide-step');
        $('.quotation-container .quotation-detail-section').addClass('remove-padding');
        $('.quotation-container .quotation-document-section').addClass('display');
        $('.quotation-container .quotation-document-section .document-preview-wrapper').removeClass('display');
        $('.quotation-container .quotation-document-section .book-preview-wrapper').addClass('display');


        documentSrc = documentSrc = $('.quotation-document-section .book-preview-wrapper iframe').attr('src');

        $('.quotation-document-section .bottom-button-block .quotation-button').attr('target', '_blank');

        $('.quotation-document-section .bottom-button-block .quotation-button').html('Voir en plein écran');

        // Set href for quotation button
        $('.quotation-document-section .bottom-button-block .quotation-button').attr('href', documentSrc);


    } else if( $(this).hasClass('mobile-booking-block') ) {

        $('.quotation-container .quotation-detail-section .booking-status-wrap, .quotation-detail-section .booking-top-total-amount').removeClass('hide-within-mobile');
        $('.mobile-document-preview-wrapper').addClass('hide-within-mobile');
        $('.quotation-container .quotation-detail-section').removeClass('remove-padding');
        $('.quotation-container .quotation-detail-section .booking-step-container').addClass('hide-step');
        $('.quotation-container .quotation-detail-section .booking-step-two').removeClass('hide-step');
        $('.quotation-container .quotation-document-section').removeClass('display');
        $('.quotation-container .quotation-document-section .document-preview-wrapper').removeClass('display');
        $('.quotation-container .quotation-document-section .book-preview-wrapper').removeClass('display');
    }


});

// === End of section to Switch between mobile option blocks ===

// custom
$('.bloc-moyen-reglement').find('[type="radio"]:first()').prop('checked', true);

$('[name="moyen_reglement"]').click(function(event) {
    if ($.inArray($(this).val(), ['virement', 'cheque']) !== -1) {
        $('.btn-pay-direct').addClass('d-none');
        $('.btn-etape-reglement').removeClass('d-none');
    } else { // sinon carte
        $('.btn-pay-direct').removeClass('d-none');
        $('.btn-etape-reglement').addClass('d-none');
    }
});

// Règlement par virement et cheque
// Vennant formulaire extérieur, si valeur = total_remaining paiement de la totlaité ou du reste
formOtherPayment = $('form.form-other-payment');
if ($('input[type="radio"][name="echeance"]').length > 0) {
    $('.echeance').remove();
    $('input[type="radio"][name="echeance"]').each(function(event) {
        if ($(this).is(':checked')) {
            $('<input>', {
                'type' : 'hidden', // text // hidden
                'class' : 'form-control echeance',
                'name' : 'echeance',
                'value': $(this).val(),
            }).appendTo(formOtherPayment)
        }
    });
}
