<?php
    $HakAksesType   = $this->session->HakAksesType;
?>
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
                <div class="row">
                    <div class="col-md-8"></div>
                    <?php if(in_array($HakAksesType, array(1,2))): ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label"><?= $this->lang->line('lb_company') ?></label>
                            <div class="input-group">
                                <div class="input-group-append pointer" onclick="modal_company('.f-CompanyID')">
                                    <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control f-CompanyID-Name" placeholder="Select Company" readonly>
                                <input type="hidden" id="f-CompanyID" name="f-CompanyID" class="f-CompanyID"readonly>
                            </div>
                            <small class="form-control-feedback"></small>
                        </div>
                    </div>
                    <?php else: echo '<div class="col-md-2"></div>'; endif; ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label text-white">.</label>
                            <button type="button" onclick="CheckLocation()" class="btn btn-info btn-last-position full-width"><i class="fa fa-search"></i> <span><?= $this->lang->line('lb_last_position') ?></span></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="MAPS" style="height: 650px;width: 100%"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-header bg-primary">
                            <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_users') ?></h4>
                        </div>
                        <div class="card-body" style="border: 1px solid #edf1f5;max-height: 600px;overflow: auto;">
                            <div class="row">
                                <table id="table-list" class="tablesaw table-bordered table table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="check_all"> All</th>
                                            <th><?= $this->lang->line('lb_no') ?></th>
                                            <th><?= $this->lang->line('lb_name') ?></th>
                                            <th><?= $this->lang->line('lb_email') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4"><div class="text-center"><h4>Data Not Found</h4></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<?php $this->load->view('backend/modal/modal_company') ?>
<!-- Modal -->

<script src="<?= base_url('assets/node_modules/datatables/jquery.dataTables.min.js') ?>"></script>
<!-- Plugins For This Page -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $this->config->item("maps_api"); ?>&libraries=places"></script>
<script src="<?= base_url('asset/js/custom/backend/last_position.js').$this->main->version_js() ?>"></script>
