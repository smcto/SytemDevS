// === Declare and initialize global variables ===

var countSelectedEmails = 0;
var totalEmails = 0;

// === End of section to Declare and initialize global variables ===




// === Click on card kanban to display Pipe Popup Container ===

$('.card-kanban').on('mousedown', function(e) {

    $('.card-kanban').on('mouseup mousemove', function handleMouseEvent(e) {

        // Check if element is left clicked and not moved
        if( e.which == '1' && e.type === 'mouseup' ) {

            //Call function to display pipe popup container
            displayPipePopupContainer(e);

        }

        $('.card-kanban').off('mouseup mousemove', handleMouseEvent);

    });



});


$('.container-kanban .card-kanban .card-body .card-title').on('mousedown', function(e) {

    if( e.which == '1' ) {

        //Call function to display pipe popup container
        displayPipePopupContainer(e);

    }


});


if( $(window).width() <= 767 ) {

    $('.container-kanban .card-kanban').on('mousedown', function(e) {

        if( e.which == '1' ) {

            //Call function to display pipe popup container
            displayPipePopupContainer(e);

        }


    });

}

// === End of section to Click on card kanban to display Pipe Popup Container ===



// === Function to display Pipe Popup Container ===

function displayPipePopupContainer(event) {

    if( $(event.target).closest( $('.card-body .card-options') ).length === 0 ) {

        // Display pipe popup container
        $('.pipe-popup-container').addClass('display');

        // Call function to get input size for Editable Text
        getInputSize( $('.popup-pipe-header .right-header-section .amount .editable-text') );
        getCurrencyFormatted( $('.popup-pipe-header .right-header-section .amount .editable-text') );


        // Call function to set values for customized selects
        setValuesForCustomizedSelects();

        // Call function to check client status type
        checkClientStatusType( $('.client-detail-wrapper .client-info-wrapper .customized-select .selected-value-block .text') );

        // Set total emails
        totalEmails = $('.pipe-popup-container .email-list-wrapper .email-preview-wrapper').length;

    } else {


    }


}

// === End of Function to display Pipe Popup Container ===



/* getInputSize( $('.popup-pipe-header .pipe-name input') );
getInputSize( $('.popup-pipe-header .right-header-section .amount input') );
getCurrencyFormatted( $('.popup-pipe-header .right-header-section .amount input') ); */

getInputSize( $('.popup-pipe-header .right-header-section .amount .editable-text') );
getCurrencyFormatted( $('.popup-pipe-header .right-header-section .amount .editable-text') );

// === Function to get input size for Editable Text ===

function getInputSize(input) {

    input.css({

        //'width': ( input.val().length + 0.5 ) + 'ch'

        'width': ( input.val().length + 1 ) + 'ch'

    });
}

// === End of Function to get input size for Editable Text ===


// === Display border bottom for Editable Text to indicate it is being edited ===

$('.popup-detail-wrapper .inner-detail-wrapper .popup-detail-block').on('click', function(){

    // Check if child is NOT textarea
    /* if( !$(this).find('.editable-text').is('textarea') ) {

        var currentVal = $(this).find('.editable-text').val();

        $(this).find('.editable-text').focus().val('').val(currentVal);

    } */

    $(this).find('.editable-text').focus();

});

$('.editable-text').on('click, focusin', function(){

    $(this).parents('.editable-block').addClass('editing');

});

$('.editable-text').on('blur, focusout', function(){

    $(this).parents('.editable-block').removeClass('editing');

});

// === End of section to Display border bottom for Editable Text to indicate it is being edited ===




// === Update input size while typing for Editable Text ===

//$('.editable-text').on('click, keyup', function(e){

$('.popup-pipe-header .right-header-section .amount .editable-text').on('click, keyup', function(e){


    /* if( $(e.target).closest( $('.client-contact-popup-container') ).length === 0 ) {

        // Call function to get input size for Editable Text

        getInputSize( $(this) );

    } */


    // Call function to get input size for Editable Text

    getInputSize( $(this) );


});


// === End of section to Update input size while typing for Editable Text ===


// === Get number formatted in currency way when cursor leaves input for editable amount ===

//$('.popup-pipe-header .right-header-section .amount input').on('blur', function(){

$('.popup-pipe-header .right-header-section .amount .editable-text').on('blur', function(){

    // Call function to get value formatted in currency way
    getCurrencyFormatted( $(this) );

});

