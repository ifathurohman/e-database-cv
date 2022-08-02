<?php
	$status = true;
	
	$StartDate      = $this->input->post('StartDate');
    $EndDate        = $this->input->post('EndDate');
    if(!$StartDate): $StartDate = '1998-01-01'; endif;
    if(!$EndDate): $EndDate = date('Y-m-d'); endif;
    $totalDays = $this->main->DayDifference($StartDate,$EndDate);
    if($totalDays>31):
    	$status = false;
        $message = ""."A maximum of 31 days";
    endif;

if($status):
	$list = $this->report->attendance_report();
	$CompanyID = $this->session->ReportCompany;
	$StartDate = $this->session->ReportStartDate;
	$EndDate   = $this->session->ReportEndDate;

	$arrEmployee = array();
	if(count($list)>0):
		$ParentID = implode(",", $list);
		$employee = $this->db->query("select Nik,Name as EmployeeName, EmployeeID from mt_employee where CompanyID = '$CompanyID' and EmployeeID in ($ParentID)")->result();
		foreach ($employee as $k => $v) {
			$h['Nik']		    = $v->Nik;
			$h['EmployeeName']	= $v->EmployeeName;
			$h['EmployeeID']	= $v->EmployeeID;

			array_push($arrEmployee,$h);
		}
	endif;
	$arrEmployee = json_encode($arrEmployee);
	$arrEmployee = json_decode($arrEmployee);
?>
<style type="text/css">
	.midle{
		vertical-align: middle !important;
	}
	.width-min-150{
		min-width: 150px; 
	}
