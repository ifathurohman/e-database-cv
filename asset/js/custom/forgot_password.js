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

$('.btn-save-recover').click(function(){
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty();
    proccess_save();
    url = host+"api/forgot_password_save";
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
                    title   : "Your password is recovered",
                    html    : true,
                    text    : "Please don't forget and remember your <br> password",
                    imageUrl: url_string+"/img/icon/image-84.png",
                    imageWidth: 600,
                    imageHeight: 600,
                });
            }
            else
            {
                swal('',data.message,'warning');
            }
            end_save('btn-save-recover','Reset');
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

// ============================================================== 
// Login and Recover Password 
// ==============================================================

// $("#registerform").slideUp();
// $('#img-reg').hide();
// $('#img-for').hide();

$('#to-register').click(function() {
    $('#img-reg').fadeIn();
    $('#img-log').hide();
});

$('#to-recover').click(function() {
    $('#img-reg').hide();
    $('#img-log').hide();
    $('#img-for').fadeIn();
})

if($('div').hasClass('show_password')){
    $('.show_password').on('click',function(){
        check_show_password(this);
    });
}

function check_show_password(p1){
	tg_data = $(p1).data();
	if(tg_data.status){
		$(p1).prev().attr('type', 'password');
		$(p1).find('.btn-icon').removeClass('fa-eye-slash');
		$(p1).find('.btn-icon').addClass('fa-eye');
		$(p1).data('status','');
	}else{
		$(p1).prev().attr('type', 'text');
		$(p1).find('.btn-icon').removeClass('fa-eye');
		$(p1).find('.btn-icon').addClass('fa-eye-slash');
		$(p1).data('status','1');
	}
}