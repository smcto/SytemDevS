$(document).ready(function() {
    
    var limit = $('#nombre-utilisateur').val();
    
    $(".select2").select2({
        maximumSelectionLength: limit
    });
    
    var base_url = $('#id_baseUrl').val();
  
    $('#type_licence_id').on('change', function(){
        var type_id = $(this).val();
        if(type_id != '') {
            var urlGet = base_url+'/fr/type-licences/get-nombre-utilisation/'+type_id+'.json';
            $.get(urlGet, function(data) {
                $('#nombre-utilisateur').val(data.nombre);
                $('#nombre-utilisateur').trigger('change');
            });
        } else {
            $('#nombre-utilisateur').val('');
            $('#nombre-utilisateur').trigger('change');
        }
    });
  
    $('#nombre-utilisateur').on('change', function() {
        limit = $(this).val();

        $(".select2").select2({
            maximumSelectionLength: limit
        });
    });
});
