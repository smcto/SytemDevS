$(document).ready(function(){

    // === Display Late Payment Popup Container ===

    $('.btn-late-payment-popup').on('click', function(){

        $('.late-payment-popup-container').addClass('display');

    });

    // === End of section to Display Late Payment Popup Container ===


    // === Display border bottom for Editable Text to indicate it is being edited ===

    //$('.popup-detail-wrapper .inner-detail-wrapper .popup-detail-block').on('click', function(){
    $(document).on( "click", ".popup-detail-wrapper .inner-detail-wrapper .popup-detail-block", function() {
        // Check if child is NOT textarea
        /* if( !$(this).find('.editable-text').is('textarea') ) {

            var currentVal = $(this).find('.editable-text').val();

            $(this).find('.editable-text').focus().val('').val(currentVal);

        } */

        $(this).find('.editable-text').focus();

    });

    //$('.editable-text').on('click, focusin', function(){
    $(document ).on( "click, focusin", ".editable-text", function() {
        $(this).parents('.editable-block').addClass('editing');

    });

    //$('.editable-text').on('blur, focusout', function(){
    $(document ).on( "blur, focusout", ".editable-text", function() {


        $(this).parents('.editable-block').removeClass('editing');

    });

    // === End of section to Display border bottom for Editable Text to indicate it is being edited ===



    // === Remove extra space from textarea ===

    $('textarea').each(function(){

        trimTextAreaSpace( $(this) );

    });

    // === End of section to Remove extra space from textarea ===



    // === Function to Remove extra space from textarea ===

    function trimTextAreaSpace(textarea) {

        textarea.html( $.trim( textarea.html() ) );
    }

    // === End of section to Remove extra space from textarea ===



    // === Switch between tabs for client section on Popup Container ===

    $(document ).on( "click", ".client-event-tab-section .tab-block", function() {
    //$('.pipe-popup-container .client-event-tab-section .tab-block').on('click', function(){

        $(this).parents('.popup-container').find('.client-event-tab-section .tab-block').removeClass('current');
        $(this).parents('.popup-container').find('.popup-detail-wrapper').removeClass('display');

        $(this).addClass('current');

        if( $(this).hasClass('event-tab-block') ) {

            $('.pipe-popup-container .outer-popup-detail-wrapper .for-event-tab-wrapper').addClass('display');

        } else if( $(this).hasClass('client-tab-block') ) {

            //$('.pipe-popup-container .outer-popup-detail-wrapper .client-detail-wrapper').addClass('display');

            $(this).parents('.popup-container').find('.client-detail-wrapper').addClass('display');

        } else if( $(this).hasClass('original-tab-block') ) {

            $('.pipe-popup-container .outer-popup-detail-wrapper .for-original-tab-wrapper').addClass('display');

        } else if( $(this).hasClass('doc-tab-block') ) {

            $(this).parents('.popup-container').find('.doc-section').addClass('display');

            updateTableCellHeights( $(this).parents('.popup-container').find('.doc-section .customized-table') );

        } else if( $(this).hasClass('facture-tab-block') ) {

            $(this).parents('.popup-container').find('.facture-detail-wrapper').addClass('display');

        } else if( $(this).hasClass('devis-tab-block') ) {

            $(this).parents('.popup-container').find('.devis-detail-wrapper').addClass('display');

        } else if( $(this).hasClass('reglement-tab-block') ) {

            $(this).parents('.popup-container').find('.reglement-section').addClass('display');

            updateTableCellHeights( $(this).parents('.popup-container').find('.reglement-section .customized-table') );

        }


    });


    // === End of section to Switch between tabs for client section on Popup Container ===



    // === Customized styles for Firefox ===

    if( navigator.userAgent.indexOf("Firefox") > -1 ) {

        $('.popup-container .inner-popup-container .below-section-content').css('padding-bottom', '40px');

    }

    // === End of section to Customized styles for Firefox ===



    // === Switch between tabs for popup below tab section on Popup Container ===

    $( document ).on( "click", ".popup-below-tab-section .tab-block", function() {
    //$('.popup-below-tab-section .tab-block').on('click', function(){

        $('.popup-below-tab-section .tab-block').removeClass('current');
        $('.below-section-content .inner-below-section-content').removeClass('display');

        $(this).addClass('current');


        if( $(this).hasClass('comment-tab-block') ) {

            $('.below-section-content .comment-section').addClass('display');

        } else if( $(this).hasClass('mail-tab-block') ) {

            $('.below-section-content .email-section').addClass('display');

        } else if( $(this).hasClass('doc-tab-block') ) {

            $('.below-section-content .doc-section').addClass('display');

            // Call function to update cell heights for customized table
            updateTableCellHeights( $('.below-section-content .doc-section').find('.customized-table') );

        } else if( $(this).hasClass('activity-tab-block') ) {

            $('.below-section-content .activity-section').addClass('display');
        }


    });

    // === End of section to Switch between tabs for popup below tag section on Popup Container ===




    // === Display option list wrap when clicking on Customized Select ===

    $(document).on('click', '.customized-select .selected-value-block', function(e) {
    //$('.customized-select .selected-value-block').on('click', function(e){

        $(this).parents('.customized-select').find('.outer-option-list-wrap').toggleClass('display');

        // Call function to reset search input on select
        resetSelectSearchInput( $(this).parents('.customized-select').find('.search-option-wrap input') );

        $(this).parents('.customized-select').find('.search-option-wrap input').focus();

        // Check if inside popup
        if( $(e.target).closest( $('.popup-container .inner-popup-container') ).length === 1 ) {

            var popupBottom = $(this).parents('.inner-popup-container').offset().top + $(this).parents('.inner-popup-container').outerHeight(true);

            var customizedSelectBottom = $(this).parents('.customized-select').find('.option-list-wrap').offset().top + $(this).parents('.customized-select').find('.option-list-wrap').outerHeight(true);


            if( $(window).width() > 767 && !( navigator.userAgent.match(/iPad/i) && window.matchMedia('(orientation: portrait)').matches ) ) {

                if( ( popupBottom - customizedSelectBottom ) <= 0 ) {

                    $(this).parents('.customized-select').find('.option-list-wrap').css({

                        'top': ( -1 * $(this).parents('.customized-select').find('.option-list-wrap').outerHeight(true) ) - 5 + 'px'

                    });

                } else {

                    if( $(e.target).closest( $('.select-email-model-wrapper') ).length === 1 ) {

                        $(this).parents('.customized-select').find('.option-list-wrap').css({

                            'top': '30.4px'

                        });

                    } else if( $(e.target).closest( $('.small-popup-container .inner-popup-container .wrap-with-select') ).length === 1 ) {

                        $(this).parents('.customized-select').find('.option-list-wrap').css({

                            'top': '23px'

                        });

                    } else if( $(e.target).closest( $('.pipeline-header-container .pipeline-menu-container.display .inner-pipeline-menu-container') ).length === 1 ) {

                        $(this).parents('.customized-select').find('.option-list-wrap').css({

                            'top': '40px'

                        });

                    } else {

                        $(this).parents('.customized-select').find('.option-list-wrap').css({

                            'top': '25px'

                        });

                    }

                }

            }

        }


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
        //alert('je passe ici');
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


    // === Display Client Contact Popup Container when clicking on edit icon wrap within contact person wrap on Pipe Popup Container ===

    $(document).on( "click", ".client-detail-wrapper .right-section .contact-person-wrap .edit-icon-wrap", function() {
    //$('.client-detail-wrapper .right-section .contact-person-wrap .edit-icon-wrap').on('click', function(){

        $('.client-contact-popup-container').addClass('display');
        $('.client-contact-popup-container .inner-popup-container .client-contact-wrap:first-child .editable-block input').focus();

        $('.client-contact-popup-container .inner-popup-container .title').text('Éditer ce contact');
        $('.client-contact-popup-container .submit-add').hide();
        $('.client-contact-popup-container .submit-validate').show();

    });

    // === End of section to Display Client Contact Popup Container when clicking on edit icon wrap within contact person wrap on Pipe Popup Container ===


    // === Close Client Contact Popup Container wen clicking validate contact button ===

    $(document).on('click', '.small-popup-container .bottom-submit-btn-wrap .btn-validate', function(){

        $(this).parents('.popup-container').removeClass('display');

    });

    // === End of section to Close Client Contact Popup Container wen clicking validate contact button ===


    // === Close Pipe Popup Container ===

    $(document).on('click', '.pipe-popup-container .popup-close-wrap', function(e) {
    //$('.pipe-popup-container .popup-close-wrap').on('click', function(){

        // Call function to reset all for Pipe Popup Container
        resetAllForPipePopup();

    });

    $(document).on('click', '.pipe-popup-container', function(e) {
    //$('.pipe-popup-container').on('click', function(e){

        if( $(e.target).closest( $('.popup-container .inner-popup-container') ).length === 0 ) {

            // Call function to reset all for Pipe Popup Container
            resetAllForPipePopup();
        }

    });

    $(document).keydown(function(e){

        // Check if escape key is pressed
        if (e.key === "Escape") {

            // Call function to reset all for Pipe Popup Container
            resetAllForPipePopup();
        }

    });


    // === Function to reset all for Pipe Popup Container ===

    function resetAllForPipePopup() {

        $('.pipe-popup-container .client-event-tab-section .tab-block').removeClass('current');
        $('.pipe-popup-container .client-event-tab-section .event-tab-block').addClass('current');
        $('.pipe-popup-container .outer-popup-detail-wrapper .popup-detail-wrapper').removeClass('display');
        $('.pipe-popup-container .outer-popup-detail-wrapper .for-event-tab-wrapper').addClass('display');
        $('.popup-below-tab-section .tab-block').removeClass('current');
        $('.popup-below-tab-section .comment-tab-block').addClass('current');
        $('.pipe-popup-container .below-section-content .inner-below-section-content').removeClass('display');
        $('.pipe-popup-container .below-section-content .comment-section').addClass('display');

    }

    // === End of Function to reset all for Pipe Popup Container ===


    // === Display professional data when clicking on Professional value for option block on Pipe Popup Container ===

    $(document).on('click', '.client-detail-wrapper .client-info-wrapper .customized-select .option-list-wrap .option-block', function(e) {
   // $('.client-detail-wrapper .client-info-wrapper .customized-select .option-list-wrap .option-block').on('click', function(){

        // Call function to check client status type
        checkClientStatusType( $(this).attr('type-value') );

    });

    // === End of section to Display professional data when clicking on Professional value for option block on Pipe Popup Container ===



    // === Function to check client status type ===

    function checkClientStatusType( typeValue ) {

        if( typeValue == 'person' ) {

            //$('.client-detail-wrapper .left-section .professional-client-data-wrapper .professional-data').addClass('hide');

            $('.popup-container .professional-data').addClass('hide');

            $('.client-detail-wrapper .left-section .below-left-client-wrapper .inner-left-section').addClass('increase-width');

            if( $(window).width() <= 767 ) {

                $('.client-detail-wrapper .left-section .vertical-block:not(:first-child)').css({
                    'padding-bottom': '9.5px'
                });

                $('.client-detail-wrapper .left-section .vertical-block:last-child').css({
                    'padding-bottom': '9.5px'
                });

            }

        } else if( typeValue == 'corporation' ) {

            //$('.client-detail-wrapper .left-section .professional-client-data-wrapper .professional-data').removeClass('hide');
            //alert('change me');
            $('.popup-container .professional-data').removeClass('hide');

            $('.client-detail-wrapper .left-section .below-left-client-wrapper .inner-left-section').removeClass('increase-width');

            if( $(window).width() <= 767 ) {

                $('.client-detail-wrapper .left-section .vertical-block:not(:first-child)').css({
                    'padding-bottom': '25px'
                });

                $('.client-detail-wrapper .left-section .vertical-block:last-child').css({
                    'padding-bottom': '25px'
                });

            }
        }

    }

    // === End of Function to check client status type ===



    // === Set displayed client data according to the client's status type ===

    if( $('.client-detail-wrapper .client-info-wrapper .customized-select .option-list-wrap .option-block.selected').attr('type-value') == 'person' ) {

        checkClientStatusType( 'person' );

    } else if( $('.client-detail-wrapper .client-info-wrapper .customized-select .option-list-wrap .option-block.selected').attr('type-value') == 'corporation' ) {

        checkClientStatusType( 'corporation' );
    }

    // === End of section to Set displayed client data according to the client's status type ===



    $(document).on( "click", ".client-detail-wrapper .left-section .professional-client-data-wrapper .edit-icon-wrap", function() {

        $('.client-company-popup-container').addClass('display');

    });

    // === End of section to Display Client Company Popup Container when clicking on edit icon wrap for left section on client tab ===



    // === Display WYSIWYG CKEditor on Email Editor Popup Container ===

    $( 'textarea.email-editor' ).ckeditor();

    CKEDITOR.config.language = 'fr';

    //CKEDITOR.config.baseFloatZIndex = -1;

    $( 'textarea#id_commentaireOpp' ).ckeditor();

    //CKEDITOR.config.contentsCss = CKEDITOR.getUrl("");

    $('#cke_38').parent().hide();

    // === End of section to Display WYSIWYG CKEditor on Email Editor Popup Container ===



    // === Display Add Comment Popup Container when clicking on add button within comment section on Pipe Popup Container ===

    //$('.comment-section .add-comment-wrap .btn-text').on('click', function(){
    $(document).on( "click", '.comment-section .add-comment-wrap .btn-text', function() {

        $('.add-comment-popup-container').addClass('display');

    });

    // === End of section to Display Add Comment Popup Container when clicking on add button within comment section on Pipe Popup Container ===



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


    // === Display toggle option menu ===

    //$('.toggle-option-block').on('click', function(e){
    $(document).on( "click", '.toggle-option-block', function(e) {

        if( $(e.target).closest( $('.outer-toggle-option-menu') ).length === 0 ) {

            $(this).find('.outer-toggle-option-menu').toggleClass('display');

        }

        $('.toggle-option-block').not( this ).each( function(){

            $(this).find('.outer-toggle-option-menu').removeClass('display');

        });

    });

    // === End of section to Display toggle option menu ===



    // === Hide option list wrap when clicking outside Toggle Option Block ===

    $(document).on('click', function(e){

        if( $(e.target).closest( $('.toggle-option-block') ).length === 0 ) {

            $('.outer-toggle-option-menu').removeClass('display');
        }

    });

    // === End of section to Hide option list wrap when clicking outside Toggle Option Block ===



    // === Hide outer toogle option menu when clicking on toggle menu block ===

    //$('.outer-toggle-option-menu .toggle-option-menu .toggle-menu-block').on('click', function(){
    $(document).on( "click", '.outer-toggle-option-menu .toggle-option-menu .toggle-menu-block', function(e) {

        $(this).parents('.outer-toggle-option-menu').removeClass('display');

    });

    // === End of section to Hide outer toogle option menu when clicking on toggle menu block ===




    // === Display Client Contact Poup Container when clicking on add client contact menu on Toggle Menu Block for client contacts ===

    //$('.client-detail-wrapper .right-section .toggle-option-block .toggle-option-menu .add-client-contact').on('click', function(){
    $(document).on( "click", '.client-detail-wrapper .right-section .toggle-option-block .toggle-option-menu .add-client-contact', function(e) {

        $('.client-contact-popup-container').addClass('display');

        $('.client-contact-popup-container .inner-popup-container .title').text('Ajouter un contact');
        $('.client-contact-popup-container .submit-validate').hide();
        $('.client-contact-popup-container .submit-add').show();

    });

    // === End of section to Display Client Contact Poup Container when clicking on add client contact menu on Toggle Menu Block for client contacts ===




    // === Hide outer toggle option menu when clicking on it when on responsive toggle option menu ===
    $(document).on( "click", '.outer-toggle-option-menu', function(e) {

    //$('.outer-toggle-option-menu').on('click', function(e){

        if( $(e.target).closest( $('.outer-toggle-option-menu .toggle-option-menu') ).length === 0 ) {

            $(this).removeClass('display');
        }

    });

    // === End of section to Hide outer toggle option menu when clicking on it when on responsive toggle option menu ===




    // === Activate search for customized select ===

    $(document).on( "keyup", '.customized-select .option-list-wrap .search-option-wrap input', function(e) {
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



$(document).on('click', '.late-payment-popup-container .inner-popup-container .middle-header-wrapper .step-wrapper .step-block', function(){

    let allSteps = $('.late-payment-popup-container .inner-popup-container .middle-header-wrapper .step-wrapper .step-block');
    allSteps.removeClass('current');
    $(this).addClass('current');
    allSteps.removeClass('previous');
    let currentStepIndex = $('.late-payment-popup-container .inner-popup-container .middle-header-wrapper .step-wrapper .step-block.current').index();

    for(var i = 0; i < currentStepIndex; i++) {

        allSteps.eq(i).addClass('previous');
    }

});


