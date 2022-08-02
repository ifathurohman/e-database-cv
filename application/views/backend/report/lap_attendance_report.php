<table id="table" class="tablesaw table-bordered table table-responsive-lg mt-20" width="100%">
	<tr>
		<th><?= $this->lang->line('lb_no') ?></th>
		<th><?= $this->lang->line('lb_nik') ?></th>
		<th><?= $this->lang->line('lb_name') ?></th>
		<th><?= $this->lang->line('lb_date') ?></th>
		<th><?= $this->lang->line('lb_check_in') ?></th>
		<th><?= $this->lang->line('lb_check_out') ?></th>
		<th><?= $this->lang->line('lb_check_in_duration') ?></th>
		<th><?= $this->lang->line('lb_break_start') ?></th>
		<th><?= $this->lang->line('lb_break_end') ?></th>
		<th><?= $this->lang->line('lb_break_start_duration') ?></th>
		<th><?= $this->lang->line('lb_overtime_in') ?></th>
		<th><?= $this->lang->line('lb_overtime_out') ?></th>
		<th><?= $this->lang->line('lb_overtimes_duration') ?></th>
	</tr>
	<?php
		$d = $this->report->attendance_report();
		$StatusData = false;
		if(count($d)>0):
			$no = 0;
			$ID = '';
			foreach ($d as $k2 => $v2) {
				$CompanyID = $this->session->ReportCompany;
				$StartDate = $this->session->ReportStartDate;
				$EndDate   = $this->session->ReportEndDate;

				$list = $this->api->HistoryAttendaceAndroid($CompanyID,$v2,$StartDate,$EndDate,"report");
				if(count($list)>0):
					$StatusData = true;
					foreach ($list as $k => $v) {
						if($v->EmployeeID != $ID):
							$no += 1;
							$nox = $no;
							$ID = $v->EmployeeID;
						else:
							$nox = '';
						endif;

						$DurationCheckIn = "-";
			            if($v->CheckOut):
			                $DurationCheckIn = $this->main->time_elapsed_string($v->CheckIn,true,$v->CheckOut,"duration");
			            else:
			                $v->CheckOut     = "-";
			            endif;
			            $v->DurationCheckIn = $DurationCheckIn;

			            $DurationBreakStart = "-";
			            if($v->BreakStart && $v->BreakEnd):
			                $DurationBreakStart = $this->main->time_elapsed_string($v->BreakStart,true,$v->BreakEnd,"duration");
			            endif;
			            $v->DurationBreakStart = $DurationBreakStart;
			            if($v->BreakStart):
			            else:
			                $v->BreakStart     = "-";
			            endif;
			            if($v->BreakEnd):
			            else:
			                $v->BreakEnd     = "-";
			            endif;

			            $DurationOvertime = "-";
			            if($v->OvertimeIn && $v->OvertimeOut):
			                $DurationOvertime = $this->main->time_elapsed_string($v->OvertimeIn,true,$v->OvertimeOut,"duration");
			            endif;
			            $v->DurationOvertime = $DurationOvertime;
			            if($v->OvertimeIn):
			            else:
			                $v->OvertimeIn     = "-";
			            endif;
			            if($v->OvertimeOut):
			            else:
			                $v->OvertimeOut     = "-";
			            endif;

						$item = '<tr>';
						$item .= '<td>'.$nox.'</td>';
						$item .= '<td>'.$v->Nik.'</td>';
						$item .= '<td>'.$v->EmployeeName.'</td>';
						$item .= '<td>'.$v->WorkDate.'</td>';
						$item .= '<td>'.$v->CheckIn.'</td>';
						$item .= '<td>'.$v->CheckOut.'</td>';
						$item .= '<td>'.$v->DurationCheckIn.'</td>';
						$item .= '<td>'.$v->BreakStart.'</td>';
						$item .= '<td>'.$v->BreakEnd.'</td>';
						$item .= '<td>'.$v->DurationBreakStart.'</td>';
						$item .= '<td>'.$v->OvertimeIn.'</td>';
						$item .= '<td>'.$v->OvertimeOut.'</td>';
						$item .= '<td>'.$v->DurationOvertime.'</td>';
						$item .= '</tr>';

						echo $item;
					}
				endif;
			}
		endif;
		if(!$StatusData):
			echo $this->report->DataNotFound(13);
		endif;
	?>
</table>