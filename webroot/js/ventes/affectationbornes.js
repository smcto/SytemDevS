$('.btn-borne').on("click", function () {
    var parc_id = $(this).data('parc');
    var gamme_borne_id = $(this).data('gamme'); // gamme_borne_id
    var parc_nom = $(this).data('parcname');
    var gamme_nom = $(this).data('gamme-name');
    var venteId = $(this).data('id');
    var value    = $(this).data('value');
    var valueName    = $(this).data('valuename');

    // rappel : une fois affecter, la borne choisie devient une borne de type parc vente et n'est plus listée en tant que stock tampon
    $.get(baseUrl+'fr/bornes/findWithNotations/', function(data) {
        var bornes = data;
        
        var borne_list = bornes[3+';'+gamme_borne_id]; // on choisit les parcs du types stock tampon
        document.form_edit.action = baseUrl+"fr/ventes/venteToBorne/"+venteId;
        var option = '<option value>Séléctionner</option>';
        if(value != '' && valueName !=''){
            option += '<option value="'+value+'" selected=selected>'+valueName+'</option>';
        }
        $.each(borne_list, function(key, values){
            option += '<option value="'+key+'">'+values+'</option>';
        });
        $('#borne-id').html(option);
        $('#label-parc').html(parc_nom+gamme_nom);
        
    });
});