</style>
<div class="table-responsive mt-20">
	<table id="table-list" class="tablesaw table-bordered table table-responsive">
		<tr>
		<th rowspan="2" class="midle"><?= $this->lang->line('lb_no') ?></th>
		<th rowspan="2" class="midle"><?= $this->lang->line('lb_nik') ?></th>
		<th rowspan="2" class="midle"><?= $this->lang->line('lb_name') ?></th>
		<?php
			$begin  = new DateTime($StartDate);
	        $end    = new DateTime($EndDate);
	        $end    = $end->modify( '+1 days'); 

	        $interval = DateInterval::createFromDateString('1 days');
	        $period = new DatePeriod($begin, $interval, $end);

	        foreach ($period as $dt) {
	            $date = $dt->format("Y-m-d");
	            echo '<th colspan="6" class="text-center">'.$date.'</th>';
	        }
		?>
		<th colspan="3" class="text-center">SUM</th>
		</tr>
		<tr>
		<?php
			$total_col = 3;
			$begin  = new DateTime($StartDate);
	        $end    = new DateTime($EndDate);
	        $end    = $end->modify( '+1 days'); 

	        $interval = DateInterval::createFromDateString('1 days');
	        $period = new DatePeriod($begin, $interval, $end);

	        foreach ($period as $dt) {
	        	$total_col += 1;
	            $date = $dt->format("Y-m-d");
	            echo '<th class="text-center width-min-150">'.$this->lang->line('lb_check_in').'</th>';
				echo '<th class="text-center width-min-150">'.$this->lang->line('lb_check_out').'</th>';
				echo '<th class="text-center width-min-150">'.$this->lang->line('lb_break_start').'</th>';
				echo '<th class="text-center width-min-150">'.$this->lang->line('lb_break_end').'</th>';
				echo '<th class="text-center width-min-150">'.$this->lang->line('lb_overtime_in').'</th>';
				echo '<th class="text-center width-min-150">'.$this->lang->line('lb_overtime_out').'</th>';
	        }
		?>
		<th class="text-center width-min-150"><?= $this->lang->line('lb_check_in_duration') ?></th>
		<th class="text-center width-min-150"><?= $this->lang->line('lb_break_start_duration') ?></th>
		<th class="text-center width-min-150"><?= $this->lang->line('lb_overtimes_duration') ?></th>
		</tr>
		<?php
		$no = 0;
		foreach ($arrEmployee as $k => $v) {

			$item2 		= '';
			$item_dt 	= '';
			$total_row	= 1;
			$first 		= true;

			$totalDurationCheckin 	= 0;
			$totalDurationBreak 	= 0;
			$totalDurationOvertime 	= 0;

			$begin  = new DateTime($StartDate);
	        $end    = new DateTime($EndDate);
	        $end    = $end->modify( '+1 days'); 
	        $interval = DateInterval::createFromDateString('1 days');
	        $period = new DatePeriod($begin, $interval, $end);

	        foreach ($period as $dt) {
	            $date = $dt->format("Y-m-d");
	            $status = false;

	            $item_dt2 = '';

	            $list = $this->api->HistoryAttendaceAndroid($CompanyID,$v->EmployeeID,$StartDate,$EndDate,"report");
	            $nox = 0;
	            foreach ($list as $k2 => $v2) {
	            	$nox += 1;
	            	if($v2->EmployeeID == $v->EmployeeID && $date == $v2->WorkDate):
	            		$status = true;

	            		if($v2->CheckOut):
			                $diff = strtotime($v2->CheckOut) - strtotime($v2->CheckIn);
                        	$totalDurationCheckin += $diff;
			            else:
			                $v2->CheckOut     = "-";
			            endif;

			            if($v2->BreakStart && $v2->BreakEnd):
			                $diff = strtotime($v2->BreakEnd) - strtotime($v2->BreakStart);
                        	$totalDurationBreak += $diff;
			            endif;
			            if($v2->BreakStart):
			            else:
			                $v2->BreakStart     = "-";
			            endif;
			            if($v2->BreakEnd):
			            else:
			                $v2->BreakEnd     = "-";
			            endif;

			            if($v2->OvertimeIn && $v2->OvertimeOut):
			                $diff = strtotime($v2->OvertimeOut) - strtotime($v2->OvertimeIn);
                        	$totalDurationOvertime += $diff;
			            endif;
			            if($v2->OvertimeIn):
			            else:
			                $v2->OvertimeIn     = "-";
			            endif;
			            if($v2->OvertimeOut):
			            else:
			                $v2->OvertimeOut     = "-";
			            endif;

			            $p1 = $this->encrypt->encode('attendance','report');
			            $p2 = $this->encrypt->encode($v2->Code,'report');
			            $p3 = $this->encrypt->encode($v2->CheckOutCode,'report');
			            $p4 = $this->encrypt->encode($v2->OvertimeOutCode,'report');
			            $p5 = $this->encrypt->encode($CompanyID,'report');
			            $p6 = $this->encrypt->encode($v2->EmployeeID,'report');
			            $p7 = $this->encrypt->encode($v2->BreakCode,'report');
			            $p8 = $this->encrypt->encode($v2->BreakEndCode,'report');

			            $tg_data = ' data-p1="'.$p1.'" ';
			            $tg_data .= ' data-p2="'.$p2.'" ';
			            $tg_data .= ' data-p3="'.$p3.'" ';
			            $tg_data .= ' data-p4="'.$p4.'" ';
			            $tg_data .= ' data-p5="'.$p5.'" ';
			            $tg_data .= ' data-p6="'.$p6.'" ';
			            $tg_data .= ' data-p7="'.$p7.'" ';
			            $tg_data .= ' data-p8="'.$p8.'" ';

	            		$item_dt2 .= 
	            			'<td onmouseover="td_hover(this)" onclick="view_data('."this,'attendance'".')" onmouseout="td_hover_out(this)" class="no'
	            			.$nox.'" data-no="'.$nox.'" '.$tg_data.'>'.$v2->CheckIn.'</td>';
	            		$item_dt2 .= 
	            			'<td onmouseover="td_hover(this)" onclick="view_data('."this,'attendance'".')" onmouseout="td_hover_out(this)" class="no'.
	            			$nox.'" data-no="'.$nox.'" '.$tg_data.'>'.$v2->CheckOut.'</td>';
	            		$item_dt2 .= 
	            			'<td onmouseover="td_hover(this)" onclick="view_data('."this,'attendance'".')" onmouseout="td_hover_out(this)" class="no'.
	            			$nox.'" data-no="'.$nox.'" '.$tg_data.'>'.$v2->BreakStart.'</td>';
	            		$item_dt2 .= 
	            			'<td onmouseover="td_hover(this)" onclick="view_data('."this,'attendance'".')" onmouseout="td_hover_out(this)" class="no'.
	            			$nox.'" data-no="'.$nox.'" '.$tg_data.'>'.$v2->BreakEnd.'</td>';
	            		$item_dt2 .= 
	            			'<td onmouseover="td_hover(this)" onclick="view_data('."this,'attendance'".')" onmouseout="td_hover_out(this)" class="no'.
	            			$nox.'" data-no="'.$nox.'" '.$tg_data.'>'.$v2->OvertimeIn.'</td>';
	            		$item_dt2 .= 
	            			'<td onmouseover="td_hover(this)" onclick="view_data('."this,'attendance'".')" onmouseout="td_hover_out(this)" class="no'.
	            			$nox.'" data-no="'.$nox.'" '.$tg_data.'>'.$v2->OvertimeOut.'</td>';
	            	endif;
	            }

	            if(!$status):
	            	$item_dt2 .= '<td>-</td>';
	            	$item_dt2 .= '<td>-</td>';
	            	$item_dt2 .= '<td>-</td>';
	            	$item_dt2 .= '<td>-</td>';
	            	$item_dt2 .= '<td>-</td>';
	            	$item_dt2 .= '<td>-</td>';
	            endif;

            	$item2 .= $item_dt2;
	            
	        }
			$no += 1;
			$item = '<tr>';
			$item .= '<td>'.$no.'</td>';
			$item .= '<td>'.$v->Nik.'</td>';
			$item .= '<td>'.$v->EmployeeName.'</td>';
			$item .= $item2;
			$item .= '<td>'.ucwords($this->main->convert_seconds($totalDurationCheckin,true,"duration")).'</td>';
			$item .= '<td>'.ucwords($this->main->convert_seconds($totalDurationBreak,true,"duration")).'</td>';
			$item .= '<td>'.ucwords($this->main->convert_seconds($totalDurationOvertime,true,"duration")).'</td>';
			$item .= '</tr>';

			echo $item;
		}
		?>
	</table>
</div>
<?php else:
	echo '<h3>'.$message.'</h3>';
endif;?>