// === End of section to Get number formatted in currency way when cursor leaves input for editable amount ===


// === Call function to get number formatted in currency way for editable amount ===

function getCurrencyFormatted(input) {

    // Trim value and replace comma with dot
    var trimmedValue = input.val().replace(/\s+/g, '').replace(/,/g, '.');

    input.val( new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 2 } ).format( trimmedValue ) );
}

// === End of function to Call function to get number formatted in currency way for editable amount ===



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



// === Switch between tabs for client section on Pipe Popup Container ===

$('.pipe-popup-container .client-event-tab-section .tab-block').on('click', function(){

    $('.pipe-popup-container .client-event-tab-section .tab-block').removeClass('current');
    $('.pipe-popup-container .outer-popup-detail-wrapper .popup-detail-wrapper').removeClass('display');

    $(this).addClass('current');


    if( $(this).hasClass('event-tab-block') ) {

        $('.pipe-popup-container .outer-popup-detail-wrapper .for-event-tab-wrapper').addClass('display');

    } else if( $(this).hasClass('client-tab-block') ) {

        $('.pipe-popup-container .outer-popup-detail-wrapper .client-detail-wrapper').addClass('display');

    } else if( $(this).hasClass('original-tab-block') ) {

        $('.pipe-popup-container .outer-popup-detail-wrapper .for-original-tab-wrapper').addClass('display');
    }


});


// === End of section to Switch between tabs for client section on Pipe Popup Container ===


// === Switch between tabs for popup below tag section on Pipe Popup Container ===

$('.popup-below-tab-section .tab-block').on('click', function(){

    $('.popup-below-tab-section .tab-block').removeClass('current');
    $('.pipe-popup-container .below-section-content .inner-below-section-content').removeClass('display');

    $(this).addClass('current');


    if( $(this).hasClass('comment-tab-block') ) {

        $('.pipe-popup-container .below-section-content .comment-section').addClass('display');

    } else if( $(this).hasClass('mail-tab-block') ) {

        $('.pipe-popup-container .below-section-content .email-section').addClass('display');

    } else if( $(this).hasClass('doc-tab-block') ) {

        $('.pipe-popup-container .below-section-content .doc-section').addClass('display');

        // Call function to update cell heights for customized table
        updateTableCellHeights();

    } else if( $(this).hasClass('activity-tab-block') ) {

        $('.pipe-popup-container .below-section-content .activity-section').addClass('display');
    }


});

// === End of section to Switch between tabs for popup below tag section on Pipe Popup Container ===


// === Display option list wrap when clicking on Customized Select ===

$('.customized-select .selected-value-block').on('click', function(e){

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

    if( $(e.target).closest( $('.customized-select') ).length === 0 ) {

        $('.customized-select .outer-option-list-wrap').removeClass('display');

        // Call function to reset search input on select
        resetSelectSearchInput( $(e.currentTarget).find('.search-option-wrap input') );
    }

});

// === End of section to Hide option list wrap when clicking outside Customized Select ===



// === Display value of selected option on Customized Select ===

$('.customized-select .option-list-wrap .option-block').on('click', function(){

    $(this).parents('.customized-select').find('.option-block').removeClass('selected');

    $(this).parents('.customized-select').find('.selected-value-block .text').attr('option-id',  $(this).attr('option-id') );
    $(this).parents('.customized-select').find('.selected-value-block .text').text( $(this).text() );
    $(this).addClass('selected');

    $(this).parents('.outer-option-list-wrap').removeClass('display');

    if( $(window).width() > 767 ) {

        $(this).parents('.customized-select').find('.option-list-wrap').css({

            'top': '25px'

        });

    }

});

// === End of section to Display value of selected option on Customized Select ===


// === Hide outer option list wrapper when clicking on it for responsive customized menu ===

$('.customized-select .outer-option-list-wrap').on('click', function(e){

    if( $(e.target).closest( $('.customized-select .option-list-wrap') ).length === 0 ) {

        $(this).removeClass('display');

    }


});

// === End of section to Hide outer option list wrapper when clicking on it for responsive customized menu ===



// === Display Client Contact Popup Container when clicking on edit icon wrap within contact person wrap on Pipe Popup Container ===

