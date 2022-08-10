var mobile = /iphone|ipod|android|blackberry|mini|windows\sce|palm/i.test(
  navigator.userAgent.toLowerCase(),
);
var host = window.location.origin + '/';
var url_page = window.location.href;
var save_method; //for save method string
var table;
var table2;
var save_method; //for save method string
var url_list = host + 'dashboard-list';
var url_list_sdm = host + 'dashboard-list-sdm-pt';
var url_list_non = host + 'dashboard-list-sdm-non';

var url_save_sdm = host + 'dashboard-save_sdm';
var url_save_non = host + 'dashboard-save_sdm_non';

var url_edit_sdm = host + 'sdm_pegawai_ciriajasa-edit';
var url_edit_non = host + 'sdm_pegawai-edit';

var url_detail = host + 'dashboard-list-detail';

$(document).ready(function () {
  $('#v-form-pt').hide();
  $('#v-form-non').hide();
  $('#form').hide();
  filter_table();
  filter_table2();
  ChartJS();
  load_data('first');
});

var chart_pegawai, chart_tot_pegawai;
function ChartJS() {
  var ctx = document.getElementById('status_pegawai');
  chart_pegawai = new Chart(ctx, {});

  var ctx = document.getElementById('myChart');
  chart_tot_pegawai = new Chart(ctx, {});
}

function load_data(p1) {
  IDPelanggan = $('#IDPelanggan').val();
  StartDate = $('#f-StartDate').val();
  EndDate = $('#f-EndDate').val();

  data_post = {
    IDPelanggan: IDPelanggan,
    StartDate: StartDate,
    EndDate: EndDate,
  };

  $('.div_loader').show();
  $.ajax({
    url: url_list,
    type: 'POST',
    data: data_post,
    dataType: 'JSON',
    success: function (data) {
      show_console(data);
      console.log(data);

      if (data.status) {
        $('.total_tersedia').text(data.tersedia.tersedia);
        $('.total_terkontrak').text(data.terkontrak.terkontrak);
        $('.total_tender').text(data.tender.tender);

        $('.total_peg').text(data.total_peg.total_pegawaian);
        $('.total_peg_bulan').text(data.total_peg_bulan.total_pegawaian);
        set_data_biodata(data);
        // set_data_sdm_non_pt(data);
        // set_data_sdm_pt(data);
        set_data_top_status_pegawai(data);
        proyek(data);
        set_data_pegawai(data);
      } else {
        if (p1 != 'first') {
          show_invalid_response(data);
        } else {
        }
      }
      $('.div_loader').hide();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $('.div_loader').hide();
      swal('Error reject data');
      console.log(jqXHR.responseText);
    },
  });
}

function set_data_biodata(data) {
  biodata(data.biodata);
}
// function set_data_sdm_non_pt(data){
//     sdm_non_pt(data.sdm_non_pt);
// }
// function set_data_sdm_pt(data){
//     sdm_pt(data.sdm_pt);
// }
function set_data_top_status_pegawai(data) {
  top_status_pegawai(data.top_status_pegawai);
}
function set_data_pegawai(data) {
  top_total_pegawai(data.total_pegawai);
}

function biodata(data) {
  $('#table-biodata tbody').empty();
  $('html, body').animate(
    {
      scrollTop: $('#table-biodata').offset().top - 100,
    },
    1000,
  );
  item = '';
  if (data.length > 0) {
    item = '';
    $.each(data, function (k, v) {
      no = k + 1;

      item += '<tr>';
      item += '<td style="width:10px;">' + no + '</td>';
      item += '<td class="ellipsis">' + v.Nama_personil + '</td>';
      item += '<td class="ellipsis">' + v.Pendidikan + '</td>';
      item += '<td class="ellipsis">' + v.Pendidikan_non_formal + '</td>';
      // item += '<td>'+' <div class="row"><img src="https://dev.edatabasecv.com/img/icon/Edit_Square.png" style="margin-right: 10px;"><img src="https://dev.edatabasecv.com/img/icon/Show.png"></div>'+'</td>';
      item += '</tr>';
    });
  } else {
    item = '<tr class="odd">';
    item += '<td valign="top" colspan="7" class="dataTables_empty">';
    item += '<div align="center">';
    item +=
      '<img src="https://dev.edatabasecv.com/img/icon/Logo.png" width="150">';
    item += '<h4>Data Not Found</h4>';
    item += '</div>';
    item += '</td>';
    item += '</tr>';
  }
  $('#table-biodata tbody').append(item);
  $('#table-biodata').DataTable({
    destroy: true,
  });
  // create a data table
  var table = $('#table-biodata').DataTable();

  // add custom listener to draw event on the table
  table.on('draw', function () {
    // get the search keyword
    var keyword = $('#table-biodata_filter > label:eq(0) > input').val();

    // clear all the previous highlighting
    $('#table-biodata').unmark();

    // highlight the searched word
    $('#table-biodata').mark(keyword, {});
  });
}

