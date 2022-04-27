<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_validation extends CI_Model {
	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }

    public function login(){
    	$status 	= true;
    	$message 	= "";
    	$username 	= $this->input->post('username');
    	$password 	= $this->input->post('password');

    	$user = $this->api->user("username",$username);
    	if($user):
            $user->LoginType = 'not_user';
    		$password = $this->main->create_password($password);
    		if($password != $user->Password):
    			$status 	= false;
    			$message  	= "Wrong Password";
    		endif;
            if($user->Status != 1):
                $status     = false;
                $message    = "Account has been Nonactive, Please contact your admin";
            endif;
        else:
            $status     = false;
            $message    = "User Not Registered";
        endif;

    	if(!$status):
    		$output = array(
    			"status" 	=> $status,
    			"message"	=> $message,
    		);
    		$this->main->echoJson($output);
    		exit();
    	endif;

    	return $user;

    }

    public function register(){
    	$data                   = array();
        $data['error_string']   = array();
        $data['inputerror']     = array();
        $data['input_type']     = array();
        $data['status']         = TRUE;
        $message                = $this->lang->line('lb_incomplate_form');

        $full_name      = $this->input->post('full_name');
        $phone_number   = $this->input->post('phone_number');
        $email          = $this->input->post('email');
        $password       = $this->input->post('password');

        if($full_name == ''):
            $data['inputerror'][] = 'full_name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        if($phone_number == ''):
            $data['inputerror'][] = 'phone_number';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_phone_null');
            $data['status'] = FALSE;
        endif;

        $ck_email = $this->api->get_one_row("ut_user","Email",array("email" => $email));

        if($email == ''):
            $data['inputerror'][] = 'email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_null');
            $data['status'] = FALSE;
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)):
            $data['inputerror'][] = 'email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_validate');
            $data['status'] = FALSE;
        elseif($ck_email):
            $data['inputerror'][] = 'email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_already');
            $data['status'] = FALSE;
        endif;

        if($password == ''):
            $data['inputerror'][] = 'password';
            $data['input_type'][] = 'input_group';
            $data['error_string'][] = $this->lang->line('lb_password_null');
            $data['status'] = FALSE;
        elseif($password):
            if(strlen($password)<8):
                $data['inputerror'][] = 'password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_max');
                $data['status'] = FALSE;
            elseif(!preg_match("#[0-9]+#", $password)):
                $data['inputerror'][] = 'password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_numb');
                $data['status'] = FALSE;
            elseif(!preg_match("#[A-Z]+#", $password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_upper');
                $data['status'] = FALSE;
            elseif(!preg_match("#[a-z]+#", $password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_lower');
                $data['status'] = FALSE;
            endif;
        endif;

    	if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }

    public function menu()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        // form
        $ID     = $this->input->post("ID");
        $Level  = $this->input->post("Level");
        $Parent = $this->input->post("Parent");

        if($this->input->post('Name') == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        // if($this->input->post('Url') == ''):

        //     $data['inputerror'][] = 'Url';

        //     $data['input_type'][] = '';

        //     $data['error_string'][] = $this->lang->line('lb_url_null');

        //     $data['status'] = FALSE;

        // endif;



        // if($this->input->post('Root') == ''):

        //     $data['inputerror'][] = 'Root';

        //     $data['input_type'][] = '';

        //     $data['error_string'][] = $this->lang->line('lb_root_null');

        //     $data['status'] = FALSE;

        // endif;

        if(!$Level):
            $data['inputerror'][] = 'Level';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_root_null');
            $data['status'] = FALSE;
        endif;

        if($Level > 1):
            $ParentLevel = $Level - 1;
            $ckParent     = $this->db->count_all("ut_menu where MenuID = $Parent and Level = '$ParentLevel' and MenuID != '$ID'");
            if(!$Parent):
                $data['inputerror'][] = 'Parent';
                $data['input_type'][] = 'select2';
                $data['error_string'][] = $this->lang->line('lb_parent_null');
                $data['status'] = FALSE;
            elseif($ckParent<1):
                $data['inputerror'][] = 'Parent';
                $data['input_type'][] = 'select2';
                $data['error_string'][] = $this->lang->line('lb_parent_not_found');
                $data['status'] = FALSE;
            endif;

        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }


    public function users($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');
        $Crud    = $this->input->post("crud");
        $ID      = $this->input->post("ID");
        if($p1 == "company"):
            $ID = $this->session->CompanyID;
        endif;

        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        $Email = $this->input->post('Email');
        if($Crud == "update"):
            $ck_email = $this->api->get_one_row("ut_user","Email",array("Email" => $Email, "UserID != " => $ID));
        else:
            $ck_email = $this->api->get_one_row("ut_user","Email",array("Email" => $Email));
        endif;

        if($Email == ''):
            $data['inputerror'][] = 'Email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_null');
            $data['status'] = FALSE;
        elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)):
            $data['inputerror'][] = 'Email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_validate');
            $data['status'] = FALSE;
        elseif($ck_email):
            $data['inputerror'][] = 'Email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_already');
            $data['status'] = FALSE;
        endif;

        $Password = $this->input->post('Password');
        if($Password == '' && $Crud != "update"):
            $data['inputerror'][] = 'Password';
            $data['input_type'][] = 'input_group';
            $data['error_string'][] = $this->lang->line('lb_password_null');
            $data['status'] = FALSE;
        elseif($Password):
            if(strlen($Password)<8):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_max');
                $data['status'] = FALSE;
            elseif(!preg_match("#[0-9]+#", $Password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_numb');
                $data['status'] = FALSE;
            elseif(!preg_match("#[A-Z]+#", $Password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_upper');
                $data['status'] = FALSE;
            elseif(!preg_match("#[a-z]+#", $Password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_lower');
                $data['status'] = FALSE;
            endif;
        endif;

        $Role = $this->input->post('Role');
        if(!$Role && $p1 != 'company'):
            $data['inputerror'][] = 'Role';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_role_null');
            $data['status'] = FALSE;
        endif;

        $Phone = $this->input->post('Phone');
        if(!$Phone):
            $data['inputerror'][] = 'Phone';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_phone_null');
            $data['status'] = FALSE;
        endif;

        $StartJoin = $this->input->post('StartJoin');
        if(!$StartJoin and $p1 != "company"):
            $data['inputerror'][] = 'StartJoin';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_start_join_null');
            $data['status'] = FALSE;
        endif;

        $StartWorkDate = $this->input->post('StartWorkDate');
        if(!$StartWorkDate):
            $data['inputerror'][] = 'StartWorkDate';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_work_date_null');
            $data['status'] = FALSE;
        endif;

        // $LocationName = $this->input->post('LocationName');
        // if(!$LocationName):
        //     $data['inputerror'][] = 'LocationName';
        //     $data['input_type'][] = '';
        //     $data['error_string'][] = $this->lang->line('lb_location_name_null');
        //     $data['status'] = FALSE;
        // endif;

        // $Address    = $this->input->post('Address');
        // if(!$Address):
        //     $data['inputerror'][] = 'Address';
        //     $data['input_type'][] = '';
        //     $data['error_string'][] = $this->lang->line('lb_address_null');
        //     $data['status'] = FALSE;
        // endif;

        // $Radius = $this->input->post('Radius');
        // if(strlen($Radius)<1):
        //     $data['inputerror'][] = 'Radius';
        //     $data['input_type'][] = '';
        //     $data['error_string'][] = $this->lang->line('lb_radius_null');
        //     $data['status'] = FALSE;
        // endif;

        // $Latitude = $this->input->post('Latitude');
        // if(!$Latitude):
        //     $data['inputerror'][] = 'Latitude';
        //     $data['input_type'][] = '';
        //     $data['error_string'][] = $this->lang->line('lb_latitude_null');
        //     $data['status'] = FALSE;
        // endif;

        // $Longidute = $this->input->post('Longidute');
        // if(!$Longidute):
        //     $data['inputerror'][] = 'Longidute';
        //     $data['input_type'][] = '';
        //     $data['error_string'][] = $this->lang->line('lb_longitude_null');
        //     $data['status'] = FALSE;
        // endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }

    public function role(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');
        $Crud    = $this->input->post("crud");
        $ID      = $this->input->post("ID");

        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        $HakAksesType = $this->session->HakAksesType;

        if($HakAksesType == 3):
            $Level = $this->input->post('Level');
            if(!in_array($Level, array(1,2,3,4))):
                $data['inputerror'][] = 'Level';
                $data['input_type'][] = '';
                $data['error_string'][] = 'Level min 1 max 4';
                $data['status'] = FALSE;
            endif;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }

    public function user_company($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $this->input->post('Company');
        endif;

        if($p1 == "users"):
            $ID = $this->session->UserID;
        endif;

        if(!$CompanyID):
            $data['inputerror'][] = 'Company';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_company_null');
            $data['status'] = FALSE;
        endif;

        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        $Email = $this->input->post('Email');
        if($Crud == "update"):
            $ck_email = $this->api->get_one_row("mt_employee","Email",array("Email" => $Email, "EmployeeID != " => $ID, "CompanyID" => $CompanyID));
        else:
            $ck_email = $this->api->get_one_row("mt_employee","Email",array("Email" => $Email, "CompanyID" => $CompanyID));
        endif;

        if($Email == ''):
            $data['inputerror'][] = 'Email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_null');
            $data['status'] = FALSE;
        elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)):
            $data['inputerror'][] = 'Email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_validate');
            $data['status'] = FALSE;
        elseif($ck_email):
            $data['inputerror'][] = 'Email';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_email_already');
            $data['status'] = FALSE;
        endif;

        $Password = $this->input->post('Password');
        if($Password == '' && $Crud != "update"):
            $data['inputerror'][] = 'Password';
            $data['input_type'][] = 'input_group';
            $data['error_string'][] = $this->lang->line('lb_password_null');
            $data['status'] = FALSE;
        elseif($Password):
            if(strlen($Password)<8):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_max');
                $data['status'] = FALSE;
            elseif(!preg_match("#[0-9]+#", $Password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_numb');
                $data['status'] = FALSE;
            elseif(!preg_match("#[A-Z]+#", $Password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_upper');
                $data['status'] = FALSE;
            elseif(!preg_match("#[a-z]+#", $Password)):
                $data['inputerror'][] = 'Password';
                $data['input_type'][] = 'input_group';
                $data['error_string'][] = $this->lang->line('lb_password_lower');
                $data['status'] = FALSE;
            endif;

        endif;

        $Branch = $this->input->post('Branch');
        if(!$Branch and $p1 != 'users'):
            $data['inputerror'][] = 'Branch';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_branch_null');
            $data['status'] = FALSE;
        endif;

        $Role = $this->input->post('Role');
        if(!$Role and $p1 != 'users'):
            $data['inputerror'][] = 'Role';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_role_null');
            $data['status'] = FALSE;
        endif;

        $Pattern = $this->input->post('Pattern');
        if(!$Pattern and $p1 != 'users'):
            $data['inputerror'][] = 'Pattern';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_work_pattern_null');
            $data['status'] = FALSE;
        endif;

        $Phone = $this->input->post("Phone");
        if(!$Phone):
            $data['inputerror'][] = 'Phone';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_phone_null');
            $data['status'] = FALSE;
        endif;

        $WorkDate = $this->input->post('WorkDate');
        if(!$WorkDate):
            $data['inputerror'][] = 'WorkDate';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_work_date_null');
            $data['status'] = FALSE;
        endif;

        $Username = $this->input->post('Username');
        if(!$Username):
            $data['inputerror'][] = 'Username';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_username_null');
            $data['status'] = FALSE;
        elseif(strlen($Username)<6):
            $data['inputerror'][] = 'Username';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_username_max');
            $data['status'] = FALSE;
        endif;

        $Departement = $this->input->post('Departement');
        if(!$Departement):
            $data['inputerror'][] = 'Departement';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_departement_null');
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }

    public function user_company_import(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->input->post('Company');
        if(in_array($HakAksesType, array(1,2))):
            if(!$CompanyID):
                $data['inputerror'][] = 'Company';
                $data['input_type'][] = '';
                $data['error_string'][] = $this->lang->line('lb_company_null');
                $data['status'] = FALSE;
            endif;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }

    public function leave(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->input->post('Company');
        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");

        if(in_array($HakAksesType, array(1,2))):
            if(!$CompanyID):
                $data['inputerror'][] = 'Company';
                $data['input_type'][] = '';
                $data['error_string'][] = $this->lang->line('lb_company_null');
                $data['status'] = FALSE;
            endif;
        endif;

        $Code = $this->input->post('Code');
        if($Crud == "update"):
            $ck_code = $this->api->get_one_row("mt_leave","Code",array("Code" => $Code, "LeaveID != " => $ID, "CompanyID" => $CompanyID));
        else:
            $ck_code = $this->api->get_one_row("mt_leave","Code",array("Code" => $Code, "CompanyID" => $CompanyID));
        endif;

        if($Code == ''):
            $data['inputerror'][] = 'Code';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_code_null');
            $data['status'] = FALSE;
        elseif($ck_code):
            $data['inputerror'][] = 'Code';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_code_already');
            $data['status'] = FALSE;
        elseif(strlen($Code)<3):
            $data['inputerror'][] = 'Code';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_code_max');
            $data['status'] = FALSE;
        endif;

        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }

    public function visit(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->input->post('Company');
        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");

        if(in_array($HakAksesType, array(1,2))):
            if(!$CompanyID):
                $data['inputerror'][] = 'Company';
                $data['input_type'][] = '';
                $data['error_string'][] = $this->lang->line('lb_company_null');
                $data['status'] = FALSE;
            endif;
        endif;

        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        $Category = $this->input->post('Category');
        if($Category == ''):
            $data['inputerror'][] = 'Category';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_category_null');
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    } 

    public function page_setting(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $CompanyID      = $this->input->post('Company');
        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");
        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        $Summary = $this->input->post('Summary');
        if($Summary == ''):
            $data['inputerror'][] = 'Summary';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_summary_null');
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }


    public function t_overtime(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->input->post('Company');
        $User      = $this->input->post('User');
        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");
        if(in_array($HakAksesType, array(1,2))):
            if(!$CompanyID):
                $data['inputerror'][] = 'Company';
                $data['input_type'][] = 'input_select';
                $data['error_string'][] = $this->lang->line('lb_company_null');
                $data['status'] = FALSE;
            endif;
        endif;

        $User = $this->input->post('User');
        if(!$User):
            $data['inputerror'][] = 'User';
            $data['input_type'][] = 'input_select';
            $data['error_string'][] = $this->lang->line('lb_user_null');
            $data['status'] = FALSE;
        endif;

        $StartDate = $this->input->post('StartDate');
        if($StartDate == ''):
            $data['inputerror'][] = 'StartDate';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_start_date_null');
            $data['status'] = FALSE;
        endif;

        $From = $this->input->post('From');
        if($From == ''):
            $data['inputerror'][] = 'From';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_start_null');
            $data['status'] = FALSE;
        endif;

        $To = $this->input->post('To');
        if($To == ''):
            $data['inputerror'][] = 'To';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_to_null');
            $data['status'] = FALSE;
        endif;

        $EndDate = $this->input->post('EndDate');
        if($EndDate == ''):
            $data['inputerror'][] = 'EndDate';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_start_end_null');
            $data['status'] = FALSE;
        endif;

        $Remark = $this->input->post('Remark');
        if(!$Remark):
            $data['inputerror'][] = 'Remark';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_remark_null');
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }



    public function work_pattern(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->input->post('Company');
        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");

        if(in_array($HakAksesType, array(1,2))):
            if(!$CompanyID):
                $data['inputerror'][] = 'Company';
                $data['input_type'][] = '';
                $data['error_string'][] = $this->lang->line('lb_company_null');
                $data['status'] = FALSE;
            endif;
        endif;

        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        $DaysNumber = $this->input->post('DaysNumber');
        $DaysNumber = $this->main->checkDuitInput($DaysNumber);
        if(!in_array($DaysNumber, array(7,14,28))):
            $data['inputerror'][] = 'DaysNumber';
            $data['input_type'][] = '';
            $data['error_string'][] = 'The number must be 7,14 or 28';
            $data['status'] = FALSE;
        elseif($DaysNumber>0):
            $TimeFrom   = $this->input->post('TimeFrom');
            $TimeTo     = $this->input->post('TimeTo');
            foreach ($TimeFrom as $k => $v) {
                if(!$TimeFrom[$k]):
                    $data['inputerror'][] = 'TimeFrom';
                    $data['input_type'][] = 'array_group';
                    $data['error_string'][] = ''.$k;
                    $data['status'] = FALSE;
                endif;
                if(!$TimeTo[$k]):
                    $data['inputerror'][] = 'TimeTo';
                    $data['input_type'][] = 'array_group';
                    $data['error_string'][] = ''.$k;
                    $data['status'] = FALSE;
                endif;
            }
        endif;

        $Apply = $this->input->post('Apply');
        $TeleranceRemark = $this->input->post('TeleranceRemark');
        $TeleranceRemark = $this->main->checkDuitInput($TeleranceRemark);
        if($Apply):
            if($TeleranceRemark<1):
                $data['inputerror'][] = 'TeleranceRemark';
                $data['input_type'][] = '';
                $data['error_string'][] = "Tardiness Tolerance can't be null";
                $data['status'] = FALSE;
            endif;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

    }

    public function transactionleave(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $HakAksesType   = $this->session->HakAksesType;
        $Level          = $this->session->Level;
        $CompanyID      = $this->input->post('Company');
        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");

        if(in_array($HakAksesType, array(1,2))):
            if(!$CompanyID):
                $data['inputerror'][] = 'Company';
                $data['input_type'][] = 'input_select';
                $data['error_string'][] = $this->lang->line('lb_company_null');
                $data['status'] = FALSE;
            endif;
        endif;

        if(in_array($HakAksesType, array(1,2,3)) || in_array($Level, array(1,2))):
            $User = $this->input->post('User');
            if(!$User):
                $data['inputerror'][] = 'User';
                $data['input_type'][] = 'input_select';
                $data['error_string'][] = $this->lang->line('lb_user_null');
                $data['status'] = FALSE;
            endif;
        endif;

        $Start  = $this->input->post('Start');
        if(!$Start):
            $data['inputerror'][] = 'Start';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_start_date_null');
            $data['status'] = FALSE;
        endif;
        $End    = $this->input->post('End');
        if(!$End):
            $data['inputerror'][] = 'End';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_start_end_null');
            $data['status'] = FALSE;
        endif;

        $Leave = $this->input->post('Leave');
        if(!$Leave):
            $data['inputerror'][] = 'Leave';
            $data['input_type'][] = 'input_select';
            $data['error_string'][] = $this->lang->line('lb_leave_type_null');
            $data['status'] = FALSE;
        endif;

        $Remark = $this->input->post('Remark');
        if(!$Remark):
            $data['inputerror'][] = 'Remark';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_remark_null');
            $data['status'] = FALSE;
        endif;

        if($Crud == 'update'):
            $ApproveStatus = $this->api->get_one_row("t_leave","ApproveStatus", array("Code" => $ID, "CompanyID" => $CompanyID))->ApproveStatus;
            if(in_array($ApproveStatus,array(2,3))):
                $data['inputerror'][] = '';
                $data['input_type'][] = '';
                $data['error_string'][] = $this->lang->line('lb_access_update');
                $data['status'] = FALSE;
                $message = $this->lang->line('lb_access_update');
            endif;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function forgot_password(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Email  = $this->input->post('Email');
        $token  = $this->main->create_password($Email.time());
        $data_token   = array("Token" => $token);
        $ck_user = $this->api->get_one_row("ut_user","Email,Status,Name,UserID", array("Email" => $Email));
        $page = 'user';
        if($ck_user):
            if($ck_user->Status == 0):
                $data['status'] = FALSE;
                $message = 'Your account has been nonactive';
            else:
                $this->main->general_update("ut_user",$data_token,array("UserID" => $ck_user->UserID));
            endif;
        else:
            $data['status'] = FALSE;
            $message = 'Account not registered';
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
        $ck_user->Token = $token;
        return $ck_user;
    }

    public function forgot_password_save(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $ID         = $this->input->post('ID');
        $Password   = $this->input->post('Password');
        $ConfirmPassword = $this->input->post('ConfirmPassword');

        $page = 'user';
        $ck_user = $this->api->get_one_row("ut_user","UserID", array("Token" => $ID));

        if($ck_user):
            if($Password == ''):
                $message        = $this->lang->line('lb_password_null');
                $data['status'] = FALSE;
            elseif($Password):
                if(strlen($Password)<8):
                    $message        = $this->lang->line('lb_password_max');
                    $data['status'] = FALSE;
                elseif(!preg_match("#[0-9]+#", $Password)):
                    $message        = $this->lang->line('lb_password_numb');
                    $data['status'] = FALSE;
                elseif(!preg_match("#[A-Z]+#", $Password)):
                    $message        = $this->lang->line('lb_password_upper');
                    $data['status'] = FALSE;
                elseif(!preg_match("#[a-z]+#", $Password)):
                    $message        = $this->lang->line('lb_password_lower');
                    $data['status'] = FALSE;
                elseif($Password != $ConfirmPassword):
                    $message        = $this->lang->line('lb_password_not_match');
                    $data['status'] = FALSE;
                endif;
            endif;
        else:
            $data['status'] = FALSE;
            $message = 'Invalid Url';
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

        $ck_user->Page = $page;
        return $ck_user;
    }

    public function verification_save(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;

        $ID   = $this->input->post('ID');

        $page = 'verification';
        $ck_user = $this->api->get_one_row("ut_user","UserID", array("Token" => $ID));

        if($ck_user == ''):
            $data['status'] = FALSE;
            $message = 'Invalid Url';
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

        $ck_user->Page = $page;
        return $ck_user;
    }

    public function LoginAndroid(){
        $Email      = $this->input->post("Email");
        $Password   = $this->input->post("Password");
        $Token      = $this->input->post("Token");
        $Imei       = $this->input->post("Imei");
        $DeviceID   = $this->input->post("DeviceID");

        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status']     = TRUE;
        $data['res_code']   = 500;// error
        $message            = "";
        
        if($Token != $this->main->TokenApp()):
            $data['status'] = FALSE;
            $message = 'Data not found';
        else:
            $Password = $this->main->create_password($Password);
            $user_employee = $this->api->employee("username", $Email,$Password);
            if($user_employee):
                if($user_employee->Status != 1):
                    $data['status'] = FALSE;
                    $message = 'Your Account has been Nonactive, Please contact your admin';
                endif;
                if($user_employee->ImeiDefault == 1 and $user_employee->DeviceID != $DeviceID && $user_employee->DeviceID):
                    $data['status'] = FALSE;
                    $message = 'Device ID not match, Please contact your admin';
                endif;
            else:
                $data['status'] = FALSE;
                $message = 'The username/password you entered is incorrect';
            endif;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;

        return $user_employee;
    }

    public function SaveLeaveAndroid(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status']     = TRUE;
        $data['res_code']   = 500;// error
        $message            = "Incomplete Form";

        $CompanyID = $this->input->post("CompanyID");

        $StartDate = $this->input->post("StartDate");
        if($StartDate == ''):
            $data['inputerror'][] = 'StartDate';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Start time can`t be null';
            $data['status'] = FALSE;
        endif;

        $EndDate = $this->input->post("EndDate");
        if($StartDate == ''):
            $data['inputerror'][] = 'EndDate';
            $data['input_type'][] = '';
            $data['error_string'][] = 'End time can`t be null';
            $data['status'] = FALSE;
        endif;
        if($StartDate>$EndDate):
            $data['inputerror'][] = 'StartDate';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Start time greater than end time';
            $data['status'] = FALSE;
        endif;

        $Remark = $this->input->post('Remark');
        $Remark = trim($Remark);
        if(!$Remark):
            $data['inputerror'][] = 'Remark';
            $data['input_type'][] = '';
            $data['error_string'][] = "Remark can't be null";
            $data['status'] = FALSE;
        endif;

        $LeaveID = $this->input->post("LeaveID");
        $ck_leave = $this->db->count_all("mt_leave where CompanyID = '$CompanyID' and LeaveID = '$LeaveID'");
        if($ck_leave<=0):
            $data['inputerror'][] = 'LeaveID';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Leave type not found';
            $data['status'] = FALSE;
        endif;

        $CountPicture = $this->input->post("CountPicture");
        if($CountPicture<=0):
            $data['inputerror'][] = 'Picture';
            $data['input_type'][] = '';
            $data['error_string'][] = "Picture can't be null";
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function SaveOvertimeAndroid(){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status']     = TRUE;
        $data['res_code']   = 500;// error
        $message            = "Incomplete Form";

        $CompanyID = $this->input->post("CompanyID");
        $StartDate  = $this->input->post('StartDate');
        $StartTime  = $this->input->post('StartTime');
        $EndDate    = $this->input->post('EndDate');
        $EndTime    = $this->input->post('EndTime');

        $date1 = date("Y-m-d H:i", strtotime($StartDate." ".$StartTime));
        $date2 = date("Y-m-d H:i", strtotime($EndDate." ".$EndTime));

        if($date1>$date2):
            $data['status'] = FALSE;
            $message        = "Start time greater than end time";
        endif;

        $Remark = $this->input->post('Remark');
        if(!$Remark):
            $data['status'] = FALSE;
            $message        = $this->lang->line('lb_remark_null');
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function branch($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud           = $this->input->post("crud");
        $ID             = $this->input->post("ID");
        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $this->input->post('Company');
        endif;

        if($p1 == "users"):
            $ID = $this->session->UserID;
        endif;

        if(!$CompanyID):
            $data['inputerror'][] = 'Company';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_company_null');
            $data['status'] = FALSE;
        endif;

        $Name = $this->input->post('Name');
        if($Name == ''):
            $data['inputerror'][] = 'Name';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_name_null');
            $data['status'] = FALSE;
        endif;

        $Address = $this->input->post('Address');
        if($Address == ''):
            $data['inputerror'][] = 'Address';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_address_null');
            $data['status'] = FALSE;
        endif;

        $Radius = $this->input->post('Radius');
        if($Radius == ''):
            $data['inputerror'][] = 'Radius';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_radius_null');
            $data['status'] = FALSE;
        endif;

        $Latitude = $this->input->post('Latitude');
        if($Latitude == ''):
            $data['inputerror'][] = 'Latitude';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_latitude_null');
            $data['status'] = FALSE;
        endif;

        $Longidute = $this->input->post('Longidute');
        if($Longidute == ''):
            $data['inputerror'][] = 'Longidute';
            $data['input_type'][] = '';
            $data['error_string'][] = $this->lang->line('lb_longitude_null');
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function konstruksi($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                       = $this->input->post("crud");
        $ID                         = $this->input->post("ID");
        $Posisi                     = $this->input->post("Posisi");

        $PengalamanID 			    = $this->input->post("PengalamanID");
		$Nama_kegiatan 			    = $this->input->post("Nama_kegiatan");
		$Posisi_penugasan 		    = $this->input->post("Posisi_penugasan");
		$Status_kepegawaian 		= $this->input->post("Status_kepegawaian[]");
		$Status_kepegawaian2 		= $this->input->post("Status_kepegawaian2");

		$Pernyataan 	            = $this->input->post("Pernyataan");


        if(!$Posisi):
            $data['inputerror'][] = 'Posisi';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Posisi yang di usulkan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        foreach($PengalamanID as $key => $val) {
            
            if($Nama_kegiatan[$key] == ''):
                $data['inputerror'][] = 'Nama_kegiatan[]';
                $data['input_type'][] = '';
                $data['error_string'][] = 'Nama kegiatan tidak boleh kosong';
                $data['status'] = FALSE;
            endif;
            
            if($Posisi_penugasan[$key] == ''):
                $data['inputerror'][] = 'Posisi_penugasan[]';
                $data['input_type'][] = '';
                $data['error_string'][] = 'Posisi penugasan tidak boleh kosong';
                $data['status'] = FALSE;
            endif;
            
        }        

        // $status_gawai = array('Tetap','Tidak Tetap');
        // foreach ($Status_kepegawaian as $key => $val){
        //     if($Status_kepegawaian != in_array($status_gawai)):
        //         $data['inputerror'][]   = 'Status_kepegawaian';
        //         $data['input_type'][]   = 'input_group';
        //         $data['error_string'][] = 'Status kepegawaian tidak boleh kosong';
        //         $data['status'] = FALSE;
        //     endif;
        // }

        // print_r($Status_kepegawaian); exit();
        
        if($Status_kepegawaian == ''):
            $data['inputerror'][] = 'Status_kepegawaian';
            $data['input_type'][] = 'input_group';
            $data['error_string'][] = 'Status kepegawaian tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Status_kepegawaian2 == ''):
            $data['inputerror'][] = 'Status_kepegawaian2';
            $data['input_type'][] = 'input_group';
            $data['error_string'][] = 'Status kepegawaian tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Pernyataan == ''):
            $data['inputerror'][] = 'Pernyataan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Tidak bisa dilanjutkan karena anda tidak setuju dengan pernyataan diatas';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function export_konstruksi($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        // $Crud                       = $this->input->post("crud");
        $ID                         = $this->input->post("ID");
        $Posisi                     = $this->input->post("Posisi");

        $PengalamanID 			    = $this->input->post("PengalamanID");
		$Nama_kegiatan 			    = $this->input->post("Nama_kegiatan");
		$Posisi_penugasan 		    = $this->input->post("Posisi_penugasan");
		$Status_kepegawaian 		= $this->input->post("Status_kepegawaian[]");
		$Status_kepegawaian2 		= $this->input->post("Status_kepegawaian2");

		$Pernyataan 	            = $this->input->post("Pernyataan");


        if(!$Posisi):
            $data['inputerror'][] = 'Posisi';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Posisi yang di usulkan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;   

        // $status_gawai = array('Tetap','Tidak Tetap');
        // foreach ($Status_kepegawaian as $key => $val){
        //     if($Status_kepegawaian != in_array($status_gawai)):
        //         $data['inputerror'][]   = 'Status_kepegawaian';
        //         $data['input_type'][]   = 'input_group';
        //         $data['error_string'][] = 'Status kepegawaian tidak boleh kosong';
        //         $data['status'] = FALSE;
        //     endif;
        // }

        // print_r($Status_kepegawaian); exit();
        
        // if($Status_kepegawaian == ''):
        //     $data['inputerror'][] = 'Status_kepegawaian';
        //     $data['input_type'][] = 'input_group';
        //     $data['error_string'][] = 'Status kepegawaian tidak boleh kosong';
        //     $data['status'] = FALSE;
        // endif;

        // if($Status_kepegawaian2 == ''):
        //     $data['inputerror'][] = 'Status_kepegawaian2';
        //     $data['input_type'][] = 'input_group';
        //     $data['error_string'][] = 'Status kepegawaian tidak boleh kosong';
        //     $data['status'] = FALSE;
        // endif;

        // if($Pernyataan == ''):
        //     $data['inputerror'][] = 'Pernyataan';
        //     $data['input_type'][] = '';
        //     $data['error_string'][] = 'Tidak bisa dilanjutkan karena anda tidak setuju dengan pernyataan diatas';
        //     $data['status'] = FALSE;
        // endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function non_konstruksi($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                   = $this->input->post("crud");
        $ID                     = $this->input->post("ID");
        $Posisi                 = $this->input->post("Posisi");
        // $Nama_perusahaan        = $this->input->post("Nama_perusahaan");
        // $Nama_personil 			= $this->input->post("Nama_personil");
		// $Tempat_tanggal_lahir 	= $this->input->post("Tempat_tanggal_lahir");
		// $Pendidikan 			= $this->input->post("Pendidikan");
		// $Pendidikan_non_formal 	= $this->input->post("Pendidikan_non_formal");

        $PengalamanID 			    = $this->input->post("PengalamanID");
		$Nama_kegiatan 			    = $this->input->post("Nama_kegiatan");
		$Penguasaan_bahasa_indo 	= $this->input->post("Penguasaan_bahasa_indo");
		$Penguasaan_bahasa_inggris 	= $this->input->post("Penguasaan_bahasa_inggris");
		$Penguasaan_bahasa_setempat = $this->input->post("Penguasaan_bahasa_setempat");
		// $Lokasi_kegiatan 		= $this->input->post("Lokasi_kegiatan");
		// $Pengguna_jasa 			= $this->input->post("Pengguna_jasa");
		// $Nama_perusahaan 		= $this->input->post("Nama_perusahaan");
		// $Uraian_tugas 			= $this->input->post("Uraian_tugas");
		// $Waktu_pelaksanaan 		= $this->input->post("Waktu_pelaksanaan");
		$Posisi_penugasan 		    = $this->input->post("Posisi_penugasan");

		$Pernyataan 	            = $this->input->post("Pernyataan");
		// $Surat_referensi 		= $this->input->post("Surat_referensi");


        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $this->input->post('Company');
        endif;

        if($p1 == "users"):
            $ID = $this->session->UserID;
        endif;

        if(!$Posisi):
            $data['inputerror'][] = 'Posisi';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Posisi yang di usulkan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;
        
        foreach($PengalamanID as $key => $val) {
            if($Nama_kegiatan[$key] == ''):
                $data['inputerror'][] = 'Nama_kegiatan[]';
                $data['input_type'][] = '';
                $data['error_string'][] = 'Nama kegiatan tidak boleh kosong';
                $data['status'] = FALSE;
            endif;

            if($Posisi_penugasan[$key] == ''):
                $data['inputerror'][] = 'Posisi_penugasan[]';
                $data['input_type'][] = '';
                $data['error_string'][] = 'Posisi penugasan tidak boleh kosong';
                $data['status'] = FALSE;
            endif;
        }

        if($Pernyataan == ''):
            $data['inputerror'][] = 'Pernyataan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Tidak bisa dilanjutkan karena anda tidak setuju dengan pernyataan diatas';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function pengalaman_kerja($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                   = $this->input->post("crud");
        $ID                     = $this->input->post("ID");
        $Posisi                 = $this->input->post("Posisi");

        $PengalamanID 		    = $this->input->post("PengalamanID");
		$Nama_kegiatan 		    = $this->input->post("Nama_kegiatan");
		$Lokasi_kegiatan 	    = $this->input->post("Lokasi_kegiatan");
		$Pengguna_jasa 	        = $this->input->post("Pengguna_jasa");
		$Nama_perusahaan 	    = $this->input->post("Nama_perusahaan");
        
        if($Nama_kegiatan == ''):
            $data['inputerror'][] = 'Nama_kegiatan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama kegiatan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Lokasi_kegiatan == ''):
            $data['inputerror'][] = 'Lokasi_kegiatan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Lokasi kegiatan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Pengguna_jasa == ''):
            $data['inputerror'][] = 'Pengguna_jasa';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Pengguna jasa tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Nama_perusahaan == ''):
            $data['inputerror'][] = 'Nama_perusahaan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama perusahaan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }
    
    public function upload_cv($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                   = $this->input->post("crud");
        $ID                     = $this->input->post("ID");

		$Nama_kegiatan 		    = $this->input->post("Nama_kegiatan");
		$Pengguna_jasa 	        = $this->input->post("Pengguna_jasa");
		$Tanggal_tender 	    = $this->input->post("Tanggal_tender");
        
        if($Nama_kegiatan == ''):
            $data['inputerror'][] = 'Nama_kegiatan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama kegiatan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Pengguna_jasa == ''):
            $data['inputerror'][] = 'Pengguna_jasa';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Pengguna jasa tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Tanggal_tender == ''):
            $data['inputerror'][] = 'Tanggal_tender';
            $data['input_type'][] = 'input_group';
            $data['error_string'][] = 'Tanggal tender tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function poisi_uraian($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                   = $this->input->post("crud");
        $ID                     = $this->input->post("ID");
        $Posisi                 = $this->input->post("Posisi");

        $Posisi_penugasan 		= $this->input->post("Posisi_penugasan");

        $Uraian_pengalaman 		= $this->input->post("Uraian_pengalaman");

        if($Posisi_penugasan == ''):
            $data['inputerror'][] = 'Posisi_penugasan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Posisi penugasan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        $pattern = "/;/i";
        if (!preg_match_all($pattern, $Uraian_pengalaman)):
            $data['inputerror'][] = 'Uraian_pengalaman';
            $data['input_type'][] = 'input_group';
            $data['error_string'][] = 'Format uraian tugas tidak sesuai';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function sdm_pegawai_ciriajasa($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                   = $this->input->post("crud");
        $ID                     = $this->input->post("ID");
        $Posisi                 = $this->input->post("Posisi");

        $Nama 		            = $this->input->post("Nama");
        $Nama_perusahaan 		= $this->input->post("Nama_perusahaan");
        $Proyek 		        = $this->input->post("Proyek");

        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $this->input->post('Company');
        endif;

        if($p1 == "users"):
            $ID = $this->session->UserID;
        endif;
        
        if($Nama == ''):
            $data['inputerror'][] = 'Nama';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Nama_perusahaan == ''):
            $data['inputerror'][] = 'Nama_perusahaan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama perusahaan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Proyek == ''):
            $data['inputerror'][] = 'Proyek';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Proyek tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function sdm_pegawai_non_ciriajasa($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                   = $this->input->post("crud");
        $ID                     = $this->input->post("ID");
        $Posisi                 = $this->input->post("Posisi");

        $Nama 		            = $this->input->post("Nama");
        $Nama_perusahaan 		= $this->input->post("Nama_perusahaan");
        $Proyek 		        = $this->input->post("Proyek");

        $HakAksesType   = $this->session->HakAksesType;
        $CompanyID      = $this->session->CompanyID;

        if(in_array($HakAksesType, array(1,2))):
            $CompanyID = $this->input->post('Company');
        endif;

        if($p1 == "users"):
            $ID = $this->session->UserID;
        endif;
        
        if($Nama == ''):
            $data['inputerror'][] = 'Nama';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Nama_perusahaan == ''):
            $data['inputerror'][] = 'Nama_perusahaan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama perusahaan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Proyek == ''):
            $data['inputerror'][] = 'Proyek';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Proyek tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }

    public function pendidikan($p1=""){
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['input_type'] = array();
        $data['status'] = TRUE;
        $message = $this->lang->line('lb_incomplate_form');

        $Crud                   = $this->input->post("crud");
        $ID                     = $this->input->post("ID");
        
        $Posisi 			    = $this->input->post("Posisi");
        $Nama_personil 			= $this->input->post("Nama_personil");
        $Nama_perusahaan 	    = $this->input->post("Nama_perusahaan");
		$Tempat_tanggal_lahir 	= $this->input->post("Tempat_tanggal_lahir");
		$Pendidikan 			= $this->input->post("Pendidikan");
		$Pendidikan_non_formal 	= $this->input->post("Pendidikan_non_formal");

        if($Posisi == ''):
            $data['inputerror'][] = 'Posisi';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Posisi yang diusulkan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Nama_personil == ''):
            $data['inputerror'][] = 'Nama_personil';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama personil tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Nama_perusahaan == ''):
            $data['inputerror'][] = 'Nama_perusahaan';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Nama perusahaan tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($Tempat_tanggal_lahir == ''):
            $data['inputerror'][] = 'Tempat_tanggal_lahir';
            $data['input_type'][] = '';
            $data['error_string'][] = 'Tempat tanggal lahir tidak boleh kosong';
            $data['status'] = FALSE;
        endif;

        if($data['status'] === FALSE):
            $data['message'] = $message;
            echo json_encode($data);
            exit();
        endif;
    }
}