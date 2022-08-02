<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpWord\Element\Field;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Style\Font;
class Output_cv extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_output_cv","output_cv");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "output_cv";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;

        $ID = $this->main->generate_code_konstruksi();

		$data["title"] 		= $this->lang->line('lb_output_cv');
		$data['url']		= $url;
		$data['module']		= $module;
        $data['id']			= $ID;
		$data['content'] 	= 'backend/output_cv/list';
		$data['form']		= 'backend/output_cv/form';
		$data['filter']		= 'backend/output_cv/filter';

		$data['filter_search1']		= 'backend/output_cv/filter_search1';
		$data['filter_search2']		= 'backend/output_cv/filter_search2';
		
		$data['import']		= 'backend/output_cv/import';

        $data['b_list']		= 'backend/output_cv/breadcumb-list';
		$data['b_form']		= 'backend/output_cv/breadcumb-form';

		$data['btn_add']	= $btn_add;
		$data['btn_import']	= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->output_cv->get_datatables();
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
			
			$temp = '<label><input type="checkbox" class="checkbox dt-id2 dt-x" '.$tg_data.'" baris-id2="'.$a->ID.'" value="'.$no.'"><span class="dt-id" '.$tg_data.'>'.$no.'</span></label>';
			
			$row = array();
			$row[] 	= $btn.$temp;
            $row[] 	= $a->ID;
			$row[] 	= $a->Posisi;
			$row[] 	= $a->Nama_personil;
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->output_cv->count_all(),
			"recordsFiltered" 	=> $this->output_cv->count_filtered(),
			"data" 				=> $data,
		);

		$this->main->echoJson($response);
	}

	public function list_non_konstruksi(){
		$data 	= array();
		$list 	= $this->output_cv->get_datatables_non_konstruksi();
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
			$temp = '<label><input type="checkbox" class="checkbox dt-id2 dt-z" '.$tg_data.'" baris-id2="'.$a->ID.'" value="'.$no.'"><span class="dt-id" '.$tg_data.'>'.$no.'</span></label>';
			
			
			$row = array();
			$row[] 	= $btn.$temp;
            $row[] 	= $a->ID;
			$row[] 	= $a->Posisi;
			$row[] 	= $a->Nama_personil;
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->output_cv->count_all_non_konstruksi(),
			"recordsFiltered" 	=> $this->output_cv->count_filtered_non_konstuksi(),
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
		$this->validation->output_cv();

		$ID 		= $this->input->post("ID");
		$Name 		= $this->input->post("Name");
		$Code 		= $this->input->post("Code");
		$Company 	= $this->input->post('Company');
		$CompanyID 		= $this->session->CompanyID;
		$HakAksesType   = $this->session->HakAksesType;

		if(in_array($HakAksesType,array(1,2))): $CompanyID = $Company; endif;

		$Image = $this->save_image();

		$data = array(
			"CompanyID"			=> $CompanyID,
			"Name"				=> $Name,
			"Code"				=> $Code,
		);
		if($Crud == "insert"):
			$data['Status'] 	= 1;
			$message = $this->lang->line('lb_success_insert');
			$ID = $this->main->general_save("mt_output_cv", $data);
			$this->main->inser_log(1,2,'output_cv', $ID);//$LogType,$Type,$Page,$Content=""
		elseif($Crud == "update"):
			$message = $this->lang->line('lb_success_update');
			$this->main->general_update("mt_output_cv", $data, array("output_cvID" => $ID));
			$this->main->inser_log(1,3,'output_cv', $ID);//$LogType,$Type,$Page,$Content=""

		endif;

		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

	public function update_konstruksi(){
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
		$this->validation->konstruksi();

		$ID 							= $this->input->post("ID");
		$DetID 							= $this->input->post("DetID");
		$BioID 							= $this->input->post("BioID");
		$Posisi 						= $this->input->post("Posisi");
		$Nama_perusahaan1 				= $this->input->post("Nama_perusahaan1");
		$Nama_personil 					= $this->input->post("Nama_personil");
		$Tempat_tanggal_lahir 			= $this->input->post("Tempat_tanggal_lahir");

		$Pendidikan 					= $this->input->post("Pendidikan");
		$Pendidikan_non_formal 			= $this->input->post("Pendidikan_non_formal");
		
		$Penguasaan_bahasa_indo 		= $this->input->post("Penguasaan_bahasa_indo");
		$Penguasaan_bahasa_inggris 		= $this->input->post("Penguasaan_bahasa_inggris");
		$Penguasaan_bahasa_setempat 	= $this->input->post("Penguasaan_bahasa_setempat");

		$PengalamanID 					= $this->input->post("PengalamanID");
		$Nama_kegiatan 					= $this->input->post("Nama_kegiatan[]");
		$Lokasi_kegiatan 				= $this->input->post("Lokasi_kegiatan[]");
		$Pengguna_jasa 					= $this->input->post("Pengguna_jasa[]");
		$Nama_perusahaan 				= $this->input->post("Nama_perusahaan[]");
		$Uraian_tugas 					= $this->input->post("Uraian_tugas[]");
		$Waktu_pelaksanaan 				= $this->input->post("Waktu_pelaksanaan[]");
		$Posisi_penugasan 				= $this->input->post("Posisi_penugasan[]");
		$Status_kepegawaian 			= $this->input->post("Status_kepegawaian");
		$Surat_referensi 				= $this->input->post("Surat_referensi[]");
		$Status_kepegawaian_2 			= $this->input->post("Status_kepegawaian2");

		$Status 						= $this->input->post("Status");
		$Pernyataan 					= $this->input->post("Pernyataan");

		$cekID = $this->api->get_one_row("mt_konstruksi","ID",array("ID" => $ID));

		$ID = $cekID->ID;

		$data_konstruksi = array(
			"BioID" 						=> $BioID,
			"Posisi" 						=> $Posisi,
			"Nama_perusahaan1" 				=> $Nama_perusahaan1,
			"Nama_personil" 				=> $Nama_personil,
			"Tempat_tanggal_lahir" 			=> $Tempat_tanggal_lahir,
			"Pendidikan" 					=> $Pendidikan,
			"Pendidikan_non_formal" 		=> $Pendidikan_non_formal,
			"Penguasaan_bahasa_indo" 		=> $Penguasaan_bahasa_indo,
			"Penguasaan_bahasa_inggris" 	=> $Penguasaan_bahasa_inggris,
			"Penguasaan_bahasa_setempat" 	=> $Penguasaan_bahasa_setempat,
			"Status_kepegawaian2" 			=> $Status_kepegawaian_2,
			// "Pernyataan" 					=> $Pernyataan,
		);
		
		$this->main->general_update("mt_konstruksi", $data_konstruksi, array("ID" => $ID));
		
		$No  = 0;
		foreach($PengalamanID as $key => $val) {
			$No++;
			$data_detail[] = array(
				"ID" 							=> $ID,	
				"PengalamanID" 					=> $val,	
				"Nama_kegiatan" 				=> $Nama_kegiatan[$key],
				"Lokasi_kegiatan" 				=> $Lokasi_kegiatan[$key],
				"Pengguna_jasa" 				=> $Pengguna_jasa[$key],
				"Nama_perusahaan" 				=> $Nama_perusahaan[$key],
				"Uraian_tugas" 					=> $Uraian_tugas[$key],
				"Waktu_pelaksanaan" 			=> $Waktu_pelaksanaan[$key],
				"Posisi_penugasan" 				=> $Posisi_penugasan[$key],
				"Status_kepegawaian" 			=> $Status_kepegawaian[$No],
				"Surat_referensi" 				=> $Surat_referensi[$key],
			);			
			$this->db->delete('mt_konstruksi_det', array('ID' => $ID));
		}

		$message = 'Update Success';
		
		$ID  = $this->db->insert_batch('mt_konstruksi_det', $data_detail); 
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

	public function update_non_konstruksi(){
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
		$this->validation->konstruksi();

		$ID 							= $this->input->post("ID");
		$DetID 							= $this->input->post("DetID");
		$BioID 							= $this->input->post("BioID");
		$Posisi 						= $this->input->post("Posisi");
		$Nama_perusahaan1 				= $this->input->post("Nama_perusahaan1");
		$Nama_personil 					= $this->input->post("Nama_personil");
		$Tempat_tanggal_lahir 			= $this->input->post("Tempat_tanggal_lahir");

		$Pendidikan 					= $this->input->post("Pendidikan");
		$Pendidikan_non_formal 			= $this->input->post("Pendidikan_non_formal");
		
		$Penguasaan_bahasa_indo 		= $this->input->post("Penguasaan_bahasa_indo");
		$Penguasaan_bahasa_inggris 		= $this->input->post("Penguasaan_bahasa_inggris");
		$Penguasaan_bahasa_setempat 	= $this->input->post("Penguasaan_bahasa_setempat");

		$PengalamanID 					= $this->input->post("PengalamanID");
		$Nama_kegiatan 					= $this->input->post("Nama_kegiatan[]");
		$Lokasi_kegiatan 				= $this->input->post("Lokasi_kegiatan[]");
		$Pengguna_jasa 					= $this->input->post("Pengguna_jasa[]");
		$Nama_perusahaan 				= $this->input->post("Nama_perusahaan[]");
		$Uraian_tugas 					= $this->input->post("Uraian_tugas[]");
		$Waktu_pelaksanaan 				= $this->input->post("Waktu_pelaksanaan[]");
		$Posisi_penugasan 				= $this->input->post("Posisi_penugasan[]");
		$Status_kepegawaian 			= $this->input->post("Status_kepegawaian");
		$Surat_referensi 				= $this->input->post("Surat_referensi[]");
		$Status_kepegawaian_2 			= $this->input->post("Status_kepegawaian2");

		$Status 						= $this->input->post("Status");
		$Pernyataan 					= $this->input->post("Pernyataan");

		// $ID 							= $this->session->ID;
		// $HakAksesType   				= $this->session->HakAksesType;

		// if(in_array($HakAksesType,array(1,2))): $ID = $Company; endif;

		$cekID = $this->api->get_one_row("mt_non_konstruksi","ID",array("ID" => $ID));

		$ID = $cekID->ID;

		$data_non_konstruksi = array(
			"BioID" 						=> $BioID,
			"Posisi" 						=> $Posisi,
			"Nama_perusahaan1" 				=> $Nama_perusahaan1,
			"Nama_personil" 				=> $Nama_personil,
			"Tempat_tanggal_lahir" 			=> $Tempat_tanggal_lahir,
			"Pendidikan" 					=> $Pendidikan,
			"Pendidikan_non_formal" 		=> $Pendidikan_non_formal,
			"Penguasaan_bahasa_indo" 		=> $Penguasaan_bahasa_indo,
			"Penguasaan_bahasa_inggris" 	=> $Penguasaan_bahasa_inggris,
			"Penguasaan_bahasa_setempat" 	=> $Penguasaan_bahasa_setempat,
			"Status_kepegawaian2" 			=> $Status_kepegawaian_2,
			// "Pernyataan" 					=> $Pernyataan,
		);
		
		$this->main->general_update("mt_non_konstruksi", $data_non_konstruksi, array("ID" => $ID));
		
		$No  = 0;
		foreach($PengalamanID as $key => $val) {
			$No++;
			$data_detail[] = array(
				"ID" 							=> $ID,	
				"PengalamanID" 					=> $val,	
				"Nama_kegiatan" 				=> $Nama_kegiatan[$key],
				"Lokasi_kegiatan" 				=> $Lokasi_kegiatan[$key],
				"Pengguna_jasa" 				=> $Pengguna_jasa[$key],
				"Nama_perusahaan" 				=> $Nama_perusahaan[$key],
				"Uraian_tugas" 					=> $Uraian_tugas[$key],
				"Waktu_pelaksanaan" 			=> $Waktu_pelaksanaan[$key],
				"Posisi_penugasan" 				=> $Posisi_penugasan[$key],
				"Status_kepegawaian" 			=> $Status_kepegawaian[$No],
				"Surat_referensi" 				=> $Surat_referensi[$key],
			);			
			$this->db->delete('mt_non_konstruksi_det', array('ID' => $ID));
		}

		$message = 'Update Success';
		
		$ID  = $this->db->insert_batch('mt_non_konstruksi_det', $data_detail); 
		
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
		$list 		= $this->output_cv->get_by_id($ID);

		$response = array(
			"status"	=> true,
			"data"		=> $list,
			"message"	=> $this->lang->line('lb_success'),
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
		$list 		= $this->output_cv->get_by_id2($ID);

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
			$this->main->general_update("mt_output_cv", $data, array("output_cvID" => $ID, "CompanyID" => $CompanyID));
		else:
			$this->main->general_update("mt_output_cv", $data, array("output_cvID" => $ID));
		endif;

		if($Active == 1):
			$this->main->inser_log(1,6,'output_cv', $ID);//$LogType,$Type,$Page,$Content=""
		else:
			$this->main->inser_log(1,7,'output_cv', $ID);//$LogType,$Type,$Page,$Content=""
		endif;
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}

	public function export(){
		$this->output_cv->export();
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
				$this->db->update('mt_konstruksi');		}
			else:

				foreach($ID as $value){
					$this->db->set('Status', '0');
					$this->db->where('ID', $value);
					$this->db->update('mt_konstruksi');
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
			$this->db->update('mt_non_konstruksi');		}
		else:

			foreach($ID as $value){
				$this->db->set('Status', '0');
				$this->db->where('ID', $value);
				$this->db->update('mt_non_konstruksi');
			}
		endif;

		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}

	public function export_word_konstruksi($p1=""){
		$ID 							= $this->input->post("ID");
		$Posisi 						= $this->input->post("Posisi");
		$Nama_perusahaan1 				= $this->input->post("Nama_perusahaan1");
		$Nama_personil 					= $this->input->post("Nama_personil");
		$Tempat_tanggal_lahir 			= $this->input->post("Tempat_tanggal_lahir");
		$Penguasaan_bahasa_indo 		= $this->input->post("Penguasaan_bahasa_indo");
		$Penguasaan_bahasa_inggris 		= $this->input->post("Penguasaan_bahasa_inggris");
		$Penguasaan_bahasa_setempat 	= $this->input->post("Penguasaan_bahasa_setempat");
		$Status_kepegawaian2 			= $this->input->post("Status_kepegawaian2");

		$detail 						= $this->input->post("detail");
		$pendidikan						= $this->input->post("pendidikan");

		$Hari 							= $this->main->tanggal_indo(date('Y-m-d'));

		$folder 						= $this->main->create_folder_general('word');

		$file_name 						= $Nama_personil.'-'.$Posisi.".docx";

		$phpWord 						= new \PhpOffice\PhpWord\PhpWord();
		$templateProcessor 				= new \PhpOffice\PhpWord\TemplateProcessor('Tamplate/Template-konstruksi-docs.docx');

		$where 	= array("ID" => $ID);
		$cek 	= $this->api->get_one_row("mt_konstruksi", "ID",$where);

		$ID 	= $cek->ID;

		$templateProcessor->setValues([
			'ID' 							=> $ID,
			'Posisi' 						=> $Posisi,
			'Nama_perusahaan1' 				=> $Nama_perusahaan1,
			'Nama_personil' 				=> $Nama_personil,
			'Tempat_tanggal_lahir' 			=> $Tempat_tanggal_lahir,
			'inggris' 						=> $Penguasaan_bahasa_inggris,
			'indonesia'						=> $Penguasaan_bahasa_indo,
			'setempat'						=> $Penguasaan_bahasa_setempat,
			'Hari'							=> $Hari,
			'Status2'						=> $Status_kepegawaian2,
		]);	
		
		foreach($pendidikan as $total_pendidikan => $data) {
			// Pendidikan formal
			$data_pend[$total_pendidikan] = array(
				'pendidikan' => $data['Pendidikan'],
			);
			$dom_pend = new DOMDocument;
			$dom_pend->loadHTML($data_pend[$total_pendidikan]['pendidikan']);

			// Pendidikan non formal
			$data_pend_non[$total_pendidikan] = array(
				'pendidikan_non' => $data['Pendidikan_non_formal'],
			);
			$dom_pend_non = new DOMDocument;
			$dom_pend_non->loadHTML($data_pend_non[$total_pendidikan]['pendidikan_non']);

		}

		foreach($detail as $urutan => $waktu) {
			$data_waktu[$urutan] = array(
				'waktu' => $waktu['Waktu_pelaksanaan'],
			);
			$mulai[$urutan] = explode(" ",$data_waktu[$urutan]['waktu']);
		}

		foreach($mulai as $key => $val) {
			
			$data_waktu[$key] = array(
				'mulai' 	=> $val['2'],
				'selesai' 	=> $val['6'],
			);
			$data_waktu[$key] = $data_waktu[$key]['mulai'].' - '.$data_waktu[$key]['selesai'];
		}
		
		
		$i=0;

		// Pendidikan formal
		foreach($dom_pend->getElementsByTagName('div') as $node_pendidikan)
		{
			$array_pendidikan[] = $dom_pend->saveHTML($node_pendidikan);
		}
		$Pendidikan = preg_replace("/<.+>/sU", "", $array_pendidikan);

		foreach ($Pendidikan as $row4 => $row_pendidikan){
			$data_pendidikan[$row4] = array(
				'Pendidikan' => $row_pendidikan,
			);
		}
		
		// Pendidikan Non formal
		foreach($dom_pend_non->getElementsByTagName('div') as $node_pendidikan_non)
		{
			$array_pendidikan_non[] = $dom_pend_non->saveHTML($node_pendidikan_non);
		}
		$Pendidikan_non = preg_replace("/<.+>/sU", "", $array_pendidikan_non);

		foreach ($Pendidikan_non as $row3 => $row_pendidikan_non){
			$data_pendidikan_non[$row3] = array(
				'Pendidikan_non_formal' => $row_pendidikan_non,
			);
		}

		$templateProcessor->cloneBlock('group1', count($data_pendidikan), true, false, $data_pendidikan);
		$templateProcessor->cloneBlock('group2', count($data_pendidikan_non), true, false, $data_pendidikan_non);
		// $templateProcessor->cloneBlock('group3', count($data_tugas), true, false, $data_tugas);
		// $templateProcessor->cloneBlock('block_group', count($replacements), true, false, $replacements);

		// echo "<pre>";
		// print_r($templateProcessor); exit();
		// echo "</pre>";
		
		$document = $phpWord->loadTemplate('Tamplate/Template-konstruksi-docs.docx');
		$document->setValues([
			'ID' 							=> $ID,
			'Posisi' 						=> $Posisi,
			'Nama_perusahaan1' 				=> $Nama_perusahaan1,
			'Nama_personil' 				=> $Nama_personil,
			'Tempat_tanggal_lahir' 			=> $Tempat_tanggal_lahir,
			'inggris' 						=> $Penguasaan_bahasa_inggris,
			'indonesia'						=> $Penguasaan_bahasa_indo,
			'setempat'						=> $Penguasaan_bahasa_setempat,
			'Hari'							=> $Hari,
			'Status2'						=> $Status_kepegawaian2,
		]);	

		$replacements = array(			
			'Tahun',  		
			'Nama', 			
			'Lokasi', 		
			'Pengguna', 		
			'Perusahaan', 	
			'Waktu', 		
			'Posisi_uraian',	
			'Status',
			'Surat' 
		);

		$alphabet = array('a.','x','b.','c.','d.','e.','f.','g.','h.','i.','j.');
		
		$fontStyle['name'] = 'Arial Narrow';
		$fontStyle['size'] = 11;
		// $fontStyle['doubleStrikethrough'] = false;

		$fontStyleBold['name'] = 'Arial Narrow';
		$fontStyleBold['size'] = 11;
		$fontStyleBold['bold'] = true;
		// $fontStyleBold['doubleStrikethrough'] = false;

		$i=0;
		$test4= [];
		$i++;

		$i++;

		$table = new Table(array('borderSize' => 0,'borderColor' => 'white', 'width' => 10000, 'unit' => TblWidth::TWIP));
		foreach($detail as $key => $value) {
			$no = 0;
			$table->addRow();
			$table->addCell(800)->addText('8.'.$key, $fontStyleBold);
			$table->addCell(3100)->addText($replacements[$no].' '.$data_waktu[$key],$fontStyleBold);
			$table->addCell(600)->addText('');
			$table->addCell(600)->addText('');
			$table->addCell(6000)->addText('');				
			foreach ($value as $key2 => $value2){
				if ($key2 != 'PengalamanID'){
					if ($key2 !='Uraian_tugas'){
						$table->addRow();
						$table->addCell(800)->addText('');
						$table->addCell(3100)->addText($alphabet[$no].' '.str_replace('_', ' ', $key2),$fontStyle);
						$table->addCell(600)->addText(':');
						if ($key2 == 'Nama_kegiatan'){
							$table->addCell(6600, array('gridSpan' => 2))->addText($value2,$fontStyleBold);
						}
						else{
							$table->addCell(6600, array('gridSpan' => 2))->addText($value2,$fontStyle);
						}
					}
					else{
						$test2= '';
						$test3= [];


						$test = explode(';',$value2);
				



						foreach ($test as $key3 => $value3){
							if ($key3 == 0){								
								$table->addRow();
								$table->addCell(800)->addText('');
								$table->addCell(3100)->addText($alphabet[$no].' '.$key2,$fontStyle);
								$table->addCell(600)->addText(':');
								$table->addCell(600)->addText('•');
								$table->addCell(6000)->addText(ltrim($value3),$fontStyle);				
							}
							else{
								$table->addRow();
								$table->addCell(800)->addText('');
								$table->addCell(3100)->addText('');
								$table->addCell(600)->addText('');
								$table->addCell(600)->addText('•');
								$table->addCell(6000)->addText(ltrim($value3),$fontStyle);	
							}
						}
					}
				}
				$no++;
			}
			$i++;

			$table->addRow();
			$table->addCell(800)->addText('');
			$table->addCell(3100)->addText('');
			$table->addCell(600)->addText('');
			$table->addCell(600)->addText('');
			$table->addCell(6000)->addText('');			

		}

		// $a = 'asdasd asdasdasd asd asd asda';
		// $b = explode(';',$a);
		// 	$i++;
		// 	echo "<pre>";
		// 	print_r($b); 
		// 	echo "</pre>";
		// exit();
		
		$document->cloneBlock('group1', count($data_pendidikan), true, false, $data_pendidikan);
		$document->cloneBlock('group2', count($data_pendidikan_non), true, false, $data_pendidikan_non);
		$templateProcessor->setComplexBlock('table', $table);
		// $document->cloneBlock('group3', count($data_tugas), true, false, $data_tugas);
		// $document->cloneBlock('block_group', count($replacements), true, false, $replacements);
		$document->setComplexBlock('table', $table);

		$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
		$document->saveAs($temp_file);
		header('Content-Disposition: attachment; filename="' . $file_name . '"');
		readfile($temp_file); // or echo file_get_contents($temp_file);
		unlink($temp_file);  // remove temp file

		
		$pathToSave = 'file/word/'.$ID.'.docx';
		$templateProcessor->saveAs($pathToSave);
		
	}

	public function export_word_non_konstruksi($p1=""){
		$ID 							= $this->input->post("ID");
		$Posisi 						= $this->input->post("Posisi");
		$Nama_perusahaan1 				= $this->input->post("Nama_perusahaan1");
		$Nama_personil 					= $this->input->post("Nama_personil");
		$Tempat_tanggal_lahir 			= $this->input->post("Tempat_tanggal_lahir");
		$Penguasaan_bahasa_indo 		= $this->input->post("Penguasaan_bahasa_indo");
		$Penguasaan_bahasa_inggris 		= $this->input->post("Penguasaan_bahasa_inggris");
		$Penguasaan_bahasa_setempat 	= $this->input->post("Penguasaan_bahasa_setempat");
		$Status_kepegawaian2 			= $this->input->post("Status_kepegawaian2");

		$detail 						= $this->input->post("detail");
		$pendidikan						= $this->input->post("pendidikan");

		$Hari 							= $this->main->tanggal_indo(date('Y-m-d'));

		$folder 						= $this->main->create_folder_general('word');

		$file_name 						= $Nama_personil.'-'.$Posisi.".docx";

		$phpWord 						= new \PhpOffice\PhpWord\PhpWord();
		$templateProcessor 				= new \PhpOffice\PhpWord\TemplateProcessor('Tamplate/Template-non-konstruksi-docs.docx');

		$where 	= array("ID" => $ID);
		$cek 	= $this->api->get_one_row("mt_non_konstruksi", "ID",$where);

		$ID 	= $cek->ID;

		$templateProcessor->setValues([
			'ID' 							=> $ID,
			'Posisi' 						=> $Posisi,
			'Nama_perusahaan1' 				=> $Nama_perusahaan1,
			'Nama_personil' 				=> $Nama_personil,
			'Tempat_tanggal_lahir' 			=> $Tempat_tanggal_lahir,
			'inggris' 						=> $Penguasaan_bahasa_inggris,
			'indonesia'						=> $Penguasaan_bahasa_indo,
			'setempat'						=> $Penguasaan_bahasa_setempat,
			'Hari'							=> $Hari,
			'Status2'						=> $Status_kepegawaian2,
		]);	
		
		foreach($pendidikan as $total_pendidikan => $data) {
			// Pendidikan formal
			$data_pend[$total_pendidikan] = array(
				'pendidikan' => $data['Pendidikan'],
			);
			$dom_pend = new DOMDocument;
			$dom_pend->loadHTML($data_pend[$total_pendidikan]['pendidikan']);

			// Pendidikan non formal
			$data_pend_non[$total_pendidikan] = array(
				'pendidikan_non' => $data['Pendidikan_non_formal'],
			);
			$dom_pend_non = new DOMDocument;
			$dom_pend_non->loadHTML($data_pend_non[$total_pendidikan]['pendidikan_non']);

		}

		foreach($detail as $urutan => $waktu) {
			$data_waktu[$urutan] = array(
				'waktu' => $waktu['Waktu_pelaksanaan'],
			);
			$mulai[$urutan] = explode(" ",$data_waktu[$urutan]['waktu']);
		}

		foreach($mulai as $key => $val) {
			
			$data_waktu[$key] = array(
				'mulai' 	=> $val['2'],
				'selesai' 	=> $val['6'],
			);
			$data_waktu[$key] = $data_waktu[$key]['mulai'].' - '.$data_waktu[$key]['selesai'];
		}
		
		
		$i=0;

		// Pendidikan formal
		foreach($dom_pend->getElementsByTagName('div') as $node_pendidikan)
		{
			$array_pendidikan[] = $dom_pend->saveHTML($node_pendidikan);
		}
		$Pendidikan = preg_replace("/<.+>/sU", "", $array_pendidikan);

		foreach ($Pendidikan as $row4 => $row_pendidikan){
			$data_pendidikan[$row4] = array(
				'Pendidikan' => $row_pendidikan,
			);
		}
		
		// Pendidikan Non formal
		foreach($dom_pend_non->getElementsByTagName('div') as $node_pendidikan_non)
		{
			$array_pendidikan_non[] = $dom_pend_non->saveHTML($node_pendidikan_non);
		}
		$Pendidikan_non = preg_replace("/<.+>/sU", "", $array_pendidikan_non);

		foreach ($Pendidikan_non as $row3 => $row_pendidikan_non){
			$data_pendidikan_non[$row3] = array(
				'Pendidikan_non_formal' => $row_pendidikan_non,
			);
		}

		$templateProcessor->cloneBlock('group1', count($data_pendidikan), true, false, $data_pendidikan);
		$templateProcessor->cloneBlock('group2', count($data_pendidikan_non), true, false, $data_pendidikan_non);
		// $templateProcessor->cloneBlock('group3', count($data_tugas), true, false, $data_tugas);
		// $templateProcessor->cloneBlock('block_group', count($replacements), true, false, $replacements);

		// echo "<pre>";
		// print_r($templateProcessor); exit();
		// echo "</pre>";
		
		$document = $phpWord->loadTemplate('Tamplate/Template-non-konstruksi-docs.docx');
		$document->setValues([
			'ID' 							=> $ID,
			'Posisi' 						=> $Posisi,
			'Nama_perusahaan1' 				=> $Nama_perusahaan1,
			'Nama_personil' 				=> $Nama_personil,
			'Tempat_tanggal_lahir' 			=> $Tempat_tanggal_lahir,
			'inggris' 						=> $Penguasaan_bahasa_inggris,
			'indonesia'						=> $Penguasaan_bahasa_indo,
			'setempat'						=> $Penguasaan_bahasa_setempat,
			'Hari'							=> $Hari,
			'Status2'						=> $Status_kepegawaian2,
		]);	

		$replacements = array(			
			'Tahun',  		
			'Nama', 			
			'Lokasi', 		
			'Pengguna', 		
			'Perusahaan', 	
			'Waktu', 		
			'Posisi_uraian',	
			'Status',
			'Surat' 
		);

		$alphabet = array('a.','x','b.','c.','d.','e.','f.','g.','h.','i.','j.');
		
		$fontStyle['name'] = 'Arial Narrow';
		$fontStyle['size'] = 11;
		// $fontStyle['doubleStrikethrough'] = false;

		$fontStyleBold['name'] = 'Arial Narrow';
		$fontStyleBold['size'] = 11;
		$fontStyleBold['bold'] = true;
		// $fontStyleBold['doubleStrikethrough'] = false;

		$i=0;
		$test4= [];
		$i++;

		$i++;

		$table = new Table(array('borderSize' => 0,'borderColor' => 'white', 'width' => 10000, 'unit' => TblWidth::TWIP));
		foreach($detail as $key => $value) {
			$no = 0;
			$table->addRow();
			$table->addCell(800)->addText('8.'.$key, $fontStyleBold);
			$table->addCell(3100)->addText($replacements[$no].' '.$data_waktu[$key],$fontStyleBold);
			$table->addCell(600)->addText('');
			$table->addCell(600)->addText('');
			$table->addCell(6000)->addText('');				
			foreach ($value as $key2 => $value2){
				if ($key2 != 'PengalamanID'){
					if ($key2 !='Uraian_tugas'){
						$table->addRow();
						$table->addCell(800)->addText('');
						$table->addCell(3100)->addText($alphabet[$no].' '.str_replace('_', ' ', $key2),$fontStyle);
						$table->addCell(600)->addText(':');
						if ($key2 == 'Nama_kegiatan'){
							$table->addCell(6600, array('gridSpan' => 2))->addText($value2,$fontStyleBold);
						}
						else{
							$table->addCell(6600, array('gridSpan' => 2))->addText($value2,$fontStyle);
						}
					}
					else{
						$test2= '';
						$test3= [];


						$test = explode(';',$value2);
	

						foreach ($test as $key3 => $value3){
							if ($key3 == 0){								
								$table->addRow();
								$table->addCell(800)->addText('');
								$table->addCell(3100)->addText($alphabet[$no].' '.$key2,$fontStyle);
								$table->addCell(600)->addText(':');
								$table->addCell(600)->addText('•');
								$table->addCell(6000)->addText(ltrim($value3),$fontStyle);				
							}
							else{
								$table->addRow();
								$table->addCell(800)->addText('');
								$table->addCell(3100)->addText('');
								$table->addCell(600)->addText('');
								$table->addCell(600)->addText('•');
								$table->addCell(6000)->addText(ltrim($value3),$fontStyle);	
							}
						}
					}
				}
				$no++;
			}
			$i++;

			$table->addRow();
			$table->addCell(800)->addText('');
			$table->addCell(3100)->addText('');
			$table->addCell(600)->addText('');
			$table->addCell(600)->addText('');
			$table->addCell(6000)->addText('');			

		}

		// $a = 'asdasd asdasdasd asd asd asda';
		// $b = explode(';',$a);
		// 	$i++;
		// 	echo "<pre>";
		// 	print_r($b); 
		// 	echo "</pre>";
		// exit();
		
		$document->cloneBlock('group1', count($data_pendidikan), true, false, $data_pendidikan);
		$document->cloneBlock('group2', count($data_pendidikan_non), true, false, $data_pendidikan_non);
		$templateProcessor->setComplexBlock('table', $table);
		// $document->cloneBlock('group3', count($data_tugas), true, false, $data_tugas);
		// $document->cloneBlock('block_group', count($replacements), true, false, $replacements);
		$document->setComplexBlock('table', $table);

		$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
		$document->saveAs($temp_file);
		header('Content-Disposition: attachment; filename="' . $file_name . '"');
		readfile($temp_file); // or echo file_get_contents($temp_file);
		unlink($temp_file);  // remove temp file

		$pathToSave = 'file/word/'.$ID.'.docx';
		$templateProcessor->saveAs($pathToSave);
		
	}
}