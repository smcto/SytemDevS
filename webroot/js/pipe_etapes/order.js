$(document).ready(function () {

    var BASE_URL = $('#id_baseUrl').val();

    $('.kl_table').tableDnD({
        onDrop: function (table, row) {
            //alert(table.rows);
            var rows = [];
            $.each(table.rows, function (index, elem) {
                var tr = $(elem);
                var id = tr.attr('id');
                rows[index] = id;
                //console.log(tr);
            });
            rows.shift();
            console.log(rows);
            //console.log(rows.length);
            var BASE_URL = $('#id_baseUrl').val();
            $.ajax({
                url: BASE_URL + "fr/pipeEtapes/getOrdre",
                type: "POST",
                data: {'new_list': rows},
                success: function (data) {
                    //console.log(data);
                    $("#div_content_table").empty().html(data);
                    //window.location.href = BASE_URL + "categories";
                }
            });
        }
    });


});