$(document).ready(function(){


    // -----  used by toggle button decimal / precise ---------
    var nbDecimal = 2;

    if ($('[name="nbDecimal"]').length > 0) {

        var nbDecimal = $('[name="nbDecimal"]').val();

    }

    var currentYearFromView = $('[name="currentYear"]').val();

    // Add dashboard-body-content class to body of Dashboard Content Wrapper
    //$('.dashboard-content-wrapper').parents('body').addClass('dashboard-body-content');

    // Add dashboard-two-button-titles class to body of Encaissement Dashboard Wrapper
    $('.encaissement-dashboard-wrapper').parents('body').addClass('dashboard-two-button-titles');

    // Trim dropdown-toggle text
    $('.dropdown').each(function(){

        var dropdownText = $(this).find('.dropdown-toggle').text();
        $(this).find('.dropdown-toggle').text( $.trim( dropdownText ) );

    });

    // Set event for header filter dropdowns
    var headerFilterEvent = 'mousedown';

    // Get selected bootstrap dropdown value
    //$(document).on('click', '.dropdown-menu .dropdown-item', function(){

    $(document).on(headerFilterEvent, '.dropdown-menu .dropdown-item', function(){

        $(this).parents('.dropdown').find('.dropdown-toggle').attr( 'selected-data-value', $(this).attr('data-value') );
        $(this).parents('.dropdown').find('.dropdown-toggle').text( $(this).text() );

        $(this).parents('.dropdown-menu').find('.dropdown-item').removeClass('selected');
        $(this).addClass('selected');

    });


    // Display corresponding dashboard header value
    //$(document).on('click', '.page-titles .dashboard-header-period-wrapper .inner-header-wrap .label-text .dropdown-item', function(){

    $(document).on(headerFilterEvent, '.page-titles .dashboard-header-period-wrapper .inner-header-wrap .label-text .dropdown-item', function(){

        $(this).parents('.inner-header-wrap').find('.dashboard-header-value').removeClass('display');

        if( $(this).attr('data-value') == '1' ) {

            $(this).parents('.inner-header-wrap').find('.label-text').removeClass('dashboard-header-date-wrap');
            $(this).parents('.inner-header-wrap').find('.dashboard-header-previous-month').addClass('display');

        } else if( $(this).attr('data-value') == '2' ) {

            $(this).parents('.inner-header-wrap').find('.label-text').removeClass('dashboard-header-date-wrap');
            $(this).parents('.inner-header-wrap').find('.dashboard-header-year').addClass('display');

        } else if( $(this).attr('data-value') == '3' ) {

            $(this).parents('.inner-header-wrap').find('.label-text').addClass('dashboard-header-date-wrap');
            $(this).parents('.inner-header-wrap').find('.dashboard-header-date-input').addClass('display');
        }

    });


    // === Dashboard header filter navigation section ===

    var dashboardHeaderValue = $('.page-titles .dashboard-header-period-wrapper .dashboard-header-value.display');
    var selectedPeriodItem = dashboardHeaderValue.find('.dropdown .dropdown-item.selected');

    if( selectedPeriodItem.attr('data-value') == dashboardHeaderValue.find('.dropdown .dropdown-item:first-child').attr('data-value') ) {

        dashboardHeaderValue.find('.next-wrap').addClass('hide');

    } else if( selectedPeriodItem.attr('data-value') == dashboardHeaderValue.find('.dropdown .dropdown-item:last-child').attr('data-value') ) {

        dashboardHeaderValue.find('.prev-wrap').addClass('hide');
    }

    $(document).on('click', '.page-titles .dashboard-header-period-wrapper .dashboard-header-value .arrow-wrap', function(){
        var currentSelectedItem = $(this).parents('.dashboard-header-value').find('.dropdown-menu .dropdown-item.selected');
        var selectedIndex = currentSelectedItem.index();

        if( $(this).hasClass('prev-wrap') ) {
            selectedIndex++;
        } else {
            selectedIndex--;
        }

        $(this).parents('.dashboard-header-value').find('.dropdown-menu .dropdown-item').eq(selectedIndex).trigger(headerFilterEvent);
        window.location.href = $(this).parents('.dashboard-header-value').find('.dropdown-menu .dropdown-item').eq(selectedIndex).find('a').attr('href');
        // console.log($(this).parents('.dashboard-header-value').find('.dropdown-menu .dropdown-item').eq(selectedIndex).find('a'));
    });

    // === End of Dashboard header filter navigation section ===


    // Set language of moment.js
    moment.locale('fr');

    /* var formatL = moment.localeData().longDateFormat('L');
    var formatYearlessL = formatL.replace(/YYYY/g,'YY');
    console.log(moment().format(formatYearlessL)); */

    // Get current year, current month and current date
    var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth();
    var todayDate = new Date().toLocaleDateString().split('/');

    // Set date range picker
    $('.page-titles .dashboard-header-period-wrapper .inner-header-wrap .dashboard-header-date-input').daterangepicker({
        showDropdowns: true,
        minDate: new Date( 2017, 0, 1 ),
        maxDate: new Date( currentYear, currentMonth, parseInt(todayDate[1]) )
    }).on('apply.daterangepicker', function (ev, picker) {
        var data = {
            'from': picker.startDate.format('YYYY-MM-DD'),
            'to': picker.endDate.format('YYYY-MM-DD'),
        };
        
        var url_filter_redirect = baseUrl+'fr/reglements/dashboard-encaissements?custom_range=1&from='+data.from+'&to='+data.to;
        window.location = url_filter_redirect;
    }).on('showCalendar.daterangepicker', function (ev) {
        $('.daterangepicker select.monthselect').addClass('form-control form-control-sm');
        $('.daterangepicker select.yearselect').addClass('form-control form-control-sm');
    })
    ;

    // Modify text of buttons for date range picker
    $('.daterangepicker .drp-buttons .cancelBtn').text('Annuler');
    $('.daterangepicker .drp-buttons .applyBtn').text('Appliquer');



    // === Check if on Firefox ===

    if( navigator.userAgent.indexOf("Firefox") > -1 ) {

        $('.toggle-btn-amount-wrapper .inner-toggle-amount-wrap .btn-toggle-circle').css('top', '-0.124px');
    }

    // === End of section to Check if on Firefox ===


    // === Click on Header btn toggle amount ===

    $(document).on('click', '#header-btn-toggle-amount', function(){

        $(this).parents('.inner-toggle-amount-wrap').toggleClass('active');

    });

    // === End of section to Click on Header btn toggle amount ===


    // === Global function to get bar thickness for bar charts ===

    window.getBarThickness = function() {

        return 20;
    }

    // === End of Global function to get bar thickness for bar charts ===



    // === Global function to space number digits and format number into currency ===

    window.formatCurrencyNumber = function(number, with_decimal = 2) {

        if (with_decimal > 0) {

            number = number.toFixed(with_decimal);

        }

        // Check if number has decimal point and Convert it to string, then split each of its 3 digits from the end
        var value = (number % 1 > 0 ? number.toString() : number.toString() );

        value = value.split(/(?=(?:...)*$)/);

        // Format value to currency
        value = value.join(' ');
        return value.replace(' .', ',') + ' €';

        var value = (number % 1 > 0 ? number.toString() : number.toString() );

        value = value.split(/(?=(?:...)*$)/);

        // Format value to currency
        value = value.join(' ');
        return value.replace(' .', ',') + ' €';


    }

    // === End of Global function to space number digits and format number into currency ===


    // === Global function to get min date on line chart ===

    window.getLineMinDate = function() {

        //return new Date("2020/01/01");
        return new Date(currentYearFromView + '/01/01');
    }

    // === End of Global function to get min date on line chart ===


    // === Global function to populate chart legend ===

    window.populateChartLegend = function(chart, summaryBlock, amounts, nbDocuments) {

        var legendBlocks = [];

        if( chart.config.type == 'pie' || chart.config.type == 'doughnut' ) {

            for (var i = 0; i < chart.data.datasets[0].data.length; i++) {

                var bgColor = chart.data.datasets[0].backgroundColor[i];
                var text = chart.data.labels[i].replace(/'/g, "\'");
                var data = chart.data.datasets[0].data[i];
                

                //legendBlocks.push( ( amounts.length > 0 ? '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + ' : </div><div class="amount">' + formatCurrencyNumber(amounts[i]) + '</div></div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' : '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' ) );

                //legendBlocks.push( ( amounts.length > 0 ? '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div><div class="amount">' + formatCurrencyNumber(amounts[i]) + '</div></div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' : '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' ) );

                if (data) {


                    if( summaryBlock == '.retard-reglement-dashboard-wrapper .all-chart-wrapper .somme-due-summary-block' ) {

                        legendBlocks.push( ( amounts ? '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="amount">' + formatCurrencyNumber(amounts[i], 0) + '</div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div><div class="invoice-wrap">(' + nbDocuments[i] + ' facture'+(nbDocuments[i] > 1 ? 's' : '')+')</div></div>' : '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div><div class="invoice-wrap">(' + nbDocuments[i] + ' facture'+(nbDocuments[i] > 1 ? 's' : '')+')</div></div>' ) );

                    } else {

                        if( nbDocuments ) {

                            legendBlocks.push( ( amounts ? '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="amount">' + formatCurrencyNumber(amounts[i], 0) + '&nbsp;&nbsp;(' + nbDocuments[i] + ')</div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' : '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' ) );

                        } else {
                            legendBlocks.push( ( amounts ? '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="amount">' + formatCurrencyNumber(amounts[i], 0) + '</div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' : '<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div><div class="number-wrap">' + data.toString().replace('.', ',') + ' %</div></div>' ) );

                        }
                    }
                }
            }

        } else {

            for (var i = 0; i < chart.data.datasets.length; i++) {

                var bgColor = chart.data.datasets[i].backgroundColor;
                var text = chart.data.datasets[i].label.replace(/'/g, "\'");

                legendBlocks.push('<div class="legend-block"><div class="description-wrap"><div class="color" style="background-color: ' + bgColor + ';"></div><div class="text">' + text + '</div></div></div>');

            }
        }

        return legendBlocks.join('');
    }

    // === End of Global function to populate chart legend ===



    // === Global function to display Total Invoiced Amount ===

    window.showTotalAmountInvoiced = function(summaryBlock, amount) {

        return $(summaryBlock).prepend('<div class="amount">' + formatCurrencyNumber(amount, 0) + '</div>');
    }

    // === End of Global function to display Total Invoiced Amount ===



    // === Global function to populate Gauge chart legend ===

    window.populateGaugeChartLegend = function(chart, summaryBlock, amount) {

        var legendDetails = [ '<div class="percentage-amount">' + amount.toFixed(0) + '%</div><div class="description">du CA facturé</div>' ];

        return legendDetails.join('');
    }

    // === End of Global function to populate Gauge chart legend ===



    // === Global function to update chart ===

    window.updateChart = function(currentElement, chart) {

        var datasetIndex = currentElement.index();
        var type = chart.config.type;
        var datasetHidden = ( type == 'pie' || type == 'doughnut' ? chart.getDatasetMeta(0).data[datasetIndex].hidden : chart.getDatasetMeta(datasetIndex).hidden );

        var result = ( datasetHidden ) ? true : false;

        if( !result ) {

            /*

            currentElement.find('.description-wrap .text').css('text-decoration', 'line-through');

            type == 'pie' || type == 'doughnut' ? chart.getDatasetMeta(0).data[datasetIndex].hidden = true : chart.getDatasetMeta(datasetIndex).hidden = true;

            */


            if( type == 'pie' || type == 'doughnut' ) {

                currentElement.addClass('add-line-through');
                chart.getDatasetMeta(0).data[datasetIndex].hidden = true;

            } else {

                currentElement.find('.description-wrap .text').css('text-decoration', 'line-through');
                chart.getDatasetMeta(datasetIndex).hidden = true;
            }


        } else {


            /*

            currentElement.find('.description-wrap .text').css('text-decoration', 'none');

            type == 'pie' || type == 'doughnut' ? chart.getDatasetMeta(0).data[datasetIndex].hidden = false : chart.getDatasetMeta(datasetIndex).hidden = false;

            */


            if( type == 'pie' || type == 'doughnut' ) {

                currentElement.removeClass('add-line-through');
                chart.getDatasetMeta(0).data[datasetIndex].hidden = false;

            } else {

                currentElement.find('.description-wrap .text').css('text-decoration', 'none');
                chart.getDatasetMeta(datasetIndex).hidden = false;
            }

        }

        chart.update();

    }

    // === End of Global function to update chart ===



    // === Global function to get responsive Line Chart aspect ratio ===

    window.getLineChartRatio = function(ratio) {

        return( window.matchMedia("(min-width: 768px)").matches ? ratio : 1 );
    }

    // === End of Global function to get responsive Line Chart aspect ratio ===



    // === Global function to get chart ratio ===

    window.getChartRatio = function(ratio, summaryBlock) {

        var aspectRatio = 0;

        switch(summaryBlock) {

            case '.retard-reglement-dashboard-wrapper .all-chart-wrapper .total-summary-block .en-attente-block':
            case '.retard-reglement-dashboard-wrapper .all-chart-wrapper .total-summary-block .en-retard-block':
                if( window.matchMedia('(min-width: 1440px)').matches ) {

                    aspectRatio = 5.25;

                } else if( window.matchMedia('(min-width: 990px)').matches && window.matchMedia('(max-width: 1088px)').matches ) {

                    aspectRatio = 2.9;

                } else {

                    aspectRatio = ratio;
                }
                break;

            case '.retard-reglement-dashboard-wrapper .all-chart-wrapper .somme-due-summary-block':
                if( window.matchMedia('(min-width: 1440px)').matches ) {

                    aspectRatio = 1.25;

                } else if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 1229px)').matches ) {

                    aspectRatio = 3.5;

                } else if( window.matchMedia('(max-width: 767px)').matches ) {

                    aspectRatio = 2.5;

                } else {

                    aspectRatio = ratio;
                }
                break;

            case '.retard-reglement-dashboard-wrapper .all-chart-wrapper .attente-reglement-summary-block':
            case '.retard-reglement-dashboard-wrapper .all-chart-wrapper .invoice-type-summary-block':
                if( window.matchMedia('(min-width: 990px)').matches && window.matchMedia('(max-width: 1088px)').matches ) {

                    aspectRatio = 2;

                } else if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 989px)').matches ) {

                    aspectRatio = 1;

                } else if( window.matchMedia('(max-width: 767px)').matches ) {

                    aspectRatio = 2.5;

                } else {

                    aspectRatio = ratio;
                }
                break;

            case '.retard-reglement-dashboard-wrapper .all-chart-wrapper .commercial-summary-block':
            case '.retard-reglement-dashboard-wrapper .all-chart-wrapper .commercial-retard-sum-block':
                if( window.matchMedia('(min-width: 1440px)').matches ) {

                    aspectRatio = 1.5;

                } else if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 1088px)').matches ) {

                    //aspectRatio = 3.5;
                    aspectRatio = 1.1;

                } else if( window.matchMedia('(max-width: 767px)').matches ) {

                    aspectRatio = 1.75;

                } else {

                    aspectRatio = ratio;
                }
                break;

            case '.encaissement-dashboard-wrapper .all-chart-wrapper .evolution-summary-block':
            case '.encaissement-dashboard-wrapper .all-chart-wrapper .invoice-type-summary-block.bar-chart-sum-block':
            case '.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.line-chart-sum-block':
            case '.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.line-chart-sum-block':

                if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 1088px)').matches ) {

                    aspectRatio = 3.3;

                } else if( window.matchMedia('(min-width: 1089px)').matches ) {

                    aspectRatio = ratio;

                } else {

                    aspectRatio = 1;
                }
                break;

            case '.encaissement-dashboard-wrapper .all-chart-wrapper .invoice-type-summary-block.pie-chart-sum-block':
                if( window.matchMedia('(min-width: 1440px)').matches ) {

                    aspectRatio = 1.345;

                } else if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 1088px)').matches ) {

                    if( $(summaryBlock).hasClass('only-pie-chart-block') ) {

                        aspectRatio = 2;

                    } else {

                        aspectRatio = 3.7;
                    }

                } else {

                    aspectRatio = ratio;
                }
                break;

            case '.encaissement-dashboard-wrapper .all-chart-wrapper .payment-type-summary-block.pie-chart-sum-block':
            case '.encaissement-dashboard-wrapper .all-chart-wrapper .bank-summary-block.pie-chart-sum-block':

                if( window.matchMedia('(min-width: 1440px)').matches ) {

                    aspectRatio = 1.4;

                //} else if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 1088px)').matches ) {

                } else if( window.matchMedia('(min-width: 990px)').matches && window.matchMedia('(max-width: 1088px)').matches ) {

                    if( $(summaryBlock).hasClass('only-pie-chart-block') && $(summaryBlock).hasClass('payment-type-summary-block') ) {

                        aspectRatio = 2;

                    } else {

                        aspectRatio = 3.7;
                    }

                } else if( window.matchMedia('(min-width: 768px)').matches && window.matchMedia('(max-width: 989px)').matches ) {

                    if( $(summaryBlock).hasClass('only-pie-chart-block') && $(summaryBlock).hasClass('payment-type-summary-block') ) {

                        aspectRatio = 3.7;

                    } else {

                        aspectRatio = 1.8;
                    }

                } else {

                    aspectRatio = ratio;
                }
                break;

        }

        return aspectRatio;
    }

    // === End of Global function to get chart ratio ===



    // === Global function to display monthly amounts ===

    window.displayMonthlyAmounts = function(amounts, monthlyAmountWrapper) {

        amounts.forEach( amount => monthlyAmountWrapper.append('<div class="amount-block">' + formatCurrencyNumber(amount) + '</div>') );
    }

    // === End of Global function to display monthly amounts ===



    // === Global function to get tooltip in Percentage for Line Chart ===

    window.getLineChartCurrencyTooltip = function(tooltipItems, data) {

        return data.datasets[tooltipItems.datasetIndex].label + ': ' + tooltipItems.yLabel.toFixed(nbDecimal);

    }

    // === End of Global function to get tooltip in Percentage for Line Chart ===



    // === Global function to get Amount Percents ===

    window.getDataPercents = function(amounts) {

        var totalAmount = 0; for(var i in amounts) totalAmount += amounts[i];
        var amountPercents = [];
        //amounts.forEach( amount => amountPercents.push( ( ( (amount / totalAmount) * 100 ) % 1 > 0 ? ( (amount / totalAmount) * 100 ).toFixed(2) : (amount / totalAmount) * 100 ) ) );
        amounts.forEach( amount => amountPercents.push( ( ( (amount / totalAmount) * 100 ) % 1 > 0 ? ( (amount / totalAmount) * 100 ).toFixed(0) : ( totalAmount > 0 ? (amount / totalAmount) * 100 : 0 ) ) ) );

        return amountPercents;

    }

    // === End of Global function to get Amount Percents ===



    // === Global function to get data in percentage for chart tooltips ===

    window.getPercentageTooltip = function(tooltipItems, data, amount) {

        /* if( !amount ) {
            return data['labels'][ tooltipItems['index'] ] + ': ' + data['datasets'][0]['data'][ tooltipItems['index'] ] + ' %';
        } else {
            return data['labels'][ tooltipItems['index'] ] + ': ' + amount + ' € | ' + data['datasets'][0]['data'][ tooltipItems['index'] ] + ' %';
        } */

        // return ( amount ? data['labels'][ tooltipItems['index'] ] + ': ' + formatCurrencyNumber(amount) + ' | ' + data['datasets'][0]['data'][ tooltipItems['index'] ].toString().replace('.', ',') + ' %' : data['labels'][ tooltipItems['index'] ] + ': ' + data['datasets'][0]['data'][ tooltipItems['index'] ].toString().replace('.', ',') + ' %' );

        return ( amount ? data['labels'][ tooltipItems['index'] ] + ': ' + (Number.isInteger(amount) ? amount : amount.toFixed(nbDecimal)) + ' | ' + data['datasets'][0]['data'][ tooltipItems['index'] ].toString().replace('.', ',') + ' %' : data['labels'][ tooltipItems['index'] ] + ': ' + data['datasets'][0]['data'][ tooltipItems['index'] ].toString().replace('.', ',') + ' %' );


    }

    // === End of Global function to get data in percentage for chart tooltips ===



    // === Global function to display amounts on bar charts ===

    window.displayBarChartAmounts = function(chart, datasets) {

        var chartInstance = chart,

        ctx = chartInstance.ctx;

        //ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);

        //ctx.font = '400 12.1px sans-serif';
        //ctx.font = '600 12.1px sans-serif';

        ctx.font = '400 11.49px sans-serif';
        //ctx.font = '400 11.5px sans-serif';

        //ctx.font = 'bold 14px sans-serif';

        //ctx.fillStyle = '#ffffff';
        ctx.fillStyle = '#000000';

        //ctx.textAlign = 'right';
        ctx.textAlign = 'left';

        //ctx.textBaseline = 'top';
        ctx.textBaseline = 'bottom';

        datasets.forEach(function(dataset, i) {
            var meta = chartInstance.controller.getDatasetMeta(i);
            meta.data.forEach(function(bar, index) {
                var data = formatCurrencyNumber(dataset.data[index], 0);
                //ctx.fillText(data, bar._model.x, bar._model.y - 5);

                //ctx.fillText(data, bar._model.x - 10, bar._model.y - 5);
                //ctx.fillText(data, bar._model.x + 28, bar._model.y + 26);
                ctx.fillText(data, 67, bar._model.y + 24);
                // -- FOR LARGER FONT SIZE (11.5px): ctx.fillText(data, 67, bar._model.y + 26);

                //ctx.fillText(data, bar._model.x - 10, bar._model.y - 5.04);
            });
        });
    }

    // === End of Global function to display amounts on bar charts ===


    // === Center tooltip for horizontal bar chart ===

    Chart.Tooltip.positioners.center = function (elements) {

        const { x, y, base } = elements[0]._model;
        const height = base - y;

        return {
            x: x - ( x / 2 ), // To place tooltip in the middle of each bar chart
            //x: x - ( x / 2 ) - 20,
            //x: x - ( x / 7 ),
            y: y
        };

    };

    // === End of section to Center tooltip for horizontal bar chart ===



    // === Center tooltip for Small horizontal bar chart ===

    Chart.Tooltip.positioners.centerSmall = function (elements) {

        const { x, y, base } = elements[0]._model;
        const height = base - y;

        return {
            //x: x - ( x / 2 ), // To place tooltip in the middle of each bar chart
            x: x - ( x / 2 ) - 40,
            //x: x - ( x / 7 ),
            y: y
        };

    };

    // === End of section to Center tooltip for Small horizontal bar chart ===



    // === Display content related to clicked tab ===


    $(document).on('click', '.dashboard-content-wrapper .all-chart-wrapper .summary-block .table-wrapper .tab-wrapper .tab-block', function(){

        $(this).parents('.tab-wrapper').find('.tab-block').removeClass('current');
        $(this).addClass('current');
        $(this).parents('.table-wrapper').find('.inner-table-wrapper').removeClass('display');

        if( $(this).hasClass('tab-last-quote') ) {

            $(this).parents('.table-wrapper').find('.last-quote-wrapper').addClass('display');

        } else if( $(this).hasClass('tab-last-signed-quote') ) {

            $(this).parents('.table-wrapper').find('.last-signed-quote-wrapper').addClass('display');

        } else if( $(this).hasClass('tab-vente') ) {

            $(this).parents('.table-wrapper').find('.vente-table-wrapper').addClass('display');

        } else if( $(this).hasClass('tab-loc-fi') ) {

            $(this).parents('.table-wrapper').find('.loc-fi-table-wrapper').addClass('display');

        } else if( $(this).hasClass('tab-commercial-chart') ) {

            $(this).parents('.table-wrapper').find('.commercial-chart-wrapper').addClass('display');

        } else if( $(this).hasClass('tab-retard-commercial') ) {

            $(this).parents('.table-wrapper').find('.retard-commercial-wrapper').addClass('display');

        }


    });


    // === End of section to Display content related to clicked tab ===


});
