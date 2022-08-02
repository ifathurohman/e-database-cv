var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list        = host + "output_proyek-list";
var url_edit        = host + "output_proyek-edit";
var url_delete      = host + "output_proyek-active";
var url_save        = host + "output_proyek-save";
var url_export      = host + "output_proyek-export";
var url_save_import = host + "output_proyek-save-import";
$(document).ready(function() {
    filter_table();
    $("#v-form").hide();
    $("#form").hide();
});

function filter_table(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    var form_filter = '#form-filter';
    // Companyx    = $(form_filter+" [name=f-CompanyID]").val();
    Searchx     = $(form_filter+" [name=f-Search").val();

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
        Searchx         : Searchx,
        // Companyx        : Companyx,
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
    $("#v-list").hide();
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

function action_view(){
    save_method = 'view';
    val = $('#table-list .dt-id').eq(index_dt).data();
    open_form('edit',val.id);
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
reset_file_upload();
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
                swal({
                    title:'Berhasil',
            		text:data.message,
            		type:'success',
            		icon:'success',
            		confirmButtonText: 'OK',
            		showCancelButton: false,
            	}, function () {
                    reload_table();
                    location.reload();
                    window.scrollTo(0, 0);
                    if(ck_count_save_file()>0){
                        upload_attachment_file(data.ID);
                    }
            	});
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

function validateForm(form)
{
    console.log("checkbox checked is ", form.agree.checked);
    if(!form.agree.checked)
    {
        document.getElementById('agree_chk_error').style.visibility='visible';
        return false;
    }
    else
    {
        document.getElementById('agree_chk_error').style.visibility='hidden';
        return true;
    }
}

function short_click(p1){
    open_form('edit',p1.id);
}

function batal() {
    location.reload();
    reload_table();
    window.scrollTo(0, 0);
}

function edit_data(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    xform = '#form';
    $(xform)[0].reset();
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');

    $("#v-form").show();
    $("#form").show();

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

            id_form  = '<h4 class="id-form v-form data-ID" data-id='+data.data.ID+'>ID FORM #'+data.data.ID+'</h4>';
            $('.id_form').append(id_form);

            if(save_method == 'view'){
                xform = '#form';
                $(xform+' .form-control-feedback').text('');
                $(xform+' .has-danger').removeClass('has-danger');
                dt_value = data.data;
                $(xform+' [name=crud]').val('update');
                $(xform+' [name=ID]').val(p1);
                $(xform+' [name=Nama_kegiatan]').val(dt_value.Nama_kegiatan);
                $(xform+' [name=Pengguna_jasa]').val(dt_value.Pengguna_jasa);
                $(xform+' [name=Tanggal_tender]').val(dt_value.Tanggal_tender);
                $('.form-view input').attr('disabled', true);
                $('.form-view input').attr('readonly', true);
                $('.form-view').removeClass('content-hide');
                $(".btn-simpan").hide();
                $.each(data.attach,function(i,v){
                    set_file(v,1,"view");
                })        
            }else{
                if(data.status){
                    dt_value = data.data;
                    $(xform+' [name=crud]').val('update');
                    $(xform+' [name=ID]').val(p1);
                    $(xform+' [name=Nama_kegiatan]').val(dt_value.Nama_kegiatan);
                    $(xform+' [name=Pengguna_jasa]').val(dt_value.Pengguna_jasa);
                    $(xform+' [name=Tanggal_tender]').val(dt_value.Tanggal_tender);
                    $.each(data.attach,function(i,v){
                        set_file(v,1,"edit");
                    })
                }else{
                    open_form('close');
                    show_invalid_response(data);
                }
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

function edit_attach(id){
    $('#modal .modal-title').text(title_page+' '+language_app.lb_edit); // Set Title to Bootstrap modal title
    show_upload_file();
    $('#sell_remark').attr('disabled', false);
    show_button_cancel();
    $('.btn-back').attr('onclick', 'cancel_attach('+"'"+id+"'"+')');
    $('.btn-save2').attr('onclick', 'save_attach('+"'"+id+"'"+')');
}

function cancel_attach(id){
    view(id)
}

function save_attach(id){
    ID = $('.data-ID').val();
    remark = $('#sell_remark').val();
    if(ID){
        $('.btn-save2').button('loading');
        data_post = {
            ID : ID,
            Remark : remark,
        }

        url = url_simpan_remark;
        $.ajax({
            url : url,
            type: "POST",    
            data: data_post,
            dataType: "JSON",
            success: function(data){
                $('.btn-save2').button('reset');
                if(data.hakakses == "super_admin"){
                    console.log(data);
                }
                if(data.status){
                    swal('',data.message,'success');
                    view(id);
                }else{
                    swal('',data.message,'warning');
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR.responseText);
                $('.btn-save2').button('reset');
            }
        });
    }
}

