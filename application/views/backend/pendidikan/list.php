<!-- Bread crumb and right sidebar toggle -->
<!-- Bread crumb and right sidebar toggle -->
<!-- End Bread crumb and right sidebar toggle -->

 
        <div class="card-form with-frame">
            <div class="row page-titles page-data" data-url="<?= $url ?>" data-module="<?= $module ?>">
                <div class="col-md-8 align-self-center">
                    <h4 class="form-text" style="margin-bottom: 3%;">FORM INPUT BIODATA TENAGA AHLI</h4>
                    <h4 class="id-form">ID FORM #<?= $id ?></h4>
                </div>
                <div class="col-md-4 align-self-center text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <!-- <ol class="breadcrumb"> -->
                            <!-- <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li> -->
                            <!-- <li class="breadcrumb-item active"><a href="<?= site_url($url) ?>"><?= $title ?></a></li> -->
                        <!-- </ol> -->
                        <!-- <button type="button" onclick="edit_custom()" class="btn btn-edit btn-custom edit d-lg-block m-l-15"></i>EDIT</button> -->
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
        </div>


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
<?php $this->load->view('backend/modal/modal_role') ?>
<?php $this->load->view('backend/modal/modal_company') ?>
<!-- Modal -->

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<link href="<?= base_url('assets/node_modules/summernote/dist/summernote.css') ?>" rel="stylesheet"/>
<link href="<?= base_url('dist/css/style.min.css') ?>" rel="stylesheet"/>
<!-- End CSS -->

<!-- Start JS -->
<script src="<?= base_url('assets/node_modules/summernote/dist/summernote.min.js') ?>" type="text/javascript"></script>


<!-- Plugin -->
<link href="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/node_modules/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>"></script>
<link href="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<!-- <script src="<?= base_url('asset/js/custom/backend/pendidikan.js') ?>"></script> -->

<script src="<?= base_url('asset/js/custom/backend/pendidikan.js').$this->main->version_js() ?>"></script>

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

    .page-titles1 {
        background: #ffffff;
        /* padding: 14px; */
        margin: 20px 0px 20px 0px;
        border-radius: 2px;
    }

</style>

<script>
    // MAterial Date picker    \
    $('.mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    open_form('form');
</script>