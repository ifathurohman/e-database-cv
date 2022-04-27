var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list        = host + "output_cv-list";
var url_list_non    = host + "output_cv-list_non_konstruksi";
var url_edit        = host + "output_cv-edit";
var url_edit_non            = host + "output_cv-edit_non_konstruksi";
var url_update_konstruksi   = host + "output_cv-update-konstruksi";
var url_update_non          = host + "output_cv-update-non_konstruksi";
var url_delete      = host + "output_cv-active";
var url_delete_all      = host + "output_cv-active_all";
var url_delete_all2      = host + "output_cv-active_all2";
var url_save        = host + "output_cv-save";
var url_export      = host + "output_cv-export";
var url_save_import = host + "output_cv-save-import";

var url_export_word_konstruksi      = host + "output_cv-export_konstruksi";
var url_export_word_non_konstruksi  = host + "output_cv-export_non_konstruksi";

var riwayat = 0;

$(document).ready(function() {
    filter_table();
    $(".v-table-konstruksi").show();
    $(".v-table-non-konstruksi").hide();
    $("#v-form-konstruksi").hide();
    $("#v-form-non_konstruksi").hide();
    $("#form-filter2").hide();
});

$('.summernote_pendidikan').summernote({
    toolbar:false,
    height: 150,
    placeholder: 'Masukan pendidikan formal',
    displayReadonly:false,
});

$('.summernote_pendidikan_non').summernote({
    toolbar:false,
    height: 150,
    displayReadonly:false,
    placeholder: 'Masukan pendidikan non formal',
});
$('.Uraian_tugas').summernote({
    toolbar:false,
    height: 150,
    displayReadonly:false,
    placeholder: 'Masukan uraian tugas',
});

$(".btn-konstruksi").click(function () {
	$(".v-table-konstruksi").show();
    $(".v-table-non-konstruksi").hide();
    $("#v-form-konstruksi").hide();
    $("#form-filter2").hide();
    $("#form-filter1").show();
    $("#v-form-non_konstruksi").hide();
});
$(".btn-non_konstruksi").click(function () {
    $(".v-table-non-konstruksi").show();
    $(".v-table-konstruksi").hide();
    $("#v-form-non_konstruksi").hide();
    $("#form-filter1").hide();
    $("#form-filter2").show();
    $("#v-form-konstruksi").hide();
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
            "targets": [0], //last column
            "orderable": false, //set not orderable
        },
        ],
        "language": {                
            "infoFiltered": ""
        },
    });

    table2 = $('#table-list-non').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "destroy":true,
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url"   : url_list_non,
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
            "targets": [0], //last column
            "orderable": false, //set not orderable
        },
        ],
        "language": {                
            "infoFiltered": ""
        },
    });
}

function filter_table1(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    var form_filter = '#form-filter1';
    Searchx         = $(form_filter+" [name=f-Search").val();

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
        Searchx         : Searchx,
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
            "targets": [0], //last column
            "orderable": false, //set not orderable
        },
        ],
        "language": {                
            "infoFiltered": ""
        },
    });

}

function filter_table2(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    var form_filter = '#form-filter2';
    Searchx         = $(form_filter+" [name=f-Search").val();

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
        Searchx         : Searchx,
    }
    //datatables
    table = $('#table-list-non').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "destroy":true,
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url"   : url_list_non,
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
            "targets": [0], //last column
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
    table2.ajax.reload(null,false); //reload datatable ajax
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

$('#checkAll').on('change',function(){
    if ($(this).is(':checked') ){
        $('.checkbox.dt-x').prop('checked',true);
    }
    else{
        $('.checkbox.dt-x').prop('checked',false);
    }
})

$('#checkAll2').on('change',function(){
    if ($(this).is(':checked') ){
        $('.checkbox.dt-z').prop('checked',true);
    }
    else{
        $('.checkbox.dt-z').prop('checked',false);
    }
})

function hapus(){
    datas = [];

    $('.checkbox.dt-x').each(function(i,v){
        if ($(v).is(':checked')==true){
            datas.push($(v).attr('baris-id2'));
        }
    })

    if (datas.length == 0){
         swal("Check at least 1 data !");
         return false;
    }

    swal({   title: 'Delete Data',   
        text: "Are you sure want to delete this data ?",   
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
                    url : url_delete_all,
                    type: "POST",
                    data: {ID:datas},
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
                swal("Delete Canceled !");
            } 
        }
        );
}

