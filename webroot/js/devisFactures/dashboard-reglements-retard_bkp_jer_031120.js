$(document).ready(function(){


    // === Remove dashboard period wrapper ===
    $('.dashboard-main-wrapper').find('.page-titles .dashboard-header-period-wrapper').remove();
    // === End of section to Remove dashboard period wrapper ===


    function getRatioForLargeScreen(ratio) {

        return( window.matchMedia("(min-width: 1440px)").matches ? 1.25 : ratio );
    }


    function getGaugeRatioForLargeScreen(ratio) {

        return( window.matchMedia("(min-width: 1440px)").matches ? 5.25 : ratio );
    }



    // Get total CA invoiced
    var totalCAInvoiced = 600000;


    /* === Chart for Facture Attente Summary === */

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .total-summary-block .en-attente-block';

    var totalFactureAttente = 180000;

    var factureAttenteAmounts = [totalFactureAttente, totalCAInvoiced - totalFactureAttente];

    // Display total amount invoiced
    showTotalAmountInvoiced(summaryBlockClass, totalFactureAttente);

    var factureAttenteData = {

        labels: ["CA factures en attente", "CA facturé restant"],
        datasets: [{
            data: getDataPercents(factureAttenteAmounts),
            backgroundColor: ['#7ba0ff', '#e5ecff']
        }]
    };

    let factureAttenteSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let factureAttenteChartData = new Chart(factureAttenteSumCanvas, {

        type: 'doughnut',
        data: factureAttenteData,
        options: {
            //aspectRatio: 3.5,
            aspectRatio: getGaugeRatioForLargeScreen(3.5),
            maintainAspectRatio: false,
            circumference: Math.PI,
            rotation: Math.PI,
            legend: {
                display: false
            },
            legendCallback: function(chart) {
                return populateGaugeChartLegend(chart, summaryBlockClass, (totalFactureAttente / totalCAInvoiced) * 100);
            },
            tooltips: {
                //enabled: false,
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getPercentageTooltip( tooltipItems, data, factureAttenteAmounts[ tooltipItems['index'] ] );
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            //cutoutPercentage: 73
            cutoutPercentage: 75
        }

    });

    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(factureAttenteChartData.generateLegend());


    /* === End of Chart for Facture Attente Summary === */



    /* === Chart for Facture Attente Summary === */

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .total-summary-block .en-retard-block';

    var totalFactureRetard = 146300;

    var factureRetardAmounts = [totalFactureRetard, totalCAInvoiced - totalFactureRetard];

    // Display total amount invoiced
    showTotalAmountInvoiced(summaryBlockClass, totalFactureRetard);

    var factureRetardData = {

        labels: ["CA factures en retard", "CA facturé restant"],
        datasets: [{
            data: getDataPercents(factureRetardAmounts),
            //backgroundColor: ['#7ba0ff', '#e5ecff']
            //backgroundColor: ['#ff6161', '#e5ecff']
            //backgroundColor: ['#ff5c5c', '#ffcbcb']
            backgroundColor: ['#ff5c5c', '#ffcccc']
        }]
    };

    let factureRetardSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let factureRetardChartData = new Chart(factureRetardSumCanvas, {

        type: 'doughnut',
        data: factureRetardData,
        options: {
            //aspectRatio: 3.5,
            aspectRatio: getGaugeRatioForLargeScreen(3.5),
            maintainAspectRatio: false,
            circumference: Math.PI,
            rotation: Math.PI,
            legend: {
                display: false
            },
            legendCallback: function(chart) {
                return populateGaugeChartLegend(chart, summaryBlockClass, (totalFactureRetard / totalCAInvoiced) * 100);
            },
            tooltips: {
                //enabled: false,
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getPercentageTooltip( tooltipItems, data, factureRetardAmounts[ tooltipItems['index'] ] );
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            //cutoutPercentage: 73
            cutoutPercentage: 75
        }

    });

    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(factureRetardChartData.generateLegend());


    /* === End of Chart for Facture Attente Summary === */




    /* === Chart for Somme Due Summary === */

    var sommeDueAmounts = [4402, 2600, 1384, 901, 650];
    var nbInvoices = [10, 10, 10, 10, 10];

    var sommeDueData = {

        labels: ["En délai", "< 30 jrs de retard", "Entre 30 et 60 jrs de retard", "Entre 60 et 90 jrs de retard", "> 30 jrs de retard"],
        datasets: [{
            data: getDataPercents(sommeDueAmounts),
            backgroundColor: ['#27cb83', '#ffea06', '#ff6f06', '#ff0000', '#000000']
        }]
    };

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .somme-due-summary-block';
    let sommeDueSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let sommeDueChartData = new Chart(sommeDueSumCanvas, {

        type: 'pie',
        data: sommeDueData,
        options: {
            //aspectRatio: 1.1,
            //aspectRatio: 1,
            aspectRatio: getRatioForLargeScreen(0.9),
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function (chart) {
                return populateChartLegend(chart, summaryBlockClass, sommeDueAmounts, nbInvoices);
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
    $(summaryBlockClass + ' .legend-wrapper').append(sommeDueChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), sommeDueChartData );
    });


    /* === End of Chart for Somme Due Summary === */



    /* === Chart for Invoice Type Summary === */

    var invoiceTypeAmounts = [4000, 6000, 5500, 3000];

    var invoiceTypeData = {

        labels: ["Loc'event pro", "Loc'fi", "Achat", "Particuliers"],
        datasets: [{
            data: getDataPercents(invoiceTypeAmounts),
            backgroundColor: ['#01caf1', '#ff4f70', '#22ca80', '#fcba03']
        }]
    };

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .invoice-type-summary-block';
    let invoiceTypeSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let invoiceTypeChartData = new Chart(invoiceTypeSumCanvas, {

        type: 'pie',
        data: invoiceTypeData,
        options: {
            /* responsive: false, */
            //aspectRatio: 1.405,
            aspectRatio: 1.5205,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function (chart) {
                return populateChartLegend(chart, summaryBlockClass, invoiceTypeAmounts);
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
    $(summaryBlockClass + ' .legend-wrapper').append(invoiceTypeChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), invoiceTypeChartData );
    });


    /* === End of Chart for Invoice Type Summary === */




    /* === Horizontal Bar Chart for Commercial Summary === */

    var barCommercialData = {

        labels: ["Lucie", "Bertrand", "Gregory", "Benjamin"],
        datasets: [{
            data: [30000, 20000, 20000, 20000],
            maxBarThickness: 20,
            backgroundColor: '#9966ff'
        }]
    };

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .commercial-summary-block';
    let barCommercialSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let barCommercialChartData = new Chart(barCommercialSumCanvas, {

        type: 'horizontalBar',
        data: barCommercialData,
        options: {
            //aspectRatio: 3.2,
            //aspectRatio: 2.065,
            aspectRatio: 0.935,
            maintainAspectRatio: false,
            legend: { display: false },
            hover: {
                animationDuration: 0
            },
            animation: {
                onComplete: function() {

                    var chartInstance = this.chart,

                    ctx = chartInstance.ctx;

                    //ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);

                    ctx.font = '400 12.1px sans-serif';

                    //ctx.font = 'bold 14px sans-serif';

                    ctx.fillStyle = '#ffffff';
                    //ctx.fontWeight = 'bold',

                    ctx.textAlign = 'right';
                    ctx.textBaseline = 'top';

                    this.data.datasets.forEach(function(dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            var data = formatCurrencyNumber(dataset.data[index]);
                            //ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            ctx.fillText(data, bar._model.x - 10, bar._model.y - 5);
                            //ctx.fillText(data, bar._model.x - 10, bar._model.y - 5.04);
                        });
                    });

                }
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return formatCurrencyNumber(value);
                        }
                    }
                }]
            },
            tooltips: {
                position : 'centerSmall',
                displayColors: false,
                shadow: false,
                borderWidth: 0,
                callbacks: {
                    label: function(tooltipItems, data) {
                        return formatCurrencyNumber(tooltipItems.xLabel);
                    }
                }
            }
        }

    });

    /* === End of Horizontal Bar Chart for Commercial Summary === */




});
