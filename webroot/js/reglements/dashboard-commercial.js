$(document).ready(function(){

    /* === Chart for General Summary === */

    var generalData = {

        datasets: [
            {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 23000
                    },{
                        x: new Date("2020-2"),
                        y: 9400
                    },{
                        x: new Date("2020-3"),
                        y: 7000
                    },{
                        x: new Date("2020-4"),
                        y: 3840
                    },{
                        x: new Date("2020-5"),
                        y: 9510
                    },{
                        x: new Date("2020-6"),
                        y: 8300
                    },{
                        x: new Date("2020-7"),
                        y: 3541
                    },{
                        x: new Date("2020-8"),
                        y: 6450
                    },{
                        x: new Date("2020-9"),
                        y: 2783
                    },{
                        x: new Date("2020-10"),
                        y: 30478
                    }],
                label: "Total CA",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
            }, {
                data: [
                    {
                        x: new Date("2020-1"),
                        y: 12000
                    },{
                        x: new Date("2020-2"),
                        y: 2300
                    },{
                        x: new Date("2020-3"),
                        y: 2874
                    },{
                        x: new Date("2020-4"),
                        y: 120
                    },{
                        x: new Date("2020-5"),
                        y: 5420
                    },{
                        x: new Date("2020-6"),
                        y: 809
                    },{
                        x: new Date("2020-7"),
                        y: 470
                    },{
                        x: new Date("2020-8"),
                        y: 2402
                    },{
                        x: new Date("2020-9"),
                        y: 540
                    },{
                        x: new Date("2020-10"),
                        y: 10267
                    }],
                label: "Total Devis",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
            }
        ]
    };

    var summaryBlockClass = '.commercial-dashboard-wrapper .all-chart-wrapper .general-summary-block';
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



    /* === Chart for Devis Summary === */

    var devisData = {

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
                label: "CA Selfizee Loc'fi",
                borderColor: "#ff4f70",
                backgroundColor: "#ff4f70",
                fill: false
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
                label: "CA Event",
                borderColor: "#01caf1",
                backgroundColor: "#01caf1",
                fill: false
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
                label: "CA Particuliers",
                borderColor: "#22ca80",
                backgroundColor: "#22ca80",
                fill: false
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
                label: "CA Professionnels",
                borderColor: "#fcba03",
                backgroundColor: "#fcba03",
                fill: false
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
                label: "CA Digitea",
                borderColor: "#9966ff",
                backgroundColor: "#9966ff",
                fill: false
            }
        ]
    };

    var summaryBlockClass = '.commercial-dashboard-wrapper .all-chart-wrapper .devis-summary-block .inner-horizontal-chart-wrap';
    let devisSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let devisChartData = new Chart(devisSumCanvas, {

        type: 'line',
        data: devisData,
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
    $(summaryBlockClass + ' .legend-wrapper').append(devisChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), devisChartData );
    });

    /* === End of section for Devis Summary Chart === */



    /* === Chart for Pie Devis Type Summary === */

    var devisTypeAmounts = [40000, 30000, 10000, 15000, 5000];

    var pieDevisTypeData = {

        labels: ["CA Selfizee Loc'fi", "CA Event", "CA Particuliers", "CA Professionnels", "CA Digitea"],
        datasets: [{
            data: getDataPercents(devisTypeAmounts),
            backgroundColor: ['#ff4f70', '#01caf1', '#22ca80', '#fcba03', '#9966ff']
        }]
    };

    var summaryBlockClass = '.commercial-dashboard-wrapper .all-chart-wrapper .devis-summary-block .inner-pie-chart-wrap';
    let pieDevisTypeSumCanvas = document.querySelector(summaryBlockClass + ' canvas').getContext('2d');

    let pieDevisTypeChartData = new Chart(pieDevisTypeSumCanvas, {

        type: 'pie',
        data: pieDevisTypeData,
        options: {
            aspectRatio: 3.9,
            //maintainAspectRatio: false,
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
            rotation: 89
        }

    });

    // Generate legend for legend wrapper
    $(summaryBlockClass + ' .legend-wrapper').append(pieDevisTypeChartData.generateLegend());

    // --- Update chart when clicking legend block ---
    $(document).on('click', summaryBlockClass + ' .legend-wrapper .legend-block', function(){

        // Call function to update chart
        updateChart( $(this), pieDevisTypeChartData );
    });

    /* === End of Chart for Pie Devis Type Summary === */



});
