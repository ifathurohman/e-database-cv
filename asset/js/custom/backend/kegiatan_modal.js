function modal_pengalaman(p1, modalType = 'first'){
    let modalTypeNumber = p1.substring(14);

    modalTypeNumber = modalTypeNumber == 1 ? '' : modalTypeNumber;

    $('#modal-pengalaman').modal('show');
    $('#modal-pengalaman').attr('data-modal-id', p1);
    $('.pengalaman-kerja-type').text('PENGALAMAN KERJA ' + modalTypeNumber);

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
        page            : "pengalaman",
        p1              : p1,
    }

    let table = $('#table-modal-pengalaman').DataTable({
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
                $('#table-modal-pengalaman-pagination .pagination .prev-btn').attr('disabled', true);
              }else{
                $('#table-modal-pengalaman-pagination .pagination .prev-btn').removeAttr('disabled');
              }

              if(json?.recordsFiltered <= infoTable?.length || json?.recordsFiltered === infoTable?.end ){
                $('#table-modal-pengalaman-pagination .pagination .next-btn').attr('disabled', true);
              }else{
                $('#table-modal-pengalaman-pagination .pagination .next-btn').removeAttr('disabled');
              }

              if(json?.data?.length > 0){
                $('#table-modal-pengalaman-pagination .display-info').html(`<p>Menampilkan <b>${infoTable?.start + 1}</b> hingga <b>${infoTable?.end <= 0 ? json?.data?.length <= infoTable?.length ?  json?.data?.length : infoTable?.length : infoTable?.end}</b> dari <b>${json?.recordsFiltered}</b> entri</p>`);
                $('#table-modal-pengalaman-pagination .pagination').removeClass('d-none');
                $('#table-modal-pengalaman-pagination .pagination .curr-page').html(`${infoTable?.page + 1}`);
              }else{
                $('#table-modal-pengalaman-pagination .display-info').empty();
                $('#table-modal-pengalaman-pagination .pagination').addClass('d-none');
                $('#table-modal-pengalaman-pagination .pagination .curr-page').empty();
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

    $('#table-modal-pengalaman_wrapper .dataTables_paginate, #table-modal-pengalaman_wrapper .dataTables_info').hide();

    $('#table-modal-pengalaman-pagination .pagination > .prev-btn').on('click', function(){
        table.page( 'previous' ).draw( 'page' );
    });

    $('#table-modal-pengalaman-pagination .pagination > .next-btn').on('click', function(){
        table.page( 'next' ).draw( 'page' );
    });
}

function modal_pengalaman_filter(e){
    let modalId = $(e.target).parents('#modal-pengalaman').attr('data-modal-id');
    console.log('MODAL KEGIATAN FILTER ID', modalId);
    modal_pengalaman(modalId, 'filter');
}

$(document).ready(function() {

    let table = $('#table-modal-pengalaman').DataTable();

    table.on("draw",function() {
        let form_filter = '#form-filter-pengalaman';
        let keyword = $(form_filter+" [name=f-Search]").val();

        //let keyword = $('#table-modal-pengalaman_filter > label:eq(0) > input').val();

        $('#table-modal-pengalaman tbody').unmark();

        $('#table-modal-pengalaman tbody').mark(keyword,{});
    });

});

function choose_modal_pengalaman(element){
    tg_data             = $(element).data();
    p1                  = tg_data.p1;       
    id                  = tg_data.id;
    pel_id              = tg_data.pel_id;
    nama_kegiatan       = tg_data.nama_kegiatan; 
    lokasi_kegiatan     = tg_data.lokasi_kegiatan;
    pengguna            = tg_data.pengguna;
    nama_perusahaan     = tg_data.nama_perusahaan;
    uraian_tugas        = tg_data.uraian_tugas;
    waktu_pelaksanaan   = tg_data.waktu_pelaksanaan;
    posisi_penugasan    = tg_data.posisi_penugasan;
    
    console.log('Pengalaman TG Data', tg_data);
    
    var str = p1;
    var res = str.substring(14);

    console.log(res);
    
    last_id = $(p1).val();
    if(last_id != nama_kegiatan){   
        $('#Nama_kegiatan' + res).val();
        $('#PengalamanID' + res).val();
        $('#Lokasi_kegiatan' + res).val();
        $('#Pengguna_jasa' + res).val();
        $('#Nama_perusahaan' + res).val();
        $('#Waktu_pelaksanaan' + res).val();
    }
    
    $(p1).val(nama_kegiatan);
    $('#Nama_kegiatan' + res).val(nama_kegiatan);
    $('#PengalamanID' + res).val(pel_id);
    $('#Lokasi_kegiatan' + res).val(lokasi_kegiatan);
    $('#Pengguna_jasa' + res).val(pengguna);
    $('#Nama_perusahaan' + res).val(nama_perusahaan);
    $('#Waktu_pelaksanaan' + res).val(waktu_pelaksanaan);

    $('#modal-pengalaman').modal('hide');
}
