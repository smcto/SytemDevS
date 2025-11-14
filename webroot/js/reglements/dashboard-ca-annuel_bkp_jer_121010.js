$(document).ready(function(){

    /* === Chart for General Summary === */

    var generalData = {

        datasets: [
            {
                data: [
                    {
                        x: new Date("2019-11-1"),
                        y: 97560
                    },{
                        x: new Date("2019-12-1"),
                        y: 38000
                    },{
                        x: new Date("2020-1-1"),
                        y: 15000
                    },{
                        x: new Date("2020-2-2"),
                        y: 97400
                    },{
                        x: new Date("2020-3-3"),
                        y: 7000
                    },{
                        x: new Date("2020-4-4"),
                        y: 80
                    },{
                        x: new Date("2020-5-5"),
                        y: 107
                    },{
                        x: new Date("2020-6-6"),
                        y: 6300
                    },{
                        x: new Date("2020-7-7"),
                        y: 7410
                    },{
                        x: new Date("2020-8-8"),
                        y: 221
                    },{
                        x: new Date("2020-9-9"),
                        y: 783
                    },{
                        x: new Date("2020-10-4"),
                        y: 41478
                    }],
                label: "Total",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
            }, {
                data: [
                    {
                        x: new Date("2019-11-3"),
                        y: 75060
                    },{
                        x: new Date("2019-12-1"),
                        y: 27500
                    },{
                        x: new Date("2020-1-2"),
                        y: 5000
                    },{
                        x: new Date("2020-2-6"),
                        y: 14500
                    },{
                        x: new Date("2020-3-4"),
                        y: 756
                    },{
                        x: new Date("2020-5-20"),
                        y: 6046
                    },{
                        x: new Date("2020-6-4"),
                        y: 635
                    },{
                        x: new Date("2020-7-3"),
                        y: 809
                    },{
                        x: new Date("2020-8-19"),
                        y: 4100
                    },{
                        x: new Date("2020-9-17"),
                        y: 1402
                    },{
                        x: new Date("2020-9-20"),
                        y: 3700
                    },{
                        x: new Date("2020-10-1"),
                        y: 5267
                    }],
                label: "Professionnels",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
            }, {
                data: [
                    {
                        x: new Date("2019-11-6"),
                        y: 60674
                    },{
                        x: new Date("2019-12-3"),
                        y: 22450
                    },{
                        x: new Date("2020-2-24"),
                        y: 10000
                    },{
                        x: new Date("2020-3-2"),
                        y: 75210
                    },{
                        x: new Date("2020-3-14"),
                        y: 74564
                    },{
                        x: new Date("2020-4-9"),
                        y: 6870
                    },{
                        x: new Date("2020-5-11"),
                        y: 400
                    },{
                        x: new Date("2020-6-18"),
                        y: 630
                    },{
                        x: new Date("2020-7-14"),
                        y: 3214
                    },{
                        x: new Date("2020-8-20"),
                        y: 547
                    },{
                        x: new Date("2020-9-8"),
                        y: 450
                    },{
                        x: new Date("2020-9-27"),
                        y: 734
                    }],
                label: "Particuliers",
                borderColor: "#22ca80",
                backgroundColor: "#22ca80",
                fill: false
            }
        ]
    };

    let generalSumCanvas = document.querySelector('.chiffre-affaires-dashboard-wrapper .all-chart-wrapper .general-summary-block canvas').getContext('2d');

    let generalChartData = new Chart(generalSumCanvas, {

        type: 'line',
        data: generalData,
        options: {
            aspectRatio: 2.9,
            elements: {
                line: {
                    tension: 0
                }
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        unit: 'month',
                        tooltipFormat: 'D MMM YYYY',
                        displayFormats: {
                            day: 'D MMM'
                        },
                        min: new Date("2020/01/01")
                    },
                    distribution: 'linear'
                }],
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
                        return data.datasets[tooltipItems.datasetIndex].label + ': ' + formatCurrencyNumber(tooltipItems.yLabel);
                    }
                }
            }
        }

    });

    /* === End of section for General Summary Chart === */



    /* === Chart for Devis Summary === */

    var devisData = {

        labels: ["Selfizee pro", "Selfizee part", "Selfizee loc'fi", "Selfizee achat"],
        datasets: [{
            data: [40, 60, 55, 30],
            backgroundColor: ['#01caf1', '#22ca80', '#ff4f70', '#fcba03']
        }]
    };

    let devisSumCanvas = document.querySelector('.chiffre-affaires-dashboard-wrapper .all-chart-wrapper .devis-summary-block canvas').getContext('2d');

    let devisChartData = new Chart(devisSumCanvas, {

        type: 'doughnut',
        data: devisData,
        options: {
            /* responsive: false, */
            //aspectRatio: 1.405,
            aspectRatio: 1.5205,
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return data['labels'][ tooltipItems['index'] ] + ': ' + data['datasets'][0]['data'][ tooltipItems['index'] ] + '%';
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            cutoutPercentage: 80,
            rotation: 89
        }

    });

    // Call function to populate legend for Payment Type Chart
    populateChartLegend( $('.chiffre-affaires-dashboard-wrapper .all-chart-wrapper .devis-summary-block .legend-wrapper'), devisChartData );


    /* === End of Chart for Devis Summary === */




    /* === Chart for Commercial Summary === */

    var commercialData = {

        labels: ["Lucie", "Bertrand", "Gregory", "Benjamin"],
        datasets: [{
            data: [30000, 20000, 20000, 20000],
            maxBarThickness: 20,
            backgroundColor: '#9966ff'
        }]
    };

    let commercialSumCanvas = document.querySelector('.chiffre-affaires-dashboard-wrapper .all-chart-wrapper .commercial-summary-block canvas').getContext('2d');

    let commercialChartData = new Chart(commercialSumCanvas, {

        type: 'horizontalBar',
        data: commercialData,
        options: {
            /* responsive: false, */
            aspectRatio: 2.1,
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

    /* === End of Chart for Commercial Summary === */




});
