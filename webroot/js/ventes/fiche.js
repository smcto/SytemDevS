$(document).ready(function($) {
    
    // On vient cocher une case, comme dans un site e-commerce, pour dire si c’est le même contact ou s’il est différent
    $('input#project_is_same_contact_as_client').click(function(event) {
        if ($(this).is(':checked')) {
            $('.container-project').addClass('d-none');
            $('.container-project').find('input , select').attr('disabled', 'disabled');
        } else {
            $('.container-project').removeClass('d-none');
            $('.container-project').find('input , select').removeAttr('disabled');
        }
    });
    setAttrDisabledToChilds($('.container-project.d-none'));

    function setAttrDisabledToChilds(el) {
        el.find('input , select').attr('disabled', 'disabled');
    }

    // mark active onglet
    // If li contain data-active (for other pages in the same active context)
    var current = window.location.href.split('?')[0];
    $('.etap-crea-vente-container .col a').each(function(e) {
        var self = $(this);

        // if the current path is like this link, make it active
        linkPath = self.attr('href').split('?')[0];
        if(linkPath == current){
            self.addClass('active')
        }

        if (!self.hasClass('active')) {
            self.addClass('text-dark')
        }
    });

    // si precistion sur select, affiche un textarea en bas
    $('select#needprecision').on('changed.bs.select', function(event) {
        event.preventDefault();
        currentRowFluid = $(this).parents('.row-fluid').first();

        if ($(this).val() == 1) {
            currentRowFluid.find('.hidden-precision').removeClass('d-none');
        } else {
            currentRowFluid.find('.hidden-precision').addClass('d-none');
            currentRowFluid.find('.hidden-precision').find('input , textarea').val('');
        }
    }); 

    // si precistion sur select, affiche un textarea en bas
    $('input[neednote]').on('click', function(event) {
        currentRowFluid = $(this).parents('.row-fluid').first();
        if ($(this).is(':checked')) {
            currentRowFluid.find('.hidden-precision').removeClass('d-none');
        } else {
            currentRowFluid.find('.hidden-precision').addClass('d-none');
        }
    });

    // wysiwyg
    if ($('.textarea_editor').length > 0) {
        $('.textarea_editor').wysihtml5({
            'locale': 'fr-FR',
            'image': false,
            "stylesheets": false
        });
    }

    containerName = [];
    $('input , select, textarea').each(function(index, el) {
        if (
            $(this).attr('name') !== undefined &&
            $(this).attr('name') != '_method' &&
            $(this).attr('name') != "_wysihtml5_mode"
        ) {
            containerName.push($(this).attr('name'));
        }
    });


    $('.save_vente').click(function(event) {
        event.preventDefault();
        formAction = $('.step-vente').attr('action');
        newFormAction = formAction+'?save_directly_from_top_bottom=true';
        formAction = $('.step-vente').attr('action', newFormAction).promise().then(function (e) {
            $('.step-vente').submit();
        });
    });

});