
var topOffset = 80;

var set = function () {

        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#mapCanvas").css("min-height", (height) + "px");
        }

};
$(window).ready(set);
$(window).on("resize", set);

var map;
var antenne_markers = [];
var classik_markers = [];
var spherik_markers = [];
var search_markers = [];
var marks = [];

var nbornes_antenne = document.getElementById("nbornes_antenne").value;
var nbornes_classik = document.getElementById("nbornes_classik").value;
var nbornes_spherik = document.getElementById("nbornes_spherik").value;

var antenne =[];
var classik =[];
var spherik =[];

var nombrB = 0;
var nombrC = 0;
var nombrS= 0;
var total =0;

for(var i=0; i<nbornes_antenne; i++){
    if (document.getElementById("a_lat_"+i)!= null && document.getElementById("a_lgt_"+i)!= null) {
        antenne[i] = [
            document.getElementById("a_lat_" + i).value, 
            document.getElementById("a_lgt_" + i).value,
            document.getElementById("a_name_" + i).value,
            document.getElementById("a_head_" + i).value,
            document.getElementById("a_adresse_" + i).value,
            document.getElementById("a_link_" + i).value,
            document.getElementById("a_gamme_" + i).value,
            document.getElementById("a_not_" + i).value,
            document.getElementById("a_nombre_" + i).value,
            document.getElementById("a_tot_" + i).value,
        ];
    }

}


for(var i=0; i<nbornes_classik; i++){
    if (document.getElementById("c_lat_"+i)!= null && document.getElementById("c_lgt_"+i)!= null) {
        classik[i] = [
            document.getElementById("c_lat_" + i).value, 
            document.getElementById("c_lgt_" + i).value,
            document.getElementById("c_name_" + i).value,
            document.getElementById("c_head_" + i).value,
            document.getElementById("c_adresse_" + i).value,
            document.getElementById("c_link_" + i).value,
            document.getElementById("c_gamme_" + i).value,
            document.getElementById("c_not_" + i).value,
            document.getElementById("c_nombre_" + i).value,
            document.getElementById("c_tot_" + i).value,
        ];
    }

}


for(var i=0; i<nbornes_spherik; i++){
    if (document.getElementById("s_lat_"+i)!= null && document.getElementById("s_lgt_"+i)!= null) {
        spherik[i] = [
            document.getElementById("s_lat_" + i).value, 
            document.getElementById("s_lgt_" + i).value,
            document.getElementById("s_name_" + i).value,
            document.getElementById("s_head_" + i).value,
            document.getElementById("s_adresse_" + i).value,
            document.getElementById("s_link_" + i).value,
            document.getElementById("s_gamme_" + i).value,
            document.getElementById("s_not_" + i).value,
            document.getElementById("s_nombre_" + i).value,
            document.getElementById("s_tot_" + i).value,
        ];
    }

}


var infowindow = new google.maps.InfoWindow({});

function initialize() {
    var latlng = new google.maps.LatLng(47.720348, -0.866558999999825);
    var myOptions = {
        zoom: 7,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
    addMarker(antenne,antenne_markers);
    addMarker(classik,classik_markers);
    addMarker(spherik,spherik_markers);
    
    $("#nombre_b").html(nombrB);
    $("#nombre_c").html(nombrC);
    $("#nombre_s").html(nombrS);
    $("#nombre").html(total + " bornes " + nombrB + " Antennes");
    
        // Create the search box and link it to the UI element.
        var input = document.getElementById('search_text');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          marks = [];
          
          if (places.length == 0) {
            return;
          }

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            marks.push(new google.maps.Marker({
              map: map,
              icon: " http://maps.google.com/mapfiles/marker_black.png",
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
        map.initialZoom = true;
        map.fitBounds(bounds);
        var zoom = map.getZoom();
        map.setZoom(zoom > 7 ? 7 : zoom);
        });
}

function addMarker(donnee, markres) {
    console.log(markres);
    console.log(donnee);
    for (var i = 0; i < donnee.length; i++) {
        // obtain the attribues of each marker
        var lat = parseFloat(donnee[i][0]);
        var lng = parseFloat(donnee[i][1]);
        var trailhead_name = donnee[i][2];
        var trailhead_head = donnee[i][3];
        var trailhead_adresse = donnee[i][4];
        var trailhead_link = donnee[i][5];
        var nombre = donnee[i][8];
        var not = donnee[i][7];
        total += parseFloat(donnee[i][9]);

        var myLatlng = new google.maps.LatLng(lat, lng);
        var contentString = '';
        if(nombre != ""){
                contentString = '<html><body><div><p><h4><b><a href="'+trailhead_link+'" style="color:#000">'+trailhead_head+'</a></b></h4></p><p>' + trailhead_name + '<br>' + trailhead_adresse + '</p><p>' +nombre+ '</p></div></body></html>';
        }else {
                contentString = '<html><body><div><p><h4><b><a href="'+trailhead_link+'" style="color:#000"> #' + trailhead_head + '</a></b></h4></p><p>' + trailhead_name + '<br>' + trailhead_adresse + '</p></div></body></html>';
        }

        if(not == 'B'){
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker.png')
                });
                nombrB++;
        }else if(not == 'C'){
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_green.png')
                });
                nombrC++;
        }else if(not == 'S'){
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_purple.png')
                });
                nombrS++;
        }else {
                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                    icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_black.png')
                });
        }
        
        //marker_white,marker_black,marker_brown,marker_purple,marker_orange,marker_yellow
        //http://ex-ample.blogspot.com/2011/08/all-url-of-markers-used-by-google-maps.html

        marker['infowindow'] = contentString;
        

        markres[i] = marker;

        google.maps.event.addListener(markres[i], 'click', function() {
            infowindow.setContent(this['infowindow']);
            infowindow.open(map, this);
        });
        
    }
    
    
