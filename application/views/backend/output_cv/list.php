<!-- Form -->
<?php $this->load->view($form); ?>
<!-- End Form -->

<div class="row list-view" style="margin-top: 2%;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row page-data list" data-url="<?= $url ?>" data-module="<?= $module ?>">
                    <div class="col-md-9 align-self-center">
                        <h4 class="form-text v-list">CARI OUTPUT BERDASARKAN KATEGORI INPUT</h4>
                    </div>
                    <div class="col-md-3 align-self-center text-right">
                        <?php $this->load->view($filter_search1); ?>
                        <?php $this->load->view($filter_search2); ?>
                    </div>
                </div>
            </div>
            <div class="card-body v-table-konstruksi">
                <?php $this->load->view($filter); ?>
                <table id="table-list" class="tablesaw table-bordered table-hover table-cursor table table-responsive-lg dataTables-Normal" style="width:100% !important">
                    <thead>
                        <tr>
                            <th width="120">
                                <input type="checkbox" class="checkbox" id="checkAll">
                            </th>
                            <th>ID</th>
                            <th>POSISI</th>
                            <th>NAMA PERSONIL</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <br>
                <div class='action-buttons mobile-pt-25'>
                    <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="hapus()">HAPUS KONTRUKSI</button>
                </div>
            </div>
            <div class="card-body v-table-non-konstruksi">
                <?php $this->load->view($filter); ?>
                <table id="table-list-non" class="tablesaw table-bordered table-hover table-cursor table table-responsive-lg dataTables-Normal" style="width:100% !important">
                    <thead>
                        <tr>
                            <th width="120">
                                <input type="checkbox" class="checkbox" id="checkAll2">
                            </th>
                            <th>ID</th>
                            <th>POSISI</th>
                            <th>NAMA PERSONIL</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <br>
                <div class='action-buttons mobile-pt-25'>
                    <button type="button" class="btn waves-effect waves-light btn-custom btn-batal" onclick="hapus2()">HAPUS NON KONTRUKSI</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="daftar_riwayat" class="row list-view" style="margin-top: 2%;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row page-data list" data-url="<?= $url ?>" data-module="<?= $module ?>">
                    <div class="col-7 align-self-center">
                        <h4 class="form-text v-list">DAFTAR RIWAYAT HIDUP</h4>
                    </div>
                    <div class="col-5 align-self-center text-right">
                        <a id="download" class="download"><img class="margin-right" width="35" src="<?= base_url('img/icon/entypo_download.png')?>"></a>
                        <a id="print" target="_blank" class="print"><img class="" width="42" src="<?= base_url('img/icon/fluent_print-20-filled.png')?>"></a>
                        <!-- <span class="pointer print" onclick="printIframe()"><img width="42" src="<?= base_url('img/icon/fluent_print-20-filled.png')?>"></i></span> -->
                    </div>
                </div>
            </div>
            <div class="card-body">
                <iframe id="office" class ="office iframe" style="background-color: white;" width="100%" height="1200px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" role="document" aria-label="Doc document" title="Doc document" ></iframe> 
            </div>
        </div>
        <div class="boder" style="border: 2px dashed #000000;padding: 15px;">
            <span style="font-size: larger; font-weight: bold;color: red;"> * Catatan :</span><br>
            <span style="font-size: larger; font-weight: bold;color: black;font-style: italic;">Apabila setelah edit data dan ingin melihat file tersebut, jika belum sesuai silahkan click icon berikut.  
                <img src="<?= base_url('img/icon/note_cv.png')?>" style="width: 100%;margin-top: 10px;">
            </span>
        </div>
    </div>
</div>

<div class="row list-view" style="margin-top: 2%;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row page-data list" data-url="<?= $url ?>" data-module="<?= $module ?>">
                    <div class="col-7 align-self-center">
                        <h4 class="form-text v-list">SURAT REFERENSI</h4>
                    </div>
                    <div class="col-5 align-self-center text-right">
                        <a name="download_refferensi" id="download_refferensi" class="download_refferensi"><img class="margin-right" width="35" src="<?= base_url('img/icon/entypo_download.png')?>"></a>
                        <a name="print_refferensi" id="print_refferensi" class="print_refferensi"><img width="42" src="<?= base_url('img/icon/fluent_print-20-filled.png')?>">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <iframe id="refferensi" class="refferensi" width="100%" height="1200px"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<?php $this->load->view('backend/modal/modal_riwayat') ?>
<?php $this->load->view('backend/modal/modal_pengalaman') ?>
<?php $this->load->view('backend/modal/modal_penugasan') ?>
<!-- Modal -->

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- Plugin -->
<link href="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/node_modules/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>"></script>
<link href="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<!-- PLUGIN -->
<link href="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css') ?>" rel="stylesheet">
<link href="<?= base_url('asset/css/pages/user-card.css') ?>" rel="stylesheet">

<!-- Plugins For This Page -->
<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') ?>"></script>

<link href="<?= base_url('assets/node_modules/summernote/dist/summernote.css') ?>" rel="stylesheet"/>
<!-- End CSS -->

<!-- Start JS -->
<script src="<?= base_url('assets/node_modules/summernote/dist/summernote.min.js') ?>" type="text/javascript"></script>

<!-- <script src="<?= base_url('asset/js/custom/backend/output_cv.js') ?>"></script> -->

<script src="<?= base_url('asset/js/custom/backend/output_cv.js').$this->main->version_js() ?>"></script>

<style>
    .checkbox{
        cursor: pointer;
    }

    td>label>.checkbox{
        margin-right : 10px !important;
        /*margin-left : 10px;*/
    }

    .btn-custom{
        padding: 10px 50px 10px 50px !important;
    }
    .form-text{
        color: #000000;
        font-weight: 600;
        font-size: large;
    }
    .form-text1{
        color: #4660E8;
        font-weight: 600;
        font-size: large;
    }

    .id-form{
        color: #000000;
        font-weight: 500;
    }
    .card-footer, .card-header {
        padding: 1.75rem 1.25rem;
        background-color: rgb(255 255 255);
        border-bottom: 1px solid lightgrey;
    }
    .button {
        font-weight:500;
    }
    .page-titles {
        background: #E6E9FB;
        padding: 14px;
        margin: 20px 0px 20px 0px;
        border-radius: 2px;
    }
    .margin-right{
        margin-right: 10%;
    }
    .embed-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        max-width: 100%;
    }
    .embed-container iframe, .embed-container object, .embed-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 200px;
        height: 100%;
    }
</style>
