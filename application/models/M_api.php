<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_api extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }

    public function user($p1,$p2=""){
        $CompanyID = $this->session->CompanyID;
        $this->db->from("ut_user");
        if($p1 == "username"):
            $p1 = "detail";
            $this->db->group_start();
            $this->db->where("Email", $p2);
            $this->db->or_where("Username", $p2);
            $this->db->group_end();
            $this->db->where("Status", 1);
        elseif($p1 == "detail_id"):
            $p1 = "detail";
            $this->db->where("UserID", $p2);
        endif;
        $query = $this->db->get();

        if($p1 == "detail"):
            return $query->row();
        endif;

    }

    public function menu($p1="",$p2="", $p3=""){
        $HakAksesList = $this->role("my_role");
        if(!$p1):
            $p1         = $this->input->post("p1");
        endif;
        $Select     = $this->input->post("Select");
        $Name       = $this->input->post('Name');
        $Level      = $this->input->post('Level');
        $Type      = $this->input->post('Type');

        $this->db->select("
            MenuID as ID,
            Name,
            Level,
            ParentID,
            Type,
            Icon,
            Url,
        ");

        if($p1 == "Select"):
            $Level -= 1;
            $this->db->like("Name", $Name);
            $this->db->where("Level", $Level);
            $this->db->limit(10);
        elseif($p1 == "role-setting"):
            $this->db->like('Type', $Type);
            $this->db->where("Level !=", 3);
        elseif($p1 == "level1_backend"):
            $this->db->where("Level", 1);
            $this->db->like('Type', 'backend');
        elseif($p1 == "level2_backend"):
            $view = json_decode($HakAksesList->View);
            $this->db->where("Level", 2);
            $this->db->like('Type', 'backend');
            $this->db->where("ParentID", $p2);
            if(count($view)>0):
            	$this->db->where_in("MenuID", $view);
            else:
            	$this->db->where_in("MenuID", array('none'));
            endif;
        elseif($p1 == "backend"):
            $this->db->like('Type', 'backend');
        endif;

        $this->db->order_by("ifnull(ut_menu.Index,9999)");
        $query  = $this->db->get("ut_menu");
        return $query->result();

    }

    public function get_menuID($p1){
        $this->db->select('MenuID');
        $this->db->from('ut_menu');
        $this->db->like('Url',$p1);
        $MenuID = $this->db->get()->row();
        if($MenuID):
            $MenuID = $MenuID->MenuID;
        else:
            $MenuID = 0;
        endif;

        return $MenuID;

    }

    public function read_menu($p1,$CompanyID="",$HakAksesType="",$RoleID=""){
        if($CompanyID == ''): $CompanyID      = $this->session->CompanyID; endif;
        if($HakAksesType == ''): $HakAksesType      = $this->session->HakAksesType; endif;
        if($RoleID == ''): $RoleID      = $this->session->RoleID; endif;

        if($HakAksesType == 1)://developer
            $where = " and Type = 1 ";
        elseif($HakAksesType == 2)://super admin
            $where = " and Type = 2 ";
        elseif($HakAksesType == 3)://company
            $where = " and Type = 3 ";
        else://user
            $where = " and (Type = 0 or Type is null) and CompanyID = '$CompanyID' ";
        endif;
        
        $query = $this->db->query("
            SELECT 
                IFNULL(mt.View, '[]')    as cView,  
                IFNULL(mt.Insert, '[]')  as cInsert,
                IFNULL(mt.Update, '[]')  as cUpdate,
                IFNULL(mt.Delete, '[]')  as cDelete,
                IFNULL(mt.Approve, '[]') as cApprove 
            FROM ut_role mt WHERE RoleID = '$RoleID' $where ");
        foreach($query->result() as $b){
            $arrView    = json_decode($b->cView);
            $arrInsert  = json_decode($b->cInsert);
            $arrUpdate  = json_decode($b->cUpdate);
            $arrDelete  = json_decode($b->cDelete);
            $arrApprove = json_decode($b->cApprove);

            $view       = count(array_keys($arrView, $p1 ));
            $insert     = count(array_keys($arrInsert, $p1 ));
            $update     = count(array_keys($arrUpdate, $p1 ));
            $delete     = count(array_keys($arrDelete, $p1 ));
            $approve    = count(array_keys($arrApprove, $p1 ));

            $data = array(
                'view'      => $view,
                'insert'    => $insert,
                'update'    => $update,
                'delete'    => $delete,
                'approve'   => $approve,

            );

            $data = json_encode($data);
            $data = json_decode($data);

            return $data;
        }

        $data = array(
            'view'      => 0,
            'insert'    => 0,
            'update'    => 0,
            'delete'    => 0,
            'approve'   => 0,

        );

        $data = json_encode($data);
        $data = json_decode($data);
        return $data;

    }

    public function get_one_row($table,$column,$where){
        $this->db->select($column);
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->row();
    }

    public function get_result($table,$column,$where){
        $this->db->select($column);
        $this->db->where($where);
        $query = $this->db->get($table);

        return $query->result();
    }

    public function role($p1,$p2=""){
        $CompanyID = $this->session->CompanyID;

        $this->db->select("
            RoleID as ID,
            Name,
            Remark,
            View,
            Insert,
            Update,
            Delete,
            Type,
            Level,
        ");


        $this->db->from("ut_role as role");
        if($p1 == "detail_id"):
            $p1 = "detail";
            $this->db->where("RoleID", $p2);
        elseif($p1 == "my_role"):
            $p1 = "detail";
            $RoleID = $this->session->RoleID;
            $this->db->where("RoleID", $RoleID);
        endif;

        $query = $this->db->get();

        if($p1 == "detail"):
            return $query->row();
        endif;

    }

    public function employee($p1,$p2="",$p3=""){
        $Companyx       = $this->input->post('Companyx');
        $CompanyID      = $this->session->CompanyID;
        $HakAksesType   = $this->session->HakAksesType;

        $this->db->select("
            mt_employee.EmployeeID,
            mt_employee.CompanyID,
            mt_employee.BranchID,
            mt_employee.Name,
            mt_employee.Email,
            mt_employee.Username,
            mt_employee.Phone,
            mt_employee.PhoneCountry,
            mt_employee.Gender,
            mt_employee.StartWork,
            mt_employee.Imei,
            mt_employee.ImeiDefault,
            mt_employee.Image,
            mt_employee.CompanyID,
            mt_employee.RoleID,
            mt_employee.ParentID,
            mt_employee.WorkPatternID,
            mt_employee.NameLast,
            mt_employee.Departement,
            mt_employee.Web,
            mt_employee.DeviceID,
            mt_employee.Latlng,
            ifnull(mt_employee.Nik,'') as Nik,
            ifnull(mt_employee.Position,'') as Position,
            mt_employee.Password,
            mt_employee.Status,
            role.Name       as RoleName,
            role.Type       as RoleType,
            role.Level      as RoleLevel,
            company.Name    as CompanyName,
            company.Status  as CompanyStatus,
            company.Image   as CompanyImage,
            company.Theme,
            ifnull(parent.Name,'')     as parentName,
            pattern.Name    as patternName,
            
            branch.Name         as branchName,
            branch.Latitude     as branchLatitude,
            branch.Longitude    as branchLongitude,
            branch.Radius       as branchRadius,
            branch.Address      as branchAddress,
            branch.Phone        as branchPhone,

        ");

        $this->db->from("mt_employee");
        $this->db->join("ut_role role", "role.RoleID = mt_employee.RoleID and role.CompanyID = mt_employee.CompanyID");
        $this->db->join("mt_employee parent", "mt_employee.ParentID = parent.EmployeeID and parent.CompanyID = mt_employee.CompanyID","left");
        $this->db->join("mt_workpattern pattern", "pattern.WorkPatternID = mt_employee.WorkPatternID and pattern.CompanyID = mt_employee.CompanyID");
        $this->db->join("ut_user company", "company.UserID = mt_employee.CompanyID");
        $this->db->join("mt_branch branch", "branch.BranchID = mt_employee.BranchID");
        if($p1 == 'array_row'):
            $this->db->where($p2);
        elseif(!in_array($HakAksesType, array(1,2)) and $p1 != "username"):
            $this->db->where("mt_employee.CompanyID", $CompanyID);
        elseif($p1 == "users"):
            $this->db->where("mt_employee.CompanyID", $Companyx);
            if(!$Companyx):
                echo 'Please select Company';
                exit();
            endif;
        elseif($p1 == "where"):
            $this->db->where($p2);
        elseif($p1 == "username"):
            $this->db->join("ut_user as company_", "company_.UserID = mt_employee.CompanyID");
            $this->db->group_start();
            $this->db->where("mt_employee.Email", $p2);
            $this->db->or_where("mt_employee.Username", $p2);
            $this->db->group_end();
            if($p3):
                $this->db->where("mt_employee.Password", $p3);
            endif;
        endif;

        $query = $this->db->get();

        if(in_array($p1, array('username','array_row'))):
            return $query->row();
        else:
            return $query->result();
        endif;
    }

    public function konstruksi($p1,$p2="",$p3=""){

        $this->db->select("
           mt_konstruksi.ID,
           mt_konstruksi.Posisi,
           mt_konstruksi.Nama_perusahaan1,
           mt_konstruksi.Nama_personil,
           mt_konstruksi.Tempat_tanggal_lahir,
           mt_konstruksi.Pendidikan,
           mt_konstruksi.Pendidikan_non_formal,
           mt_konstruksi.Penguasaan_bahasa_indo,
           mt_konstruksi.Penguasaan_bahasa_inggris,
           mt_konstruksi.Penguasaan_bahasa_setempat,
           mt_konstruksi.Status_kepegawaian2,
           mt_konstruksi.Pernyataan,
           mt_konstruksi.Status,

          det.ID,
          det.DetID,
          det.PengalamanID,
          det.Nama_kegiatan,
          det.Lokasi_kegiatan,
          det.Pengguna_jasa,
          det.Nama_perusahaan,
          det.Uraian_tugas,
          det.Waktu_pelaksanaan,
          det.Posisi_penugasan,
          det.Status_kepegawaian,
          det.Surat_referensi,

        ");

        $this->db->from("mt_konstruksi");
        $this->db->join("mt_konstruksi_det det", "det.ID = mt_konstruksi.ID");

        $query = $this->db->get();

        return $query->result();
    }

    public function getDataKonstruksi(){

        $this->db->select("
           mt_konstruksi.ID,
           mt_konstruksi.Posisi,
           mt_konstruksi.Nama_perusahaan1,
           mt_konstruksi.Nama_personil,
           mt_konstruksi.Tempat_tanggal_lahir,
           mt_konstruksi.Pendidikan,
           mt_konstruksi.Pendidikan_non_formal,
           mt_konstruksi.Penguasaan_bahasa_indo,
           mt_konstruksi.Penguasaan_bahasa_inggris,
           mt_konstruksi.Penguasaan_bahasa_setempat,
           mt_konstruksi.Status_kepegawaian2,
           mt_konstruksi.Pernyataan,
           mt_konstruksi.Status,

          det.ID,
          det.DetID,
          det.PengalamanID,
          det.Nama_kegiatan,
          det.Lokasi_kegiatan,
          det.Pengguna_jasa,
          det.Nama_perusahaan,
          det.Uraian_tugas,
          det.Waktu_pelaksanaan,
          det.Posisi_penugasan,
          det.Status_kepegawaian,
          det.Surat_referensi,

        ");

        $this->db->from("mt_konstruksi");
        $this->db->join("mt_konstruksi_det det", "det.ID = mt_konstruksi.ID");

        $query = $this->db->get();

        return $query->result();
    }
    public function getDataNonKonstruksi(){

        $this->db->select("
           mt_non_konstruksi.ID,
           mt_non_konstruksi.Posisi,
           mt_non_konstruksi.Nama_perusahaan1,
           mt_non_konstruksi.Nama_personil,
           mt_non_konstruksi.Tempat_tanggal_lahir,
           mt_non_konstruksi.Pendidikan,
           mt_non_konstruksi.Pendidikan_non_formal,
           mt_non_konstruksi.Penguasaan_bahasa_indo,
           mt_non_konstruksi.Penguasaan_bahasa_inggris,
           mt_non_konstruksi.Penguasaan_bahasa_setempat,
           mt_non_konstruksi.Status_kepegawaian2,
           mt_non_konstruksi.Pernyataan,
           mt_non_konstruksi.Status,

          det.ID,
          det.DetID,
          det.PengalamanID,
          det.Nama_kegiatan,
          det.Lokasi_kegiatan,
          det.Pengguna_jasa,
          det.Nama_perusahaan,
          det.Uraian_tugas,
          det.Waktu_pelaksanaan,
          det.Posisi_penugasan,
          det.Status_kepegawaian,
          det.Surat_referensi,

        ");

        $this->db->from("mt_non_konstruksi");
        $this->db->join("mt_non_konstruksi_det det", "det.ID = mt_non_konstruksi.ID");

        $query = $this->db->get();

        return $query->result();
    }

    public function work_pattern($p1,$p2=""){
        $Companyx       = $this->input->post('Companyx');
        $CompanyID      = $this->session->CompanyID;
        $HakAksesType   = $this->session->HakAksesType;

        $this->db->select("
            mt.WorkPatternID as ID,
            mt.Name,
            mt.Days,
            ifnull(mt.Tolerance,0) as Tolerance,
            ifnull(mt.ToleranceRemark,0) as ToleranceRemark,
            mt.Status,
        ");

        $this->db->from("mt_workpattern as mt");
        if($p1 == 'array_row'):
            $this->db->where($p2);
        elseif(!in_array($HakAksesType, array(1,2))):
            $this->db->where("mt.CompanyID", $CompanyID);
        elseif($p1 == "export"):
            $this->db->select("
                dt.WorkPatternDetID as detID,
                dt.Day,
                dt.WorkingDays,
                DATE_FORMAT(dt.From,'%H:%i') as dFrom,
                DATE_FORMAT(dt.To,'%H:%i') as dTo,
            ");
            $this->db->join("mt_workpattern_detail dt","dt.WorkPatternID = mt.WorkPatternID and mt.CompanyID = dt.CompanyID");
            $this->db->where("mt.CompanyID", $Companyx);
            $this->db->order_by("dt.Day");

            if(!$Companyx):
                echo 'Please select Company';
                exit();
            endif;
        endif;

        $query = $this->db->get();
        if(in_array($p1, array('array_row'))):
            return $query->row();
        else:
            return $query->result();
        endif;
    }

    public function work_pattern_detail($p1,$p2=""){
        $this->db->select("
            dt.Day,
            dt.WorkingDays,
            dt.From,
            dt.To,
        ");
        $this->db->from("mt_workpattern_detail as dt");
        if($p1 == 'array_row'):
            $this->db->where($p2);
        elseif(!in_array($HakAksesType, array(1,2))):
            $this->db->where("dt.CompanyID", $CompanyID);
        endif;

        $query = $this->db->get();
        if(in_array($p1, array('array_row'))):
            return $query->row();
        else:
            return $query->result();
        endif;
    }

    public function log($p2="",$p3="",$p4=""){
        $table = "ut_log";

        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $HakAksesType   = $this->session->HakAksesType;
        $p1             = $this->input->post('p1');

        $this->db->select("
            $table.Code,
            $table.Page,
            $table.Content,
            $table.DateAdd,
            $table.Type,
            $table.Status,
            $table.HakAksesType,
            $table.LogType,

            company.Name    as companyName,
            company.Image   as companyImage,

            employee.EmployeeID,
            employee.Name   as employeeName,
            employee.Nik    as employeeNik,
            employee.Departement as employeeDepartement,
            employee.Image  as employeeImage,
        ");
        $this->db->join("ut_user as company", "company.UserID = $table.CompanyID");
        $this->db->join("mt_employee as employee", "employee.CompanyID = $table.CompanyID and employee.EmployeeID = $table.UserID", "left");
        $this->db->from($table);

        if($p2 == 'array'):
            $this->db->where($p3);
            if($p4):
                $this->db->where_in("employee.EmployeeID", $p4);
            endif;
            $this->db->order_by("$table.UserID");
            $this->db->order_by("$table.DateAdd", 'desc');
        elseif(in_array($HakAksesType, array(1,2,3))):
            $this->db->where("$table.CompanyID", $CompanyID);
        else:
            $this->db->where("$table.CompanyID", $CompanyID);
            $this->db->where("$table.UserID", $UserID);
        endif;

        if($p1 == 'log_info'):
            $this->db->where("$table.LogType", 1);
            $this->db->limit(10);
            $this->db->order_by("$table.DateAdd", 'desc');
        endif;

        $query = $this->db->get();
        return $query->result();
    }

    public function visit_type($p1,$p2="",$p3=""){
        $Companyx       = $this->input->post('Companyx');
        $CompanyID      = $this->session->CompanyID;
        $HakAksesType   = $this->session->HakAksesType;

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $Companyx;
        endif;

        $this->db->select("
            mt.VisitID as ID,
            mt.Name,
            mt.Category,
            mt.Remark,
            mt.Status,
        ");

        $this->db->from("mt_visit as mt");
        if($p1 == 'array_row'):
            $this->db->where($p2);
        elseif($p1 == 'array_limit'):
            $this->db->where($p2);
            $this->db->limit(20,$p3);
        elseif($p1 == "export"):
            $this->db->where("mt.CompanyID", $Companyx);
            if(!$Companyx):
                echo 'Please select Company';
                exit();
            endif;
        else:
            $this->db->where("mt.CompanyID", $CompanyID);
        endif;

        $query = $this->db->get();
        if(in_array($p1, array('array_row'))):
            return $query->row();
        else:
            return $query->result();
        endif;
    }

    public function GetMenuName($url)
    {
        $Value = 'Nothing';
        $this->db->select('Name');
        $this->db->from('ut_menu');
        if($url == "current_url"):
            $url = current_url();
            $url = str_replace(base_url(), "", $url);
            $this->db->where('Url',$url);
        else:
            $this->db->like('Url',$url);
            $this->db->or_like('Root',$url);
        endif;
        $data = $this->db->get()->row();
        if($data):
            $Value = $data->Name;
        endif;
        return $Value;
    }

    public function get_parent($p1){
        $this->db->select("EmployeeID");
        $this->db->where("ParentID", $p1);
        $this->db->from("mt_employee");
        $query = $this->db->get();

        $data = array();
        foreach ($query->result() as $k => $v) {
            array_push($data,$v->EmployeeID);
        }

        return $data;
    }

    public function general_setting($p1,$p2=""){
        $this->db->select("
            Code,
            Name,
            Value
        ");
        if($p1 == 'array_code'):
            $this->db->where_in("ut_general.Code",$p2);
        else:
            $this->db->where("ut_general.Code",$p1);
        endif;
        $query = $this->db->get("ut_general");
        return $query->result();
    }

    #leave 
    public function t_leave($p1,$p2,$p3=""){
        $table = "t_leave";
        $this->db->select("
            $table.Code,
            $table.Date,
            $table.From,
            $table.To,
            $table.ApproveStatus,
            $table.Remark,
            ifnull($table.Attachment,'[]') as Attachment,
            ifnull($table.Picture,'[]') as Picture,
            $table.ApproveID,
            $table.ApproveDate,
            ifnull($table.ApproveRemark,'') as ApproveRemark,

            company.Name    as CompanyName,
            employee.Name   as EmployeeName,
            employee.Nik,
            employee.Position,
            leave.Code      as LeaveCode,
            leave.Name      as leaveName,

            ifnull(case
                when $table.ApproveRoleType in (1,2,3) then approve_company.Name
                else approve_user.Name
            end,'') as ApproveBy,
        ");
        $this->db->join("ut_user company", "company.UserID = $table.CompanyID");
        $this->db->join("mt_leave as leave", "$table.LeaveID = leave.LeaveID and $table.CompanyID = leave.CompanyID");
        $this->db->join("mt_employee employee", "employee.EmployeeID = $table.EmployeeID");

        $this->db->join("ut_user approve_company", "approve_company.UserID = $table.ApproveID", "left");
        $this->db->join("mt_employee approve_user", "approve_user.EmployeeID = $table.ApproveID", "left");
        $this->db->from($table);
        if($p1 == 'array'):
            $this->db->where($p2);
            if($p3):
                $this->db->where_in("$table.EmployeeID", $p3);
            endif;
            $this->db->order_by("$table.DateAdd", "desc");
        elseif($p1 == 'array_row'):
            $this->db->where($p2);
        endif;
        $query = $this->db->get();

        if(in_array($p1,array('array_row'))):
            return $query->row();
        else:
            return $query->result();
        endif;
    }

    public function pengalaman_kerja($p1,$p2="",$p3=""){
        
        $this->db->select("
            pk.ID,
            pk.Nama_kegiatan,
            pk.Lokasi_kegiatan,
            pk.Pengguna_jasa,
            pk.Nama_perusahaan,
            pk.Waktu_pelaksanaan_mulai,
            pk.Waktu_pelaksanaan_selesai,
            pk.Status,
        ");
        
        $this->db->from('mt_daftar_riwayat pk');
        $this->db->where("pk.Status", 1);

        $query = $this->db->get();

        return $query->result();
    }

    public function biodata($p1,$p2="",$p3=""){
        
        $this->db->select("
            pk.ID,
            pk.Nama_personil,
            pk.Tempat_tanggal_lahir,
            pk.Pendidikan,
            pk.Pendidikan_non_formal,
            pk.Nomor_hp,
            pk.Email,
            pk.Status,
            pk.Status_bio,
        ");
        
        $this->db->from('biodata pk');
        $this->db->where("pk.Status", 1);
        $this->db->where("pk.Status_bio", 1);

        $query = $this->db->get();

        return $query->result();
    }

    public function posisi($p1,$p2="",$p3=""){
        
        $this->db->select("
            pk.ID,
            pk.Posisi,
            pk.Uraian_tugas,
            pk.Status,
        ");
        
        $this->db->from('mt_posisi_uraian pk');
        $this->db->where("pk.Status", 1);

        $query = $this->db->get();

        return $query->result();
    }

    // history
    public function HistoryAttendaceAndroid($CompanyID,$EmployeeID,$StarDate,$EndDate,$Type=""){
        $ord = " desc ";
        if($Type == 'report'):
            $ord = "";
        endif;
        $query = $this->db->query("
            select
                ck_checkin.EmployeeID,
                employee.Name as EmployeeName,
                employee.Nik,
                ck_checkin.WorkDate,
                ck_checkin.Code as Code,ck_checkin.CheckIn  as CheckIn,
                (case
                	when ck_checkin.Status = 1 then 0
                	else ifnull(ck_checkin.ApproveStatus,1)
                end) as ApproveStatus,
                ifnull(ck_checkout.CheckOut,'')     as CheckOut,
                ifnull(ck_checkout.Code,'')         as CheckOutCode,
                (case
                	when ck_checkout.Status = 1 then 0
                	else ifnull(ck_checkout.ApproveStatus,1)
                end) as ApproveStatusCheckOut,
                ifnull(ck_break_start.CheckIn,'')   as BreakStart,
                ifnull(ck_break_end.CheckIn,'')     as BreakEnd,
                ifnull(ck_overtime_in.CheckIn,'')   as OvertimeIn,
                ifnull(ck_overtime_out.CheckIn,'')  as OvertimeOut,
                ifnull(ck_overtime_out.Code,'')     as OvertimeOutCode,
                ifnull(ck_break_start.Code,'')      as BreakCode,
                ifnull(ck_break_end.Code,'')        as BreakEndCode
            from (
                select Code,CheckIn,WorkDate,Status,ApproveStatus,EmployeeID from t_attendance where CompanyID = '$CompanyID' and EmployeeID in ($EmployeeID) and
                WorkDate >= '$StarDate' and WorkDate <= '$EndDate' and Type = '1' group by WorkDate order by DateAdd
            ) as ck_checkin
            left join (
                select WorkDate,max(CheckIn) as CheckOut,Status,ApproveStatus,max(Code) as Code from t_attendance where CompanyID = '$CompanyID' and EmployeeID in ($EmployeeID) and
                WorkDate >= '$StarDate' and WorkDate <= '$EndDate' and Type = '2' group by WorkDate
            ) as ck_checkout on ck_checkout.WorkDate = ck_checkin.WorkDate
            left join (
                select WorkDate,CheckIn,Code from t_attendance where CompanyID = '$CompanyID' and EmployeeID in ($EmployeeID) and
                WorkDate >= '$StarDate' and WorkDate <= '$EndDate' and Type = '3' group by WorkDate
            ) as ck_break_start on ck_break_start.WorkDate = ck_checkin.WorkDate
            left join (
                select WorkDate,CheckIn,Code from t_attendance where CompanyID = '$CompanyID' and EmployeeID in ($EmployeeID) and
                WorkDate >= '$StarDate' and WorkDate <= '$EndDate' and Type = '4' group by WorkDate
            ) as ck_break_end on ck_break_end.WorkDate = ck_checkin.WorkDate
            left join (
                select WorkDate,CheckIn from t_attendance where CompanyID = '$CompanyID' and EmployeeID in ($EmployeeID) and
                WorkDate >= '$StarDate' and WorkDate <= '$EndDate' and Type = '7' group by WorkDate
            ) as ck_overtime_in on ck_overtime_in.WorkDate = ck_checkin.WorkDate
            left join (
                select WorkDate,max(CheckIn) as CheckIn,max(Code) as Code from t_attendance where CompanyID = '$CompanyID' and EmployeeID in ($EmployeeID) and
                WorkDate >= '$StarDate' and WorkDate <= '$EndDate' and Type = '8' group by WorkDate
            ) as ck_overtime_out on ck_overtime_out.WorkDate = ck_checkin.WorkDate

            join mt_employee employee on ck_checkin.EmployeeID = employee.EmployeeID
            order by employee.Name,ck_checkin.WorkDate $ord

        ");

        return $query->result();
    }

    public function HistoryAttendaceVisitAndroid($CompanyID,$EmployeeID,$StarDate,$EndDate,$Type=""){
        $query = $this->db->query("
            select 
                t.Code,t.ParentCodeVisit,t.CheckIn,t.WorkDate,t.Type,t.EmployeeID,t.Latitude,t.Longitude,t.Note,t.VisitType,t.CompanyID,
                ifnull(t.Attachment,'[]') as Attachment,
                ifnull(t.Picture,'[]') as Picture,
                employee.Name as EmployeeName,employee.Nik
            from t_attendance t
            join mt_employee employee on t.EmployeeID = employee.EmployeeID
            where t.CompanyID = '$CompanyID' and t.EmployeeID in ($EmployeeID) and
                t.WorkDate >= '$StarDate' and t.WorkDate <= '$EndDate' and t.Type in (5,6)
        ");

        return $query->result();
    }

    public function GetParent($p1,$p2,$p3,$p4){
        $CompanyID      = $p1;
        $UserID         = $p2;
        $HakAksesType   = $p3;
        $Level          = $p4;
        $arrParent  = array();
        if(!in_array($HakAksesType, array(1,2,3)) && in_array($Level,array(1,2,3))):
            $arrTemp    = array();
            for ($i=$Level + 1; $i <= 4 ; $i++) { 
                $l = $Level + 2;
                if($i>=$l):
                    $id = array();
                    foreach ($arrTemp as $k => $v) {
                        $ID        = $this->GetParentDown($CompanyID,$v,$i);
                        $arrParent =  array_merge($arrParent,$ID);
                        $id        =  array_merge($id,$ID);
                    }
                    $arrTemp   = $id;
                else:
                    $ID = $this->GetParentDown($CompanyID,$UserID,$i);
                    $arrTemp   = $ID;
                    $arrParent =  array_merge($arrParent,$ID);
                endif;
            }
        endif;

        $arrData = array();
        foreach ($arrParent as $k => $v) {
            if(!in_array($v,$arrData) && $v):
                array_push($arrData, $v);
            endif;
        }

        return $arrData;
    }

    public function GetParent2($p1,$p2,$p3,$p4){
        $CompanyID      = $p1;
        $UserID         = $p2;
        $HakAksesType   = $p3;
        $Level          = $p4;
        $arrParent  = array();
        if(!in_array($HakAksesType, array(1,2,3)) && in_array($Level,array(1,2,3))):
            $d1 = $this->GetParentDown2($CompanyID,$UserID,$Level);
            if($d1):
                $d1_id   = implode(",", $d1);
                $d1_role = $this->db->query("
                    select mt.RoleID,mt.EmployeeID,dt.Level from mt_employee mt join ut_role dt on dt.RoleID = mt.RoleID where mt.CompanyID = '$CompanyID' and mt.EmployeeID in ($d1_id)")->result();
            endif;
            foreach ($d1 as $k => $v) {
                if(!in_array($v, $arrParent)):
                    $d1_key = array_search($v, array_column($d1_role, 'EmployeeID'));
                    if(strlen($d1_key)>0):
                        $d1_level       = $d1_role[$d1_key]->Level;

                        array_push($arrParent, $v);

                        $d2 = $this->GetParentDown2($CompanyID,$v,$d1_level);
                        if($d2):
                            $d2_id   = implode(",", $d2);
                            $d2_role = $this->db->query("
                                select mt.RoleID,mt.EmployeeID,dt.Level from mt_employee mt join ut_role dt on dt.RoleID = mt.RoleID where mt.CompanyID = '$CompanyID' and mt.EmployeeID in ($d2_id)")->result();
                        endif;
                        foreach ($d2 as $k2 => $v2) {
                            if(!in_array($v2, $arrParent)):
                                $d2_key = array_search($v2, array_column($d2_role, 'EmployeeID'));
                                if(strlen($d2_key)>0):
                                    $d2_level       = $d2_role[$d2_key]->Level;

                                    array_push($arrParent, $v2);

                                    $d3 = $this->GetParentDown2($CompanyID,$v2,$d2_level);
                                    if($d3):
                                        $d3_id   = implode(",", $d3);
                                        $d3_role = $this->db->query("
                                            select mt.RoleID,mt.EmployeeID,dt.Level from mt_employee mt join ut_role dt on dt.RoleID = mt.RoleID where mt.CompanyID = '$CompanyID' and mt.EmployeeID in ($d3_id)")->result();
                                    endif;
                                    foreach ($d3 as $k3 => $v3) {
                                        if(!in_array($v3, $arrParent)):
                                            $d3_key = array_search($v3, array_column($d3_role, 'EmployeeID'));
                                            if(strlen($d3_key)>0):
                                                $d3_level       = $d3_role[$d3_key]->Level;

                                                array_push($arrParent, $v3);

                                                $d4 = $this->GetParentDown2($CompanyID,$v3,$d3_level);
                                                if($d4):
                                                    $d4_id   = implode(",", $d4);
                                                    $d4_role = $this->db->query("
                                                        select mt.RoleID,mt.EmployeeID,dt.Level from mt_employee mt join ut_role dt on dt.RoleID = mt.RoleID where mt.CompanyID = '$CompanyID' and mt.EmployeeID in ($d4_id)")->result();
                                                endif;

                                                foreach ($d4 as $k4 => $v4) {
                                                    if(!in_array($v4, $arrParent)):
                                                        $d4_key = array_search($v4, array_column($d4_role, 'EmployeeID'));
                                                        if(strlen($d4_key)>0):
                                                            $d4_level       = $d4_role[$d4_key]->Level;

                                                            array_push($arrParent, $v4);
                                                        endif;
                                                    endif;
                                                }

                                            endif;
                                        endif;
                                    }

                                endif;
                            endif;
                        }

                    endif;
                endif;
            }
        endif;

        $arrData = array();
        foreach ($arrParent as $k => $v) {
            if(!in_array($v,$arrData) && $v):
                array_push($arrData, $v);
            endif;
        }

        return $arrData;
    }

    private function GetParentDown($p1,$p2,$p3){
        $query = $this->db->query("
            select 
                GROUP_CONCAT(mt.EmployeeID) as ID
            from mt_employee mt
            join ut_role dt on mt.RoleID = dt.RoleID
            where mt.CompanyID = '$p1' and mt.ParentID = '$p2' and dt.Level = '$p3'
        ")->row();

        $ID = array();
        if($query):
            $ID = explode(",", $query->ID);
        endif;
        return $ID;
    }

    private function GetParentDown2($p1,$p2,$p3){
        $query = $this->db->query("
            select 
                GROUP_CONCAT(mt.EmployeeID) as ID
            from mt_employee mt
            join ut_role dt on mt.RoleID = dt.RoleID
            where mt.CompanyID = '$p1' and mt.ParentID = '$p2' and dt.Level >= '$p3'
        ")->row();

        $ID = array();
        if($query):
            if($query->ID):
                $ID = explode(",", $query->ID);
            endif;
        endif;
        return $ID;
    }

    public function branch($p1,$p2=""){
        $CompanyID = $this->session->CompanyID;
        $this->db->select("mt_branch.*, company.Name as CompanyName");
        $this->db->from("mt_branch");
        $this->db->join("ut_user company","mt_branch.CompanyID = company.UserID");
        if($p1 == "detail_id"):
            $p1 = "detail";
            $this->db->where("BranchID", $p2);
        elseif($p1 == 'company'):
            $this->db->where("mt_branch.CompanyID", $p2);
        endif;
        $query = $this->db->get();

        if($p1 == "detail"):
            return $query->row();
        else:
            return $query->result();
        endif;

    }

    // public function attachment_list($ID="",$page=""){

    //     $table = "ut_attachment";
    //     $this->db->select("
    //         $table.AttachmentID as attachID,
    //         $table.ID,
    //         $table.Name,
    //         $table.Image,
    //     ");

    //     if($page == "array"):
    //         $this->db->where_in("$table.ID", $ID);
    //     endif;
    //     $this->db->where("$table.ID", $ID);
    //     $this->db->from($table);
    //     $query = $this->db->get();

    //     return $query->result();
    // }

    public function attachment_list($Type,$ID="",$page=""){

        $table = "ut_attachment";
        $this->db->select("
            $table.AttachmentID as attachID,
            $table.CompanyID,
            $table.ID,
            $table.Name,
            $table.Image,
            $table.Url,
            $table.Type,
        ");

        if($page == "array"):
            $this->db->where_in("Type",$Type);
        else:
            $this->db->where("Type", $Type);
            $this->db->where("ID", $ID);                                                                                                                                                 
        endif;
        $this->db->from($table);
        $query = $this->db->get();

        return $query->result();
    }

    public function reset_data_master(){

        $query  = $this->db->query("TRUNCATE TABLE biodata");
        $query  = $this->db->query("TRUNCATE TABLE mt_sdm");
        $query  = $this->db->query("TRUNCATE TABLE mt_konstruksi");
        $query  = $this->db->query("TRUNCATE TABLE mt_konstruksi_det");
        $query  = $this->db->query("TRUNCATE TABLE mt_non_konstruksi");
        $query  = $this->db->query("TRUNCATE TABLE mt_non_konstruksi_det");
        $query  = $this->db->query("TRUNCATE TABLE mt_daftar_riwayat");
        $query  = $this->db->query("TRUNCATE TABLE mt_posisi_uraian");
        $query  = $this->db->query("TRUNCATE TABLE proyek");
        $query  = $this->db->query("TRUNCATE TABLE ut_attachment");

        return $query;
    }

    
}