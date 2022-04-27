
function modal_role(p1){
    $('#modal-role').modal('show');
    tg_data  = $(p1).data();
    company  = "";
    if(tg_data.company){
        company = tg_data.company;
    }
    data_post = {
        page : "role",
        p1   : p1,
        company     : company,
        company_id  : $('.Company').val(),
    }

    $('#table-modal-role').DataTable({
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

function choose_modal_role(element){
    tg_data = $(element).data();
    p1      = tg_data.p1;
    id      = tg_data.id;
    name    = tg_data.name;

    $(p1).val(id);
    $(p1+'-Name').val(name);

    $('#modal-role').modal('hide');
}