// function sdm_non_pt(data){
//     // $('#table-daftar-pegawai').DataTable();
//     $('#table-daftar-pegawai tbody').empty();
//     if(data.length>0){
//         item = '';
//         $.each(data,function(k,v){

//             str_class = '';
//             if(v.Status_pegawai == 'Tersedia'){
//                 str_class = 'label-tersedia ';
//             }else if(v.Status_pegawai == 'Terkontrak'){
//                 str_class = 'label-terkontrak ';
//             }

//             no = k + 1;

//             item += '<tr>';
//             item += '<td>'+no+'</td>';
//             item += '<td>'+v.Nama_personil+'</td>';
//             item += '<td>'+'<span class="'+str_class+'">'+v.Status_pegawai+''+'</span>'+'</td>';
//             item += '<td>'+v.Nama_perusahaan+'</td>';
//             item += '<td>'+v.Proyek+'</td>';
//             item += '<td>'+convertDateDBtoIndo(v.Periode_proyek_mulai)+'</td>';
//             item += '<td>'+convertDateDBtoIndo(v.Periode_proyek_selesai)+'</td>';
//             item += '<td>'+' <div class="row"><img src="https://dev.edatabasecv.com/img/icon/Edit_Square.png" style="margin-right: 10px;"><img src="https://dev.edatabasecv.com/img/icon/Show.png"></div>'+'</td>';
//             item += '</tr>';
//         });
//     }else{
//         item =  '<tr class="odd">';
//         item += '<td valign="top" colspan="7" class="dataTables_empty">';
//         item += '<div align="center">';
//         item += '<img src="https://dev.edatabasecv.com/img/icon/Logo.png" width="150">';
//         item += '<h4>Data Not Found</h4>';
//         item += '</div>';
//         item += '</td>';
//         item += '</tr>';
//     }
//     $('#table-daftar-pegawai tbody').append(item);
//     $('#table-daftar-pegawai').DataTable({
//         "destroy"   : true,
//     });
// }

// function sdm_pt(data){
//     $('#table-daftar-pegawai-pt tbody').empty();
//     if(data.length>0){
//         item = '';
//         $.each(data,function(k,v){

//             str_class = '';
//             if(v.Status_pegawai == 'Tersedia'){
//                 str_class = 'label-tersedia ';
//             }else if(v.Status_pegawai == 'Terkontrak'){
//                 str_class = 'label-terkontrak ';
//             }else if(v.Status_pegawai == 'Tender'){
//                 str_class = 'label-tender ';
//             }

//             no = k + 1;

//             item += '<tr>';
//             item += '<td>'+no+'</td>';
//             item += '<td>'+v.Nama_personil+'</td>';
//             item += '<td>'+'<span class="'+str_class+'">'+v.Status_pegawai+''+'</span>'+'</td>';
//             item += '<td>'+v.Nama_perusahaan+'</td>';
//             item += '<td>'+v.Proyek+'</td>';
//             item += '<td>'+convertDateDBtoIndo(v.Periode_proyek_mulai)+'</td>';
//             item += '<td>'+convertDateDBtoIndo(v.Periode_proyek_selesai)+'</td>';
//             item += '<td>'+' <div class="row"><img src="https://dev.edatabasecv.com/img/icon/Edit_Square.png" style="margin-right: 10px;"><img src="https://dev.edatabasecv.com/img/icon/Show.png"></div>'+'</td>';
//             item += '</tr>';
//         });
//     }else{
//         item =  '<tr class="odd">';
//         item += '<td valign="top" colspan="7" class="dataTables_empty">';
//         item += '<div align="center">';
//         item += '<img src="https://dev.edatabasecv.com/img/icon/Logo.png" width="150">';
//         item += '<h4>Data Not Found</h4>';
//         item += '</div>';
//         item += '</td>';
//         item += '</tr>';
//     }
//     $('#table-daftar-pegawai-pt tbody').append(item);
//     $('#table-daftar-pegawai-pt').DataTable({
//         "destroy"   : true,
//     });
// }

