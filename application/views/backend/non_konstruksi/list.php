<?php $this->load->view($b_list); ?>

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
                            <th><?= $this->lang->line('lb_code') ?></th>
                            <th><?= $this->lang->line('lb_name') ?></th>
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


<link href="<?= base_url('assets/node_modules/summernote/dist/summernote.css') ?>" rel="stylesheet"/>
<link href="<?= base_url('dist/css/style.min.css') ?>" rel="stylesheet"/>
<!-- End CSS -->

<!-- Start JS -->
<script src="<?= base_url('assets/node_modules/summernote/dist/summernote.min.js') ?>" type="text/javascript"></script>

<!-- <script src="<?= base_url('asset/js/custom/backend/non_konstruksi.js') ?>"></script> -->

<script src="<?= base_url('asset/js/custom/backend/non_konstruksi.js').$this->main->version_js() ?>"></script>

<style>
    .btn-custom{
        padding: 10px 50px 10px 50px;
    }
    .form-text{
        color: #5379F1;
        font-weight: 600;
    }

    .id-form{
        color: #000000;
        font-weight: 500;
    }

</style>

<script>
    // MAterial Date picker    \
    $('.mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    open_form('form');
</script>