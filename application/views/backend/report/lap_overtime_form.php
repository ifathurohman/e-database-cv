<table id="table" class="tablesaw table-bordered table table-responsive-lg mt-20" width="100%">
	<tr>
		<th><?= $this->lang->line('lb_no') ?></th>
		<th><?= $this->lang->line('lb_nik') ?></th>
		<th><?= $this->lang->line('lb_name') ?></th>
		<th><?= $this->lang->line('lb_departement') ?></th>
		<th><?= $this->lang->line('lb_role') ?></th>
		<th><?= $this->lang->line('lb_date') ?></th>
		<th><?= $this->lang->line('lb_start') ?></th>
		<th><?= $this->lang->line('lb_end') ?></th>
		<th><?= $this->lang->line('lb_remark') ?></th>
		<th><?= $this->lang->line('lb_status') ?></th>
		<th><?= $this->lang->line('lb_approval_by') ?></th>
		<th><?= $this->lang->line('lb_approval_date') ?></th>
		<th><?= $this->lang->line('lb_approval_remark') ?></th>
	</tr>
	<?php
	$list = $this->report->overtime_form();
	if(count($list)>0):
		$no = 0;
		$ID = '';
		foreach ($list as $k => $v) {
			if($v->EmployeeID != $ID):
				$no += 1;
				$nox = $no;
				$ID = $v->EmployeeID;
			else:
				$nox = '';
			endif;
			$item = '<tr>';
			$item .= '<td>'.$nox.'</td>';
			$item .= '<td>'.$v->Nik.'</td>';
			$item .= '<td>'.$v->EmployeeName.'</td>';
			$item .= '<td>'.$v->Departement.'</td>';
			$item .= '<td>'.$v->roleName.'</td>';
			$item .= '<td>'.$v->Date.'</td>';
			$item .= '<td>'.$v->From.'</td>';
			$item .= '<td>'.$v->To.'</td>';
			$item .= '<td>'.$v->Remark.'</td>';
			$item .= '<td>'.$this->main->label_status_ap($v->ApproveStatus).'</td>';
			$item .= '<td>'.$v->ApproveBy.'</td>';
			$item .= '<td>'.$v->ApproveDate.'</td>';
			$item .= '<td>'.$v->ApproveRemark.'</td>';
			$item .= '</tr>';

			echo $item;
		}
	else:
		echo $this->report->DataNotFound(13);
	endif;
	?>
</table>