function proyek(data) {
  if (data.total_proyek.length > 1) {
    $.each(data.total_proyek, function (i, v) {
      image = '';
      if (data.total_proyek[i].tahun == '2021') {
        image = host + 'img/icon/1.png';
      } else if (data.total_proyek[i].tahun == '2020') {
        image = host + 'img/icon/2.png';
      } else if (data.total_proyek[i].tahun == '2019') {
        image = host + 'img/icon/3.png';
      } else if (data.total_proyek[i].tahun == '2019') {
        image = host + 'img/icon/4.png';
      }
      item =
        '<div class="sl-item">\
                            <div class="sl-left"><img class="img-circle" alt="user" src="' +
        image +
        '"></div>\
                            <div class="sl-right">\
                                <div class="font-medium">' +
        data.total_proyek[i].tahun +
        '</div>\
                                <div class="desc">' +
        data.total_proyek[i].jumlah_proyek +
        ' Current Project</div>\
                            </div>\
                        </div>';
      $('.list_proyek').append(item);
    });
  }
}

// chart //
function top_status_pegawai(data) {
  var ctx = $('#status_pegawai');
  chart_pegawai.destroy();
  labels = [];
  value = [];
  backgroundColor = [];
  borderColor = [];
  if (data.length > 0) {
    $.each(data, function (k, v) {
      color = get_backgroundColor(k);
      labels.push(v.Status_pegawai);
      value.push(v.Status_pegawai);
      backgroundColor.push(color[0]);
      borderColor.push(color[1]);
    });
    var tender = 'Tender';
    var tersedia = 'Tersedia';
    var terkontrak = 'Terkontrak';
    var tender = value.filter(function (elem) {
      return elem == tender;
    }).length;
    var tersedia = value.filter(function (elem) {
      return elem == tersedia;
    }).length;
    var terkontrak = value.filter(function (elem) {
      return elem == terkontrak;
    }).length;
  } else {
    labels.push('Data Not Found');
    value.push(100);
    backgroundColor.push('rgba(208,208,208,0.82');
    borderColor.push('rgba(208,208,208,0.82)');
  }
  chart_pegawai = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Tender', 'Terkontrak', 'Tersedia'],
      datasets: [
        {
          label: '# of Votes',
          data: [tender, terkontrak, tersedia],
          backgroundColor: ['#fce353', '#ff5d73', '#4ec662'],
          // borderColor: borderColor,
          borderWidth: 1,
        },
      ],
    },
    options: {
      scales: {
        display: false,
      },
      legend: {
        display: false,
        position: 'right',
      },
      tooltips: {
        callbacks: {
          label: function (tooltipItem, data) {
            var labels = data.labels[tooltipItem.index];
            if (labels == 'Data Not Found') {
              var value = 0;
            } else {
              var value =
                data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
            }
            var labels = labels + ' : ' + value;
            return labels;
          },
        },
      },
    },
  });

  var s = chart_pegawai.generateLegend();
  $('#status_pegawai-legend').html(s);

  $('#status_pegawai-legend > ul > li').on('click', function (e) {
    var index = $(this).index();
    $(this).toggleClass('strike');
    var ci = e.view.chart_pegawai;
    var curr = ci.data.datasets[0]._meta;
    $.each(curr, function (k, v) {
      curr = v.data[index];
      curr.hidden = !curr.hidden;
      ci.update();
    });
  });
}
// chart //

function reload_table() {
  table.ajax.reload(null, false); //reload datatable ajax
}

