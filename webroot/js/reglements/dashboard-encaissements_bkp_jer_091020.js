$(document).ready(function(){

    /* === Chart for General Summary Chart === */

    moment.locale('fr');

    function formatCurrencyNumber(number) {

        // Convert value to string and split each 3 digits from the end
        var value = number.toString();
        value = value.split(/(?=(?:...)*$)/);

        // Format value to currency
        value = value.join(' ');
        return value + ' €';

    }

    var generalData = {

        //labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre'],
        //labels: [time],
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

    let generalSumCanvas = document.querySelector('.encaissement-dashboard-wrapper .all-chart-wrapper .general-summary-block canvas').getContext('2d');

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
                        }
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

    /* === End of section for Chart for General Summary Chart === */

});
