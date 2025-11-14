var setChartVenteGamme = function () {

        var height = document.getElementById("legende_vente_gamme").offsetHeight;
        var width = document.getElementById("box_vente_gamme").offsetWidth;
        height = 293-height;
        $("#chart_vente_gamme").css("height", (height) + "px");
        $("#chart_vente_gamme").css("width", (height*2) + "px");
        if(width <  height*2){
            $("#chart_vente_gamme").css("margin-left", (-(height*2 - width)/2) + "px");
        }

};
$(window).ready(setChartVenteGamme);

var setChartVenteParc = function () {

        var height = document.getElementById("legende_vente").offsetHeight;
        var width = document.getElementById("box_vente_parc").offsetWidth;
        height = 293-height;
        $("#chart_vente").css("height", (height) + "px");
        $("#chart_vente").css("width", (height*2) + "px");
        if(width <  height*2){
            $("#chart_vente").css("margin-left", (-(height*2 - width)/2) + "px");
        }

};
$(window).ready(setChartVenteParc);

var setChartVenteTypeCons = function () {

        var height = document.getElementById("legende_vente_cons").offsetHeight;
        var width = document.getElementById("box_vente_cons").offsetWidth;
        height = 328-height;
        $("#chart_vente_cons").css("height", (height) + "px");
        $("#chart_vente_cons").css("width", (height*2) + "px");
        if(width <  height*2){
            $("#chart_vente_cons").css("margin-left", (-(height*2 - width)/2) + "px");
        }

};
$(window).ready(setChartVenteTypeCons);



$(document).ready(function () {
    
    $('.select2').select2();

var ctx = document.getElementById('canvas_chart_vente').getContext('2d');
window.myDoughnut = new Chart(ctx, {
        type: 'doughnut',
        data: dataParcs,
        options: {
                responsive: true,
                legend: {
                        display: false,
                },
                animation: {
                        animateScale: true,
                        animateRotate: true
                },
                cutoutPercentage: 80,
                rotation:89
        }
});

var ctx = document.getElementById('canvas_chart_vente_month').getContext('2d');
window.myBar = new Chart(ctx, {
        type: 'bar',
        data: dataParcByMonth,
        options: {
                tooltips: {
                        mode: 'index',
                        intersect: false
                },
                responsive: true,
                scales: {
                        xAxes: [{
                                stacked: true
                        }],
                        yAxes: [{
                                stacked: true
                        }]
                },legend: {
                    display: true,
                    position:'bottom'
                }
        }
});

var ctx = document.getElementById('canvas_chart_vente_gamme').getContext('2d');
window.myDoughnut = new Chart(ctx, {
        type: 'doughnut',
        data: dataGammes,
        options: {
                responsive: true,
                legend: {
                        display: false,
                },
                animation: {
                        animateScale: true,
                        animateRotate: true
                },
                cutoutPercentage: 80,
                rotation:89
        }
});

var ctx = document.getElementById('canvas_chart_vente_gamme_month').getContext('2d');
window.myBar = new Chart(ctx, {
        type: 'bar',
        data: dataGammeByMonth,
        options: {
                tooltips: {
                        mode: 'index',
                        intersect: false
                },
                responsive: true,
                scales: {
                        xAxes: [{
                                stacked: true
                        }],
                        yAxes: [{
                                stacked: true
                        }]
                },legend: {
                    display: true,
                    position:'bottom'
                }
        }
});


var ctx = document.getElementById('canvas_chart_vente_cons').getContext('2d');
window.myDoughnut = new Chart(ctx, {
        type: 'doughnut',
        data: dataTypeCons,
        options: {
                responsive: true,
                legend: {
                        display: false,
                },
                animation: {
                        animateScale: true,
                        animateRotate: true
                },
                cutoutPercentage: 80,
                rotation:89
        }
});


var ctx = document.getElementById('canvas_chart_vente_client_month').getContext('2d');
window.myBar = new Chart(ctx, {
        type: 'bar',
        data: dataClientByMonth,
        options: {
                tooltips: {
                        mode: 'index',
                        intersect: false
                },
                responsive: true,
                aspectRatio: 0.9,
                scales: {
                        xAxes: [{
                                stacked: true
                        }],
                        yAxes: [{
                                stacked: true
                        }]
                },legend: {
                    display: true,
                    position:'bottom'
                }
        }
});

    $('#type').on('change', function(){
        var type = $(this).val();
        if(type == 'mensuel') {
            $('.mois').removeClass('d-none');
            $('#mois').prop('required',true);
            $('.annees').removeClass('d-none');
            $('#annees').prop('required',true);
            $('.periode').addClass('d-none');
            $('#periode').prop('required',false);
        }else if(type == 'annuel') {
            $('.annees').removeClass('d-none');
            $('#annees').prop('required',true);
            $('.mois').addClass('d-none');
            $('#mois').prop('required',false);
            $('.periode').addClass('d-none');
            $('#periode').prop('required',false);
        }else if(type == 'periode') {
            $('.mois').addClass('d-none');
            $('#mois').prop('required',false);
            $('.annees').addClass('d-none');
            $('#annees').prop('required',false);
            $('.periode').removeClass('d-none');
            $('#periode').prop('required',true);
        }else {
            $('.mois').addClass('d-none');
            $('#mois').prop('required',false);
            $('.annees').addClass('d-none');
            $('#annees').prop('required',false);
            $('.periode').removeClass('d-none');
            $('#periode').prop('required',false);
        }
        
    });
    
    $('#show_period').on('click',function(){
        if($('.filter').hasClass('d-none')){
            $('.filter').removeClass('d-none');
        }else{
            $('.filter').addClass('d-none');
        }
    });


});
