<!-- Bread crumb and right sidebar toggle -->
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
            <?= $edit ?>
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
                <div class="row el-element-overlay">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <small class="text-muted"><?= $this->lang->line('lb_name') ?></small>
                                <h6><?= $this->session->PageName ?></h6>
                                <small class="text-muted"><?= $this->lang->line('lb_summary') ?></small>
                                <h6><?= $this->session->PageSummary ?></h6>
                                <small class="text-muted"><?= $this->lang->line('lb_type') ?></small>
                                <h6><?= $this->session->PageType ?></h6>
                                <small class="text-muted"><?= $this->lang->line('lb_status') ?></small>
                                <h6><?= $this->session->PageStatus ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <strong class="text-muted"><?= $this->lang->line('lb_description') ?></strong>
                                        <h6><?= $this->session->PageDescription ?></h6>
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

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- PLUGIN -->
<link href="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css') ?>" rel="stylesheet">
<link href="<?= base_url('asset/css/pages/user-card.css') ?>" rel="stylesheet">

<!-- Plugins For This Page -->
<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') ?>"></script>

<script src="<?= base_url('asset/js/custom/backend/page_setting.js').$this->main->version_js() ?>"></script>