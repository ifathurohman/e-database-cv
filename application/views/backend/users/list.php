<style type="text/css">
  .pac-container {
    z-index: 1800 !important;
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
                            <th><?= $this->lang->line('lb_username') ?></th>
                            <th><?= $this->lang->line('lb_email') ?></th>
                            <th><?= $this->lang->line('lb_role') ?></th>
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
<!-- Modal -->

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>

<!-- PLUGIN -->
<link href="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet') ?>">
<script src="<?= base_url('assets/node_modules/moment/moment.js') ?>"></script>
<script src="<?= base_url('assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>"></script>
<link href="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css') ?>" rel="stylesheet" type="text/css" />
<script src="<?= base_url('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>

<link href="<?= base_url('assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') ?>" rel="stylesheet" />
<script src="<?= base_url('assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') ?>" type="text/javascript"></script>

<!-- Plugins For This Page -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $this->config->item("maps_api"); ?>&libraries=places"></script>
<script src="<?= base_url('asset/js/custom/backend/users.js').$this->main->version_js() ?>"></script>

<script>
    // MAterial Date picker    \
    $('.mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus',
            min: 0,
            max: 3000,
        });
</script>