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
            <?= $btn_add ?>
        </div>
    </div>
</div>
<!-- End Bread crumb and right sidebar toggle -->

<!-- Form -->
<?php $this->load->view($form); ?>
<!-- End Form -->

<!-- Import -->
<?php $this->load->view($import); ?>
<!-- END Import -->

<!-- Start Page Content -->
<div class="row list-view">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_list_data') ?></h4>
            </div>
            <div class="card-body">
                <?php $this->load->view($filter); ?>
                <table id="table-list" class="tablesaw table-bordered table-hover table-cursor table table-responsive-lg">
                    <thead>
                        <tr>
                            <th><?= $this->lang->line('lb_no') ?></th>
                            <th><?= $this->lang->line('lb_branch') ?></th>
                            <th><?= $this->lang->line('lb_name_full') ?></th>
                            <th><?= $this->lang->line('lb_gender') ?></th>
                            <th><?= $this->lang->line('lb_email') ?></th>
                            <th><?= $this->lang->line('lb_role') ?></th>
                            <th><?= $this->lang->line('lb_device_default') ?></th>
                            <th><?= $this->lang->line('lb_status') ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<?php $this->load->view('backend/modal/modal_role') ?>
<?php $this->load->view('backend/modal/modal_company') ?>
<?php $this->load->view('backend/modal/modal_pattern') ?>
<?php $this->load->view('backend/modal/modal_user_company') ?>
<?php $this->load->view('backend/modal/modal_branch') ?>
<!-- Modal -->

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- Plugin -->
<link href="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/node_modules/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>"></script>
<link href="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<script src="<?= base_url('asset/js/custom/backend/user_company.js').$this->main->version_js() ?>"></script>

<script>
    // MAterial Date picker    \
    $('.mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
</script>