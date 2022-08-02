<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_report extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }

    public function ReportType(){
    	$url 			= $this->input->post('url');
    	$ReportType 	= $this->input->post('ReportType');

    	$arrReportType = array();

    	if($url == 'report-transaction-leave'):
    		$arrReportType = array(
	    		'leave_total',
                'leave_detail'
	    	);
        elseif($url == 'report-transaction-overtime'):
            $arrReportType = array(
                'overtime_form',
            );
        elseif($url == 'report-transaction-attendance'):
            $arrReportType = array(
                'attendance_report',
                'attendance_report_h',
                'attendance_visit',
            );
        elseif($url == 'transaction-attendance'):
            $arrReportType = array(
                'attendance',
            );
        elseif($url == 'report-log'):
            $arrReportType = array(
                'report_log',
                'report_log_company',
            );
    	endif;

    	if(!in_array($ReportType,$arrReportType)):
            return false;
    	endif;

        return true;
    }

    public function leave_total(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;
        $Companyx       = $this->input->post('Company');
        $Userx          = $this->input->post('User');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        $where = '';
        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        $Status     = $this->input->post('Status');

        if($StartDate):
            $where .= " and Date(t.Date) >= '$StartDate' ";
        endif;
        if($EndDate):
            $where .= " and Date(t.Date) <= '$EndDate' ";
        endif;
        if($Status != 'none' and $Status):
            $where .= " and t.ApproveStatus = '$Status' ";
        endif;

        $table = "mt_employee";
        $this->db->select("
            $table.Name,
            $table.Nik,
            $table.Departement,
            r.Name  as roleName,

            ifnull((select count(t.Code) from t_leave t where CompanyID = $table.CompanyID and t.EmployeeID = $table.EmployeeID $where),0) as Total
        ");
        $this->db->from($table);
        $this->db->join("ut_role r", "$table.RoleID = r.RoleID");
        $this->db->where("$table.CompanyID", $CompanyID);
        if(!in_array($HakAksesType, array(1,2,3)) && !$Userx):
            if(in_array($Level,array(1,2,3))):
                array_push($ParentList,$UserID);
                $this->db->group_start();
                $this->db->where_in("$table.EmployeeID", $ParentList);
                $this->db->group_end();
            else:
                $this->db->where("$table.EmployeeID", $UserID);
            endif;
        elseif($Userx):
            $this->db->where("$table.EmployeeID", $Userx);
        endif;
        $query = $this->db->get()->result();

        return $query;
    }

    public function leave_detail(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;
        $Companyx       = $this->input->post('Company');
        $Userx          = $this->input->post('User');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        $table = "t_leave";
        $this->db->select("
            $table.Code,
            $table.EmployeeID,
            $table.Date,
            $table.From,
            $table.To,
            $table.ApproveStatus,
            $table.Remark,
            ifnull($table.Attachment,'[]') as Attachment,
            $table.ApproveID,
            $table.ApproveDate,
            ifnull($table.ApproveRemark,'') as ApproveRemark,

            company.Name    as CompanyName,
            employee.Name   as EmployeeName,
            employee.Departement,
            employee.Nik,
            employee.Position,
            leave.Code      as LeaveCode,
            leave.Name      as leaveName,
            r.Name          as roleName,

            ifnull(case
                when $table.ApproveRoleType in (1,2,3) then approve_company.Name
                else approve_user.Name
            end,'') as ApproveBy,
        ");
        $this->db->join("ut_user company", "company.UserID = $table.CompanyID");
        $this->db->join("mt_leave as leave", "$table.LeaveID = leave.LeaveID and $table.CompanyID = leave.CompanyID");
        $this->db->join("mt_employee employee", "employee.EmployeeID = $table.EmployeeID");
        $this->db->join("ut_role r", "employee.RoleID = r.RoleID");

        $this->db->join("ut_user approve_company", "approve_company.UserID = $table.ApproveID", "left");
        $this->db->join("mt_employee approve_user", "approve_user.EmployeeID = $table.ApproveID", "left");
        $this->db->from($table);

        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        $Status     = $this->input->post('Status');
        if($StartDate):
            $this->db->where("$table.Date >=", $StartDate);
        endif;
        if($EndDate):
            $this->db->where("$table.Date <=", $EndDate);
        endif;
        if($Status != 'none' and $Status):
            $this->db->where("$table.ApproveStatus", $Status);
        endif;

        $this->db->where("$table.CompanyID", $CompanyID);
        if(!in_array($HakAksesType, array(1,2,3)) && !$Userx):
            if(in_array($Level,array(1,2,3))):
                array_push($ParentList,$UserID);
                $this->db->group_start();
                $this->db->where_in("$table.EmployeeID", $ParentList);
                $this->db->group_end();
            else:
                $this->db->where("$table.EmployeeID", $UserID);
            endif;
        elseif($Userx):
            $this->db->where("$table.EmployeeID", $Userx);
        endif;
        $this->db->order_by("employee.Name");
        $query = $this->db->get()->result();

        return $query;
    }

    public function overtime_form(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;
        $Companyx       = $this->input->post('Company');
        $Userx          = $this->input->post('User');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        $table = "t_overtime";
        $table = "t_overtimes";
        $this->db->select("
            $table.Code,
            $table.EmployeeID,
            $table.Date,
            $table.From,
            $table.To,
            $table.ApproveStatus,
            $table.Remark,
            $table.ApproveID,
            $table.ApproveDate,
            ifnull($table.ApproveRemark,'') as ApproveRemark,

            company.Name    as CompanyName,
            employee.Name   as EmployeeName,
            employee.Departement,
            employee.Nik,
            employee.Position,
            r.name as roleName,

            ifnull(case
                when $table.ApproveRoleType in (1,2,3) then approve_company.Name
                else approve_user.Name
            end,'') as ApproveBy,
        ");
        $this->db->join("ut_user company", "company.UserID = $table.CompanyID");
        $this->db->join("mt_employee employee", "employee.EmployeeID = $table.EmployeeID");
        $this->db->join("ut_role r", "employee.RoleID = r.RoleID");

        $this->db->join("ut_user approve_company", "approve_company.UserID = $table.ApproveID", "left");
        $this->db->join("mt_employee approve_user", "approve_user.EmployeeID = $table.ApproveID", "left");
        $this->db->from($table);

        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        $Status     = $this->input->post('Status');
        if($StartDate):
            $this->db->where("$table.Date >=", $StartDate);
        endif;
        if($EndDate):
            $this->db->where("$table.Date <=", $EndDate);
        endif;
        if($Status != 'none' and $Status):
            $this->db->where("$table.ApproveStatus", $Status);
        endif;

        $this->db->where("$table.CompanyID", $CompanyID);
        if(!in_array($HakAksesType, array(1,2,3)) && !$Userx):
            if(in_array($Level,array(1,2,3))):
                array_push($ParentList,$UserID);
                $this->db->group_start();
                $this->db->where_in("$table.EmployeeID", $ParentList);
                $this->db->group_end();
            else:
                $this->db->where("$table.EmployeeID", $UserID);
            endif;
        elseif($Userx):
            $this->db->where("$table.EmployeeID", $Userx);
        endif;
        $this->db->order_by("employee.Name");
        $query = $this->db->get()->result();

        return $query;
    }

    public function attendance_report(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;
        $Companyx       = $this->input->post('Company');
        $Userx          = $this->input->post('User');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        if(!in_array($HakAksesType, array(1,2,3)) && !$Userx):
            if(in_array($Level,array(1,2,3))):
                array_push($ParentList,$UserID);
            else:
                $ParentList = array($UserID);
            endif;
            $ParentList = implode(",", $ParentList);
        elseif($Userx):
            $ParentList = $Userx;
        else:
            $ParentList = $this->api->get_one_row("mt_employee", "GROUP_CONCAT(EmployeeID) as ID", array("CompanyID" => $CompanyID));
            if($ParentList):
                $ParentList = $ParentList->ID;
            else:
                $ParentList = '';
                echo "User is empty";
                exit();
            endif;
        endif;

        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        if(!$StartDate): $StartDate = '1998-01-01'; endif;
        if(!$EndDate): $EndDate = date("Y-m-d"); endif;

        if($ParentList):
            // return $this->db->query("call t_attendance_procedure($CompanyID,'$ParentList','$StartDate','$EndDate')")->result();
            $data_session = array(
                "ReportCompany"     => $CompanyID,
                "ReportStartDate"   => $StartDate,
                "ReportEndDate"     => $EndDate,
            );

            $this->session->set_userdata($data_session);

            $ParentList = explode(",", $ParentList);
            return $ParentList;
        else:
            return array();
        endif;
    }

    public function attendance_visit(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;
        $Companyx       = $this->input->post('Company');
        $Userx          = $this->input->post('User');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        if(!in_array($HakAksesType, array(1,2,3)) && !$Userx):
            if(in_array($Level,array(1,2,3))):
                array_push($ParentList,$UserID);
            else:
                $ParentList = array($UserID);
            endif;

            $ParentList = implode(",", $ParentList);
        elseif($Userx):
            $ParentList = $Userx;
        else:
            $ParentList = $this->api->get_one_row("mt_employee", "GROUP_CONCAT(EmployeeID) as ID", array("CompanyID" => $CompanyID));
            if($ParentList):
                $ParentList = $ParentList->ID;
            else:
                $ParentList = '';
                echo "User is empty";
                exit();
            endif;
        endif;

        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        if(!$StartDate): $StartDate = '1998-01-01'; endif;
        if(!$EndDate): $EndDate = date("Y-m-d"); endif;

        if($ParentList):
            return $this->api->HistoryAttendaceVisitAndroid($CompanyID,$ParentList,$StartDate,$EndDate,"report");
        else:
            return array();
        endif;
    }

    public function log(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;
        $Companyx       = $this->input->post('Company');
        $Userx          = $this->input->post('User');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        if(!in_array($HakAksesType, array(1,2,3)) && !$Userx):
            if(in_array($Level,array(1,2,3))):
                array_push($ParentList,$UserID);
            else:
                $ParentList = array($UserID);
            endif;
        elseif($Userx):
            $ParentList = array($Userx);
        else:
            $ParentList = $this->api->get_one_row("mt_employee", "GROUP_CONCAT(EmployeeID) as ID", array("CompanyID" => $CompanyID));
            if($ParentList):
                $ParentList = $ParentList->ID;
                $ParentList = explode(",",$ParentList);
            else:
                $ParentList = '';
                echo "User is empty";
                exit();
            endif;
        endif;

        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        if(!$StartDate): $StartDate = '1998-01-01'; endif;
        if(!$EndDate): $EndDate = date("Y-m-d"); endif;

        if($ParentList):
            $where = array(
                "ut_log.CompanyID"         => $CompanyID,
                "ut_log.HakAksesType"      => null,
                "Date(ut_log.DateAdd) >= " => $StartDate,
                "Date(ut_log.DateAdd) <= " => $EndDate,
            );
            return $this->api->log("array",$where,$ParentList);
        else:
            return array();
        endif;
    }

    public function log_company(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;
        $Companyx       = $this->input->post('Company');
        $Userx          = $this->input->post('User');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        $StartDate  = $this->input->post('StartDate');
        $EndDate    = $this->input->post('EndDate');
        if(!$StartDate): $StartDate = '1998-01-01'; endif;
        if(!$EndDate): $EndDate = date("Y-m-d"); endif;

        $where = array(
            "ut_log.CompanyID"         => $CompanyID,
            "ut_log.HakAksesType != "  => null,
            "Date(ut_log.DateAdd) >= " => $StartDate,
            "Date(ut_log.DateAdd) <= " => $EndDate,
        );
        return $this->api->log("array",$where);
    }

    public function DataNotFound($p1=""){
        $Print = $this->input->post('Print');
        $logo = '';
        if($Print):

        endif;
        $item = '<tr><td colspan="'.$p1.'"><div align="center"><img src="'.site_url('img/icon/Logo.png').'" width="70px"><h4>Data Not Found</h4></div></td></tr>';
        return $item;
    }

    public function ReportName(){
        $ReportType     = $this->input->post('ReportType');
        $name = '';

        if($ReportType == 'leave_total'):
            $name = 'Leave Total';
        elseif($ReportType == 'leave_detail'): $name = "Leave Detail";
        elseif($ReportType == 'overtime_form'): $name = "Overtime Form";
        elseif($ReportType == 'attendance_report'): $name = "Attendance Report";
        elseif($ReportType == 'attendance_report_h'): $name = "Attendance Report H";
        elseif($ReportType == 'attendance_visit'): $name = "Visit Report";
        elseif($ReportType == 'report_log'): $name = "User LOG";
        elseif($ReportType == 'report_log_company'): $name = "Company LOG";
        endif;

        return $name;
    }

    public function GetCompany(){
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;
        $Companyx       = $this->input->post('Company');

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        $query = $this->db->query("select Name,Image from ut_user where UserID = '$CompanyID'")->row();
        if(!$query):
            echo "Please Select Company";
            exit();
        endif;
        return $query;
    }
}