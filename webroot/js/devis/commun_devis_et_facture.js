/**
 * Voir dans add.js ou corps_devis si on ne trouve pas la fontion
 */

// rajouter une colonne après chaque colonne "montant" : "%"
$('table#echeance').on('blur', '[input-name="percent_value"]', function(event) {
    currentTr = $(this).parents('tr');

    if ($(this).val() != '') {
        percentValueDecimal = ($(this).val()/100).toFixed(4);
        totalGeneralTtc = $('.total_general_ttc').text();
        montant = (percentValueDecimal*totalGeneralTtc).toFixed(2);
        currentTr.find('[input-name="montant"]').val(montant);
        calculTotalEcheance();
    }
});

// et faire l'inverse, c'est à dire que si je met une valeur dans la colonne montant, ça doit afficher le % à droite sur la valeur que ça représente.
$('table#echeance').on('blur', '[input-name="montant"]', function(event) {
    currentTr = $(this).parents('tr');

    if ($(this).val() != '') {
        totalGeneralTtc = $('.total_general_ttc').text();
        percentValueDecimal = ($(this).val()/totalGeneralTtc).toFixed(4);
        percentInt = (percentValueDecimal*100);
        currentTr.find('[input-name="percent_value"]').val(percentInt % 1 === 0 ? percentInt.toFixed(0) : percentInt.toFixed(2)); // si decimal on met 2 chiffres après la virgule, sinon on met rien après
        calculTotalEcheance();
    }
});

// afficher un modal après un moment, proposant d'enregistrer le form
setTimeout(function () {
    $('#save-proposition').modal('show');
    $('.proposition-save').click(function(event) {
        $('.save_continuer_devis').click();
    });
}, 1000*60*10)