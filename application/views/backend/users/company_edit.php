<!-- Bread crumb and right sidebar toggle -->
<div class="row page-titles page-data" data-url="<?= $url ?>" data-module="<?= $module ?>" data-lat="<?= $this->session->CompanyLatitude ?>" data-lng="<?= $this->session->CompanyLongitude ?>" data-radius="<?= $this->session->CompanyRadius ?>">
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

<form id="form" autocomplete="off">
    <div class="row form-view">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_logo') ?></h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="crud" value="update">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <center class="m-t-30">
                        <img class="img-circle img-photo img-profile" src="<?= $this->session->CompanyImage ?>">
                    </center>
                    <div class="form-group m-t-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" data-id="img-photo" name="photo" id="photo" accept="image/*">
                                <label class="custom-file-label" for="photo">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_data') ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_name') ?> <span class="wajib"></span></label>
                                <input type="text" id="Name" name="Name" value="<?= $this->session->CompanyName ?>" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_email') ?> <span class="wajib"></span></label>
                                <input type="text" id="Email" name="Email" value="<?= $this->session->CompanyEmail ?>" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_phone_number') ?> <span class="wajib"></span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <select class="form-control" name="PhoneCountry" id="PhoneCountry">
                                            <option>+62</option>
                                        </select>
                                    </div>
                                    <input type="text" name="Phone" id="Phone" value="<?= $this->session->CompanyPhone ?>" placeholder="exp : 81xxxxxxx" class="form-control" aria-label="Text input with dropdown button">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_start_join') ?> <span class="wajib"></span></label>
                                <input type="text" id="StartJoin" name="StartJoin" value="<?= $this->session->CompanyJoinDate ?>" class="form-control mdate" readonly>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_address') ?> <span class="wajib"></span></label>
                                <input type="text" id="Address" name="Address" value="<?= $this->session->CompanyAddress ?>" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_start_work_date') ?> <span class="wajib"></span></label>
                                <input type="text" id="StartWorkDate" name="StartWorkDate" value="<?= $this->session->CompanyStartWorkDate ?>" class="form-control mdate" readonly>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_username') ?></label>
                                <input type="text" id="Username" name="Username" value="<?= $this->session->CompanyUserName ?>" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-6 Password-view">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_password') ?></label>
                                <div class="input-group">
                                    <input type="password" id="Password" name="Password" class="form-control" placeholder="Password" aria-label="Password" autocomplete="new-password">
                                    <div class="input-group-append pointer show_password">
                                        <span class="input-group-text"><i class="btn-icon fa fa-eye"></i></span>
                                    </div>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <?= $this->main->button('action2') ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 content-hide">
            <div class="card">
                <div class="card-header bg-primary">
                    <span class="m-b-0 text-white"><?= $this->lang->line('lb_location') ?></span>
                    <div class="card-actions">
                        <a class="text-white" data-action="collapse"><i class="ti-minus"></i></a>
                    </div>
                </div>
                <div class="card-body show">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_location_name') ?> <span class="wajib"></span></label>
                                <input type="text" id="LocationName" name="LocationName" value="<?= $this->session->CompanyLocation ?>" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <!-- <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_address') ?> <span class="wajib"></span></label>
                                <input type="text" id="Address" name="Address" value="<?= $this->session->CompanyAddress ?>" class="form-control">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div> -->
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_latitude') ?> <span class="wajib"></span></label>
                                <input type="text" id="Latitude" name="Latitude" value="<?= $this->session->CompanyLatitude ?>" class="form-control" readonly placeholder="<?= $this->lang->line('lb_automatic') ?>">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_longitude') ?> <span class="wajib"></span></label>
                                <input type="text" id="Longidute" name="Longidute" value="<?= $this->session->CompanyLongitude ?>" class="form-control" readonly placeholder="<?= $this->lang->line('lb_automatic') ?>">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_radius') ?> (Meters) <span class="wajib"></span></label>
                                <input class="vertical-spin" type="text" data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline"name="Radius" id="Radius" value="<?= $this->session->CompanyRadius ?>">
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="MAPS" style="height: 500px;width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

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
<script src="<?= base_url('asset/js/custom/backend/company_edit.js') ?>"></script>

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