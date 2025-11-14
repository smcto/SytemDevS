$(document).ready(function(){

    // === Get height for th and td of first customized-table ===

    if( $(window).width() > 767 && !( navigator.userAgent.match(/iPad/i) && window.matchMedia('(orientation: portrait)').matches ) ) {

        //$('.customized-table:first-child').each(function(){

        $('.customized-table').each(function(){

            setToHighestCellHeight( $(this), '.th' );
            setToHighestCellHeight( $(this), '.td' );

        });

    }

    // === End of section to Get height for th and td of first customized-table ===




    // === Function to update table cell heights for customized table ===

    function updateTableCellHeights(table) {

        if( $(window).width() > 767 && !( navigator.userAgent.match(/iPad/i) && window.matchMedia('(orientation: portrait)').matches ) ) {

            //var thHeight = 0;

            // Call function to set cell to highest cell height for th

            setToHighestCellHeight( table, '.th' );

            //var tdHeight = 0;

            // === Set height of td to the highest cell's height on the same row for customized table ===

            setToHighestCellHeight( table, '.td' );

        }

    }

    // === End of Function to update table cell heights for customized table ===



    // === Function to set height of cell to the highest cell's height on the same row for customized table ===

    function setToHighestCellHeight(table, cellClass) {

        //$('.customized-table .tr').each(function(){

        table.find('.tr').each(function(){

            // Reset height
            var height = 0;

            // Get maximum height for current row

            $(this).find(cellClass).each(function(){

                if( $(this).outerHeight(true) > height ) {

                    height = $(this).outerHeight(true);
                }

            });

            // Set maximum height for each cell in current row

            $(this).find(cellClass).each(function(){

                $(this).css({

                    'height': height + 'px'

                });

            });


        });

    }

    // === End of Function to set height of cell to the highest cell's height on the same row for customized table ===



    // === Global function to get table general search results ===

    window.getTableGeneralSearchResults = function(currentElement, parentSelector) {

        var value = currentElement.val().toLowerCase();
        var parent = currentElement.parents(parentSelector);

        parent.find('.customized-table .tr .column .td').each(function() {

            $(this).toggle( $(this).parents('.tr').find('.column .td').text().toLowerCase().indexOf(value) > -1 );

        });

        if( parent.find('.customized-table .tr .column .td:visible').length == 0 ) {

            parent.find('.customized-table').addClass('data-not-found');

        } else {

            parent.find('.customized-table').removeClass('data-not-found');
        }
    }

    // === End of Global function to get table general search results ===




    // === Check if Rubik table row is a link ===

    $('.rubik-customized-table .tr:first-child .th').on('mouseover', function(){

        //$(this).parents('a.tr').attr('href', 'javascript:void(0))').attr('target', '');

        $(this).parents('.tr').find('.td').css('background-color', 'transparent');
        $(this).parents('a.tr').css('cursor', 'default');
    });

    $('.rubik-customized-table .tr:first-child .td').on('mouseover', function(){

        $(this).parents('.tr').find('.td').css('background-color', '#e5f2ff');
        $(this).parents('a.tr').css('cursor', 'pointer');
    });

    $('.rubik-customized-table .tr:first-child .td').on('mouseout', function(){

        $(this).parents('.tr').find('.td').css('background-color', 'transparent');
    });

    // === End of secton to Check if Rubik table row is a link ===




});
