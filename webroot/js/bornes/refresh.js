$(document).ready(function() {

        var BASE_URL = $('#id_baseUrl').val();
        /*setInterval(function () {
            $.ajax({
                url: BASE_URL + "fr/bornes/refreshList",
                type: "GET",
                success: function (data) {
                    //console.log(data);
                    $("#div_table_bornes").empty().html(data);
                }
            });

        }, 2000);*/

    var BASE_URL = $('#id_baseUrl').val();
    setInterval(function () {
        $.ajax({
            url: BASE_URL + "fr/StripeCsvFiles/refreshList",
            type: "GET",
            success: function (data) {
                // console.log(data);
                $("#div_table_file_csv").empty().html(data);
            }
        });

    }, 2000);
});