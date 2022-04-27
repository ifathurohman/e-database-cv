// MASTER COMPANY

var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list    = host + "company-list";
var url_edit    = host + "company-edit";
var url_delete  = host + "company-active";
var url_save    = host + "company-save";
$(document).ready(function() {
    filter_table();
    $("#Radius").change(function(){
        set_radius();
    });
});

function filter_table(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
    }
    //datatables
    table = $('#table-list').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url"   : url_list,
            "data"  : data_post,
            "type"  : "POST",
            dataSrc : function (json) {
              return json.data;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [], //last column
            "orderable": false, //set not orderable
        },
        ],
    });
}

function add_data(){
    $('#form')[0].reset();
    $('#form .form-control-feedback').text('');
    $('#form .has-danger').removeClass('has-danger');
    $('#form [name=crud]').val('insert');
    $('#form [name=ID]').val('');
    $('.img-profile').attr('src',img_default);
    resizeMap();
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

var pressTimer;
var countUp = 0;
var dt_val;
// $("#table-list tbody").on('mouseup','tr',function(){
//  if(countUp <=0){
//      val = $(this).children('td').children('.dt-id').data();
//      short_click(val);
//  }
//  countUp = 0;
//      clearTimeout(pressTimer);
//      return false;
//   }).mousedown(function(e){
//      // Set timeout
//     e = e.target;
//     dt_val = $(e).closest('tr').find('.dt-id').data();
//      pressTimer = window.setTimeout(function() {
//         long_click(dt_val);
//     },time_long_click);
//      return false; 
// });

$(document).on('click',function(){
    $('.action_list').removeClass('active');
})

var index_dt;
$("#table-list tbody").on('click','tr',function(event){
    index_dt = $(this).index();
    $('.action_list').removeClass('active');
    $('#table-list tbody tr td .action_list').eq(index_dt).addClass("active");
    event.stopPropagation();
});

function action_edit(){
    val = $('#table-list .dt-id').eq(index_dt).data();
    short_click(val);
}

function action_delete(){
    val = $('#table-list .dt-id').eq(index_dt).data();
    long_click(val);
}

// delete data
function long_click(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    data_post = {
        ID      : p1.id,
        Status  : p1.status,
        page_url        : dt_url,
        page_module     : dt_module,
    }
    if(p1.status == 1){
        title = "Nonactive Data";
        text  = "nonactive";
    }else{
        title = "Active Data";
        text  = "active";
    }
    swal({   title: title,   
        text: "Are you sure want to "+text+"?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "OK",   
        cancelButtonText: "Cancel",   
        closeOnConfirm: false,   
        closeOnCancel: false }, 
        function(isConfirm){   
            if (isConfirm) { 
                $.ajax({
                    url : url_delete,
                    type: "POST",
                    data: data_post,
                    dataType: "JSON",
                    success: function(data)
                    {
                        show_console(data);
                        if(data.status){
                            swal('',data.message, 'success');
                            reload_table();
                        }else{
                            show_invalid_response(data);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal('Error deleting data');
                        console.log(jqXHR.responseText);
                    }
                });
            } 
            else {
                swal("Canceled", "Your data is safe", "error");
            } 
        }
    );
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
        url : url_save,
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
                reload_table();
                if(p1 == "save_new"){
                    add_data();
                }else{
                    open_form('close');
                }
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

function short_click(p1){
    open_form('edit',p1.id);
}

function edit_data(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    xform = '#form';
    $(xform)[0].reset();
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    data_post = {
        ID : p1,
        page_url        : dt_url,
        page_module     : dt_module,
    }
    $.ajax({
        url : url_edit,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            if(data.status){
                dt_value = data.data;
                $(xform+' [name=crud]').val('update');
                $(xform+' [name=ID]').val(p1);
                $(xform+' [name=Name]').val(dt_value.Name);
                $(xform+' [name=Username]').val(dt_value.Username);
                $(xform+' [name=Email]').val(dt_value.Email);
                $(xform+' [name=Phone]').val(dt_value.Phone);
                $(xform+' [name=LocationName]').val(dt_value.LocationName);
                $(xform+' [name=Address]').val(dt_value.Address);
                $(xform+' [name=Latitude]').val(dt_value.Latitude);
                $(xform+' [name=Longidute]').val(dt_value.Longitude);
                $(xform+' [name=Radius]').val(dt_value.Radius);
                $(xform+' [name=StartJoin]').val(dt_value.DateJoin);
                $(xform+' [name=StartWorkDate]').val(dt_value.StartWorkDate);
                $(xform+' .Role').val(dt_value.RoleID);
                $(xform+' .Role-Name').val(dt_value.RoleName);
                if(dt_value.Image){
                    $('.img-profile').attr('src',host+dt_value.Image);
                }else{
                    $('.img-profile').attr('src',img_default);
                }
                resizeMap(dt_value.Latitude,dt_value.Longitude);
                set_radius();
            }else{
                open_form('close');
                show_invalid_response(data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
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
var infowindow;
var cityCircle;
var radius_val = 0;
$(document).ready(function() { 
    myCenter    = new google.maps.LatLng(20, -10);
    infowindow  = new google.maps.InfoWindow;
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
    map.addListener('click', function(event) {
        if(save_method != "view"){
            myCenter = event.latLng; 
            addMarker(myCenter);
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

    geocoder = new google.maps.Geocoder(); // creating a new geocode object
    autocomplete_place();
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
      draggable : false

    });
    cityCircle = new google.maps.Circle({
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: '#FF0000',
        fillOpacity: 0.35,
        map: map,
        center: location,
        radius: radius_val
    });
    markers.push(marker);
    setMarkerinput(location);
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

function set_radius()
{
    radius_val = $("#Radius").val();
    radius_val    = parseInt(radius_val);
    cityCircle.setRadius(radius_val);
}