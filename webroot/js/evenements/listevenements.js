/*var event = document.getElementById("evenement_10").value;
var evenement = JSON.parse(event);
var antenne = "" ;
var borne = "";
var client ="";
var type_event ="";
var type_animation = "" ;
if(evenement.antenne != null) antenne = evenement.antenne.ville_principale;
if(evenement.borne != null ) borne = evenement.borne.numero;
if(evenement.client != null) client = evenement.client.full_name;
if(evenement.type_evenement != null) type_event = evenement.type_evenement.nom;
if(evenement.type_animation != null) type_animation = evenement.type_animation.nom;

console.log(evenement.nom_event);
console.log(antenne);
console.log(borne);
console.log(client);
console.log(type_event);
console.log(type_animation);*/

var map;
var global_markers = [];

var nb = document.getElementById("nbevenemnts").value;
var BASE_URL = document.getElementById("id_baseUrl").value;

var markers =[];

for(var i=0; i<nb; i++){
    if (document.getElementById("lat_"+i)!= null && document.getElementById("lgt_"+i)!= null) {
        var event = document.getElementById("evenement_" + i).value;
        var evenement = JSON.parse(event);
        var antenne = "" ;
        var borne = "";
        var client ="";
        var type_client ="";
        var type_event ="";
        var type_animation = "" ;
        if(evenement.antenne != null) antenne = evenement.antenne.ville_principale;
        if(evenement.borne != null ) borne = evenement.borne.numero;
        if(evenement.client != null) { client = evenement.client.full_name; type_client = evenement.client.client_type;  };
        if(evenement.type_evenement != null) type_event = evenement.type_evenement.nom;
        if(evenement.type_animation != null) type_animation = evenement.type_animation.nom;

        markers[i] = [
            document.getElementById("lat_" + i).value,
            document.getElementById("lgt_" + i).value,
            document.getElementById("nom_" + i).value,
            antenne,
            borne,
            client,
            type_client,
            type_event,
            type_animation,
            evenement.id
        ];
    }
}


var infowindow = new google.maps.InfoWindow({});

function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(45.720348, 5.0866558999999825);
    var myOptions = {
        zoom: 5,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
    addMarker();
}

function addMarker() {
    for (var i = 0; i < markers.length; i++) {
        // obtain the attribues of each marker
        var lat = parseFloat(markers[i][0]);
        var lng = parseFloat(markers[i][1]);
        var trailhead_name = markers[i][2];
        var antenne = markers[i][3];
        var borne = markers[i][4];
        var client = markers[i][5];
        var type_client = markers[i][6];
        var type_event = markers[i][7];
        var type_animation = markers[i][8];
        var evenement_id = markers[i][9];

        var myLatlng = new google.maps.LatLng(lat, lng);

        //var contentString = "<html><body><div><p><h2>" + trailhead_name + "</h2></p></div></body></html>";
        client_types = [];
        client_types ['person'] = 'Particulier';
        client_types ['corporation'] = 'Professionnel';
        var contentString = "<div><span>" +
                "<strong><b>Evenement :</b></strong> <a href='"+ BASE_URL + "fr/evenements/edit/"+ evenement_id + "'><strong>" + trailhead_name + "</strong></a><br>" +
                "<strong><b>Client :</b> " + client + "</strong><br><strong>" + client_types[type_client] + "</strong><br>" +
                "<strong><b>Type evenement :</b> " + type_event + "</strong><br>" +
                "<strong><b>Type animation :</b> " + type_animation + "</strong><br>" +
                "<strong><b>Antenne :</b> " + antenne + "</strong>" +
            "</span></div>";

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,

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

