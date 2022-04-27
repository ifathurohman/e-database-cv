function modal_penugasan(p1, modalType = 'first'){
    let modalTypeNumber = p1.substring(17);

    modalTypeNumber = modalTypeNumber == 1 ? '' : modalTypeNumber;

    $('#modal-penugasan').modal('show');
    $('#modal-penugasan').attr('data-modal-id', p1);
    $('.penugasan-kerja-type').text('PENGALAMAN KERJA ' + modalTypeNumber);

    var form_filter = '#form-filter-penugasan';
    if(modalType === 'first'){
        $(form_filter+" [name=f-Search]").val('');
        Searchx         = '';
    }else{
        Searchx         = $(form_filter+" [name=f-Search]").val();
    }

    tg_data  = $(p1).data();
    f_search = $('.f-Search').val();
    data_post = {
        'search[value]' : Searchx,
        page        : "penugasan",
        f_search    : f_search,
        p1          : p1,
    }

    let table = $('#table-modal-penugasan').DataTable({
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
                 console.log("Table Modal Penugasan", json, table.page.info());
              let infoTable = table.page.info();  

              if(infoTable?.start <= 0){
                $('#table-modal-penugasan-pagination .pagination .prev-btn').attr('disabled', true);
              }else{
                $('#table-modal-penugasan-pagination .pagination .prev-btn').removeAttr('disabled');
              }

              if(json?.recordsFiltered <= infoTable?.length || json?.recordsFiltered === infoTable?.end ){
                $('#table-modal-penugasan-pagination .pagination .next-btn').attr('disabled', true);
              }else{
                $('#table-modal-penugasan-pagination .pagination .next-btn').removeAttr('disabled');
              }

              if(json?.data?.length > 0){
                $('#table-modal-penugasan-pagination .display-info').html(`<p>Menampilkan <b>${infoTable?.start + 1}</b> hingga <b>${infoTable?.end <= 0 ? json?.data?.length <= infoTable?.length ?  json?.data?.length : infoTable?.length : infoTable?.end}</b> dari <b>${json?.recordsFiltered}</b> entri</p>`);
                $('#table-modal-penugasan-pagination .pagination').removeClass('d-none');
                $('#table-modal-penugasan-pagination .pagination .curr-page').html(`${infoTable?.page + 1}`);
              }else{
                $('#table-modal-penugasan-pagination .display-info').empty();
                $('#table-modal-penugasan-pagination .pagination').addClass('d-none');
                $('#table-modal-penugasan-pagination .pagination .curr-page').empty();
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
        mark: true
    });

    $('#table-modal-penugasan_wrapper .dataTables_paginate, #table-modal-penugasan_wrapper .dataTables_info').hide();

    $('#table-modal-penugasan-pagination .pagination > .prev-btn').on('click', function(){
        table.page( 'previous' ).draw( 'page' );
    });

    $('#table-modal-penugasan-pagination .pagination > .next-btn').on('click', function(){
        table.page( 'next' ).draw( 'page' );
    });

}

function modal_penugasan_filter(e){
    let modalId = $(e.target).parents('#modal-penugasan').attr('data-modal-id');
    console.log('MODAL PENUGASAN FILTER ID', modalId);
    modal_penugasan(modalId, 'filter');
}

$(document).ready(function() {

    var table = $('#table-modal-penugasan').DataTable();

    table.on("draw",function() {

        let form_filter = '#form-filter-penugasan';
        let keyword = $(form_filter+" [name=f-Search]").val();

        //var keyword = $('#table-modal-penugasan_filter > label:eq(0) > input').val();

        $('#table-modal-penugasan tbody').unmark();

        $('#table-modal-penugasan tbody').mark(keyword,{});
    });

});

function choose_modal_penugasan(element){
    tg_data             = $(element).data();
    p1                  = tg_data.p1;       
    id                  = tg_data.id;
    posisi_penugasan    = tg_data.posisi_penugasan; 
    uraian_tugas        = tg_data.uraian_tugas;

    console.log(tg_data);

    var str = p1;
    var res = str.substring(17);
    
    // uraian_tugas = replaceAll('<div>'+ uraian_tugas,';','</div>'+'<div>');
    
    clear_id = $(p1).val();
    if(clear_id != posisi_penugasan){   
        $('#Posisi_penugasan' + res).val();
        $('#Uraian_tugas' + res).val();
    }

    $(p1).val(posisi_penugasan);
    $('#Posisi_penugasan' + res).val(posisi_penugasan);
    $('#Uraian_tugas' + res).summernote('code', uraian_tugas);

    $('#modal-penugasan').modal('hide');
}
