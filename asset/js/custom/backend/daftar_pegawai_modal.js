function modal_daftar_pegawai(p1, modalType = 'first'){
    let modalTypeNumber = p1.substring(14);

    modalTypeNumber = modalTypeNumber == 1 ? '' : modalTypeNumber;

    $('#modal-daftar-pegawai').modal('show');
    $('#modal-daftar-pegawai').attr('data-modal-id', p1);

    var form_filter = '#form-filter-pengalaman';
    if(modalType === 'first'){
        $(form_filter+" [name=f-Search]").val('');
        Searchx         = '';
    }else{
        Searchx         = $(form_filter+" [name=f-Search]").val();
    }

    tg_data     = $(p1).data();
    data_post   = {
        'search[value]' : Searchx,
        page            : "non_pt",
        p1              : p1,
    }

    let table = $('#table-modal-daftar-pegawai').DataTable({
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
                console.log("Table Modal Pengalaman / Kegiatan", json, table.page.info());
              let infoTable = table.page.info();  

              if(infoTable?.start <= 0){
                $('#table-modal-daftar-pegawai-pagination .pagination .prev-btn').attr('disabled', true);
              }else{
                $('#table-modal-daftar-pegawai-pagination .pagination .prev-btn').removeAttr('disabled');
              }

              if(json?.recordsFiltered <= infoTable?.length || json?.recordsFiltered === infoTable?.end ){
                $('#table-modal-daftar-pegawai-pagination .pagination .next-btn').attr('disabled', true);
              }else{
                $('#table-modal-daftar-pegawai-pagination .pagination .next-btn').removeAttr('disabled');
              }

              if(json?.data?.length > 0){
                $('#table-modal-daftar-pegawai-pagination .display-info').html(`<p>Menampilkan <b>${infoTable?.start + 1}</b> hingga <b>${infoTable?.end <= 0 ? json?.data?.length <= infoTable?.length ?  json?.data?.length : infoTable?.length : infoTable?.end}</b> dari <b>${json?.recordsFiltered}</b> entri</p>`);
                $('#table-modal-daftar-pegawai-pagination .pagination').removeClass('d-none');
                $('#table-modal-daftar-pegawai-pagination .pagination .curr-page').html(`${infoTable?.page + 1}`);
              }else{
                $('#table-modal-daftar-pegawai-pagination .display-info').empty();
                $('#table-modal-daftar-pegawai-pagination .pagination').addClass('d-none');
                $('#table-modal-daftar-pegawai-pagination .pagination .curr-page').empty();
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

    // $('#table-modal-daftar-pegawai_wrapper .dataTables_paginate, #table-modal-daftar-pegawai_wrapper .dataTables_info').hide();

    $('#table-modal-daftar-pegawai-pagination .pagination > .prev-btn').on('click', function(){
        table.page( 'previous' ).draw( 'page' );
    });

    $('#table-modal-daftar-pegawai-pagination .pagination > .next-btn').on('click', function(){
        table.page( 'next' ).draw( 'page' );
    });
}

function modal_daftar_pegawai_filter(e){
    let modalId = $(e.target).parents('#modal-daftar-pegawai').attr('data-modal-id');
    console.log('MODAL PEGAWAI FILTER ID', modalId);
    modal_daftar_pegawai(modalId, 'filter');
}

$(document).ready(function() {

    let table = $('#table-modal-daftar-pegawai').DataTable();

    table.on("draw",function() {
        let form_filter = '#form-filter-pengalaman';
        let keyword = $(form_filter+" [name=f-Search]").val();

        //let keyword = $('#table-modal-daftar-pegawai_filter > label:eq(0) > input').val();

        $('#table-modal-daftar-pegawai tbody').unmark();

        $('#table-modal-daftar-pegawai tbody').mark(keyword,{});
    });

});

function choose_modal_non_pt(element){
    tg_data                 = $(element).data();
    p1                      = tg_data.p1;       
    id                      = tg_data.id;
    nama                    = tg_data.nama; 
    nama_perusahaan         = tg_data.nama_perusahaan; 
    status_pegawai          = tg_data.status_pegawai; 
    proyek                  = tg_data.proyek; 
    periode_proyek_mulai    = tg_data.periode_proyek_mulai; 
    periode_proyek_selesai  = tg_data.periode_proyek_selesai; 

    console.log(tg_data);

    last_id = $(p1).val();
    if(last_id != nama){   
        $('.Nama').val();
        $('[name=ID]').val(id);
    }
    
    $(p1).val(nama);
    $('.Nama').val(nama);
    $('[name=ID]').val(id);
    $('[name=Nama_perusahaan]').val(nama_perusahaan);
    $('[name=Proyek]').val(proyek);
    $('[name=Peride_proyek_mulai]').val(periode_proyek_mulai);
    $('[name=Peride_proyek_selesai]').val(periode_proyek_selesai);

    if(status_pegawai == "Tersedia"){
        $('#tersedia').prop('checked', true);
    }else if(status_pegawai == "Tender"){
        $('#tender').prop('checked', true);
    }else if(status_pegawai == "Terkontrak"){
        $('#terkontrak').prop('checked', true);
    }

    $('#modal-daftar-pegawai').modal('hide');
}
