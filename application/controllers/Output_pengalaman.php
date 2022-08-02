<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Output_pengalaman extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("M_output_pengalaman","output_pengalaman");
		$this->load->model("M_output_posisi_uraian","output_posisi_uraian");
	}

	public function index(){
		$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "output_pengalaman";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;

		$ID = $this->main->generate_code_proyek();

		$data["title"] 		= $this->lang->line('lb_output_pengalaman');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['id']			= $ID;
		$data['content'] 	= 'backend/output_pengalaman/list';
		$data['form']		= 'backend/output_pengalaman/form';
		$data['upload']		= 'backend/output_pengalaman/upload_uraian';
		$data['filter']		= 'backend/output_pengalaman/filter';
		$data['filter2']	= 'backend/output_pengalaman/filter2';
		$data['import']		= 'backend/output_pengalaman/import';

		$data['b_list']		= 'backend/output_pengalaman/breadcumb-list';
		$data['b_form']		= 'backend/output_pengalaman/breadcumb-form';

		$data['btn_add']	= $btn_add;
		$data['btn_import']	= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->output_pengalaman->get_datatables();
		$i 		= $this->input->post('start');

		$url 		= $this->input->post('page_url');
		$module 	= $this->input->post('page_module');
		$MenuID 	= $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);

		foreach ($list as $a):
			$no = $i++;
			$no += 1;
			$txt_status = $this->main->label_active($a->Status);
			$tg_data = ' data-id="'.$a->PelID.'" ';
			$tg_data .= ' data-status="'.$a->Status.'" ';
			$tg_datax = 'id="'.$a->PelID.'" ';

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
				$btn = $this->main->button('action_list',$a->PelID,$btn_array);
			else:
				$btn = '';
			endif;
			// $temp = '<label><input type="checkbox" class="checkbox dt-id" '.$tg_data.'" baris-id="'.$a->PelID.'" value="'.$no.'"><span class="dt-id" '.$tg_data.'>'.$no.'</span></label>';
			$temp = '<label class="dt-id" '.$tg_datax.'><input type="checkbox" class="checkbox dt-id dt-x" '.$tg_data.'" baris-id="'.$a->PelID.'" value="'.$no.'"><span >'.$no.'</span></label>';
			
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= $a->PelID;
			$row[] 	= $a->Nama_kegiatan;
			$row[] 	= $a->Lokasi_kegiatan;
			$row[] 	= $a->Pengguna_jasa;
			// $row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->output_pengalaman->count_all(),
			"recordsFiltered" 	=> $this->output_pengalaman->count_filtered(),
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
			$temp = '<label><input type="checkbox" class="checkbox dt-id2" '.$tg_data.'" baris-id2="'.$a->ID.'" value="'.$no.'"><span class="dt-id" '.$tg_data.'>'.$no.'</span></label>';

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

				$ID 							= $this->input->post("ID");
				$PengalamanID 					= $this->input->post("PengalamanID");
				$Nama_kegiatan 					= $this->input->post("Nama_kegiatan");
				$Lokasi_kegiatan 				= $this->input->post("Lokasi_kegiatan");
				$Pengguna_jasa 					= $this->input->post("Pengguna_jasa");
				$Nama_perusahaan 				= $this->input->post("Nama_perusahaan");
				$Waktu_pelaksanaan_mulai 		= $this->input->post("Waktu_pelaksanaan_mulai");
				$Waktu_pelaksanaan_selesai 		= $this->input->post("Waktu_pelaksanaan_selesai");

				$data_detail 	= array(	
					"PelID" 						=> $ID,	
					"Nama_kegiatan" 				=> $Nama_kegiatan,
					"Lokasi_kegiatan" 				=> $Lokasi_kegiatan,
					"Pengguna_jasa" 				=> $Pengguna_jasa,
					"Nama_perusahaan" 				=> $Nama_perusahaan,
					"Waktu_pelaksanaan_mulai" 		=> $Waktu_pelaksanaan_mulai,
					"Waktu_pelaksanaan_selesai" 	=> $Waktu_pelaksanaan_selesai,
				);		

				$this->main->general_update("mt_daftar_riwayat", $data_detail, array("PelID" => $ID));

				$message = $this->lang->line('lb_success_insert'); 	

				$response = array(
					"status"	=> true,
					"message"	=> $message,
				);
				$this->main->echoJson($response);
			}

			public function save_uraian(){
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
		// $this->validation->poisi_uraian();

						$ID 							= $this->input->post("ID");

						$Posisi_penugasan 				= $this->input->post("Posisi_penugasan");
						$Uraian_tugas 					= $this->input->post("Uraian_pengalaman");

						$data_detail 	= array(	
							"Posisi"						=> $Posisi_penugasan,
							"Uraian_tugas" 					=> $Uraian_tugas,
						);		

						$this->main->general_update("mt_posisi_uraian", $data_detail, array("ID" => $ID));

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
						$list 		= $this->output_pengalaman->get_by_id($ID);

						$response = array(
							"status"	    => true,
							"data"		    => $list,
							"message"	    => $this->lang->line('lb_success'),
						);

						$this->main->echoJson($response);
					}

					public function edit2(){
						$url 				= $this->input->post('page_url');
						$module 			= $this->input->post('page_module');
						$MenuID 			= $this->api->get_menuID($url);
						$read_menu 			= $this->api->read_menu($MenuID);
						$this->main->check_session('out', 'update', $read_menu->update);
						$ID 		= $this->input->post('ID');
						$list 		= $this->output_pengalaman->get_by_id_uraian($ID);

						$response = array(
							"status"	    => true,
							"data"		    => $list,
							"message"	    => $this->lang->line('lb_success'),
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
								$this->db->where('PelID', $value);
								$this->db->update('mt_daftar_riwayat');		
							}
						else:

							foreach($ID as $value){
								$this->db->set('Status', '0');
								$this->db->where('PelID', $value);
								$this->db->update('mt_daftar_riwayat');
							}
						endif;

						$response = array(
							"status"	=> true,
							"message"	=> $message,
						);
						$this->main->echoJson($response);

					}

					public function active_all2(){
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
								$this->db->update('mt_posisi_uraian');		}
							else:

								foreach($ID as $value){
									$this->db->set('Status', '0');
									$this->db->where('ID', $value);
									$this->db->update('mt_posisi_uraian');
								}
							endif;

							$response = array(
								"status"	=> true,
								"message"	=> $message,
							);
							$this->main->echoJson($response);

						}



					}