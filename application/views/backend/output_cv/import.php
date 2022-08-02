<?php
    $HakAksesType   = $this->session->HakAksesType;
?>

<form id="form-import" autocomplete="off">
    <input type="hidden" name="inputFileName" id="inputFileName">
    <div class="row form-import content-hide">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white pg-title"></h4>
                </div>
                <div class="card-body">
                	<?php
                    if(in_array($HakAksesType, array(1,2))): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?= $this->lang->line('lb_company') ?> <span class="wajib"></span></label>
                                <div class="input-group">
                                    <div class="input-group-append pointer" onclick="modal_company('.Company')">
                                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control Company-Name" placeholder="Select Company" readonly>
                                    <input type="text" id="Company" name="Company" class="Company content-hide"readonly>
                                </div>
                                <small class="form-control-feedback"></small>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                	<div class="row">
                		<div class="col-md-12">
                			<div class="form-group">
                				<input type="file" name="file" class="dropify" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                			</div>
                		</div>
                	</div>
                    <?= $this->main->button('action_import') ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_note') ?></h4>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <h4 class="card-title">1. Download Template <a href="<?= site_url('leave-template') ?>" target="_blank">Here</a></h4>

                        <h4 class="card-title">2. Masukan Data Import</h4>
                        <ul class="list-icons">
                            <li class="m-0"><i class="ti-angle-right"></i> Code wajib di isi dan tidak boleh duplicate</li>
                            <li class="m-0"><i class="ti-angle-right"></i> Name wajib di isi</li>
                        </ul>

                        <h4 class="card-title mt-10">2. Upload File</h4>
                        <ul class="list-icons">
                            <li class="m-0"><i class="ti-angle-right"></i> File harus ber extensi .xls</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 v-import-result">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="m-b-0 text-white"><?= $this->lang->line('lb_result') ?></h4>
                </div>
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-success"><i class="fa fa-check-circle"></i> Success : <span class="import-total-succeess"></span></h5>
                            <h5 class="text-danger"><i class="fa fa-exclamation-triangle"></i> Failed : <span class="import-total-failed"></span></h5>
                            <h5 class="text-info"> Total : <span class="import-total"></span></h5>
                        </div>
                    </div>
                    <table id="table-import-result" class="tablesaw table-bordered table">
                        <thead></thead>
                        <tbody></tbody>
                    </table>
                    <input type="hidden" name="CompanyID" id="CompanyID">
                    <?= $this->main->button('action_import2') ?>
                </div>
            </div>
        </div>
    </div>
</form>

<link rel="stylesheet" href="<?= base_url('assets/node_modules/dropify/dist/css/dropify.min.css') ?>">
<script src="<?= base_url('assets/node_modules/dropify/dist/js/dropify.min.js') ?>"></script>

<script>
	$(document).ready(function() {
        $('.dropify').dropify();
    });
</script>