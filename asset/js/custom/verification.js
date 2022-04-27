var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
var host        = window.location.origin + '/';
var url_string  = window.location.href;

$(document).ready(function() {
  
});

$(function() {
    $(".preloader").fadeOut();
});
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
});

$('.btn-verification').click(function(){
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty();
    proccess_save();
    url = host+"api/verification";
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            if(data.status) //if success close modal and reload ajax table
            {
                swal({
                    title   : "Akun Anda Telah Aktif",
                    html    : true,
                    text    : "Anda Dapat Melakukan Login Sekarang",
                    imageUrl: url_string+"/img/icon/image-84.png",
                    imageWidth: 600,
                    imageHeight: 600,
                    confirmButtonText: 'Sign In',
                }, function() {
                    window.location = data.url;
                });
            }
            else
            {
                swal('',data.message,'warning');
            }
            end_save('btn-verification','Reset');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
        }
    });
});

function proccess_save(){
    $('.btn-save, .btn-save-recover').button('loading');
    $('.btn-save, .btn-save-recover').text('Loading');
    $('button').attr('disabled', true);
}

function end_save(p1,p2){
    $('.btn-save, .btn-save-recover').button('reset');
    $('.'+p2).text(p1);
    $('button').attr('disabled', false);    
}
