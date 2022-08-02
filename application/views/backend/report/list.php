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
</style>

<!-- Bread crumb and right sidebar toggle -->
<div class="row page-titles page-data" data-url="<?= $url ?>" data-module="<?= $module ?>">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"><?= $title ?></h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= site_url($url) ?>"><?= $title ?></a></li>
            </ol>
        </div>
    </div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<!-- Start Page Content -->
<div class="row list-view">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_list_data') ?></h4>
            </div>
            <div class="card-body">
                <?php $this->load->view($filter); ?>
                <div class="div_loader">
                    <div class="loader"><div class="loader-1"></div></div>
                </div>
                <div class="view_data"></div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('backend/modal/modal_company') ?>
<?php $this->load->view('backend/modal/modal_user_company') ?>
<?php $this->load->view('backend/report/modal') ?>

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- Plugin -->
<link href="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/node_modules/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>"></script>
<link href="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<script src="<?= base_url('asset/js/plugin/redirect/jquery.redirect.js').$this->main->version_js() ?>"></script>
<script src="<?= base_url('asset/js/custom/backend/report.js').$this->main->version_js() ?>"></script>

<script>
    // MAterial Date picker    \
    $('.mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
</script>