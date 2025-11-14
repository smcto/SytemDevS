$(document).ready(function(){

    /* === Chart for General Summary === */

    var generalData = {

        datasets: [
            {
                data: [
                    {
                        x: new Date("2020-1-1"),
                        y: 5870
                    },{
                        x: new Date("2020-2-1"),
                        y: 4850
                    },{
                        x: new Date("2020-3-1"),
                        y: 2680
                    },{
                        x: new Date("2020-4-2"),
                        y: 3478
                    },{
                        x: new Date("2020-5-3"),
                        y: 3046
                    },{
                        x: new Date("2020-6-4"),
                        y: 2000
                    },{
                        x: new Date("2020-7-5"),
                        y: 813
                    },{
                        x: new Date("2020-8-6"),
                        y: 1500
                    },{
                        x: new Date("2020-9-7"),
                        y: 2963
                    },{
                        x: new Date("2020-10-8"),
                        y: 6267
                    }],
                label: "Total",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
            }, {
                data: [
                    {
                        x: new Date("2020-1-2"),
                        y: 5000
                    },{
                        x: new Date("2020-2-6"),
                        y: 4500
                    },{
                        x: new Date("2020-3-4"),
                        y: 995
                    },{
                        x: new Date("2020-5-20"),
                        y: 1200
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
                        y: 2500
                    },{
                        x: new Date("2020-10-1"),
                        y: 5267
                    }],
                label: "Loc'fi",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
            }, {
                data: [
                    {
                        x: new Date("2020-1-5"),
                        y: 1310
                    },{
                        x: new Date("2020-2-2"),
                        y: 460
                    },{
                        x: new Date("2020-3-14"),
                        y: 2785
                    },{
                        x: new Date("2020-4-9"),
                        y: 600
                    },{
                        x: new Date("2020-5-11"),
                        y: 2000
                    },{
                        x: new Date("2020-6-18"),
                        y: 1700
                    },{
                        x: new Date("2020-7-14"),
                        y: 754
                    },{
                        x: new Date("2020-8-20"),
                        y: 547
                    },{
                        x: new Date("2020-9-8"),
                        y: 450
                    },{
                        x: new Date("2020-10-3"),
                        y: 1560
                    }],
                label: "Ventes",
                borderColor: "#22ca80",
                backgroundColor: "#22ca80",
                fill: false
            }
        ]
    };

    var summaryBlockClass = '.vente-consommable-dashboard-wrapper .all-chart-wrapper .general-summary-block';
    let generalSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let generalChartData = new Chart(generalSumCanvas, {

        type: 'line',
        data: generalData,
        options: {
            aspectRatio: getLineChartRatio(2.9),
            elements: {
                line: {
                    tension: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        borderDash: [2, 2],
                        lineWidth: 1,
                    },
                    type: 'time',
                    time: {
                        unit: 'month',
                        //tooltipFormat: 'D MMM YYYY',
                        tooltipFormat: 'MMM YYYY',
                        displayFormats: {
                            //day: 'D MMM YY',
                            month: 'MMM YY'
                        }
                    },
                    ticks: {
                        min: new Date("2020/01/01")
                        //min: getLineMinDate()
                    },
                    distribution: 'linear'
                }],
                yAxes: [{
                    gridLines: {
                        borderDash: [2, 2],
                        lineWidth: 2,
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            return formatCurrencyNumber(value);
                        }
                    }
                }],
            },
            legend: {
                display: false
            },
            legendCallback: function(chart) {
                return populateChartLegend(chart, summaryBlockClass);
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getLineChartCurrencyTooltip(tooltipItems, data);
                    }
                }
            }
        }

    });

    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(generalChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), generalChartData );
    });

    /* === End of section for General Summary Chart === */


    /* === Chart for Loc-fi Vente Summary === */

    var locFiAmounts = [6300, 3700];

    var locFiVenteData = {

        labels: ["Loc'fi", "Ventes"],
        datasets: [{
            data: getDataPercents(locFiAmounts),
            backgroundColor: ['#01caf1', '#22ca80']
        }]
    };

    var summaryBlockClass = '.vente-consommable-dashboard-wrapper .all-chart-wrapper .loc-fi-vente-summary-block';
    let locFiVenteSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let locFiVenteChartData = new Chart(locFiVenteSumCanvas, {

        type: 'doughnut',
        data: locFiVenteData,
        options: {
            /* responsive: false, */
            //aspectRatio: 1.405,
            aspectRatio: 1.5205,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function(chart) {
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
            cutoutPercentage: 80,
            rotation: 89
        }

    });

    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(locFiVenteChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), locFiVenteChartData );
    });


    /* === End of Chart for Loc-fi Vente Summary === */




    /* === Chart for Commercial Summary === */

    var commercialData = {

        labels: ["Lucie", "Bertrand", "Gregory", "Benjamin"],
        datasets: [{
            data: [30000, 20000, 20000, 20000],
            maxBarThickness: 20,
            backgroundColor: '#9966ff'
        }]
    };

    var summaryBlockClass = '.vente-consommable-dashboard-wrapper .all-chart-wrapper .commercial-summary-block';
    let commercialSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

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



    // === Get table general search results ===

    $(document).on('keyup', '.customized-input-search input', function() {

        // Call function to get table general search results
        getTableGeneralSearchResults( $(this), '.summary-block' );


    });

    // === End of function to Get table general search results ===


});
