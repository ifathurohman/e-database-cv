var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/e-database-cv/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_save    = host + "menu-shorting-save";

function save(p1){
    xform = '#form';
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');
    // proccess_save();

    add_data_page(xform);
    // ajax adding data to database
    $.ajax({
        url : url_save,
        type: "POST",
        data: $(xform).serialize(),
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            if(data.status) //if success close modal and reload ajax table
            {   
                swal({
                    title: "",
                    text: data.message,
                    type: "success",
                }, function() {
                    location.reload();
                });
            }
            else
            {
                show_invalid_response(data);
            }
            // end_save();
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
            // end_save();
        }
    });
}