function hapus2(){
    datas = [];

    $('.checkbox.dt-z').each(function(i,v){
        if ($(v).is(':checked')==true){
            datas.push($(v).attr('baris-id2'));
        }
    })

    if (datas.length == 0){
         swal("Check at least 1 data !");
         return false;
    }

    swal({   title: 'Delete Data',   
        text: "Are you sure want to delete this data ?",   
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
                    url : url_delete_all2,
                    type: "POST",
                    data: {ID:datas},
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
                swal("Delete Canceled !");
            } 
        }
        );
}

var index_dt;
$("#table-list tbody").on('click','tr td:not(:first-child)',function(event){
    // index_dt = $(this).index();
    index_dt = $(this).parent().index();

    $('.action_list').removeClass('active');
    $('#table-list tbody tr td .action_list').eq(index_dt).addClass("active");
    event.stopPropagation();
});

var index_dt;
$("#table-list-non tbody").on('click','tr td:not(:first-child)',function(event){
    // index_dt = $(this).index();
    index_dt = $(this).parent().index();
    
    $('.action_list').removeClass('active');
    $('#table-list-non tbody tr td .action_list').eq(index_dt).addClass("active");
    event.stopPropagation();
});

function action_edit(){
    val = $('#table-list .dt-id').eq(index_dt).data();
    short_click(val);
}

function action_edit2(){
    val = $('#table-list-non .dt-id').eq(index_dt).data();
    short_click2(val);
}

