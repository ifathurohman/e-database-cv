<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#catatan
#Token wajib untuk menjaga data

class Android extends CI_Controller {
	
	function __construct() {
        parent::__construct();
        $this->check_token();
    }
    
    public function Login(){
    	$DeviceID   = $this->input->post("DeviceID");
        $FCM        = $this->input->post("FCM");
    	$user_employee = $this->validation->LoginAndroid();

    	$data = array(
            "DeviceID"  => $DeviceID,
            "FCM"       => $FCM,
        );
    	$this->main->general_update("mt_employee", $data,array("EmployeeID" => $user_employee->EmployeeID));

    	$output = array(
    		"status"	=> TRUE,
    		"message" 	=> "success",
    		"res_code"	=> 1,
    		"UserID" 	=> $user_employee->EmployeeID,
    		"CompanyID"	  => $user_employee->CompanyID,
            "CompanyName" => $user_employee->CompanyName,
            "Theme"       => $user_employee->Theme,
    	);

    	$this->main->echoJson($output);
    }

    public function CheckVersion(){
    	$VersionCode = $this->input->post("VersionCode");
        if(!$VersionCode):
            $VersionCode = 0;
        endif;

        $update = false;

        $list = $this->api->general_setting("array_code", array("policy-page-setting","term-and-condition","general"));
        $Policy = '';
        $Term   = '';
        $UrlShare   = site_url();
        $UrlReview  = site_url();
        $UrlContact = site_url();
        $VersionCodex = 0;
        foreach ($list as $k => $v) {
            if($v->Code == 'policy-page-setting' and $v->Name == 'Description'):
                $Policy = $v->Value;
            elseif($v->Code == 'term-and-condition' and $v->Name == 'Description'):
                $Term = $v->Value;
            elseif($v->Code == 'general' and $v->Name == 'AppDownloadLink'):
                $UrlShare = $v->Value;
            elseif($v->Code == 'general' and $v->Name == 'AppReviewLink'):
                $UrlReview = $v->Value;
            elseif($v->Code == 'general' and $v->Name == 'AppVersionCode'):
                $VersionCodex = $v->Value;
            endif;
        }

        if($VersionCodex>$VersionCode):
            $update = true;
        endif;

        $output = array(
            "status"    => true,
            "message"   => "success",
            "res_code"  => 1,
            "update"    => $update,
            "Url"       => $UrlShare,
            "UrlShare"  => $UrlShare,
            "UrlReview" => $UrlReview,
            "UrlContact" => $UrlContact,
            "Policy"    => $Policy,
            "Term"      => $Term,
        );

        $this->main->echoJson($output);
    }

    private function check_token(){
        $Token       = $this->input->post("Token");

        if($Token != $this->main->TokenApp()):
            $res = array(
                'status'    => false,
                'res_code'  => 500,
                'message'   => 'Data not found',
            );
            $this->main->echoJson($res);
            exit();
        endif;
    }

    private function validate_user(){
        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $DeviceID   = $this->input->post('DeviceID');

        $where = array(
            "CompanyID"     => $CompanyID,
            "EmployeeID"    => $UserID,
            "DeviceID"      => $DeviceID,
        );
        $cek = $this->api->get_one_row("mt_employee","Status", $where);

        if(!$cek):
            $res = array(
                'status'    => false,
                'res_code'  => 500,
                'message'   => 'Device not found or Another user has used Your account',
            );
            $this->main->echoJson($res);
            exit();
        else:
            if($cek->Status != 1):
                $res = array(
                    'status'    => false,
                    'res_code'  => 500,
                    'message'   => 'Your account has nonactive, Please contact your admin',
                );
                $this->main->echoJson($res);
                exit();
            endif;
        endif;
    }

    public function GetProfile(){
        $this->validate_user();
        
        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $DeviceID   = $this->input->post('DeviceID');

        $where = array(
            "mt_employee.CompanyID"     => $CompanyID,
            "mt_employee.EmployeeID"    => $UserID,
            "mt_employee.DeviceID"      => $DeviceID,
        );

        $user = $this->api->employee("array_row", $where);
        $user->NameLast = "";
        $Image = '';
        if(is_file('./'.$user->Image)):
            $Image = $user->Image;
        elseif(is_file('./'.$user->CompanyImage)):
            $Image = $user->CompanyImage;
        else:
            $Image = 'img/icon/user.png';
        endif;
        $Image = base_url($Image);
        $user->Image = $Image;

        // days work
        $StartWork  = $user->StartWork;
        $DaysWork   = $this->main->time_elapsed_string($StartWork,true,"","days");
        $user->DaysWork = ucwords($DaysWork);

        $dt_company   = $this->api->user("detail_id", $CompanyID);
        if(!$dt_company):
            $dt_company = array();
        endif;

        $url_approval = "transaction-leave-approval";
        $MenuID             = $this->api->get_menuID($url_approval);
        $read_menu          = $this->api->read_menu($MenuID,$CompanyID,$user->RoleType,$user->RoleID);
        if($read_menu->view > 0 and $read_menu->update > 0):
            $user->PageApprovalLeave = 1;
        else:
            $user->PageApprovalLeave = 0;
        endif;

        $url_approval = "transaction-overtimes-approval";
        $MenuID             = $this->api->get_menuID($url_approval);
        $read_menu          = $this->api->read_menu($MenuID,$CompanyID,$user->RoleType,$user->RoleID);
        if($read_menu->view > 0 and $read_menu->update > 0):
            $user->PageApprovalOvertime = 1;
        else:
            $user->PageApprovalOvertime = 0;
        endif;

        $url_approval = "transaction-attendance-approval";
        $MenuID             = $this->api->get_menuID($url_approval);
        $read_menu          = $this->api->read_menu($MenuID,$CompanyID,$user->RoleType,$user->RoleID);
        if($read_menu->view > 0 and $read_menu->update > 0):
            $user->PageApprovalAttendance = 1;
        else:
            $user->PageApprovalAttendance = 0;
        endif;

        //check transaction
        if($dt_company->StartWorkDate):
            $StartWorkDate = date("d", strtotime($dt_company->StartWorkDate));
        else:
            $StartWorkDate = "01";
        endif;

        $StartWorkDate = date('Y-m-').$StartWorkDate;
        $DateNow       = date("Y-m-d");
        $DayNow        = date("D", strtotime($DateNow));
        $TimeNow       = date("H:i");
        
        $variable_where = "CompanyID = '$CompanyID' and EmployeeID = '$UserID' ";
        $ck_checkin     = 1;
        $ck_checkout    = 0;
        $dt_checkin     = $this->db->query("select Type from t_attendance where $variable_where and Type in (1,2) order by DateAdd desc limit 1")->row();
        if($dt_checkin):
            if($dt_checkin->Type == 1):
                $ck_checkin     = 0;
                $ck_checkout    = 1;
            endif;
        endif;

        $ck_break_start = 1;
        $ck_break_end   = 0;
        $dt_break_end   = $this->db->query("select Type from t_attendance where $variable_where and Type in (3,4) order by DateAdd desc limit 1")->row();
        if($dt_break_end):
            if($dt_break_end->Type == 3):
                $ck_break_start = 0;
                $ck_break_end   = 1;
            endif;
        endif;

        $ck_visit_in    = 1;
        $ck_visit_out   = 0;
        $dt_visit       = $this->db->query("select Type from t_attendance where $variable_where and Type in (5,6) order by DateAdd desc limit 1")->row();
        if($dt_visit):
            if($dt_visit->Type == 5):
                $ck_visit_in    = 0;
                $ck_visit_out   = 1;
            endif;
        endif;

        $ck_overtime_in    = 1;
        $ck_overtime_out   = 0;
        $dt_overtime       = $this->db->query("select Type from t_attendance where $variable_where and Type in (7,8) order by DateAdd desc limit 1")->row();
        if($dt_overtime):
            if($dt_overtime->Type == 7):
                $ck_overtime_in    = 0;
                $ck_overtime_out   = 1;
            endif;
        endif;

        $data_transaction = array(
        	"checkin" 	    => $ck_checkin,
        	"checkout"	    => $ck_checkout,
            "break_start"   => $ck_break_start,
            "break_end"     => $ck_break_end,
            "visit_in"      => $ck_visit_in,
            "visit_out"     => $ck_visit_out,
            "overtime_in"   => $ck_overtime_in,
            "overtime_out"  => $ck_overtime_out,
        );

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $user,
            "dt_company"     => $dt_company,
            "dt_transaction" => $data_transaction,
        );

