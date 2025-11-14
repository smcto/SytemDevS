// === Display Late Payment Popup Container ===
var srcUrl = $("#id_baseUrl").attr('value');

$(document).on('click', '.popup-detail', function(e){
    
    var link = $(e.target);
    var facture_id = link.attr('data-facture');

    $('.pipeline-large-loader-container').addClass('display');

    $.get(srcUrl + 'fr/ajax-devis-factures/getDatasClientFacture/' + facture_id, function(data, xhr) {
        
        $('.details-facture-client').html(data);

        $('.pipeline-large-loader-container').removeClass('display');
        $('.late-payment-popup-container').addClass('display');
        trimTextAreaSpace( $('.late-payment-popup-container #description_retard') );
        setPrevious();
    });
    
});

// === End of section to Display Late Payment Popup Container ===



// === Display border bottom for Editable Text to indicate it is being edited ===

$(document).on('click', '.popup-detail-wrapper .inner-detail-wrapper .popup-detail-block', function(){

    // Check if child is NOT textarea
    /* if( !$(this).find('.editable-text').is('textarea') ) {

        var currentVal = $(this).find('.editable-text').val();

        $(this).find('.editable-text').focus().val('').val(currentVal);

    } */

    $(this).find('.editable-text').focus();

});

$(document).on('click, focusin', '.editable-text', function(){

    $(this).parents('.editable-block').addClass('editing');

});

