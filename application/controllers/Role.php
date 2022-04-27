<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_role","role");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "role";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); endif;

		$dt_menu 			= $this->api->menu("backend");

		$data["title"] 		= $this->lang->line('lb_role');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/role/list';
		$data['form']		= 'backend/role/form';
		$data['menu']		= $dt_menu;
		$data['btn_add']	= $btn_add;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->role->get_datatables();
		$i 		= $this->input->post('start');

		$url 		= $this->input->post('page_url');
		$module 	= $this->input->post('page_module');
		$MenuID 	= $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);

		foreach ($list as $a):
			$no = $i++;
			$no += 1;
			$txt_status = $this->main->label_active($a->Status);
			$tg_data 	= ' data-id="'.$a->RoleID.'" ';
			$tg_data 	.= ' data-status="'.$a->Status.'" ';

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
				$btn = $this->main->button('action_list',$a->RoleID,$btn_array);
			else:
				$btn = '';
			endif;
			$temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';

			$HakAksesType   = $this->session->HakAksesType;
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= $a->Name;
			if(in_array($HakAksesType, array(1,2))):
				$row[] 	= $this->main->label_role_type($a->Type);
			endif;
			$row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->role->count_all(),
			"recordsFiltered" 	=> $this->role->count_filtered(),
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
		$this->validation->role();

		$ID 		= $this->input->post("ID");
		$Name 		= $this->input->post("Name");
		$Remark 	= $this->input->post("Remark");
		$View 		= $this->input->post("View");
		$Insert 	= $this->input->post("Insert");
		$Update 	= $this->input->post("Update");
		$Delete 	= $this->input->post("Delete");
		$Type 		= $this->input->post("Type");
		$Level 		= $this->input->post("Level");

		if($Type == "developer"): $Type = 1;
		elseif($Type == "super_admin"): $Type = 2;
		elseif($Type == "company"): $Type = 3;
		endif;

		$HakAksesType   = $this->session->HakAksesType;
		$CompanyID 		= $this->session->CompanyID;

		if(!$View): $View = array(); endif;
		if(!$Insert): $Insert = array(); endif;
		if(!$Update): $Update = array(); endif;
		if(!$Delete): $Delete = array(); endif;
		
		$data = array(
			"Name"		=> $Name,
			"Remark"	=> $Remark,
			"View"		=> json_encode($View),
			"Insert"	=> json_encode($Insert),
			"Update"	=> json_encode($Update),
			"Delete"	=> json_encode($Delete),
		);
		if($HakAksesType == 3 || !in_array($HakAksesType, array(1,2,3))):
			$data['Level'] = $Level;
		endif;
		if($HakAksesType == 1 and in_array($Type,array(1,2,3))): $data['Type'] = $Type;
		elseif($HakAksesType == 2 and in_array($Type,array(2,3))): $data['Type'] = $Type;
		else: $data['CompanyID'] = $CompanyID;
		endif;

		if($Crud == "insert"):
			$data['Status']	= 1;
			$ID = $message = $this->lang->line('lb_success_insert');
			$this->main->general_save("ut_role", $data);
			$this->main->inser_log(1,2,'role', $ID);//$LogType,$Type,$Page,$Content=""
		elseif($Crud == "update"):
			$message = $this->lang->line('lb_success_update');
			$this->main->general_update("ut_role", $data, array("RoleID" => $ID));
			$this->main->inser_log(1,3,'role', $ID);//$LogType,$Type,$Page,$Content=""
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
		$list 		= $this->api->role("detail_id", $ID);

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

		$this->main->general_update("ut_role", $data, array("RoleID" => $ID));
		if($Active == 1):
			$this->main->inser_log(1,6,'role', $ID);//$LogType,$Type,$Page,$Content=""
		else:
			$this->main->inser_log(1,7,'role', $ID);//$LogType,$Type,$Page,$Content=""
		endif;
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}
}