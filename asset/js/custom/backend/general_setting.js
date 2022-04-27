var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+"/";
var url         = window.location.href;
var page_name;
var url;
var page_settings;
$(document).ready(function() {
    data_page          = $(".data-page, .page-data").data();
    page_name          = data_page.page_name;
    url                = data_page.url;
    page_settings      = data_page.page;
    $('.'+page_settings+"-nav-link").addClass("active");
    get_setting(page_settings);
    $('.summernote').summernote('code', '');
});

function reset_form(element){
    dt       = $(element).data();
    page   = dt.page;
    $('#'+page)[0].reset();
    img_preview("reset");
}
function get_setting(page,id){
    if(page == "edit_slideshow"){
        url     = host + "api/slideshow/edit/"+id;
        form    = $('#slideshow')[0];
        $('#slideshow')[0].reset();
    } else {
        url     = host + "api/get_setting/"+page;
        form    = $('#'+page_settings)[0];
    }
    var formData    = new FormData(form);
    // var value       = 'asemmmmmmmmmmmmmmmmmmmmmm';
    $.ajax({
        url : url,
        type: "POST",
        data:  formData,
        mimeType:"multipart/form-data", // upload
        contentType: false, // upload
        cache: false, // upload
        processData:false, //upload
        dataType: "JSON",
        success: function(data)
        {            
            show_console(data);
            if(page == 'slideshow'){
                $.each(data.ListData,function(i,v){
                    add_slideshow_item(v);
                });
            } else if(jQuery.inArray(page, ['term-and-condition','policy-page-setting']) !== -1){               
                $.each(data.ListData,function(k,v){
                    $('[name='+v.Name+']').summernote('code', v.Value);
                });
            } else {            
                $.each(data.ListData,function(i,v){
                    value = host+v.Value;
                    if(v.Name == 'SiteLogo'){
                        $(".dropify-render img").remove();
                        img = '<img src="'+value+'" />';
                        $(".dropify-render").append(img);
                        $(".dropify-preview").show();
                    }else{
                        $('[name='+v.Name+']').val(v.Value);
                    }
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown){
            console.log(jqXHR.responseText);
        }
    });
}

function save_setting(element)
{
    $(element).button('loading');
    dt      = $(element).data();
    page   = dt.page;

    if(page == 'general'){
        var file = $('[name=SiteLogo]')[0].files[0];
        if(file && file.size > 5000000) { //2 MB (this size is in bytes)
            $(element).button("reset");
            toastr.error('Image size too big, size maximum is 500kb',"Information");
            return;
        }
    }

    url             = host + "api/save_setting/"+page;
    // Description     = $('.summernote').summernote('code');
    var form        = $('#'+page_settings)[0]; // You need to use standard javascript object here
    var formData    = new FormData(form);
    // formData.append("Description", Description);
    proccess_save();
    $.ajax({
        url : url,
        type: "POST",
        data:  formData,
        mimeType:"multipart/form-data", // upload
        contentType: false, // upload
        cache: false, // upload
        processData:false, //upload
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            if(data.Status){
                swal("Info","saving data success","");
                if(data.Modul == "slideshow"){
                    $(".list-data-slideshow").empty();
                    $('#'+page)[0].reset();
                    img_preview("reset");
                    get_setting(page);
                }
            } else {
                if(data.message){
                    swal("Info",data.message,"warning");
                }
            }
            end_save();
            $(element).button('reset');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            // alert('Error adding / update data');
            swal("Info","saving data failed","warning");
            $(element).button('reset');
            console.log(jqXHR.responseText);
        }
    });

}
