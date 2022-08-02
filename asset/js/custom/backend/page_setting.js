var mobile      = (/iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));  
var host        = window.location.origin+'/';
var url_page    = window.location.href;
var save_method; //for save method string
var table;
var url_edit    = host + "policy-page-setting-edit";

var pressTimer;
var countUp = 0;
var dt_val;
// $("#table-list tbody").on('mouseup','tr',function(){
//  if(countUp <=0){
//      val = $(this).children('td').children('.dt-id').data();
//      short_click(val);
//  }
//  countUp = 0;
//      clearTimeout(pressTimer);
//      return false;
//   }).mousedown(function(e){
//      // Set timeout
//     e = e.target;
//     dt_val = $(e).closest('tr').find('.dt-id').data();
//      pressTimer = window.setTimeout(function() {
//         long_click(dt_val);
//     },time_long_click);
//      return false; 
// });

$(document).on('click',function(){
    $('.action_list').removeClass('active');
})

var index_dt;
$("#table-list tbody").on('click','tr',function(event){
    index_dt = $(this).index();
    $('.action_list').removeClass('active');
    $('#table-list tbody tr td .action_list').eq(index_dt).addClass("active");
    event.stopPropagation();
});

function action_edit(){
    val = $('#table-list .dt-id').eq(index_dt).data();
    short_click(val);
}

function short_click(p1){
    open_form('edit',p1.id);
}

function edit_data(){
    page_data   = $(".page-data").data();
    dt_url      = page_data.url;
    dt_module   = page_data.module;

    data_post = {
        page_url        : dt_url,
        page_module     : dt_module,
    }

    $.redirect(host+'policy-page-setting-edit',data_post,"POST");
}