$(document).ready(function(){

    /* === Chart for General Summary Chart === */

    var generalData = {

        labels: ["Loc'event pro", "Loc'fi", "Achat", "Particuliers"],
        datasets: [{
            data: [40, 60, 55, 30],
            backgroundColor: ['#01caf1', '#ff4f70', '#22ca80', '#fcba03']
        }]
    };

    let generalSumCanvas = document.querySelector('.dashboard-late-payment-wrapper .all-chart-wrapper .general-summary-block canvas').getContext('2d');

    let generalChartData = new Chart(generalSumCanvas, {

        type: 'doughnut',
        data: generalData,
        options: {
            responsive: false,
            aspectRatio: 2.5,
            //aspectRatio: 1.31,
            maintainAspectRatio: false,
            legend: { display: false },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            cutoutPercentage: 80,
            rotation: 89
        }

    });


    // --- *** Populate legend for General Summary Chart *** ---

    let legendWrapper = $('.dashboard-late-payment-wrapper .all-chart-wrapper .general-summary-block .legend-wrapper');

    for(var i = 0; i < generalChartData.data.labels.length; i++) {

        var bgColor = generalChartData.data.datasets[0].backgroundColor[i];
        var text = generalChartData.data.labels[i].replace(/'/g, "\'");
        var data = generalChartData.data.datasets[0].data[i];

        var legendBlock = '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="number-wrap">' + data + '</div></div>';

        legendWrapper.append(legendBlock);
    }

    // --- *** End of section to Populate legend for General Summary Chart *** ---


    /* === End of Chart for General Summary Chart === */






    /* === Chart for Commercial Summary Chart === */

    var commercialData = {

        labels: ["Lucie", "Bertrand", "Gregory", "Benjamin"],
        datasets: [{
            data: [30000, 20000, 20000, 20000],
            maxBarThickness: 20,
            backgroundColor: '#9966ff'
        }]
    };

    function formatCurrencyNumber(number) {

        // Convert value to string and split each 3 digits from the end
        var value = number.toString();
        value = value.split(/(?=(?:...)*$)/);

        // Format value to currency
        value = value.join(' ');
        return value + ' €';

    }

    let commercialSumCanvas = document.querySelector('.dashboard-late-payment-wrapper .all-chart-wrapper .commercial-summary-block canvas').getContext('2d');

    let commercialChartData = new Chart(commercialSumCanvas, {

        type: 'horizontalBar',
        data: commercialData,
        options: {
            responsive: false,
            //aspectRatio: 2,
            //aspectRatio: 2.5,
            //aspectRatio: 1.546398,
            //aspectRatio: 1.518,
            aspectRatio: 1.55,
            //aspectRatio: 1.63,
            //aspectRatio: 0.8,
            maintainAspectRatio: false,
            legend: { display: false },
            scales: {
                xAxes: [{
                    stacked: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return formatCurrencyNumber(value);
                        }
                    }
                }],
            },
            tooltips: {
                displayColors: false,
                callbacks: {
                    label: function(tooltipItems, data) {
                        return formatCurrencyNumber(tooltipItems.xLabel);
                    }
                }
            }
        }

    });

    /* === End of Chart for Commercial Summary Chart === */



});