function get_backgroundColor(index, transaparant) {
  backgroundcolor = 'rgba(216,216,216,0.82)';
  bordercolor = 'rgba(216,216,216,1)';

  // red
  if (index == 0) {
    backgroundcolor = 'rgba(209,59,59,0.82)';
    bordercolor = 'rgba(209,59,59,1)';
    if (transaparant) {
      backgroundcolor = 'rgba(209,59,59,0)';
    }
  }
  // pink
  else if (index == 1) {
    backgroundcolor = 'rgba(209,59,99,0.82)';
    bordercolor = 'rgba(209,59,99,1)';
    if (transaparant) {
      backgroundcolor = 'rgba(209,59,99,0)';
    }
  }

  // orange
  else if (index == 2) {
    backgroundcolor = 'rgba(221,124,54,0.82)';
    bordercolor = 'rgba(221,124,54,1)';
    if (transaparant) {
      backgroundcolor = 'rgba(221,124,54,0)';
    }
  }
  // orange - yellow
  else if (index == 3) {
    backgroundcolor = 'rgba(227,165,74,0.82)';
    bordercolor = 'rgba(227,165,74,1)';
    if (transaparant) {
      backgroundcolor = 'rgba(227,165,74,0)';
    }
  }
  // yellow
  else if (index == 4) {
    backgroundcolor = 'rgba(255,205,86,0.82)';
    bordercolor = 'rgba(255,205,86,1)';
    if (transaparant) {
      backgroundcolor = 'rgba(255,205,86,0)';
    }
  }
  // green
  else if (index == 5) {
    backgroundcolor = 'rgba(125,226,212,0.82)';
    bordercolor = 'rgba(125,226,212,1)';
    if (transaparant) {
      backgroundcolor = 'rgba(125,226,212,0)';
    }
  }
  // blue
  else if (index == 6) {
    backgroundcolor = 'rgba(59,154,230,0.82)';
    bordercolor = 'rgba(59,154,230,1)';
    if (transaparant) {
      backgroundcolor = 'rgba(59,154,212,0)';
    }
  } else if (index == 'non') {
    backgroundcolor = 'rgba(240, 248, 255, 0)';
    bordercolor = 'rgba(240, 248, 255, 0)';
  }

  // custom
  else if (index == 'gradient1') {
    backgroundcolor =
      'linear-gradient(60deg, rgba(255,175,16,1) 30%, rgba(253,116,155,1) 37%)';
  }

  data = [backgroundcolor, bordercolor];

  return data;
}

function top_total_pegawai(data) {
  var ctx = document.getElementById('myChart').getContext('2d');
  chart_tot_pegawai.destroy();

  var gradientStroke1 = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke1.addColorStop(0, 'rgba(255,85,108,1)');
  gradientStroke1.addColorStop(1, 'rgba(255,175,16,1)');

  var gradientFill1 = ctx.createLinearGradient(500, 0, 100, 0);
  gradientFill1.addColorStop(0, 'rgba(253,116,155,0.30)');
  gradientFill1.addColorStop(1, 'rgba(255,175,16,0.37)');

  var gradientStroke2 = ctx.createLinearGradient(500, 0, 100, 0);
  gradientStroke2.addColorStop(0, 'rgba(40,26,200,1)');
  gradientStroke2.addColorStop(1, 'rgba(255,126,184,1)');

  var gradientFill2 = ctx.createLinearGradient(500, 0, 100, 0);
  gradientFill2.addColorStop(0, 'rgba(233,236,241,1)');
  gradientFill2.addColorStop(1, 'rgba(229,244,255,1)');

  labels = [];
  value = [];

  if (data.length > 0) {
    $.each(data, function (k, v) {
      color = get_backgroundColor(k);
      labels.push(data[k]['tahun']);
      value.push(data[k]['jumlah_pegawai']);
    });
  } else {
    labels.push('Data Not Found');
    value.push(100);
    backgroundColor.push('rgba(208,208,208,0.82');
    borderColor.push('rgba(208,208,208,0.82)');
  }
  chart_tot_pegawai = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Tahun',
          borderColor: gradientStroke1,
          pointBorderColor: gradientStroke1,
          pointBackgroundColor: gradientStroke1,
          pointHoverBackgroundColor: gradientStroke1,
          pointHoverBorderColor: gradientStroke1,
          pointBorderWidth: 1,
          pointHoverRadius: 1,
          pointHoverBorderWidth: 1,
          pointRadius: 3,
          fill: true,
          backgroundColor: gradientFill1,
          borderWidth: 2,
          data: value,
        },
      ],
    },
    options: {
      legend: {
        display: false,
        position: 'bottom',
      },
      scales: {
        yAxes: [
          {
            ticks: {
              fontColor: 'rgba(0,0,0,0.5)',
              fontStyle: 'bold',
              beginAtZero: true,
              maxTicksLimit: 5,
              padding: 20,
            },
            gridLines: {
              drawTicks: false,
              display: false,
            },
          },
        ],
        xAxes: [
          {
            gridLines: {
              zeroLineColor: 'transparent',
            },
            ticks: {
              padding: 20,
              fontColor: 'rgba(0,0,0,0.5)',
              fontStyle: 'bold',
            },
          },
        ],
      },
    },
  });
}

