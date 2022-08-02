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

<form id="form" autocomplete="off">
    <div class="row form-view">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_page_setting') ?></h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="crud" value="update">
                    <input type="hidden" name="ID">
                    <input type="hidden" name="page_url">
                    <input type="hidden" name="page_module">

                    <div class="form-group m-t-10">
                        <div class="form-group">
                            <label class="control-label"><?= $this->lang->line('lb_type') ?></label>
                            <select name="Type" placeholder="Type" id="Type" class="form-control"> 
                                <option value="1">Policy Page Setting</option>
                                <option value="2">Term & Conditon</option>
                            </select>
                            <small class="form-control-feedback"></small>
                        </div>
                        <hr>
                        <div class="form-group v_page">
                            <label class="control-label"><?= $this->lang->line('lb_name') ?> <span class="wajib"></span></label>
                            <input type="text" id="Name" name="Name" value="<?= $this->session->PageName ?>" class="form-control">
                            <small class="form-control-feedback"></small>
                        </div>
                        <div class="form-group v_term">
                            <label class="control-label"><?= $this->lang->line('lb_name') ?> <span class="wajib"></span></label>
                            <input type="text" id="Nameterm" name="Nameterm" value="<?= $this->session->PageName ?>" class="form-control">
                            <small class="form-control-feedback"></small>
                        </div>
                        <div class="form-group v_page">
                            <label class="control-label"><?= $this->lang->line('lb_summary') ?> <span class="wajib"></span></label>
                            <input type="text" id="Summary" name="Summary" value="<?= $this->session->PageSummary ?>" class="form-control">
                            <small class="form-control-feedback"></small>
                        </div>
                        <div class="form-group v_term">
                            <label class="control-label"><?= $this->lang->line('lb_summary') ?> <span class="wajib"></span></label>
                            <input type="text" id="Summaryterm" name="Summaryterm" value="<?= $this->session->PageSummary ?>" class="form-control">
                            <small class="form-control-feedback"></small>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= $this->lang->line('lb_status') ?></label>
                            <select name="Status" placeholder="Status" id="Status" class="form-control"> 
                                <option value="1">Publish</option>
                                <option value="2">Unpublish</option>
                            </select>
                        </div>
                    </div>
                	<?= $this->main->button('action2') ?>
                </div>
            </div>  
        </div>

        <div class="col-md-8">
            <div class="card">
            	<div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_description') ?></h4>
                </div>
                <div class="card-body v_page">
                    <textarea id="Description" name="Description" value="<?= $this->session->PageDescription ?>" class="form-control summernote" placeholder="Description" style="width: 100%;"></textarea>
                </div>
                <div class="card-body v_term">
                    <textarea id="Descriptionterm" name="Descriptionterm" value="<?= $this->session->PageDescription ?>" class="form-control summernote" placeholder="Description" style="width: 100%;"></textarea>
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

<!-- summernotes CSS -->
<link href="<?= base_url('assets/node_modules/summernote/dist/summernote.css') ?>" rel="stylesheet" />

<script src="<?= base_url('assets/node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/node_modules/summernote/dist/summernote.min.js') ?>" type="text/javascript"></script>

<!-- Plugins For This Page -->
<script src="<?= base_url('asset/js/custom/backend/page_setting_edit.js').$this->main->version_js() ?>"></script>

<script>
    // MAterial Date picker    \
    $('.mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    $('.summernote').summernote({
        height: 350, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });
</script>