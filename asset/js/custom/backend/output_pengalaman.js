var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_list            = host + "output_pengalaman-list";
var url_list_uraian     = host + "output_pengalaman-list_uraian";
var url_edit            = host + "output_pengalaman-edit";
var url_edit_uraian     = host + "output_pengalaman-edit_uraian";
var url_delete          = host + "output_pengalaman-active";
var url_delete_all      = host + "output_pengalaman-active_all";
var url_delete_all2      = host + "output_pengalaman-active_all2";
var url_save            = host + "output_pengalaman-save";
var url_save_uraian     = host + "output_pengalaman-save-uraian";
var url_export          = host + "output_pengalaman-export";
var url_save_import     = host + "output_pengalaman-save-import";
$(document).ready(function() {
    filter_table();
    filter_table2();
    $("#v-form").hide();
    $("#form").hide();
});

$('.Uraian_pengalaman').summernote({
    toolbar:false,
    height: 150,
    displayReadonly:false,
    placeholder: 'Masukan uraian tugas dan akhiri dengan tanda  ; ',
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
    //datatables
    table = $('#table-list-uraian').DataTable({
        "searching": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "destroy":true,
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url"   : url_list_uraian,
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
    // Companyx    = $(form_filter+" [name=f-CompanyID]").val();
    Searchx     = $(form_filter+" [name=f-Search").val();

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
        Searchx         : Searchx,
        // Companyx        : Companyx,
    }
    //datatables
    table = $('#table-list-uraian').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "destroy":true,
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url"   : url_list_uraian,
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
        $('.checkbox.dt-id').prop('checked',true);
    }
    else{
        $('.checkbox.dt-id').prop('checked',false);
    }
})

$('#checkAll2').on('change',function(){
    if ($(this).is(':checked') ){
        $('.checkbox.dt-id2').prop('checked',true);
    }
    else{
        $('.checkbox.dt-id2').prop('checked',false);
    }
})

