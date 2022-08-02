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
                <!-- <?php $this->load->view($filter); ?> -->
                <table id="table-list" class="tablesaw table-bordered table-hover table-cursor table table-responsive-lg" style="width:100% !important">
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

<!-- <script src="<?= base_url('asset/js/custom/backend/upload_cv.js') ?>"></script> -->

<script src="<?= base_url('asset/js/custom/backend/upload_cv.js').$this->main->version_js() ?>"></script>

<style>
    .btn-custom{
        padding: 10px 50px 10px 50px;
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
    .page-titles {
        background: #E6E9FB;
        padding: 14px;
        margin: 5px 0px 20px 0px;
        border-radius: 2px;
    }
    .margin-right{
        margin-right: 10%;
    }
    .btn-browse{
        background: rgb(69,90,228);
        background: linear-gradient(90deg, rgba(69,90,228,1) 0%, rgba(72,134,255,1) 100%);
    }
    .btn-save-custom{
        background: rgb(69,90,228);
        background: linear-gradient(90deg, rgba(69,90,228,1) 0%, rgba(72,134,255,1) 100%);
        color: #fff;
        font-size: 10px;
    }
    .btn-cancel-custom{
        background: rgb(255 255 255);
        color: #000;
        font-size: 10px;
        border: solid 1px;
    }
    .datepicker table thead {
        background: #ffffff;
        color: black;
        /* border: none !important; */
    }
</style>

<script>
    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true,
    }).mask("9999-99-99");
    open_form('form');
</script>