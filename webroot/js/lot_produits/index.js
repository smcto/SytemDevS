$(document).ready(function() {

    if (window.location.search && window.location.search !== '?is_event=1' && window.location.search !== '?is_hs=1') {
        $('.container-filter').removeClass('d-none');
        $('.btn-show-filter').addClass('active');
    }

    $('.btn-show-filter').on('click', function(event) {
        event.preventDefault();
        if (!$(this).hasClass('active')) {
            $('.container-filter').removeClass('d-none');
            $(this).addClass('active');
        } else {
            $('.container-filter').addClass('d-none');
            $(this).removeClass('active');
        }
    });
    
    $('#action').on('change', function () {
        if($(this).val() === 'date_stock') {
            $(".date_stock").removeClass('hide');
            $(".fournisseur").addClass('hide');
            $(".tarif_achat").addClass('hide');
            $('.type-stock').addClass('hide');
        }
        if($(this).val() === 'fournisseur') {
            $(".fournisseur").removeClass('hide');
            $(".date_stock").addClass('hide');
            $(".tarif_achat").addClass('hide');
            $('.type-stock').addClass('hide');
        }
        if($(this).val() === 'tarif_achat') {
            $(".tarif_achat").removeClass('hide');
            $(".date_stock").addClass('hide');
            $(".fournisseur").addClass('hide');
            $('.type-stock').addClass('hide');
        }
        if($(this).val() === 'type_produit') {
            $(".date_stock").addClass('hide');
            $(".fournisseur").addClass('hide');
            $(".tarif_achat").addClass('hide');
            $('.type-stock').addClass('hide');
            $("#type_produit").modal('show');
        }
        if($(this).val() === 'type_stock') {
            $(".tarif_achat").addClass('hide');
            $(".date_stock").addClass('hide');
            $(".fournisseur").addClass('hide');
            $('.type-stock').removeClass('hide');
        }
    });
    
    $('.delete-produit').on('click', function () {
        var produit = $(this).parents('td').find('#delete-produit-id').val();
        if(produit != 'undefined') {
            if(confirm('Êtes-vous sûr de vouloir supprimer?')) {
                window.location.replace(baseUrl + 'fr/lot-produits/delete/' + produit);
            }
        }
    });
    
    $('#type-equipement-id').on('change', function () {
        var type_equipement = $(this).val();
        console.log(equipements);
        var liste_equipements = equipements[type_equipement];
        var option = '';
        $.each(liste_equipements, function (key, value) {
            option += '<option value="' + key + '">' + value + '</option>';
        });
        $('#equipement-id').html(option);
    });
    
    $('.btn-submit-type-produit').on('click', function () {
        $('.multi-actions').submit();
    });
    
}); 