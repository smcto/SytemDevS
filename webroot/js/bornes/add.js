$(document).ready(function(){

    $(".select2").select2({
        allowClear: true
    });

    var srcUrl = $("#id_baseUrl").attr('value');
    var nombre = 0;
    

    $('#type-win-licence').on('change', function(){
        var type_win_licence = $(this).val();
        console.log(type_win_licence);
        var list_win_licence = numeroSeriesLicenceWin[type_win_licence];
        console.log(list_win_licence);
        var option = '<option value>Séléctionner</option>';
        $('#numero-series-win-licence').html(option);
        if (type_win_licence == 6 || type_win_licence == 5){
            $('.ns-win-licence').removeClass('hide');
            $.each(list_win_licence, function(key, value){
                option += '<option value="'+key+'">'+value+'</option>';
            });
            $('#numero-series-win-licence').html(option);
            console.log('option');
        }
    });
    $('#type-win-licence').trigger('change');

    // modelBornes
    $('#gamme').on('change', function(){
        var gamme = $(this).val();
        var liste_model_bornes = modelBornes[gamme];
        var option = '<option value>Séléctionner</option>';
        $.each(liste_model_bornes, function(key, value){
                option += '<option value="'+key+'">'+value+'</option>';
        });
        $('#model_borne_id').html(option);
        
        $.ajax({
            url : srcUrl + 'fr/ajax-bornes/equipement-by-gamme/' + gamme,
            type : "GET",
            beforeSend: function() {
                $("#id_loader").show();
            },
            success: function (data) {
                $("#dev-equipement").html(data);
                nombre = $('#nombre').val();
                equipementsBorne(nombre - 1);
                $("#id_loader").hide();
            }
        });
        
    });
    // $('#gamme').trigger('change');
    
    $('#model_borne_id').on('change', function() {
        var model = $(this).val();
        $.ajax({
            url : srcUrl + 'fr/ajax-bornes/equipement-by-model-borne/' + model,
            type : "GET",
            beforeSend: function() {
                $("#id_loader").show();
            },
            success: function (data) {
                for(var i=0; i<nombre; i++){
                    var type = $('#equipement-bornes-' + i + '-type-equipement-id').val();
                    if(data[type] != 'undefined' && data[type] != null) {
                        $('#equipement-bornes-' + i + '-equipement-id').val(data[type]);
                        $('#equipement-bornes-' + i + '-equipement-id').trigger('change.select2');
                        $('#equipement-bornes-' + i + '-equipement-id').trigger('change');
                    }
                }
                $("#id_loader").hide();
            }
        });
    });
    
    $('#id_parc').on('change', function(){
        var parc_id = $(this).val();
        if (parc_id == 2){
            $('.antenne-id').removeClass('hide');
            $('.client-id').addClass('hide');
            $('[name="client_id"]').val('').trigger('change');
            $('.sous-loc').addClass('hide');
            $('.antenne-loc').addClass('hide');
            $('#is_sous_louee').val('0');
        }else if(parc_id == 1 || parc_id == 4 || parc_id == 9){
            $('.antenne-id').addClass('hide');
            $('.client-id').removeClass('hide');
            $('.sous-loc').removeClass('hide');
        }else{
            $('.antenne-id').addClass('hide');
            $('.client-id').addClass('hide');
            $('[name="client_id"]').val('').trigger('change');
            $('.sous-loc').addClass('hide');
            $('.antenne-loc').addClass('hide');
            $('#is_sous_louee').val('0');
        }
    });

    $('#is_sous_louee').on('change', function(){
        var loc = $(this).val();
        if(loc == '1'){
            $('.antenne-loc').removeClass('hide');
        }else{
            $('.antenne-loc').addClass('hide');
        }
    });
    
    $('#is_sous_louee').trigger('change');
});


function equipementsBorne(nombre) {
    
    if(nombre != 'undefined' && nombre >= 0) {
        
        var j = nombre;
        var type = $('#equipement-bornes-' + j + '-type-equipement-id').val();
        var old_type = $('#equipement-bornes-' + j + '-old-equipement-id').val();
        var equipement = equipements[type];

        var option = '<option value>Séléctionner</option>';
        $.each(equipement, function(key, value){
            if(old_type == key) {
                option += '<option value="'+key+'" selected = selected>'+value+'</option>';
            }else {
                option += '<option value="'+key+'">'+value+'</option>';
            }
        });
        $('#equipement-bornes-' + j + '-equipement-id').html(option);
        
        $('#equipement-bornes-' + j + '-equipement-id').on('change', function(){
            var equip = $(this).val();
            var old_equip = $('#equipement-bornes-' + j + '-old-numero-serie-id').val();
            var numeroSeries = equip ? numeroSeriesEquip[equip] : [];

            var option = '<option value>Séléctionner</option>';
            $.each(numeroSeries, function(key, value){
                if(old_equip == key) {
                    option += '<option value="'+key+'" selected = selected>'+value+'</option>';
                }else {
                    option += '<option value="'+key+'">'+value+'</option>';
                }
            });
            $('#equipement-bornes-' + j + '-numero-serie-id').html(option);
        });
        $('#equipement-bornes-' + j + '-equipement-id').trigger('change');
        
        $('#equipement-bornes-' + j + '-aucun').on('change', function(){
            if($(this).prop('checked')){
                $('.' + j + '-aucun').removeClass('hide');
                $('.' + j + '-exist').addClass('hide');
            }else{
                $('.' + j + '-aucun').addClass('hide');
                $('.' + j + '-exist').removeClass('hide');
            }
        });
        
        $('#equipement-bornes-' + j + '-new-stock').on('change', function(){
            if($(this).prop('checked')){
                $('.' + j + '-stock').removeClass('hide');
                $('.' + j + '-hide-stock').addClass('hide');
                $('.' + j + '-exist').removeClass('col-md-6').addClass('col-md-4');
            }else{
                $('.' + j + '-stock').addClass('hide');
                $('.' + j + '-hide-stock').removeClass('hide');
                $('.' + j + '-exist').removeClass('col-md-4').addClass('col-md-6');
            }
        });
        equipementsBorne(nombre - 1);
    }
    
    $(".select2").select2({
        allowClear: true
    });
    
    // ----- checkbox tr collapse AJAX ----------
    $('.tr-container-checkbox input[type="checkbox"]').click(function(event) {
        self = $(this);
        dataTarget  = self.attr('data-target');

        if (self.is(':checked')) {
            $('tr#'+dataTarget).removeClass('d-none');
            $('tr#'+dataTarget).find('input[type="number"]').val('');
        } else {
            $('tr#'+dataTarget).addClass('d-none');
        }
    });
    
    $('.tr-container-checkbox input[type="checkbox"]').each(function(index, el) {
        var self = $(this);
        var dataTarget  = self.attr('data-target');

        if (self.is(':checked')) {
            $('tr#'+dataTarget).removeClass('d-none');
        } else {
            $('tr#'+dataTarget).addClass('d-none');
        }
    });
}
