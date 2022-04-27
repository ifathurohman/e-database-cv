
function modal_user_company(p1){
    $('#modal-user-company').modal('show');
    tg_data  = $(p1).data();
    company  = "";
    user     = "";
    role     = "";
    role_id  = "";
    CompanyID = $('.Company').val();
    if(tg_data.company){
        company = tg_data.company;
    }
    if(tg_data.user){
        user = tg_data.user;
    }
    if(tg_data.company_class){
        CompanyID = $(tg_data.company_class).val();
    }
    if(tg_data.role){
        role = tg_data.role;
        if(role == 'active'){
            role_id = $('.'+tg_data.role_class).val();
        }
    }
    data_post = {
        page : "user_company",
        p1   : p1,
        company     : company,
        company_id  : CompanyID,
        user        : user,
        role        : role,
        role_id     : role_id,
        user_id     : $('#form [name=ID]').val(),
    }
    show_console(data_post);
    $('#table-modal-user-company').DataTable({
        "destroy": true,
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "language" : {
            "infoFiltered" : "",
        },
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

function choose_modal_user_company(element){
    tg_data = $(element).data();
    p1      = tg_data.p1;
    id      = tg_data.id;
    name    = tg_data.name;

    $(p1).val(id);
    $(p1+'-Name').val(name);

    $('#modal-user-company').modal('hide');
}