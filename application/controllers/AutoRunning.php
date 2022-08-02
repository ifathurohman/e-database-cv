<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AutoRunning extends CI_Controller {
	
	function __construct() {
        parent::__construct();
    }

    function index(){
    	$DateNow 	= strtotime(date("Y-m-d"));
    	$DateNow 	= date("Y-m-d", strtotime('-1 day',$DateNow));
    	$WorkDate   = $DateNow;
    	$DayNow     = date("D", strtotime($DateNow));

    	$company = $this->db->query("select mt.UserID,mt.StartWorkDate,Latitude,Longitude,Radius from ut_user mt join ut_role dt on mt.RoleID = dt.RoleID where dt.Type = '3' and mt.Status = '1'")->result();
    	if($company):
    		foreach ($company as $k => $v) {
    			$CompanyID 		= $v->UserID;
    			$StartWorkDate 	= $v->StartWorkDate;
    			$StartWorkDate1 = $StartWorkDate;
    			$LatlngCompany 	= null;
    			$Radius 		= $v->Radius;
    			if($v->Latitude):
    				$LatlngCompany = $v->Latitude.",".$v->Longitude;
    			endif;
    			if($StartWorkDate):
		            $StartWorkDate = date("d", strtotime($StartWorkDate));
		        else:
		            $StartWorkDate = "01";
		        endif;

		        $StartWorkDate = date('Y-m-').$StartWorkDate;

		        if($StartWorkDate>$DateNow):
		            $StartWorkDate = date("Y-m-d", strtotime($StartWorkDate." -1 Month"));
		        endif;

		        $TotalWeek = $this->main->WeekOfMonth($StartWorkDate,$DateNow);
        		$TotalWeek = count($TotalWeek);

    			$employee = $this->db->query("select mt.EmployeeID,mt.WorkPatternID,dt.Days,mt.StartWork from mt_employee mt join mt_workpattern dt on mt.WorkPatternID = dt.WorkPatternID where mt.CompanyID = '$CompanyID'")->result();
    			if($employee):
    				foreach ($employee as $k2 => $v2) {
    					$EmployeeID 	= $v2->EmployeeID;
    					$WorkPatternID 	= $v2->WorkPatternID;
    					$StartWork 		= $v2->StartWork;
    					$ck_attendane = $this->db->count_all("t_attendance where CompanyID = '$CompanyID' and EmployeeID = '$EmployeeID' and Type in (1,9) and WorkDate = '$DateNow'");
    					if(!$ck_attendane && $WorkDate >= $StartWork):
    						$TotalDayWork   = $v2->Days;// total hari kerja
    						$DaysIndex      = $this->main->IndexDays($DayNow);
    						if($TotalDayWork<=7):// untuk perminggu

					        elseif($TotalDayWork<=14):
					            $x = $TotalWeek % 2;
					            if($x == 0):// jika genap maka tambah 7 hari
					                $DaysIndex += 7;
					            endif;
					        elseif($TotalDayWork>14):
					        	if($TotalWeek == 2):
					        		$DaysIndex += 7;
					        	elseif($TotalWeek == 3):
					        		$DaysIndex += 14;
					        	elseif($TotalWeek == 4):
					        		$DaysIndex += 21;
					        	endif;
					        endif;

					        $where_det = array(
					            "CompanyID"     => $CompanyID,
					            "WorkPatternID" => $WorkPatternID,
					            "Day"   		=> $DaysIndex,
					        );
					        $dt_work_detail = $this->api->work_pattern_detail("array_row",$where_det);
					        $TimeWorkStart  = $dt_work_detail->From;
					        $TimeWorkEnd    = $dt_work_detail->To;
					        $WorkingDays    = $dt_work_detail->WorkingDays;

					        $code = $this->main->generate_code_t_attendace($CompanyID,9);
					        $data = array(
					            "Code"          => $code,
					            "CompanyID"     => $CompanyID,
					            "EmployeeID"    => $EmployeeID,
					            "Date"          => date("Y-m-d H:i:s"),
					            "LatlngCompany" => $LatlngCompany,
					            "Radius"        => $Radius,
					            "Type"          => 9,
					            "Status"        => 0,
					            "WorkDate"      => $WorkDate,
					            "CheckIn"       => $DateNow." "."23:59",
					            "WorkingDays"   => $WorkingDays,
					            "Days"          => $DaysIndex,
					            "StartWorkDate"	=> $StartWorkDate1,
					        );
					        $this->main->general_save_android("t_attendance", $data);
    					endif;
    				}
    			endif;
    		}
    	endif;
    }

    public function AttachmentAttendance(){
    	$this->db->select("
            Code,
            CompanyID,
            EmployeeID,
            ifnull(Temp,'[]') as Temp,
            ifnull(TempAttach,'[]') as TempAttach,
        ");
        $this->db->group_start();
        $this->db->where("ifnull(Temp,'[]') != ", "[]");
        $this->db->or_where("ifnull(TempAttach,'[]') != ", "[]");
        $this->db->group_end();
        $this->db->where("WorkDate", date("Y-m-d"));
        $this->db->from("t_attendance");
        $query = $this->db->get()->result();
        
        foreach ($query as $k => $v) {
            $CompanyID  = $v->CompanyID;
            $Code       = $v->Code;
            $UserID     = $v->EmployeeID;
            $picture    = json_decode($v->Temp);
            $file       = json_decode($v->TempAttach);

            $Attachment = array();
            foreach ($picture as $k2 => $v2) {
                $FileName   = $v2->Name;
                $FileName   = str_replace(' ', '-', $FileName);
                $FileName   = explode('.', $FileName)[0];
                $Value      = $v2->Byte;
                $Extension  = $v2->Extension;

                $path       = "img/attachment/";
                $nmfile     = "alpa-".date("ymdHis").$FileName."-".$UserID."picture.".$Extension;

                if(!in_array($path.$nmfile, $Attachment)):
                    file_put_contents($path.$nmfile,base64_decode($Value));
                    array_push($Attachment, $path.$nmfile);
                endif;
            }

            $arrFile = array();
            foreach ($file as $k2 => $v2) {
                $FileName   = $v2->Name;
                $FileName   = str_replace(' ', '-', $FileName);
                $FileName   = explode('.', $FileName)[0];
                $Value      = $v2->Byte;
                $Extension  = $v2->Extension;

                $path       = "img/attachment/";
                $nmfile     = "alpa-".date("ymdHis").$FileName."-".$UserID."file.".$Extension;

                if(!in_array($path.$nmfile, $arrFile)):
                    file_put_contents($path.$nmfile,base64_decode($Value));
                    array_push($arrFile, $path.$nmfile);
                endif;
            }

            $data = array(
                "Picture"       => json_encode($Attachment),
                "Attachment"    => json_encode($arrFile),
                "Temp"          => null,
                "TempAttach"    => null,
            );

            $where = array("CompanyID"  => $CompanyID, "Code" => $Code);
            $this->main->general_update_android("t_attendance",$data,$where);
        }
    }

    public function Temp(){
        $this->db->from("t_temp");
        $query = $this->db->get()->result();

        foreach ($query as $k => $v) {
            $Temp       = json_decode($v->Temp);
            $where      = array(
                "CompanyID"     => $v->CompanyID,
                "EmployeeID"    => $v->EmployeeID,
                "Code"          => $v->Code,
            );
            $a = $this->api->get_one_row($v->Page,"ifnull($v->Column,'[]') as $v->Column",$where);
            $Attachment = array();
            if($a):
                $Attachment = json_decode($a->{$v->Column});
            endif;
            foreach ($Temp as $k2 => $v2) {
                if($v->Page == 't_leave' and $v->Column == 'Attachment'):
                    $FileName    = $v2->Name;
                    $FileName    = str_replace(' ', '-', $FileName);
                    $FileName    = explode('.', $FileName)[0];
                    $Value       = $v2->Value;
                    $Extension   = $v2->Extension;
                    
                    $path    = "img/attachment/";
                    $nmfile  = "alpa-".date("ymdHis").$FileName."-".$v->EmployeeID.$k2.".".$Extension;
                else:
                    $FileName   = $v2->Name;
                    $FileName   = str_replace(' ', '-', $FileName);
                    $FileName   = explode('.', $FileName)[0];
                    $Value      = $v2->Byte;
                    $Extension  = $v2->Extension;

                    $path       = "img/attachment/";
                    $nmfile     = "alpa-".date("ymdHis").$FileName."-".$v->EmployeeID.$k2."file.".$Extension;
                endif;
                if(!in_array($path.$nmfile, $Attachment)):
                    file_put_contents($path.$nmfile,base64_decode($Value));
                    array_push($Attachment, $path.$nmfile);
                endif;
            }

            $data = array(
                $v->Column       => json_encode($Attachment),
            );
            $this->main->general_update_android($v->Page,$data,$where);

            $this->db->where("ID", $v->ID);
            $this->db->delete("t_temp");   
        }
    }
}