$(document).ready(function(){

    /* === Chart for General Summary Chart === */

    function formatCurrencyNumber(number) {

        // Convert value to string and split each 3 digits from the end
        var value = number.toString();
        value = value.split(/(?=(?:...)*$)/);

        // Format value to currency
        value = value.join(' ');
        return value + ' €';

    }

    var generalData = {

        labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre'],
        datasets: [
            {
                data: [15000, 97400, 7000, 80, 107, 6300, 7410, 221, 783, 41478],
                label: "Règlements",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
            }, {
                data: [5000, 350, 756, 6046, 635, 809, 4100, 1402, 3700, 5267],
                label: "Professionnels",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
            }, {
                data: [10000, 75210, 74564, 6870, 400, 630, 3214, 547, 450, 734],
                label: "Particuliers",
                borderColor: "#22ca80",
                backgroundColor: "#22ca80",
                fill: false
            }
        ]
    };

    let generalSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .general-summary-block canvas').getContext('2d');

    let generalChartData = new Chart(generalSumCanvas, {

        type: 'line',
        data: generalData,
        options: {
            aspectRatio: 2.9,
            scales: {
                yAxes: [{
                    ticks: {
                        callback: function(value, index, values) {
                            return formatCurrencyNumber(value);
                        }
                    }
                }],
            },
            legend: {
                padding: 20
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return data.datasets[tooltipItems.datasetIndex].label + ' ' + formatCurrencyNumber(tooltipItems.yLabel);
                    }
                }
            }
        }

    });

    /* === End of section for Chart for General Summary Chart === */

});
