<style type="text/css">
    .loader-1 {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #03a9f3;
        border-right: 16px solid #00c292;
        border-bottom: 16px solid #e46a76;
        border-left: 16px solid #ab8ce4;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }
    .counter {
        margin-left: 210px;
    }
</style>

<div id="form-dashboard">
  <h4 class='d-md-none d-lg-none' style='font-weight:bold'>Dashboard</h4>
  <div class="row">

      <div class="col-lg-8 col-md-12">
       <div class="card card-frame">
          <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                <h5 class="card-title title-with-border-bottom d-md-none d-lg-none">Statistik Pegawai</h5>
                  <h5 class="card-title d-none d-md-block d-lg-block d-xl-block">Dashboard</h5>
                  <h6 class='d-none d-md-block d-lg-block d-xl-block'>Statistik Pegawai</h6>
                  <div class='mobile-statistik-pegawai-flex'>
                    <div>
                      <h6 class='d-md-none d-lg-none'>Pegawai</h6>
                      <h1 class="card-title total_peg text-primary-color" style="margin-top:20px">0</h1>
                      <h6 class='d-none d-md-block d-lg-block d-xl-block'>Pegawai</h6>
                    </div>
                    <div>
                      <h6 class='d-md-none d-lg-non'>Karyawan bulan ini</h6>
                      <h1 class="card-title total_peg_bulan text-primary-color" style="margin-top:20px">0</h1>
                      <h6 class='d-none d-md-block d-lg-block d-xl-block'>Karyawan bulan ini</h6>
                    </div>
                  </div>
                </div>
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <div class="wrapper mt-4">
                    <canvas id="myChart"></canvas>
                  </div>
                  
                </div>
            </div>  
          </div>                             
          <div class="card-body">
            <hr class='ml-4 mr-4' />
            <div class="row">
                <div class="col-md-12">
                  <div class="row g-0">
                    <div class="col-lg-4 col-md-6">
                      <!-- <div class="card border"> -->
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12 desktop-divider-right">
                              <div class="d-flex no-block align-items-center">
                              <div class="sl-left"><img class="img-circle" alt="user" src="<?= base_url('img/icon/01.png')?>"></div>
                                <div class="sl-right" style="margin-left:10px;">
                                    <div class="font-medium">Terkontrak</div>
                                    <div class="desc total_terkontrak">0</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- </div> -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <!-- <div class="card border"> -->
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12 desktop-divider-right">
                              <div class="d-flex no-block align-items-center">
                                <div class="sl-left"><img class="img-circle" alt="user" src="<?= base_url('img/icon/02.png')?>"></div>
                                <div class="sl-right" style="margin-left:10px;">
                                    <div class="font-medium">Tersedia</div>
                                    <div class="desc total_tersedia">0</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- </div> -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <!-- <div class="card border"> -->
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="d-flex no-block align-items-center">
                              <div class="sl-left"><img class="img-circle" alt="user" src="<?= base_url('img/icon/03.png')?>"></div>
                                <div class="sl-right" style="margin-left:10px;">
                                    <div class="font-medium">Tender</div>
                                    <div class="desc total_tender">0</div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- </div> -->
                    </div>

                  </div>
                </div>
            </div>  
          </div>                             
        </div>
      </div>
      
      <div class="col-lg-4 col-md-12">
        <div class="card card-frame dash-status-pegawai">
            <div class="card-body">
              <div class="row">
                      <div class="col-md-12 col-sm-6 col-xs-12">
                      <h5 class="card-title title-with-border-bottom">Status Pegawai</h5>
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                <canvas id="status_pegawai"  width="200" height="130"></canvas>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                        <hr class='mb-4' />
                        <div class="row">
                            <div class="col-md-12">
                              <div class="row g-0 text-center">
                                <div class="col-4">
                                  <!-- <div class="card border"> -->
                                    <!-- <div class="card-body"> -->
                                      <div class="row divider-right">
                                        <div class="col-md-12">
                                          <div class="d-flex no-block align-items-center justify-content-center">
                                            <div class="sl-right">
                                                <div class="font-medium total_tersedia" style="font-size: xx-large;">0</div>
                                                <div class="desc"><i class="fa fa-circle text-green"></i><span class='mobile-font-size' style="margin-left:10px;">Tersedia</span></div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- </div> -->
                                  <!-- </div> -->
                                </div>
                                <div class="col-4">
                                  <!-- <div class="card border"> -->
                                    <!-- <div class="card-body"> -->
                                      <div class="row divider-right">
                                        <div class="col-md-12">
                                          <div class="d-flex no-block align-items-center justify-content-center">
                                            <div class="sl-right">
                                                <div class="font-medium total_terkontrak" style="font-size: xx-large;">0</span></div>
                                                <div class="desc"><i class="fa fa-circle text-red"></i><span class='mobile-font-size' style="margin-left:10px;">Kontrak</span></div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- </div> -->
                                  <!-- </div> -->
                                </div>
                                <div class="col-4">
                                  <!-- <div class="card border"> -->
                                    <!-- <div class="card-body"> -->
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="d-flex no-block align-items-center justify-content-center">
                                            <div class="sl-right">
                                                <div class="font-medium total_tender" style="font-size: xx-large;">0</div>
                                                <div class="desc"><i class="fa fa-circle text-yellow"></i><span class='mobile-font-size' style="margin-left:10px;">Tender</span></div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- </div> -->
                                  <!-- </div> -->
                                </div>
                              </div>
                            </div>
                        </div>  
                      </div>  
                    </div>
                </div>
            </div>
        </div>
      </div>
  </div>

  <div class="row">

      <!-- <div class="col-lg-4 col-md-12">
        <div class="card">
          <div class="card-body" style="height: 644px;">
              <h5 class="card-title">Proyek Terbaru</h5>
              <h6>Hasil dari beberapa tahun pekerjaan proyek</h6>
              <div class="steamline m-t-40">
                  <div class="sl-item">
                      <div class="sl-left"><img class="img-circle" alt="user" src="<?= base_url('img/icon/1.png')?>"></div>
                      <div class="sl-right">
                          <div class="font-medium">2021</div>
                          <div class="desc">280 Current Project</div>
                      </div>
                  </div>
                  <div class="list_proyek"></div>
              </div>
          </div>
        </div>
      </div> -->

      <div class="col-lg-12 col-md-12">
          <div class="card card-frame col-md-12">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-9">
                        <h5 class="card-title universal-title-with-border-bottom">Tenaga Ahli</h5>
                        <h6>PT.Ciriajasa E.C. memiliki tenaga ahli yang kompeten</h6>
                    </div>
                    <div class="col-md-3 align-self-center text-right">
                      <?php $this->load->view($filter3); ?>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="padding: 0.25rem 1.25rem 0px 1.25rem;">
                <table id="table-biodata" class="table table-hover no-wrap" style="width: 100%;">
                    <thead style="background: #3c4195;color: white;">
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Pendidikan</th>
                          <th>SKA/ Sertifikat</th>
                          <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody style="font-weight:bold;">
                    </tbody>
                </table>
            </div>
            <div id='table-biodata-pagination' class='pagination-info-data'>
                <div class='display-info'>
                      
                </div>
                <div class='pagination'>
                    <button class='prev-btn'><i class='fa fa-arrow-left'></i></button>
                      <span class='curr-page'></span>
                      <button class='next-btn'><i class='fa fa-arrow-right'></i></button>
                   </div>
            </div>
        </div>
      </div>

  </div>

  <div class="card-group list-view card-frame">
      <div class="card col-md-12">
          <div class="card-body pb-0">
              <div class="row page-data list" data-url="<?= $url ?>" data-module="<?= $module ?>">
                <div class="col-md-9 align-self-center">
                    <h4 class="card-title universal-title-with-border-bottom">Status Pegawai Available PT.Ciriajasa E.C.</h4>
                </div>
                <div class="col-md-3 align-self-center text-right">
                  <?php $this->load->view($filter); ?>
                </div>
              </div>
          </div>
          <div class="table-responsive" style="padding: 0.25rem 1.25rem 0px 1.25rem;">
              <table id="table-daftar-pegawai-pt" class="table table-hover no-wrap" style="width:100%;">
                  <thead style="background: #3c4195;color: white;">
                    <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">NO</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">STATUS</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA PERUSAHAAN</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">PROYEK</th>
                        <th colspan="2" style="horizontal-align : middle;text-align:center;">PERIODE PROYEK</th>
                    </tr>
                    <tr>
                        <th scope="col">MULAI</th>
                        <th scope="col">SELESAI</th>
                    </tr>
                  </thead>
                  <tbody style="font-weight:bold"></tbody>
              </table>
          </div>
          <div id='table-daftar-pegawai-pt-pagination' class='pagination-info-data'>
                <div class='display-info'>
                      
                </div>
                <div class='pagination'>
                    <button class='prev-btn'><i class='fa fa-arrow-left'></i></button>
                    <span class='curr-page'></span>
                    <button class='next-btn'><i class='fa fa-arrow-right'></i></button>
                </div>
          </div>
      </div>
  </div>
  <div class="card-group card-frame">
      <div class="card col-md-12">
          <div class="card-body pb-0">
              <div class="row">
                <div class="col-md-9 align-self-center">
                    <h4 class="card-title universal-title-with-border-bottom">Status Pegawai Available Non PT.Ciriajasa E.C.</h4>
                </div>
                <div class="col-md-3 align-self-center text-right">
                  <?php $this->load->view($filter2); ?>
                </div>
              </div>
          </div>
          <div class="table-responsive" style="padding: 0.25rem 1.25rem 0px 1.25rem;">
              <table id="table-daftar-pegawai" class="table table-hover no-wrap" style="width:100%;">
                  <thead style="background: #3c4195;color: white;">
                    <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">NO</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">STATUS</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">NAMA PERUSAHAAN</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;">PROYEK</th>
                        <th colspan="2" style="horizontal-align : middle;text-align:center;">PERIODE PROYEK</th>
                    </tr>
                    <tr>
                        <th scope="col">MULAI</th>
                        <th scope="col">SELESAI</th>
                    </tr>
                  </thead>
                  <tbody style="font-weight:bold"></tbody>
              </table>
          </div>
          <div id='table-daftar-pegawai-pagination' class='pagination-info-data'>
                <div class='display-info'>
                      
                </div>
                <div class='pagination'>
                    <button class='prev-btn'><i class='fa fa-arrow-left'></i></button>
                    <span class='curr-page'></span>
                    <button class='next-btn'><i class='fa fa-arrow-right'></i></button>
                </div>
          </div>
      </div>
  </div>
</div>

<!-- Form -->
<?php $this->load->view($form); ?>
<!-- End Form -->

<!-- Modal -->
<?php $this->load->view('backend/modal/modal_notif') ?>
<!-- Modal -->

<div class="div_loader">
    <div class="loader"><div class="loader-1"></div></div>
</div>


<style>
  .text-green {
    color: #4ec662!important
  }
  .text-red {
    color: #ff5d73!important
  }
  .text-yellow {
    color: #fce353!important
  }
  .edit{
    position: absolute;
    margin-left: -83px;
  }
  .view{
    position: absolute;
    margin-left: -50px;
    margin-top: 2px;
  }
  .footer {
        bottom: 0;
        left: 0;
        padding: 17px 15px;
        right: 0;
        border-top: 1px solid #e9ecef;
        background: #fff;
        margin-left: 0px !important;
    }
  .btn-browse{
      background: rgb(69,90,228);
      background: linear-gradient(90deg, rgba(69,90,228,1) 0%, rgba(72,134,255,1) 100%);
  }

  .img_data{
      background-image: url('img/icon/Logo.png');
  }
  .ellipsis {
    text-overflow: ellipsis;
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
  }
  .ellipsis1 {
    text-overflow: ellipsis;
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
  }
  .btn-custom{
      padding: 10px 50px 10px 50px;
  }
  .form-text1{
      color: #5379F1;
      font-weight: 600;
  }

  .id-form{
      color: #000000;
      font-weight: 500;
  }
  
  .datepicker table thead {
      background: #ffffff;
      color: black;
      /* border: none !important; */
  }
  .text-center{
    text-align: center;
  }
</style>

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>
<!-- Chart JS -->
<!-- <script src="<?= base_url('asset/js/plugin/chartjs/chart.js') ?>"></script> -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js'></script>
<!-- Sweet Alert -->
<link href="<?= base_url('assets/node_modules/sweetalert/sweetalert.css') ?>" rel="stylesheet" type="text/css">
<script src="<?= base_url('assets/node_modules/sweetalert/sweetalert.min.js') ?>"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<!-- Datepicker -->
<link href="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/node_modules/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>"></script>
<link href="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<script src="<?= base_url('asset/js/custom/backend/dashboard.js') ?>"></script>

<script>  
  // $('#modal-notif').modal('show');
  // swal({
  //     title   : "Welcome to <br> Digital E-Database CV",
  //     html    : true,
  //     text    : "Have a nice day",
  //     // imageUrl: url_string+"/img/icon/image-83.png",
  //     imageWidth: 600,
  //     imageHeight: 600,
  //     confirmButtonText: 'Ok',
  // }, function () {
  //     window.scrollTo(0, 0);
  // });
  
  $('.date').datepicker({
      format: 'yyyy-mm-dd',
      todayHighlight: true,
      autoclose: true,
  }).mask("9999-99-99");
</script>