<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Output_proyek extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_upload_cv","output_proyek");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "output_proyek";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;

        $ID = $this->main->generate_code_proyek();

		$data["title"] 		= $this->lang->line('lb_output_proyek');
		$data['url']		= $url;
		$data['module']		= $module;
        $data['id']			= $ID;
		$data['content'] 	= 'backend/output_proyek/list';
		$data['form']		= 'backend/output_proyek/form';
		$data['upload']		= 'backend/output_proyek/upload_uraian';
		$data['filter']		= 'backend/output_proyek/filter';
		$data['import']		= 'backend/output_proyek/import';

        $data['b_list']		= 'backend/output_proyek/breadcumb-list';
		$data['b_form']		= 'backend/output_proyek/breadcumb-form';

		$data['btn_add']	= $btn_add;
		$data['btn_import']	= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->output_proyek->get_datatables();
		$i 		= $this->input->post('start');

		$url 		= $this->input->post('page_url');
		$module 	= $this->input->post('page_module');
		$MenuID 	= $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);

		foreach ($list as $a):
			$no = $i++;
			$no += 1;
			$txt_status = $this->main->label_active($a->Status);
			$tg_data = ' data-id="'.$a->ID.'" ';
			$tg_data .= ' data-status="'.$a->Status.'" ';

			$btn_array = array();
			$btn_status = false;
			if($read_menu->view>0):
				$btn_status = true;
				array_push($btn_array, 'view');
			endif;
			if($read_menu->update>0):
				$btn_status = true;
				array_push($btn_array, 'edit');
			endif;

			if($btn_status):
				$btn = $this->main->button('action_list',$a->ID,$btn_array);
			else:
				$btn = '';
			endif;
			$temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';
			
			$row = array();
			$row[] 	= $btn.$temp;
            $row[] 	= $a->ID;
			$row[] 	= $a->Nama_kegiatan;
			$row[] 	= $a->Pengguna_jasa;
			$row[] 	= $this->main->tanggal_indo($a->Tanggal_tender);
			// $row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->output_proyek->count_all(),
			"recordsFiltered" 	=> $this->output_proyek->count_filtered(),
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
		// $this->validation->upload_cv();

		$ID 							= $this->input->post("ID");

		$Nama_kegiatan 					= $this->input->post("Nama_kegiatan");
		$Pengguna_jasa 					= $this->input->post("Pengguna_jasa");
		$Tanggal_tender 				= $this->input->post("Tanggal_tender");

		$ID 							= $this->main->generate_code_proyek();

		$data_detail 	= array(	
			"ID" 							=> $ID,	
			"Nama_kegiatan" 				=> $Nama_kegiatan,
			"Pengguna_jasa" 				=> $Pengguna_jasa,
			"Tanggal_tender" 				=> $Tanggal_tender,
		);		

		$this->main->general_update("proyek", $data_detail, array("ID" => $ID));
		
		$message = $this->lang->line('lb_success_insert'); 	

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
		$list 		= $this->output_proyek->get_by_id($ID);

		$response = array(
			"status"	=> true,
			"data"		=> $list,
			"attach"	=> $this->main->attachment_show("proyek",$ID),
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
			$this->main->general_update("proyek", $data, array("ID" => $ID, "CompanyID" => $CompanyID));
		else:
			$this->main->general_update("proyek", $data, array("ID" => $ID));
		endif;
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}

}