function filter_table() {
  // page_data   = $(".page-data").data();
  // dt_url      = page_data.url;
  // dt_module   = page_data.module;

  var form_filter = '#form-filter';
  Searchx = $(form_filter + ' [name=f-Search').val();

  data_post = {
    // page_url        : dt_url,
    // page_module     : dt_module,
    Searchx: Searchx,
  };
  //datatables
  table = $('#table-daftar-pegawai-pt').DataTable({
    searching: true,
    processing: true, //Feature control the processing indicator.
    serverSide: true, //Feature control DataTables' server-side processing mode.
    destroy: true,
    order: [], //Initial no order.
    // Load data for the table's content from an Ajax source
    ajax: {
      url: url_list_sdm,
      data: data_post,
      type: 'POST',
      dataSrc: function (json) {
        return json.data;
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      },
    },
    //Set column definition initialisation properties.
    columnDefs: [
      {
        targets: [], //last column
        orderable: false, //set not orderable
        className: 'ellipsis1',
        targets: [4],
      },
    ],
    language: {
      infoFiltered: '',
    },
  });
}

$(document).ready(function () {
  // create a data table
  var form_filter = '#form-filter';
  var table = $('#table-daftar-pegawai-pt').DataTable();

  // add custom listener to draw event on the table
  table.on('draw', function () {
    // get the search keyword
    // var keyword = $('#table-daftar-pegawai-pt_filter > label:eq(0) > input').val();
    Searchx = $(form_filter + ' [name=f-Search').val();

    // clear all the previous highlighting
    $('#table-daftar-pegawai-pt').unmark();

    // highlight the searched word
    $('#table-daftar-pegawai-pt').mark(Searchx, {});
  });
});

function filter_table2() {
  // page_data   = $(".page-data").data();
  // dt_url      = page_data.url;
  // dt_module   = page_data.module;

  var form_filter = '#form-filter2';
  Searchx = $(form_filter + ' [name=f-Search').val();

  data_post = {
    // page_url        : dt_url,
    // page_module     : dt_module,
    Searchx: Searchx,
  };
  //datatables
  table = $('#table-daftar-pegawai').DataTable({
    searching: false,
    processing: true, //Feature control the processing indicator.
    serverSide: true, //Feature control DataTables' server-side processing mode.
    destroy: true,
    order: [], //Initial no order.
    // Load data for the table's content from an Ajax source
    ajax: {
      url: url_list_non,
      data: data_post,
      type: 'POST',
      dataSrc: function (json) {
        return json.data;
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      },
    },
    //Set column definition initialisation properties.
    columnDefs: [
      {
        targets: [], //last column
        orderable: false, //set not orderable
        className: 'ellipsis1',
        targets: [4],
      },
    ],
    language: {
      infoFiltered: '',
    },
  });
}

$(document).on('click', function () {
  $('.action_list').removeClass('active');
});

var index_dt;
$('#table-daftar-pegawai-pt tbody').on('click', 'tr', function (event) {
  index_dt = $(this).index();
  // $('.action_list').removeClass('active');
  // $('#table-daftar-pegawai-pt tbody tr td .action_list').eq(index_dt).addClass("active");
  // event.stopPropagation();
  val = $('#table-daftar-pegawai-pt .dt-id').eq(index_dt).data();
  short_click(val);
});

var index_dt2;
$('#table-daftar-pegawai tbody').on('click', 'tr', function (event) {
  index_dt2 = $(this).index();
  // $('.action_list').removeClass('active');
  // $('#table-daftar-pegawai tbody tr td .action_list').eq(index_dt2).addClass("active");
  // event.stopPropagation();
  val = $('#table-daftar-pegawai .dt-id').eq(index_dt2).data();
  short_click2(val);
});

