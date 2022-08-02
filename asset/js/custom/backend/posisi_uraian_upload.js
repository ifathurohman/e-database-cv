var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_save_import2    = host + "posisi-save-import";
$(document).ready(function() {
    $("#v-form").show();
    $("#v-list").hide();
    $('.v-import-result2').hide();
});

$("#v-form").hide();
$("#v-list").show();
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
                $(xform+' .Company').val(dt_value.CompanyID);
                $(xform+' .Company-Name').val(dt_value.CompanyName);
                $(xform+' [name=Name]').val(dt_value.Name);
                $(xform+' [name=Code]').val(dt_value.Code);
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

pengalaman  = 0;
posisi      = 0;

function import_data_posisi(p1){
    xform = '#form-import-posisi';
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
        url : url_save_import2,
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
                    });

                }else{
                    result_impot(data);
                }
            }
            else
            {
                // show_invalid_response(data);
                swal({
                    title   : "Failed!",
                    text    : data.message,
                    imageUrl: host+"/img/icon/image-83.png",
                    imageWidth: 600,
                    imageHeight: 600,
                    confirmButtonText: 'Try Again',
                });
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

let no = 1;

function result_impot(data){
    xform = '#form-import-posisi';
    $(xform+' #inputFileName').val(data.inputFileName);
    $(xform+' #CompanyID').val(data.CompanyID);
    $('.v-import-result').show(300);
    // if ( $.fn.DataTable.isDataTable('#table-import-result') ) {
    //     import_header(data.header);
    //     $('#table-import-result').DataTable().destroy();
    // }
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
            item += '<td>'+v.No+'</td>';
            item += '<td style="min-width:250px;">'+v.Nama_kegiatan+'</td>';
            item += '<td style="min-width:250px;">'+v.Lokasi_kegiatan+'</td>';
            item += '<td style="min-width:250px;">'+v.Pengguna_jasa+'</td>';
            item += '<td style="min-width:250px;">'+v.Nama_perusahaan+'</td>';
            item += '<td style="min-width:250px;">'+v.Waktu_pelaksanaan_mulai+'</td>';
            item += '<td style="min-width:250px;">'+v.Waktu_pelaksanaan_selesai+'</td>';
            item += '<td>'+status+'</td>';
            item += '<td style="min-width: 400px;">'+v.Message+'</td>';
            item += '</tr>';
        });
    }else{

    }
    $('#table-import-result tbody').append(item);
    // $('#table-import-result').DataTable({
    //     "destroy"   : true,
    // });
    $('.import-total-succeess').text(total_import_success);
    $('.import-total-failed').text(total_import_failed);
    $('.import-total').text(total_import);
}