function action_view(){
    save_method = 'view';
    val = $('#table-list .dt-id').eq(index_dt).data();
    
    $('html, body').animate({
        scrollTop: $("#daftar_riwayat").offset().top
    }, 2000);

    var domain      =  host;
    console.log(domain)
    var url         = 'https://view.officeapps.live.com/op/embed.aspx?src='+domain+'/file/word/default.docx';
    $('#office').prop('src', url);

    var url_download = 'https://edatabasecv.com/file/word/'+val.id+'.docx';
    var url_word     = 'https://view.officeapps.live.com/op/embed.aspx?src='+domain+'/file/word/'+val.id+'.docx';

    var url_dir      = 'https://edatabasecv.com:443/file/word/'+val.id+'.docx';
    var encode_dir1  =  encodeURIComponent(url_dir).replace(/'/g,"%27").replace(/"/g,"%22");
    var encode_dir1  =  encodeURIComponent(encode_dir1).replace(/'/g,"%27").replace(/"/g,"%22");
    var url_file1    = 'https://psg4-word-view.officeapps.live.com/wv/WordViewer/request.pdf?WOPIsrc=http%3A%2F%2Fpsg4%2Dview%2Dwopi%2Ewopi%2Eonline%2Eoffice%2Enet%3A808%2Foh%2Fwopi%2Ffiles%2F%40%2FwFileId%3FwFileId%3D'+encode_dir1+'&access_token=1&access_token_ttl=0&z=3bb53f276da67d5802b5e231c8021ab09f68b262acce3d7366722c0fad87464d&type=printpdf&useNamedAction=1';

    console.log(url_file1);

    $('.print').prop('href', url_file1);
    $('.download').prop('href', url_download);
    $('#office').prop('src', url_word);
}

function action_view2(){
    save_method = 'view2';
    val = $('#table-list-non .dt-id').eq(index_dt).data();
    
    $('html, body').animate({
        scrollTop: $("#daftar_riwayat").offset().top
    }, 2000);

    var domain      =  host;
    var url         = 'https://view.officeapps.live.com/op/embed.aspx?src='+domain+'/file/word/default.docx';
    $('#office').prop('src', url);

    var url_download = 'https://edatabasecv.com/file/word/'+val.id+'.docx';
    var url_word     = 'https://view.officeapps.live.com/op/embed.aspx?src='+domain+'/file/word/'+val.id+'.docx';

    var url_dir      = 'https://edatabasecv.com:443/file/word/'+val.id+'.docx';
    var encode_dir1  =  encodeURIComponent(url_dir).replace(/'/g,"%27").replace(/"/g,"%22");
    var encode_dir1  =  encodeURIComponent(encode_dir1).replace(/'/g,"%27").replace(/"/g,"%22");
    var url_file1    = 'https://psg4-word-view.officeapps.live.com/wv/WordViewer/request.pdf?WOPIsrc=http%3A%2F%2Fpsg4%2Dview%2Dwopi%2Ewopi%2Eonline%2Eoffice%2Enet%3A808%2Foh%2Fwopi%2Ffiles%2F%40%2FwFileId%3FwFileId%3D'+encode_dir1+'&access_token=1&access_token_ttl=0&z=3bb53f276da67d5802b5e231c8021ab09f68b262acce3d7366722c0fad87464d&type=printpdf&useNamedAction=1';

    console.log(url_file1);

    $('.print').prop('href', url_file1);
    $('.download').prop('href', url_download);
    $('#office').prop('src', url_word);
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
                if(p1 == "save_new"){
                    add_data();
                // }else{
                //     open_form('close');
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

function short_click2(p1){
    open_form('edit2',p1.id);
}

function batal() {
    location.reload();
    reload_table();
    window.scrollTo(0, 0);
} 

function edit_custom(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    xform = '#form';
    // $(xform)[0].reset();
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');

    $('.form-view input').attr('disabled', false);
    $('.form-view input').attr('readonly', false);
    $('.form-view').removeClass('content-hide');

    $(".summernote_pendidikan").summernote("enable");
    $(".summernote_pendidikan_non").summernote("enable");
    $(".Posisi").prop("onclick", null).off("click");
    $('.total_pengalaman').each(function(i,v){
        i= i+1;
        $("#Uraian_tugas" + i).summernote("enable");
        $('#Nama_kegiatan' + i).prop("onclick", null).off("click");
        $('#Posisi_penugasan' + i).prop("onclick", null).off("click");
    });

}

function edit_data(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    xform = '#form';
    $(xform)[0].reset();
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $('.form-view').removeClass('content-hide');

    $("#pernyataan_konstruksi").show();
    $("#pernyataan_non_konstruksi").hide();

    $(".summernote_pendidikan").summernote("disable");
    $(".summernote_pendidikan_non").summernote("disable");
    $(".Uraian_tugas").summernote("disable");

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
            // show_console(data);
            console.log(data);
            riwayat +=1;
            
            $("#v-form-konstruksi").show();
            $("#v-form-non_konstruksi").hide();
            // $("#v-form-non_konstruksi").show();
            id_form  = '<h4 class="id-form v-form">ID FORM #'+p1+'</h4>';
            $('.id_form').append(id_form);

            if(data.status){
                dt_value = data.data[0];
                $(xform+' [name=crud]').val('update');
                $(xform+' [name=ID]').val(p1);
                $(xform+' [name=Posisi]').val(dt_value.Posisi);
                $(xform+' [name=Nama_perusahaan1]').val(dt_value.Nama_perusahaan1);
                $(xform+' [name=Nama_personil]').val(dt_value.Nama_personil);
                $(xform+' [name=Tempat_tanggal_lahir]').val(dt_value.Tempat_tanggal_lahir);
                $('#Pendidikan'+ riwayat).summernote('code', dt_value.Pendidikan);
                $('#Pendidikan_non_formal'+ riwayat).summernote('code', dt_value.Pendidikan_non_formal);

                if(dt_value.Penguasaan_bahasa_indo == "Sangat Baik"){
                    $('#sangat_baik1').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_indo == "Baik"){
                    $('#baik1').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_indo == "Cukup"){
                    $('#cukup1').prop('checked', true);
                }

                if(dt_value.Penguasaan_bahasa_inggris == "Sangat Baik"){
                    $('#sangat_baik2').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_inggris == "Baik"){
                    $('#baik2').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_inggris == "Cukup"){
                    $('#cukup2').prop('checked', true);
                }

                if(dt_value.Penguasaan_bahasa_setempat == "Sangat Baik"){
                    $('#sangat_baik3').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_setempat == "Baik"){
                    $('#baik3').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_setempat == "Cukup"){
                    $('#cukup3').prop('checked', true);
                }

                if(dt_value.Status_kepegawaian2 == "Tidak Tetap"){
                    $('#status_kepeg2_tidak_tetap').prop('checked', true);
                }else if(dt_value.Status_kepegawaian2 == "Tetap"){
                    $('#status_kepeg2_tetap').prop('checked', true);
                }

                if(dt_value.Pernyataan == "1"){
                    $('#Pernyataan').prop('checked', true);
                }

                $.each(data.data, function(i, v) {
                    add_pengalaman(v);
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

function update_konstruksi(p1){
    xform = '#form';
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');

    proccess_save();

    add_data_page(xform);
    // ajax adding data to database
    var xform        = $(xform)[0]; // You need to use standard javascript object here
    var formData     = new FormData(xform);
    $.ajax({
        url : url_update_konstruksi,
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
function update_non_konstruksi(p1){
    xform = '#form';
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');

    proccess_save();

    add_data_page(xform);
    // ajax adding data to database
    var xform        = $(xform)[0]; // You need to use standard javascript object here
    var formData     = new FormData(xform);
    $.ajax({
        url : url_update_non,
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

function edit_data2(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    xform = '#form';
    $(xform)[0].reset();
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');

    $("#pernyataan_non_konstruksi").show();
    $("#pernyataan_konstruksi").hide();
    $('.form-view').removeClass('content-hide');

    $(".summernote_pendidikan").summernote("disable");
    $(".summernote_pendidikan_non").summernote("disable");
    $(".Uraian_tugas").summernote("disable");

    data_post = {
        ID : p1,
        page_url        : dt_url,
        page_module     : dt_module,
    }
    $.ajax({
        url : url_edit_non,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            riwayat +=1;
            
            $("#v-form-non_konstruksi").show();
            id_form  = '<h4 class="id-form v-form">ID FORM #'+p1+'</h4>';
            $('.id_form').append(id_form);

            if(data.status){
                dt_value = data.data[0];
                $(xform+' [name=crud]').val('update');
                $(xform+' [name=ID]').val(p1);
                $(xform+' [name=Posisi]').val(dt_value.Posisi);
                $(xform+' [name=Nama_perusahaan1]').val(dt_value.Nama_perusahaan1);
                $(xform+' [name=Nama_personil]').val(dt_value.Nama_personil);
                $(xform+' [name=Tempat_tanggal_lahir]').val(dt_value.Tempat_tanggal_lahir);
                $('#Pendidikan'+ riwayat).summernote('code', dt_value.Pendidikan);
                $('#Pendidikan_non_formal'+ riwayat).summernote('code', dt_value.Pendidikan_non_formal);

                if(dt_value.Penguasaan_bahasa_indo == "Sangat Baik"){
                    $('#sangat_baik1').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_indo == "Baik"){
                    $('#baik1').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_indo == "Cukup"){
                    $('#cukup1').prop('checked', true);
                }

                if(dt_value.Penguasaan_bahasa_inggris == "Sangat Baik"){
                    $('#sangat_baik2').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_inggris == "Baik"){
                    $('#baik2').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_inggris == "Cukup"){
                    $('#cukup2').prop('checked', true);
                }

                if(dt_value.Penguasaan_bahasa_setempat == "Sangat Baik"){
                    $('#sangat_baik3').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_setempat == "Baik"){
                    $('#baik3').prop('checked', true);
                }else if(dt_value.Penguasaan_bahasa_setempat == "Cukup"){
                    $('#cukup3').prop('checked', true);
                }

                if(dt_value.Status_kepegawaian2 == "Tidak Tetap"){
                    $('#status_kepeg2_tidak_tetap').prop('checked', true);
                }else if(dt_value.Status_kepegawaian2 == "Tetap"){
                    $('#status_kepeg2_tetap').prop('checked', true);
                }
                
                if(dt_value.Pernyataan == "1"){
                    $('#Pernyataan_non').prop('checked', true);
                }

                $.each(data.data, function(i, v) {
                    add_pengalaman(v);
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

var domain      = host;
var url_pdf     = domain+'/file/pdf/default.pdf';
var url         = 'https://view.officeapps.live.com/op/embed.aspx?src='+domain+'/file/word/default.docx';
$('#office').prop('src', url);
$('#refferensi').prop('src', url_pdf);

let status = 0;
let room = 0;

function add_pengalaman(data) {
    
    kolom = $('#pengalaman_kerjax').length + 1;
    
    status ++;
	room ++;

    PengalamanID             = "";
    Nama_kegiatan            = "";
    Lokasi_kegiatan          = "";
    Pengguna_jasa            = "";
    Nama_perusahaan          = "";
    Posisi_penugasan         = "";
    Uraian_tugas             = "";
    Waktu_pelaksanaan        = "";
    Status_kepegawaian       = "";
    Surat_referensi          = "";
    button_remove            = "";

    if(data){
        PengalamanID         = data.PengalamanID;
        Nama_kegiatan        = data.Nama_kegiatan;
        Lokasi_kegiatan      = data.Lokasi_kegiatan;
        Pengguna_jasa        = data.Pengguna_jasa;
        Nama_perusahaan      = data.Nama_perusahaan;
        Posisi_penugasan     = data.Posisi_penugasan;
        Uraian_tugas         = data.Uraian_tugas;
        Waktu_pelaksanaan    = data.Waktu_pelaksanaan;
        Status_kepegawaian   = data.Status_kepegawaian;
        Surat_referensi      = data.Surat_referensi;
    }
    console.log(data);

    if (kolom > 1){
        button_remove = '<span class="pointer" onclick="remove_education_fields('+ room +')"><i class="fa fa-minus-square-o fa-lg" style="font-weight:500;font-size:32px;margin-right:25px;color:red"></i></span>';
    }
    
	var objTo = document.getElementById('pengalaman_kerja')
	var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass" + room);
	var rdiv = 'removeclass' + room;
	divtest.innerHTML = '<div class="card" id="pengalaman_kerjax">\
    <div class="card-header bt-light-grey">\
      <div class="row">\
        <div class="col-md-6">\
          <h4 class="m-b-0 text-muted-bold">PENGALAMAN KERJA </h4>\
        </div>\
        <div class="col-md-6">\
          <h4 class="m-b-0 pull-right">\
            <span class="pointer">\
              <i class="ti-arrow-circle-up" style="font-weight:700;font-size:x-large"></i>\
            </span>\
          </h4>\
          <h4 class="m-b-0 pull-right">\
            '+button_remove+'\
            <span class="pointer" onclick="add_pengalaman()">\
              <i class="fa fa-plus-square-o fa-lg" style="font-weight:500;font-size:32px;margin-right:25px"></i>\
            </span>\
          </h4>\
        </div>\
      </div>\
    </div>\
    <div class="card-body bg-card">\
        <input type="hidden" name="crud">\
        <input type="hidden" name="ID">\
        <input type="hidden" name="page_url">\
        <input type="hidden" name="page_module">\
        <input type="hidden" name="PengalamanID[]" id="PengalamanID'+ room +'" value="'+PengalamanID+'">\
        <div class="row">\
        <div class="col-md-8">\
            <div class="form-group">\
            <label class="custom-label">NAMA KEGIATAN</label>\
            <input class="form-control input-custom total_pengalaman" name="Nama_kegiatan[]" id="Nama_kegiatan'+ room +'" type="text" onclick="modal_pengalaman('+"'#Nama_kegiatan"+ room +"'"+')" placeholder="Masukan nama kegiatan" value="'+Nama_kegiatan+'">\
            <small class="form-control-feedback"></small>\
            </div>\
            <div class="form-group">\
            <label class="custom-label">LOKASI KEGIATAN</label>\
            <input class="form-control input-custom" name="Lokasi_kegiatan[]" id="Lokasi_kegiatan'+ room +'" type="text" placeholder="Masukan lokasi kegiatan" readonly="" value="'+Lokasi_kegiatan+'">\
            </div>\
            <div class="form-group">\
            <label class="custom-label">PENGGUNA JASA</label>\
            <input class="form-control input-custom" name="Pengguna_jasa[]" id="Pengguna_jasa'+ room +'" type="text" placeholder="Masukan pengguna jasa" readonly="" value="'+Pengguna_jasa+'">\
            </div>\
            <div class="form-group">\
            <label class="custom-label">NAMA PERUSAHAAN</label>\
            <input class="form-control input-custom" name="Nama_perusahaan[]" id="Nama_perusahaan'+ room +'" type="text" placeholder="Masukan nama perusahaan" readonly="" value="'+Nama_perusahaan+'">\
            </div>\
            <div class="form-group">\
            <label class="custom-label">POSISI PENUGASAN</label>\
            <input class="form-control input-custom Posisi_penugasan[]" name="Posisi_penugasan[]" id="Posisi_penugasan'+ room +'" type="text" onclick="modal_penugasan('+"'#Posisi_penugasan"+ room +"'"+')" placeholder="Masukan posisi penugasan" value="'+Posisi_penugasan+'">\
            <small class="form-control-feedback"></small>\
            </div>\
            <div class="form-group">\
                <label class="custom-label-textarea">URAIAN TUGAS</label>\
                <textarea class="form-control Uraian_tugas" name="Uraian_tugas[]" id="Uraian_tugas'+ room +'" placeholder="Masukan uraian tugas"></textarea>\
            </div>\
            <div class="form-group">\
            <label class="custom-label">WAKTU PELAKSANAAN</label>\
            <input class="form-control input-custom" name="Waktu_pelaksanaan[]" id="Waktu_pelaksanaan'+ room +'" type="text" placeholder="Masukan waktu penugasan" readonly="" value="'+Waktu_pelaksanaan+'">\
            </div>\
            <div class="form-group">\
                <label class="custom-label-2">STATUS KEPEGAWAIAN PADA PERUSAHAAN</label>\
                <div class="row">\
                    <fieldset class="controls">\
                    <div class="custom-control custom-radio">\
                        <input type="radio" name="Status_kepegawaian['+ status +']" id="status_kepeg1_tidak_tetap'+ status +'" value="Tidak Tetap" class="form-check-input radio-custom Status_kepegawaian'+ room +'">\
                        <label class="form-check-label label-custom1" style="margin-left:25px">Tidak Tetap</label>\
                    </div>\
                    </fieldset>\
                    <fieldset class="controls">\
                    <div class="custom-control custom-radio ml-70-px">\
                        <input type="radio" name="Status_kepegawaian['+ status +']" id="status_kepeg1_tetap'+ status +'" value="Tetap" class="form-check-input radio-custom Status_kepegawaian'+ room +'">\
                        <label class="form-check-label label-custom1" style="margin-left:25px">Tetap</label>\
                    </div>\
                    </fieldset>\
                </div>\
            </div>\
            <div class="form-group">\
            <label class="custom-label">SURAT REFERENSI DARI PENGGUNA JASA</label>\
            <input class="form-control input-custom" name="Surat_referensi[]" id="Surat_referensi'+ room +'" type="text" placeholder="Masukan surat referensi dari pengguna jasa" readonly="" value="Terlampir">\
            </div>\
        </div>\
        </div>\
    </div>\
    </div>';

	objTo.appendChild(divtest)
    $('.Uraian_tugas').summernote({
        toolbar:false,
        height: 150,
        displayReadonly:false,
        placeholder: 'Masukan uraian tugas',
    });
    $('#Uraian_tugas' +room).summernote('code','');
    $('#Uraian_tugas' +room).summernote("disable");
    $('#Uraian_tugas' +room).summernote('code', Uraian_tugas);
    console.log(Status_kepegawaian);
    if(Status_kepegawaian == "Tidak Tetap"){
        $('#status_kepeg1_tidak_tetap' +status).prop('checked', true);
    }else if(Status_kepegawaian == "Tetap"){
        $('#status_kepeg1_tetap' +status).prop('checked', true);
    }
}

function remove_education_fields(rid) {
	$('.removeclass' + rid).remove();
}

if(performance.navigation.type == 2){
    location.reload(true);
 }

 pengalaman  = 0;
posisi      = 0;

function export_word_konstruksi (p1=""){

    posisi                      +=1;
    pengalaman                  +=1;

    xform                       = '#form';
    ID                          = $(xform+" [name=ID]").val();
    Posisi                      = $(xform+" [name=Posisi]").val();
    Nama_perusahaan1            = $(xform+" [name=Nama_perusahaan1]").val();
    Nama_personil               = $(xform+" [name=Nama_personil]").val();
    Tempat_tanggal_lahir        = $(xform+" [name=Tempat_tanggal_lahir]").val();
    Penguasaan_bahasa_indo      = $(xform+" [name=Penguasaan_bahasa_indo]:checked").val();
    Penguasaan_bahasa_inggris   = $(xform+" [name=Penguasaan_bahasa_inggris]:checked").val();
    Penguasaan_bahasa_setempat  = $(xform+" [name=Penguasaan_bahasa_setempat]:checked").val();
    Status_kepegawaian2         = $(xform+" [name=Status_kepegawaian2]:checked").val();

    Pendidikan                  = $('#Pendidikan' + pengalaman).val();
    Pendidikan_non_formal       = $('#Pendidikan_non_formal' + pengalaman).val();
    Nama_kegiatan               = $('#Nama_kegiatan' + pengalaman).val();
    PengalamanID                = $('#PengalamanID' + pengalaman).val();
    Lokasi_kegiatan             = $('#Lokasi_kegiatan' + pengalaman).val();
    Pengguna_jasa               = $('#Pengguna_jasa' + pengalaman).val();
    Nama_perusahaan             = $('#Nama_perusahaan' + pengalaman).val();
    Uraian_tugas                = $('#Uraian_tugas' + pengalaman).val();
    Waktu_pelaksanaan           = $('#Waktu_pelaksanaan' + pengalaman).val();
    Posisi_penugasan            = $('#Posisi_penugasan' + pengalaman).val();
    // Status_kepegawaian          = $('#Status_kepegawaian' + pengalaman).val();
    Surat_referensi             = $('#Surat_referensi' + pengalaman).val();
    Status_kepegawaian          = $(xform+" [name=Status_kepegawaian]:checked").val();
    
    data_post = {
        ID                          : ID,
        Posisi                      : Posisi,
        Nama_perusahaan1            : Nama_perusahaan1,
        Nama_personil               : Nama_personil,
        Tempat_tanggal_lahir        : Tempat_tanggal_lahir,
        Pendidikan                  : Pendidikan,
        Pendidikan_non_formal       : Pendidikan_non_formal,
        Penguasaan_bahasa_indo      : Penguasaan_bahasa_indo,
        Penguasaan_bahasa_inggris   : Penguasaan_bahasa_inggris,
        Penguasaan_bahasa_setempat  : Penguasaan_bahasa_setempat,
        Status_kepegawaian2         : Status_kepegawaian2,

        Nama_kegiatan               : Nama_kegiatan,
        PengalamanID                : PengalamanID,
        Lokasi_kegiatan             : Lokasi_kegiatan,
        Pengguna_jasa               : Pengguna_jasa,
        Nama_perusahaan             : Nama_perusahaan,
        Uraian_tugas                : Uraian_tugas,
        Waktu_pelaksanaan           : Waktu_pelaksanaan,
        Posisi_penugasan            : Posisi_penugasan,
        Status_kepegawaian          : Status_kepegawaian,
        Surat_referensi             : Surat_referensi,

    }
    
    data_detail = [];
    $('.total_pengalaman').each(function(i,v){
        i= i+1;
        Status_kepegawaian = '';
        $(".Status_kepegawaian" + i).each(function() {
            if (this.checked) {
                Status_kepegawaian = $(this).val();
            }
        });
        data_detail[i] = {
            Nama_kegiatan              : $('#Nama_kegiatan' + i).val(),
            PengalamanID               : $('#PengalamanID' + i).val(),
            Lokasi_kegiatan            : $('#Lokasi_kegiatan' + i).val(),
            Pengguna_jasa              : $('#Pengguna_jasa' + i).val(),
            Nama_perusahaan            : $('#Nama_perusahaan' + i).val(),
            Uraian_tugas               : $('#Uraian_tugas' + i).val(),
            Waktu_pelaksanaan          : $('#Waktu_pelaksanaan' + i).val(),
            Posisi_penugasan           : $('#Posisi_penugasan' + i).val(),
            Surat_referensi            : $('#Surat_referensi' + i).val(),
            Status_kepegawaian         : Status_kepegawaian,
        }
    })

    console.log(data_detail);

    data_pendidikan = [];
    $('.total_pendidikan').each(function(j,v){
        j= j+1;
        data_pendidikan[j] = {
            Pendidikan                 : $('#Pendidikan' + j).val(),
            Pendidikan_non_formal      : $('#Pendidikan_non_formal' + j).val(),
        }
    })

    $.ajax({
        url : url_export_word_konstruksi,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
        },
        // error: function (jqXHR, textStatus, errorThrown)
        // {
        //     alert('Error adding / update data');
        //     console.log(jqXHR.responseText);
        // }
    });
    $.redirect(url_export_word_konstruksi,
    {
        ID                          : ID,
        Posisi                      : Posisi,
        Nama_perusahaan1            : Nama_perusahaan1,
        Nama_personil               : Nama_personil,
        Tempat_tanggal_lahir        : Tempat_tanggal_lahir,
        Penguasaan_bahasa_indo      : Penguasaan_bahasa_indo,
        Penguasaan_bahasa_inggris   : Penguasaan_bahasa_inggris,
        Penguasaan_bahasa_setempat  : Penguasaan_bahasa_setempat,
        Status_kepegawaian2         : Status_kepegawaian2,
        detail                      : data_detail,
        pendidikan                  : data_pendidikan,
    },
    "POST","blank"), swal({
        title:'Berhasil',
        text:'Simpan dan Export berhasil',
        type:'success',
        icon:'success',
        confirmButtonText: 'OK',
        showCancelButton: false,
    }, function () {
        reload_table();
        location.reload();
        window.scrollTo(0, 0);
    });
    update_konstruksi();
}

pengalaman  = 0;
posisi      = 0;

function export_word_non_konstruksi(p1=""){

    posisi                      +=1;
    pengalaman                  +=1;

    xform                       = '#form';
    ID                          = $(xform+" [name=ID]").val();
    Posisi                      = $(xform+" [name=Posisi]").val();
    Nama_perusahaan1            = $(xform+" [name=Nama_perusahaan1]").val();
    Nama_personil               = $(xform+" [name=Nama_personil]").val();
    Tempat_tanggal_lahir        = $(xform+" [name=Tempat_tanggal_lahir]").val();
    Penguasaan_bahasa_indo      = $(xform+" [name=Penguasaan_bahasa_indo]:checked").val();
    Penguasaan_bahasa_inggris   = $(xform+" [name=Penguasaan_bahasa_inggris]:checked").val();
    Penguasaan_bahasa_setempat  = $(xform+" [name=Penguasaan_bahasa_setempat]:checked").val();
    Status_kepegawaian2         = $(xform+" [name=Status_kepegawaian2]:checked").val();

    Pendidikan                  = $('#Pendidikan' + pengalaman).val();
    Pendidikan_non_formal       = $('#Pendidikan_non_formal' + pengalaman).val();
    Nama_kegiatan               = $('#Nama_kegiatan' + pengalaman).val();
    PengalamanID                = $('#PengalamanID' + pengalaman).val();
    Lokasi_kegiatan             = $('#Lokasi_kegiatan' + pengalaman).val();
    Pengguna_jasa               = $('#Pengguna_jasa' + pengalaman).val();
    Nama_perusahaan             = $('#Nama_perusahaan' + pengalaman).val();
    Uraian_tugas                = $('#Uraian_tugas' + pengalaman).val();
    Waktu_pelaksanaan           = $('#Waktu_pelaksanaan' + pengalaman).val();
    Posisi_penugasan            = $('#Posisi_penugasan' + pengalaman).val();
    // Status_kepegawaian          = $('#Status_kepegawaian' + pengalaman).val();
    Surat_referensi             = $('#Surat_referensi' + pengalaman).val();
    Status_kepegawaian          = $(xform+" [name=Status_kepegawaian]:checked").val();
    
    data_post = {
        ID                          : ID,
        Posisi                      : Posisi,
        Nama_perusahaan1            : Nama_perusahaan1,
        Nama_personil               : Nama_personil,
        Tempat_tanggal_lahir        : Tempat_tanggal_lahir,
        Pendidikan                  : Pendidikan,
        Pendidikan_non_formal       : Pendidikan_non_formal,
        Penguasaan_bahasa_indo      : Penguasaan_bahasa_indo,
        Penguasaan_bahasa_inggris   : Penguasaan_bahasa_inggris,
        Penguasaan_bahasa_setempat  : Penguasaan_bahasa_setempat,
        Status_kepegawaian2         : Status_kepegawaian2,

        Nama_kegiatan               : Nama_kegiatan,
        PengalamanID                : PengalamanID,
        Lokasi_kegiatan             : Lokasi_kegiatan,
        Pengguna_jasa               : Pengguna_jasa,
        Nama_perusahaan             : Nama_perusahaan,
        Uraian_tugas                : Uraian_tugas,
        Waktu_pelaksanaan           : Waktu_pelaksanaan,
        Posisi_penugasan            : Posisi_penugasan,
        Status_kepegawaian          : Status_kepegawaian,
        Surat_referensi             : Surat_referensi,

    }

    console.log(data_post);
    
    data_detail = [];
    $('.total_pengalaman').each(function(i,v){
        i= i+1;
        Status_kepegawaian = '';
        $(".Status_kepegawaian" + i).each(function() {
            if (this.checked) {
                Status_kepegawaian = $(this).val();
            }
        });
        data_detail[i] = {
            Nama_kegiatan              : $('#Nama_kegiatan' + i).val(),
            PengalamanID               : $('#PengalamanID' + i).val(),
            Lokasi_kegiatan            : $('#Lokasi_kegiatan' + i).val(),
            Pengguna_jasa              : $('#Pengguna_jasa' + i).val(),
            Nama_perusahaan            : $('#Nama_perusahaan' + i).val(),
            Uraian_tugas               : $('#Uraian_tugas' + i).val(),
            Waktu_pelaksanaan          : $('#Waktu_pelaksanaan' + i).val(),
            Posisi_penugasan           : $('#Posisi_penugasan' + i).val(),
            Surat_referensi            : $('#Surat_referensi' + i).val(),
            Status_kepegawaian         : Status_kepegawaian,
        }
    })

    data_pendidikan = [];
    $('.total_pendidikan').each(function(j,v){
        j= j+1;
        data_pendidikan[j] = {
            Pendidikan                 : $('#Pendidikan' + j).val(),
            Pendidikan_non_formal      : $('#Pendidikan_non_formal' + j).val(),
        }
    })

    $.ajax({
        url : url_export_word_non_konstruksi,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
        },
        // error: function (jqXHR, textStatus, errorThrown)
        // {
        //     alert('Error adding / update data');
        //     console.log(jqXHR.responseText);
        // }
    });

    xform                       = '#form';
    Posisi                      = $(xform+" [name=Posisi]").val();
    Nama_kegiatan               = $('#Nama_kegiatan1').val();
    Posisi_penugasan            = $('#Posisi_penugasan1').val();
    
    $.redirect(url_export_word_non_konstruksi,
    {
        ID                          : ID,
        Posisi                      : Posisi,
        Nama_perusahaan1            : Nama_perusahaan1,
        Nama_personil               : Nama_personil,
        Tempat_tanggal_lahir        : Tempat_tanggal_lahir,
        Penguasaan_bahasa_indo      : Penguasaan_bahasa_indo,
        Penguasaan_bahasa_inggris   : Penguasaan_bahasa_inggris,
        Penguasaan_bahasa_setempat  : Penguasaan_bahasa_setempat,
        Status_kepegawaian2         : Status_kepegawaian2,
        detail                      : data_detail,
        pendidikan                  : data_pendidikan,
    },
    "POST","blank"), swal({
        title:'Berhasil',
        text:'Simpan dan Export berhasil',
        type:'success',
        icon:'success',
        confirmButtonText: 'OK',
        showCancelButton: false,
    }, function () {
        reload_table();
        location.reload();
        window.scrollTo(0, 0);
    });
    update_non_konstruksi();
}