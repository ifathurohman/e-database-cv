var mobile 		= (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host 		= window.location.origin+'/';
var url_page 	= window.location.href;
var url_serverSide  = host+"api/serverSide";
var time_long_click = 1000;
var img_default = host+"img/image_default.png";
$(document).ready(function() {
    plugin();
    CheckTheme();

    $('.btn-card-collapse').on('click', function(){
      $(this).parents('.collapsed-card').find('.collapsed-target ').toggleClass('collapsed');
      $(this).toggleClass('collapsing');
    });
});


function plugin(){
	if($('span').hasClass('wajib')){
		$('span.wajib').addClass('rd-color').text('*');
	}

	 if ($("input,textarea").hasClass("summernote")) {
	    summernote_init();
	 }

	if($('div').hasClass('show_password')){
		$('.show_password').on('click',function(){
			check_show_password(this);
		});
	}


	if($('input').hasClass('time-format')){
		$('.time-format').formatter({'pattern': '{{99}}:{{99}}', });
	}

	if($('input').hasClass('date-format')){
		$('.date-format').formatter({'pattern': '{{9999}}-{{99}}-{{99}}', });
	}

	if($('input').hasClass('datetime-format')){
		$('.datetime-format').formatter({'pattern' : '{{9999}}-{{99}}-{{99}} {{99}}:{{99}}',})
	}

	$( ".v-themes" ).click(function() {
	  SetThemes(this);
	});
}



function open_form(p1,p2){
	$('html, body').animate({
		scrollTop : $('.page-data').offset().top - 100
	}, 'fast');
	if(p1 == 'close'){
		$('.form-view, .form-import').hide(300);
		$('.list-view').show(300);
	}else if(p1 == 'edit'){
		$('.form-view input').attr('disabled', false);
		$('.form-view').removeClass('content-hide');
		$('.form-view .pg-title').text('Edit Data');
		$('.form-view').show(300);
		$('.list-view, .form-import').hide(300);
		$('.v-Save').show();
		$('.v-Approved').hide();
		edit_data(p2);
	}else if(p1 == 'edit2'){
		$('.form-view input').attr('disabled', false);
		$('.form-view').removeClass('content-hide');
		$('.form-view .pg-title').text('Edit Data');
		$('.form-view').show(300);
		$('.list-view, .form-import').hide(300);
		$('.v-Save').show();
		$('.v-Approved').hide();
		edit_data2(p2);
	}else if(p1 == 'view'){
		$('.form-view input').attr('disabled', true);
		$('.form-view').removeClass('content-hide');
		$('.form-view .pg-title').text('View Data');
		$('.form-view').show(300);
		$('.list-view, .form-import').hide(300);
		$('.v-Save').hide();
		$('.v-Approved').show();
		edit_data(p2);
	}else if(p1 == 'view2'){
		$('.form-view input').attr('disabled', true);
		$('.form-view').removeClass('content-hide');
		$('.form-view .pg-title').text('View Data');
		$('.form-view').show(300);
		$('.list-view, .form-import').hide(300);
		$('.v-Save').hide();
		$('.v-Approved').show();
		edit_data2(p2);
	}else if(p1 == 'import'){
		$('.v-import-result').hide();
		$('.form-import').removeClass('content-hide');
		$('.form-import .pg-title').text('Import Data');
		$('.form-view, .list-view').hide(300);
		$('.form-import').show(300);
		$('#form-import')[0].reset();
		$('#form-import .form-control-feedback').text('');
		$('#form-import .has-danger').removeClass('has-danger');
	    $('#form-import .select2-has-danger').removeClass('select2-has-danger');
	    $('.dropify-clear').click();
	    $('#table-import-result thead').empty();
    	$('#table-import-result tbody').empty();
    	$('.import-total-succeess').empty();
    	$('.import-total-failed').empty();
    	$('.import-total').empty();
	}else{
		$('.form-view input').attr('disabled', false);
		$('.form-view').removeClass('content-hide');
		$('.form-view .pg-title').text('Add Data');
		$('.form-view').show(300);
		$('.list-view, .form-import').hide(300);
		$('.v-Save').show();
		$('.v-Approved').hide();
		add_data();
	}
}

function proccess_save(){
	$('.btn-save').button('loading');
	$('button').attr('disabled', true);
}

function end_save(){
	$('.btn-save').button('reset');
	$('button').attr('disabled', false);	
}
function session_expired(url){
	swal({
	    title: "",
	    text: "Session Expired",
	    type: "success"
	}, function() {
	    window.location = url;
	});
}

function show_console(p1){
	console.log(p1);
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

function clear_value(p1,p2){
	$(p1).val('');
	if(p2 == "icon"){
		set_fa_icon();
	}else if("select_api"){
		$(p1+"-Name").val('');
	}
}

function add_data_page(xform){
	page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    $(xform+ ' [name=page_url]').val(dt_url);
    $(xform+ ' [name=page_module]').val(dt_module);

}


// import
function import_header(p1){
	item = '<tr>';
	$.each(p1[0],function(k,v){
		item += '<th>'+v+'</th>';
	});
	item += '<th>Status</th>';
	item += '<th class="mwidth-250p">Message</th>';
	item += '</tr>';
	$('#table-import-result thead').append(item);
}
function import_header2(p1){
	item = '<tr>';
	$.each(p1[0],function(k,v){
		item += '<th>'+v+'</th>';
	});
	item += '<th>Status</th>';
	item += '<th class="mwidth-250p">Message</th>';
	item += '</tr>';
	$('#table-import-result2 thead').append(item);
}

function create_time_picker(){
	$('.timepicker').bootstrapMaterialDatePicker({ format: 'HH:mm', time: true, date: false });
}

function create_time_format(){
	$('.time-format').formatter({'pattern': '{{99}}:{{99}}', });
}

// log info
function log_info(){
	url = host+"log-info";
	data_post = {
		p1 : "log_info",
	}
	$.ajax({
        url : url,
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            $('.log-info').empty();
            if(data.length>0){
            	$.each(data,function(k,v){
            		item = v.Content;
            		$('.log-info').append(item);
            	})
            }else{
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
        }
    });

}

function remove_value(inputnya){
  $('[name='+inputnya+']').val('');
}

function remove_value_user(p1){
	$(p1).val('');
	$(p1+'-Name').val('');
}

function check_type_file(p1,p2){
	icon = host+'img/icon/file.png';
    if(p1 == 'docx' || p1 == 'doc'){
        icon = host+'img/icon/word.png';
    }else if(p1 == 'pdf'){
        icon = host+'img/icon/pdf.png';
    }else if(p1 == 'xls' || p1 == 'csv' || p1 == 'xlsx'){
        icon = host+'img/icon/vscode-icons_file-type-excel.png';
    }else if(p1 == 'png' || type == 'jpg' || p1 == 'jpeg'){
        icon = p2;
    }

    return icon;
}

function redirect_to(url,p2){
	if(p2){
		window.location.replace(url);
	}else{
		window.open(url, '_blank');
	}
}

function summernote_init() {
  $('.summernote').summernote({
    addclass: {
      debug: false,
      classTags: [{
        title: "Button",
        "value": "btn btn-success"
      }, "jumbotron", "lead", "img-rounded", "img-circle", "img-responsive", "btn", "btn btn-success", "btn btn-danger", "text-muted", "text-primary", "text-warning", "text-danger", "text-success", "table-bordered", "table-responsive", "alert", "alert alert-success", "alert alert-info", "alert alert-warning", "alert alert-danger", "visible-sm", "hidden-xs", "hidden-md", "hidden-lg", "hidden-print"]
    },
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
      ['fontname', ['fontname']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video', 'hr']],
      ['view', ['codeview']]
    ],
    fontSize: 16,
    height: 500
  });
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie(p1) {
  var user = getCookie(p1);
  if (user != "") {
    alert("Welcome again " + user);
  } else {
    user = prompt("Please enter your name:", "");
    if (user != "" && user != null) {
      setCookie("username", user, 365);
    }
  }
}

function CheckTheme(){
	var themes = getCookie("themes");
	if(themes != ""){
		SetThemesDefault(themes);
	}else{
		SetThemesDefault(0);
	}
}

function SetThemes(element){
	var index = $(".v-themes").index(element);
	setCookie("themes",index,7);
}

function SetThemesDefault(p1){
	$('.v-themes').eq(p1).click();
}

function doInnerUpdates() { // we will use this function to display upload speed
    var iCB = iBytesUploaded;
    var iDiff = iCB - iPreviousBytesLoaded;

    // if nothing new loaded - exit
    if (iDiff == 0)
        return;

    iPreviousBytesLoaded = iCB;
    iDiff = iDiff * 2;
    var iBytesRem = iBytesTotal - iPreviousBytesLoaded;
    var secondsRemaining = iBytesRem / iDiff;

    // update speed info
    var iSpeed = iDiff.toString() + 'B/s';
    if (iDiff > 1024 * 1024) {
        iSpeed = (Math.round(iDiff * 100/(1024*1024))/100).toString() + 'MB/s';
    } else if (iDiff > 1024) {
        iSpeed =  (Math.round(iDiff * 100/1024)/100).toString() + 'KB/s';
    }

    document.getElementById('speed').innerHTML = iSpeed;
    // document.getElementById('remaining').innerHTML = '| ' + secondsToTime(secondsRemaining);
}

function convertDateDBtoIndo(string) {
	bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
 
    tanggal = string.split("-")[2];
    bulan = string.split("-")[1];
    tahun = string.split("-")[0];
 
    return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
}

// mask date //
(function(e) {
    function t() {
        var e = document.createElement("input"),
            t = "onpaste";
        return e.setAttribute(t, ""), "function" == typeof e[t] ? "paste" : "input"
    }
    var n, a = t() + ".mask",
        r = navigator.userAgent,
        i = /iphone/i.test(r),
        o = /android/i.test(r);
    e.mask = {
        definitions: {
            9: "[0-9]",
            a: "[A-Za-z]",
            "*": "[A-Za-z0-9]"
        },
        dataName: "rawMaskFn",
        placeholder: "_"
    }, e.fn.extend({
        caret: function(e, t) {
            var n;
            if (0 !== this.length && !this.is(":hidden")) return "number" == typeof e ? (t = "number" == typeof t ? t : e, this.each(function() {
                this.setSelectionRange ? this.setSelectionRange(e, t) : this.createTextRange && (n = this.createTextRange(), n.collapse(!0), n.moveEnd("character", t), n.moveStart("character", e), n.select())
            })) : (this[0].setSelectionRange ? (e = this[0].selectionStart, t = this[0].selectionEnd) : document.selection && document.selection.createRange && (n = document.selection.createRange(), e = 0 - n.duplicate().moveStart("character", -1e5), t = e + n.text.length), {
                begin: e,
                end: t
            })
        },
        unmask: function() {
            return this.trigger("unmask")
        },
        mask: function(t, r) {
            var c, l, s, u, f, h;
            return !t && this.length > 0 ? (c = e(this[0]), c.data(e.mask.dataName)()) : (r = e.extend({
                placeholder: e.mask.placeholder,
                completed: null
            }, r), l = e.mask.definitions, s = [], u = h = t.length, f = null, e.each(t.split(""), function(e, t) {
                "?" == t ? (h--, u = e) : l[t] ? (s.push(RegExp(l[t])), null === f && (f = s.length - 1)) : s.push(null)
            }), this.trigger("unmask").each(function() {
                function c(e) {
                    for (; h > ++e && !s[e];);
                    return e
                }

                function d(e) {
                    for (; --e >= 0 && !s[e];);
                    return e
                }

                function m(e, t) {
                    var n, a;
                    if (!(0 > e)) {
                        for (n = e, a = c(t); h > n; n++)
                            if (s[n]) {
                                if (!(h > a && s[n].test(R[a]))) break;
                                R[n] = R[a], R[a] = r.placeholder, a = c(a)
                            } b(), x.caret(Math.max(f, e))
                    }
                }

                function p(e) {
                    var t, n, a, i;
                    for (t = e, n = r.placeholder; h > t; t++)
                        if (s[t]) {
                            if (a = c(t), i = R[t], R[t] = n, !(h > a && s[a].test(i))) break;
                            n = i
                        }
                }

                function g(e) {
                    var t, n, a, r = e.which;
                    8 === r || 46 === r || i && 127 === r ? (t = x.caret(), n = t.begin, a = t.end, 0 === a - n && (n = 46 !== r ? d(n) : a = c(n - 1), a = 46 === r ? c(a) : a), k(n, a), m(n, a - 1), e.preventDefault()) : 27 == r && (x.val(S), x.caret(0, y()), e.preventDefault())
                }

                function v(t) {
                    var n, a, i, l = t.which,
                        u = x.caret();
                    t.ctrlKey || t.altKey || t.metaKey || 32 > l || l && (0 !== u.end - u.begin && (k(u.begin, u.end), m(u.begin, u.end - 1)), n = c(u.begin - 1), h > n && (a = String.fromCharCode(l), s[n].test(a) && (p(n), R[n] = a, b(), i = c(n), o ? setTimeout(e.proxy(e.fn.caret, x, i), 0) : x.caret(i), r.completed && i >= h && r.completed.call(x))), t.preventDefault())
                }

                function k(e, t) {
                    var n;
                    for (n = e; t > n && h > n; n++) s[n] && (R[n] = r.placeholder)
                }

                function b() {
                    x.val(R.join(""))
                }

                function y(e) {
                    var t, n, a = x.val(),
                        i = -1;
                    for (t = 0, pos = 0; h > t; t++)
                        if (s[t]) {
                            for (R[t] = r.placeholder; pos++ < a.length;)
                                if (n = a.charAt(pos - 1), s[t].test(n)) {
                                    R[t] = n, i = t;
                                    break
                                } if (pos > a.length) break
                        } else R[t] === a.charAt(pos) && t !== u && (pos++, i = t);
                    return e ? b() : u > i + 1 ? (x.val(""), k(0, h)) : (b(), x.val(x.val().substring(0, i + 1))), u ? t : f
                }
                var x = e(this),
                    R = e.map(t.split(""), function(e) {
                        return "?" != e ? l[e] ? r.placeholder : e : void 0
                    }),
                    S = x.val();
                x.data(e.mask.dataName, function() {
                    return e.map(R, function(e, t) {
                        return s[t] && e != r.placeholder ? e : null
                    }).join("")
                }), x.attr("readonly") || x.one("unmask", function() {
                    x.unbind(".mask").removeData(e.mask.dataName)
                }).bind("focus.mask", function() {
                    clearTimeout(n);
                    var e;
                    S = x.val(), e = y(), n = setTimeout(function() {
                        b(), e == t.length ? x.caret(0, e) : x.caret(e)
                    }, 10)
                }).bind("blur.mask", function() {
                    y(), x.val() != S && x.change()
                }).bind("keydown.mask", g).bind("keypress.mask", v).bind(a, function() {
                    setTimeout(function() {
                        var e = y(!0);
                        x.caret(e), r.completed && e == x.val().length && r.completed.call(x)
                    }, 0)
                }), y()
            }))
        }
    })
})(jQuery);
// mask date //

// attachment //
function readUrl(input) {
    if (input.files && input.files[0]) {
      $.each(input.files, function(k,v){
          var reader = new FileReader();
          reader.readAsDataURL(input.files[k]);
          var url_image = reader.result;
          reader.onload = function (e) {
              data = input.files[k];
              url_image = e.target.result;
              type = "";
              if(data.name){
                  d = data.name;
                  d = d.split('.');
                  type = d[1];
              }
  
              arrData = {
                  filename : data.name,
                  url      : url_image,
                  type     : type,
                  size     : data.size,
                  status   : 0,
                  page     : '',
                  id       : '',
  
              }
              console.log(arrData);
              set_file(arrData, input.files.length, k+1);
          };
      });
    }
  }
  
  function reset_file_upload(){
    $('.div-attach').empty();
    $('.form-attach').empty();
    $('.file-result').empty();
    $('.progress-data').hide();
  }
  
  function set_file(data,total_data,key){
      item = 
      '<div class="box-file-result" data-id="'+data.id+'" data-page="'+data.page+'" data-size="'+data.size+'" data-file="'+data.url+'" data-type="'+data.type+'" data-filename="'+data.filename+'" data-status="'+data.status+'">\
            <div class="row">\
                <div class="col-md-1 box-file-result-img" style="padding: 13px;\">\
                    <a href="javascript:;" onclick="event_click_file(this)">\
                        <img src="'+host+icon_file(data.type)+'" width="37" height="37" style="margin-bottom:0px;">\
                    </a>\
                </div>\
                <div class="col-md-11" style="margin-top: 10px">\
                    <div>\
                        <button class="close btn-close-attach" style="margin-top:-5px;padding: 15px;" type="button" onclick="remove_file(this)">×</button>\
                        <span style="font-weight:bold;color:black;"><a href="javascript:;" onclick="event_click_file(this)">'+data.filename+'</span></a><span style="margin-left:10px;">'+bytesToSize(data.size)+'</span>\
                        <div>100% done</div>\
                    </div>\
                </div>\
            </div>\
      </div>';
        
      $('.file-result').append(item);
      ID = $('.data-ID').attr('data-id');
      type = data.type;
      if(key == "view"){
        $('.btn-close-attach').hide();
      }
      if(ID && total_data == key){
          upload_attachment_file();
      } 
  }
  
  function bytesToSize(bytes) {
     var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
     if (bytes == 0) return '0 Byte';
     var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
     return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
  };
  
  function remove_file(a){
      ID  = $('.data-ID').val();
      if(ID){
          remove_attachment_file(a);
      }else{
          // swal('',language_app.lb_success, 'success');
          $(a).closest('.box-file-result').remove();
      }
  }
  
  function icon_file(type){
    file = 'asset/images/icon_file/file.png';
    if(type == "pdf"){file = 'asset/images/icon_file/pdf.png';}
    else if(type == "png"){file = 'asset/images/icon_file/png.png';}
    else if(type == "jpg" || type == "jpeg"){file = 'asset/images/icon_file/jpg.png';}
    else if(type == "doc" || type == "docx"){file = 'asset/images/icon_file/doc.png'}
    else if(type == "xls" || type == "xlsx"){file = 'asset/images/icon_file/excell.png';}
    else{file = 'asset/images/icon_file/file.png';}
    return file;
  }
  
  function link_file(type,data,page){
    url     = '';
    docs    = '';//https://docs.google.com/gview?url=
    typenya = ['png','jpg','jpeg'];
    if(jQuery.inArray(type, typenya) !== -1){
      docs = ''; 
    }
  
    return docs+data;
  }
  
  // function event_click_file(a){
  //   tag_data = $(a).closest('.box-file-result').data();
  //   if(tag_data){
  //     frame = link_file(tag_data.type, tag_data.file);
  //     $.redirect(host+"show-attachment",
  //     {
  //       frame     : frame,
  //       filename  : tag_data.filename,
  //       type      : tag_data.type,
  //       page      : tag_data.page,
  //     },
  //     "POST","_blank",);
  //   }
  // }

    function saveBase64AsFile(base64, fileName) {
        var link = document.createElement("a");
        document.body.appendChild(link); // for Firefox
        link.setAttribute("href", base64);
        link.setAttribute("download", fileName);
        link.click();
    }

  function event_click_file(a){
    tag_data = $(a).closest('.box-file-result').data();
    if(tag_data){
        saveBase64AsFile(tag_data.file, tag_data.filename);
    }
  }
  
  function ck_count_save_file(){
    d = $('.box-file-result');
    count = 0;
    $.each(d,function(k,v){
      tag_data = $(v).data();
      if(tag_data){
        if(tag_data.status == 0){
          count += 1;
        }
      }
    });
  
    return count;
  }
  
  function upload_attachment_file(id){
    arrFilename = [];
    arrSize     = [];
    arrFile     = [];
    arrKey      = [];
  
    d = $('.box-file-result');
    $.each(d,function(k,v){
      tag_data = $(v).data();
      if(tag_data){
        if(tag_data.status == 0){
          arrFilename.push(tag_data.filename);
          arrFile.push(tag_data.file);
          arrSize.push(tag_data.size);
          arrKey.push(k);
        }
      }
    });

    data_page   = $(".data-page, .page-data").data();
    modul       = data_page.modul;
    if(!id){
      // ID          = $('.data-ID').val();
      ID = $('.data-ID').attr('data-id');
    }else{
      ID = id;
    }
  
    data_post   = {
      ID        : ID,
      type      : modul,
      file      : arrFile,
      filename  : arrFilename,
      size      : arrSize,
      key       : arrKey,
    }

    console.log(data_post);
  
    url = host+"save-attachment";
    $.ajax({
      url : url,
      type: "POST",    
      data: data_post,
      dataType: "JSON",
      success: function(data){
        if(data.hakakses == "super_admin"){
          console.log(data);
        }
        if(data.status){
          for(i = 0;i<data.key.length; i++){
            $('.box-file-result').eq(data.key[i]).data("status", 1);
            $('.box-file-result').eq(data.key[i]).data("id", data.ID[i]);
          }
        }
      },
      error: function (jqXHR, textStatus, errorThrown){
        console.log(jqXHR.responseText);
  
      }
    });
  }
  
  function show_attachment_file(id){
    data_page   = $(".data-page, .page-data").data();
    modul       = data_page.modul;
    data_post   = {
      modul   : modul,
      ID      : id,
    }
    url = host + 'attachment-file';
    $.ajax({
        url : url,
        type: "POST",
        data : data_post,
        dataType: "JSON",
        success: function(data){
          console.log(data);
          if(data.status){
            $.each(data.attach,function(i,v){
              set_file(v,1,"view");
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown){
          console.log(jqXHR.responseText);
        }
      });
  }
  
  function remove_attachment_file(d){
    if(d){
      tag_data = $(d).closest('.box-file-result').data();
      url = host+"attachment/delete/"+tag_data.id;
      $.ajax({
        url : url,
        type: "POST",
        dataType: "JSON",
        success: function(data){
          if(data.status){
            swal('','Successfully deleted', 'success');
            $(d).closest('.box-file-result').remove();
          }
        },
        error: function (jqXHR, textStatus, errorThrown){
          console.log(jqXHR.responseText);
        }
      });
    }
  }
  
  function disabled_file(){
    $('#inputFile').attr('disabled', false);
  }
  
  function show_upload_file(){
    $('.inputDnD').show();
  }
  
  function hide_upload_file(){
    $('.inputDnD').hide();
  }
  
  function progres_bar(){
    $('.progress-data').show();
    $(".progress-bar").animate({
      width: "80%"
    }, 1500);
  }
  
  function success_progres_bar(){
    $(".progress-bar").animate({
      width: "100%"
    });
    $('.progress-data').hide();
  }
  
  function create_form_attach(){
    item = '<div class="form-group col-sm-12">\
                  <label class="control-label">'+language_app.lb_attachment+'</label>\
                  <div class="file-result"></div>\
                  <div class="form-group inputDnD">\
                    <label class="sr-only" for="inputFile">'+language_app.lb_file_upload+'</label>\
                    <input type="file" multiple="multiple" class="form-control-file text-success font-weight-bold" id="inputFile" onchange="readUrl(this)" data-title="'+language_app.lb_file_choose+'">\
                  </div>\
                  <div class="progress-data"></div>\
                  <span class="help-block"></span>\
                </div>';
    $('.form-attach').append(item);
  }
  
// attachment //