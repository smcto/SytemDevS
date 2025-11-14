
$(document).ready(function () {
    $(".select2").select2();
});

var BASE_URL = $('#id_baseUrl').val();
var map;
var global_markers = [];

var nb = document.getElementById("nbantennes").value;



var markers =[];

for(var i=0; i<nb; i++){
    if (document.getElementById("lat_"+i)!= null && document.getElementById("lgt_"+i)!= null) {
        markers[i] = [document.getElementById("lat_" + i).value, document.getElementById("lgt_" + i).value,
            document.getElementById("nom_" + i).value, document.getElementById("nba_" + i).value, document.getElementById("etat_" + i).value,
            document.getElementById("color_" + i).value, document.getElementById("id_" + i).value];
    }

}


var infowindow = new google.maps.InfoWindow({});

function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(47.720348, 2.3966558999999825);
    var myOptions = {
        zoom: 7,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
    addMarker();
}

function addMarker() {

    var global_markers = [];
    for (var i = 0; i < markers.length; i++) {
        // obtain the attribues of each marker
        var lat = parseFloat(markers[i][0]);
        var lng = parseFloat(markers[i][1]);
        var trailhead_name = markers[i][2];
        var nbb = markers[i][3];
        if(nbb <1 ){
            nbbs = ' Nombre de borne : 0';
        }else if(nbb == 1){
            nbbs = ' Nombre de borne : '+nbb;
        }else{
            nbbs = ' Nombre de bornes : '+nbb;
        }
        var etat = markers[i][4];
        var pinColor = markers[i][5];
        var id = markers[i][6];


        var pinImage = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
            new google.maps.Size(21, 34),
            new google.maps.Point(0,0),
            new google.maps.Point(10, 34));
        var pinShadow = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_shadow",
            new google.maps.Size(40, 37),
            new google.maps.Point(0, 0),
            new google.maps.Point(12, 35));

        var myLatlng = new google.maps.LatLng(lat, lng);

        var contentString = "<html><body><div><p><h4><a href="+BASE_URL+"fr/antennes/edit/"+id+" target='blank'>" + trailhead_name + "</a></h4> "+ nbbs +"</p><br></div></body></html>";

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
            icon: pinImage,
            shadow: pinShadow

        });

        marker['infowindow'] = contentString;

        global_markers[i] = marker;

        google.maps.event.addListener(global_markers[i], 'click', function() {
            infowindow.setContent(this['infowindow']);
            infowindow.open(map, this);
        });
    }
}

window.onload = initialize;

