$(document).ready(function(){


    /* === Pie Chart for General Summary === */

    var pieGeneralAmounts = [40000, 30000, 10000, 15000, 24000, 7000];

    var pieGeneralData = {

        labels: ["Selfizee pro", "Selfizee part", "Selfizee loc'fi", "Selfizee vente", "Brandeet", "Digitea"],
        datasets: [{
            data: getDataPercents(pieGeneralAmounts),
            backgroundColor: ['#fcba03', '#FF0099', '#22ca80', '#9966ff', '#ff4f70', '#01caf1']
        }]
    };

    let pieGeneralSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .general-summary-block.pie-chart-sum-block canvas').getContext('2d');

    let pieGeneralChartData = new Chart(pieGeneralSumCanvas, {

        type: 'pie',
        data: pieGeneralData,
        options: {
            //aspectRatio: 2.5,
            //aspectRatio: 1.27,
            //aspectRatio: 1.805,
            aspectRatio: 1.575,
            //maintainAspectRatio: false,
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(tooltipItems, data) {
                        return getPercentageTooltip( tooltipItems, data, pieGeneralAmounts[ tooltipItems['index'] ] );
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

    // Call function to populate legend for Payment Type Chart
    populateChartLegend( $('.encaissement-dashboard-wrapper .all-chart-wrapper .general-summary-block.pie-chart-sum-block .legend-wrapper'), pieGeneralChartData, pieGeneralAmounts );


    /* === End of Pie Chart for General Summary === */


    /* === Line Chart for General Summary === */

    var monthlyAmounts = [4600, 3290, 3100, 1480, 6450, 5120, 7415, 9782, 7500, 17810];

    var barGeneralData = {

        datasets: [
            {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 3000
                    },{
                        x: new Date("2020-2"),
                        y: 2750
                    },{
                        x: new Date("2020-3"),
                        y: 420
                    },{
                        x: new Date("2020-4"),
                        y: 874
                    },{
                        x: new Date("2020-5"),
                        y: 750
                    },{
                        x: new Date("2020-6"),
                        y: 1745
                    },{
                        x: new Date("2020-7"),
                        y: 2300
                    },{
                        x: new Date("2020-8"),
                        y: 985
                    },{
                        x: new Date("2020-9"),
                        y: 1240
                    },{
                        x: new Date("2020-10"),
                        y: 3600
                    }],
                label: "Selfizee pro",
                borderColor: "#fcba03",
                backgroundColor: "#fcba03",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 4000
                    },{
                        x: new Date("2020-2"),
                        y: 620
                    },{
                        x: new Date("2020-3"),
                        y: 798
                    },{
                        x: new Date("2020-4"),
                        y: 5410
                    },{
                        x: new Date("2020-5"),
                        y: 987
                    },{
                        x: new Date("2020-6"),
                        y: 1300
                    },{
                        x: new Date("2020-7"),
                        y: 297
                    },{
                        x: new Date("2020-8"),
                        y: 8745
                    },{
                        x: new Date("2020-9"),
                        y: 6547
                    },{
                        x: new Date("2020-10"),
                        y: 5000
                    }],
                label: "Selfizee part",
                borderColor: "#FF0099",
                backgroundColor: "#FF0099",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 1980
                    },{
                        x: new Date("2020-2"),
                        y: 684
                    },{
                        x: new Date("2020-3"),
                        y: 1475
                    },{
                        x: new Date("2020-4"),
                        y: 200
                    },{
                        x: new Date("2020-5"),
                        y: 120
                    },{
                        x: new Date("2020-6"),
                        y: 600
                    },{
                        x: new Date("2020-7"),
                        y: 841
                    },{
                        x: new Date("2020-8"),
                        y: 3541
                    },{
                        x: new Date("2020-9"),
                        y: 4000
                    },{
                        x: new Date("2020-10"),
                        y: 6900
                    }],
                label: "Selfizee loc'fi",
                borderColor: "#22ca80",
                backgroundColor: "#22ca80",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 4500
                    },{
                        x: new Date("2020-2"),
                        y: 1780
                    },{
                        x: new Date("2020-3"),
                        y: 2840
                    },{
                        x: new Date("2020-4"),
                        y: 861
                    },{
                        x: new Date("2020-5"),
                        y: 784
                    },{
                        x: new Date("2020-6"),
                        y: 930
                    },{
                        x: new Date("2020-7"),
                        y: 6745
                    },{
                        x: new Date("2020-8"),
                        y: 2160
                    },{
                        x: new Date("2020-9"),
                        y: 7410
                    },{
                        x: new Date("2020-10"),
                        y: 9630
                    }],
                label: "Selfizee vente",
                borderColor: "#9966ff",
                backgroundColor: "#9966ff",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 4500
                    },{
                        x: new Date("2020-2"),
                        y: 3242
                    },{
                        x: new Date("2020-3"),
                        y: 1745
                    },{
                        x: new Date("2020-4"),
                        y: 2780
                    },{
                        x: new Date("2020-5"),
                        y: 975
                    },{
                        x: new Date("2020-6"),
                        y: 4750
                    },{
                        x: new Date("2020-7"),
                        y: 800
                    },{
                        x: new Date("2020-8"),
                        y: 8541
                    },{
                        x: new Date("2020-9"),
                        y: 1900
                    },{
                        x: new Date("2020-10"),
                        y: 7700
                    }],
                label: "Brandeet",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false,
                maxBarThickness: getBarThickness()
            }, {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 1230
                    },{
                        x: new Date("2020-2"),
                        y: 500
                    },{
                        x: new Date("2020-3"),
                        y: 745
                    },{
                        x: new Date("2020-4"),
                        y: 1780
                    },{
                        x: new Date("2020-5"),
                        y: 3680
                    },{
                        x: new Date("2020-6"),
                        y: 2145
                    },{
                        x: new Date("2020-7"),
                        y: 520
                    },{
                        x: new Date("2020-8"),
                        y: 4123
                    },{
                        x: new Date("2020-9"),
                        y: 2000
                    },{
                        x: new Date("2020-10"),
                        y: 8730
                    }],
                label: "Digitea",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false,
                maxBarThickness: getBarThickness()
            }
        ]
    };

    let barGeneralSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .general-summary-block.bar-chart-sum-block canvas').getContext('2d');

    let barGeneralChartData = new Chart(barGeneralSumCanvas, {

        type: 'bar',
        data: barGeneralData,
        options: {
            //aspectRatio: getLineChartRatio(),
            //aspectRatio: 2.3,
            aspectRatio: 1.84,
            elements: {
                line: {
                    tension: 0
                }
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    },
                    type: 'time',
                    time: {
                        unit: 'month',
                        tooltipFormat: 'MMM YYYY',
                        displayFormats: {
                            day: 'MMM'
                        }
                    },
                    distribution: 'linear',
                    ticks: {
                        callback: function(value, index, values) {
                            return [value, '', formatCurrencyNumber(monthlyAmounts[index])];
                        }
                    }
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
                return populateTopChartLegend(chart);
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

    $('.encaissement-dashboard-wrapper .all-chart-wrapper .general-summary-block.bar-chart-sum-block .outer-top-legend-wrapper').append(barGeneralChartData.generateLegend());


    // --- Update chart when clicking legend block ---

    var legendBlock = '.encaissement-dashboard-wrapper .all-chart-wrapper .general-summary-block.bar-chart-sum-block .outer-top-legend-wrapper .legend-block';

    $(document).on('click', legendBlock, function(){

        // Update monthly amounts
        monthlyAmounts = [4600, 3290, 3100, 1480, 6450, 5120, 7415, 9782, 7500, 17810];

        // Call function to update chart
        updateChart( $(this), barGeneralChartData );

    });


    /* === End of section for Line Chart for General Summary === */




    /* === Chart for Evolution Summary === */

    var monthlyAmounts = [17000, 97500, 7500, 640, 875, 6450, 7415, 340, 791, 42300];

    var evolutionData = {

        datasets: [
            {
                data: [
                    {
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

    let evolutionSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .evolution-summary-block canvas').getContext('2d');

    let evolutionChartData = new Chart(evolutionSumCanvas, {

        type: 'line',
        data: evolutionData,
        options: {
            aspectRatio: getLineChartRatio(),
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
                        tooltipFormat: 'D MMM YYYY',
                        displayFormats: {
                            day: 'D MMM'
                        }
                    },
                    distribution: 'linear',
                    ticks: {
                        callback: function(value, index, values) {
                            return [value, '', formatCurrencyNumber(monthlyAmounts[index])];
                        }
                    }
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
                //return populateTopChartLegend(chart);
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

    //$('.encaissement-dashboard-wrapper .all-chart-wrapper .evolution-summary-block .outer-top-legend-wrapper').append(evolutionChartData.generateLegend());

    /* === End of section for Evolution Summary Chart === */


    /* === Pie Chart for Payment Type Summary === */

    var piePaymentAmounts = [7000, 4000, 3000];

    var piePaymentData = {

        labels: ["CB", "Vir. bancaire", "Chèque"],
        datasets: [{
            data: getDataPercents(piePaymentAmounts),
            backgroundColor: ['#01caf1', '#ff4f70', '#fcba03']
        }]
    };

    let piePaymentSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.pie-chart-sum-block canvas').getContext('2d');

    let piePaymentChartData = new Chart(piePaymentSumCanvas, {

        type: 'pie',
        data: piePaymentData,
        options: {
            //aspectRatio: 2.5,
            //aspectRatio: 1.27,
            //aspectRatio: 1.731,
            aspectRatio: 1.505,
            //maintainAspectRatio: false,
            legend: { display: false },
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

    // Call function to populate legend for Payment Type Chart
    populateChartLegend( $('.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.pie-chart-sum-block .legend-wrapper'), piePaymentChartData, piePaymentAmounts );


    /* === End of Pie Chart for Payment Type Summary === */



    /* === Line Chart for Payment Type Summary === */

    var linePaymentData = {

        datasets: [
            {
                data: [
                    {
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
                label: "CB",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
            }, {
                data: [
                    {
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
                label: "Vir. bancaire",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
            }, {
                data: [
                    {
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
                label: "Chèque",
                borderColor: "#fcba03",
                backgroundColor: "#fcba03",
                fill: false
            }
        ]
    };

    let linePaymentSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.line-chart-sum-block canvas').getContext('2d');

    let linePaymentChartData = new Chart(linePaymentSumCanvas, {

        type: 'line',
        data: linePaymentData,
        options: {
            //aspectRatio: getLineChartRatio(),
            aspectRatio: 2.3,
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
                        tooltipFormat: 'D MMM YYYY',
                        displayFormats: {
                            day: 'D MMM'
                        }
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
                //return populateTopChartLegend(chart);
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

    //$('.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.line-chart-sum-block .outer-top-legend-wrapper').append(linePaymentChartData.generateLegend());

    /* === End of section for Line Chart for Payment Type Summary === */



    /* === Pie Chart for Bank Summary === */

    var pieBankAmounts = [70000, 45000, 180000];

    var pieBankData = {

        labels: ["BPO", "CIC", "CA"],
        datasets: [{
            data: getDataPercents(pieBankAmounts),
            backgroundColor: ['#16b1e6', '#0f228b', '#007d8f']
        }]
    };

    let pieBankSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.pie-chart-sum-block canvas').getContext('2d');

    let pieBankChartData = new Chart(pieBankSumCanvas, {

        type: 'pie',
        data: pieBankData,
        options: {
            //aspectRatio: 2.5,
            //aspectRatio: 1.27,
            //aspectRatio: 1.731,
            aspectRatio: 1.505,
            //maintainAspectRatio: false,
            legend: { display: false },
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

    // Call function to populate legend for Payment Type Chart
    populateChartLegend( $('.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.pie-chart-sum-block .legend-wrapper'), pieBankChartData, pieBankAmounts );


    /* === End of Pie Chart for Bank Summary === */


    /* === Line Chart for Bank Summary === */

    var lineBankData = {

        datasets: [
            {
                data: [
                    {
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
                label: "BPO",
                borderColor: "#16b1e6",
                backgroundColor: "#16b1e6",
                fill: false
            }, {
                data: [
                    {
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
                label: "CIC",
                borderColor: "#0f228b",
                backgroundColor: "#0f228b",
                fill: false
            }, {
                data: [
                    {
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
                label: "CA",
                borderColor: "#007d8f",
                backgroundColor: "#007d8f",
                fill: false
            }
        ]
    };

    let lineBankSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.line-chart-sum-block canvas').getContext('2d');

    let lineBankChartData = new Chart(lineBankSumCanvas, {

        type: 'line',
        data: lineBankData,
        options: {
            //aspectRatio: getLineChartRatio(),
            aspectRatio: 2.3,
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
                        tooltipFormat: 'D MMM YYYY',
                        displayFormats: {
                            day: 'D MMM'
                        }
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
                //return populateTopChartLegend(chart);
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

    //$('.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.line-chart-sum-block .outer-top-legend-wrapper').append(lineBankChartData.generateLegend());

    /* === End of section for Line Chart for Bank Summary === */



});
