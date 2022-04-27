<?php
	$HakAksesType   = $this->session->HakAksesType;
?>
<div class="col-12 p-0">
    <form id="form-filter">
    	<div class="row">
    		<?php if(in_array($HakAksesType, array(1,2))): ?>
    		<div class="col-md-3">
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
	    	<?php endif; ?>
	        <div class="col-md-3">
	            <div class="form-group">
	                <label class="control-label"><?= $this->lang->line('lb_search') ?></label>
	                <div class="input-group">
	                    <div class="input-group-append">
	                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
	                    </div>
	                    <input type="text" name="f-Search" class="form-control f-Search">
	                </div>
	                <small class="form-control-feedback"></small>
	            </div>
	        </div>
	        <div class="col-12">
	        	<div class="pull-right">
	        		<?= $this->main->button('filter',array('search',$btn_import,'export')) ?>
	        	</div>
	        </div>
    	</div>
    </form>
</div>