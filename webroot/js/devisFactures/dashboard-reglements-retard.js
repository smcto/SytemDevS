$(document).ready(function(){


    // === Remove dashboard period wrapper ===
    $('.dashboard-main-wrapper').find('.page-titles .dashboard-header-period-wrapper').remove();
    // === End of section to Remove dashboard period wrapper ===



    // Get total CA invoiced
    var totalCAInvoiced = $('[name="totalFactures"]').val();


    /* === Chart for Facture Attente Summary === */

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .total-summary-block .en-attente-block';

    var totalFactureAttente = parseFloat($('[name="totalFacturesNonReglees"]').val());

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
            aspectRatio: getChartRatio(3.5, summaryBlockClass),
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

    var totalFactureRetard = parseFloat($('[name="totalFacturesEnRetard"]').val());

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
            aspectRatio: getChartRatio(3.5, summaryBlockClass),
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

    var sommeDueAmounts = [
        parseFloat($('[name="totalFacturesDelai"]').val()),
        parseFloat($('[name="totalFacturesEnRetardInferieure30js"]').val()),
        parseFloat($('[name="totalFacturesEnRetardEntre30j60js"]').val()),
        parseFloat($('[name="totalFacturesEnRetardEntre60j90js"]').val()),
        parseFloat($('[name="totalFacturesEnRetardSuperieure90js"]').val())
    ];
    var nbInvoices = [
        parseFloat($('[name="nbFacturesEnDelai"]').val()),
        parseFloat($('[name="nbFacturesEnRetardInferieure30js"]').val()),
        parseFloat($('[name="nbFacturesEnRetardEntre30j60js"]').val()),
        parseFloat($('[name="nbFacturesEnRetardEntre60j90js"]').val()),
        parseFloat($('[name="nbFacturesEnRetardSuperieure90js"]').val()),
    ];

    var sommeDueData = {

        labels: ["En délai", "< 30 jrs de retard", "Entre 30 et 60 jrs de retard", "Entre 60 et 90 jrs de retard", "> 90 jrs de retard"],
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
            aspectRatio: getChartRatio(0.9, summaryBlockClass),
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



    /* === Chart for Attente Reglement Summary === */

    var attenteReglementAmounts = [
        parseFloat($('[name="facturesEnAttentedEvent"]').val()), 
        parseFloat($('[name="facturesEnAttentedLocFi"]').val()), 
        parseFloat($('[name="facturesEnAttentedVente"]').val()), 
        parseFloat($('[name="facturesEnAttentedPart"]').val())
    ];

    var attenteReglementData = {

        labels: ["Loc'event pro", "Loc'fi", "Achat", "Particuliers"],
        datasets: [{
            data: getDataPercents(attenteReglementAmounts),
            backgroundColor: ['#01caf1', '#ff4f70', '#22ca80', '#fcba03']
        }]
    };

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .attente-reglement-summary-block';
    let attenteReglementSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let attenteReglementChartData = new Chart(attenteReglementSumCanvas, {

        type: 'pie',
        data: attenteReglementData,
        options: {
            //aspectRatio: 1.5205,
            //aspectRatio: getChartRatio(1.5205, summaryBlockClass),
            aspectRatio: getChartRatio(2, summaryBlockClass),
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function (chart) {
                return populateChartLegend(chart, summaryBlockClass, attenteReglementAmounts);
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
    $(summaryBlockClass + ' .legend-wrapper').append(attenteReglementChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), attenteReglementChartData );
    });


    /* === End of Chart for Attente Reglement Summary === */



    /* === Chart for Invoice Type Summary === */

    var invoiceTypeAmounts = [
        parseFloat($('[name="facturesRetardEvent"]').val()),
        parseFloat($('[name="facturesRetardLocFi"]').val()),
        parseFloat($('[name="facturesRetardVente"]').val()),
        parseFloat($('[name="facturesRetardPart"]').val())
    ];

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
            //aspectRatio: 1.5205,
            //aspectRatio: getChartRatio(1.5205, summaryBlockClass),
            aspectRatio: getChartRatio(2, summaryBlockClass),
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
            data: [
                parseFloat($('[name="facturesEnAttenteReglementLucie"]').val()),
                parseFloat($('[name="facturesEnAttenteReglementBertrant"]').val()), 
                parseFloat($('[name="facturesEnAttenteReglementGregory"]').val()), 
                parseFloat($('[name="facturesEnAttenteReglementBenjamin"]').val()), 
            ],
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
            //aspectRatio: 0.935,
            //aspectRatio: getChartRatio(0.935, summaryBlockClass),
            aspectRatio: getChartRatio(1.143, summaryBlockClass),
            maintainAspectRatio: false,
            legend: { display: false },
            hover: {
                animationDuration: 0
            },
            animation: {
                onComplete: function() {
                    displayBarChartAmounts(this.chart, this.data.datasets);
                }
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return formatCurrencyNumber(value, 0);
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
                        return formatCurrencyNumber(tooltipItems.xLabel, 0);
                    }
                }
            }
        }

    });

    /* === End of Horizontal Bar Chart for Commercial Summary === */



    /* === Horizontal Bar Chart for Commercial Retard Summary === */

    var barCommercialRetardData = {

        labels: ["Lucie", "Bertrand", "Gregory", "Benjamin"],
        datasets: [{
            data: [
                parseFloat($('[name="facturesRetardLucie"]').val()),
                parseFloat($('[name="facturesRetardBertrant"]').val()), 
                parseFloat($('[name="facturesRetardGregory"]').val()), 
                parseFloat($('[name="facturesRetardBenjamin"]').val()), 
            ],
            maxBarThickness: 20,
            backgroundColor: '#9966ff'
        }]
    };

    var summaryBlockClass = '.retard-reglement-dashboard-wrapper .all-chart-wrapper .commercial-retard-sum-block';
    let barCommercialRetardSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let barCommercialRetardChartData = new Chart(barCommercialRetardSumCanvas, {

        type: 'horizontalBar',
        data: barCommercialRetardData,
        options: {
            //aspectRatio: 0.935,
            //aspectRatio: getChartRatio(0.935, summaryBlockClass),
            aspectRatio: getChartRatio(1.143, summaryBlockClass),
            maintainAspectRatio: false,
            legend: { display: false },
            hover: {
                animationDuration: 0
            },
            animation: {
                onComplete: function() {
                    displayBarChartAmounts(this.chart, this.data.datasets);
                }
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return formatCurrencyNumber(value, 0);
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
                        return formatCurrencyNumber(tooltipItems.xLabel, 0);
                    }
                }
            }
        }

    });

    /* === End of Horizontal Bar Chart for Commercial Retard Summary === */




});