//    $('.nombre').html("Nombre de bornes affiché: " + global_markers.length);
}

window.onload = initialize;

function markerSearch(){
    var urlBase = $("#base_url").val();
    var key = $('#search_text').val();
            
    $.ajax({
        url: urlBase + "fr/bornes/refreshList?key=" + key,
        type: "GET",
        success: function (data) {
            //console.log(data);
            $("#div_table_bornes").html(data);
            nb = $('#nbornes').val();
            markers =[];

            for(var i=0; i<nb; i++){
                if (document.getElementById("lat_"+i)!= null && document.getElementById("lgt_"+i)!= null) {
                    
                    var lat = parseFloat(document.getElementById("lat_" + i).value);
                    var lng = parseFloat(document.getElementById("lgt_" + i).value);
                    var trailhead_name = document.getElementById("name_" + i).value;
                    var trailhead_head = document.getElementById("head_" + i).value;
                    var trailhead_adresse = document.getElementById("adresse_" + i).value;
                    var trailhead_link = document.getElementById("link_" + i).value;

                    var myLatlng = new google.maps.LatLng(lat, lng);

                    var contentString = '<html><body><div><p><h4><b><a href="'+trailhead_link+'" style="color:#000"> #' + trailhead_head + '</a></b></h4></p><p>' + trailhead_name + '<br>' + trailhead_adresse + '</p></div></body></html>';

                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: "Coordinates: " + lat + " , " + lng + " | Trailhead name: " + trailhead_name,
                        icon: new google.maps.MarkerImage('http://maps.google.com/mapfiles/marker_black.png')
                    });

                    marker['infowindow'] = contentString;

                    search_markers[i] = marker;

                    google.maps.event.addListener(search_markers[i], 'click', function() {
                        infowindow.setContent(this['infowindow']);
                        infowindow.open(map, this);
                    });
                    
                }
            }
        }
    });
}

$(document).ready(function() {    
    
    
    $('#search_text').keydown(function(event) {
            if(event.which == 13){
                event.preventDefault();
                event.stopPropagation();
            }
    });
    
    document.getElementById('search').onclick = function () {
        
        // Clear out the old marks.
        marks.forEach(function(marker) {
          marker.setMap(null);
        });
        search_markers.forEach(function(marker) {
          marker.setMap(null);
        });
        
        if($.isNumeric($('#search_text').val())){
            markerSearch();
        }else {
            var input = document.getElementById('search_text');

            google.maps.event.trigger(input, 'focus', {});
            google.maps.event.trigger(input, 'keydown', { keyCode: 13 });
            google.maps.event.trigger(this, 'focus', {});
        }
    };
    
    $('#is_agence').on('change', function() {
        if($('#is_agence').prop('checked')){
            antenne_markers.forEach(function(marker) {
              marker.setMap(map);
            });
        }else {
            antenne_markers.forEach(function(marker) {
              marker.setMap(null);
            });
        }
    });
    $('#sous_loc_classik').on('change', function() {
        if($('#sous_loc_classik').prop('checked')){
            classik_markers.forEach(function(marker) {
              marker.setMap(map);
            });
        }else {
            classik_markers.forEach(function(marker) {
              marker.setMap(null);
            });
        }
    });
    $('#sous_loc_spherik').on('change', function() {
        if($('#sous_loc_spherik').prop('checked')){
            spherik_markers.forEach(function(marker) {
              marker.setMap(map);
            });
        }else {
            spherik_markers.forEach(function(marker) {
              marker.setMap(null);
            });
        }
            // $('#search_text').val("");
            //markerfilter();
    });
    
    
    $("#fullscren").on('click', function() {
        
        var elem = document.getElementById("main-wrapper");
            
        if($('#fullscren_value').val() == 0){
            
            $('.page-wrapper').addClass('hidemenu');
            $('.left-sidebar').addClass('hide');
            $("#fullscren").html('Quitter le plein écran');
            $('#fullscren_value').val(1);
            elem.requestFullscreen();
            topOffset = 1;
            
        }else {
            $('.page-wrapper').removeClass('hidemenu');
            $('.left-sidebar').removeClass('hide');
            $("#fullscren").html('Afficher en plein écran');
            $('#fullscren_value').val(0);
            document.exitFullscreen(); 
            topOffset = 80;
            
        }
        set();
    });
});
