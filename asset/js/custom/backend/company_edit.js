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
var infowindow;
$(document).ready(function() { 
    myCenter    = new google.maps.LatLng(20, -10);
    marker      = new google.maps.Marker({
        position:myCenter
    });
    google.maps.event.addDomListener(window, 'load', initialize());
    google.maps.event.addDomListener(window, "resize", resizingMap());

    $("#Radius").change(function(){
        set_radius();
    });
});

function initialize() {
    var mapProp = {
        center:myCenter,
        zoom: zoom,
        // mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("MAPS"),mapProp);
    infowindow  = new google.maps.InfoWindow;
    geocoder = new google.maps.Geocoder(); // creating a new geocode object
    autocomplete_place();

    map.addListener('click', function(event) {
        if(save_method != "view"){
            myCenter = event.latLng; 
            addMarker(myCenter);
            setMarkerinput(myCenter);
        }
    });

    cityCircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: myCenter,
        radius: radius_val,
    });

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
        addMarker(myCenter);
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
        addMarker(myCenter);
    }
}

function addMarker(location) {
    deleteMarkers();
    cityCircle.setMap(null);
    var marker = new google.maps.Marker({
      position: location,
      map: map,
      animation : google.maps.Animation.DROP,
      draggable : false,

    });
    cityCircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: location,
        radius: radius_val,
    });
    set_radius();
    markers.push(marker);
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
function set_radius()
{
    radius_val = $("#Radius").val();
    radius_val    = parseInt(radius_val);
    cityCircle.setRadius(radius_val);
}

function autocomplete_place(){
    var input         = (document.getElementById('Address'));
    var autocomplete  = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        // If the place has a geometry, then present it on a map.
        map.setCenter(place.geometry.location);
        map.setZoom(15); // Why 17? Because it looks good.
        addMarker(place.geometry.location);
        var address = '';
        var country_txt = '', province_txt = '', city_txt = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');

            $.each(place.address_components, function(k,v){
                if(v.types[0] == 'country'){
                    country_txt = v.long_name;
                }else if(v.types[0] == 'administrative_area_level_1'){
                    province_txt = v.long_name;
                }else if(v.types[0] == 'administrative_area_level_2'){
                    city_txt = v.long_name;
                }
            })
        }
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        $('#City').val(city_txt);
        $('#Province').val(province_txt);
        $('#Country').val(country_txt);
        // map.getUiSettings().setMyLocationButtonEnabled(true);
    });
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

function save(p1){
    xform = '#form';
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');
    proccess_save();

    add_data_page(xform);
    // ajax adding data to database
    var xform        = $(xform)[0]; // You need to use standard javascript object here
    var formData    = new FormData(xform);

    $.ajax({
        url : host+"company-edit-save",
        type: "POST",
        data: formData,
        dataType: "JSON",
        mimeType:"multipart/form-data", // upload
        contentType: false, // upload
        cache: false, // upload
        processData:false, //upload
        success: function(data)
        {
            show_console(data);
            if(data.status) //if success close modal and reload ajax table
            {   
                swal('',data.message,'success');
            }
            else
            {
                show_invalid_response(data);
            }
            end_save();
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
            end_save();
        }
    });
}

$('.custom-file-input').change(function(){
    readFile(this);
});
var class_file;
function readFile(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();
        tg_data = $(input).data();
        class_file = tg_data.id;
        reader.onload = function(e){
            show_console(e);
            $('.'+class_file).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}