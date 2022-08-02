
function modal_company(p1){
    $('#modal-company').modal('show');

    tg_data = $(p1).data();
    type    = '';
    if(tg_data){
        if(tg_data.type){type = tg_data.type;}
    }

    data_post = {
        page : "company",
        p1   : p1,
        type : type,
    }

    show_console(data_post);
    $('#table-modal-company').DataTable({
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

function choose_modal_company(element){
    tg_data = $(element).data();
    p1      = tg_data.p1;
    id      = tg_data.id;
    name    = tg_data.name;

    last_id = $(p1).val();

    if(last_id != id){
        $('.User').val('');
        $('.User-Name').val('');
    }

    $(p1).val(id);
    $(p1+'-Name').val(name);

    $('#modal-company').modal('hide');
}