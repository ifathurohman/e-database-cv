var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list    = host + "users-list";
var url_edit    = host + "users-edit";
var url_delete  = host + "users-active";
var url_save    = host + "users-save";
var url_export  = host + "users-export";
var url_save_import     = host + "users-save-import";
var url_reset_device    = host + "users-reset-deviceid";
$(document).ready(function() {
    filter_table();
});

function filter_table(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    var form_filter = '#form-filter';
    Companyx    = $(form_filter+" [name=f-CompanyID]").val();
    Searchx     = $(form_filter+" [name=f-Search").val();

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
        Searchx         : Searchx,
        Companyx        : Companyx,
    }
    //datatables
    table = $('#table-list').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "destroy":true,
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
        "language": {                
            "infoFiltered": ""
        },
    });
}

function add_data(){
    $('#form')[0].reset();
    $('#form .form-control-feedback').text('');
    $('#form .has-danger').removeClass('has-danger');
    $('#form [name=crud]').val('insert');
    $('#form [name=ID]').val('');
    $('.img-profile').attr('src',img_default);
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

function action_reset_device(){
    val = $('#table-list .dt-id').eq(index_dt).data();
    reset_device(val);
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

// reset device id
function reset_device(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    data_post = {
        ID      : p1.id,
        Status  : p1.status,
        page_url        : dt_url,
        page_module     : dt_module,
    }
    
    title = "Reset Device ID";
    text  = "reset device id";
    
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
                    url : url_reset_device,
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
                swal("Canceled", "", "error");
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
                $(xform+' [name=Imei]').val(dt_value.Imei);
                $(xform+' [name=WorkDate]').val(dt_value.StartWork);
                $(xform+' [name=NameLast]').val(dt_value.NameLast);
                $(xform+' [name=Departement]').val(dt_value.Departement);
                $(xform+' [name=Nik]').val(dt_value.Nik);
                $(xform+' [name=Position]').val(dt_value.Position);
                
                $(xform+' .Role').val(dt_value.RoleID);
                $(xform+' .Role-Name').val(dt_value.RoleName);
                
                $(xform+' .Company').val(dt_value.CompanyID);
                $(xform+' .Company-Name').val(dt_value.CompanyName);
                
                $(xform+' .Pattern').val(dt_value.WorkPatternID);
                $(xform+' .Pattern-Name').val(dt_value.patternName);

                $(xform+' .Branch').val(dt_value.BranchID);
                $(xform+' .Branch-Name').val(dt_value.branchName);

                if(dt_value.ParentID){
                    $(xform+' .Parent').val(dt_value.ParentID);
                    $(xform+' .Parent-Name').val(dt_value.parentName);
                }

                if(dt_value.Image){
                    $('.img-profile').attr('src',host+dt_value.Image);
                }else{
                    $('.img-profile').attr('src',img_default);
                }

                if(dt_value.ImeiDefault == 1){
                    $(xform+' [name=default_imei]').prop('checked', true);
                }else{
                    $(xform+' [name=default_imei]').prop('checked', false);
                }

                if(dt_value.Web == 1){
                    $(xform+' [name=Website]').prop('checked', true);
                }else{
                    $(xform+' [name=Website]').prop('checked', false);
                }

                if(dt_value.Gender == 0){
                    $(xform+' #male').prop('checked', true);
                }else{
                    $(xform+' #female').prop('checked', true);
                }
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

function export_data(){
    var form_filter = '#form-filter';
    Companyx    = $(form_filter+" [name=f-CompanyID]").val();
    $.redirect(url_export,
    {
      Companyx : Companyx,
    },
    "POST","blank");
}

function import_data(p1){
    xform = '#form-import';
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');
    proccess_save();

    add_data_page(xform);
    // ajax adding data to database
    var xform        = $(xform)[0]; // You need to use standard javascript object here
    var formData    = new FormData(xform);
    formData.append('p1', p1);
    $.ajax({
        url : url_save_import,
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
                if(p1 == 'save'){
                    swal('',data.message, 'success');
                    reload_table();
                    open_form('close');
                }else{
                    result_impot(data);
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

function result_impot(data){
    xform = '#form-import';
    $(xform+' #inputFileName').val(data.inputFileName);
    $(xform+' #CompanyID').val(data.CompanyID);
    $('.v-import-result').show(300);
    if ( $.fn.DataTable.isDataTable('#table-import-result') ) {
      import_header(data.header);
      $('#table-import-result').DataTable().destroy();
    }
    $('#table-import-result thead').empty();
    $('#table-import-result tbody').empty();
    $('.import-total-succeess').empty();
    $('.import-total-failed').empty();
    $('.import-total').empty();

    import_header(data.header);

    $('html, body').animate({
        scrollTop : $('#table-import-result').offset().top - 100
    }, 1000);
    item = '';
    total_import_success = 0;
    total_import_failed  = 0;
    total_import         = 0;
    if(data.data.length>0){
        $.each(data.data,function(k,v){
            checked = ' checked ';
            bg      = ' bg-danger ';
            status  = 'Failed';
            total_import += 1;
            if(v.status){
                checked = ' checked ';
                bg      = ' bg-success ';
                status  = 'Insert';
                total_import_success += 1;
            }else{
                total_import_failed += 1;
            }

            item += '<tr class="'+bg+' wt-color">';
            item += '<td>'+v.Nik+'</td>';
            item += '<td>'+v.Name+'</td>';
            item += '<td>'+v.Gender+'</td>';
            item += '<td>'+v.Email+'</td>';
            item += '<td>'+v.WorkDate+'</td>';
            item += '<td>'+v.Iso+'</td>';
            item += '<td>'+v.Phone+'</td>';
            item += '<td>'+v.Pattern+'</td>';
            item += '<td>'+v.Parent+'</td>';
            item += '<td>'+v.Username+'</td>';
            item += '<td>'+v.Password+'</td>';
            item += '<td>'+v.Role+'</td>';
            item += '<td>'+v.ImeiDefault+'</td>';
            item += '<td>'+v.BranchID+'</td>';
            item += '<td>'+status+'</td>';
            item += '<td>'+v.Message+'</td>';
            item += '</tr>';
        });
    }else{

    }
    $('#table-import-result tbody').append(item);
    $('#table-import-result').DataTable({
        "destroy"   : true,
    });
    $('.import-total-succeess').text(total_import_success);
    $('.import-total-failed').text(total_import_failed);
    $('.import-total').text(total_import);
}