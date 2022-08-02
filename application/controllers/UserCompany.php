<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserCompany extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_user_company","users");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "user_company";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = ''; $btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;

		$data["title"] 		= $this->lang->line('lb_users');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/user_company/list';
		$data['form']		= 'backend/user_company/form';
		$data['filter']		= 'backend/user_company/filter';
		$data['import']		= 'backend/user_company/import';
		$data['btn_add']	= $btn_add;
		$data['btn_import']	= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function user_profile(){
		$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "user_company";
		$HakAksesType 		= $this->session->HakAksesType;
		if(in_array($HakAksesType,array(1,2,3))): redirect('403_override'); endif;

		$data["title"] 		= $this->lang->line('lb_profile');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/user_company/user_profile';
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->users->get_datatables();
		$i 		= $this->input->post('start');

		$url 		= $this->input->post('page_url');
		$module 	= $this->input->post('page_module');
		$MenuID 	= $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);

		foreach ($list as $a):
			$no = $i++;
			$no += 1;
			$txt_status = $this->main->label_active($a->Status);
			$tg_data = ' data-id="'.$a->EmployeeID.'" ';
			$tg_data .= ' data-status="'.$a->Status.'" ';

			$btn_array = array();
			$btn_status = false;
			if($read_menu->update>0):
				$btn_status = true;
				array_push($btn_array, 'edit');
			endif;
			if($a->Status == 1 and $read_menu->delete>0):
				$btn_status = true;
				array_push($btn_array, 'nonactive');
			elseif($a->Status == 0 and $read_menu->delete>0):
				$btn_status = true;
				array_push($btn_array, 'active');
			endif;

			$device = '<span class=" txt-danger">'.$this->lang->line('lb_nonactive').'</span>';
			if($a->DeviceID and $a->ImeiDefault == 1):
				$device = '<span class=" txt-success">'.$this->lang->line('lb_active').'</span>';
				if($read_menu->update>0):
					$btn_status = true;
					array_push($btn_array, 'reset_device');
				endif;
			endif;

			if($btn_status):
				$btn = $this->main->button('action_list',$a->EmployeeID,$btn_array);
			else:
				$btn = '';
			endif;
			$temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';
			
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= $a->BranchName;
			$row[] 	= $a->Name;
			$row[] 	= $this->main->label_gender($a->Gender);
			$row[] 	= $a->Email;
			$row[] 	= $a->RoleName;
			$row[] 	= $device;
			$row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->users->count_all(),
			"recordsFiltered" 	=> $this->users->count_filtered(),
			"data" 				=> $data,
		);

		$this->main->echoJson($response);
	}

	public function save(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);

		$Crud 		= $this->input->post("crud");
		if($Crud == "insert"): $p3 = $read_menu->insert;
		elseif($Crud == "update"): $p3 = $read_menu->update;
		else: $p3 = 0;
		endif;

		$this->main->check_session('out',$Crud, $p3);
		$this->validation->user_company();

		$ID 		= $this->input->post("ID");
		$Name 		= $this->input->post("Name");
		$NameLast 	= $this->input->post("NameLast");
		$Email 		= $this->input->post("Email");
		$Username 	= $this->input->post("Username");
		$Role 		= $this->input->post("Role");
		$Password 	= $this->input->post("Password");
		$Company 	= $this->input->post('Company');
		$Gender 	= $this->input->post('Gender');
		$WorkDate 	= $this->input->post('WorkDate');
		$Phone 		= $this->input->post('Phone');
		$Imei 		= $this->input->post('Imei');
		$Pattern 	= $this->input->post('Pattern');
		$Parent 	= $this->input->post('Parent');
		$BranchID 	= $this->input->post('Branch');
		$Departement 	= $this->input->post('Departement');
		$Website 		= $this->input->post('Website');
		$PhoneCountry 	= $this->input->post('PhoneCountry');
		$default_imei 	= $this->input->post('default_imei');
		$Nik 			= $this->input->post('Nik');
		$Position 		= $this->input->post('Position');
		$CompanyID 		= $this->session->CompanyID;
		$HakAksesType   = $this->session->HakAksesType;

		if($default_imei): $default_imei = 1; else: $default_imei = 0; endif;
		if(in_array($HakAksesType,array(1,2))): $CompanyID = $Company; endif;
		if(!$Parent): $Parent = null; endif;
		if(!$Website): $Website = 0; endif;

		$Image = $this->save_image();

		$data = array(
			"CompanyID"			=> $CompanyID,
			"BranchID"			=> $BranchID,
			"Name"				=> $Name,
			"NameLast"			=> $NameLast,
			"Departement"		=> $Departement,
			"Email"				=> $Email,
			"Username" 			=> $Username,
			"RoleID"			=> $Role,
			"PhoneCountry"		=> $PhoneCountry,
			"Phone"				=> $Phone,
			"StartWork"			=> $WorkDate,
			// "Imei"				=> $Imei,
			"Gender"			=> $Gender,
			"ImeiDefault"		=> $default_imei,
			"WorkPatternID"		=> $Pattern,
			"ParentID"			=> $Parent,
			"Web" 				=> $Website,
			"Nik" 				=> $Nik,
			"Position" 			=> $Position,
		);
		if($Image):
			$data['Image']  = $Image;
		endif;
		if($Crud == "insert"):
			$Password = $this->main->create_password($Password);
			$data['Password'] 	= $Password;
			$data['Status'] 	= 1;
			$message = $this->lang->line('lb_success_insert');
			$ID = $this->main->general_save("mt_employee", $data);
			$this->main->inser_log(1,2,'user_company', $ID);//$LogType,$Type,$Page,$Content=""
		elseif($Crud == "update"):
			if($Password):
				$Password = $this->main->create_password($Password);
				$data['Password'] = $Password;
			endif;
			$message = $this->lang->line('lb_success_update');
			$this->main->general_update("mt_employee", $data, array("EmployeeID" => $ID));
			$this->main->inser_log(1,3,'user_company', $ID);//$LogType,$Type,$Page,$Content=""
		endif;

		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

	public function edit(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		$this->main->check_session('out', 'update', $read_menu->update);
		$ID 		= $this->input->post('ID');
		$list 		= $this->users->get_by_id($ID);

		$response = array(
			"status"	=> true,
			"data"		=> $list,
			"message"	=> $this->lang->line('lb_success'),
		);

		$this->main->echoJson($response);
	}

	public function active(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);

		$this->main->check_session('out', 'delete', $read_menu->delete);
		$ID 		= $this->input->post('ID');
		$Status 	= $this->input->post('Status');
		$Active 	= 1;
		$message 	= $this->lang->line('lb_success_active');

		if($Status == 1):
			$Active  = 0;
			$message = $this->lang->line('lb_success_nonactive');
		endif;

		$data = array(
			"Status"	=> $Active,
		);
		$HakAksesType   = $this->session->HakAksesType;
		$CompanyID 		= $this->session->CompanyID;
		if(!in_array($HakAksesType, array(1,2))):
			$this->main->general_update("mt_employee", $data, array("EmployeeID" => $ID, "CompanyID" => $CompanyID));
		else:
			$this->main->general_update("mt_employee", $data, array("EmployeeID" => $ID));
		endif;

		if($Active == 1):
			$this->main->inser_log(1,6,'user_company', $ID);//$LogType,$Type,$Page,$Content=""
		else:
			$this->main->inser_log(1,7,'user_company', $ID);//$LogType,$Type,$Page,$Content=""
		endif;
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}

	public function reset_device(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);

		$this->main->check_session('out', 'delete', $read_menu->delete);
		$ID 		= $this->input->post('ID');
		$Status 	= $this->input->post('Status');
		$Active 	= 1;
		$message 	= $this->lang->line('lb_success_update');

		$data = array(
			"DeviceID"	=> null,
		);
		$HakAksesType   = $this->session->HakAksesType;
		$CompanyID 		= $this->session->CompanyID;
		if(!in_array($HakAksesType, array(1,2))):
			$this->main->general_update("mt_employee", $data, array("EmployeeID" => $ID, "CompanyID" => $CompanyID));
		else:
			$this->main->general_update("mt_employee", $data, array("EmployeeID" => $ID));
		endif;
		$this->main->inser_log(1,3,'user_company', $ID);//$LogType,$Type,$Page,$Content=""
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

	private function save_image($p1=''){

		$nmfile                     = "alpa_".date("ymdHis");
	    $config['upload_path']      = './img/employee'; //path folder 
	    $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp|PNG|JPG'; //type yang dapat diakses bisa anda sesuaikan 
	    $config['max_size']         = '99999'; //maksimum besar file 2M 
	    $config['max_width']        = '99999'; //lebar maksimum 1288 px 
	    $config['max_height']       = '99999'; //tinggi maksimu 768 px 
	    $config['file_name']        = $nmfile; //nama yang terupload nantinya 
	    $this->upload->initialize($config); 
	    $upload                     = $this->upload->do_upload('photo');
	    $gbr                        = $this->upload->data();

	    $Crud 		= $this->input->post("crud");
	    $ID 		= $this->input->post("ID");
	    $Company 	= $this->input->post('Company');
		$CompanyID 		= $this->session->CompanyID;
		$HakAksesType   = $this->session->HakAksesType;
	    
	    if($p1 == 'users'):
	    	$ID = $this->session->UserID;
	    endif;

	    $image = '';
	    if($upload):
	    	$image 	= "img/employee/".$gbr['file_name'];
	    	if($Crud == "update"):
	    		if(in_array($HakAksesType,array(1,2))):
	    			$this->main->remove_file("mt_employee","Image",array("EmployeeID" => $ID));
	    		else:
	    			$this->main->remove_file("mt_employee","Image",array("EmployeeID" => $ID, "CompanyID" => $CompanyID));
	    		endif;
	    	endif;
	    endif;

	    return $image;
	}

	public function export(){
		$this->users->export();
	}

	public function template_import(){
		$this->users->export('template');
	}

	public function save_import(){
		$p1 = $this->input->post('p1');
		if($p1 == 'save'):
			$this->proccess_save_import();
		else:
			$this->upload_import();
		endif;
	}

	private function upload_import(){

		$this->validation->user_company_import();
		$HakAksesType   = $this->session->HakAksesType;
		$CompanyID 		= $this->session->CompanyID;
		if(in_array($HakAksesType, array(1,2))):
			$CompanyID 		= $this->input->post('Company');
		endif;
		$folder = $this->main->create_folder_general('import_users');

		$nmfile                     = "hadir_".date("ymdHis");
	    $config['upload_path']      = './'.$folder; //path folder
	    $config['file_name']      	= $nmfile;
		$config['allowed_types']  	= 'xls|xlsx|csv|ods|ots';
		$config['max_size']       	= 10000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')):
			$output = array(
				"status" 	=> false,
				"message"	=> $this->lang->line('lb_excell_empty'),
			);
		else:
			$media 			= $this->upload->data();
			$inputFileName 	= $folder.$media['file_name'];
			try {
				$inputFileType  = IOFactory::identify($inputFileName);
				$objReader      = IOFactory::createReader($inputFileType);
				$objPHPExcel  	= $objReader->load($inputFileName);
			}
			catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			$sheet         = $objPHPExcel->getSheet(0);
			$highestRow    = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			$status    = true;
			$message   = "success";

			$arrData   = array();
			$arrHeader = array(); 
			$rowData   = $sheet->rangeToArray('A' . 1 . ':' . $highestColumn . 1,NULL,TRUE,FALSE);

			if($rowData): $arrHeader = $rowData; endif;
			$total_data = 0;
			$arrName 	= array();
			$arrEmail 	= array();
			$arrUsername= array();
			for ($row = 2; $row <= $highestRow; $row++){
				$total_data += 1;
				$rowData 		= $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

				if(count($rowData[0]) == 14):
					$arrMandatory_imei 	  = array('yes','no');
					$arrGender 	  		  = array('male','female');

					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";
					$Nik 			= $this->main->checkInputData($rowData[0][0]);
					$Name 			= $this->main->checkInputData($rowData[0][1]);
					$Gender 		= $this->main->checkInputData($rowData[0][2]);
					$Email 			= $this->main->checkInputData($rowData[0][3]);
					$WorkDate 		= $this->main->checkInputData($rowData[0][4]);
					$Iso 			= $this->main->checkInputData($rowData[0][5]);
					$Phone 			= $this->main->checkInputData($rowData[0][6]);
					$Pattern 		= $this->main->checkInputData($rowData[0][7]);
					$Parent 		= $this->main->checkInputData($rowData[0][8]);
					$Username 		= $this->main->checkInputData($rowData[0][9]);
					$Password 		= $this->main->checkInputData($rowData[0][10]);
					$Role 			= $this->main->checkInputData($rowData[0][11]);
					$ImeiDefault 	= $this->main->checkInputData($rowData[0][12]);
					$BranchID 		= $this->main->checkInputData($rowData[0][13]);
					$BranchID 		= trim($BranchID);
					$Role 			= trim($Role);

					$ck_name = $this->db->count_all("mt_employee where CompanyID = '$CompanyID' and Name = '$Name'");
					if(!$Name):
						$status_product = false;
						$Message .= "- ".$this->lang->line('lb_name_null')."<br>";
					elseif($ck_name>0):
						$status_product = false;
						$Message .= "- "."Name already exists"."<br>";
					elseif(in_array($Name,$arrName)):
						$status_product = false;
						$Message .= "- "."Duplicate Name"."<br>";
					endif;
					array_push($arrName,$Name);

					$Gender = strtolower($Gender);
					if(!in_array($Gender,$arrGender)):
						$status_product = false;
						$Message .= "- "."Gender not match"."<br>";
					endif;

					$ck_email = $this->db->count_all("mt_employee where CompanyID = '$CompanyID' and Email = '$Email'");
					if(!$Email):
						$status_product = false;
						$Message .= "- ".$this->lang->line('lb_email_null')."<br>";
					elseif($ck_email>0):
						$status_product = false;
						$Message .= "- ".$this->lang->line('lb_email_already')."<br>";
					elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)):
						$status_product = false;
						$Message .= "- ".$this->lang->line('lb_email_validate')."<br>";
					elseif(in_array($Email,$arrEmail)):
						$status_product = false;
						$Message .= "- "."Duplicate Email"."<br>";
					endif;
					array_push($arrEmail, $Email);

			        if(!$WorkDate):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_work_date_null')."<br>";
			        endif;

			        if(!$Iso):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_iso_null')."<br>";
			        endif;

			        if(!$Phone):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_phone_null')."<br>";
			        endif;

			        $ck_pattern = $this->db->count_all("mt_workpattern where CompanyID = '$CompanyID' and Name = '$Pattern' and Status = '1'");
			        if(!$ck_pattern):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_work_pattern_null')."<br>";
			        elseif($ck_pattern<1):
			        	$status_product = false;
						$Message .= "- "."Work Pattern not found"."<br>";
			        endif;

			        $ck_branch = $this->api->get_one_row("mt_branch", "Status", array("CompanyID" => $CompanyID, "Name"	=> $BranchID));
			        if($ck_branch):
			        	if($ck_branch->Status != 1):
			        		$status_product = false;
							$Message .= "- "."Branch is inactive"."<br>";
			        	endif;
			        else:
			        	$status_product = false;
						$Message .= "- "."Branch not found"."<br>";
			        endif;

			        if($Parent):
			        	$ck_parent = $this->db->count_all("mt_employee where CompanyID = '$CompanyID' and Name = '$Parent' and Status = '1'");
			        	if($ck_parent<1):
			        		$status_product = false;
							$Message .= "- "."Parent User not found"."<br>";
			        	endif;
			        endif;

			        if(!$Username):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_username_null')."<br>";
			        elseif(strlen($Username)<6):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_username_max')."<br>";
					elseif(in_array($Username,$arrUsername)):
						$status_product = false;
						$Message .= "- "."Duplicate Username"."<br>";
			        endif;
			        array_push($arrUsername, $Username);

			        if(!$Password):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_password_null')."<br>";
			        elseif($Password):
			            if(strlen($Password)<8):
			            	$status_product = false;
							$Message .= "- ".$this->lang->line('lb_password_max')."<br>";
			            elseif(!preg_match("#[0-9]+#", $Password)):
			            	$status_product = false;
							$Message .= "- ".$this->lang->line('lb_password_numb')."<br>";
			            elseif(!preg_match("#[A-Z]+#", $Password)):
			            	$status_product = false;
							$Message .= "- ".$this->lang->line('lb_password_upper')."<br>";
			            elseif(!preg_match("#[a-z]+#", $Password)):
			            	$status_product = false;
							$Message .= "- ".$this->lang->line('lb_password_lower')."<br>";
			            endif;
			        endif;

			        $ck_role = $this->db->count_all("ut_role where CompanyID = '$CompanyID' and Name = '$Role' and Status = '1'");
			        if(!$Role):
			        	$status_product = false;
						$Message .= "- ".$this->lang->line('lb_role_null')."<br>";
			        elseif($ck_role<1):
			        	$status_product = false;
						$Message .= "- "."Role not found"."<br>";
			        endif;

			        $ImeiDefault = strtolower($ImeiDefault);
			        if(!in_array($ImeiDefault, $arrMandatory_imei)):
			        	$status_product = false;
						$Message .= "- "."Mandatory imei not found"."<br>";
			        endif;

			   //      if(!$Imei and $ImeiDefault == 'yes'):
			   //      	$status_product = false;
						// $Message .= "- ".$this->lang->line('lb_imei_null')."<br>";
			   //      endif;

			        $h = array(
				    	"status"		=> $status_product,
				    	"status_data"	=> $status_data,
				    	"Nik"  			=> $Nik,
				    	"Name"  		=> $Name,
				    	"Gender"  		=> $Gender,
				    	"WorkDate"  	=> $WorkDate,
				    	"Email"  		=> $Email,
				    	"Iso"  			=> $Iso,
				    	"Phone"  		=> $Phone,
				    	"Pattern"  		=> $Pattern,
				    	"Parent"  		=> $Parent,
				    	"Username"  	=> $Username,
				    	"Password"  	=> $Password,
				    	"Role"  		=> $Role,
				    	"ImeiDefault"  	=> $ImeiDefault,
				    	"BranchID"  	=> $BranchID,
				    	"Message" 		=> $Message,
				    );

				    array_push($arrData, $h);


				else:
					$status  = false;
					$message = $this->lang->line('lb_column_not_match');
				endif;
			}

			if($total_data<=0):
				$status = false;
				$message = $this->lang->line('lb_data_not_found');
			endif;

			$output = array(
				"status" 	 	=> $status,
				"message"		=> $message,
				"data"		 	=> $arrData,
				"header"	 	=> $arrHeader,
				"inputFileName" => $inputFileName,
				"CompanyID"		=> $CompanyID,
			);
		endif;

		$this->main->echoJson($output);
	}

	private function proccess_save_import(){
		$CompanyID 		= $this->input->post('CompanyID');
		$inputFileName 	= $this->input->post('inputFileName');

		if(is_file("./".$inputFileName)):
			$status  = true;
			$message = $this->lang->line('lb_success_import');

			try {
				$inputFileType  = IOFactory::identify($inputFileName);
				$objReader      = IOFactory::createReader($inputFileType);
				$objPHPExcel  	= $objReader->load($inputFileName);
			}
			catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			$sheet         = $objPHPExcel->getSheet(0);
			$highestRow    = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			$arrData   = array();
			$arrHeader = array(); 
			$rowData   = $sheet->rangeToArray('A' . 1 . ':' . $highestColumn . 1,NULL,TRUE,FALSE);
			if($rowData): $arrHeader = $rowData; endif;
			$total_data = 0;
			$arrName 	= array();
			$arrEmail 	= array();
			$arrUsername= array();
			for ($row = 2; $row <= $highestRow; $row++){
				$total_data += 1;
				$rowData 		= $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

				if(count($rowData[0]) == 14):
					$arrMandatory_imei 	  = array('yes','no');
					$arrGender 	  		  = array('male','female');

					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";
					$Nik 			= $this->main->checkInputData($rowData[0][0]);
					$Name 			= $this->main->checkInputData($rowData[0][1]);
					$Gender 		= $this->main->checkInputData($rowData[0][2]);
					$Email 			= $this->main->checkInputData($rowData[0][3]);
					$WorkDate 		= $this->main->checkInputData($rowData[0][4]);
					$Iso 			= $this->main->checkInputData($rowData[0][5]);
					$Phone 			= $this->main->checkInputData($rowData[0][6]);
					$Pattern 		= $this->main->checkInputData($rowData[0][7]);
					$Parent 		= $this->main->checkInputData($rowData[0][8]);
					$Username 		= $this->main->checkInputData($rowData[0][9]);
					$Password 		= $this->main->checkInputData($rowData[0][10]);
					$Role 			= $this->main->checkInputData($rowData[0][11]);
					// $Imei 			= $this->main->checkInputData($rowData[0][12]);
					$ImeiDefault 	= $this->main->checkInputData($rowData[0][12]);
					$BranchID 		= $this->main->checkInputData($rowData[0][13]);
					$BranchID 		= trim($BranchID);
					$Role 			= trim($Role);

					$ck_name = $this->db->count_all("mt_employee where CompanyID = '$CompanyID' and Name = '$Name'");
					if(!$Name):
						$status_product = false;
					elseif($ck_name>0):
						$status_product = false;
					elseif(in_array($Name,$arrName)):
						$status_product = false;
					endif;
					array_push($arrName,$Name);

					$Gender = strtolower($Gender);
					if(!in_array($Gender,$arrGender)):
						$status_product = false;
					endif;

					$ck_email = $this->db->count_all("mt_employee where CompanyID = '$CompanyID' and Email = '$Email'");
					if(!$Email):
						$status_product = false;
					elseif($ck_email>0):
						$status_product = false;
					elseif(!filter_var($Email, FILTER_VALIDATE_EMAIL)):
						$status_product = false;
					elseif(in_array($Email,$arrEmail)):
						$status_product = false;
					endif;
					array_push($arrEmail, $Email);

			        if(!$WorkDate):
			        	$status_product = false;
			        endif;

			        if(!$Iso):
			        	$status_product = false;
			        endif;

			        if(!$Phone):
			        	$status_product = false;
			        endif;

			        $ck_pattern = $this->db->count_all("mt_workpattern where CompanyID = '$CompanyID' and Name = '$Pattern' and Status = '1'");
			        if(!$ck_pattern):
			        	$status_product = false;
			        elseif($ck_pattern<1):
			        	$status_product = false;
			        endif;

			        $ck_branch = $this->api->get_one_row("mt_branch", "Status,BranchID", array("CompanyID" => $CompanyID, "Name"	=> $BranchID));
			        if($ck_branch):
			        	if($ck_branch->Status != 1):
			        		$status_product = false;
			        	endif;
			        else:
			        	$status_product = false;
			        endif;

			        if($Parent):
			        	$ck_parent = $this->db->count_all("mt_employee where CompanyID = '$CompanyID' and Name = '$Parent' and Status = '1'");
			        	if($ck_parent<1):
			        		$status_product = false;
			        	endif;
			        endif;

			        if(!$Username):
			        	$status_product = false;
			        elseif(strlen($Username)<6):
			        	$status_product = false;
					elseif(in_array($Username,$arrUsername)):
						$status_product = false;
			        endif;
			        array_push($arrUsername, $Username);

			        if(!$Password):
			        	$status_product = false;
			        elseif($Password):
			            if(strlen($Password)<8):
			            	$status_product = false;
			            elseif(!preg_match("#[0-9]+#", $Password)):
			            	$status_product = false;
			            elseif(!preg_match("#[A-Z]+#", $Password)):
			            	$status_product = false;
			            elseif(!preg_match("#[a-z]+#", $Password)):
			            	$status_product = false;
			            endif;
			        endif;

			        $ck_role = $this->db->count_all("ut_role where CompanyID = '$CompanyID' and Name = '$Role' and Status = '1'");
			        if(!$Role):
			        	$status_product = false;
			        elseif($ck_role<1):
			        	$status_product = false;
			        endif;

			        $ImeiDefault = strtolower($ImeiDefault);
			        if(!in_array($ImeiDefault, $arrMandatory_imei)):
			        	$status_product = false;
			        endif;

			        // if(!$Imei and $ImeiDefault == 'yes'):
			        // 	$status_product = false;
			        // endif;

			        if($status_product):
			        	$RoleID = $this->api->get_one_row("ut_role","RoleID",array("CompanyID" => $CompanyID,"Name" => $Role, "Status" => "1"))->RoleID;
			        	$WorkPatternID = $this->api->get_one_row("mt_workpattern","WorkPatternID",array("CompanyID" => $CompanyID,"Name" => $Pattern, "Status" => "1"))->WorkPatternID;
			        	if($Parent):
			        		$ParentID = $this->api->get_one_row("mt_employee","EmployeeID",array("CompanyID" => $CompanyID,"Name" => $Parent, "Status" => "1"))->EmployeeID;
			        	else:
			        		$ParentID = null;
			        	endif;
			        	if($Gender == 'male'):$Gender = 0;else:$Gender = 1;endif;
			        	if($ImeiDefault == 'yes'): $ImeiDefault = 1; else: $ImeiDefault = 0; endif;
			        	$data_user = array(
			        		'CompanyID'		=> $CompanyID,
			        		'Nik'			=> $Nik,
			        		'Name'			=> $Name,
			        		'Email'			=> $Email,
			        		'Phone'			=> $Phone,
			        		'PhoneCountry' 	=> $Iso,
			        		'ParentID' 		=> $ParentID,
			        		"WorkPatternID"	=> $WorkPatternID,
			        		// "Imei"			=> $Imei,
			        		"StartWork"		=> $WorkDate,
			        		"Username"		=> $Username,
			        		"Password"		=> $this->main->create_password($Password),
			        		"RoleID"		=> $RoleID,
			        		"Gender" 		=> $Gender,
			        		"ImeiDefault"	=> $ImeiDefault,
			        		"Status"		=> 1,
			        		"BranchID"		=> $ck_branch->BranchID,
			        	);
			        	$ID = $this->main->general_save("mt_employee", $data_user);
			        	$this->main->inser_log(1,2,'user_company', $ID);//$LogType,$Type,$Page,$Content=""
			        endif;
				endif;
			}

			$output = array(
				"status" 	 	=> $status,
				"message"		=> $message,
			);
		else:
			$status  = false;
			$message = $this->lang->line('lb_file_not_found');
		endif;

		$output = array(
			"status" 	=> $status,
			"message"	=> $message,
		);

		$this->main->echoJson($output);
	}

	public function user_edit_save(){
		$Crud 	= "update";
		$p3 	= 1;

		$this->main->check_session('out',$Crud, $p3);
		$this->validation->user_company("users");

		$CompanyID 			= $this->session->CompanyID;
		$UserID 			= $this->session->UserID;

		$ID 		= $this->input->post("ID");
		$Name 		= $this->input->post("Name");
		$NameLast 	= $this->input->post("NameLast");
		$Email 		= $this->input->post("Email");
		$Username 	= $this->input->post("Username");
		$Role 		= $this->input->post("Role");
		$Password 	= $this->input->post("Password");
		$Company 	= $this->input->post('Company');
		$Gender 	= $this->input->post('Gender');
		$WorkDate 	= $this->input->post('WorkDate');
		$Phone 		= $this->input->post('Phone');
		$Imei 		= $this->input->post('Imei');
		$Pattern 	= $this->input->post('Pattern');
		$Parent 	= $this->input->post('Parent');
		$Departement 	= $this->input->post('Departement');
		$Website 		= $this->input->post('Website');
		$PhoneCountry 	= $this->input->post('PhoneCountry');
		$default_imei 	= $this->input->post('default_imei');
		$Nik 			= $this->input->post('Nik');
		$Position 		= $this->input->post('Position');
		$CompanyID 		= $this->session->CompanyID;
		$HakAksesType   = $this->session->HakAksesType;

		if($default_imei): $default_imei = 1; else: $default_imei = 0; endif;
		if(in_array($HakAksesType,array(1,2))): $CompanyID = $Company; endif;
		if(!$Parent): $Parent = null; endif;
		if(!$Website): $Website = 0; endif;

		$Image = $this->save_image("users");

		$data = array(
			"Name"				=> $Name,
			"NameLast"			=> $NameLast,
			"Departement"		=> $Departement,
			"Username" 			=> $Username,
			"Phone"				=> $Phone,
			"Gender"			=> $Gender,
		);
		if($Image):
			$data['Image']  = $Image;
		endif;
		if($Password):
			$Password = $this->main->create_password($Password);
			$data['Password'] = $Password;
		endif;
		$message = $this->lang->line('lb_success_update');
		$this->main->general_update("mt_employee", $data, array("EmployeeID" => $UserID));
		$this->main->inser_log(1,3,'user_company', $UserID);//$LogType,$Type,$Page,$Content=""

		$data = array(
            'Name'              => $Name,
            'NameLast'          => $NameLast,
            'Phone'             => $Phone,
            'Departement'       => $Departement,
            'Position'       	=> $Position,
            'Username'          => $Username,
            'Gender'            => $Gender,
        );
        if($Image):
			$data['Image']  = $Image;
		endif;
        $this->session->set_userdata($data);

		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}
}