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