        $this->main->echoJson($output);
    }

    public function GetCompany(){
        $this->validate_user();
        
        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $DeviceID   = $this->input->post('DeviceID');

        $user   = $this->api->user("detail_id", $CompanyID);
        $Image  = base_url('img/image_default.png');
        if($user->Image):
            $Image = base_url($user->Image);
        endif;
        $user->Image = $Image;

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $user,
        );

        $this->main->echoJson($output);
    }

    #leave
    public function GetLeave_T(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $HakAksesType     = $this->input->post('HakAksesType');
        $Level      = $this->input->post('Level');
        $Page       = $this->input->post('Page');
        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        $ApprovalStatus    = $this->input->post('ApprovalStatus');

        $ParentList = array($UserID);

        if(!in_array($HakAksesType, array(1,2,3)) && $Page == 'approval'):
			if(in_array($Level,array(1,2,3))):
				$GetParent  = $this->api->GetParent2($CompanyID,$UserID,$HakAksesType,$Level);
				$ParentList = $GetParent;
				array_push($ParentList,$UserID);
			endif;
		endif;

        $where = array(
            't_leave.CompanyID'     => $CompanyID,
            't_leave.Date >= '      => $StartDate,
            't_leave.Date <= '      => $EndDate,
        );
        if($ApprovalStatus):
            $where['t_leave.ApproveStatus'] = $ApprovalStatus;
        endif;
        $list = $this->api->t_leave('array',$where,$ParentList);
        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $list,
        );

        $this->main->echoJson($output);
    }

    public function GetLeave_T_Row(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Code       = $this->input->post('Code');

        $where      = array(
            "t_leave.CompanyID"     => $CompanyID,
            "t_leave.Code"          => $Code,
        );
        $list = $this->api->t_leave('array_row',$where);
        $list->Attachment = json_decode($list->Attachment);
        $list->Picture    = json_decode($list->Picture);
        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $list,
        );

        $this->main->echoJson($output);
    }

    public function GetLeaveList(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Start      = $this->input->post('Start');

        $where = array(
            'mt_leave.CompanyID'     => $CompanyID,
            'mt_leave.Status'        => 1,
        );
        $list = $this->api->leave("array_limit", $where, $Start);

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $list,
        );

        $this->main->echoJson($output);
    }

    public function SaveLeave(){
        $this->validate_user();
        $this->validation->SaveLeaveAndroid();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $BranchID   = $this->input->post('BranchID');
        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        $LeaveID    = $this->input->post('LeaveID');
        $Remark     = $this->input->post('Remark');
        $Picture 	= $this->input->post("Picture");
        $CountPicture 	= $this->input->post("CountPicture");

        $data = array(
            "CompanyID"         => $CompanyID,
            "EmployeeID"        => $UserID,
            "BranchID"        	=> $BranchID,
            "From"              => $StartDate,
            "To"                => $EndDate,
            "Remark"            => $Remark,
            "LeaveID"           => $LeaveID,
        );
        $ID = $this->main->generate_code_t_leave($CompanyID);
        $data['Code'] = $ID;
        $data['Date'] = date("Y-m-d");

        $this->main->general_save_android("t_leave", $data);
        $this->inser_log(1,2,'t_leave', $ID);//$LogType,$Type,$Page,$Content=""

        if($CountPicture>0):
        	$Picture       = json_decode($Picture);
            $Attachment = array();
            array_push($Attachment,$Picture);
        	$data = array(
        		"CompanyID"		=> $CompanyID,
        		"EmployeeID"	=> $UserID,
        		"Code"			=> $ID,
        		"Page"			=> "t_leave",
        		"Column"		=> "Picture",
        		"Temp"			=> json_encode($Attachment),
        	);
        	$this->main->general_save_android("t_temp", $data);
        endif;

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "ID"      	=> $ID,
        );

        $this->main->echoJson($output);
    }

    public function SaveLeaveAttachment(){
    	$this->validate_user();

    	$CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $ID     	= $this->input->post('ID');
        $Data     	= $this->input->post('Data');
        $Data 		= json_decode($Data);

        $where = array(
        	"CompanyID"		=> $CompanyID,
        	"EmployeeID" 	=> $UserID,
        	"Code" 			=> $ID,
        );
        $dt_leave = $this->api->get_one_row("t_leave","ifnull(Attachment,'[]') as Attachment", $where);
        if($dt_leave):

        	$Attachment  = json_decode($dt_leave->Attachment);
        	foreach ($Data as $k => $v) {
        		// $FileName 	= $v->Name;
        		// $FileName 	= str_replace(' ', '-', $FileName);
        		// $FileName 	= explode('.', $FileName)[0];
        		// $Value 		= $v->Value;
        		// $Extension 	= $v->Extension;
        		
        		// $path   	= "img/attachment/";
        		// $nmfile 	= "alpa-".date("ymdHi").$FileName."-".$UserID.$k.".".$Extension;

        		// if(!in_array($path.$nmfile, $Attachment)):
        		// 	file_put_contents($path.$nmfile,base64_decode($Value));
        		// 	array_push($Attachment, $path.$nmfile);
        		// endif;

                $Attachment = array();
                array_push($Attachment,$v);
        		$data = array(
	        		"CompanyID"		=> $CompanyID,
	        		"EmployeeID"	=> $UserID,
	        		"Code"			=> $ID,
	        		"Page"			=> "t_leave",
	        		"Column"		=> "Attachment",
	        		"Temp"			=> json_encode($Attachment),
	        	);
	        	$this->main->general_save_android("t_temp", $data);
        	}

        	// $data = array("Attachment"	=> json_encode($Attachment));
        	// $this->main->general_update_android("t_leave",$data,$where);

        endif;

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
        );

        $this->main->echoJson($output);

    }

    public function DeleteLeave_T(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Code       = $this->input->post('Code');

        $where      = array(
            "t_leave.CompanyID"     => $CompanyID,
            "t_leave.EmployeeID"    => $UserID,
            "t_leave.Code"          => $Code,
        );
        $cek = $this->api->get_one_row("t_leave", "ApproveStatus,ifnull(Attachment,'[]') as Attachment",$where);
        $status     = false;
        $res_code   = 500;
        $message    = "Data Nout Found";
        if($cek):
            if($cek->ApproveStatus == 1):
                $Attachment = json_decode($cek->Attachment);
                foreach ($Attachment as $v) {
                    if(is_file($v)):
                        unlink('./' . $v);
                    endif;
                }
                $this->db->delete('t_leave',$where);
                $this->inser_log(1,4,'t_leave', $Code);//$LogType,$Type,$Page,$Content=""
                $status  = true;
                $message = "Success";
                $res_code = 1;
            else:
                $message = "Data can't Delete";
            endif;
        endif;

        $output = array(
            "status"    => $status,
            "message"   => $message,
            "res_code"  => $res_code,
        );

        $this->main->echoJson($output);
    }

    public function ApprovalLeave_T(){
        $this->validate_user();

        $CompanyID      = $this->input->post('CompanyID');
        $UserID         = $this->input->post('UserID');
        $HakAksesType   = $this->input->post('HakAksesType');
        $Code           = $this->input->post('Code');
        $Status         = $this->input->post('Status');
        $Remark         = $this->input->post('Remark');

        $where = array(
            "Code"          => $Code, 
            "CompanyID"     => $CompanyID,
        );
        $cek = $this->api->get_one_row("t_leave", "ApproveStatus",$where);
        $status     = false;
        $res_code   = 500;
        $message    = "Data Nout Found";
        if($cek):
            if($cek->ApproveStatus == 1):
                $data = array(
                    "ApproveRemark"     => $Remark,
                    "ApproveStatus"     => $Status,
                    "ApproveID"         => $UserID,
                    "ApproveRoleType"   => $HakAksesType,
                    "ApproveDate"       => date("Y-m-d H:i:s"),
                );
                $this->main->general_update_android("t_leave",$data,$where);
                $status  = true;
                if($Status == 2):
                    $this->inser_log(1,8,'t_leave', $Code);//$LogType,$Type,$Page,$Content=""
                    $message = $this->lang->line('lb_success_approve');
                else:
                    $message = $this->lang->line('lb_success_reject');
                    $this->inser_log(1,9,'t_leave', $Code);//$LogType,$Type,$Page,$Content=""
                endif;
            else:
                $message = $this->lang->line('lb_data_not_delete');
            endif;
        endif;

        $output = array(
            "status"    => $status,
            "message"   => $message,
            "res_code"  => $res_code,
        );

        $this->main->echoJson($output);
    }    #overtime form
    public function GetOvertime_T(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $HakAksesType     = $this->input->post('HakAksesType');
        $Level      = $this->input->post('Level');
        $Page       = $this->input->post('Page');
        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        $ApprovalStatus    = $this->input->post('ApprovalStatus');

        $ParentList = array($UserID);

        if(!in_array($HakAksesType, array(1,2,3)) && $Page == 'approval'):
            if(in_array($Level,array(1,2,3))):
                $GetParent  = $this->api->GetParent($CompanyID,$UserID,$HakAksesType,$Level);
                $ParentList = $GetParent;
                array_push($ParentList,$UserID);
            endif;
        endif;

        $where = array(
            't_overtimes.CompanyID'     => $CompanyID,
            't_overtimes.Date >= '      => $StartDate,
            't_overtimes.Date <= '      => $EndDate,
        );
        if($ApprovalStatus):
            $where['t_overtimes.ApproveStatus'] = $ApprovalStatus;
        endif;
        $list = $this->api->t_overtime('array',$where,$ParentList);
        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $list,
        );

        $this->main->echoJson($output);
    }

    public function SaveOvertime_T(){
        $this->validate_user();
        $this->validation->SaveOvertimeAndroid();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $BranchID   = $this->input->post('BranchID');
        $StartDate  = $this->input->post('StartDate');
        $StartTime  = $this->input->post('StartTime');
        $EndDate    = $this->input->post('EndDate');
        $EndTime    = $this->input->post('EndTime');
        $Remark     = $this->input->post('Remark');

        $data = array(
            "CompanyID"         => $CompanyID,
            "EmployeeID"        => $UserID,
            "BranchID"        	=> $BranchID,
            "From"              => $StartDate." ".$StartTime,
            "To"                => $EndDate." ".$EndTime,
            "Remark"            => $Remark,
        );
        $ID = $this->main->generate_code_t_overtime($CompanyID);
        $data['Code'] = $ID;
        $data['Date'] = date("Y-m-d");

        $this->main->general_save_android("t_overtimes", $data);
        $this->inser_log(1,2,'t_overtimes', $ID);//$LogType,$Type,$Page,$Content=""

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
        );

        $this->main->echoJson($output);
    }

    public function GetOvertime_T_Row(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Code       = $this->input->post('Code');

        $where      = array(
            "t_overtimes.CompanyID"     => $CompanyID,
            "t_overtimes.Code"          => $Code,
        );
        $list = $this->api->t_overtime('array_row',$where);
        $list->FromTime = date("H:i", strtotime($list->From));
        $list->From = date("Y-m-d", strtotime($list->From));
        $list->ToTime = date("H:i", strtotime($list->To));
        $list->To = date("Y-m-d", strtotime($list->To));
        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $list,
        );

        $this->main->echoJson($output);
    }

    public function DeleteOvertime_T(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Code       = $this->input->post('Code');

        $where      = array(
            "t_overtimes.CompanyID"     => $CompanyID,
            "t_overtimes.EmployeeID"    => $UserID,
            "t_overtimes.Code"          => $Code,
        );
        $cek = $this->api->get_one_row("t_overtimes", "ApproveStatus",$where);
        $status     = false;
        $res_code   = 500;
        $message    = "Data Nout Found";
        if($cek):
            if($cek->ApproveStatus == 1):
                $this->db->delete('t_overtimes',$where);
                $this->inser_log(1,4,'t_overtimes', $Code);//$LogType,$Type,$Page,$Content=""
                $status  = true;
                $message = "Success";
                $res_code = 1;
            else:
                $message = "Data can't Delete";
            endif;
        endif;

        $output = array(
            "status"    => $status,
            "message"   => $message,
            "res_code"  => $res_code,
        );

        $this->main->echoJson($output);
    }

    public function ApprovalOvertime_T(){
        $this->validate_user();

        $CompanyID      = $this->input->post('CompanyID');
        $UserID         = $this->input->post('UserID');
        $HakAksesType   = $this->input->post('HakAksesType');
        $Code           = $this->input->post('Code');
        $Status         = $this->input->post('Status');
        $Remark         = $this->input->post('Remark');

        $where = array(
            "Code"          => $Code, 
            "CompanyID"     => $CompanyID,
        );
        $cek = $this->api->get_one_row("t_overtimes", "ApproveStatus",$where);
        $status     = false;
        $res_code   = 500;
        $message    = "Data Nout Found";
        if($cek):
            if($cek->ApproveStatus == 1):
                $data = array(
                    "ApproveRemark"     => $Remark,
                    "ApproveStatus"     => $Status,
                    "ApproveID"         => $UserID,
                    "ApproveRoleType"   => $HakAksesType,
                    "ApproveDate"       => date("Y-m-d H:i:s"),
                );
                $this->main->general_update_android("t_overtimes",$data,$where);
                $status  = true;
                if($Status == 2):
                    $this->inser_log(1,8,'t_overtimes', $Code);//$LogType,$Type,$Page,$Content=""
                    $message = $this->lang->line('lb_success_approve');
                else:
                    $message = $this->lang->line('lb_success_reject');
                    $this->inser_log(1,9,'t_overtimes', $Code);//$LogType,$Type,$Page,$Content=""
                endif;
            else:
                $message = $this->lang->line('lb_data_not_delete');
            endif;
        endif;

        $output = array(
            "status"    => $status,
            "message"   => $message,
            "res_code"  => $res_code,
        );

        $this->main->echoJson($output);
    }

    #Transaction Attendace

    public function CheckIn(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $BranchID   = $this->input->post('BranchID');
        
        $WorkPatternID = $this->input->post("WorkPatternID");
        $Type       = $this->input->post("Type");
        $Latitude   = $this->input->post("Latitude");
        $Longitude  = $this->input->post("Longitude");
        $Radius     = $this->input->post("Radius");
        $RadiusMessage = $this->input->post("RadiusMessage");
        $RadiusStatus  = $this->input->post("RadiusStatus");
        $LatlngCompany = $this->input->post("LatlngCompany");
        $Note          = $this->input->post("Note");
        $CountFile     = $this->input->post("CountFile");
        $Distance      = $this->input->post("Distance");
        $StartWorkDate = $this->input->post("StartWorkDate");
        $StartWorkDate1= $StartWorkDate;

        // Visit
        $VisitType  = $this->input->post("VisitType");

        if($StartWorkDate):
            $StartWorkDate = date("d", strtotime($StartWorkDate));
        else:
            $StartWorkDate = "01";
        endif;

        $StartWorkDate = date('Y-m-').$StartWorkDate;
        $DateNow       = date("Y-m-d");
        $DayNow        = date("D", strtotime($DateNow));
        $TimeNow       = date("H:i");
        $WorkDate      = date("Y-m-d");
        
        if($StartWorkDate>$DateNow):
            $StartWorkDate = date("Y-m-d", strtotime($StartWorkDate." -1 Month"));
        endif;

        $TotalWeek = $this->main->WeekOfMonth($StartWorkDate,$DateNow);
        $TotalWeek = count($TotalWeek);

        $where = array(
            "CompanyID" => $CompanyID,
            "WorkPatternID" => $WorkPatternID,
        );
        $dt_work = $this->api->work_pattern('array_row',$where);
        $TotalDayWork   = $dt_work->Days;// total hari kerja
        $Tolerance      = $dt_work->Tolerance;
        $ToleranceRemark = $dt_work->ToleranceRemark;
        $DaysIndex      = $this->main->IndexDays($DayNow);

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
            "Day"   => $DaysIndex,
        );
        $dt_work_detail = $this->api->work_pattern_detail("array_row",$where_det);
        $TimeWorkStart  = $dt_work_detail->From;
        $TimeWorkEnd    = $dt_work_detail->To;
        $WorkingDays    = $dt_work_detail->WorkingDays;

        $Time = $TimeWorkEnd;
        if(in_array($Type, array(1))):
            $Time = $TimeWorkStart;
            if($Tolerance == 1):
                $Time = date("H:i", strtotime('+'.$ToleranceRemark.' minutes', strtotime(date('Y-m-d '.$Time))));
            endif;
        endif;

        $StatusSave = TRUE;
        $Status     = 1;
        $message    = '';

        $d1 = strtotime(date("Y-m-d ".$TimeNow));
        $d2 = strtotime(date("Y-m-d ".$Time));
        if($Type == 1):
            if($d1>$d2):
                $Status  = 0;
                $message .= "- More than standard time \n";
            endif;
        elseif($Type == 2):
            if($d1<$d2):
                $Status  = 0;
                $message .= "- Less than standard time \n";
            endif;
        endif;

        if(in_array($Type,array(1,2))):
            if($RadiusStatus == 0):
                $Status  = 0;
                $message .= "- ".$RadiusMessage." \n";
            endif;

            if($Status == 0):
                if($Note == ''):
                    $message .= 'Please add note for approval.';
                    $output = array(
                        "status"    => false,
                        "message"   => $message,
                        "res_code"  => 2,
                    );
                    $this->main->echoJson($output);
                    exit();
                endif;
            endif;
        endif;

        if(in_array($Type, array(8,6))):
            if($CountFile<=0):
                $message = 'Please take a picture';
                $output = array(
                    "status"    => false,
                    "message"   => $message,
                    "res_code"  => 500,
                );
                $this->main->echoJson($output);
                exit();
            endif;
        endif;


        $code = $this->main->generate_code_t_attendace($CompanyID,$Type);

        $data = array(
            "Code"          => $code,
            "CompanyID"     => $CompanyID,
            "EmployeeID"    => $UserID,
            "BranchID"    	=> $BranchID,
            "Date"          => date("Y-m-d H:i:s"),
            "Latitude"      => $Latitude,
            "Longitude"     => $Longitude,
            "LatlngCompany" => $LatlngCompany,
            "Radius"        => $Radius,
            "Type"          => $Type,
            "Status"        => $Status,
            "Remark"        => $message,
            "Note"          => $Note,
            "WorkDate"      => $WorkDate,
            "WorkTime"      => $Time,
            "CheckIn"       => $DateNow." ".$TimeNow,
            "WorkingDays"   => $WorkingDays,
            "Days"          => $DaysIndex,
            "Distance"      => $Distance,
            "StartWorkDate"	=> $StartWorkDate1,

        );
        if($Type == 5):
            $data['VisitType']  = $VisitType;
        endif;
        if($Type != 1):
            $query = $this->db->query("select Code,WorkDate from t_attendance where Type = 1 and CompanyID = '$CompanyID' and EmployeeID = '$UserID' order by DateAdd desc limit 1")->row();
            if($query):
                $data['ParentCode'] = $query->Code;
                $data['WorkDate']   = $query->WorkDate;

                if($Type == 2 && $StatusSave):
                	$dt_update = array("Finish" => 1);
                	$this->main->general_update_android("t_attendance",$dt_update,array("CompanyID" => $CompanyID, "EmployeeID" => $UserID, "Code" => $query->Code));
                endif;

                //for visitout
                if($Type == 6):
                    $query = $this->db->query("select Code,WorkDate from t_attendance where Type = 5 and CompanyID = '$CompanyID' and EmployeeID = '$UserID' order by DateAdd desc limit 1")->row();
                    if($query):
                        $data['ParentCodeVisit'] = $query->Code;
                    endif;
                endif;

            else:
                $StatusSave = FALSE;
            endif;
        endif;

        if($StatusSave):
            $this->main->general_save_android("t_attendance", $data);
            $output = array(
                "status"    => true,
                "message"   => "success",
                "res_code"  => 1,
                "t_status"  => $Status,
                "t_message" => $message,
                "Code"      => $code,
            );
        else:
            $output = array(
                "status"    => false,
                "message"   => "You must check in first",
                "res_code"  => 500,
            );
        endif;

        $this->main->echoJson($output);
    }

    public function UploadAttendance2(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $ID         = $this->input->post('ID');
        $Type       = $this->input->post('Type');
        $Page       = $this->input->post('Page');
        $Data       = $this->input->post('Data');
        $Data       = json_decode($Data);

        $where = array(
            "CompanyID"     => $CompanyID,
            "EmployeeID"    => $UserID,
            "Code"          => $ID,
        );
        $dt_attendance = $this->api->get_one_row("t_attendance","ifnull(Attachment,'[]') as Attachment, ifnull(Picture,'[]') as Picture", $where);
        if($dt_attendance):
            if($Page == 'camera'):
                $Attachment  = json_decode($dt_attendance->Picture);
            else:
                $Attachment  = json_decode($dt_attendance->Attachment);
            endif;
            
            $FileName   = $Data->Name;
            $FileName   = str_replace(' ', '-', $FileName);
            $FileName   = explode('.', $FileName)[0];
            $Value      = $Data->Byte;
            $Extension  = $Data->Extension;
            
            $path       = "img/attachment/";
            $nmfile     = "alpa-".date("ymdHi").$FileName."-".$UserID.".".$Extension;

            if(!in_array($path.$nmfile, $Attachment)):
                file_put_contents($path.$nmfile,base64_decode($Value));
                array_push($Attachment, $path.$nmfile);
            endif;

            if($Page == 'camera'):
                $data = array("Picture"  => json_encode($Attachment));
            else:
                $data = array("Attachment"  => json_encode($Attachment));
            endif;
            
            $this->main->general_update_android("t_attendance",$data,$where);

        endif;

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "Page"      => $Page,
        );

        $this->main->echoJson($output);
    }

    public function UploadAttendance(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $ID         = $this->input->post('ID');
        $Type       = $this->input->post('Type');
        $Page       = $this->input->post('Page');
        $Data       = $this->input->post('Data');
        $Data       = json_decode($Data);

        $where = array(
            "CompanyID"     => $CompanyID,
            "EmployeeID"    => $UserID,
            "Code"          => $ID,
        );
        $dt_attendance = $this->api->get_one_row("t_attendance","ifnull(Attachment,'[]') as Attachment, ifnull(Picture,'[]') as Picture", $where);
        if($dt_attendance):
            $Attachment = array();
            array_push($Attachment,$Data);
            if($Page == 'camera'):
                $data = array("Temp"  => json_encode($Attachment));
            else:
                $data = array("TempAttach"  => json_encode($Attachment));
            endif;
            
            $this->main->general_update_android("t_attendance",$data,$where);

        endif;

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "Page"      => $Page,
        );

        $this->main->echoJson($output);
    }

    public function Attendance_T(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $HakAksesType     = $this->input->post('HakAksesType');
        $Level      = $this->input->post('Level');
        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        $ApprovalStatus    = $this->input->post('ApprovalStatus');

        $ParentList = array($UserID);

        if(!in_array($HakAksesType, array(1,2,3))):
			if(in_array($Level,array(1,2,3))):
				$GetParent  = $this->api->GetParent2($CompanyID,$UserID,$HakAksesType,$Level);
				$ParentList = $GetParent;
				array_push($ParentList,$UserID);
			endif;
		endif;

        $where = array(
            't_attendance.CompanyID'            => $CompanyID,
            'Date(t_attendance.WorkDate) >= '   => $StartDate,
            'Date(t_attendance.WorkDate) <= '   => $EndDate,
            't_attendance.Status !='            => 1,
        );
        if($ApprovalStatus):
            $where["ifnull(t_attendance.ApproveStatus,'1')"] = $ApprovalStatus;
        endif;
        $list = $this->api->t_attendance('array_list',$where,$ParentList);
        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $list,
        );

        $this->main->echoJson($output);
    }

    public function ApprovalAttendance(){
        $this->validate_user();

        $CompanyID      = $this->input->post('CompanyID');
        $UserID         = $this->input->post('UserID');
        $HakAksesType   = $this->input->post('HakAksesType');
        $Code           = $this->input->post('Code');
        $Status         = $this->input->post('Status');
        $Remark         = $this->input->post('Remark');

        $where = array(
            "Code"          => $Code, 
            "CompanyID"     => $CompanyID,
        );
        $cek = $this->api->get_one_row("t_attendance", "ifnull(ApproveStatus,1) as ApproveStatus",$where);
        $status     = false;
        $res_code   = 500;
        $message    = "Data Nout Found";
        if($cek):
            if($cek->ApproveStatus == 1):
                $data = array(
                    "Status"            => 2,
                    "ApproveRemark"     => $Remark,
                    "ApproveStatus"     => $Status,
                    "ApproveID"         => $UserID,
                    "ApproveRoleType"   => $HakAksesType,
                    "ApproveDate"       => date("Y-m-d H:i:s"),
                );
                $this->main->general_update_android("t_attendance",$data,$where);
                $status  = true;
                if($Status == 2):
                    $this->inser_log(1,8,'t_attendance', $Code);//$LogType,$Type,$Page,$Content=""
                    $message = $this->lang->line('lb_success_approve');
                else:
                    $message = $this->lang->line('lb_success_reject');
                    $this->inser_log(1,9,'t_attendance', $Code);//$LogType,$Type,$Page,$Content=""
                endif;
            else:
                $message = $this->lang->line('lb_data_not_delete');
            endif;
        endif;

        $output = array(
            "status"    => $status,
            "message"   => $message,
            "res_code"  => $res_code,
        );

        $this->main->echoJson($output);
    }

    public function History(){
    	$this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');

        $where = array(
            't_attendance.CompanyID'     => $CompanyID,
            't_attendance.EmployeeID'    => $UserID,
            't_attendance.WorkDate >= '  => $StartDate,
            't_attendance.WorkDate <= '  => $EndDate,
        );
        $list = $this->api->t_attendance('array',$where);
        foreach ($list as $k => $v) {
            $v->Duration = "";
            if($v->Type == 2):
                $where_checkin = array(
                    "CompanyID" => $CompanyID,
                    "Code"      => $v->ParentCode,
                    "EmployeeID" => $UserID,
                );
                $duration = $this->api->get_one_row("t_attendance","CheckIn",$where_checkin);
            elseif($v->Type == 8):
                $where_checkin = array(
                    "CompanyID"     => $CompanyID,
                    "ParentCode"    => $v->ParentCode,
                    "EmployeeID"    => $UserID,
                    "Type"          => 7,
                );
                $duration = $this->api->get_one_row("t_attendance","CheckIn",$where_checkin);
            endif;

            if(in_array($v->Type, array(2,8))):
                if($duration):
                    $duration = $duration->CheckIn;
                    if($duration>$v->CheckIn):
                        $v->Duration = "0";
                    else:
                        $duration = $this->main->time_elapsed_string($v->CheckIn,true,$duration,"duration");
                        $v->Duration = $duration;
                    endif;
                endif;
            endif;
        }

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"		=> $list,
        );

        $this->main->echoJson($output);
    }

    public function GetHistory(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');

        $list       = $this->api->HistoryAttendaceAndroid($CompanyID,$UserID,$StartDate,$EndDate);
        $list2      = $this->api->HistoryAttendaceVisitAndroid($CompanyID,$UserID,$StartDate,$EndDate);

        $arrVisitIn     = array();
        $arrVisitOut    = array();

        foreach ($list2 as $k => $v) {
           if($v->Type == 5):
                array_push($arrVisitIn,$v);
            else:
                array_push($arrVisitOut,$v);
            endif;
        }

        foreach ($list as $k => $v) {
            $DurationCheckIn = "-";
            if($v->CheckOut):
                $DurationCheckIn = $this->main->time_elapsed_string($v->CheckIn,true,$v->CheckOut,"duration");
                $d = explode(' ', $v->CheckOut);
                $v->CheckOut     = $d[0];
                $v->CheckOutTime = $d[1];
            else:
                $v->CheckOut     = "-";
                $v->CheckOutTime = "";
            endif;
            $v->DurationCheckIn = $DurationCheckIn;
            if($v->CheckIn):
                $d = explode(' ', $v->CheckIn);
                $v->CheckIn = $d[0];
                $v->CheckInTime = $d[1];
            else:
                $v->CheckIn = "-";
                $v->CheckInTime = "";
            endif;

            $DurationBreakStart = "-";
            if($v->BreakStart && $v->BreakEnd):
                $DurationBreakStart = $this->main->time_elapsed_string($v->BreakStart,true,$v->BreakEnd,"duration");
            endif;
            $v->DurationBreakStart = $DurationBreakStart;
            if($v->BreakStart):
                $d = explode(' ', $v->BreakStart);
                $v->BreakStart     = $d[0];
                $v->BreakStartTime = $d[1];
            else:
                $v->BreakStart     = "-";
                $v->BreakStartTime = "";
            endif;
            if($v->BreakEnd):
                $d = explode(' ', $v->BreakEnd);
                $v->BreakEnd     = $d[0];
                $v->BreakEndTime = $d[1];
            else:
                $v->BreakEnd     = "-";
                $v->BreakEndTime = "";
            endif;

            $DurationOvertime = "-";
            if($v->OvertimeIn && $v->OvertimeOut):
                $DurationOvertime = $this->main->time_elapsed_string($v->OvertimeIn,true,$v->OvertimeOut,"duration");
            endif;
            $v->DurationOvertime = $DurationOvertime;
            if($v->OvertimeIn):
                $d = explode(' ', $v->OvertimeIn);
                $v->OvertimeIn     = $d[0];
                $v->OvertimeInTime = $d[1];
            else:
                $v->OvertimeIn     = "-";
                $v->OvertimeInTime = "";
            endif;
            if($v->OvertimeOut):
                $d = explode(' ', $v->OvertimeOut);
                $v->OvertimeOut     = $d[0];
                $v->OvertimeOutTime = $d[1];
            else:
                $v->OvertimeOut     = "-";
                $v->OvertimeOutTime = "";
            endif;

            $arrVisit       = array();
            foreach ($arrVisitIn as $k2 => $v2) {
                if($v2->WorkDate == $v->WorkDate):
                    $key = array_search($v2->Code, array_column($arrVisitOut, 'ParentCodeVisit'));
                    $h['VisitIn']   = $v2->CheckIn;
                    if($v2->CheckIn):
                        $d = explode(' ', $v2->CheckIn);
                        $h['VisitIn']     = $d[0];
                        $h['VisitInTime'] = $d[1];
                    else:
                        $h['VisitIn']     = '-';
                        $h['VisitInTime'] = "";
                    endif;
                    if(strlen($key)>0):
                        $VisitOut       = $arrVisitOut[$key]->CheckIn;
                        $DurationVisit  = $this->main->time_elapsed_string($v2->CheckIn,true,$VisitOut,"duration");
                        
                        $d = explode(' ', $VisitOut);
                        $h['VisitOut']      = $d[0];
                        $h['VisitOutTime']  = $d[1];
                        $h['DurationVisit'] = $DurationVisit;
                    else:
                        $h['VisitOut']      = "-";
                        $h['VisitOutTime']  = "";
                        $h['DurationVisit'] = "-";
                    endif;

                    array_push($arrVisit, $h);
                endif;
            }
            $v->Visit = $arrVisit;
        }
        
        $data = array(
            "data"      => $list,
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
        );

        $this->main->echoJson($data);
    }

    public function PushData(){
        $this->validate_user();
        
        $CompanyID  		= $this->input->post('CompanyID');
        $UserID     		= $this->input->post('UserID');
        $BranchID     		= $this->input->post('BranchID');
        $StartWorkDate     	= $this->input->post('StartWorkDate');
        $StartWorkDate1 	= $StartWorkDate;
        $Data       = $this->input->post('Data');
        $Data       = json_decode($Data);

        if($StartWorkDate):
            $StartWorkDate = date("d", strtotime($StartWorkDate));
        else:
            $StartWorkDate = "01";
        endif;

        foreach ($Data as $k => $v) {
            $Date           = $v->Date;
            $WorkPatternID  = $v->WorkPatternID;
            $Latitude       = $v->Latitude;
            $Longitude      = $v->Longitude;
            $Distance       = $v->Distance;
            $Radius         = $v->Radius;
            $LatlngCompany  = $v->LatlngCompany;
            $Type           = $v->Type;
            $RadiusStatus   = $v->RadiusStatus;
            $RadiusMessage  = $v->RadiusMessage;
            $CountFile      = $v->CountFile;
            $Note           = $v->Note;
            $arr_attach     = $v->arr_attach;
            $VisitType      = $v->VisitType;

            $Image  = "";
            if(isset($v->Image)):
                $Image          = $v->Image;
            endif;

            $StartWorkDate = date('Y-m-').$StartWorkDate;
            $DateNow       = date("Y-m-d", strtotime($Date));
            $DayNow        = date("D", strtotime($DateNow));
            $TimeNow       = date("H:i", strtotime($Date));
            $WorkDate      = date("Y-m-d", strtotime($Date));

            if($StartWorkDate>$DateNow):
                $StartWorkDate = date("Y-m-d", strtotime($StartWorkDate." -1 Month"));
            endif;

            $TotalWeek = $this->main->WeekOfMonth($StartWorkDate,$DateNow);
            $TotalWeek = count($TotalWeek);

            $where = array(
                "CompanyID" => $CompanyID,
                "WorkPatternID" => $WorkPatternID,
            );
            $dt_work = $this->api->work_pattern('array_row',$where);
            $TotalDayWork   = $dt_work->Days;// total hari kerja
            $Tolerance      = $dt_work->Tolerance;
            $ToleranceRemark = $dt_work->ToleranceRemark;
            $DaysIndex      = $this->main->IndexDays($DayNow);

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
                "Day"   => $DaysIndex,
            );

            $dt_work_detail = $this->api->work_pattern_detail("array_row",$where_det);
            $TimeWorkStart  = $dt_work_detail->From;
            $TimeWorkEnd    = $dt_work_detail->To;
            $WorkingDays    = $dt_work_detail->WorkingDays;

            $Time = $TimeWorkEnd;
            if(in_array($Type, array(1))):
                $Time = $TimeWorkStart;
                if($Tolerance == 1):
                    $Time = date("H:i", strtotime('+'.$ToleranceRemark.' minutes', strtotime(date('Y-m-d '.$Time))));
                endif;
            endif;

            $StatusSave = TRUE;
            $Status     = 1;
            $message    = '';

            $d1 = strtotime(date("Y-m-d ".$TimeNow));
            $d2 = strtotime(date("Y-m-d ".$Time));
            if($Type == 1):
                if($d1>$d2):
                    $Status  = 0;
                    $message .= "- More than standard time \n";
                endif;
            elseif($Type == 2):
                if($d1<$d2):
                    $Status  = 0;
                    $message .= "- Less than standard time \n";
                endif;
            endif;

            if(in_array($Type,array(1,2))):
                if($RadiusStatus == 0):
                    $Status  = 0;
                    $message .= "- ".$RadiusMessage." \n";
                endif;

                if($Status == 0):
                    if($Note == ''):
                        $message .= 'Please add note for approval.';
                        $output = array(
                            "status"    => false,
                            "message"   => $message,
                            "res_code"  => 500,
                        );
                        $this->main->echoJson($output);
                        exit();
                    endif;
                endif;
            endif;

            // if(in_array($Type, array(8))):
            //     if($CountFile<=0):
            //         $message = 'Please take a picture';
            //         $output = array(
            //             "status"    => false,
            //             "message"   => $message,
            //             "res_code"  => 500,
            //         );
            //         $this->main->echoJson($output);
            //         exit();
            //     endif;
            // endif;

            $arr_picture = array();
            $arr_file 	 = array();
            if($arr_attach):
            	$arr_attach = json_encode($arr_attach);
            	$arr_attach = json_decode($arr_attach);
            	$arr_picture = $arr_attach->picture;
            	$arr_file 	 = $arr_attach->file;
            endif;

            $code = $this->main->generate_code_t_attendace($CompanyID,$Type);
            $data = array(
                "Code"          => $code,
                "CompanyID"     => $CompanyID,
                "EmployeeID"    => $UserID,
                "BranchID"    	=> $BranchID,
                "Date"          => date("Y-m-d H:i:s"),
                "Latitude"      => $Latitude,
                "Longitude"     => $Longitude,
                "LatlngCompany" => $LatlngCompany,
                "Radius"        => $Radius,
                "Type"          => $Type,
                "Status"        => 0,
                "Remark"        => $message,
                "Note"          => $Note,
                "WorkDate"      => $WorkDate,
                "WorkTime"      => $Time,
                "CheckIn"       => $DateNow." ".$TimeNow,
                "WorkingDays"   => $WorkingDays,
                "Days"          => $DaysIndex,
                "Distance"      => $Distance,
                "Temp"          => json_encode($arr_picture),
                "TempAttach"    => json_encode($arr_file),
                "StartWorkDate"	=> $StartWorkDate,
                "VisitType"     => $VisitType,
                "AppStatus"     => 0,

            );
            if($Type != 1):
                $query = $this->db->query("select Code,WorkDate from t_attendance where Type = 1 and CompanyID = '$CompanyID' and EmployeeID = '$UserID' order by DateAdd desc limit 1")->row();
                if($query):
                    $data['ParentCode'] = $query->Code;
                    $data['WorkDate']   = $query->WorkDate;

                    if($Type == 2 && $StatusSave):
	                	$dt_update = array("Finish" => 1);
	                	$this->main->general_update_android("t_attendance",$dt_update,array("CompanyID" => $CompanyID, "EmployeeID" => $UserID, "Code" => $query->Code));
	                endif;

                    //for visitout
                    if($Type == 6):
                        $query = $this->db->query("select Code,WorkDate from t_attendance where Type = 5 and CompanyID = '$CompanyID' and EmployeeID = '$UserID' order by DateAdd desc limit 1")->row();
                        if($query):
                            $data['ParentCodeVisit'] = $query->Code;
                        endif;
                    endif;
                else:
                    $StatusSave = FALSE;
                endif;
            endif;

            if($StatusSave):
                $this->main->general_save_android("t_attendance", $data);
                $output = array(
                    "status"    => true,
                    "message"   => "success",
                    "res_code"  => 1,
                    "t_status"  => $Status,
                    "t_message" => $message,
                    "Code"      => $code,
                );
            endif;
        }

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "oke"       => "oke pish", 
        );

        $this->main->echoJson($output);
    }

    private function inser_log($LogType,$Type,$Page="",$Content=""){
        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $HakAksesType   = null;

        $data_user = array(
            "browser"           => "Android",
            "sistem operasi"    => "",
            "IP"                => "",
        );

        $Code = $this->main->generate_code_log($CompanyID);
        $data = array(
            "Code"          => $Code,
            "CompanyID"     => $CompanyID,
            "UserID"        => $UserID,
            "HakAksesType"  => $HakAksesType,
            "LogType"       => $LogType,
            "Type"          => $Type,
            "Page"          => $Page,
            "Content"       => $Content,
            "UserAgent"     => json_encode($data_user),
        );

        $this->main->general_save_android("ut_log", $data);
    }

    public function CheckThemes(){
        $this->validate_user();
        
        $CompanyID  = $this->input->post('CompanyID');
        $dt_company = $this->api->get_one_row("ut_user","Theme", array("UserID" => $CompanyID));
        $Themes = 1;
        if($dt_company):
            $Themes = $dt_company->Theme;
        endif;

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "Themes"    => $Themes,
        );

        $this->main->echoJson($output);
    }

    public function VisitType(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Start      = $this->input->post('Start');

        $where = array(
            'mt.CompanyID'     => $CompanyID,
            // 'mt.Status'        => 1,
        );
        $list = $this->api->visit_type("array_limit", $where, $Start);

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
            "data"      => $list,
        );

        $this->main->echoJson($output);
    }

    public function InsertLog(){
    	$this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Type       = $this->input->post('Type');

        $this->inser_log(3,12,'t_attendance_page', $Type);//$LogType,$Type,$Page,$Content=""

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
        );

        $this->main->echoJson($output);
    }

    public function LastPosition(){
        $this->validate_user();

        $CompanyID  = $this->input->post('CompanyID');
        $UserID     = $this->input->post('UserID');
        $Latlng     = $this->input->post('Latlng');

        $data = array(
            "Latlng"  => $Latlng
        );

        $this->main->general_update("mt_employee", $data,array("EmployeeID" => $UserID));

        $output = array(
            "status"    => TRUE,
            "message"   => 'success',
            "res_code"  => 1,
        );

        $this->main->echoJson($output);
    }
}
