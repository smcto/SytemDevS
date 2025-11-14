$(document).ready(function() {

    $("#id_type_installation").change(function(){
        var val = $(this).val();

        if(val == 1){
            $("#id_personne_affecte").removeClass('hide');
            $("#id_personne_affecte select").attr('required', true);
        }else {
            $("#id_personne_affecte").addClass('hide');
            $("#id_personne_affecte select").attr('required', false);
            //$("#id_personne_affecte select").val('');
        }
    });

    $('.kl_daterange_iconPicker').click(function () {
        $(this).closest('.kl_date_block_large').find('input').trigger('click');
    });

    //===== Gestion form PI
    $('.date_evenenement, .date_evenenement_edition').daterangepicker(
        {
            locale: {
                format: 'DD/MM/YYYY',
                applyLabel: 'Valider',
                cancelLabel: 'Annuler'
            },
            autoUpdateInput: false,
            /*startDate: new Date(),
             endDate: new Date()*/
        }
    );

    $('.kl_suppr_date:first').hide();
    $('.kl_suppr_date_edit:first').hide();
    $('#id_add_periode').on('click', function () {

        var clone = $("[id ^='blocDateEvenement']:last").clone();
        //===== gestion titre du form
        var idLast = $("[id ^='blocDateEvenement']:last").attr('id');
        console.log(idLast);
        var idLast = idLast.split('-');
        var numNouv = parseInt(idLast[1]) + 1;

        $(clone).find('.kl_suppr_date').attr('id', "btnSupprDate-" + numNouv);
        clone.find('.kl_suppr_date').show();//=== affichage btn suppr date

        $(clone).find('.kl_suppr_date_edit').attr('id', "btnSupprDate-" + numNouv);
        $(clone).find('.kl_suppr_date_edit').show();

        var inputs = clone.find('input');
        clone.find('button').remove();

        $.each(inputs, function (index, elem) {
            var input = $(elem);
            var id = input.attr('id');
            var ids = id.split('-');
            var num = parseInt(ids[1]);
            var nouvName = "date_evenements[" + (num + 1) + "][" + ids[0] + "]";
            var nouvId = ids[0] + "-" + (num + 1);
            input.attr('id', nouvId);
            input.attr('name', nouvName);
            /*if( (nouvName == "date_evenements[" + (num + 1) + "][dateplanning]")){
             input.removeAttr('name');
             }*/

            if (nouvId === "dateevenement_id-" + (num + 1)) {
                input.remove();
            }
            input.val("");
        });

        $(clone).attr('id', "blocDateEvenement-" + (numNouv));
        clone.insertAfter('.blocDateEvenement:last');
    });

    //==== suppression date dans add
    $(document).on('click', '.kl_suppr_date', function () {
        var id = $(this).attr('id');//alert(id);
        var numDate = id.split('-')['1'];
        $("#blocDateEvenement-" + numDate).hide("blind");
        $("#blocDateEvenement-" + numDate).remove();
    });

    $(document).on('click', '.kl_suppr_date_edit', function () {
        var id = $(this).attr('id');
        console.log(id);
        var numDate = id.split('-')[1];
        var idDate = id.split('-')[2];
        $("#asuppr-" + numDate).val(idDate);
        $("#blocDateEvenement-" + numDate).hide("blind");
        $("#blocDateEvenement-" + numDate).remove();
    });

});