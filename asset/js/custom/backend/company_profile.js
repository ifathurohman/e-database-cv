var map;
var markers = [];
var lat;
var lng;
var zoom;
var myCenter;
var marker;
var zoom = 2;
var statusmap;
var geocoder;
var cityCircle;
var radius_val = 0;
var infowindow = null;
$(document).ready(function() { 
    myCenter    = new google.maps.LatLng(20, -10);
    marker      = new google.maps.Marker({
        position:myCenter
    });
    google.maps.event.addDomListener(window, 'load', initialize());
    google.maps.event.addDomListener(window, "resize", resizingMap());
});

function initialize() {
    var mapProp = {
        center:myCenter,
        zoom: zoom,
        // mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("MAPS"),mapProp);
    geocoder = new google.maps.Geocoder(); // creating a new geocode object

    cityCircle = new google.maps.Circle();

    page_data   = $(".page-data").data();
    dt_lat      = page_data.lat;
    dt_lng      = page_data.lng;
    radius_val  = page_data.radius;
    resizeMap(dt_lat,dt_lng);
}

function resizeMap(lat="",lng="") {
   if(typeof map =="undefined") return;
   setTimeout( function(){
        resizingMap(lat,lng);
    } , 400);
}

function resizingMap(lat="",lng="") {
    if(typeof map =="undefined") return;
    statusmap = false;
    if(lat != "" && lng != ""){
        deleteMarkers();

        myCenter = new google.maps.LatLng(lat, lng);
        // addMarker(myCenter);
        statusmap   = true;
        center      = myCenter;
        zoom        = 12;
    } else {
        deleteMarkers();
        zoom        = 10;
        lat = -6.210089;
        lng = 106.844917;
        myCenter    = new google.maps.LatLng(lat, lng);
        center      = myCenter;
    }

    google.maps.event.trigger(map, "resize");
    map.setCenter(center); 
    map.setZoom(zoom); 
    if(statusmap){
        // addMarker(myCenter);

        dt_length = $('.dt_branch').length;
        
        var bounds  = new google.maps.LatLngBounds();
        infowindow  = new google.maps.InfoWindow(); /* SINGLE */

        for(i=0; i<dt_length; i++){
            dt_branch = $('.dt_branch').eq(i).data();

            myCenter = new google.maps.LatLng(dt_branch.lat, dt_branch.lng);
            bounds.extend(myCenter);
            statusmap   = true;
            center      = myCenter;
            zoom        = 12;
            addMarker(myCenter, dt_branch);
        }
        map.fitBounds(bounds);
    }
}

function addMarker(location,p1) {
    // deleteMarkers();
    cityCircle = new google.maps.Circle();
    var color  = getColor(p1.no);
    var marker = new google.maps.Marker({
      position: location,
      map: map,
      animation : google.maps.Animation.DROP,
      draggable : false,
      icon : getIcon(null, color, '000', '000'),

    });

    google.maps.event.addListener(marker, 'click', function(){
        WindowContent = "<div id='infowindow'>";
        WindowContent += '<b>'+p1.name+'</b>';
        WindowContent += "<br/> Phone Number : " + p1.phone;
        WindowContent += "<br/>" + p1.address;
        WindowContent += "</div>";

        infowindow.close(); // Close previously opened infowindow
        infowindow.setContent(WindowContent);
        infowindow.open(map, marker);
    });

    cityCircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: location,
        radius: p1.radius
    });
    set_radius(p1.radius);
    markers.push(marker);
}

function getColor(p1){
    val = 'FF0000';

    if(p1>5){
        p1 = Math.floor(Math.random() * 6);
    }

    if(p1 == 0){ val = 'fb9678'; }
    if(p1 == 1){ val = '00c292'; }
    if(p1 == 2){ val = 'e46a76'; }
    if(p1 == 3){ val = '03a9f3'; }
    if(p1 == 4){ val = 'ab8ce4'; }
    if(p1 == 5){ val = '01c0c8'; }

    return val;
}

function getIcon(text, fillColor, textColor, outlineColor) {
  if (!text) text = '•'; //generic map dot
  var iconUrl = "http://chart.googleapis.com/chart?cht=d&chdp=mapsapi&chl=pin%27i\\%27[" + text + "%27-2%27f\\hv%27a\\]h\\]o\\" + fillColor + "%27fC\\" + textColor + "%27tC\\" + outlineColor + "%27eC\\Lauto%27f\\&ext=.png";
  return iconUrl;
}

function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
    }
}
function clearMarkers() {
    setMapOnAll(null);
}
function deleteMarkers() {
    clearMarkers();
    markers = [];
}
function setMarkerinput(location) {
    $("#Latitude").val(location.lat());
    $("#Longidute").val(location.lng());
}
function set_radius(p1)
{
    cityCircle.setRadius(p1);
}

function edit_data(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
    }

    $.redirect(host+'company-profile-edit',data_post,"POST");
}