function hapus(){
    datas = [];

    $('.checkbox.dt-id').each(function(i,v){
        if ($(v).is(':checked')==true){
            datas.push($(v).attr('baris-id'));
        }
    })

    if (datas.length == 0){
       swal("Check at least 1 data !");
       return false;
   }

   console.log(datas)

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
                    console.log(datas)
                    if(data.status){
                        swal('',data.message, 'success');
                        filter_table();
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

    $('.checkbox.dt-id2').each(function(i,v){
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

// var index_dt;
// $("#table-list tbody").on('click','tr td:not(:first-child)',function(event){
//     index_dt = $(this).parent().index();
//     val = $('#table-list .dt-id').eq(index_dt).data();
//     short_click(val);
// });

var index_dt;
$("#table-list tbody").on('click','tr td:not(:first-child)',function(event){
    index_dt = $(this).parent().index();
    td = $(this).parent().children('td:first-child').children(':nth-child(2)').attr('id');
    val = {status:'1',id:td}
    short_click(val);
});

var index_dt2;
$("#table-list-uraian tbody").on('click','tr td:not(:first-child)',function(event){
    index_dt2 = $(this).parent().index();
    val = $('#table-list-uraian .dt-id').eq(index_dt2).data();
    short_click2(val);
});

// $("#table-list-uraian tbody").on('click','tr',function(event){
//     index_dt = $(this).index();
//     $('.action_list').removeClass('active');
//     $('#table-list-uraian tbody tr td .action_list').eq(index_dt).addClass("active");
//     event.stopPropagation();
// });

function action_edit(){
    val = $('#table-list .dt-id').eq(index_dt).data();
    short_click(val);
}

function action_edit2(){
    val = $('#table-list-uraian .dt-id').eq(index_dt).data();
    short_click2(val);
}

function action_view(){
    save_method = 'view';
    val = $('#table-list .dt-id').eq(index_dt).data();
    open_form('edit',val.id);
}

function action_view2(){
    save_method = 'view2';
    val = $('#table-list-uraian .dt-id').eq(index_dt).data();
    open_form('edit2',val.id);
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
                    // if(ck_count_save_file()>0){
                    //     upload_attachment_file(data.ID);
                    // }
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

no = 1;

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
    $("#posisi_uraian").hide();

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

            id_form  = '<h4 class="id-form v-form">ID FORM #'+p1+'</h4>';
            $('.id_form').append(id_form);

            if(save_method == 'view'){
                xform = '#form';
                $(xform)[0].reset();
                $(xform+' .form-control-feedback').text('');
                $(xform+' .has-danger').removeClass('has-danger');
                
                $('.form-view input').attr('disabled', true);
                $('.form-view input').attr('readonly', true);
                $('.form-view').removeClass('content-hide');

                $("#posisi_uraian").hide();
                $(".btn-simpan").hide();

            }

            if(data.status){
                dt_value = data.data;
                $(xform+' [name=crud]').val('update');
                $(xform+' [name=ID]').val(p1);

                $(xform+' [name=Nama_kegiatan]').val(dt_value.Nama_kegiatan);
                $(xform+' [name=Lokasi_kegiatan]').val(dt_value.Lokasi_kegiatan);
                $(xform+' [name=Pengguna_jasa]').val(dt_value.Pengguna_jasa);
                $(xform+' [name=Nama_perusahaan]').val(dt_value.Nama_perusahaan);
                $(xform+' [name=Waktu_pelaksanaan_mulai]').val(dt_value.Waktu_pelaksanaan_mulai);
                $(xform+' [name=Waktu_pelaksanaan_selesai]').val(dt_value.Waktu_pelaksanaan_selesai);

                // $.each(data.data_uraian, function(i, v) {
                //     data_uraian(v);
                //     if(save_method == 'view'){    
                //         xform = '#form';
                //         // $(xform)[0].reset();
                //         $(xform+' .form-control-feedback').text('');
                //         $(xform+' .has-danger').removeClass('has-danger');
                
                //         $('.form-view input').attr('disabled', true);
                //         $('.form-view input').attr('readonly', true);
                //         $('.form-view').removeClass('content-hide');

                //         $('#Uraian_pengalaman' + i).summernote("disable");

                //         $(".btn-simpan").hide();
                //     }
                // });
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

function edit_data2(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    xform = '#form';
    $(xform)[0].reset();
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');

    $("#v-form").hide();
    $("#form").show();
    $("#pengalaman_kerja").hide();

    data_post = {
        ID : p1,
        page_url        : dt_url,
        page_module     : dt_module,
    }
    $.ajax({
        url : url_edit_uraian,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);

            if(save_method == 'view2'){
                xform = '#form';
                // $(xform)[0].reset();
                $(xform+' .form-control-feedback').text('');
                $(xform+' .has-danger').removeClass('has-danger');
                
                $('.form-view input').attr('disabled', true);
                $('.form-view input').attr('readonly', true);
                $('.form-view').removeClass('content-hide');

                $('.Uraian_pengalaman').summernote("disable");
                $("#pengalaman_kerja").hide();
                $(".btn-simpan").hide();

            }

            if(data.status){
                dt_value = data.data;
                $(xform+' [name=crud]').val('update');
                $(xform+' [name=ID]').val(p1);

                $(xform+' [name=Posisi_penugasan]').val(dt_value.Posisi);
                $('.Uraian_pengalaman').summernote('code', dt_value.Uraian_tugas);

                // $.each(data.data_uraian, function(i, v) {
                //     data_uraian(v);
                if(save_method == 'view'){    
                    xform = '#form';
                        // $(xform)[0].reset();
                        $(xform+' .form-control-feedback').text('');
                        $(xform+' .has-danger').removeClass('has-danger');
                        
                        $('.form-view input').attr('disabled', true);
                        $('.form-view input').attr('readonly', true);
                        $('.form-view').removeClass('content-hide');

                        $('.Uraian_pengalaman').summernote("disable");

                        $(".btn-simpan").hide();
                    }
                // });
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

// let index_pengalaman = 1;

// function data_uraian(data){

//     index_pengalaman++;
//     Posisi          = "";
//     Uraian_tugas    = "";

//     if(data){
//         ID              = data.ID;
//         Posisi          = data.Posisi;
//         Uraian_tugas    = data.Uraian_tugas;
//     }

//     var objTo = document.getElementById('posisi_uraian')
// 	var divtest = document.createElement("div");
//     divtest.innerHTML =' <div class="card" id="posisi_uraian">\
//                 <div class="card-header bt-light-grey">\
//                     <div class="row">\
//                         <div class="col-md-6">\
//                             <h4 class="m-b-0 text-muted-bold">POSISI DAN URAIAN TUGAS</h4>\
//                         </div>\
//                         <div class="col-md-6">\
//                             <h4 class="m-b-0 pull-right">\
//                             <span class="pointer"><i class="ti-arrow-circle-up" style="font-weight:bold;font-size: x-large;"></i></span>\
//                             </h4>\
//                         </div>\
//                     </div>\
//                 </div>\
//                 <div class="card-body bg-card">\
//                     <input type="hidden" name="crud">\
//                     <input type="hidden" name="ID" value="'+ ID +'">\
//                     <input type="hidden" name="page_url">\
//                     <input type="hidden" name="page_module">\
//                     <input type="hidden" name="PengalamanID" id="PengalamanID1">\
//                     <div class="row">\
//                         <div class="col-md-8">\
//                             <div class="form-group">\
//                                 <label class="custom-label">POSISI PENUGASAN</label>\
//                                 <input class="form-control input-custom Posisi_penugasan'+ index_pengalaman +'" name="Posisi_penugasan" id="Posisi_penugasan'+ index_pengalaman +'" type="text" placeholder="Masukan posisi penugasan" value="'+ Posisi +'">\
//                                 <small class="form-control-feedback"></small>\
//                             </div>\
//                             <div class="form-group">\
//                                 <form method="post">\
//                                     <label class="custom-label-textarea">URAIAN TUGAS </label>\
//                                     <textarea class="Uraian_pengalaman'+ index_pengalaman +'" name="Uraian_pengalaman" id="Uraian_pengalaman'+ index_pengalaman +'"></textarea>\
//                                 </form>\
//                             </div>\
//                             <div class="boder" style="border: 2px dashed #000000;padding: 15px;">\
//                                 <span style="font-size: larger; font-weight: bold;color: red;"> Contoh 3 Point Uraian Tugas :</span><br>\
//                                 <span style="font-size: larger; font-weight: bold;color: black;font-style: italic;"> Sebagai penanggung jawab tertinggi pekerjaan manajemen konstruksi secara keceluruhan <span style="color:red; font-size:30px;"> ; </span> </span><br>\
//                                 <span style="font-size: larger; font-weight: bold;color: black;font-style: italic;"> Sebagai koordinator seluruh kegiatan teknis maupun administrasi di lapangan <span style="color:red; font-size:30px;"> ; </span></span><br>\
//                                 <span style="font-size: larger; font-weight: bold;color: black;font-style: italic;"> Sebagai pengkoordinir komunikasi antara PPK dengan penyedia jasa konstruksi <span style="color:red; font-size:30px;"> . </span></span>\
//                             </div>\
//                         </div>\
//                     </div>\
//                 </div>\
//                 <div class="card-button">\
//                     <div class="card-body">\
//                         <div class="button-group">\
//                             <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="batal()">BATAL</button>\
//                             <button type="button" class="btn waves-effect waves-light btn-custom btn-simpan" onclick="save_uraian('+"'"+ index_pengalaman +"'"+')">SIMPAN</button>\
//                         </div>\
//                     </div>\
//                 </div>\
//             </div>';


// 	objTo.appendChild(divtest)
//     $('.Uraian_pengalaman').summernote({
//         toolbar:false,
//         height: 150,
//         displayReadonly:false,
//         placeholder: 'Masukan uraian tugas',
//     });
//     $('#Uraian_pengalaman' + index_pengalaman).summernote('code','');
//     // $('#Uraian_pengalaman' + index_pengalaman).summernote("disable");
//     $('#Uraian_pengalaman' + index_pengalaman).summernote('code', Uraian_tugas);
// }

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
            }
            else
            {
                show_invalid_response(data);
                if(data.inputerror == "Uraian_pengalaman"){
                    swal({
                        title   : "Failed!",
                        text    : "Format uraian tugas tidak sesuai",
                        imageUrl: host+"/img/icon/image-83.png",
                        imageWidth: 600,
                        imageHeight: 600,
                        confirmButtonText: 'Try Again',
                    });
                }
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
