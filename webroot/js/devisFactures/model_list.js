$(document).ready(function () {
    
    $('#category').on('change', function(){
        var cat = $(this).val();
        var sousCategories = modelSousCategories[cat];
        var option = '<option value>Sous catégorie</option>';
        $.each(sousCategories, function(key, value){
            option += '<option value="'+key+'">'+value+'</option>';
        });
        $('#sous-category').html(option);
    });
    
    $('#category').trigger('change');
    
});