function action_edit() {
  val = $('#table-daftar-pegawai-pt .dt-id').eq(index_dt).data();
  short_click(val);
}

function action_edit2() {
  val = $('#table-daftar-pegawai .dt-id').eq(index_dt2).data();
  short_click2(val);
}

function batal() {
  location.reload();
  reload_table();
  window.scrollTo(0, 0);
}

function short_click(p1) {
  open_form('edit', p1.id);
}

function short_click2(p1) {
  open_form('edit2', p1.id);
}

function edit_data(p1) {
  page_data = $('.page-data').data();
  dt_url = page_data.url;
  dt_module = page_data.module;

  xform = '#form-sdm-pt';
  // $(xform)[0].reset();
  $(xform + ' .form-control-feedback').text('');
  $(xform + ' .has-danger').removeClass('has-danger');

  $('#v-form-pt').show();
  $('#form-sdm-non').hide();
  $('#v-form-non').hide();
  $('#form-sdm-pt').show();
  $('#form-dashboard').hide();

  data_post = {
    ID: p1,
    page_url: dt_url,
    page_module: dt_module,
  };
  $.ajax({
    url: url_edit_sdm,
    type: 'POST',
    data: data_post,
    dataType: 'JSON',
    success: function (data) {
      show_console(data);
      window.scrollTo(0, 0);

      id_form = '<h4 class="id-form v-form">ID FORM #' + p1 + '</h4>';
      $('.id_form').append(id_form);

      if (data.status) {
        dt_value = data.data;
        $(xform + ' [name=crud]').val('update');
        $(xform + ' [name=ID]').val(p1);

        $(xform + ' [name=Nama]').val(dt_value.Nama_personil);
        $(xform + ' [name=Proyek]').val(dt_value.Proyek);
        $(xform + ' [name=Peride_proyek_mulai]').val(
          dt_value.Periode_proyek_mulai,
        );
        $(xform + ' [name=Peride_proyek_selesai]').val(
          dt_value.Periode_proyek_selesai,
        );

        if (dt_value.Status_pegawai == 'Tersedia') {
          $('#tersedia').prop('checked', true);
        } else if (dt_value.Status_pegawai == 'Tender') {
          $('#tender').prop('checked', true);
        } else if (dt_value.Status_pegawai == 'Terkontrak') {
          $('#terkontrak').prop('checked', true);
        }
      } else {
        open_form('close');
        show_invalid_response(data);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data');
      console.log(jqXHR.responseText);
    },
  });
}

function edit_data2(p1) {
  page_data = $('.page-data').data();
  dt_url = page_data.url;
  dt_module = page_data.module;

  xform = '#form-sdm-non';
  // $(xform)[0].reset();
  $(xform + ' .form-control-feedback').text('');
  $(xform + ' .has-danger').removeClass('has-danger');

  $('#v-form-pt').hide();
  $('#form-sdm-pt').hide();

  $('#v-form-non').show();
  $('#form-sdm-non').show();

  $('#form-dashboard').hide();

  data_post = {
    ID: p1,
    page_url: dt_url,
    page_module: dt_module,
  };
  $.ajax({
    url: url_edit_non,
    type: 'POST',
    data: data_post,
    dataType: 'JSON',
    success: function (data) {
      show_console(data);
      window.scrollTo(0, 0);

      id_form = '<h4 class="id-form v-form">ID FORM #' + p1 + '</h4>';
      $('.id_form').append(id_form);

      if (data.status) {
        dt_value = data.data;
        $(xform + ' [name=crud]').val('update');
        $(xform + ' [name=ID]').val(p1);

        $(xform + ' [name=Nama]').val(dt_value.Nama_personil);
        $(xform + ' [name=Proyek]').val(dt_value.Proyek);
        $(xform + ' [name=Nama_perusahaan]').val(dt_value.Nama_perusahaan);
        $(xform + ' [name=Peride_proyek_mulai]').val(
          dt_value.Periode_proyek_mulai,
        );
        $(xform + ' [name=Peride_proyek_selesai]').val(
          dt_value.Periode_proyek_selesai,
        );

        if (dt_value.Status_pegawai == 'Tersedia') {
          $('#tersedia1').prop('checked', true);
        } else if (dt_value.Status_pegawai == 'Terkontrak') {
          $('#terkontrak1').prop('checked', true);
        }
      } else {
        open_form('close');
        show_invalid_response(data);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data');
      console.log(jqXHR.responseText);
    },
  });
}

function edit_custom() {
  page_data = $('.page-data').data();
  dt_url = page_data.url;
  dt_module = page_data.module;

  xform = '#form-sdm-pt';
  // $(xform)[0].reset();
  $(xform + ' .form-control-feedback').text('');
  $(xform + ' .has-danger').removeClass('has-danger');

  $('.form-view input').attr('disabled', false);
  $('.form-view input').attr('readonly', false);
  $('.form-view').removeClass('content-hide');

  $('.Nama').prop('onclick', null).off('click');
}

function edit_custom2() {
  page_data = $('.page-data').data();
  dt_url = page_data.url;
  dt_module = page_data.module;

  xform = '#form-sdm-non';
  // $(xform)[0].reset();
  $(xform + ' .form-control-feedback').text('');
  $(xform + ' .has-danger').removeClass('has-danger');

  $('.form-view input').attr('disabled', false);
  $('.form-view input').attr('readonly', false);
  $('.form-view').removeClass('content-hide');

  $('.Nama').prop('onclick', null).off('click');
}

function save_sdm(p1) {
  xform = '#form-sdm-pt';
  $(xform + ' .form-control-feedback').text('');
  $(xform + ' .has-danger').removeClass('has-danger');
  $(xform + ' .select2-has-danger').removeClass('select2-has-danger');
  proccess_save();

  add_data_page(xform);
  // ajax adding data to database
  var xform = $(xform)[0]; // You need to use standard javascript object here
  var formData = new FormData(xform);
  $.ajax({
    url: url_save_non,
    type: 'POST',
    data: formData,
    dataType: 'JSON',
    mimeType: 'multipart/form-data', // upload
    contentType: false, // upload
    cache: false, // upload
    processData: false, //upload
    success: function (data) {
      show_console(data);
      if (data.status) {
        //if success close modal and reload ajax table
        swal(
          {
            title: 'Berhasil',
            text: data.message,
            type: 'success',
            icon: 'success',
            confirmButtonText: 'OK',
            showCancelButton: false,
          },
          function () {
            reload_table();
            location.reload();
            window.scrollTo(0, 0);
          },
        );
      } else {
        show_invalid_response(data);
      }
      end_save();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data');
      console.log(jqXHR.responseText);
      end_save();
    },
  });
}

function save_sdm_non(p1) {
  xform = '#form-sdm-non';
  $(xform + ' .form-control-feedback').text('');
  $(xform + ' .has-danger').removeClass('has-danger');
  $(xform + ' .select2-has-danger').removeClass('select2-has-danger');
  proccess_save();

  add_data_page(xform);
  // ajax adding data to database
  var xform = $(xform)[0]; // You need to use standard javascript object here
  var formData = new FormData(xform);
  $.ajax({
    url: url_save_sdm,
    type: 'POST',
    data: formData,
    dataType: 'JSON',
    mimeType: 'multipart/form-data', // upload
    contentType: false, // upload
    cache: false, // upload
    processData: false, //upload
    success: function (data) {
      show_console(data);
      if (data.status) {
        //if success close modal and reload ajax table
        swal(
          {
            title: 'Berhasil',
            text: data.message,
            type: 'success',
            icon: 'success',
            confirmButtonText: 'OK',
            showCancelButton: false,
          },
          function () {
            reload_table();
            location.reload();
            window.scrollTo(0, 0);
          },
        );
      } else {
        show_invalid_response(data);
      }
      end_save();
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data');
      console.log(jqXHR.responseText);
      end_save();
    },
  });
}

$(document).on('mouseenter', '.iffyTip', function () {
  var $this = $(this);
  if (this.offsetWidth < this.scrollWidth && !$this.attr('title')) {
    $this.tooltip({
      title: $this.text(),
      placement: 'top',
    });
    $this.tooltip('show');
  }
});
$('.hideText').css('width', $('.hideText').parent().width());
