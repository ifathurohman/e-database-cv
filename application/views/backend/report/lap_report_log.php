<table id="table" class="tablesaw table-bordered table table-responsive-lg mt-20" width="100%">
		<tr>
			<th><?= $this->lang->line('lb_no') ?></th>
			<th><?= $this->lang->line('lb_nik') ?></th>
			<th><?= $this->lang->line('lb_name') ?></th>
			<th><?= $this->lang->line('lb_departement') ?></th>
			<th><?= $this->lang->line('lb_date') ?></th>
			<th><?= $this->lang->line('lb_page') ?></th>
			<th><?= $this->lang->line('lb_action') ?></th>
		</tr>
	<?php
		$list = $this->report->log();
		// echo '<pre>';
		// echo json_encode($list);
		// echo '</pre>';
		if(count($list)>0):

			$no 	= 0;
			$ID   	= '';
			foreach ($list as $k => $v) {
				$Lables     = $this->main->label_log($v->Type, $v->Page, $v->Content);
				$Page 		= $this->main->label_log2($v->Page);

				if($v->EmployeeID != $ID):
					$no += 1;
					$nox = $no;
					$ID = $v->EmployeeID;
				else:
					$nox = '';
				endif;
				
				$item = '<tr>';
				$item .= '<td>'.$nox.'</td>';
				$item .= '<td>'.$v->employeeNik.'</td>';
				$item .= '<td>'.$v->employeeName.'</td>';
				$item .= '<td>'.$v->employeeDepartement.'</td>';
				$item .= '<td>'.$v->DateAdd.'</td>';
				$item .= '<td>'.$Page.'</td>';
				$item .= '<td>'.$Lables.'</td>';
				$item .= '</tr>';
				echo $item;
			}
		else:
			echo $this->report->DataNotFound(7);
		endif;
	?>
</table>