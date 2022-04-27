var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list           = host + "sdm_pegawai-list";
var url_edit           = host + "sdm_pegawai-edit";
var url_delete         = host + "sdm_pegawai-active";
var url_save           = host + "sdm_pegawai-save";
var url_save_uraian    = host + "sdm_pegawai-save-uraian";
var url_export         = host + "sdm_pegawai-export";
var url_save_import    = host + "sdm_pegawai-save-import";
$(document).ready(function() {
    filter_table();
    $("#v-form").show();
    $("#v-list").hide();
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

function save_uraian(p1){

    var contents    = $('.Uraian_pengalaman').summernote('code');
    var plainText   = $("<p>" + contents+ "</p>").text();

    xform = '#form';
    $(xform+' [name=Uraian_pengalaman]').val(plainText);
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');
    proccess_save();

    add_data_page(xform);
    // ajax adding data to database
    var xform        = $(xform)[0]; // You need to use standard javascript object here
    var formData    = new FormData(xform);
    $.ajax({
        url : url_save_uraian,
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
    $(".Nama").prop("onclick", null).off("click");
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

function export_data(){


    posisi                      +=1;
    pengalaman                  +=1;

    xform                       = '#form';
    ID                          = $(xform+" [name=ID]").val();
    Posisi                      = $(xform+" [name=Posisi]").val();
    Nama_perusahaan1            = $(xform+" [name=Nama_perusahaan1").val();
    Nama_personil               = $(xform+" [name=Nama_personil").val();
    Tempat_tanggal_lahir        = $(xform+" [name=Tempat_tanggal_lahir").val();
    Pendidikan                  = $(xform+" [name=Pendidikan").val();
    Pendidikan_non_formal       = $(xform+" [name=Pendidikan_non_formal").val();
    Penguasaan_bahasa_indo      = $(xform+" [name=Penguasaan_bahasa_indo").val();
    Status_kepegawaian2         = $(xform+" [name=Status_kepegawaian2").val();

    Nama_kegiatan               = $('#Nama_kegiatan' + pengalaman).val();
    PengalamanID                = $('#PengalamanID' + pengalaman).val();
    Lokasi_kegiatan             = $('#Lokasi_kegiatan' + pengalaman).val();
    Pengguna_jasa               = $('#Pengguna_jasa' + pengalaman).val();
    Nama_perusahaan             = $('#Nama_perusahaan' + pengalaman).val();
    Uraian_tugas                = $('#Uraian_tugas' + pengalaman).val();
    Waktu_pelaksanaan           = $('#Waktu_pelaksanaan' + pengalaman).val();
    Posisi_penugasan            = $('#Posisi_penugasan' + pengalaman).val();
    Status_kepegawaian          = $('#Status_kepegawaian' + pengalaman).val();
    Surat_referensi             = $('#Surat_referensi' + pengalaman).val();

    // if(PengalamanID.length > 1){
    //     $.each(PengalamanID,function(i,v){

    //         Nama_kegiatan       = v.Nama_kegiatan;
    //         PengalamanID        = v.PengalamanID;
    //         Lokasi_kegiatan     = v.Lokasi_kegiatan;
    //         Pengguna_jasa       = v.Pengguna_jasa;
    //         Nama_perusahaan     = v.Nama_perusahaan;
    //         Uraian_tugas        = v.Uraian_tugas;
    //         Waktu_pelaksanaan   = v.Waktu_pelaksanaan;
    //         Posisi_penugasan    = v.Posisi_penugasan;
    //         Status_kepegawaian  = v.Status_kepegawaian;
    //         Surat_referensi     = v.Surat_referensi;
    //     });
    //     console.log(i);
    // }

    data_post = {
        ID                          : ID,
        Posisi                      : Posisi,
        Nama_perusahaan1            : Nama_perusahaan1,
        Nama_personil               : Nama_personil,
        Tempat_tanggal_lahir        : Tempat_tanggal_lahir,
        Pendidikan                  : Pendidikan,
        Pendidikan_non_formal       : Pendidikan_non_formal,
        Penguasaan_bahasa_indo      : Penguasaan_bahasa_indo,
        Status_kepegawaian2         : Status_kepegawaian2,

        Nama_kegiatan              : Nama_kegiatan,
        PengalamanID               : PengalamanID,
        Lokasi_kegiatan            : Lokasi_kegiatan,
        Pengguna_jasa              : Pengguna_jasa,
        Nama_perusahaan            : Nama_perusahaan,
        Uraian_tugas               : Uraian_tugas,
        Waktu_pelaksanaan          : Waktu_pelaksanaan,
        Posisi_penugasan           : Posisi_penugasan,
        Status_kepegawaian         : Status_kepegawaian,
        Surat_referensi            : Surat_referensi,
    }

    
    $.ajax({
        url : url_export,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            // if(data.status){
            //     dt_value = data.data;
            //     $(xform+' [name=crud]').val('update');
            //     $(xform+' [name=ID]').val(p1);
            //     $(xform+' .Company').val(dt_value.CompanyID);
            //     $(xform+' .Company-Name').val(dt_value.CompanyName);
            //     $(xform+' [name=Name]').val(dt_value.Name);
            //     $(xform+' [name=Code]').val(dt_value.Code);
            // }else{
            //     open_form('close');
            //     show_invalid_response(data);
            // }
        },
        // error: function (jqXHR, textStatus, errorThrown)
        // {
        //     alert('Error adding / update data');
        //     console.log(jqXHR.responseText);
        // }
    });

    $.redirect(url_export,
    {
        ID                          : ID,
        Posisi                      : Posisi,
        Nama_perusahaan1            : Nama_perusahaan1,
        Nama_personil               : Nama_personil,
        Tempat_tanggal_lahir        : Tempat_tanggal_lahir,
        Pendidikan                  : Pendidikan,
        Pendidikan_non_formal       : Pendidikan_non_formal,
        Penguasaan_bahasa_indo      : Penguasaan_bahasa_indo,
        Status_kepegawaian2         : Status_kepegawaian2,

        PengalamanID               : PengalamanID,
        Nama_kegiatan              : Nama_kegiatan,
        Lokasi_kegiatan            : Lokasi_kegiatan,
        Pengguna_jasa              : Pengguna_jasa,
        Nama_perusahaan            : Nama_perusahaan,
        Uraian_tugas               : Uraian_tugas,
        Waktu_pelaksanaan          : Waktu_pelaksanaan,
        Posisi_penugasan           : Posisi_penugasan,
        Status_kepegawaian         : Status_kepegawaian,
        Surat_referensi            : Surat_referensi,
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
            item += '<td>'+v.Code+'</td>';
            item += '<td>'+v.Name+'</td>';
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


let room = 1;

function add_pengalaman() {

	room++;

	var objTo = document.getElementById('pengalaman_kerja')
	var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass" + room);
	var rdiv = 'removeclass' + room;
	divtest.innerHTML = '<div class="card"><div class="card-header bt-light-grey"><div class="row"><div class="col-md-6"><h4 class="m-b-0 text-muted-bold">PENGALAMAN KERJA '+ room +'</h4></div><div class="col-md-6"><h4 class="m-b-0 pull-right"><span class="pointer"><i class="ti-arrow-circle-up" style="font-weight:700;font-size:x-large"></i></span></h4><h4 class="m-b-0 pull-right"><span class="pointer" onclick="remove_education_fields('+ room +')"><i class="fa fa-minus-square-o fa-lg" style="font-weight:500;font-size:32px;margin-right:25px;color:red"></i></span><span class="pointer" onclick="add_pengalaman()"><i class="fa fa-plus-square-o fa-lg" style="font-weight:500;font-size:32px;margin-right:25px"></i></span></h4></div></div></div><div class="card-body bg-card"><input type="hidden" name="crud"> <input type="hidden" name="ID"> <input type="hidden" name="page_url"> <input type="hidden" name="page_module"> <input type="hidden" name="PengalamanID[]" id="PengalamanID'+ room +'"><div class="row"><div class="col-md-8"><div class="form-group"><label class="custom-label">NAMA KEGIATAN</label><input class="form-control input-custom" name="Nama_kegiatan[]" id="Nama_kegiatan'+ room +'" type="text" onclick="modal_pengalaman()" placeholder="Masukan nama kegiatan"><small class="form-control-feedback"></small></div><div class="form-group"><label class="custom-label">LOKASI KEGIATAN</label><input class="form-control input-custom" name="Lokasi_kegiatan[]" id="Lokasi_kegiatan'+ room +'" type="text" placeholder="Masukan lokasi kegiatan" readonly=""></div><div class="form-group"><label class="custom-label">PENGGUNA JASA</label><input class="form-control input-custom" name="Pengguna_jasa[]" id="Pengguna_jasa'+ room +'" type="text" placeholder="Masukan pengguna jasa" readonly=""></div><div class="form-group"><label class="custom-label">NAMA PERUSAHAAN</label><input class="form-control input-custom" name="Nama_perusahaan[]" id="Nama_perusahaan'+ room +'" type="text" placeholder="Masukan nama perusahaan" readonly=""></div><div class="form-group"><label class="custom-label">URAIAN TUGAS</label><input class="form-control input-custom" name="Uraian_tugas[]" id="Uraian_tugas'+ room +'" type="text" placeholder="Masukan uraian tugas" readonly=""></div><div class="form-group"><label class="custom-label">WAKTU PELAKSANAAN</label><input class="form-control input-custom" name="Waktu_pelaksanaan[]" id="Waktu_pelaksanaan'+ room +'" type="text" placeholder="Masukan waktu penugasan" readonly=""></div><div class="form-group"><label class="custom-label">POSISI PENUGASAN</label><input class="form-control input-custom" name="Posisi_penugasan[]" id="Posisi_penugasan'+ room +'" type="text" onclick="modal_penugasan()" placeholder="Masukan posisi penugasan"><small class="form-control-feedback"></small></div><div class="form-group"><label class="custom-label">STATUS KEPEGAWAIAN PADA PERUSAHAAN</label><input class="form-control input-custom" name="Status_kepegawaian[]" id="Status_kepegawaian'+ room +'" type="text" placeholder="Masukan status kepegawaian pada perusahaan" readonly=""></div><div class="form-group"><label class="custom-label">SURAT REFERENSI DARI PENGGUNA JASA</label><input class="form-control input-custom" name="Surat_referensi[]" id="Surat_referensi'+ room +'" type="text" placeholder="Masukan surat referensi dari pengguna jasa" readonly=""></div></div></div></div></div>';

	objTo.appendChild(divtest)
}

function remove_education_fields(rid) {
	$('.removeclass' + rid).remove();
}