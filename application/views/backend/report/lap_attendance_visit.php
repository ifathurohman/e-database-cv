<?php
	$Print 			= $this->input->post('Print');
?>
<table id="table" class="tablesaw table-bordered table table-responsive-lg mt-20" width="100%">
	<tr>
		<th><?= $this->lang->line('lb_no') ?></th>
		<th><?= $this->lang->line('lb_nik') ?></th>
		<th><?= $this->lang->line('lb_name') ?></th>
		<th><?= $this->lang->line('lb_date') ?></th>
		<th><?= $this->lang->line('lb_visit_type') ?></th>
		<th><?= $this->lang->line('lb_visit_in') ?></th>
		<th><?= $this->lang->line('lb_visit_in_remark') ?></th>
		<th><?= $this->lang->line('lb_visit_out') ?></th>
		<th><?= $this->lang->line('lb_visit_out_remark') ?></th>
		<th><?= $this->lang->line('lb_visit_duration') ?></th>
		<th><?= $this->lang->line('lb_location') ?></th>
		<?php if(!in_array($Print,array('pdf','excel'))):?>
			<th><?= $this->lang->line('lb_attachment') ?></th>
		<?php endif; ?>
	</tr>
	<?php
	$list = $this->report->attendance_visit();
	$arrVisitIn     = array();
    $arrVisitOut    = array();
    $arrID 			= array();

    foreach ($list as $k => $v) {
    	if(!in_array($v->EmployeeID, $arrID)):
    		array_push($arrID, $v->EmployeeID);
    	endif;
       	if($v->Type == 5):
            array_push($arrVisitIn,$v);
        else:
            array_push($arrVisitOut,$v);
        endif;
    }
	
	if(count($list)>0):
		$no = 0;
		$ID = '';
		foreach ($arrID as $k => $v) {
			foreach ($arrVisitIn as $k2 => $v2) {
				if($v == $v2->EmployeeID):
					if($v2->EmployeeID != $ID):
						$no += 1;
						$nox = $no;
						$ID = $v2->EmployeeID;
					else:
						$nox = '';
					endif;

					$key = array_search($v2->Code, array_column($arrVisitOut, 'ParentCodeVisit'));
					if(strlen($key)>0):
                        $VisitOut       = $arrVisitOut[$key]->CheckIn;
                        $DurationVisit  = $this->main->time_elapsed_string($v2->CheckIn,true,$VisitOut,"duration");
                        $v2->VisitOut 	= $VisitOut;
                        $v2->DurationVisit = $DurationVisit;
                        $v2->RemarkOut = $arrVisitOut[$key]->Note;
                        $v2->OutAttach = $arrVisitOut[$key]->Attachment;
                        $v2->OutPicture = $arrVisitOut[$key]->Picture;
                    else:
                        $v2->VisitOut     	= "-";
                        $v2->DurationVisit 	= "-";
                        $v2->RemarkOut 		= "-";
                        $v2->OutAttach 		= "[]";
                        $v2->OutPicture 	= "[]";
                    endif;

                    if($v2->Latitude && $v2->Longitude):
                    	$v2->Latlng = $v2->Latitude.",".$v2->Longitude;
                    else:
                    	$v2->Latlng = "-";
                    endif;
					
					$Attachment = $v2->Attachment; $Attachment = json_decode($Attachment);
					$Picture 	= $v2->Picture; $Picture = json_decode($Picture);
					$OutAttach 	= $v2->OutAttach; $OutAttach = json_decode($OutAttach);
					$OutPicture = $v2->OutPicture; $OutPicture = json_decode($OutPicture);
					$file 		= '';
					if(count($Attachment) || count($Picture) || count($OutAttach) || count($OutPicture)):
						$p1 = implode(",", $Attachment);
						$p2 = implode(",", $Picture);
						$p3 = implode(",", $OutAttach);
						$p4 = implode(",", $OutPicture);

						$on = ' onclick="view_data('."this,'attendance_visit'".')" ';
						$file = '<a href="javascript:;" data-p1="'.$p1.'" data-p2="'.$p2.'" data-p3="'.$p3.'" data-p4="'.$p4.'" '.$on.'>
							Open File</a>';
					endif;


					$item = '<tr>';
					$item .= '<td>'.$nox.'</td>';
					$item .= '<td>'.$v2->Nik.'</td>';
					$item .= '<td>'.$v2->EmployeeName.'</td>';
					$item .= '<td>'.$v2->WorkDate.'</td>';
					$item .= '<td>'.$v2->VisitType.'</td>';
					$item .= '<td>'.$v2->CheckIn.'</td>';
					$item .= '<td>'.$v2->Note.'</td>';
					$item .= '<td>'.$v2->VisitOut.'</td>';
					$item .= '<td>'.$v2->RemarkOut.'</td>';
					$item .= '<td>'.$v2->DurationVisit.'</td>';
					$item .= '<td>'.$v2->Latlng.'</td>';
					if(!in_array($Print,array('pdf','excel'))):
						$item .= '<td>'.$file.'</td>';
					endif;
					$item .= '</tr>';
					echo $item;
				endif;
			}
		}
	else:
		echo $this->report->DataNotFound(8);
	endif;
	?>
</table>