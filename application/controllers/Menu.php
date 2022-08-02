<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_menu","menu");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "menu";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); endif;

		$data["title"] 		= $this->lang->line('lb_menu');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/menu/list';
		$data['form']		= 'backend/menu/form';
		$data['btn_add']	= $btn_add;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->menu->get_datatables();
		$url 		= $this->input->post('page_url');
		$MenuID 	= $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);
		$i 		= $this->input->post('start');

		foreach ($list as $a):
			$type = $this->menu->type($a->Type);

			$no = $i++;
			$no += 1;
			$tg_data 	= ' data-id="'.$a->MenuID.'" ';

			$btn_array = array();
			$btn_status = false;
			if($read_menu->update>0):
				$btn_status = true;
				array_push($btn_array, 'edit');
			endif;
			if($read_menu->delete>0):
				$btn_status = true;
				array_push($btn_array, 'delete');
			endif;

			if($btn_status):
				$btn = $this->main->button('action_list',$a->MenuID,$btn_array);
			else:
				$btn = '';
			endif;
			$temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';
			$row = array();
			// $row[] 	= '<span class="dt-id" data-id="'.$a->MenuID.'">'.$no.'</span>';
			$row[] 	= $btn.$temp;
			$row[] 	= $a->Name;
			$row[] 	= $a->Url;
			$row[] 	= $a->Root;
			$row[] 	= $type;
			$row[] 	= $a->Level;
			$row[] 	= $a->parentName;
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->menu->count_all(),
			"recordsFiltered" 	=> $this->menu->count_filtered(),
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

		$this->main->check_session('out',$Crud,$p3);
		$this->validation->menu();

		$ID 	= $this->input->post("ID");
		$Name 	= $this->input->post("Name");
		$Url 	= $this->input->post("Url");
		$Root 	= $this->input->post("Root");
		$Level 	= $this->input->post("Level");
		$Parent = $this->input->post("Parent");
		$Type 	= $this->input->post("Type");
		$Role 	= $this->input->post("Role");
		$Icon 	= $this->input->post("Icon");

		if(!$Type): $Type = array(); endif;
		if($Level == 1): $Parent = null; endif;

		$data = array(
			"Name"		=> $Name,
			"Url"		=> $Url,
			"Root"		=> $Root,
			"Level"		=> $Level,
			"ParentID"	=> $Parent,
			"Type"		=> json_encode($Type),
			"Role"		=> $Role,
			"Icon"		=> $Icon,
		);

		if($Level<2):
			$data['ParentID'] = null;
		endif;

		if($Crud == "insert"):
			$message = $this->lang->line('lb_success_insert');
			$this->main->general_save("ut_menu", $data);
		elseif($Crud == "update"):
			$message = $this->lang->line('lb_success_update');
			$this->main->general_update("ut_menu", $data, array("MenuID" => $ID));
		endif;	

		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

	public function delete(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);

		$this->main->check_session('out', 'delete', $read_menu->delete);
		$ID = $this->input->post('ID');

		$this->db->where("MenuID", $ID);
		$this->db->delete("ut_menu");

		$response = array(
			"status"	=> true,
			"message"	=> $this->lang->line('lb_success'),
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
		$list 		= $this->menu->get_by_id($ID);
		$Type 		= json_decode($list->Type);
		$Backend 	= '';
		$Frontend 	= '';
		if(count($Type)):
			if(in_array('backend',$Type)): $Backend = 'backend'; endif;
			if(in_array('frontend',$Type)): $Frontend = 'frontend'; endif;
		endif;

		$response = array(
			"status"	=> true,
			"data"		=> $list,
			"backend"	=> $Backend,
			"frontend" 	=> $Frontend,
			"message"	=> $this->lang->line('lb_success'),
		);

		$this->main->echoJson($response);
	}

}