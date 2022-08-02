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

<!-- Start Page Content -->
<div class="row list-view">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_list_data') ?></h4>
            </div>
            <div class="card-body">
                <table id="table-list" class="tablesaw table-bordered table-hover table-cursor table table-responsive-lg">
                    <thead>
                        <tr>
                            <th><?= $this->lang->line('lb_no') ?></th>
                            <th><?= $this->lang->line('lb_name') ?></th>
                            <th><?= $this->lang->line('lb_url') ?></th>
                            <th><?= $this->lang->line('lb_root') ?></th>
                            <th><?= $this->lang->line('lb_type') ?></th>
                            <th><?= $this->lang->line('lb_level') ?></th>
                            <th><?= $this->lang->line('lb_parent') ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<?php $this->load->view('backend/modal/modal_icon'); ?>
<!-- End Modal -->

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>
<!-- select2 -->
<link href="<?= base_url('assets/node_modules/select2/dist/css/select2.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/node_modules/select2/dist/js/select2.full.min.js') ?>" type="text/javascript"></script>

<script src="<?= base_url('asset/js/custom/backend/menu.js') ?>"></script>