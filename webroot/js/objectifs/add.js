$('.table-objectifs tbody td input.montant').on('blur', function(event) {
    event.preventDefault();

    generateSum();
});

function generateSum() {
    $('.table-objectifs thead th.mois').each(function(i) {
        calculTotalParColonne(i);
    });

    function calculTotalParColonne(index) {
        var total = 0;
        $('.table-objectifs tbody tr').each(function() {
            var montant = parseFloat($('td input.montant', $(this)).eq(index).val());
            if (!isNaN(montant)) {
                total += montant;
            }
        });
        $('.table-objectifs tfoot td span.total').eq(index).text(total > 0 ? total + ' €' : '');

        grandTotal = 0;
        $('.table-objectifs tfoot td span.total').each(function(index, el) {
            var totalParCol = parseFloat($(this).text());

            if (!isNaN(totalParCol)) {
                grandTotal += totalParCol;
            }
        });

        $('.grand-total').text(grandTotal+ ' €');
    }
};

generateSum();