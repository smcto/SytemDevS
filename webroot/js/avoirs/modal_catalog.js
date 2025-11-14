$(document).ready(function() {
    var srcUrl = $("#id_baseUrl").attr('value');
    
    
    // Get the input field
    var input = document.getElementById("key");
    
    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
      // Number 13 is the "Enter" key on the keyboard
      if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("search-catalog").click();
      }
    });
    
    $('#search-catalog').on('click', function() {

        var key = $('#key').val();
        var categorie = $('#categorie').val();
        var sousCat = $('#sous-categorie').val();
        $.ajax({
            url: srcUrl + "fr/ajax-catalog-produits/refresh-list-catalog?key=" + key + "&categorie=" + categorie + '&sous-categorie=' + sousCat,
            type: "GET",
            success: function (data) {
                $("#div_table_catalog").html(data);
                selectCatalog();
                deleteProductFromModal();
            }
        });
    });
    
    $('#categorie').on('change', function(event) {
        event.preventDefault();
        var categoryId = $(this).val();
        $.get(baseUrl+'fr/ajax-catalog-produits/getCatalogSousCategories/'+categoryId, function(data) {
            var option = '<option value>Toutes les sous catégories</option>';
            $.each(data, function (key, value) {
                option += '<option value="'+key+'">'+value+'</option>';
            });
            $('#sous-categorie').html(option);
        });
    });
    
    $('#cancel-search').on('click', function() {

        $.ajax({
            url: srcUrl + "fr/ajax-catalog-produits/refresh-list-catalog",
            type: "GET",
            success: function (data) {
                $("#div_table_catalog").html(data);
                selectCatalog();
                deleteProductFromModal();
            }
        });
    });
    
    selectCatalog();
    deleteProductFromModal();
    
});


function selectCatalog() {

    $("tbody.table-catalog button.add").on("click", function (e) {
        var currentTr = $(this).parents('tr');
        currentTr.find('.catalog-produit').prop('checked', true);
        if (currentTr.find('.catalog-produit').is(':checked')) {
            currentTr.addClass('d-none');

            var blocSelectedProducts = $('.bloc-selected-products');
            var clonedTr = $('tfoot tr', blocSelectedProducts).last().clone();
            var addLine = $('tbody.selected-produits', blocSelectedProducts).prepend(clonedTr);

            addLine.promise().then(function (e) {
                var newTr = $('tbody.selected-produits').find('tr').first();
                var productId = $('.catalog-produit', currentTr).val();
                newTr.attr('product-id', productId);
                $('.nom_interne', newTr).text($('.nom_interne', currentTr).text());
                $('.prix_reference_ht', newTr).text($('.prix_reference_ht', currentTr).text());
                $('.prix_reference_ttc', newTr).text($('.prix_reference_ttc', currentTr).text());
                $('.code_comptable', newTr).text($('.code_comptable', currentTr).text());

                checkDisplayBlocSelectedProducts();
            });
        }
    });
}

function deleteProductFromModal() {
    $(".div_table_selected_produits").on("click", ".delete-selected", function (e) {
        var currentTr = $(this).parents('tr');
        var productId = currentTr.attr('product-id');
        var tableCatalog = $('tbody.table-catalog');
        $('tr[product-id="'+productId+'"]', tableCatalog).removeClass('d-none');
        currentTr.remove();

        checkDisplayBlocSelectedProducts();
    });
}

function checkDisplayBlocSelectedProducts() {
    if ($('.bloc-selected-products .selected-produits tr').length > 0) {
        $('.bloc-selected-products').removeClass('d-none');
    } else {
        $('.bloc-selected-products').addClass('d-none');
    }
}


$(document).keypress(
  function(event){
    if (event.which == '13') {
      event.preventDefault();
    }
});
