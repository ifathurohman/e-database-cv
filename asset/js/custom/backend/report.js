var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var xform_filter;
var url_list    = host + "report-change";
$(document).ready(function() {
	xform_filter = '#form-filter';
	ReportType 		= $(xform_filter+' [name=ReportType] option:selected').val();
   	change_report(ReportType);
});

function filter_table(){
	ReportType 		= $(xform_filter+' [name=ReportType] option:selected').val();
	Company 		= $(xform_filter+' [name=Company]').val();
	User 			= $(xform_filter+' [name=User]').val();
	StartDate 		= $(xform_filter+' [name=f-StartDate]').val();
	EndDate 		= $(xform_filter+' [name=f-EndDate]').val();
	Status 			= $(xform_filter+' [name=f-Status] option:selected').val();

	dt_page 	= $('.page-data').data();

	data = {
		ReportType 	: ReportType,
		Company 	: Company,
		User 		: User,
		StartDate 	: StartDate,
		EndDate 	: EndDate,
		Status 		: Status,
		url 		: dt_page.url,
		module 		: dt_page.module,
	}

	show_console(data);
	$('.div_loader').show();
	$(".view_data").load(url_list,data,function(response, status, xhr){
      	$('.div_loader').hide();
      
    });
}

$(document).ready(function() {
	$(xform_filter+' [name=ReportType]').change(function(){
		val = $(this).val();
		change_report(val);
	});
});

var arr_v_status = ['attendance_report','attendance_visit','attendance_report_h','report_log','report_log_company','attendance'];
var arr_btn_pdf  = ['attendance_report_h','attendance'];
var arr_btn_excell  = ['attendance'];
var arr_v_user  	= ['report_log_company'];
function change_report(p1){
	if(jQuery.inArray(p1, arr_v_status) !== -1){ // hide data yg ada di array
	    $('.v-status').hide(-300);
  	}else{
  		$('.v-status').show(300);
  	}

  	if(jQuery.inArray(p1, arr_btn_pdf) !== -1){ // hide data yg ada di array
	    $('.btn-pdf').hide(-300);
  	}else{
  		$('.btn-pdf').show(300);
  	}

  	if(jQuery.inArray(p1, arr_btn_excell) !== -1){ // hide data yg ada di array
	    $('.btn-excell').hide(-300);
  	}else{
  		$('.btn-excell').show(300);
  	}

  	if(jQuery.inArray(p1, arr_v_user) !== -1){ // hide data yg ada di array
	    $('.v-user').hide(-300);
  	}else{
  		$('.v-user').show(300);
  	}

  	if(p1 == 'report_log_company'){
  		$('.Company').data('type','all');
  	}else{
  		$('.Company').data('type','');
  	}

	filter_table();
}

function export_data(p1,p2){
	ReportType 		= $(xform_filter+' [name=ReportType] option:selected').val();
	Company 		= $(xform_filter+' [name=Company]').val();
	User 			= $(xform_filter+' [name=User]').val();
	StartDate 		= $(xform_filter+' [name=f-StartDate]').val();
	EndDate 		= $(xform_filter+' [name=f-EndDate]').val();
	Status 			= $(xform_filter+' [name=f-Status] option:selected').val();

	dt_page 	= $('.page-data').data();

	data = {
		ReportType 	: ReportType,
		Company 	: Company,
		User 		: User,
		StartDate 	: StartDate,
		EndDate 	: EndDate,
		Status 		: Status,
		url 		: dt_page.url,
		module 		: dt_page.module,
		Print 		: p1,
		Print2 		: p2,
	}

	$.redirect(host+'report-print',data,"POST","_blank");
}

function view_data(p1,p2){
	$('.data-report').empty();
	tg_data = $(p1).data();

	if(p2 == 'attendance_visit'){
		item = '<div class="row">';
		if(tg_data.p2){
			img = host+tg_data.p2;
			item += '<div class="col-sm-4">\
              <div class="form-group">\
                  <label class="control-label">Picture In</label>\
                  <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
              </div>\
            </div>';
		}
		if(tg_data.p4){
			img = host+tg_data.p4;
			item += '<div class="col-sm-4">\
              <div class="form-group">\
                  <label class="control-label">Picture Out</label>\
                  <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
              </div>\
            </div>';
		}
		if(tg_data.p3){
			img = host+tg_data.p3;
			item += '<div class="col-sm-4">\
              <div class="form-group">\
                  <label class="control-label">File Out</label>\
                  <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
              </div>\
            </div>';
		}
		item += '</div>';

		$('.data-report').append(item);
	}else if(p2 == 'attendance'){
		view_attendance(tg_data);
	}

	$('#modal-report').modal('show');
}

