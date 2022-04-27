// function edit_data(){
//     page_data   = $(".page-data").data();
//     dt_url      = page_data.url;
//     dt_module   = page_data.module;

//     data_post = {
//         ID : p1.id,
//         page_url        : dt_url,
//         page_module     : dt_module,
//         data_data       : dt_value,
//     }

//     $('.v_page .data').hide();

//     $.redirect(host+'policy-page-setting-edit',data_post,"POST");
// }
$('.v_term').hide(300);

function check_type(p1){
    if(p1 == 1){
        $('.v_page').show(300);
        $('.v_term').hide(300);
    }else{
        $('.v_term').show(300);
        $('.v_page').hide(300);
    }
}

$('#Type').on('change', function(){
    value = this.value;
    check_type(value);
});


function edit_data(p1){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    xform = '#form';
    $(xform)[0].reset();
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    data_post = {
        ID : p1,
        page_url        : dt_url,
        page_module     : dt_module,
    }
    $.ajax({
        url : host+'policy-page-setting-edit',
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            if(data.status){
                dt_value = data.data;
                $(xform+' [name=crud]').val('update');
                $(xform+' [name=ID]').val(p1);
                $(xform+' [name=Name]').val(dt_value.Name);
                $(xform+' [name=Type]').val(dt_value.Type);
                $(xform+' [name=Status]').val(dt_value.Status);
                $(xform+' [name=Summary]').val(dt_value.Summary);
                
                if(dt_value.Type == 1){
                    $('.v_page').show(300);
                    $('.v_term').hide(300);
                }else{
                    $('.v_term').show(300);
                    $('.v_page').hide(300);
                }
            }else{
                open_form('close');
                show_invalid_response(data);
            }
            $("[name=Description]").summernote("ID", dt_value.Description);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
        }
    });
}

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
        url : host+"policy_page_setting_save",
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
                swal('',data.message,'success');
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

