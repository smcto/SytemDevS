$(document).ready(function() {
    
    $(".select2").select2({
        allowClear: true
    });

    var base_url = $('#id_baseUrl').val();

    $('select#gamme_borne_id').on('change', function(event) {
        event.preventDefault();
        gamme_borne_id = $(this).val();

        urlLoadModelBorneByGamme = base_url+'/fr/ajax-ventes/loadModelBorneByGamme/'+gamme_borne_id+'.json';
        model_borne = $('select#model_borne_id');
        model_borne.html('');


        $.get(urlLoadModelBorneByGamme, function(data) {
            var option = new Option( 'Séléctionner un modèle', "", true, true);
            model_borne.append(option);
            
            $.each(data, function (clef, valeur) {
                var option = new Option(valeur, clef, false, false);
                model_borne.append(option);
            });
            model_borne.prop('disabled', false);
        });
    });

    $('.expand-filters').click(function() {
        $('div.optional-filter').toggleClass('d-none');
        if($('div.optional-filter').hasClass('d-none') == true) {
            $('.input_more_filter').val(0)
            $('.expand-filters').html('<u>+ de filtres</u>');
            $('.filter-2').removeClass('col-md-3');
        } else {
            $('.input_more_filter').val(1);
            $('.expand-filters').html('<u>- de filtres</u>');
            $('.filter-2').addClass('col-md-3');
        }
    });

    if ($('.input_more_filter').val() == 1) {
        $('div.optional-filter').toggleClass('d-none');
    }
});


var map;
var global_markers = [];

var nb = document.getElementById("nbornes").value;

var markers =[];

for(var i=0; i<nb; i++){
    if (document.getElementById("lat_"+i)!= null && document.getElementById("lgt_"+i)!= null) {
        markers[i] = [
            document.getElementById("lat_" + i).value, 
            document.getElementById("lgt_" + i).value,
            document.getElementById("name_" + i).value,
            document.getElementById("head_" + i).value,
            document.getElementById("adresse_" + i).value,
            document.getElementById("link_" + i).value,
            document.getElementById("gamme_" + i).value,
            document.getElementById("loc_" + i).value,
            document.getElementById("type_" + i).value,
            document.getElementById("nombre_" + i).value
        ];
    }

}


var infowindow = new google.maps.InfoWindow({});

function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(47.720348, 2.4566525);
    var myOptions = {
        zoom: 6,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
    addMarker();
}

function addMarker() {
    console.log(markers.length);
    for (var i = 0; i < markers.length; i++) {
        // obtain the attribues of each marker
        console.log(trailhead_name);
        var lat = parseFloat(markers[i][0]);
        var lng = parseFloat(markers[i][1]);
        var trailhead_name = markers[i][2];
        var trailhead_head = markers[i][3];
        var trailhead_adresse = markers[i][4];
        var trailhead_link = markers[i][5];
        var gamme = markers[i][6];
        var loc = markers[i][7];
        var parc = markers[i][8];
        var nombre = markers[i][9];

        var myLatlng = new google.maps.LatLng(lat, lng);

        var contentString   = '<html><body>';
              contentString +=  '<div>';
              contentString +=  '<h6><b><a href="'+trailhead_link+'" style="color:#000">' + trailhead_head + '</a></b></h6>';
              contentString +=  '<p style="font-weight: bold">' + trailhead_name + '</p><p>' + trailhead_adresse + '</p>';
              if(loc){
                    contentString +=  '<p>' + parc + '<br>' + loc + '</p>';
              }
              if(nombre != ""){
                    contentString +=  '<p>' + nombre + '</p>';
              }
              contentString +=  '</div>';
              contentString +=  '</body></html>';

        if(gamme == 2){
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker.png')
                });
        }else if(gamme == 3){
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_green.png')
                });
        }else if(gamme == 5){
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_purple.png')
                });
        }else if(gamme == "A"){
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_yellow.png')
                });
        }else {
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_grey.png')
                });
        }
        
        //marker_white,marker_black,marker_brown,marker_purple,marker_orange,marker_yellow
        //http://ex-ample.blogspot.com/2011/08/all-url-of-markers-used-by-google-maps.html

        marker['infowindow'] = contentString;

        global_markers[i] = marker;

        google.maps.event.addListener(global_markers[i], 'click', function() {
            infowindow.setContent(this['infowindow']);
            infowindow.open(map, this);
        });
    }
    
//    $('.nombre').html("Nombre de bornes affiché: " + global_markers.length);
}

window.onload = initialize;

