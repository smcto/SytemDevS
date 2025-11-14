$(document).ready(function(){

    /* === Chart for Facture Summary === */

    var factureAmounts = [40000, 30000, 10000, 15000, 5000];

    var factureData = {

        labels: ["Selfizee Loc'fi", "Event", "Particuliers", "Professionnels", "Digitea"],
        datasets: [{
            data: getDataPercents(factureAmounts),
            backgroundColor: ['#ff4f70', '#01caf1', '#22ca80', '#fcba03', '#9966ff']
        }]
    };

    var summaryBlockClass = '.synthese-mensuelle-dashboard-wrapper .all-chart-wrapper .facture-summary-block';
    let factureSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let factureChartData = new Chart(factureSumCanvas, {

        type: 'pie',
        data: factureData,
        options: {
            //aspectRatio: 2.5,
            //aspectRatio: 3.9,
            aspectRatio: 1.5205,
            //maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function (chart) {
                return populateChartLegend(chart, summaryBlockClass);
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getPercentageTooltip(tooltipItems, data);
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            rotation: 89
        }

    });

    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(factureChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), factureChartData );
    });


    /* === End of Chart for Facture Summary === */


});