$(document).on('blur, focusout', '.editable-text', function(){

    $(this).parents('.editable-block').removeClass('editing');

    var description_retard = $.trim($(this).val());
    var facture_id = $('#facture').val();
    
    $.ajax({
        url: srcUrl + 'fr/ajax-devis-factures/update-description-retard/' + facture_id,
        type: "POST",
        dataType: 'json',
        data: {
            description_retard: description_retard
        },
        success: function(data) {
            
        },
        error: function(data) {
            console.log('Erreur:', data);
        }
    });
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

$(document).on('click', '.client-event-tab-section .tab-block', function(){

    $(this).parents('.popup-container').find('.client-event-tab-section .tab-block').removeClass('current');
    $(this).parents('.popup-container').find('.popup-detail-wrapper').removeClass('display');

    $(this).addClass('current');

    if( $(this).hasClass('client-tab-block') ) {

        $(this).parents('.popup-container').find('.client-detail-wrapper').addClass('display');

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



// === Switch between tabs for popup below tab section on Popup Container ===

$(document).on('click', '.popup-below-tab-section .tab-block', function(){

    $('.popup-below-tab-section .tab-block').removeClass('current');
    $(this).addClass('current');
    $('.below-section-content .inner-below-section-content').removeClass('display');

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




// === Customized styles for Firefox ===

if( navigator.userAgent.indexOf("Firefox") > -1 ) {

    $('.popup-container .inner-popup-container .below-section-content').css('padding-bottom', '40px');

}

// === End of section to Customized styles for Firefox ===




// === Display option list wrap when clicking on Customized Select ===

$(document).on('click', '.customized-select .selected-value-block', function(e) {

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


// === Display Client Contact Poup Container when clicking on add client contact menu on Toggle Menu Block for client contacts ===

$(document).on('click', '.client-detail-wrapper .right-section .toggle-option-block .toggle-option-menu .add-client-contact', function(){

    $('.pipeline-large-loader-container').addClass('display');

    $.get(srcUrl + 'fr/ajax-devis-factures/getContactClient', function(data, xhr) {

        $('.client-contact-popup-container').html(data);

        $('.pipeline-large-loader-container').removeClass('display');
        $('.client-contact-popup-container').addClass('display');
        $('.client-contact-popup-container .inner-popup-container .title').text('Ajouter un contact');
        $('.client-contact-popup-container .submit-validate').hide();
        $('.client-contact-popup-container .submit-add').show();
    });

});

// === End of section to Display Client Contact Poup Container when clicking on add client contact menu on Toggle Menu Block for client contacts ===



// === Display Client Contact Popup Container when clicking on edit icon wrap within contact person wrap on Popup Container ===

$(document).on('click', '.client-detail-wrapper .right-section .contact-person-wrap .edit-icon-wrap', function(){

    var contact_id = $(this).find('.id-contact').val();
    
    $('.pipeline-large-loader-container').addClass('display');

    $.get(srcUrl + 'fr/ajax-devis-factures/getContactClient/' + contact_id, function(data, xhr) {

        $('.client-contact-popup-container').html(data);

        $('.pipeline-large-loader-container').removeClass('display');
        $('.client-contact-popup-container').addClass('display');

        $('.client-contact-popup-container .inner-popup-container .client-contact-wrap:first-child .editable-block input').focus();

        $('.client-contact-popup-container .inner-popup-container .title').text('Ã‰diter ce contact');
        $('.client-contact-popup-container .submit-add').hide();
        $('.client-contact-popup-container .submit-validate').show();
    });

});

// === End of section to Display Client Contact Popup Container when clicking on edit icon wrap within contact person wrap on Popup Container ===



// === Close Client Contact Popup Container wen clicking validate contact button ===

$(document).on('click', '.small-popup-container .bottom-submit-btn-wrap .btn-validate', function(){

    $('.pipeline-large-loader-container').addClass('display');

    var facture_id = $('#facture').val();

    $.ajax({
        type: 'POST',
        url: srcUrl + 'fr/ajax-devis-factures/add-contact',
        dataType: 'json',
        data: {
            id: $('#contact-id').val(),
            nom: $('#contact-nom').val(),
            prenom: $('#contact-prenom').val(),
            email: $('#contact-email').val(),
            tel: $('#contact-tel').val(),
            position: $('#contact-position').val(),
            contact_note: $('#contact-note').val(),
            client_id: $('#id-client-add-contact').val()
        },
        success: function (data) {

            $('.small-popup-container').removeClass('display');
    
            $.get(srcUrl + 'fr/ajax-devis-factures/getDatasClientFacture/' + facture_id, function(data, xhr) {

                $('.details-facture-client').html(data);

                    $('.pipeline-large-loader-container').removeClass('display');
                    $('.late-payment-popup-container').addClass('display');
                    setPrevious();
            });
                        
        }
    });

});

// === End of section to Close Client Contact Popup Container wen clicking validate contact button ===



// === Display Add Comment Popup Container when clicking on add button within comment section on Popup Container ===

$(document).on('click', '.comment-section .add-comment-wrap .btn-text', function(e){
    
    $('.pipeline-large-loader-container').addClass('display');
    $('#id_commentaire').val('');
    $('#content_commentaire').val('');
    $('#titre_commentaire').val('');
    
    setTimeout(function(){

        $('.pipeline-large-loader-container').removeClass('display');
        $('.add-comment-popup-container .title').text('Ajouter un commentaire');
        $('.add-comment-popup-container .bottom-submit-btn-wrap .btn-validate').hide();
        $('.add-comment-popup-container .bottom-submit-btn-wrap #btn-add-comment').show();
        $('.add-comment-popup-container').addClass('display');

    }, 2000);

});

// === End of section to Display Add Comment Popup Container when clicking on add button within comment section on Popup Container ===



// === Close Add Comment Popup Container when clicking on submit button ===

$(document).on('click', '.add-comment-popup-container #btn-add-comment', function(){

    $('.pipeline-large-loader-container').addClass('display');
    
    var facture_id = $('#facture').val();
    var titre = $('#titre_commentaire').val();
    var content = $('#content_commentaire').val();
    
    $.ajax({
        url: srcUrl + 'fr/ajax-devis-factures/ajout-commentaire/' + '/' + facture_id,
        type: "POST",
        dataType: 'json',
        data: {
            titre: titre,
            content:content
        },
        success: function(data) {
            
            $.get(srcUrl + 'fr/ajax-devis-factures/getDatasClientFacture/' + facture_id, function(data, xhr) {

                $('.details-facture-client').html(data);

                    $('.pipeline-large-loader-container').removeClass('display');
                    $('.late-payment-popup-container').addClass('display');
                    setPrevious();
            });
        },
        error: function(data) {
            console.log('Erreur:', data);
        }
    });
    
    $(this).parents('.popup-container').removeClass('display');

});


$(document).on('click', '.add-comment-popup-container #btn-update-comment', function(){

    $('.pipeline-large-loader-container').addClass('display');
    
    var facture_id = $('#facture').val();
    var titre = $('#titre_commentaire').val();
    var content = $('#content_commentaire').val();
    var id_commentaire = $('#id_commentaire').val();
    
    $.ajax({
        url: srcUrl + 'fr/ajax-devis-factures/ajout-commentaire/' + '/' + facture_id + '/' + id_commentaire,
        type: "POST",
        dataType: 'json',
        data: {
            titre: titre,
            content:content
        },
        success: function(data) {
            
            $.get(srcUrl + 'fr/ajax-devis-factures/getDatasClientFacture/' + facture_id, function(data, xhr) {

                $('.details-facture-client').html(data);

                    $('.pipeline-large-loader-container').removeClass('display');
                    $('.late-payment-popup-container').addClass('display');
                    setPrevious();
            });
        },
        error: function(data) {
            console.log('Erreur:', data);
        }
    });
    
    $(this).parents('.popup-container').removeClass('display');

});

// === End of section to Close Add Comment Popup Container when clicking on submit button ===



// === Display Add Comment Popup Container when clicking on modify button within comment section on Popup Container ===

$(document).on('click', '.comment-section .outer-toggle-option-menu .modify-toggle-block', function(e){

    $('.pipeline-large-loader-container').addClass('display');
    var commentaire_id = $(this).find('.commentaire-id').val();
    
    $.get(srcUrl + 'fr/ajax-devis-factures/getFactureCommentaire/' + commentaire_id, function(data, xhr) {

        $('#content_commentaire').val(data.content);
        $('#titre_commentaire').val(data.titre);
        $('#id_commentaire').val(commentaire_id);
        $('.pipeline-large-loader-container').removeClass('display');
        $('.add-comment-popup-container .title').text('Modifier le commentaire');
        $('.add-comment-popup-container .bottom-submit-btn-wrap .btn-validate').hide();
        $('.add-comment-popup-container .bottom-submit-btn-wrap #btn-update-comment').show();
        $('.add-comment-popup-container').addClass('display');

    });
    
});

// === End of section to Display Add Comment Popup Container when clicking on modify button within comment section on Popup Container ===


// === Display Add Comment Popup Container when clicking on modify button within comment section on Popup Container ===

$(document).on('click', '.comment-section .outer-toggle-option-menu .delete-toggle-block', function(e){
       
    if(confirm('Etes-vous sÃ»r de vouloir supprimer ?')) {
        
        $('.pipeline-large-loader-container').addClass('display');
        var id_commentaire = $(this).find('.commentaire-id').val();
        var facture_id = $('#facture').val();
        
        $.ajax({
            url: srcUrl + 'fr/ajax-devis-factures/delete-commentaire/'+ facture_id + '/' + id_commentaire,
            type: "POST",
            success: function(data) {

                $.get(srcUrl + 'fr/ajax-devis-factures/getDatasClientFacture/' + facture_id, function(data, xhr) {

                    $('.details-facture-client').html(data);

                        $('.pipeline-large-loader-container').removeClass('display');
                        $('.late-payment-popup-container').addClass('display');
                        setPrevious();
                });
            },
            error: function(data) {
                console.log('Erreur:', data);
            }
        });
    }
    
    return false;
});

// === End of section to Display Add Comment Popup Container when clicking on modify button within comment section on Popup Container ===



// === Display WYSIWYG CKEditor on Email Editor Popup Container ===

CKEDITOR.config.language = 'fr';

//CKEDITOR.config.baseFloatZIndex = -1;

$('.add-comment-popup-container textarea.comment-editor').ckeditor();

//CKEDITOR.config.contentsCss = CKEDITOR.getUrl("");

$('#cke_38').parent().hide();

// === End of section to Display WYSIWYG CKEditor on Email Editor Popup Container ===


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


// === Display toggle option menu ===

$(document).on('click', '.toggle-option-block', function(e){

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

$(document).on('click', '.outer-toggle-option-menu .toggle-option-menu .toggle-menu-block', function(){

    $(this).parents('.outer-toggle-option-menu').removeClass('display');

});

// === End of section to Hide outer toogle option menu when clicking on toggle menu block ===


// === Hide outer toggle option menu when clicking on it when on responsive toggle option menu ===

$(document).on('click', '.outer-toggle-option-menu', function(e){

    if( $(e.target).closest( $('.outer-toggle-option-menu .toggle-option-menu') ).length === 0 ) {

        $(this).removeClass('display');
    }

});

// === End of section to Hide outer toggle option menu when clicking on it when on responsive toggle option menu ===



// === Activate search for customized select ===

$(document).on('keyup', '.customized-select .option-list-wrap .search-option-wrap input', function(){

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



// === Click on step block within Late Payement Popup Container ===

$(document).on('click', '.late-payment-popup-container .middle-header-wrapper .step-block', function(){

    // === ne pas modifier si deja current ===
    if (! $(this).hasClass('current')) {
        
        var progression = $(this).find('.value').val();
        var facture_id = $('#facture').val();

        $.ajax({
            url: srcUrl + 'fr/ajax-devis-factures/update-progression/' + facture_id,
            type: "POST",
            dataType: 'json',
            data: {
                progression: progression
            },
            success: function(data) {

            },
            error: function(data) {
                console.log('Erreur:', data);
            },
        });
    }
    
    
    let allSteps = $('.late-payment-popup-container .middle-header-wrapper .step-block');
    allSteps.removeClass('current');
    $(this).addClass('current');
    allSteps.removeClass('previous');
    let currentStepIndex = $('.late-payment-popup-container .middle-header-wrapper .step-block.current').index();

    for(var i = 0; i < currentStepIndex; i++) {

        allSteps.eq(i).addClass('previous');
    }

});

// === End of function to Click on step block within Late Payement Popup Container ===

function setPrevious() {
    
        let allSteps = $('.late-payment-popup-container .middle-header-wrapper .step-block');
        let currentStepIndex = $('.late-payment-popup-container .middle-header-wrapper .step-block.current').index();

        for(var i = 0; i < currentStepIndex; i++) {

            allSteps.eq(i).addClass('previous');
        }
}


