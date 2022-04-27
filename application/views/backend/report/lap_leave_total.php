<table id="table" class="tablesaw table-bordered table table-responsive-lg mt-20" width="100%">
		<tr>
			<th><?= $this->lang->line('lb_no') ?></th>
			<th><?= $this->lang->line('lb_nik') ?></th>
			<th><?= $this->lang->line('lb_name') ?></th>
			<th><?= $this->lang->line('lb_departement') ?></th>
			<th><?= $this->lang->line('lb_role') ?></th>
			<th><?= $this->lang->line('lb_leave_taken') ?></th>
		</tr>
	<?php
		$list = $this->report->leave_total();
		if(count($list)>0):
			$no = 0;
			foreach ($list as $k => $v) {
				$no += 1;
				$item = '<tr>';
				$item .= '<td>'.$no.'</td>';
				$item .= '<td>'.$v->Nik.'</td>';
				$item .= '<td>'.$v->Name.'</td>';
				$item .= '<td>'.$v->Departement.'</td>';
				$item .= '<td>'.$v->roleName.'</td>';
				$item .= '<td>'.$v->Total.'</td>';
				$item .= '</tr>';

				echo $item;
			}
		else:
			echo $this->report->DataNotFound(6);
		endif;
	?>
</table>