<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_users","users");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "users";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); endif;

		$data["title"] 		= $this->lang->line('lb_company');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/users/list';
		$data['form']		= 'backend/users/form';
		$data['btn_add']	= $btn_add;
		$this->load->view('backend/index',$data);
	}

	public function company_profile(){
		$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "users";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_edit = '';
		if($read_menu->update>0):
			$btn_edit = '<button type="button" onclick="edit_data()" class="btn btn-primary btn-add d-lg-block m-l-15"><i class="fa fa-pencil"></i> '.$this->lang->line('lb_edit_data').'</button>';
		endif;

		$data["title"] 		= $this->lang->line('lb_company_profile');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/users/company_profile';
		$data['edit']		= $btn_edit;
		$this->load->view('backend/index',$data);
	}

	public function company_edit(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->update<=0): redirect('403_override'); endif;
		$data["title"] 		= $this->lang->line('lb_edit_data');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/users/company_edit';
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
			$tg_data = ' data-id="'.$a->UserID.'" ';
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

			if($btn_status):
				$btn = $this->main->button('action_list',$a->UserID,$btn_array);
			else:
				$btn = '';
			endif;
			$temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';
			
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= $a->Name;
			$row[] 	= $a->Username;
			$row[] 	= $a->Email;
			$row[] 	= $a->RoleName;
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
		$this->validation->users();

		$ID 			= $this->input->post("ID");
		$Name 			= $this->input->post("Name");
		$Email 			= $this->input->post("Email");
		$Username 		= $this->input->post("Username");
		$Role 			= $this->input->post("Role");
		$Password 		= $this->input->post("Password");
		$PhoneCountry 	= $this->input->post("PhoneCountry");
		$Phone 			= $this->input->post("Phone");
		$LocationName 	= $this->input->post("LocationName");
		$Address 		= $this->input->post("Address");
		$Latitude 		= $this->input->post("Latitude");
		$Longidute 		= $this->input->post("Longidute");
		$Radius 		= $this->input->post("Radius");
		$StartJoin 		= $this->input->post("StartJoin");
		$StartWorkDate 	= $this->input->post('StartWorkDate');

		$Image 			= $this->save_image();

		$data = array(
			"Name"		=> $Name,
			"Email"		=> $Email,
			"Username" 	=> $Username,
			"RoleID"	=> $Role,
			"CountryIso"=> $PhoneCountry,
			"Phone"		=> $Phone,
			"LocationName"	=> $LocationName,
			"Address"	=> $Address,
			"Latitude"	=> $Latitude,
			"Longitude"	=> $Longidute,
			"Radius"	=> $Radius,
			"DateJoin"	=> $StartJoin,
			"StartWorkDate"	=> $StartWorkDate,
		);
		if($Image):
			$data['Image']  = $Image;
		endif;
		if($Crud == "insert"):
			$Password = $this->main->create_password($Password);
			$data['Password'] 	= $Password;
			$data['Status'] 	= 1;
			$message = $this->lang->line('lb_success_insert');
			$ID = $this->main->general_save("ut_user", $data);
			$this->main->inser_log(1,2,'company', $ID);//$LogType,$Type,$Page,$Content=""
		elseif($Crud == "update"):
			if($Password):
				$Password = $this->main->create_password($Password);
				$data['Password'] = $Password;
			endif;
			$message = $this->lang->line('lb_success_update');
			$this->main->general_update("ut_user", $data, array("UserID" => $ID));
			$this->main->inser_log(1,3,'company', $ID);//$LogType,$Type,$Page,$Content=""
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
		$list 		= $this->api->user("detail_id", $ID);
		$role 		= $this->api->role('detail_id', $list->RoleID);

		$list->RoleName = $role->Name;

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

		$this->main->general_update("ut_user", $data, array("UserID" => $ID));
		if($Active == 1):
			$this->main->inser_log(1,6,'company', $ID);//$LogType,$Type,$Page,$Content=""
		else:
			$this->main->inser_log(1,7,'company', $ID);//$LogType,$Type,$Page,$Content=""
		endif;
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}

	private function save_image(){

		$nmfile                     = "alpa_".date("ymdHis");
	    $config['upload_path']      = './img/company'; //path folder 
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
	    
	    $image = '';
	    if($upload):
	    	$image 	= "img/company/".$gbr['file_name'];
	    	if($Crud == "update"):
	    		if(in_array($HakAksesType,array(1,2))):
	    			$this->main->remove_file("ut_user","Image",array("UserID" => $ID));
	    		else:
	    			$this->main->remove_file("ut_user","Image",array("UserID" => $ID));
	    		endif;
	    	endif;
	    endif;

	    return $image;
	}

	public function company_save(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		$CompanyID 			= $this->session->CompanyID;

		$Crud 	= "update";
		$p3 	= $read_menu->update;

		$this->main->check_session('out',$Crud, $p3);
		$this->validation->users("company");

		$ID 			= $this->input->post("ID");
		$Name 			= $this->input->post("Name");
		$Email 			= $this->input->post("Email");
		$Username 		= $this->input->post("Username");
		$Role 			= $this->input->post("Role");
		$Password 		= $this->input->post("Password");
		$PhoneCountry 	= $this->input->post("PhoneCountry");
		$Phone 			= $this->input->post("Phone");
		$LocationName 	= $this->input->post("LocationName");
		$Address 		= $this->input->post("Address");
		$Latitude 		= $this->input->post("Latitude");
		$Longidute 		= $this->input->post("Longidute");
		$Radius 		= $this->input->post("Radius");
		$StartJoin 		= $this->input->post("StartJoin");
		$StartWorkDate 	= $this->input->post("StartWorkDate");

		$Image 			= $this->save_image();

		$data = array(
			"Name"		=> $Name,
			"Email"		=> $Email,
			"Username" 	=> $Username,
			"CountryIso"=> $PhoneCountry,
			"Phone"		=> $Phone,
			"LocationName"	=> $LocationName,
			"Address"	=> $Address,
			"Latitude"	=> $Latitude,
			"Longitude"	=> $Longidute,
			"Radius"	=> $Radius,
			"StartWorkDate"	=> $StartWorkDate,
		);
		if($Image):
			$data['Image']  = $Image;
		endif;
		if($Password):
			$Password = $this->main->create_password($Password);
			$data['Password'] = $Password;
		endif;
		$message = $this->lang->line('lb_success_update');
		$this->main->general_update("ut_user", $data, array("UserID" => $CompanyID));
		if(!$Image):
			$data['Image']  = '';
		endif;
		$this->main->set_session_company($data);

		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}
}