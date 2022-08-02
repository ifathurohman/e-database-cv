<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Output_pendidikan extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("M_output_pendidikan","output_pendidikan");
	}

	public function index(){
		$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "output_pendidikan";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;

		$data["title"] 		= $this->lang->line('lb_output_pendidikan');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/output_pendidikan/list';
		$data['form']		= 'backend/output_pendidikan/form';
		$data['upload']		= 'backend/output_pendidikan/upload_uraian';
		$data['filter']		= 'backend/output_pendidikan/filter';
		$data['import']		= 'backend/output_pendidikan/import';

		$data['b_list']		= 'backend/output_pendidikan/breadcumb-list';
		$data['b_form']		= 'backend/output_pendidikan/breadcumb-form';

		$data['btn_add']	= $btn_add;
		$data['btn_import']	= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->output_pendidikan->get_datatables();
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
			$tg_datax = 'id="'.$a->ID.'" ';

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
			$temp = '<label class="dt-id" '.$tg_datax.'><input type="checkbox" class="checkbox dt-id dt-x" '.$tg_data.'" baris-id="'.$a->ID.'" value="'.$no.'"><span >'.$no.'</span></label>';
			// $temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';
			
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= $a->Posisi;
			$row[] 	= $a->Nama_personil;
			$row[] 	= $a->Nama_perusahaan;
			$row[] 	= $a->Tempat_tanggal_lahir;
			// $row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->output_pendidikan->count_all(),
			"recordsFiltered" 	=> $this->output_pendidikan->count_filtered(),
			"data" 				=> $data,
		);

		$this->main->echoJson($response);
	}

	public function list_uraian(){
		$data 	        = array();
		$list_uraian 	= $this->output_posisi_uraian->get_datatables_uraian();
		$i 		        = $this->input->post('start');

		$url 		    = $this->input->post('page_url');
		$module 	    = $this->input->post('page_module');
		$MenuID 	    = $this->api->get_menuID($url);
		$read_menu 	    = $this->api->read_menu($MenuID);

		foreach ($list_uraian as $a):
			$no = $i++;
			$no += 1;
			$txt_status = $this->main->label_active($a->Status);
			$tg_data = ' data-id="'.$a->ID.'" ';
			$tg_data .= ' data-status="'.$a->Status.'" ';

			$btn_array = array();
			$btn_status = false;
			if($read_menu->view>0):
				$btn_status = true;
				array_push($btn_array, 'view2');
			endif;
			if($read_menu->update>0):
				$btn_status = true;
				array_push($btn_array, 'edit2');
			endif;

			if($btn_status):
				$btn = $this->main->button('action_list',$a->ID,$btn_array);
			else:
				$btn = '';
			endif;
			$temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';

			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= $a->Posisi;
			$row[] 	= $a->Uraian_tugas;
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->output_posisi_uraian->count_all_uraian(),
			"recordsFiltered" 	=> $this->output_posisi_uraian->count_filtered_uraian(),
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

				$ID 					= $this->input->post("ID");
				$Posisi 				= $this->input->post("Posisi");
				$Nama_personil 			= $this->input->post("Nama_personil");
				$Nama_perusahaan 		= $this->input->post("Nama_perusahaan");
				$Tempat_tanggal_lahir 	= $this->input->post("Tempat_tanggal_lahir");
				$Pendidikan 			= $this->input->post("Pendidikan");
				$Pendidikan_non_formal 	= $this->input->post("Pendidikan_non_formal");
				$Nomor_hp 				= $this->input->post("Nomor_hp");
				$Email 					= $this->input->post("Email");

				$data_detail = array(	
					"ID" 						=> $ID,	
					"Posisi" 					=> $Posisi,
					"Nama_personil" 			=> $Nama_personil,
					"Nama_perusahaan" 			=> $Nama_perusahaan,
					"Tempat_tanggal_lahir" 		=> $Tempat_tanggal_lahir,
					"Pendidikan" 				=> $Pendidikan,
					"Pendidikan_non_formal" 	=> $Pendidikan_non_formal,
					"Nomor_hp" 					=> $Nomor_hp,
					"Email" 					=> $Email,
				);		

				$this->main->general_update("biodata", $data_detail, array("ID" => $ID));

				$data_detail_sdm = array(	
					"BIOID" 					=> $data_detail['ID'],	
					"Nama_personil" 			=> $Nama_personil,
				);		

				$this->main->general_update("mt_sdm", $data_detail_sdm, array("BIOID" => $ID));

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
				$list 		= $this->output_pendidikan->get_by_id($ID);

				$response = array(
					"status"	    => true,
					"data"		    => $list,
					"message"	    => $this->lang->line('lb_success'),
				);

				$this->main->echoJson($response);
			}

			public function active(){
				exit();
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
					"Status"	=> 0,
				);
				$HakAksesType   = $this->session->HakAksesType;
				if(!in_array($HakAksesType, array(1,2))):
					$this->main->general_update("biodata", $data, array("ID" => $ID));
					$this->main->general_update("mt_sdm", $data, array("BIOID" => $ID));
				else:
					$this->main->general_update("biodata", $data, array("ID" => $ID));
					$this->main->general_update("mt_sdm", $data, array("BIOID" => $ID));
				endif;

				$response = array(
					"status"	=> true,
					"message"	=> $message,
				);
				$this->main->echoJson($response);

			}

			public function active_all(){
				$url 				= $this->input->post('page_url');
				$module 			= $this->input->post('page_module');
				$MenuID 			= $this->api->get_menuID($url);
				$read_menu 			= $this->api->read_menu($MenuID);

				$ID 		= $this->input->post('ID');
				$Status 	= $this->input->post('Status');
				$Active 	= 1;
				$message 	= $this->lang->line('lb_success_active');

				if($Status == 1):
					$Active  = 0;
					$message = $this->lang->line('lb_success_nonactive');
				endif;

				$data = array(
					"Status"	=> 0,
				);
				$HakAksesType   = $this->session->HakAksesType;
				$CompanyID 		= $this->session->CompanyID;
				if(!in_array($HakAksesType, array(1,2))):
					foreach($ID as $value){
						$this->db->set('Status', '0');
						$this->db->where('ID', $value);
						$this->db->update('biodata');		
					}
					foreach($ID as $value2){
						$this->db->set('Status', '0');
						$this->db->where('BIOID', $value2);
						$this->db->update('mt_sdm');		
					}
				else:
					foreach($ID as $value){
						$this->db->set('Status', '0');
						$this->db->where('ID', $value);
						$this->db->update('biodata');
					}
					foreach($ID as $value2){
						$this->db->set('Status', '0');
						$this->db->where('BIOID', $value2);
						$this->db->update('mt_sdm');		
					}
				endif;

					$response = array(
						"status"	=> true,
						"message"	=> $message,
					);
					$this->main->echoJson($response);

				}

			}