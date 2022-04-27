var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list    = host + "menu-list";
var url_edit    = host + "menu-edit";
var url_delete  = host + "menu-delete";
var url_save    = host + "menu-save";
$(document).ready(function() {
    filter_table();
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
        "searching": true,
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
    $('#form .select2-has-danger').removeClass('select2-has-danger');
    $('#form [name=crud]').val('insert');
    $('#form [name=ID]').val('');
    check_level(1);
}

function check_level(p1){
    if(p1 == 1){
        $('.Parent-view').hide(300);
    }else{
        $('.Parent-view').show(300);
    }
}

$('#Level').on('change', function(){
    value = this.value;
    check_level(value);
});

function save(p1){
    xform = '#form';
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');
    proccess_save();

    add_data_page(xform);
    // ajax adding data to database
    $.ajax({
        url : url_save,
        type: "POST",
        data: $(xform).serialize(),
        dataType: "JSON",
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
//         long_click(dt_val)
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
        ID : p1.id,
        page_url        : dt_url,
        page_module     : dt_module,
    }
    swal({   title: "Delete Data",   
        text: "Are you sure want to delete?",   
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

// edit data
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
                $(xform+' #Name').val(dt_value.Name);
                $(xform+' #Url').val(dt_value.Url);
                $(xform+' #Root').val(dt_value.Root);
                $(xform+' #Level').val(dt_value.Level);
                $(xform+' #Icon').val(dt_value.Icon);
                if(data.backend){
                    $(xform+' #type_backend').prop('checked', true);
                }
                if(data.frontend){
                    $(xform+' #type_frontend').prop('checked', true);
                }
                if(dt_value.Role == 1){
                    $(xform+' #Role').prop('checked', true);
                }
                if(dt_value.ParentID){
                    var newopt = new Option(dt_value.parentName,dt_value.ParentID,false,false);
                    $('#Parent').append(newopt).trigger('change');
                    $('#Parent').val(dt_value.ParentID).trigger('change');
                }else{
                    var newopt = new Option("Select Parent",0,false,false);
                    $('#Parent').append(newopt).trigger('change');
                    $('#Parent').val(0).trigger('change');
                }
                check_level(dt_value.Level);
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

$('.menu_parent').select2({
    ajax:{
        url         : host+"api/menu",
        dataType    : "json",
        delay       : 250,
        type        : "POST",
        allowClear  : true,
        data : function(params){
            Level = $('#Level option:selected').val();
            return {
                p1     : "Select",
                Name   : params.term,
                Level  : Level,
            };
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log(jqXHR.responseText);
        },
        processResults : function(data){
            show_console(data);
            var list = [];

            $.each(data.list,function(k,v){
                list.push({
                    id      : v.ID,
                    text    : v.Name,
                });
            });

            return {results : list}
        }
    }
});