$(document).ready(function(){

    // Add only pie chart block class when only pie chart are displayed
    $('.encaissement-dashboard-wrapper .all-chart-wrapper .summary-block.d-none + .summary-block').addClass('only-pie-chart-block');

    /* === Chart for Evolution Summary === */

    //var monthlyAmounts = [17000, 97500, 7500, 640, 875, 6450, 7415, 340, 791, 42300];

    var evolutionData = {

        datasets: [
            {
                data: JSON.parse($('[name="courbeTotal"]').val()),
                label: "Total",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
            }, {
                data: JSON.parse($('[name="courbePro"]').val()),
                label: "Professionnels",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
            }, {
                data: JSON.parse($('[name="courbePart"]').val()),
                label: "Particuliers",
                borderColor: "#22ca80",
                backgroundColor: "#22ca80",
                fill: false
            }
        ]
    };

    var summaryBlockClass = '.encaissement-dashboard-wrapper .all-chart-wrapper .evolution-summary-block';
    let evolutionSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let evolutionChartData = new Chart(evolutionSumCanvas, {

        type: 'line',
        data: evolutionData,
        options: {
            aspectRatio: getChartRatio(2.9, summaryBlockClass),
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
                        min: getLineMinDate()
                    },
                    distribution: 'linear',
                    /* ticks: {
                        callback: function(value, index, values) {
                            return [value, '', formatCurrencyNumber(monthlyAmounts[index])];
                        }
                    } */
                }],
                yAxes: [{
                    gridLines: {
                        borderDash: [2, 2],
                        lineWidth: 2,
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            return formatCurrencyNumber(value, 0);
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


    // Display monthly amounts
    //var monthlyAmountWrapper = $('.encaissement-dashboard-wrapper .all-chart-wrapper .evolution-summary-block .monthly-amount-wrapper');
    //displayMonthlyAmounts( monthlyAmounts, monthlyAmountWrapper );

    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(evolutionChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Update monthly amounts
        //monthlyAmounts = [17000, 97500, 7500, 640, 875, 6450, 7415, 340, 791, 42300];

        // Display monthly amounts
        //displayMonthlyAmounts( monthlyAmounts, monthlyAmountWrapper );

        // Call function to update chart
        updateChart( $(this), evolutionChartData );
    });

    /* === End of section for Evolution Summary Chart === */




    /* === Pie Chart for Invoice Type Summary === */

    var pieInvoiceTypeAmounts = [
        parseFloat($('[name="montantFacturesEvent"]').val()),
        parseFloat($('[name="montantFacturesPart"]').val()),
        parseFloat($('[name="montantFacturesLocFi"]').val()),
        parseFloat($('[name="montantFacturesVente"]').val()),
        parseFloat($('[name="montantFacturesBrandeet"]').val()),
        parseFloat($('[name="montantFacturesDigitea"]').val())
    ];
    var nbInvoices = [
        parseFloat($('[name="nbFacturesEvent"]').val()), 
        parseFloat($('[name="nbFacturesPart"]').val()), 
        parseFloat($('[name="nbFacturesLocFi"]').val()), 
        parseFloat($('[name="nbFacturesVente"]').val()), 
        parseFloat($('[name="nbFacturesBrandeet"]').val()),
        parseFloat($('[name="nbFacturesDigitea"]').val()) 
    ];



    var pieInvoiceTypeData = {

        labels: ["Selfizee Event", "Selfizee part", "Selfizee loc'fi", "Selfizee vente", "Brandeet", "Digitea"],
        datasets: [{
            data: getDataPercents(pieInvoiceTypeAmounts),
            backgroundColor: ['#fcba03', '#FF0099', '#22ca80', '#9966ff', '#ff4f70', '#01caf1']
        }]
    };

    var summaryBlockClass = '.encaissement-dashboard-wrapper .all-chart-wrapper .invoice-type-summary-block.pie-chart-sum-block';
    let pieInvoiceTypeSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let pieInvoiceTypeChartData = new Chart(pieInvoiceTypeSumCanvas, {

        type: 'pie',
        data: pieInvoiceTypeData,
        options: {
            //aspectRatio: 2.5,
            //aspectRatio: 1.574,
            aspectRatio: getChartRatio(1.5, summaryBlockClass),
            //maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function (chart) {
                return populateChartLegend(chart, summaryBlockClass, pieInvoiceTypeAmounts, nbInvoices);
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getPercentageTooltip( tooltipItems, data, pieInvoiceTypeAmounts[ tooltipItems['index'] ] );
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
    $(summaryBlockClass + ' .legend-wrapper').append(pieInvoiceTypeChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), pieInvoiceTypeChartData );
    });


    /* === End of Pie Chart for Invoice Type Summary === */


    /* === Bar Chart for Invoice Type Summary === */

    //var monthlyAmounts = [4600, 3290, 3100, 1480, 6450, 5120, 7415, 9782, 7500, 17810];

    var barInvoiceTypeData = {

        datasets: [
            {
                data: JSON.parse($('[name="batonRepartitionFactureSelfizeePro"]').val()),
                label: "Selfizee Event",
                borderColor: "#fcba03",
                backgroundColor: "#fcba03",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: JSON.parse($('[name="batonRepartitionFactureSelfizeePart"]').val()),
                label: "Selfizee part",
                borderColor: "#FF0099",
                backgroundColor: "#FF0099",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: JSON.parse($('[name="batonRepartitionFactureLocFi"]').val()),
                label: "Selfizee loc'fi",
                borderColor: "#22ca80",
                backgroundColor: "#22ca80",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: JSON.parse($('[name="batonRepartitionFactureVente"]').val()),
                label: "Selfizee vente",
                borderColor: "#9966ff",
                backgroundColor: "#9966ff",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: JSON.parse($('[name="batonRepartitionFactureBrandeet"]').val()),
                label: "Brandeet",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: JSON.parse($('[name="batonRepartitionFactureDigitea"]').val()),
                label: "Digitea",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false,
                maxBarThickness: getBarThickness()
            }
        ]
    };

    var summaryBlockClass = '.encaissement-dashboard-wrapper .all-chart-wrapper .invoice-type-summary-block.bar-chart-sum-block';
    let barInvoiceTypeSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let barInvoiceTypeChartData = new Chart(barInvoiceTypeSumCanvas, {

        type: 'bar',
        data: barInvoiceTypeData,
        options: {
            //aspectRatio: 2.3,
            aspectRatio: getChartRatio(1.84, summaryBlockClass),
            elements: {
                line: {
                    tension: 0
                }
            },
            scales: {
                xAxes: [{
                    offset: true,
                    gridLines: {
                        display: false
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
                    /* ticks: {
                        callback: function(value, index, values) {
                            return [value, '', formatCurrencyNumber(monthlyAmounts[index])];
                        }
                    } */
                    ticks: {
                        min: getLineMinDate()
                    },
                    distribution: 'linear',
                }],
                yAxes: [{
                    gridLines: {
                        borderDash: [2, 2],
                        lineWidth: 2,
                    },
                    ticks: {
                        callback: function(value, index, values) {
                            // return value;
                            return formatCurrencyNumber(value, 0);
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
                //mode: 'index',
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getLineChartCurrencyTooltip(tooltipItems, data);
                    }
                }
            }
        }
    });



    // Display monthly amounts
    //var monthlyAmountWrapper = $('.encaissement-dashboard-wrapper .all-chart-wrapper .invoice-type-summary-block.bar-chart-sum-block .monthly-amount-wrapper');
    //displayMonthlyAmounts( monthlyAmounts, monthlyAmountWrapper );


    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(barInvoiceTypeChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Update monthly amounts
        //monthlyAmounts = [4600, 3290, 3100, 1480, 6450, 5120, 7415, 9782, 7500, 17810];

        // Display monthly amounts
        //displayMonthlyAmounts( monthlyAmounts, monthlyAmountWrapper );

        // Call function to update chart
        updateChart( $(this), barInvoiceTypeChartData );
    });


    /* === End of section for Bar Chart for Invoice Type Summary === */



    /* === Pie Chart for Payment Type Summary === */

    // var piePaymentAmounts = [7000, 4000, 3000];
    var piePaymentAmounts = [
        parseFloat($('[name="montantCB"]').val()),
        parseFloat($('[name="montantVirBanc"]').val()),
        parseFloat($('[name="montantCheque"]').val())
    ];
    var nbPayments = [
        parseFloat($('[name="nbCB"]').val()),
        parseFloat($('[name="nbVirBanc"]').val()),
        parseFloat($('[name="nbCheque"]').val())
    ];

    var piePaymentData = {

        labels: ["CB", "Vir. bancaire", "Chèque"],
        datasets: [{
            data: getDataPercents(piePaymentAmounts),
            backgroundColor: ['#01caf1', '#ff4f70', '#fcba03']
        }]
    };

    // console.log(piePaymentAmounts)

    var summaryBlockClass = '.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.pie-chart-sum-block';
    let piePaymentSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let piePaymentChartData = new Chart(piePaymentSumCanvas, {

        type: 'pie',
        data: piePaymentData,
        options: {
            //aspectRatio: 1.505,
            aspectRatio: getChartRatio(1.48, summaryBlockClass),
            //maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function(chart) {
                return populateChartLegend(chart, summaryBlockClass, piePaymentAmounts, nbPayments);
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getPercentageTooltip( tooltipItems, data, piePaymentAmounts[ tooltipItems['index'] ] );
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
    $(summaryBlockClass + ' .legend-wrapper').append(piePaymentChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), piePaymentChartData );
    });

    /* === End of Pie Chart for Payment Type Summary === */



    /* === Line Chart for Payment Type Summary === */

    var linePaymentData = {

        datasets: [
            {
                data: JSON.parse($('[name="courbeCB"]').val()),
                label: "CB",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
            }, {
                data: JSON.parse($('[name="courbeVir"]').val()),
                label: "Vir. bancaire",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
            }, {
                data: JSON.parse($('[name="courbeCheque"]').val()),
                label: "Chèque",
                borderColor: "#fcba03",
                backgroundColor: "#fcba03",
                fill: false
            }
        ]
    };

    var summaryBlockClass = '.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.line-chart-sum-block';
    let linePaymentSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let linePaymentChartData = new Chart(linePaymentSumCanvas, {

        type: 'line',
        data: linePaymentData,
        options: {
            aspectRatio: getChartRatio(2.3, summaryBlockClass),
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
                        min: getLineMinDate()
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
                            // return value;
                            return formatCurrencyNumber(value, 0);
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
    $(summaryBlockClass + ' .legend-wrapper').append(linePaymentChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), linePaymentChartData );
    });

    /* === End of section for Line Chart for Payment Type Summary === */



    /* === Pie Chart for Bank Summary === */

    var pieBankAmounts = [
        parseFloat($('[name="montantBPO"]').val()),
        parseFloat($('[name="montantCIC"]').val()),
        parseFloat($('[name="montantCA"]').val())
    ];

    var pieBankData = {
        labels: ["BPO", "CIC", "CA"],
        datasets: [{
            data: getDataPercents(pieBankAmounts),
            backgroundColor: ['#16b1e6', '#0f228b', '#007d8f']
        }]
    };

    var summaryBlockClass = '.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.pie-chart-sum-block';
    let pieBankSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let pieBankChartData = new Chart(pieBankSumCanvas, {

        type: 'pie',
        data: pieBankData,
        options: {
            //aspectRatio: 1.505,
            aspectRatio: getChartRatio(1.48, summaryBlockClass),
            //maintainAspectRatio: false,
            legend: {
                display: false
            },
            legendCallback: function(chart) {
                return populateChartLegend(chart, summaryBlockClass, pieBankAmounts);
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getPercentageTooltip( tooltipItems, data, pieBankAmounts[ tooltipItems['index'] ] );
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
    $(summaryBlockClass + ' .legend-wrapper').append(pieBankChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), pieBankChartData );
    });

    /* === End of section for Line Chart for Payment Type Summary === */


    /* === End of Pie Chart for Bank Summary === */


    /* === Line Chart for Bank Summary === */

    var lineBankData = {

        datasets: [
            {
                data: JSON.parse($('[name="courbeBPO"]').val()), //[{x: '', y: ''}]
                label: "BPO",
                borderColor: "#16b1e6",
                backgroundColor: "#16b1e6",
                fill: false
            }, {
                data: JSON.parse($('[name="courbeCIC"]').val()),
                label: "CIC",
                borderColor: "#0f228b",
                backgroundColor: "#0f228b",
                fill: false
            }, {
                data: JSON.parse($('[name="courbeCA"]').val()),
                label: "CA",
                borderColor: "#007d8f",
                backgroundColor: "#007d8f",
                fill: false
            }
        ]
    };

    var summaryBlockClass = '.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.line-chart-sum-block';
    let lineBankSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let lineBankChartData = new Chart(lineBankSumCanvas, {

        type: 'line',
        data: lineBankData,
        options: {
            aspectRatio: getChartRatio(2.3, summaryBlockClass),
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
                        min: getLineMinDate()
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
                            // return value;
                            return formatCurrencyNumber(value, 0);
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
    $(summaryBlockClass + ' .legend-wrapper').append(lineBankChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), lineBankChartData );
    });

    /* === End of section for Line Chart for Bank Summary === */



});
