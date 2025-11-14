$(document).ready(function(){

    /* === Chart for Contract Summary === */

    var clientAmounts = [38000, 43000, 19000];

    var contractData = {

        labels: ["Loc'event", "Loc'fi", "Vente"],
        datasets: [{
            data: getDataPercents(clientAmounts),
            backgroundColor: ['#01caf1', '#ff4f70', '#fcba03']
        }]
    };

    var summaryBlockClass = '.client-dashboard-wrapper .all-chart-wrapper .contract-summary-block';
    let contractSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let contractChartData = new Chart(contractSumCanvas, {

        type: 'pie',
        data: contractData,
        options: {
            /* responsive: false, */
            //aspectRatio: 1.405,
            aspectRatio: 1.5205,
            maintainAspectRatio: false,
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
    $(summaryBlockClass + ' .legend-wrapper').append(contractChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), contractChartData );
    });


    /* === End of Chart for Contract Summary === */

});


