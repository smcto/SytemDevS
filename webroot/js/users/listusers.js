var BASE_URL = $('#id_baseUrl').val();
var map;
var global_markers = [];

var nb = document.getElementById("nbusers").value;

var markers =[];

for(var i=0; i<nb; i++){
    if (document.getElementById("lat_"+i)!= null && document.getElementById("lgt_"+i)!= null) {
        markers[i] = [document.getElementById("lat_" + i).value, document.getElementById("lgt_" + i).value,
            document.getElementById("nom_" + i).value, document.getElementById("id_" + i).value, document.getElementById("img_" + i).value];
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
        var id = markers[i][3];
        var img = markers[i][4];



        var myLatlng = new google.maps.LatLng(lat, lng);

        var contentString = "<html><body><div><p><h4><a href="+BASE_URL+"fr/users/view/"+id+" target='blank'>" + trailhead_name + "</a></h4><br><img src="+img+" width='100px' /></p></div></body></html>";

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,

        });

        marker.setIcon("https://cdn3.iconfinder.com/data/icons/musthave/24/Stock%20Index%20Down.png");

        marker['infowindow'] = contentString;

        global_markers[i] = marker;

        google.maps.event.addListener(global_markers[i], 'click', function() {
            infowindow.setContent(this['infowindow']);
            infowindow.open(map, this);
        });
    }
}

window.onload = initialize;

