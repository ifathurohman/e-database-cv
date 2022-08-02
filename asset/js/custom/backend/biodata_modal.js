function modal_biodata(p1){
    $('#modal-biodata').modal('show');
    tg_data  = $(p1).data();
    
    data_post = {
        page : "biodata",
        p1   : p1,
    }

    $('#table-modal-biodata').DataTable({
        "destroy": true,
        "searching": true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url"   : url_serverSide,
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

function choose_modal_biodata(element){
    tg_data                 = $(element).data();
    p1                      = tg_data.p1;       
    id                      = tg_data.id;
    personil                = tg_data.personil; 
    tempat_tanggal_lahir    = tg_data.tempat_tanggal_lahir;
    pendidikan              = tg_data.pendidikan;
    pendidikan_non          = tg_data.pendidikan_non;
    nomor_hp                = tg_data.nomor_hp;
    email                   = tg_data.email;

    console.log(tg_data);

    clear_id = $(p1).val();
    if(clear_id != personil){   
        $('.Nama_personil').val();
        $('[name=ID]').val();
    }

    $(p1).val(personil);
    $('.Nama_personil').val(personil);
    $('[name=ID]').val(id);

    $('#modal-biodata').modal('hide');
}
