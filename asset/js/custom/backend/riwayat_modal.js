
function modal_riwayat(p1, modalType = 'first'){
    $('#modal-riwayat').modal('show');

    var form_filter = '#form-filter-riwayat';
    if(modalType === 'first'){
        $(form_filter+" [name=f-Search]").val('');
        Searchx         = '';
    }else{
        Searchx         = $(form_filter+" [name=f-Search]").val();
    }

    tg_data  = $(p1).data();
    
    data_post = {
        'search[value]' : Searchx,
        page : "riwayat",
        p1   : p1,
    }

    let table = $('#table-modal-riwayat').DataTable({
        "destroy": true,
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url"   : url_serverSide,
            "data"  : data_post,
            "type"  : "POST",
            dataSrc : function (json) {

              console.log("Table Modal Riwayat", json, table.page.info());
              let infoTable = table.page.info();  

              if(infoTable?.start <= 0){
                $('#table-modal-riwayat-pagination .pagination .prev-btn').attr('disabled', true);
              }else{
                $('#table-modal-riwayat-pagination .pagination .prev-btn').removeAttr('disabled');
              }

              if(json?.recordsFiltered <= infoTable?.length || json?.recordsFiltered === infoTable?.end ){
                $('#table-modal-riwayat-pagination .pagination .next-btn').attr('disabled', true);
              }else{
                $('#table-modal-riwayat-pagination .pagination .next-btn').removeAttr('disabled');
              }

              if(json?.data?.length > 0){
                $('#table-modal-riwayat-pagination .display-info').html(`<p>Menampilkan <b>${infoTable?.start + 1}</b> hingga <b>${infoTable?.end <= 0 ? json?.data?.length <= infoTable?.length ?  json?.data?.length : infoTable?.length : infoTable?.end}</b> dari <b>${json?.recordsFiltered}</b> entri</p>`);
                $('#table-modal-riwayat-pagination .pagination').removeClass('d-none');
                $('#table-modal-riwayat-pagination .pagination .curr-page').html(`${infoTable?.page + 1}`);
              }else{
                $('#table-modal-riwayat-pagination .display-info').empty();
                $('#table-modal-riwayat-pagination .pagination').addClass('d-none');
                $('#table-modal-riwayat-pagination .pagination .curr-page').empty();
              }

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

    $('#table-modal-riwayat_wrapper .dataTables_paginate, #table-modal-riwayat_wrapper .dataTables_info').hide();

    $('#table-modal-riwayat-pagination .pagination > .prev-btn').on('click', function(){
        table.page( 'previous' ).draw( 'page' );
    });

    $('#table-modal-riwayat-pagination .pagination > .next-btn').on('click', function(){
        table.page( 'next' ).draw( 'page' );
    });
}

$(document).ready(function() {

    var table = $('#table-modal-riwayat').DataTable();

    table.on("draw",function() {

        let form_filter = '#form-filter-riwayat';
        let keyword = $(form_filter+" [name=f-Search]").val();

        //var keyword = $('#table-modal-riwayat_filter > label:eq(0) > input').val();

        $('#table-modal-riwayat tbody').unmark();

        $('#table-modal-riwayat tbody').mark(keyword,{});
    });

});

riwayat = 0;

function choose_modal_riwayat(element){
    tg_data                     = $(element).data();
    p1                          = tg_data.p1;
    id                          = tg_data.id;
    name                        = tg_data.name;
    posisi                      = tg_data.posisi;
    personil                    = tg_data.personil;
    tanggal_lahir               = tg_data.tanggal_lahir;
    pendidikan                  = tg_data.pendidikan;
    pendidikan_non              = tg_data.pendidikan_non;

    console.log(tg_data);

    riwayat +=1;

    pendidikan = replaceAll('<div>'+ pendidikan,';','</div>'+'<div>');
    pendidikan_non = replaceAll('<div>'+ pendidikan_non,';','</div>'+'<div>');
    
    joss_id = $(p1).val();
    if(joss_id != posisi){   
        $('.Posisi').val();
        $('[name=BioID]').val();
        $('[name=Nama_perusahaan1]').val();
        $('[name=Nama_personil]').val();
        $('[name=Tempat_tanggal_lahir]').val();
        $('#Pendidikan1').summernote('code', );
        $('#Pendidikan_non_formal1').summernote('code', );
    }

    $(p1).val(posisi);
    $('.Posisi').val(posisi);
    $('[name=BioID]').val(id);
    $('[name=Nama_perusahaan1]').val(name);
    $('[name=Nama_personil]').val(personil);
    $('[name=Tempat_tanggal_lahir]').val(tanggal_lahir);
    $('#Pendidikan1').summernote('code', pendidikan);
    $('#Pendidikan_non_formal1').summernote('code', pendidikan_non);

    $('#modal-riwayat').modal('hide');
}


function stringToEl(string) {
    var parser = new DOMParser(),
        content = 'text/html',
        DOM = parser.parseFromString(string, content);

    return DOM.body.childNodes[0];
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}

