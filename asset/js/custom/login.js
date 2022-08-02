var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
var host        = window.location.origin + '/';
var url_string  = window.location.origin + '/';

$(document).ready(function() {
  
});

$('.btn-save').click(function(){
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty();
    proccess_save();
    url = url_string+"api/login";
    $.ajax({
        url : url,
        type: "POST",
        data: $('#loginform').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            if(data.status) //if success close modal and reload ajax table
            {
                swal({
                    title   : "Login Success!",
                    html    : true,
                    text    : "Wait a moments, you will be redirected,<br>to the dashboard",
                    imageUrl: url_string+"/img/icon/image-84.png",
                    imageWidth: 600,
                    imageHeight: 600,
                }, function() {
                    window.location = data.url;
                });
                end_save();
            }
            else
            {
                swal({
                    title   : "Login Failed!",
                    html    : true,
                    text    : "The account you entered was not found,<br> please try again!",
                    imageUrl: url_string+"/img/icon/image-83.png",
                    imageWidth: 600,
                    imageHeight: 600,
                    confirmButtonText: 'Try Again',
                });
            }
            end_save('btn-save','Login');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
        }
    });
});

$('.btn-save-register').click(function(){
    xform = '#registerform';
    $(xform+' .form-control-feedback').text('');
    $(xform+' .has-danger').removeClass('has-danger');
    $(xform+' .select2-has-danger').removeClass('select2-has-danger');
    proccess_save();
    url = url_string+"api/register";
    $.ajax({
        url : url,
        type: "POST",
        data: $('#registerform').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            if(data.status) //if success close modal and reload ajax table
            {
                swal({
                    title   : "Registered !",
                    html    : true,
                    text    : "Please check your email, for verification",
                    imageUrl: url_string+"/img/icon/image-84.png",
                    imageWidth: 600,
                    imageHeight: 600,
                    confirmButtonText: 'Sign In',
                }, function() {
                    window.location = data.url;
                });
                end_save();
            }
            else
            {
                show_invalid_response(data);
            }
            end_save('btn-save-register','Sign Up');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
        }
    });
});

$(function() {
    $(".preloader").fadeOut();
});
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
});
// ============================================================== 
// Login and Recover Password 
// ==============================================================

$("#registerform").slideUp();
$('#img-reg').hide();
$('#img-for').hide();

$('#to-register').click(function() {
    $('#img-reg').fadeIn();
    $('#img-log').hide();
});

$('#to-recover').click(function() {
    $('#img-reg').hide();
    $('#img-log').hide();
    $('#img-for').fadeIn();
});

var form_type = 1;
$('#to-register').on("click", function() {
    $("#loginform").slideUp();
    $("#registerform").fadeIn();
    form_type = 3;
});
$('#to-recover').on("click", function() {
    $("#loginform").slideUp();
    $("#recoverform").fadeIn();
    form_type = 2;
});
$('#to-login').on("click", function() {
    $("#loginform").fadeIn();
    $("#recoverform").slideUp();
    form_type = 1;
});

$('.btn-save-recover').click(function(){
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty();
    proccess_save();
    url = url_string+"api/forgot_password";
    $.ajax({
        url : url,
        type: "POST",
        data: $('#recoverform').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            console.log(data);
            if(data.status) //if success close modal and reload ajax table
            {
                swal({
                    title   : "Sent!",
                    html    : true,
                    text    : "Please check your email <br> for verification",
                    imageUrl: url_string+"/img/icon/image-85.png",
                    imageWidth: 600,
                    imageHeight: 600,
                }, function() {
                    window.location = host;
                });

                $('#recoverform')[0].reset();
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

$('#recoverform, #loginform').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    if(form_type == 1){
        $('.btn-save').click();
    }else{
        $('.btn-save-recover').click();
    }
    return false;
  }
});

function proccess_save(){
    $('.btn-save, .btn-save-recover, .btn-save-register').button('loading');
    $('.btn-save, .btn-save-recover, .btn-save-register').text('Loading');
    $('button').attr('disabled', true);
}

function end_save(p1,p2){
    $('.btn-save, .btn-save-recover, .btn-save-register').button('reset');
    $('.btn-save').text('Login');
    $('.btn-save-register').text('Sign Up');
    $('.btn-save-recover').text('Send Instructions');
    $('button').attr('disabled', false);    
}

$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    input = $(this).parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

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

function show_invalid_response(data){
	if(data.session){
        session_expired(data.url);
    }else{
        swal('',data.message,'warning');
        if(data.inputerror){
        	for (var i = 0; i < data.inputerror.length; i++)
	        {
	            input_type = data.input_type[i];
	            if(input_type == "select2"){
	                $('.'+data.inputerror[i]+'-view').addClass('select2-has-danger');
	                $('.'+data.inputerror[i]+'-view .form-control-feedback').text(data.error_string[i]);
	            }else if(input_type == "input_group"){
	            	$('.'+data.inputerror[i]+'-view').addClass('has-danger');
	            	$('.'+data.inputerror[i]+'-view .form-control-feedback').text(data.error_string[i]);
	            }else if(input_type == 'array_group'){
	            	$('.'+data.inputerror[i]).eq(data.error_string[i]).addClass('border-red-validate');
	            }else if(input_type == 'input_select'){
	            	$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-danger');
	            	$('.'+data.inputerror[i]+'-view .form-control-feedback').text(data.error_string[i]);
	            }else{
	                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-danger');
	                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
	            }
	        }
        }
    }
}