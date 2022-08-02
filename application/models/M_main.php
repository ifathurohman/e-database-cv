<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class M_main extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->lang->load('bahasa', "english");
    }

    public function echoJson($data){
        header('Content-Type: application/json');
        echo json_encode($data,JSON_PRETTY_PRINT);
    }

    public function create_password($password){
        $password = "mdan".$password."119";
        $password = sha1($password);

        return $password;
    }


    // $tabel = nama table di database
    // $kolom = kolom di table
    // $lebar = lebar auto number
    // $awalan = kode unik pertama sebelum auto number
    // tambahan = untuk mereset auto number per bulan
    // $company = CompanyID
    public function autoNumber($tabel, $kolom, $lebar=0, $awalan, $tambahan = "",$company="") {
        $CompanyID = $this->session->CompanyID;
        $this->db->select("$kolom");
    
        if($tambahan == "month_reset"):
            $this->db->where("DATE_FORMAT(DateAdd,'%Y-%m')",date("Y-m"));
        endif;
    
        $pagenya = $this->session->pagenya;
        if($pagenya == "t_attendance"):
            if($this->session->tipenya == 1):
                $this->db->where("Type", 1);
            else:
                $this->db->where("Type != ", 1);
            endif;
        endif;
    
        $this->db->order_by($kolom, "desc");
        $this->db->limit(1);
        $this->db->from($tabel);
        $query = $this->db->get();
        $rslt = $query->result_array();
        $total_rec = $query->num_rows();
        if ($total_rec == 0) {
            $nomor = 1;
        } else {
            $nomor = intval(substr($rslt[0][$kolom],strlen($awalan))) + 1;
        }
    
        if($lebar > 0) {
            $angka = $awalan.str_pad($nomor,$lebar,"0",STR_PAD_LEFT);
        } else {
            $angka = $awalan.$nomor;
        }
    
        $data = array("pagenya" => "","tipenya" => "");
        $this->session->set_userdata($data);
        return $angka;
    
    }

    public function bulan_romawi($month=""){
        if($month == ""):
            $month = date("m");
        endif;
        $month = (int) $month;
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($month > 0) {
            foreach ($map as $roman => $int) {
                if($month >= $int) {
                    $month -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    #20190915 MW
    #login
    public function login(){
        $user = $this->validation->login();
        if($user->LoginType == 'not_user'):
            $role = $this->api->role('detail_id', $user->RoleID);

            $Image = base_url('img/image_default.png');
            if($user->Image):
                $Image = base_url($user->Image);
            endif;

            $data = array(
                'login'             => TRUE,
                'UserID'            => $user->UserID,
                'Email'             => $user->Email,
                'Name'              => $user->Name,
                'NameLast'          => '',
                'RoleID'            => $user->RoleID,
                'Level'             => $role->Level,
                'HakAkses'          => $role->Name,
                'HakAksesType'      => $role->Type,
                'HakAksesTypeTxt'   => $this->main->label_role_type($role->Type),
                'Image'             => $Image,
                'Phone'             => $user->Phone,
                'Status'            => $user->Status,
                'Departement'       => '',
                'CompanyID'         => $user->UserID,
                'CompanyName'       => $user->Name,
                'CompanyImage'      => $Image,
                'CompanyPhone'      => $user->Phone,
                'CompanyIso'        => $user->CountryIso,
                'CompanyEmail'      => $user->Email,
                'CompanyLocation'   => $user->LocationName,
                'CompanyLatitude'   => $user->Latitude,
                'CompanyLongitude'  => $user->Longitude,
                'CompanyRadius'     => $user->Radius,
                'CompanyAddress'    => $user->Address,
                'CompanyJoinDate'   => $user->DateJoin,
                'CompanyUserName'   => $user->Username,
                'CompanyStartWorkDate'  => $user->StartWorkDate,
                'CompanyTheme'      => $user->Theme,
                'ParentList'        => array(),
            );
            $this->session->set_userdata($data);
        endif;
        $this->inser_log(1,1,'login');//$LogType,$Type,$Page,$Content=""
        $output = array(
            "status"    => TRUE,
            "message"   => $this->lang->line('lb_success'),
            "url"       => site_url('dashboard'),
        );

        $this->main->echoJson($output);
    }

    public function register(){
        $data = $this->validation->register();

        $ID             = $this->input->post('ID');
        $Name           = $this->input->post('full_name');
        $phone_number   = $this->input->post('phone_number');
        $Email          = $this->input->post('email');
        $password       = $this->input->post('password');

        $token          = $this->main->create_password($Email.time());
        $data_token     = array("Token" => $token);

        $data_detail = array(
            'Name'          => $Name,
            'Username'      => $Name,
            'Phone'         => $phone_number,
            'Email'         => $Email,
            'RoleID'        => 15,
            'Password'      => $this->main->create_password($password),
            'Token'         => $token,
        );
        
        $ID = $this->general_save("ut_user", $data_detail);
        $this->send_email("register",$Email);

        $output = array(
            "status"    => TRUE,
            "message"   => $this->lang->line('lb_success'),
            "url"       => site_url('verification'),
        );

        $this->main->echoJson($output);
    }

    #20191225 MW
    #forgot password
    public function forgot_password(){
        $data = $this->validation->forgot_password();

        $this->send_email("forgot_password",$data);

        $output = array(
            "status"    => TRUE,
            "message"   => $this->lang->line('lb_success'),
            "url"       => site_url('users'),
        );

        $this->main->echoJson($output);
    }
    public function forgot_password_save(){
        $data = $this->validation->forgot_password_save();

        $Password = $this->input->post('Password');
        $Password = $this->main->create_password($Password);

        $data_user = array(
            "Password"  => $Password,
            "Token"     => null,
        );

        if($data->Page == 'user'):
            $this->main->general_update('ut_user',$data_user,array('UserID' => $data->UserID));
        else:
            $this->main->general_update('mt_employee',$data_user,array('EmployeeID' => $data->UserID));
        endif;

        $output = array(
            "status"    => TRUE,
            "message"   => $this->lang->line('lb_success_reset_pwd'),
            "url"       => site_url(),
        );
        $this->main->echoJson($output);
    }

    public function verification_save(){

        $data = $this->validation->verification_save();

        $data_user = array(
            "Status"    => 1,
            "Token"     => null,
        );

        if($data->Page == 'verification'):
            $this->main->general_update('ut_user',$data_user,array('UserID' => $data->UserID));
        endif;

        $output = array(
            "status"    => TRUE,
            "message"   => 'Akun Anda Telah Aktif',
            "url"       => site_url(),
        );
        $this->main->echoJson($output);
    }
    
    public function user_detail($code)
    {
        $this->db->select("
            UserID,
            CompanyID,
            Name,
            Email,
            Username,
            Password,
            CountryIso,
            Phone,
            Image,
            RoleID,
            Status,
            Token,
        ");
        $this->db->where("UserID",$code);
        $this->db->or_where("Email",$code);
        $this->db->or_where("Token",$code);
        $query = $this->db->get("ut_user");
        return $query->row();
    }

    #20190917 MW
    public function logout(){
        // $this->inser_log(1,5,'logout');//$LogType,$Type,$Page,$Content=""
        session_destroy();
        redirect('login');
    }

    #20190915 MW
    #check session
    public function check_session($p1="",$p2="",$p3=""){
        if($p1 == "out"):
            $p1 = true;
            $message = '';
            $arrP2 = array('insert','update','delete','approve','view');
            if(!$this->session->login):
                $response = array(
                    "status"    => false,
                    "message"   => "session expired",
                    "session"   => true,
                    "url"       => site_url('login'),
                );

                $this->echoJson($response);
                exit();
            elseif($p2 == "insert" && !$p3):
                $p1      = false;
                $message = $this->lang->line('lb_access_insert');
            elseif($p2 == "update" && !$p3):
                $p1      = false;
                $message = $this->lang->line('lb_access_update');
            elseif($p2 == "delete" && !$p3):
                $p1      = false;
                $message = $this->lang->line('lb_access_delete');
            elseif($p2 == "approve" && !$p3):
                $p1      = false;
                $message = $this->lang->line('lb_access_approve');
            elseif($p2 == "view" && !$p3):
                $p1      = false;
                $message = $this->lang->line('lb_access_view');
            elseif($p2 && !in_array($p2,$arrP2)):
                $p1      = false;
                $message = $this->lang->line('lb_access_data');
            endif;

            if(!$p1):
                $response = array(
                    "status"    => false,
                    "message"   => $message,
                    "session"   => false,
                    "url"       => site_url('login'),
                );

                $this->echoJson($response);
                exit();
            endif;
        else:
            if(!$this->session->login):
                redirect();
            endif;
        endif;
    }

    #20190916 MW
    #button
    public function button($p1,$p2="",$p3="",$p4="",$p5=""){
        $btn = '';
        if($p1 == "action"):
            $btn = '<div class="row">
                        <div class="col-md-12">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-danger" onclick="open_form('."'close'".')"><i class="fa fa-close"></i> '.$this->lang->line('lb_cancel').'</button>
                                <button type="button" class="btn btn-primary btn-save v-Save" onclick="save('."'save'".')"><i class="fa fa-save"></i> '.$this->lang->line('lb_save').'</button>
                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split v-Save" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu animated flipInY" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 40px; left: 0px; will-change: transform;">
                                    <a class="dropdown-item" href="javascript:;" onclick="save('."'save_new'".')">'.$this->lang->line('lb_save_new').'</a>
                                </div>
                            </div>
                        </div>
                    </div>';
        elseif($p1 == 'action2'):
            $btn = '<div class="row">
                        <div class="col-md-12">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-primary btn-save" onclick="save('."'save'".')"><i class="fa fa-save"></i> '.$this->lang->line('lb_save').'</button>
                            </div>
                        </div>
                    </div>';
        elseif($p1 == "action_import"):
            $btn = '<div class="row">
                        <div class="col-md-12">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-danger" onclick="open_form('."'close'".')"><i class="fa fa-close"></i> '.$this->lang->line('lb_cancel').'</button>
                                <button type="button" class="btn btn-primary btn-save" onclick="import_data('."'import'".')"><i class="fa fa-save"></i> '.$this->lang->line('lb_import').'</button>
                            </div>
                        </div>
                    </div>';
        elseif($p1 == "action_import2"):
            $btn = '<div class="row">
                        <div class="col-md-12">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-danger" onclick="open_form('."'close'".')"><i class="fa fa-close"></i> '.$this->lang->line('lb_cancel').'</button>
                                <button type="button" class="btn btn-primary btn-save" onclick="import_data('."'save'".')"><i class="fa fa-save"></i> '.$this->lang->line('lb_save').'</button>
                            </div>
                        </div>
                    </div>';
        elseif($p1 == "add_new"):
            $btn = '<button type="button" onclick="open_form()" class="btn btn-add btn-add d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> '.$this->lang->line('lb_add_new').'</button>';
        elseif($p1 == "close"):
            $btn = '<button type="button" class="btn btn-danger btn-close" data-dismiss="modal"><i class="fa fa-close"></i> '.$this->lang->line('lb_close').'</button>';
        elseif($p1 == "action_list"):
            $edit = ''; $nonactive = ''; $active = ''; $approve = ''; $rejected = ''; $view = ''; $reset_device = '';
            if(in_array('edit',$p3)):
                $edit = '<a class="dropdown-item action-edit" onclick="action_edit()" href="javascript:;"><img src="https://dev.edatabasecv.com/img/icon/Edit_Square.png" style="margin-right: 10px;width:15px;margin-top:-2px;">'.$this->lang->line('lb_edit_data').'</a>';
            endif;
            if(in_array('edit2',$p3)):
                $edit = '<a class="dropdown-item action-edit" onclick="action_edit2()" href="javascript:;"><img src="https://dev.edatabasecv.com/img/icon/Edit_Square.png" style="margin-right: 10px;width:15px;margin-top:-2px;">'.$this->lang->line('lb_edit_data').'</a>';
            endif;
            if(in_array('nonactive', $p3)):
                $nonactive = '<a class="dropdown-item action-delete" onclick="action_delete()" href="javascript:;">'.$this->lang->line('lb_nonactive').'</a>';
            endif;
            if(in_array('active', $p3)):
                $active = '<a class="dropdown-item action-delete" onclick="action_delete()" href="javascript:;">'.$this->lang->line('lb_active').'</a>';
            endif;
            if(in_array('approve',$p3)):
                $approve = '<a class="dropdown-item action-approve" onclick="action_approve()" href="javascript:;">'.$this->lang->line('lb_approve').'</a>';
            endif;

            if(in_array('rejected', $p3)):
                $rejected = '<a class="dropdown-item action-rejected" onclick="action_rejected()" href="javascript:;">'.$this->lang->line('lb_reject').'</a>';
            endif;

            if(in_array('delete', $p3)):
                $active = '<a class="dropdown-item action-delete" onclick="action_delete()" href="javascript:;">'.$this->lang->line('lb_delete_data').'</a>';
            endif;

            if(in_array('view', $p3)):
                $view = '<a class="dropdown-item action-view" onclick="action_view()" href="javascript:void(0)"><img src="https://dev.edatabasecv.com/img/icon/Show.png" style="margin-right: 10px;">'.$this->lang->line('lb_view').'</a>';
            endif;

            if(in_array('view2', $p3)):
                $view = '<a class="dropdown-item action-view" onclick="action_view2()" href="javascript:void(0)"><img src="https://dev.edatabasecv.com/img/icon/Show.png" style="margin-right: 10px;">'.$this->lang->line('lb_view').'</a>';
            endif;

            if(in_array('reset_device', $p3)):
                $reset_device = '<a class="dropdown-item action-view" onclick="action_reset_device()" href="javascript:;">'.$this->lang->line('lb_device_reset').'</a>';
            endif;

            $btn = '<div class="btn-group" role="group">
                <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></div>
                <div class="dropdown-menu action_list" aria-labelledby="btnGroupVerticalDrop1" x-placement="top-start">
                    '.$view.$edit.$nonactive.$active.$approve.$rejected.$reset_device.'
                </div>
            </div>';

        elseif($p1 == "filter"):
            $search = ''; $import = ''; $export = '';
            $pdf = ''; $excel = '';
            if(in_array('search', $p2)):
                $search = '<button type="button" class="btn btn-primary" onclick="filter_table()">
                <i class="fa fa-search"></i> '.$this->lang->line('lb_search').'</button>';
            endif;
            if(in_array('export', $p2)):
                $export = '<button type="button" class="btn btn-info" onclick="export_data()">
                <i class="fa fa-files-o"></i> '.$this->lang->line('lb_export').'</button>';
            endif;
            if(in_array('import', $p2)):
                $import = '<button type="button" class="btn btn-info" onclick="open_form('."'import'".')">
                <i class="fa fa-file"></i> '.$this->lang->line('lb_import').'</button>';
            endif;
            if(in_array('pdf',$p2)):
                $pdf = '<button type="button" class="btn btn-info dropdown-toggle btn-pdf" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:0px">
                        '.$this->lang->line('lb_export_pdf').'
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu animated flipInY" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -2px, 0px); top: 40px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="javascript:;" onclick="export_data('."'pdf'".')">'.$this->lang->line('lb_potrait').'</a>
                        <a class="dropdown-item" href="javascript:;" onclick="export_data('."'pdf','lanscape'".')">'.$this->lang->line('lb_lanscape').'</a>
                    </div>';
            endif;
            if(in_array('excel',$p2)):
                $excel = '<button type="button" class="btn btn-info btn-excell" onclick="export_data('."'excel'".')">
                <i class="fa fa-files-o"></i> '.$this->lang->line('lb_export_excel').'</button>';
            endif;
            $btn = '<div class="btn-group" role="group" aria-label="Basic example">
                    '.$export.$import.$pdf.$excel.$search.'
                </div>';

        endif;

        return $btn;

    }

    #general_save

    public function general_save($table,$data){
        $this->db->set("UserAdd",$this->session->Name);
        $this->db->set("DateAdd",date("Y-m-d H:i:s"));
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    public function general_save_android($table,$data){
        $this->db->set("UserAdd","Android");
        $this->db->set("DateAdd",date("Y-m-d H:i:s"));
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    #general update
    public function general_update($table,$data,$where){
        $this->db->set("UserCh",$this->session->Name);
        $this->db->set("DateCh",date("Y-m-d H:i:s"));
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }
    public function general_update_android($table,$data,$where){
        $this->db->set("UserCh","Android");
        $this->db->set("DateCh",date("Y-m-d H:i:s"));
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    #label
    public function label_active($p1,$p2=""){
        $label = '';
        if($p1 == 1):
            $label = $this->lang->line('lb_active');
        elseif($p1 == 0):
            $label = $this->lang->line('lb_nonactive');
        endif;
        return $label;
    }


    public function label_status_ap($p1){
        $label = '';
        if($p1 == 1):
            $label = $this->lang->line('lb_submitted');
        elseif($p1 == 2):
            $label = $this->lang->line('lb_approved');
        elseif($p1 == 3):
            $label = $this->lang->line('lb_rejected');
        endif;

        return $label;
    }

    public function label_role_type($p1){
        $label = '';
        if($p1 == 1):
            $label = "Developer";
        elseif($p1 == 2):
            $label = "Super Admin";
        elseif($p1 == 3):
            $label = "Company";
        endif;
        return $label;
    }

    public function label_background($p1){
        $arrSuccess = array('Active');
        $arrDanger  = array('Nonactive');
        $p2 = '';
        if(in_array($p1,$arrSuccess)):
            $p2 = ' txt-success ';
        elseif(in_array($p1, $arrDanger)):
            $p2 = ' txt-danger ';
        endif;
        return '<span class="'.$p2.'">'.$p1.'</span>';

    }

    public function label_pegawai_pt($p1,$p2=""){
        $label = '';
        if($p1 == 'Terkontrak'):
            $label = $this->lang->line('lb_terkontrak');
        elseif($p1 == 'Tender'):
            $label = $this->lang->line('lb_tender');
        elseif($p1 == 'Tersedia'):
            $label = $this->lang->line('lb_tersedia');
        endif;
        return $label;
    }

    public function label_pegawai_non_pt($p1,$p2=""){
        $label = '';
        if($p1 == 'Terkontrak'):
            $label = $this->lang->line('lb_terkontrak');
        elseif($p1 == 'Tersedia'):
            $label = $this->lang->line('lb_tersedia');
        endif;
        return $label;
    }

    public function label_background_pegawai_pt($p1){
        $terkontrak     = array($this->lang->line('lb_terkontrak'));
        $tender         = array($this->lang->line('lb_tender'));
        $tersedia       = array($this->lang->line('lb_tersedia'));
        $p2     = '';
        if(in_array($p1,$terkontrak)):
            $p2 = ' label-terkontrak ';
            return '<span class="'.$p2.'">'.$p1.'<i class="fa fa-exclamation-triangle" style="margin-left:10px;"></i></span>';
        elseif(in_array($p1,$tersedia)):
            $p2 = ' label-tersedia ';
            return '<span class="'.$p2.'">'.$p1.'</span>';
        elseif(in_array($p1,$tender)):
            $p2 = ' label-tender ';
            return '<span class="'.$p2.'">'.$p1.'</span>';
        endif;

    }
    public function label_background_pegawai_non_pt($p1){
        $terkontrak     = array($this->lang->line('lb_terkontrak'));
        $tersedia       = array($this->lang->line('lb_tersedia'));
        $p2     = '';
        if(in_array($p1,$terkontrak)):
            $p2 = ' label-terkontrak ';
            return '<span class="'.$p2.'">'.$p1.'<i class="fa fa-exclamation-triangle" style="margin-left:10px;"></i></span>';
        elseif(in_array($p1,$tersedia)):
            $p2 = ' label-tersedia ';
            return '<span class="'.$p2.'">'.$p1.'</span>';
        endif;
    }

    public function label_approve($p1){
        $arrApprove     = array($this->lang->line('lb_approved'));
        $arrSubmitted   = array($this->lang->line('lb_submitted'));
        $arrRejected    = array($this->lang->line('lb_rejected'));
        $p2 = '';
        if(in_array($p1,$arrApprove)):
            $p2 = ' txt-success ';
        elseif(in_array($p1,$arrRejected)):
            $p2 = ' txt-danger ';
        elseif(in_array($p1,$arrSubmitted)):
            $p2 = ' txt-info ';
        endif;

        return '<span class="'.$p2.'">'.$p1.'</span>';

    }

    public function label_gender($p1){
        $label = '';
        if($p1 == 0):
            $label = $this->lang->line('lb_male');
        else:
            $label = $this->lang->line('lb_female');
        endif;
        return $label;
    }


    public function label_default_imei($p1){
        $label = 'No';
        if($p1 == 1):
            $label = "Yes";
        endif;
        return $label;
    }

    public function label_log($p1,$p2="",$p3=""){
        $label = '';
        if($p1 == 1):
            $label = "Telah masuk ke aplikasi";
        elseif($p1 == 5):
            $label = "Telah keluar dari aplikasi";
        elseif($p1 == 2):
            if($p2 == 'company'):
                $Name  = $this->api->get_one_row("ut_user","Name", array("UserID" => $p3))->Name;
                $label = 'Telah menambahkan data company dengan nama '.$Name;
            elseif($p2 == 'role'):
                $Name  = $this->api->get_one_row("ut_role","Name", array("RoleID" => $p3));
                if($Name): $Name = $Name->Name;
                else : $Name = ""; endif;
                $label = 'Telah menambahkan data role dengan nama '.$Name;
            elseif($p2 == 'leave'):
                $Name  = $this->api->get_one_row("mt_leave","Name", array("LeaveID" => $p3))->Name;
                $label = 'Telah menambahkan data leave dengan nama '.$Name;
            elseif($p2 == 'user_company'):
                $Name  = $this->api->get_one_row("mt_employee","Name", array("EmployeeID" => $p3))->Name;
                $label = 'Telah menambahkan data user dengan nama '.$Name;
            elseif($p2 == 'work_pattern'):
                $Name  = $this->api->get_one_row("mt_workpattern","Name", array("WorkPatternID" => $p3))->Name;
                $label = 'Telah menambahkan data work pattern dengan nama '.$Name;
            elseif($p2 == 't_leave'):
                $label = 'Telah menambahkan data transaksi leave dengan no transaksi '.$p3;
            elseif($p2 == 't_overtimes'):
                $label = 'Telah menambahkan data transaksi overtime dengan no transaksi '.$p3;
            elseif($p2 == 'visit'):
                $Name  = $this->api->get_one_row("mt_visit","Name", array("VisitID" => $p3));
                if($Name): $Name = $Name->Name; else: $Name = '-'; endif;
                $label = 'Telah menambahkan data visit type dengan nama '.$Name;
            elseif($p2 == 'branch'):
                $Name  = $this->api->get_one_row("mt_branch","Name", array("BranchID" => $p3))->Name;
                $label = 'Telah menambahkan data branch dengan nama '.$Name;
            endif;

        elseif($p1 == 3):
            if($p2 == 'company'):
                $Name  = $this->api->get_one_row("ut_user","Name", array("UserID" => $p3))->Name;
                $label = 'Telah mengubah data company dengan nama '.$Name;
            elseif($p2 == 'role'):
                $Name  = $this->api->get_one_row("ut_role","Name", array("RoleID" => $p3))->Name;
                $label = 'Telah mengubah data role dengan nama '.$Name;
            elseif($p2 == 'leave'):
                $Name  = $this->api->get_one_row("mt_leave","Name", array("LeaveID" => $p3))->Name;
                $label = 'Telah mengubah data leave dengan nama '.$Name;
            elseif($p2 == 'user_company'):
                $Name  = $this->api->get_one_row("mt_employee","Name", array("EmployeeID" => $p3))->Name;
                $label = 'Telah mengubah data user dengan nama '.$Name;
            elseif($p2 == 'work_pattern'):
                $Name  = $this->api->get_one_row("mt_workpattern","Name", array("WorkPatternID" => $p3))->Name;
                $label = 'Telah mengubah data work pattern dengan nama '.$Name;
            elseif($p2 == 'visit'):
                $Name  = $this->api->get_one_row("mt_visit","Name", array("VisitID" => $p3));
                if($Name): $Name = $Name->Name; else: $Name = '-'; endif;
                $label = 'Telah mengubah data visit type dengan nama '.$Name;
            elseif($p2 == 'branch'):
                $Name  = $this->api->get_one_row("mt_branch","Name", array("BranchID" => $p3))->Name;
                $label = 'Telah mengubah data branch dengan nama '.$Name;
            elseif($p2 == 't_leave'):
                $label = 'Telah mengubah data transaksi leave dengan no transaksi '.$p3;
            elseif($p2 == 't_overtimes'):
                $label = 'Telah mengubah data transaksi overtime dengan no transaksi '.$p3;
            endif;
        elseif($p1 == 4):
            if($p2 == 't_leave'):
                $label = 'Telah menghapus data transaksi leave dengan no transaksi '.$p3;
            elseif($p2 == 't_overtimes'):
                $label = 'Telah menghapus data transaksi overtime dengan no transaksi '.$p3;
            elseif($p2 == 'visit'):
                $Name  = $this->api->get_one_row("mt_visit","Name", array("VisitID" => $p3));
                if($Name): $Name = $Name->Name; else: $Name = '-'; endif;
                $label = 'Telah menghapus data visit type dengan nama '.$Name;
            endif;
        elseif($p1 == 6):
            if($p2 == 'company'):
                $Name  = $this->api->get_one_row("ut_user","Name", array("UserID" => $p3))->Name;
                $label = 'Telah mengaktifkan data company dengan nama '.$Name;
            elseif($p2 == 'role'):
                $Name  = $this->api->get_one_row("ut_role","Name", array("RoleID" => $p3))->Name;
                $label = 'Telah mengaktifkan data role dengan nama '.$Name;
            elseif($p2 == 'leave'):
                $Name  = $this->api->get_one_row("mt_leave","Name", array("LeaveID" => $p3))->Name;
                $label = 'Telah mengaktifkan data leave dengan nama '.$Name;
            elseif($p2 == 'user_company'):
                $Name  = $this->api->get_one_row("mt_employee","Name", array("EmployeeID" => $p3))->Name;
                $label = 'Telah mengaktifkan data user dengan nama '.$Name;
            elseif($p2 == 'work_pattern'):
                $Name  = $this->api->get_one_row("mt_workpattern","Name", array("WorkPatternID" => $p3))->Name;
                $label = 'Telah mengaktifkan data work pattern dengan nama '.$Name;
            elseif($p2 == 'branch'):
                $Name  = $this->api->get_one_row("mt_branch","Name", array("BranchID" => $p3))->Name;
                $label = 'Telah mengaktifkan data branch dengan nama '.$Name;
            endif;
        elseif($p1 == 7):
            if($p2 == 'company'):
                $Name  = $this->api->get_one_row("ut_user","Name", array("UserID" => $p3))->Name;
                $label = 'Telah menonaktifkan data company dengan nama '.$Name;
            elseif($p2 == 'role'):
                $Name  = $this->api->get_one_row("ut_role","Name", array("RoleID" => $p3))->Name;
                $label = 'Telah menonaktifkan data role dengan nama '.$Name;
            elseif($p2 == 'leave'):
                $Name  = $this->api->get_one_row("mt_leave","Name", array("LeaveID" => $p3))->Name;
                $label = 'Telah menonaktifkan data leave dengan nama '.$Name;
            elseif($p2 == 'user_company'):
                $Name  = $this->api->get_one_row("mt_employee","Name", array("EmployeeID" => $p3))->Name;
                $label = 'Telah menonaktifkan data user dengan nama '.$Name;
            elseif($p2 == 'work_pattern'):
                $Name  = $this->api->get_one_row("mt_workpattern","Name", array("WorkPatternID" => $p3))->Name;
                $label = 'Telah menonaktifkan data work pattern dengan nama '.$Name;
            elseif($p2 == 'branch'):
                $Name  = $this->api->get_one_row("mt_branch","Name", array("BranchID" => $p3))->Name;
                $label = 'Telah menonaktifkan data branch dengan nama '.$Name;
            endif;
        elseif($p1 == 8):
            if($p2 == 't_leave'):
                $label = 'Telah menyetujui data transaksi leave dengan no transaksi '.$p3;
            elseif($p2 == 't_overtimes'):
                $label = 'Telah menyetujui data transaksi overtime dengan no transaksi '.$p3;
            elseif($p2 == 't_attendance'):
                $label = 'Telah menyetujui data transaksi attendace dengan no transaksi '.$p3;
            endif;
        elseif($p1 == 9):
            if($p2 == 't_leave'):
                $label = 'Telah menolak data transaksi leave dengan no transaksi '.$p3;
            elseif($p2 == 't_overtimes'):
                $label = 'Telah menolak data transaksi overtime dengan no transaksi '.$p3;
            elseif($p2 == 't_attendance'):
                $label = 'Telah menolak data transaksi attendace dengan no transaksi '.$p3;
            endif;
        elseif($p1 == 10):
            if($p2 == 't_leave'):
                $label = 'Telah menambah lampiran data transaksi leave dengan no transaksi '.$p3;
            elseif($p2 == 't_overtimes'):
                $label = 'Telah menambah lampiran data transaksi overtime dengan no transaksi '.$p3;
            elseif($p2 == 't_attendance'):
                $label = 'Telah menambah data transaksi attendace dengan no transaksi '.$p3;
            endif;
        elseif($p1 == 11):
            if($p2 == 't_leave'):
                $p3 = explode("=", $p3)[0];
                $label = 'Telah menghapus lampiran data transaksi leave dengan no transaksi '.$p3;
            elseif($p2 == 't_overtimes'):
                $p3 = explode("=", $p3)[0];
                $label = 'Telah menghapus lampiran data transaksi overtime dengan no transaksi '.$p3;
            elseif($p2 == 't_attendance'):
                $label = 'Telah menghapus data transaksi attendace dengan no transaksi '.$p3;
            endif;
        elseif($p1 == 12):
            if($p2 == "t_attendance_page"):
                $p3 = $this->label_attendance($p3);
                $label = "Telah membuka menu ".$p3;
            endif;
        endif;
        return $label;
    }

    public function label_log2($p1){
        $label = "";
        if($p1 == 'login'): $label = ucwords($this->lang->line('lb_login'));
        elseif($p1 == 'logout'): $label = ucwords($this->lang->line('lb_logout'));
        elseif($p1 == 'company'): $label = ucwords($this->lang->line('lb_company'));
        elseif($p1 == 'role'): $label = ucwords($this->lang->line('lb_role'));
        elseif($p1 == 'leave'): $label = ucwords($this->lang->line('lb_leave'));
        elseif($p1 == 'overtime'): $label = ucwords($this->lang->line('lb_overtimes'));
        elseif($p1 == 'user_company'): $label = ucwords($this->lang->line('lb_user'));
        elseif($p1 == 't_leave'): $label = ucwords($this->lang->line('lb_transaction')." ".$this->lang->line('lb_leave'));
        elseif($p1 == 't_overtimes'): $label = ucwords($this->lang->line('lb_transaction')." ".$this->lang->line('lb_overtimes'));
        elseif($p1 == 'work_pattern'): $label = ucwords($this->lang->line('lb_work_pattern'));
        elseif($p1 == 't_attendance'): $label = ucwords($this->lang->line('lb_attendance'));
        elseif($p1 == 'page_setting'): $label = ucwords($this->lang->line('lb_page_setting'));
        elseif($p1 == 'visit'): $label = ucwords($this->lang->line('lb_visit_type'));
        elseif($p1 == 'branch'): $label = ucwords($this->lang->line('lb_branch'));
        elseif($p1 == 't_attendance_page'): $label = ucwords($this->lang->line('lb_device'));
        endif;

        return $label;
    }

    public function label_attendance($p1){
        $value = '';
        if($p1 == 1): $value = $this->lang->line('lb_check_in');
        elseif($p1 == 2): $value = $this->lang->line('lb_check_out');
        elseif($p1 == 3): $value = $this->lang->line('lb_break_start');
        elseif($p1 == 4): $value = $this->lang->line('lb_break_end');
        elseif($p1 == 5): $value = $this->lang->line('lb_visit_in');
        elseif($p1 == 6): $value = $this->lang->line('lb_visit_out');
        elseif($p1 == 7): $value = $this->lang->line('lb_overtime_in');
        elseif($p1 == 8): $value = $this->lang->line('lb_overtime_out');
        endif;

        return $value;
    }

    #example loop post
    private function loop_post(){
        $post = $this->input->post();
        foreach ($post as $k => $v) {
        }
    }


    #sidebar parent menu
    public function sidebar_menu_parent($p1){
        $menu_list = $this->api->menu('level2_backend', $p1);
        $data = '';
        if(count($menu_list)>0):
            $item = '<ul aria-expanded="false" class="collapse">';
            foreach ($menu_list as $k => $v):
                $Icon = '';
                if($v->Icon): $Icon = '<i class="'.$v->Icon.'"></i> '; endif;
                $item .= '<li><a href="'.site_url($v->Url).'">'.$Icon.$v->Name.' </a></li>';
            endforeach;
            $item .= '</ul>';
            $data = $item;
        endif;
        return $data;
    }

    #serverSide
    #serverSide
    public function serverSide(){
        $page = $this->input->post('page');
        $p1   = $this->input->post('p1');

        $column = array();
        $order  = array();
        $total  = 0;
        $d      = '';
        
        if($page == "role"):
            $d = $this->serverSideRole();
        elseif($page == "company"):
            $d = $this->serverSideCompany();
        elseif($page == "riwayat"):
            $d = $this->serverSideRiwayat();
        elseif($page == "pengalaman"):
            $d = $this->serverSidePengalaman();
        elseif($page == "biodata"):
            $d = $this->serverSideBiodata();
        elseif($page == "user_company"):
            $d = $this->serverSideUserCompany();
        elseif($page == "penugasan"):
            $d = $this->serverSidePenugasan();
        elseif($page == "non_pt"):
            $d = $this->serverSideNonPT();
        elseif($page == "sdm_pt"):
            $d = $this->serverSideSDMPT();
        endif;

        $column = $d['column'];
        $order  = $d['order'];
        $total  = $d['total'];

        $i = 0;
        foreach ($column as $item):
            if($this->input->post("search")):
                if($i===0):
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                else:
                    $this->db->or_like($item, $_POST['search']['value']);
                endif;
                if(count($column) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            endif;
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        endforeach;

        if($this->input->post('order')):
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        elseif(isset($order)):
            $this->db->order_by(key($order), $order[key($order)]);
        endif;

        $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        $data  = array(
            "data"      => $query->result(),
            "total"     => $total,
        );

        $data = json_encode($data);
        $data = json_decode($data);
        return $data;
    }

    private function serverSideRole(){
        $total  = $this->db->count_all("ut_role where Status = '1'");
        $p2     = $this->input->post('p2');
        $company        = $this->input->post('company');
        $company_id     = $this->input->post('company_id');
        $CompanyID      = $this->session->CompanyID;

        $this->db->select("
            RoleID as ID,
            Name,
            Type,
        ");

        $this->db->from('ut_role');
        $this->db->where("Status", 1);

        $HakAksesType   = $this->session->HakAksesType;
        if($HakAksesType == 1):
            if($company == "active"):
                $this->db->where("CompanyID", $company_id);
            else:
                $this->db->where("CompanyID", null);
            endif;
        elseif($HakAksesType == 2):
            if($company == "active"):
                $this->db->where("CompanyID", $company_id);
            else:
                $this->db->where("CompanyID", null);
                $this->db->where_in("ut_role.Type", array(2,3));
            endif;
        else:
            $this->db->where("ut_role.CompanyID", $CompanyID);
            $this->db->where("ut_role.Type is null");
        endif;

        $column = array('RoleID','Name','Type');
        $order  = array('Name' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    private function serverSideCompany(){
        $total  = $this->db->count_all("
            ut_user mt join ut_role dt on mt.RoleID = dt.RoleID 
            where dt.Type = '3'");
        $p2             = $this->input->post('p2');
        $type           = $this->input->post('type');
        $HakAksesType   = $this->session->HakAksesType;

        $this->db->select("
            mt.UserID as ID,
            mt.Name,
            mt.Email,
            mt.Status,

        ");

        $this->db->from('ut_user mt');
        $this->db->join("ut_role dt", "mt.RoleID = dt.RoleID");

        if($type == 'all'):
            $this->db->where("dt.Type >= ", $HakAksesType);
        else:
            $this->db->where("dt.Type", "3");
        endif;

        $column = array('mt.UserID','mt.Name','mt.Email', 'mt.Status');
        $order  = array('mt.Name' => 'asc'); // default order
        if(!in_array($HakAksesType, array(1,2))):
            $this->db->where("mt.UserID", $this->session->CompanyID);
        endif;

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    public function serverSideUserCompany(){
        $total = 0;
        $p2     = $this->input->post('p2');
        $company        = $this->input->post('company');
        $company_id     = $this->input->post('company_id');
        $CompanyID      = $this->session->CompanyID;
        $Level          = $this->session->Level;
        $UserID         = $this->session->UserID;
        $user           = $this->input->post('user');
        $user_id        = $this->input->post('user_id');
        $role           = $this->input->post('role');
        $role_id        = $this->input->post('role_id');

        if($role == "active"):
            $Level = $this->api->get_one_row("ut_role","Level",array("RoleID" => $role_id));
        endif;

        $this->db->select("
            mt_employee.EmployeeID as ID,
            mt_employee.Name,
            mt_employee.Email,

        ");

        $this->db->from('mt_employee');
        $this->db->where("mt_employee.Status", 1);

        $HakAksesType   = $this->session->HakAksesType;
        if($user == "active"):
            $this->db->where("mt_employee.EmployeeID != ", $user_id);
        endif;

        if($HakAksesType == 1):
            if($company == "active"):
                $this->db->where("mt_employee.CompanyID", $company_id);
            else:
                $this->db->where("mt_employee.CompanyID", null);
            endif;
        elseif($HakAksesType == 2):
            if($company == "active"):
                $this->db->where("mt_employee.CompanyID", $company_id);
            else:
                $this->db->where("mt_employee.CompanyID", null);
            endif;
        else:
            $this->db->where("mt_employee.CompanyID", $CompanyID);
            if(in_array($Level,array("1","2","3"))):
                $ParentList     = $this->session->ParentList;
                if(count($ParentList)>0):
                	$this->db->group_start();
	                $this->db->where_in("mt_employee.EmployeeID", $ParentList);
	                $this->db->or_where("mt_employee.EmployeeID", $UserID);
	                $this->db->group_end();
                endif;
            endif;
        endif;

        if($role == 'active'):
            $this->db->join("ut_role as role","role.RoleID = mt_employee.RoleID");
            if($Level):
                $this->db->where("role.Level <= ", $Level->Level);
            else:
                $this->db->where("role.Level <= ", 0);
            endif;
        endif;

        $column = array('mt_employee.EmployeeID','mt_employee.Name','mt_employee.Email');
        $order  = array('mt_employee.Name' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    private function serverSideRiwayat(){

        $column     = array('ID','Posisi','Nama_personil');
        $p2         = $this->input->post('p2');
        $search     = '';
        $searchx = $_POST['search']['value'];
        if($searchx):
            $search = 'and ';
            // $search = 'where ';
            foreach($column as $k => $v){
                if($k===0):
                    $search .= $v." like '%".$searchx."%' "; 
                else:
                    $search .= 'or '.$v." like '%".$searchx."%' ";
                endif;
            }
        endif;

        $total    = $this->db->count_all("biodata where status = '1'".$search); 

        $this->db->select("
            ID,
            Posisi,
            Nama_perusahaan,
            Nama_personil,
            Tempat_tanggal_lahir,
            Pendidikan,
            Pendidikan_non_formal,
            Status, 
        ");

        $this->db->from('biodata');
        $this->db->where("Status", 1);

        $order  = array('ID' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    private function serverSidePenugasan(){

        $column     = array('Posisi');
        $p2         = $this->input->post('p2');
        $search     = '';
        $searchx    = $_POST['search']['value'];
        $f_search   = $this->input->post('f_search');
        if($searchx):
            $search = 'and ';
            // $search = 'where ';
            foreach($column as $k => $v){
                if($k===0):
                    $search .= $v." like '%".$searchx."%' "; 
                else:
                    $search .= 'or '.$v." like '%".$searchx."%' ";
                endif;
            }
        endif;
        
        $total    =  $this->db->count_all("mt_posisi_uraian where status = '1'".$search); 

        $this->db->select("
            ID,
            Posisi,
            Uraian_tugas,
            Status,
        ");

        $this->db->from('mt_posisi_uraian');
        $this->db->group_start();
        $this->db->where("mt_posisi_uraian.Posisi", $f_search);
        $this->db->or_like("mt_posisi_uraian.Posisi", $f_search);
        $this->db->group_end();
        $this->db->where("Status", 1);

        $order  = array('ID' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    private function serverSideNonPT(){

        $column     = array('ID','Nama_personil','Status_pegawai','Nama_perusahaan','Proyek','Periode_proyek_mulai','Periode_proyek_selesai','Status');
        $p2         = $this->input->post('p2');
        $search     = '';
        $searchx    = $_POST['search']['value'];
        $f_search   = $this->input->post('f_search');
        if($searchx):            
            $search = 'and '; 
            foreach($column as $k => $v){
                if($k===0):
                    $search .= $v." like '%".$searchx."%' "; 
                else:
                    $search .= 'or '.$v." like '%".$searchx."%' ";
                endif;
            }
        endif;
        
        if($searchx){
            $total    = $this->db->count_all("mt_sdm where mt_sdm.Nama_personil='$f_search' and mt_sdm.Status = '1'".$search); 
        }else{
            $total    = $this->db->count_all("mt_sdm where mt_sdm.Status = '1'".$search); 
        }

        $this->db->select("
            ID,
            Nama_personil,
            Status_pegawai,
            Nama_perusahaan,
            Proyek,
            Periode_proyek_mulai,
            Periode_proyek_selesai,
            Status_sdm,
            Status,
        ");

        $this->db->from('mt_sdm');     
        $this->db->group_start();
        $this->db->where("Status", 1);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->where("mt_sdm.Nama_personil", $f_search);
        $this->db->or_like("mt_sdm.Nama_personil", $f_search);
        $this->db->group_end();

        $order  = array('ID' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }


    private function serverSideSDMPT(){

        $column     = array('ID','Nama_personil','Status_pegawai','Nama_perusahaan','Proyek','Periode_proyek_mulai','Periode_proyek_selesai','Status');
        $p2         = $this->input->post('p2');
        $search     = '';
        $searchx    = $_POST['search']['value'];
        $f_search   = $this->input->post('f_search');
        if($searchx):
            $search = 'and '; 
            foreach($column as $k => $v){
                if($k===0):
                    $search .= $v." like '%".$searchx."%' "; 
                else:
                    $search .= 'or '.$v." like '%".$searchx."%' ";
                endif;
            }
        endif;
        
        if($searchx){
            $total    = $this->db->count_all("mt_sdm where mt_sdm.Nama_personil='$f_search' and mt_sdm.Status = '1'".$search); 
        }else{
            $total    = $this->db->count_all("mt_sdm where mt_sdm.Status = '1'".$search); 
        }

        $this->db->select("
            ID,
            Nama_personil,
            Status_pegawai,
            Nama_perusahaan,
            Proyek,
            Periode_proyek_mulai,
            Periode_proyek_selesai,
            Status_sdm,
            Status,
        ");

        $this->db->from('mt_sdm');     
        $this->db->group_start();
        $this->db->where("Status", 1);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->where("mt_sdm.Nama_personil", $f_search);
        $this->db->or_like("mt_sdm.Nama_personil", $f_search);
        $this->db->group_end();

        $order  = array('ID' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    private function serverSidePengalaman(){

        $search     = '';
        $searchx    = $_POST['search']['value'];
        $column     = array('pk.ID','pk.PelID','pk.Nama_kegiatan');
        $p2                 = $this->input->post('p2');
        $pengalaman         = $this->input->post('pengalaman');
        $pengalaman_id      = $this->input->post('pengalaman_id');
        if($searchx):
            $search = 'and ';
            // $search = ' where ';
            foreach($column as $k => $v){
                if($k===0):
                    $search .= $v." like '%".$searchx."%' "; 
                else:
                    $search .= 'or '.$v." like '%".$searchx."%' ";
                endif;
            }
        endif;
        
        $total              = $this->db->count_all("mt_daftar_riwayat pk where pk.status = '1'".$search); 

        $this->db->select("
            pk.ID,
            pk.PelID,
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
        $pengalaman_id = json_encode($pengalaman_id);
        if($pengalaman == "active"):
            $this->db->where_not_in('pk.PelID',array($pengalaman_id));
        else:
            $this->db->where("pk.Status", 1);
        endif;

        $order  = array('pk.ID' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    private function serverSideBiodata(){

        $search     = '';
        $searchx    = $_POST['search']['value'];
        $column     = array('pk.ID','pk.Nama_personil','pk.Tempat_tanggal_lahir','pk.Pendidikan','pk.Pendidikan_non_formal','pk.Nomor_hp','pk.Email','pk.Status','pk.Status_bio');
        $p2                 = $this->input->post('p2');
        if($searchx):
            // $search = ' and ';
            $search = ' where ';
            foreach($column as $k => $v){
                if($k===0):
                    $search .= $v." like '%".$searchx."%' "; 
                else:
                    $search .= 'or '.$v." like '%".$searchx."%' ";
                endif;
            }
        endif;
        
        $total              = $this->db->count_all("biodata pk where pk.status = '1'".$search); 

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
        $this->db->join("mt_konstruksi mt", "mt.BioID = pk.BioID");
        $this->db->where_not_in("mt.BioID",array('pk.BioID'));
        $this->db->where("pk.Status", 1);
        $this->db->where("pk.Status_bio", 1);

        $order  = array('pk.ID' => 'asc'); // default order

        $data = array(
            'column'    => $column,
            'order'     => $order,
            'total'     => $total,
        );

        return $data;

    }

    public function checkInputData($input){
        $data = '';
        if($input):
            $data = $input;
        endif;
        return $data;
    }

    public function checkDuitInput($input){
        $data = 0;
        if($input != ''):
            $data = str_replace(',', '', $input);
        endif;
        return $data;
    }



    public function remove_file($table,$column,$where){
        $this->db->select($column);
        $this->db->where($where);
        $this->db->from($table);
        $query = $this->db->get()->row();

        if($query):
            if(is_file($query->{$column})):
                unlink('./' . $query->{$column});
            endif;
        endif;
    }

    public function create_folder_temp(){
        $folder = 'file/temp'.$this->session->CompanyID.'/';
        if (!is_dir($folder)) {
            mkdir('./'.$folder, 0777, TRUE);
        }
    }

    public function create_folder_general($page){
        $UserID = $this->session->UserID;
        $this->create_folder_temp();
        $temp   = 'file/temp'.$this->session->CompanyID.'/';
        $folder = $temp.$page.$UserID."/";
        if (!is_dir($folder)) {
            mkdir('./'.$folder, 0777, TRUE);
        }

        $files = glob('./'.$folder.'*.*');
        foreach($files as $file){
            if(is_file($file))
                unlink($file);
        }
        return $folder;
    }


    public function set_session_company($p1){
        $HakAksesType   = $this->session->HakAksesType;
        $data = array(
            'CompanyName'       => $p1['Name'],
            'CompanyPhone'      => $p1['Phone'],
            'CompanyIso'        => $p1['CountryIso'],
            'CompanyEmail'      => $p1['Email'],
            'CompanyLocation'   => $p1['LocationName'],
            'CompanyLatitude'   => $p1['Latitude'],
            'CompanyLongitude'  => $p1['Longitude'],
            'CompanyRadius'     => $p1['Radius'],
            'CompanyAddress'    => $p1['Address'],
            'CompanyUserName'   => $p1['Username'],
        );

        if(in_array($HakAksesType, array(1,2,3))):
            $data['Name']  = $p1['Name'];
            $data['Email'] = $p1['Email'];
            $data['Phone'] = $p1['Phone'];
        endif;

        if($p1['Image']):
            if(in_array($HakAksesType, array(1,2,3))):
                $data['Image']  = base_url($p1['Image']);
            endif;

            $data['CompanyImage'] = base_url($p1['Image']);
        endif;
        $this->session->set_userdata($data);
    }

    public function set_session_page($p1){
        $HakAksesType   = $this->session->HakAksesType;
        $data = array(
            'PageName'       => $p1['Name'],
            'PageSummary'    => $p1['Summary'],
            'PageDescription'=> $p1['Description'],
            'PageType'       => $p1['Type']
        );
         if(in_array($HakAksesType, array(1,2,3))):
            $data['Name']        = $p1['Name'];
            $data['Summary']     = $p1['Summary'];
            $data['Description'] = $p1['Description'];
        endif;
        
        $this->session->set_userdata($data);
    }

    public function inser_log($LogType,$Type,$Page="",$Content=""){
        $this->load->library('user_agent');
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $HakAksesType   = $this->session->HakAksesType;

        if ($this->agent->is_browser()):
            $agent = $this->agent->browser().' '.$this->agent->version();
        elseif ($this->agent->is_mobile()):
            $agent = $this->agent->mobile();
        else:
            $agent = 'Data user gagal di dapatkan';
        endif;
        $data_user = array(
            "browser"           => $agent,
            "sistem operasi"    => $this->agent->platform(),
            "IP"                => $this->input->ip_address(),
        );

        $Code = $this->generate_code_log();
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

        $this->general_save("ut_log", $data);
    }

    #generate code
    public function generate_code_log($p1=""){
        $month = $this->bulan_romawi();
        $code = $this->autoNumber("ut_log","Code", 5,"LOG-".date("Y")."-".$month."-","month_reset",$p1);
        return $code;
    }

    #generate code
    public function generate_code_konstruksi($p1=""){
        $month = $this->bulan_romawi();
        $code = $this->autoNumber("mt_konstruksi","ID", 5,"FIK-",$p1);
        return $code;
    }

    #generate code
    public function generate_code_proyek($p1=""){
        $month = $this->bulan_romawi();
        $code = $this->autoNumber("proyek","ID", 5,"PRO-",$p1);
        return $code;
    }

    #generate code
    public function generate_code_non_konstruksi($p1=""){
        $month = $this->bulan_romawi();
        $code = $this->autoNumber("mt_non_konstruksi","ID", 5,"NON-",$p1);
        return $code;
    }

    #generate code
    public function generate_code_pengalaman($p1=""){
        $month = $this->bulan_romawi();
        $code = $this->autoNumber("mt_daftar_riwayat","PelID", 5,"PEL-",$p1);
        return $code;
    }

    #sdm ciriajasa code
    public function generate_code_sdm($p1=""){
        $month = $this->bulan_romawi();
        $code = $this->autoNumber("mt_sdm","ID", 5,"SDM-",$p1);
        return $code;
    }

     #biodata code
     public function generate_code_biodata($p1=""){
        $month = $this->bulan_romawi();
        $code = $this->autoNumber("biodata","ID", 5,"BIO-",$p1);
        return $code;
    }

    function version_js(){
        $text = "?version=4.3";
        return $text;
    }

    function time_elapsed_string($datetime, $full = false,$from="",$type="") {
        $now = new DateTime;
        if($from != ''):
            $now = new DateTime($from);
        endif;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        if($type == 'days'):
            $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
        );
        endif;

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);

        if($type == 'duration'):
            return $string ? implode(', ', $string) . '' : '0 minutes';
        else:
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        endif;
    }

    function convert_seconds($seconds,$full = false,$type="") {
        $now = new DateTime("@0");
        $ago = new DateTime("@$seconds");
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        if($type == 'days'):
            $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
        );
        endif;

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);

        if($type == 'duration'):
            return $string ? implode(', ', $string) . '' : '0 minutes';
        else:
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        endif;
    }

    function seconds_to_ago($ptime)
    {
        $etime = $ptime;

        if ($etime < 1)
        {
            return '0';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
                     30 * 24 * 60 * 60  =>  'month',
                          24 * 60 * 60  =>  'day',
                               60 * 60  =>  'hour',
                                    60  =>  'minute',
                                     1  =>  'second'
                    );
        $a_plural = array( 'year'   => 'years',
                           'month'  => 'months',
                           'day'    => 'days',
                           'hour'   => 'hours',
                           'minute' => 'minutes',
                           'second' => 'seconds'
                    );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . '';
            }
        }
    }

    function clean_file_name($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function send_email($page,$code,$cek_page = "",$p1=""){
        if($page == "forgot_password"):
            $nama               = $code->Name;
            $email              = $code->Email;
            $token              = $code->Token;
            $subject            = "Forgot Password ".date("Y-m-d");
            $page_email         = "email/index";
            $data["message"]    = site_url("reset-password?id=".$token);
            $data["page"]       = "email/forgot_password";
        elseif($page == "register"):
            $a                  = $this->user_detail($code);
            $nama               = $a->Name;
            $email              = $a->Email;
            $token              = $a->Token;
            $subject            = "Verification ".date("Y-m-d");
            $page_email         = "email/index";
            $data["message"]    = site_url("verification-user?id=".$token);
            $data["page"]       = "email/verification";
        endif;

        $data["nama"] = $nama;

        $list = $this->api->general_setting('general');
        $general_site = array();
        foreach ($list as $k => $v) {
            $value = $v->Value;
            if($v->Name == 'SiteLogo'):
                $value = site_url($value);
            endif;
            $general_site[$v->Name] = $value;
        }
        $general_site = json_encode($general_site);
        $general_site = json_decode($general_site);

        $data['general_site'] = $general_site;
        if($cek_page == "ya"):
            $this->load->view($page_email,$data);
        else:
            $data_email = $this->db->query("SELECT * FROM ut_smtp");
            if ($data_email->num_rows() > 0):
                $hasil      = $data_email->row(1);
                $protocol   = $hasil->protocol;
                $smtp_host  = $hasil->smtp_host;
                $smtp_port  = $hasil->smtp_port;
                $smtp_user  = $hasil->smtp_user;
                $smtp_pass  = $hasil->smtp_pass;
            endif;
            $config = Array(
                'useragent'     => "Codeigniter",
                'protocol'      => $protocol,
                'smtp_host'     => $smtp_host,
                'smtp_port'     => $smtp_port,
                'smtp_user'     => $smtp_user,
                'smtp_pass'     => $smtp_pass,
                'mailtype'      => 'html',
                'charset'       => 'iso-8859-1',
                'wordwrap'      => TRUE,
                'newline'       => "\r\n",
            );
            $this->load->library('email');
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
            $this->email->subject("E-Database-CV"." - ".$subject);
            $this->email->from($smtp_user,'E-Database-CV');
            $this->email->to($email);
            $this->email->message($this->load->view($page_email, $data, TRUE));
            $send = $this->email->send();
            if($send):
                
            else:
                if($p1 == "yes"):
                    $error = $this->email->print_debugger();
                    print_r($error);
                endif;
            endif;
        endif;
    }

    public function TokenApp(){
        return 'ad8b07ae7fdf29a654ea4ea68c51838f03739ac4';
    }

    public function create_general_file(){
        $list = $this->api->general_setting('general');
        $data = array();
        foreach ($list as $k => $v) {
            $value = $v->Value;
            if($v->Name == 'SiteLogo'):
                $value = site_url($value);
            endif;

            $data[$v->Name] = $value;
        }

        $script    = "var general_site; $(document).ready(function(){ general_site = ".json_encode($data)."});";

        $general_file      = "general_site.js";
        $folder         = "asset/";
        if(is_file($folder.$general_file)){
            unlink($folder.$general_file);
        }
        file_put_contents($folder.$general_file, $script);
    }

    public function CountMonth($d1,$d2){
        $d1 = strtotime($d1);
        $d2 = strtotime($d2);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);
        $i = 0;

        while (($min_date = strtotime("+1 week", $min_date)) <= $max_date) {
            $i++;
        }
        return $i+1;
    }

    public function DayDifference($date1,$date2)
    {
        $datetime1  = new DateTime($date1);
        $datetime2  = new DateTime($date2);
        $difference = $datetime1->diff($datetime2);
        return $difference->days;
    }

    public function WeekOfMonth($p1,$p2){
        $t1 = strtotime($p1);
        $t2 = strtotime($p2);
        $out = array();
        while ($t1 <= $t2) {
            $week = date('W', $t1);
            if(!in_array($week,$out)):
                $out[] = $week;
            endif;
            $t1 = strtotime('+1 day', $t1);
        }
        return $out;
    }

    public function IndexDays($p1){
        $data = array(
            "Mon",
            "Tue",
            "Wed",
            "Thu",
            "Fri",
            "Sat",
            "Sun",
        );

        $d = array_search($p1, $data);
        return $d+1;
    }

    public function LogoWebsite(){
        $data = $this->api->get_one_row("ut_general","Value",array('Code' => 'general', 'Name' => 'SiteLogo'));
        $img = 'img/image_default.png';
        if($data):
            $img = $data->Value;
        endif;

        return site_url($img);
    }

    public function Theme(){
        $arr_theme_1 = array(
            'img/theme/alpa-theme-1.6.png',
            'img/theme/alpa-theme-1.2.png',
            'img/theme/alpa-theme-1.3.png',
            'img/theme/alpa-theme-1.4.png',
            'img/theme/alpa-theme-1.5.png',
        );

        $arr_theme_2 = array(
            'img/theme/alpa-theme-2.1.png',
            'img/theme/alpa-theme-2.2.png',
            'img/theme/alpa-theme-2.3.png',
            'img/theme/alpa-theme-2.4.png',
            'img/theme/alpa-theme-2.5.png',
        );

        $arr_theme_3 = array(
            'img/theme/alpa-theme-3.1.png',
            'img/theme/alpa-theme-3.2.png',
            'img/theme/alpa-theme-3.3.png',
            'img/theme/alpa-theme-3.4.png',
            'img/theme/alpa-theme-3.5.png',
        );

        $data = array(
            'theme_1'   => $arr_theme_1,
            'theme_2'   => $arr_theme_2,
            'theme_3'   => $arr_theme_3,
        );

        $data = json_encode($data);
        $data = json_decode($data);

        return $data;
    }

    public function YearAttendace(){
        $CompanyID      = $this->session->CompanyID;
        $HakAksesType   = $this->session->HakAksesType;
        $UserID         = $this->session->UserID;
        $Level          = $this->session->Level;
        $ParentList     = $this->session->ParentList;

        $table = "t_attendance";

        $this->db->select("Year($table.WorkDate) as Year");
        $this->db->from($table);
        if(!in_array($HakAksesType, array(1,2))):
            $this->db->where("$table.CompanyID", $CompanyID);
        endif;
        $this->db->where("$table.Type", 1);
        if(!in_array($HakAksesType, array(1,2,3))):
            if(in_array($Level,array(1,2,3))):
                array_push($ParentList,$UserID);
                $this->db->group_start();
                $this->db->where_in("$table.EmployeeID", $ParentList);
                $this->db->group_end();
            else:
                $this->db->where("$table.EmployeeID", $UserID);
            endif;
        endif;
        $this->db->order_by("$table.WorkDate");
        $this->db->limit(1);
        $query = $this->db->get()->row();

        $Year       = date("Y", strtotime($this->session->CompanyJoinDate));
        $YearNow    = date("Y");
        if($query):
            $Year = $query->Year;
        endif;

        $arrYear = array();

        while ( $Year <= $YearNow) {
            array_push($arrYear, $Year);
            $Year += 1;
        }

        return $arrYear;
    }

    public function Month(){
        $Month = array(
            $this->lang->line('lb_january'),
            $this->lang->line('lb_february'),
            $this->lang->line('lb_march'),
            $this->lang->line('lb_april'),
            $this->lang->line('lb_may'),
            $this->lang->line('lb_june'),
            $this->lang->line('lb_july'),
            $this->lang->line('lb_august'),
            $this->lang->line('lb_september'),
            $this->lang->line('lb_october'),
            $this->lang->line('lb_november'),
            $this->lang->line('lb_december'),
        );

        $arrMonth = array();
        foreach ($Month as $k => $v) {
            $no = $k + 1;
            if($no < 10): $no = "0".$no; endif;
            $h['Value']   = $no;
            $h['Name']    = $v;

            array_push($arrMonth, $h);
        }

        $arrMonth = json_encode($arrMonth);
        $arrMonth = json_decode($arrMonth);
        return $arrMonth;
    }

    public function MonthLabel($p1){
        $Month = array(
            $this->lang->line('lb_january'),
            $this->lang->line('lb_february'),
            $this->lang->line('lb_march'),
            $this->lang->line('lb_april'),
            $this->lang->line('lb_may'),
            $this->lang->line('lb_june'),
            $this->lang->line('lb_july'),
            $this->lang->line('lb_august'),
            $this->lang->line('lb_september'),
            $this->lang->line('lb_october'),
            $this->lang->line('lb_november'),
            $this->lang->line('lb_december'),
        );

        return $Month[$p1];
    }

    public function SetParent(){
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $HakAksesType   = $this->session->HakAksesType;
        $Level          = $this->session->Level;
        $GetParent = $this->api->GetParent($CompanyID,$UserID,$HakAksesType,$Level);
        $d = array(
            "ParentList"    => $GetParent
        );
        $this->session->set_userdata($d);
    }

    public function SetParent2(){
        $CompanyID      = $this->session->CompanyID;
        $UserID         = $this->session->UserID;
        $HakAksesType   = $this->session->HakAksesType;
        $Level          = $this->session->Level;
        $GetParent = $this->api->GetParent2($CompanyID,$UserID,$HakAksesType,$Level);

        $d = array(
            "ParentList"    => $GetParent
        );
        $this->session->set_userdata($d);
    }
    
    function tanggal_indo($tanggal) {
        $bulan = array (1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }

    public function column_excell($index){
        $column = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
            'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
            'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
            'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
            'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
            'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
            'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
            'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
            'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ','IK','IL','IM','IN','IO','IP','IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ',
            'JA','JB','JC','JD','JE','JF','JG','JH','JI','JJ','JK','JL','JM','JN','JO','JP','JQ','JR','JS','JT','JU','JV','JW','JX','JY','JZ',
            'KA','KB','KC','KD','KE','KF','KG','KH','KI','KJ','KK','KL','KM','KN','KO','KP','KQ','KR','KS','KT','KU','KV','KW','KX','KY','KZ',
            'LA','LB','LC','LD','LE','LF','LG','LH','LI','LJ','LK','LL','LM','LN','LO','LP','LQ','LR','LS','LT','LU','LV','LW','LX','LY','LZ',
            'MA','MB','MC','MD','ME','MF','MG','MH','MI','MJ','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ',
            'NA','NB','NC','ND','NE','NF','NG','NH','NI','NJ','NK','NL','NM','NN','NO','NP','NQ','NR','NS','NT','NU','NV','NW','NX','NY','NZ',
            'OA','OB','OC','OD','OE','OF','OG','OH','OI','OJ','OK','OL','OM','ON','OO','OP','OQ','OR','OS','OT','OU','OV','OW','OX','OY','OZ',
            'PA','PB','PC','PD','PE','PF','PG','PH','PI','PJ','PK','PL','PM','PN','PO','PP','PQ','PR','PS','PT','PU','PV','PW','PX','PY','PZ',
            'QA','QB','QC','QD','QE','QF','QG','QH','QI','QJ','QK','QL','QM','QN','QO','QP','QQ','QR','QS','QT','QU','QV','QW','QX','QY','QZ',
            'RA','RB','RC','RD','RE','RF','RG','RH','RI','RJ','RK','RL','RM','RN','RO','RP','RQ','RR','RS','RT','RU','RV','RW','RX','RY','RZ',
            'SA','SB','SC','SD','SE','SF','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SP','SQ','SR','SS','ST','SU','SV','SW','SX','SY','SZ',
            'TA','TB','TC','TD','TE','TF','TG','TH','TI','TJ','TK','TL','TM','TN','TO','TP','TQ','TR','TS','TT','TU','TV','TW','TX','TY','TZ',
            'UA','UB','UC','UD','UE','UF','UG','UH','UI','UJ','UK','UL','UM','UN','UO','UP','UQ','UR','US','UT','UU','UV','UW','UX','UY','UZ',
            'VA','VB','VC','VD','VE','VF','VG','VH','VI','VJ','VK','VL','VM','VN','VO','VP','VQ','VR','VS','VT','VU','VV','VW','VX','VY','VZ',
            'WA','WB','WC','WD','WE','WF','WG','WH','WI','WJ','WK','WL','WM','WN','WO','WP','WQ','WR','WS','WT','WU','WV','WW','WX','WY','WZ',
            'XA','XB','XC','XD','XE','XF','XG','XH','XI','XJ','XK','XL','XM','XN','XO','XP','XQ','XR','XS','XT','XU','XV','XW','XX','XY','XZ',
            'YA','YB','YC','YD','YE','YF','YG','YH','YI','YJ','YK','YL','YM','YN','YO','YP','YQ','YR','YS','YT','YU','YV','YW','YX','YY','YZ',
            'ZA','ZB','ZC','ZD','ZE','ZF','ZG','ZH','ZI','ZJ','ZK','ZL','ZM','ZN','ZO','ZP','ZQ','ZR','ZS','ZT','ZU','ZV','ZW','ZX','ZY','ZZ',
        );

        if(isset($column[$index])):
            return $column[$index];
        else:
            return '';
        endif;
    }

    public function Color($p1){
        if($p1 && $p1>5):
            $p1 = rand(0,6);
        endif;
        $color = 'black';
        if($p1 == 0): $color = 'orange';
        elseif($p1 == 1): $color = 'green';
        elseif($p1 == 2): $color = 'red';
        elseif($p1 == 3): $color = 'blue';
        elseif($p1 == 4): $color = 'puple';
        elseif($p1 == 5): $color = 'megna';
        endif;

        return $color;
    }

    public function token_encode($token)
    {
        $first  = $this->randomstring(8);
        $second = $this->randomstring(7);
        $token  = $first.$token.$second;
        return $token = base64_encode($token);
    }
    public function token_decode($token)
    {
        $token = base64_decode($token);
        $token = substr($token, 8);
        $token = substr($token, 0,-7);
        return $token;
    }
    private function randomstring($length = 10) {
        $characters         = '1234567890';//abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength   = strlen($characters);
        $randomString       = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function get_text($string = ""){
        $v = explode(" ", $string);

        $awal = '<b>'.$v[0].'</b>';
        $text = '';
        foreach ($v as $k => $v) {
            if($k != 0):
                $text .= $v." ";
            endif;
        }
        return array($awal,$text);
    }
    
    function htmlToPlainText($str){
        $str = str_replace('&nbsp;', ' ', $str);
        $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
        $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
        $str = html_entity_decode($str);
        $str = htmlspecialchars_decode($str);
        $str = strip_tags($str);
    
        return $str;
    }

    function strip_tags_content($string) { 
        // ----- remove HTML TAGs ----- 
        $string = preg_replace ('/<[^>]*>/', ' ', $string); 
        // ----- remove control characters ----- 
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", ' ', $string);
        $string = str_replace("\t", ' ', $string);
        // ----- remove multiple spaces ----- 
        $string = trim(preg_replace('/ {2,}/', ' ', $string));
        return $string; 
    
    }
    public function fixBreakSpaces($value){
		$oldBrs = ['<br />', '</br>', '<br>', '\r\n', '\n'];
	
		$value = json_encode(['txt'=>$value]);
		$value = str_replace($oldBrs, $this->newBr, $value);
	
		$value = json_decode($value);
	
		return $value->txt;
	}
    public function count_mount($from, $to){
        $month_in_year = 12;
        $date_from = getdate(strtotime($from));
        $date_to = getdate(strtotime($to));
        return ($date_to['year'] - $date_from['year']) * $month_in_year -
            ($month_in_year - $date_to['mon']) +
            ($month_in_year - $date_from['mon']);
    }

    public function upload(){
        $file_name =  $_FILES['file']['name']; //getting file name
        $tmp_name = $_FILES['file']['tmp_name']; //getting temp_name of file
        $file_up_name = time().$file_name; //making file name dynamic by adding time before file name
        move_uploaded_file($tmp_name, "upload_file/".$file_up_name); //moving file to the specified folder with dynamic name
    }
    
    // public function attachment_show($Type,$ID){
    //     $list = $this->api->attachment_list($Type,$ID);
    //     $data = array();
    //     foreach ($list as $k => $v) {
    //         $Name = '';
    //         if($v->Name):
    //             $Name = $v->Name;
    //         else:
    //             $file = $v->Image;
    //             $file = explode("/", $file);
    //             $Name = $file[count($file)-1];
    //         endif;
    //         $type = explode(".", $Name);
    //         if(count($type)>1):
    //             $type = $type[1];
    //         else:
    //             $type = '';
    //         endif;
    //         $h['filename']  = $Name;
    //         $h['url']       = $v->Image;
    //         $h['size']      = filesize($v->Image);
    //         $h['status']    = 1;
    //         $h['type']      = $type;
    //         $h['page']      = 'show';
    //         $h['id']        = $v->attachID;

    //         array_push($data, $h);
    //     }

    //     return $data;
    // }

     public function attachment_show($Type,$ID){
        $list = $this->api->attachment_list($Type,$ID);
        $data = array();
        foreach ($list as $k => $v) {
            $Name = '';
            if($v->Name):
                $Name = $v->Name;
            else:
                $file = $v->Image;
                $file = explode("/", $file);
                $Name = $file[count($file)-1];
            endif;
            $type = explode(".", $Name);
            if(count($type)>1):
                $type = $type[1];
            else:
                $type = '';
            endif;
            $h['filename']  = $Name;
            $h['url']       = $v->Url;
            $h['size']      = filesize($v->Image);
            $h['status']    = 1;
            $h['type']      = $type;
            $h['page']      = 'show';
            $h['id']        = $v->attachID;

            array_push($data, $h);
        }

        return $data;
    }

    public function data_uraian(){
        $this->db->select("
            mt_posisi_uraian.ID,
            mt_posisi_uraian.Posisi,
            mt_posisi_uraian.Uraian_tugas,
		");
		$this->db->from("mt_posisi_uraian");
		$query = $this->db->get();

		return $query->result();
    }
}