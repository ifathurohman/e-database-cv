<?php
	$HakAksesType   = $this->session->HakAksesType;
	$Level   		= $this->session->Level;
?>
<div class="col-12 p-0">
    <form id="form-filter">
    	<div class="row">
    		<?php
    		if($url == 'report-transaction-leave'):
    			echo 
    			'<div class="col-md-3">
		            <div class="form-group">
		                <label class="control-label">Report Type</label>
		                <select class="form-control" name="ReportType">
		                	<option value="leave_total">Leave Total</option>
		                	<option value="leave_detail">Leave Detail</option>
		                </select>
		                <small class="form-control-feedback"></small>
		            </div>
		        </div>';
		    elseif($url == 'report-transaction-overtime'):
		    	echo 
    			'<div class="col-md-3 content-hide">
		            <div class="form-group">
		                <label class="control-label">Report Type</label>
		                <select class="form-control" name="ReportType">
		                	<option value="overtime_form">Overtime Form</option>
		                </select>
		                <small class="form-control-feedback"></small>
		            </div>
		        </div>';
		    elseif($url == 'report-transaction-attendance'):
		    	echo 
    			'<div class="col-md-3">
		            <div class="form-group">
		                <label class="control-label">Report Type</label>
		                <select class="form-control" name="ReportType">
		                	<option value="attendance_report">Attendance Report</option>
		                	<option value="attendance_report_h">Attendance Report H</option>
		                	<option value="attendance_visit">Visit Report</option>
		                </select>
		                <small class="form-control-feedback"></small>
		            </div>
		        </div>';
		    elseif($url == 'transaction-attendance'):
		    	echo 
    			'<div class="col-md-3 content-hide">
		            <div class="form-group">
		                <label class="control-label">Report Type</label>
		                <select class="form-control" name="ReportType">
		                	<option value="attendance">Attendance Report</option>
		                </select>
		                <small class="form-control-feedback"></small>
		            </div>
		        </div>';
		    elseif($url == 'report-log'):
		    	$classnya = 'content-hide';
		    	$option = '';
		    	if(in_array($HakAksesType, array(1,2,3))):
		    		$classnya = '';
		    		$option = '<option value="report_log_company">Report Company Log</option>';
		    	endif;
		    	echo 
    			'<div class="col-md-3 '.$classnya.'">
		            <div class="form-group">
		                <label class="control-label">Report Type</label>
		                <select class="form-control" name="ReportType">
		                	<option value="report_log">Report User Log</option>
		                	'.$option.'
		                </select>
		                <small class="form-control-feedback"></small>
		            </div>
		        </div>';
    		endif;
    		?>
    		<?php if(in_array($HakAksesType, array(1,2))): ?>
    		<div class="col-md-3">
	            <div class="form-group">
	                <label class="control-label"><?= $this->lang->line('lb_company') ?></label>
	                <div class="input-group">
	                    <div class="input-group-append pointer" onclick="modal_company('.Company')">
	                        <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
	                    </div>
	                    <input type="text" class="form-control Company-Name" placeholder="Select Company" readonly>
	                    <input type="hidden" id="Company" name="Company" class="Company" readonly>
	                </div>
	                <small class="form-control-feedback"></small>
	            </div>
	        </div>
	    	<?php endif; ?>
	    	<?php if(in_array($HakAksesType, array(1,2,3)) || in_array($Level,array(1,2,3))): ?>
            <div class="col-sm-3 v-user">
                <div class="form-group User-view">
                    <label class="control-label"><?= $this->lang->line('lb_user') ?></label>
                    <div class="input-group">
                        <div class="input-group-append pointer" onclick="modal_user_company('.User')">
                            <span class="input-group-text"><i class="btn-icon fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control User-Name" placeholder="Select User" readonly> 
                        <input type="text" id="User" name="User" class="User content-hide" data-company="active" data-user="active" readonly>
                        <div class="input-group-append">
                            <span class="input-group-text" onclick="remove_value_user('.User')">
                                <i class="btn-icon fa fa-times-circle"></i>
                            </span>
                        </div>
                    </div>
                    <small class="form-control-feedback"></small>
                </div>
            </div>
            <?php endif; ?>
	    	<div class="col-md-3">
        	   <div class="form-group">
                    <label class="control-label"><?= $this->lang->line('lb_start_date') ?></span></label>
                    <div class="input-group">
                    	<input type="text" id="f-StartDate" name="f-StartDate" class="form-control mdate" value="<?= date("Y-m-01"); ?>">
                    	<div class="input-group-append">
	                        <span class="input-group-text" onclick="remove_value('f-StartDate')">
	                        	<i class="btn-icon fa fa-times-circle"></i>
	                        </span>
	                    </div>
                    </div>
                    <small class="form-control-feedback"></small>
                </div>
	        </div>
	        <div class="col-md-3">
        	   <div class="form-group">
                    <label class="control-label"><?= $this->lang->line('lb_end_date') ?></span></label>
                    <div class="input-group">
                    	<input type="text" id="f-EndtDate" name="f-EndDate" class="form-control mdate" value="<?= date("Y-m-d"); ?>">
                    	<div class="input-group-append">
	                        <span class="input-group-text" onclick="remove_value('f-EndDate')">
	                        	<i class="btn-icon fa fa-times-circle"></i>
	                        </span>
	                    </div>
                    </div>
                    <small class="form-control-feedback"></small>
                </div>
	        </div>

	    	<div class="col-md-3 v-status">
	            <div class="form-group">
	                <label class="control-label"><?= $this->lang->line('lb_status') ?></label>
	                <select class="form-control" name="f-Status">
	                	<option value="none">Select Status</option>
	                	<option value="1"><?= $this->lang->line('lb_submitted') ?></option>
	                	<option value="2"><?= $this->lang->line('lb_approved') ?></option>
	                	<option value="3"><?= $this->lang->line('lb_rejected') ?></option>
	                </select>
	                <small class="form-control-feedback"></small>
	            </div>
	        </div>
	        <div class="col-12">
	        	<div class="pull-right">
	        		<?= $this->main->button('filter',array('search','pdf','excel')) ?>
	        	</div>
	        </div>
    	</div>
    </form>
</div>