$('.client-detail-wrapper .right-section .contact-person-wrap .edit-icon-wrap').on('click', function(){

    $('.client-contact-popup-container').addClass('display');
    $('.client-contact-popup-container .inner-popup-container .client-contact-wrap:first-child .editable-block input').focus();

    $('.client-contact-popup-container .inner-popup-container .title').text('Éditer ce contact');
    $('.client-contact-popup-container .submit-add').hide();
    $('.client-contact-popup-container .submit-validate').show();

});

// === End of section to Display Client Contact Popup Container when clicking on edit icon wrap within contact person wrap on Pipe Popup Container ===



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



// === Close Client Contact Popup Container wen clicking validate contact button ===

//$('.small-popup-container .bottom-submit-btn-wrap .btn-validate').on('click', function(){

$('.popup-container .bottom-submit-btn-wrap .btn-validate').on('click', function(){

    //$(this).parents('.small-popup-container').removeClass('display');

    $(this).parents('.popup-container').removeClass('display');

});

// === End of section to Close Client Contact Popup Container wen clicking validate contact button ===



// === Close Pipe Popup Container ===

$('.pipe-popup-container .popup-close-wrap').on('click', function(){

    // Call function to reset all for Pipe Popup Container
    resetAllForPipePopup();

});

$('.pipe-popup-container').on('click', function(e){

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

// === End of section to Close Pipe Popup Container ===



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

$('.client-detail-wrapper .client-info-wrapper .customized-select .option-list-wrap .option-block').on('click', function(){

    // Call function to check client status type
    checkClientStatusType( $(this).attr('type-value') );

});

// === End of section to Display professional data when clicking on Professional value for option block on Pipe Popup Container ===


// === Function to check client status type ===

function checkClientStatusType( typeValue ) {

    if( typeValue == 'particulier' ) {

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

    } else if( typeValue == 'professionnel' ) {

        //$('.client-detail-wrapper .left-section .professional-client-data-wrapper .professional-data').removeClass('hide');

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

if( $('.client-detail-wrapper .client-info-wrapper .customized-select .option-list-wrap .option-block.selected').attr('type-value') == 'particulier' ) {

    checkClientStatusType( 'particulier' );

} else if( $('.client-detail-wrapper .client-info-wrapper .customized-select .option-list-wrap .option-block.selected').attr('type-value') == 'professionnel' ) {

    checkClientStatusType( 'professionnel' );
}

// === End of section to Set displayed client data according to the client's status type ===


// === Display Client Company Popup Container when clicking on edit icon wrap for left section on client tab ===

$('.client-detail-wrapper .left-section .professional-client-data-wrapper .edit-icon-wrap').on('click', function(){

    $('.client-company-popup-container').addClass('display');

});

// === End of section to Display Client Company Popup Container when clicking on edit icon wrap for left section on client tab ===


// === Check selected email preview wrapper on email list related to Email tab on Card Popup Container ===

$('.pipe-popup-container .email-list-wrapper .email-selection-block .custom-chk-email').on('click', function(){

    $(this).toggleClass('checked');

    var chkEmail = $(this).parents('.email-selection-block').find('input[type="checkbox"]');


    if( $(this).hasClass('checked') ) {

        chkEmail.prop('checked', true);

        countSelectedEmails++;

    } else {

        chkEmail.prop('checked', false);

        countSelectedEmails--;
    }


    if( countSelectedEmails > 0 ) {

        $('.pipe-popup-container .email-section .top-preview-option-wrapper .delete-email-icon-wrap').addClass('display');

    } else {

        $('.pipe-popup-container .email-section .top-preview-option-wrapper .delete-email-icon-wrap').removeClass('display');
        $('.pipe-popup-container .email-section .top-preview-option-wrapper .email-selection-block input[type="checkbox"]').prop('checked', false);
        $('.pipe-popup-container .email-section .top-preview-option-wrapper .email-selection-block .custom-chk-email').removeClass('checked');

    }

});

// === End of section to Check selected email preview wrapper on email list related to Email tab on Card Popup Container ===



// === Display WYSIWYG CKEditor on Email Editor Popup Container ===

$( 'textarea.email-editor' ).ckeditor();

CKEDITOR.config.language = 'fr';

//CKEDITOR.config.baseFloatZIndex = -1;

$( 'textarea.comment-editor' ).ckeditor();

//CKEDITOR.config.contentsCss = CKEDITOR.getUrl("");

$('#cke_38').parent().hide();

// === End of section to Display WYSIWYG CKEditor on Email Editor Popup Container ===



// === Add active class to inner email header wrap on Email Editor Popup Container ===

$('.email-editor-popup-container .email-header-wrapper .inner-email-header-wrap input').on('click, focusin', function(){

    $(this).parents('.inner-email-header-wrap').addClass('active');

});

// === End of section to Add active class to inner email header wrap on Email Editor Popup Container ===


// === Remove active class from inner email header wrap on Email Editor Popup Container ===

$('.email-editor-popup-container .email-header-wrapper .inner-email-header-wrap input').on('blur', function(){

    $(this).parents('.inner-email-header-wrap').removeClass('active');

});

// === End of section to Remove active class from inner email header wrap on Email Editor Popup Container ===



// === Display email editor popup container to create new email ===

$('.pipe-popup-container .email-section .top-preview-option-wrapper .btn-add-new-row').on('click', function(){

    $('.email-editor-popup-container').addClass('display');

    $('.email-editor-popup-container .title-wrap .title').text('nouveau mail');
    $('.email-editor-popup-container .title-wrap').removeClass('add-margin');
    $('.email-editor-popup-container .email-header-wrapper').show();
    $('.email-editor-popup-container .title-wrap .email-date-sent').hide();
    $('.email-editor-popup-container .email-header-wrapper .send-to-wrapper .label').text('Envoyer à :');
    $('.email-editor-popup-container .email-header-wrapper .inner-email-header-wrap input').prop('disabled', false);
    $('.email-editor-popup-container .email-header-wrapper .send-to-wrapper input').attr('placeholder', 'Adresse(s) e-mail');
    $('.email-editor-popup-container .email-header-wrapper .cc-to-wrapper input').attr('placeholder', 'Adresse(s) e-mail');
    $('.email-editor-popup-container .email-header-wrapper .email-subject-wrapper input').attr('placeholder', 'Sujet');

    $('.email-editor-popup-container .email-content-wrapper .attach-file-wrapper .file-attached').text('joindre fichier(s)');
        $('.email-editor-popup-container .middle-email-option-wrapper .select-email-model-wrapper').show();
        $('.email-editor-popup-container .email-content-wrapper .middle-email-option-wrapper').removeClass('increase-margin');

    //$('#cke_1_top').show();
    //$('#cke_1_contents').css('pointer-events', 'auto');

    $('#cke_editor1').show();
    $('.email-editor-popup-container .email-content-wrapper .email-content-sent').hide();

    $('.email-editor-popup-container .bottom-submit-btn-wrap').show();

});

// === End of section to Display email editor popup container to create new email ===


// === Display email editor popup container to preview email sent ===

$('.pipe-popup-container .email-list-wrapper .email-preview-wrapper').on('click', function(e){

    //if( $(e.target).closest( $('.pipe-popup-container .email-list-wrapper .email-selection-block .custom-chk-email') ).length === 0 ) {

    if( $(e.target).closest( $('.pipe-popup-container .email-list-wrapper .outer-selection-block') ).length === 0 ) {

        $('.email-editor-popup-container').addClass('display');

        $('.email-editor-popup-container .title-wrap .title').text('mail envoyé');
        $('.email-editor-popup-container .email-date-sent .created-label').text('Envoyé');
        $('.email-editor-popup-container .title-wrap .email-date-sent').show();
        $('.email-editor-popup-container .title-wrap').removeClass('add-margin');
        $('.email-editor-popup-container .email-header-wrapper').show();
        $('.email-editor-popup-container .email-header-wrapper .send-to-wrapper .label').text('Destinataire :');
        $('.email-editor-popup-container .email-header-wrapper .inner-email-header-wrap input').prop('disabled', true);
        $('.email-editor-popup-container .email-header-wrapper .send-to-wrapper input').attr('placeholder', '');
        $('.email-editor-popup-container .email-header-wrapper .cc-to-wrapper input').attr('placeholder', '');
        $('.email-editor-popup-container .email-header-wrapper .email-subject-wrapper input').attr('placeholder', '');

        $('.email-editor-popup-container .email-content-wrapper .attach-file-wrapper .file-attached').text('pièce(s) jointe(s)');
        $('.email-editor-popup-container .middle-email-option-wrapper .select-email-model-wrapper').hide();
        $('.email-editor-popup-container .email-content-wrapper .middle-email-option-wrapper').addClass('increase-margin');

        //$('#cke_1_top').hide();
        //$('#cke_1_contents').css('pointer-events', 'none');

        $('#cke_editor1').hide();
        $('.email-editor-popup-container .email-content-wrapper .email-content-sent').show();

        $('.email-editor-popup-container .bottom-submit-btn-wrap').hide();

    }

});

// === End of section to Display email editor popup container to preview email sent ===



// === Check all sent emails at once on Pipe Popup Container ===

$('.pipe-popup-container .email-section .top-preview-option-wrapper .email-selection-block .custom-chk-email').on('click', function(){

    $(this).toggleClass('checked');

    var chkEmail = $(this).parents('.email-selection-block').find('input[type="checkbox"]');

    if( chkEmail.is(':checked') ) {

        countSelectedEmails = 0;

        chkEmail.prop('checked', false);

        $('.pipe-popup-container .email-section .top-preview-option-wrapper .delete-email-icon-wrap').removeClass('display');

    } else {

        countSelectedEmails = totalEmails;

        chkEmail.prop('checked', true);

        $('.pipe-popup-container .email-section .top-preview-option-wrapper .delete-email-icon-wrap').addClass('display');

    }


    $('.pipe-popup-container .email-list-wrapper .email-preview-wrapper').each(function(){

        var selectedChkEmail = $(this).find('.email-selection-block .custom-chk-email');

        if( chkEmail.is(':checked') ) {

            selectedChkEmail.addClass('checked');
            selectedChkEmail.prop('checked', true);

        } else {

            selectedChkEmail.removeClass('checked');
            selectedChkEmail.prop('checked', false);
        }

    });


});

// === End of section to Check all sent emails at once on Pipe Popup Container ===


// === Reset selected emails when Pipe Popup Container is closing ===

$('.pipe-popup-container .popup-close-wrap').on('click', function(){

    // Call function to reset selected emails
    resetSelectedEmails();

});

$('.pipe-popup-container').on('click', function(e){

    if( $(e.target).closest( $('.pipe-popup-container .inner-popup-container') ).length === 0 ) {

        // Call function to reset selected emails
        resetSelectedEmails();
    }

});

$(document).keydown(function(e){

    // Check if escape key is pressed
    if (e.key === "Escape") {

        if( countSelectedEmails > 0 ) {

            // Call function to reset selected emails
            resetSelectedEmails();
        }
    }

});

// === End of section to Reset selected emails when Pipe Popup Container is closing ===


// === Function to reset selected emails ===

function resetSelectedEmails() {

    $('.email-selection-block .custom-chk-email').removeClass('checked');
    $('.email-selection-block input[type="checkbox"]').prop('checked', false);
    countSelectedEmails = 0;
    totalEmails = 0;

    $('.pipe-popup-container .email-section .top-preview-option-wrapper .delete-email-icon-wrap').removeClass('display');
}

// === End of Function to reset selected emails ===


// === Add active class to search block ===

$('.search-block input').on('click, focusin', function(){

    $(this).parents('.search-block').addClass('active');

});

// === End of section to Add active class to search block ===


// === Remove active class from search block ===

$('.search-block input').on('blur', function(){

    $(this).parents('.search-block').removeClass('active');

});

// === End of section to Remove active class from search block ===



// === Hide displayed option list wrap when clicking on editor on Email Editor Popup Container ===

$('body').delegate('#cke_editor1, #cke_editor1 iframe', 'click', function(){

    $('.email-editor-popup-container .customized-select .option-list-wrap.display').removeClass('display');

});

// === End of section to Hide displayed option list wrap when clicking on editor on Email Editor Popup Container ===



// === Display Add Comment Popup Container when clicking on add button within comment section on Pipe Popup Container ===

$('.comment-section .add-comment-wrap .btn-text').on('click', function(){

    $('.add-comment-popup-container').addClass('display');

});

// === End of section to Display Add Comment Popup Container when clicking on add button within comment section on Pipe Popup Container ===



// === Set max-width for column in each customized table ===


if( $(window).width() > 767 ) {

    var totalCustomCols = 0;

    $('.customized-table .column').each(function(){

        totalCustomCols = $(this).parents('.customized-table .column').length;

        $(this).css({

            'max-width': 'calc( 100% / ' + totalCustomCols + ' )'

        });

    });

}

// === End of section to Set max-width for column in each customized table ===



// === Function to update table cell heights for customized table ===

function updateTableCellHeights() {

    // === Set height of th to the highest cell's height on the same row for customized table ===

    if( $(window).width() > 767 && !( navigator.userAgent.match(/iPad/i) && window.matchMedia('(orientation: portrait)').matches ) ) {

        var thHeight = 0;

        // Call function to set cell to highest cell height for th

        setToHighestCellHeight( thHeight, '.th' );

    }

    // === End of section to Set height of th to the highest cell's height on the same row for customized table ===



    // === Set height of td to the highest cell's height on the same row for customized table ===

    if( $(window).width() > 767 && !( navigator.userAgent.match(/iPad/i) && window.matchMedia('(orientation: portrait)').matches ) ) {

        var tdHeight = 0;

        // Call function to set cell to highest cell height for td

        setToHighestCellHeight( tdHeight, '.td' );

    }

    // === End of section to Set height of td to the highest cell's height on the same row for customized table ===

}

// === End of Function to update table cell heights for customized table ===



// === Function to set height of cell to the highest cell's height on the same row for customized table ===

function setToHighestCellHeight(height, cellClass) {

    $('.customized-table .tr').each(function(){

        // Reset height
        height = 0;

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



// === Display responsive header menu ===

$('.pipeline-header-container .burger-menu-wrap').on('click', function(){

    $(this).find('div').toggleClass('active');
    $(this).parents('.pipeline-header-container').toggleClass('change-border-color');
    $('.pipeline-header-container .pipeline-menu-container').toggleClass('display');

});

// === End of section to Display responsive header menu ===


// === Hide responsive header menu ===

$('.pipeline-header-container .pipeline-menu-container').on('click', function(e){

    if( $(e.target).closest( $('.pipeline-header-container .inner-pipeline-menu-container') ).length === 0 ) {

        $('.pipeline-header-container .burger-menu-wrap div').removeClass('active');
        $('.pipeline-header-container').removeClass('change-border-color');
        $('.pipeline-header-container .pipeline-menu-container').removeClass('display');
    }

});

// === End of section to Hide responsive header menu ===



// === Display toggle option menu ===

$('.toggle-option-block').on('click', function(e){

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

$('.outer-toggle-option-menu .toggle-option-menu .toggle-menu-block').on('click', function(){

    $(this).parents('.outer-toggle-option-menu').removeClass('display');

});

// === End of section to Hide outer toogle option menu when clicking on toggle menu block ===



// === Display Client Contact Poup Container when clicking on add client contact menu on Toggle Menu Block for client contacts ===

$('.client-detail-wrapper .right-section .toggle-option-block .toggle-option-menu .add-client-contact').on('click', function(){

    $('.client-contact-popup-container').addClass('display');

    $('.client-contact-popup-container .inner-popup-container .title').text('Ajouter un contact');
    $('.client-contact-popup-container .submit-validate').hide();
    $('.client-contact-popup-container .submit-add').show();

});

// === End of section to Display Client Contact Poup Container when clicking on add client contact menu on Toggle Menu Block for client contacts ===


// === Hide outer toggle option menu when clicking on it when on responsive toggle option menu ===

$('.outer-toggle-option-menu').on('click', function(e){

    if( $(event.target).closest( $('.outer-toggle-option-menu .toggle-option-menu') ).length === 0 ) {

        $(this).removeClass('display');
    }

});

// === End of section to Hide outer toggle option menu when clicking on it when on responsive toggle option menu ===


// === Add tag within tag container ===

var tagExists = false;

$('.tag-container textarea').on('keydown', function(e) {

    if( e.key === "Enter" ) {


        // Call function to add tag to list
        addTagToList( $(this) );


        // Prevent textarea from line breaking
        return false;

    }


});


// === End of section to Add tag within tag container ===


// === Function to add tag to list ===

function addTagToList(textarea) {

    //var enteredTag = $.trim( textarea.val() );

    var enteredTag = textarea.val().trim();


    $('.tag-container .tag').each(function(){

        if( $(this).text().trim() === enteredTag ) {

            tagExists = true;
        }

    });


    // Check if textarea has value

    if( enteredTag ) {

        if( !tagExists ) {

            textarea.parents('.tag-container').find('.tag-list-content-wrap').append( '<div class="tag"><div class="text">' + enteredTag + '</div><svg viewBox="0 0 348.333 348.334"><path d="M336.559 68.611L231.016 174.165l105.543 105.549c15.699 15.705 15.699 41.145 0 56.85-7.844 7.844-18.128 11.769-28.407 11.769-10.296 0-20.581-3.919-28.419-11.769L174.167 231.003 68.609 336.563c-7.843 7.844-18.128 11.769-28.416 11.769-10.285 0-20.563-3.919-28.413-11.769-15.699-15.698-15.699-41.139 0-56.85l105.54-105.549L11.774 68.611c-15.699-15.699-15.699-41.145 0-56.844 15.696-15.687 41.127-15.687 56.829 0l105.563 105.554L279.721 11.767c15.705-15.687 41.139-15.687 56.832 0 15.705 15.699 15.705 41.145.006 56.844z"/></svg></div>' );

            textarea.parents('.tag-container').find('.tag svg').addClass('display');

            var belowHeaderScroll = textarea.parents('.popup-below-header-wrapper')[0].scrollWidth;
            var belowHeaderContentWidth = textarea.parents('.popup-below-header-wrapper').find('.pipe-step-container').outerWidth(true) + textarea.parents('.popup-below-header-wrapper').find('.right-section').outerWidth(true);

            if( belowHeaderContentWidth > belowHeaderScroll ) {

                textarea.parents('.right-section').addClass('add-spacing');
                textarea.parents('.right-section').find('.tag').addClass('add-spacing');

                textarea.addClass('add-spacing');
            }

            /* var rightSectionScroll = textarea.parents('.right-section')[0].scrollWidth;
            var rightSectionContentWidth = textarea.parents('.right-section').find('.tag-container').outerWidth(true) + textarea.parents('.right-section').find('.edit-icon-wrap').outerWidth(true);

            if( rightSectionContentWidth > rightSectionScroll ) {

                textarea.parents('.right-section').find('.tag').addClass('add-spacing');

            } */

            var tagListScroll = textarea.parents('.tag-container').find('.tag-list-content-wrap')[0].scrollWidth;
            var tagListContentWidth = textarea.parents('.tag-container').find('.tag-list-content-wrap').outerWidth(true);

            if( tagListContentWidth > tagListScroll ) {

                textarea.parents('.right-section').find('.tag').addClass('add-spacing');

                //textarea.addClass('add-spacing');

                textarea.parents('.right-section').find('.edit-icon-wrap').addClass('align-icon');
            }


            // Clear value of textarea
            textarea.val('');

            // Call function to reset placeholder of textarea related to tags
            resetTagTextAreaPlaceholder( textarea );


        } else {

            textarea.addClass('with-error');

            // Clear value of textarea
            textarea.val('');

            //textarea.attr('placeholder', 'Tag déjà existant');

            textarea.attr('placeholder', 'Ce tag existe déjà');

            // Reset tag exists variable
            tagExists = false;
        }

        // Prevent textarea from line breaking
        //return false;

    }

}

// === End of Function to add tag to list ===



// === Remove clicked tag from tag list content wrap ===

$(document).on('click', '.tag-container .tag svg', function(e){

    // Call function to reset placeholder of textarea related to tags
    resetTagTextAreaPlaceholder( $(e.currentTarget).parents('.tag-container').find('textarea') );

    // Set focus on textarea
    $(e.currentTarget).parents('.tag-container').find('textarea').focus();

    // Remove current tag
    $(e.currentTarget).parents('.tag').remove();

    // Call function to reset elements related to tags
    resetTagElementRelated();

});

// === End of section to Remove clicked tag from tag list content wrap ===


// === Function to reset elements related to tags ===

function resetTagElementRelated() {

    var belowHeaderScroll = $('.popup-below-header-wrapper')[0].scrollWidth;
    var belowHeaderContentWidth = $('.pipe-step-container').outerWidth(true) + $('.popup-below-header-wrapper .right-section').outerWidth(true);

    if( belowHeaderContentWidth <= belowHeaderScroll ) {

        $('.popup-below-header-wrapper .right-section').removeClass('add-spacing');

        $('.tag-container .tag').removeClass('add-spacing');
    }


    var tagListScroll = $('.tag-container .tag-list-content-wrap')[0].scrollWidth;
    var tagListContentWidth = $('.tag-container .tag-list-content-wrap').outerWidth(true);

    if( tagListContentWidth <= tagListScroll ) {

        $('.tag-container .tag').removeClass('add-spacing');
        $('.tag-container textarea').removeClass('add-spacing');
        $('.popup-below-header-wrapper .right-section .edit-icon-wrap').removeClass('align-icon');
    }
}

// === End of Function to reset elements related to tags ===


// === Function to reset placeholder of textarea related to tags ===

function resetTagTextAreaPlaceholder(textarea) {

    textarea.removeClass('with-error');
    textarea.attr('placeholder', 'Entrer des tags');
}

// === End of Function to reset placeholder of textarea related to tags ===


// === Remove last tag when pressing backspace key ===

$('.tag-container textarea').on('keydown', function(e) {

    if( e.which == 8 ) {

        // Call function to reset placeholder of textarea related to tags
        resetTagTextAreaPlaceholder( $(this) );

        if( !$(this).val() ) {

            // Remove last tag
            $('.tag-container .tag:last-child').remove();

            // Call function to reset elements related to tags
            resetTagElementRelated();

        }

    }

});

// === End of section to Remove last tag when pressing backspace key ===


// === Display textarea to add tags ===

$('.popup-below-header-wrapper .right-section .edit-icon-wrap').on('click', function(){


    $(this).parents('.right-section').find('.tag-container').toggleClass('active');
    $(this).parents('.right-section').find('.tag-container .tag svg').toggleClass('display');


    /* -- To uncomment if NO need to indicate editable textarea when there are no tags --

    $(this).parents('.right-section').find('textarea').toggleClass('display');

    */


    // Call function to reset placeholder of textarea related to tags
    resetTagTextAreaPlaceholder( $(this).parents('.right-section').find('textarea') );


    // Toggle focus for tag textarea when toggle clicking on edit icon wrap
    if( $(this).parents('.right-section').find('.tag-container').hasClass('active') ) {

        $(this).parents('.right-section').find('textarea').focus();

    }


    if( $(this).parents('.right-section').find('.tag-container .tag').length > 0 ) {

        $(this).parents('.right-section').find('textarea').toggleClass('display');

    }


});

// === End of section to Display textarea to add tags ===




// === Set tags as not editable when clicking outside of its main outer container ===

$('.pipe-popup-container').on('click', function(e){

    if( $(e.target).closest( $('.popup-below-header-wrapper .right-section') ).length === 0 ) {

        if( $('.tag-container textarea').val().trim().length == 0 ) {

            $('.tag-container').removeClass('active');
            $('.tag-container .tag svg').removeClass('display');
            resetTagTextAreaPlaceholder( $('.tag-container textarea') );


            /* -- To uncomment if NO need to indicate editable textarea when there are no tags --

            $('.tag-container textarea').removeClass('display');

            */


            // Still show editable textarea when there are no tags
            if( $('.tag-container .tag').length != 0 ) {

                $('.tag-container').removeClass('no-tag-indication');

                $('.tag-container textarea').removeClass('display');


            } else {

                $('.tag-container').addClass('no-tag-indication');

            }

            //$('.tag-container textarea').val('');

        } else {


            // Call function to add tag to list
            addTagToList( $('.tag-container textarea') );


            // Prevent textarea from line breaking
            return false;

        }



    }

});

// === End of section to Set tags as not editable when clicking outside of its main outer container ===



// === Set tag container as active when clicking on textarea for tags ===

$('.tag-container textarea').on('click', function(){

    $('.tag-container').addClass('active');

});

// === End of section to Set tag container as active when clicking on textarea for tags ===



$('.customized-select .option-list-wrap .search-option-wrap input').on('keyup', function(){

    var value = $(this).val().toLowerCase();

    $(this).parents('.customized-select').find('.option-list-wrap .option-block').each(function() {

        //$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);


        if( ($(this).text().toLowerCase().indexOf(value) < 1 ) ) {

            $(this).addClass('hide-from-search-result');

        } else {

            $(this).removeClass('hide-from-search-result');
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


























