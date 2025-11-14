$(document).ready(function(){

    // Call function to set values for customized selects
    setValuesForCustomizedSelects();

    // === Function to set values for Customized Selects ===

    function setValuesForCustomizedSelects() {

        $('.customized-select .option-list-wrap .option-block').each(function(){

            if( $(this).hasClass('selected') ) {

                $(this).parents('.customized-select').find('.selected-value-block .text').attr('option-id',  $(this).attr('option-id') );
                $(this).parents('.customized-select').find('.selected-value-block .text').text( $(this).text() );
            }

        });

    }

    // === End of Function to set values for Customized Selects ===



    // === Display option list wrap when clicking on Customized Select ===

    $(document).on('click', '.customized-select .selected-value-block', function(e) {
    //$('.customized-select .selected-value-block').on('click', function(e){

        $(this).parents('.customized-select').find('.outer-option-list-wrap').toggleClass('display');

        // Call function to reset search input on select
        resetSelectSearchInput( $(this).parents('.customized-select').find('.search-option-wrap input') );

        $(this).parents('.customized-select').find('.search-option-wrap input').focus();

        $('.customized-select .selected-value-block').not( this ).each( function(){

            $(this).parents('.customized-select').find('.outer-option-list-wrap').removeClass('display');

        });

    });

    // === End of section to Display option list wrap when clicking on Customized Select ===


    // === Function to reset search input on select ===

    function resetSelectSearchInput(input) {

        // Reset select search input
        input.parents('.customized-select').find('.search-option-wrap input').val('');
        input.parents('.customized-select').find('.option-list-wrap .option-block').removeClass('hide-from-search-result');
        input.parents('.customized-select').find('.inner-option-list-wrap').removeClass('data-not-found');
    }

    // === End of Function to reset search input on select ===


    // === Hide option list wrap when clicking outside Customized Select ===

    $(document).on('click', function(e){

        if( $(e.target).closest( $('.customized-select') ).length === 0 ) {

            $('.customized-select .outer-option-list-wrap').removeClass('display');

            // Call function to reset search input on select
            resetSelectSearchInput( $(e.currentTarget).find('.search-option-wrap input') );
        }

    });

    // === End of section to Hide option list wrap when clicking outside Customized Select ===



    // === Display value of selected option on Customized Select ===

    $(document).on('click', '.customized-select .option-list-wrap .option-block', function(e) {
    //$('.customized-select .option-list-wrap .option-block').on('click', function(){

        $(this).parents('.customized-select').find('.option-block').removeClass('selected');

        $(this).parents('.customized-select').find('.selected-value-block .text').attr('option-id',  $(this).attr('option-id') );
        $(this).parents('.customized-select').find('.selected-value-block .text').text( $(this).text() );
        $(this).addClass('selected');

        $(this).parents('.customized-select').find('.selected-value-block input').val($(this).attr('option-id')).trigger('change');

        $(this).parents('.outer-option-list-wrap').removeClass('display');

        if( $(window).width() > 767 ) {

            $(this).parents('.customized-select').find('.option-list-wrap').css({

                'top': '25px'

            });

        }

    });

    // === End of section to Display value of selected option on Customized Select ===


    // === Hide outer option list wrapper when clicking on it for responsive customized menu ===

    $(document).on('click', '.customized-select .outer-option-list-wrap', function(e) {
    //$('.customized-select .outer-option-list-wrap').on('click', function(e){

        if( $(e.target).closest( $('.customized-select .option-list-wrap') ).length === 0 ) {

            $(this).removeClass('display');

        }

    });

    // === End of section to Hide outer option list wrapper when clicking on it for responsive customized menu ===





    // === Activate search for customized select ===

    $(document).on('keyup', '.customized-select .option-list-wrap .search-option-wrap input', function(e) {
    //$('.customized-select .option-list-wrap .search-option-wrap input').on('keyup', function(){

        var value = $(this).val().toLowerCase();

        $(this).parents('.customized-select').find('.option-list-wrap .option-block').each(function() {

            //$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);


            if( ($(this).text().toLowerCase().indexOf(value) > -1 ) ) {

                $(this).removeClass('hide-from-search-result');

            } else {

                $(this).addClass('hide-from-search-result');
            }

        });

        if( value == '' ) {

            $(this).parents('.customized-select').find('.option-list-wrap .option-block').removeClass('hide-from-search-result');
        }


        if( $(this).parents('.customized-select').find('.option-list-wrap .option-block.hide-from-search-result').length == $(this).parents('.customized-select').find('.option-list-wrap .option-block').length ) {

            $(this).parents('.customized-select').find('.inner-option-list-wrap').addClass('data-not-found');

        } else {

            $(this).parents('.customized-select').find('.inner-option-list-wrap').removeClass('data-not-found');
        }


    });

    // === End of section to Activate search for customized select ===



});
