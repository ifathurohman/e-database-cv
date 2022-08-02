var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list    = host + "role-list";
var url_edit    = host + "role-edit";
var url_delete  = host + "role-active";
var url_save    = host + "role-save";
var url_menu    = host + "api/menu";
$(document).ready(function() {
    filter_table();
    get_menu();
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
}

function reload_table(){
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

    // ajax adding data to database
    add_data_page(xform);
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
                $(xform+' [name=Remark]').val(dt_value.Remark);
                $(xform+' [name=Type]').val(dt_value.Labels);
                if(dt_value.Level){
                    $(xform+' [name=Level]').val(dt_value.Level);
                }
                var arrView     = $.parseJSON(dt_value.View);
                var arrInsert   = $.parseJSON(dt_value.Insert);
                var arrUpdate   = $.parseJSON(dt_value.Update);
                var arrDelete   = $.parseJSON(dt_value.Delete);
                $.each(arrView,function(k,v){
                    $('#v-'+v).prop('checked', true);
                });
                $.each(arrInsert,function(k,v){
                    $('#c-'+v).prop('checked', true);
                });
                $.each(arrUpdate,function(k,v){
                    $('#u-'+v).prop('checked', true);
                });
                $.each(arrDelete,function(k,v){
                    $('#d-'+v).prop('checked', true);
                });
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

function get_menu(){
    data_post = {
        p1      : "role-setting",
        select  : "active",
        Type    : "backend",
    };

    $.ajax({
        url : url_menu,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            if(data.status){
                set_menu(data.list);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error System');
            console.log(jqXHR.responseText);
        }
    });
}

function set_menu(dt_value){
    $('.ul-menu').empty();
    $('.ul-menu-dt').empty();
    item_menu       = '';
    index_menu      = 0;
    arrMenu         = [];
    $.each(dt_value,function(k,v){
        if(v.Level == 1){
            activeTxt   = '';
            iconTxt     = '';
            if(!index_menu){
                activeTxt  = ' active ';
                index_menu = v.ID;
            }
            if(v.Icon){
                iconTxt = '<i class="'+v.Icon+'"></i>';
            }
            item_menu += 
            '<li class="nav-item">\
                <a class="nav-link '+activeTxt+'" data-toggle="tab" href="#h-'+v.ID+'" role="tab">\
                    <span class="hidden-sm-up">'+iconTxt+'</span>\
                    <span class="hidden-xs-down">'+v.Name+'</span> \
                </a>\
            </li>';
            arrMenu.push(v.ID);
        }
    });
    $('.ul-menu').append(item_menu);

    $.each(arrMenu,function(k,v){
        item_menu_dt    = '';
        activeTxt       = '';
        if(index_menu == v){
            activeTxt = 'active';
        };
        $.each(dt_value,function(k2,v2){
            if(v2.ParentID == v){
                str_name = v2.Name;
                str_name = str_name.toLowerCase();
                n = str_name.search("report");
                str_class = '';
                if(n != -1){
                    str_class = ' content-hide ';
                }
                item_menu_dt += 
                '<div class="row border-gray-bottom">\
                    <div class="col-sm-3">\
                        <div class="custom-control custom-checkbox">\
                            <input type="checkbox" class="custom-control-input" name="View[]" value="'+v2.ID+'" id="v-'+v2.ID+'">\
                            <label class="custom-control-label pointer" for="v-'+v2.ID+'">'+v2.Name+'</label>\
                        </div>\
                    </div>\
                    <div class="col-sm-3 '+str_class+'">\
                        <div class="custom-control custom-checkbox">\
                            <input type="checkbox" class="custom-control-input" name="Insert[]" value="'+v2.ID+'" id="c-'+v2.ID+'">\
                            <label class="custom-control-label pointer" for="c-'+v2.ID+'">Create</label>\
                        </div>\
                    </div>\
                    <div class="col-sm-3 '+str_class+'">\
                        <div class="custom-control custom-checkbox">\
                            <input type="checkbox" class="custom-control-input" name="Update[]" value="'+v2.ID+'" id="u-'+v2.ID+'">\
                            <label class="custom-control-label pointer" for="u-'+v2.ID+'">Update</label>\
                        </div>\
                    </div>\
                    <div class="col-sm-3 '+str_class+'">\
                        <div class="custom-control custom-checkbox">\
                            <input type="checkbox" class="custom-control-input" name="Delete[]" value="'+v2.ID+'" id="d-'+v2.ID+'">\
                            <label class="custom-control-label pointer" for="d-'+v2.ID+'">Delete</label>\
                        </div>\
                    </div>\
                </div>';
            }
        });

        item = 
        '<div class="tab-pane '+activeTxt+'" id="h-'+v+'" role="tabpanel">\
            '+item_menu_dt+'\
        </div>';
        $('.ul-menu-dt').append(item);
    })
}