function td_hover(p1){
	tg_data  = $(p1).data();
	no = tg_data.no;

	$('.no'+no).addClass('td-hover');
}

function td_hover_out(p1){
	tg_data  = $(p1).data();
	no = tg_data.no;

	$('.no'+no).removeClass('td-hover');
}

function view_attendance(tg_data){
	item = '<div class="row">';
	item += '<div class="col-sm-6">\
      <div class="form-group">\
          <label class="control-label">Check In Note</label>\
          <input type="text" id="CheckInNote" class="form-control" readonly>\
      </div>\
    </div>';
    item += '<div class="col-sm-6">\
      <div class="form-group">\
          <label class="control-label">Check Out Note</label>\
          <input type="text" id="CheckOutNote" class="form-control" readonly>\
      </div>\
    </div>';
    item += '<div class="col-sm-6">\
      <div class="form-group">\
          <label class="control-label">Overtime Out Note</label>\
          <input type="text" id="OvertimeOutNote" class="form-control" readonly>\
      </div>\
    </div>';
    item += '<div class="d-picture col-sm-12"></div>';
	item += '</div>';

	$('.data-report').append(item);

	page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    
    data_post = {
    	page_url        : dt_url,
        page_module     : dt_module,
        p1 : tg_data.p1,
        p2 : tg_data.p2,
        p3 : tg_data.p3,
        p4 : tg_data.p4,
        p5 : tg_data.p5,
        p6 : tg_data.p6,
        p7 : tg_data.p7,
        p8 : tg_data.p8,
    }
    show_console(data_post);
    $.ajax({
        url : host+"api/AttendanceDetail",
        type: "POST",
        data: data_post,
        dataType: "JSON",
        success: function(data)
        {
            show_console(data);
            if(data.status){
                item = '';
                if(data.checkin){
                	$('#CheckInNote').val(data.checkin.Note);
                  $.each(data.checkin.Picture,function(k,v){
                    img = host+v;
                    item += '<div class="col-sm-4">\
                            <div class="form-group">\
                                <label class="control-label">Picture Check In</label>\
                                <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
                            </div>\
                          </div>';
                  });
                }
                if(data.break){
                  $.each(data.break.Picture,function(k,v){
                    img = host+v;
                    item += '<div class="col-sm-4">\
                            <div class="form-group">\
                                <label class="control-label">Picture Break Start</label>\
                                <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
                            </div>\
                          </div>';
                  });
                }
                if(data.break_end){
                  $.each(data.break_end.Picture,function(k,v){
                    img = host+v;
                    item += '<div class="col-sm-4">\
                            <div class="form-group">\
                                <label class="control-label">Picture Break End</label>\
                                <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
                            </div>\
                          </div>';
                  });
                }
                if(data.checkout){
                  $('#CheckOutNote').val(data.checkout.Note);
                  $.each(data.checkout.Picture,function(k,v){
                    img = host+v;
                    item += '<div class="col-sm-4">\
                            <div class="form-group">\
                                <label class="control-label">Picture Check Out</label>\
                                <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
                            </div>\
                          </div>';
                  });
                }
                if(data.overtime_out){
                	$('#OvertimeOutNote').val(data.overtime_out.Note);
                	$.each(data.overtime_out.Picture,function(k,v){
                		img = host+v;
          					item += '<div class="col-sm-4">\
          		              <div class="form-group">\
          		                  <label class="control-label">Picture Overtime Out</label>\
          		                  <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
          		              </div>\
          		            </div>';
                	});
                	$.each(data.overtime_out.File,function(k,v){
                		img = host+v;
          					item += '<div class="col-sm-4">\
          		              <div class="form-group">\
          		                  <label class="control-label">File Overtime Out</label>\
          		                  <div class="vimages"><img class="img" onclick="redirect_to('+"'"+img+"'"+')" src="'+img+'"></div>\
          		              </div>\
          		            </div>';
                	});
                	$('.d-picture').append(item);
                }
            }else{
                show_invalid_response(data);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            console.log(jqXHR.responseText);
        }
    });
}