
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpWord\Element\Field;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Style\Font;
class Konstruksi extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model("M_konstruksi","konstruksi");
		$this->load->library('word');
	}

	public function index(){
		$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$ID					= $this->main->generate_code_konstruksi();
		$module 			= "konstruksi";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;
		
		$ID = $this->main->generate_code_konstruksi();

		$data["title"] 		= $this->lang->line('lb_konstruksi');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['id']			= $ID;
		$data['content'] 	= 'backend/konstruksi/list';
		$data['form']		= 'backend/konstruksi/form';
		$data['filter']		= 'backend/konstruksi/filter';
		$data['import']		= 'backend/konstruksi/import';

		$data['b_list']		= 'backend/konstruksi/breadcumb-list';
		$data['b_form']		= 'backend/konstruksi/breadcumb-form';

		$data['btn_add']	= $btn_add;
		$data['btn_import']	= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->konstruksi->get_datatables();
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
				$btn = $this->main->button('action_list',$a->ID,$btn_array);
			else:
				$btn = '';
			endif;
			$temp = '<span class="dt-id" '.$tg_data.'>'.$no.'</span>';
			
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= $a->ID;
			$row[] 	= $a->Posisi;
			$row[] 	= $a->Nama_perusahaan1;
			$row[] 	= $a->Nama_personil;
			$row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->konstruksi->count_all(),
			"recordsFiltered" 	=> $this->konstruksi->count_filtered(),
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
				$Status_kepegawaian 			= $this->input->post("Status_kepegawaian[]");
				$Surat_referensi 				= $this->input->post("Surat_referensi[]");
				$Status_kepegawaian_2 			= $this->input->post("Status_kepegawaian2");

				$Status 						= $this->input->post("Status");
				$Pernyataan 					= $this->input->post("Pernyataan");

		// $ID 							= $this->session->ID;
		// $HakAksesType   				= $this->session->HakAksesType;

		// if(in_array($HakAksesType,array(1,2))): $ID = $Company; endif;

				$Image = $this->save_image();

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
					"Pernyataan" 					=> $Pernyataan,
				);

				$ID = $this->main->generate_code_konstruksi();

				$data_konstruksi['ID'] 		= $ID;
				$ID = $this->main->general_save("mt_konstruksi", $data_konstruksi);

				foreach($PengalamanID as $key => $val) {
					$data_detail[] = array(
						"ID" 							=> $data_konstruksi['ID'],	
						"PengalamanID" 					=> $val,	
						"Nama_kegiatan" 				=> $Nama_kegiatan[$key],
						"Lokasi_kegiatan" 				=> $Lokasi_kegiatan[$key],
						"Pengguna_jasa" 				=> $Pengguna_jasa[$key],
						"Nama_perusahaan" 				=> $Nama_perusahaan[$key],
						"Uraian_tugas" 					=> $Uraian_tugas[$key],
						"Waktu_pelaksanaan" 			=> $Waktu_pelaksanaan[$key],
						"Posisi_penugasan" 				=> $Posisi_penugasan[$key],
						"Status_kepegawaian" 			=> $Status_kepegawaian[$key],
						"Surat_referensi" 				=> $Surat_referensi[$key],
					);			
				}

				$message = $this->lang->line('lb_success_insert');
				$DetID = $this->db->insert_batch('mt_konstruksi_det', $data_detail); 

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
				$list 		= $this->konstruksi->get_by_id($ID);

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
				$ID 		= $this->session->ID;
				if(!in_array($HakAksesType, array(1,2))):
					$this->main->general_update("mt_konstruksi", $data, array("ID" => $ID, "ID" => $ID));
				else:
					$this->main->general_update("mt_konstruksi", $data, array("ID" => $ID));
				endif;

				if($Active == 1):
			$this->main->inser_log(1,6,'konstruksi', $ID);//$LogType,$Type,$Page,$Content=""
		else:
			$this->main->inser_log(1,7,'konstruksi', $ID);//$LogType,$Type,$Page,$Content=""
		endif;
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}

	private function save_image(){

		$nmfile                     = "hadir_".date("ymdHis");
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
	    $ID 		= $this->session->ID;
	    $HakAksesType   = $this->session->HakAksesType;
	    
	    $image = '';
	    if($upload):
	    	$image 	= "img/employee/".$gbr['file_name'];
	    	if($Crud == "update"):
	    		if(in_array($HakAksesType,array(1,2))):
	    			$this->main->remove_file("mt_employee","Image",array("EmployeeID" => $ID));
	    		else:
	    			$this->main->remove_file("mt_employee","Image",array("EmployeeID" => $ID, "ID" => $ID));
	    		endif;
	    	endif;
	    endif;

	    return $image;
	}

	public function export($p1=""){
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

		$where 	= array("Nama_personil" => $Nama_personil);
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
			$mulai = explode(" ",$data_waktu[$urutan]['waktu']);
		}

		foreach($mulai as $key => $val) {
			$data_waktu = array(
				'mulai' 	=> $mulai['2'],
				'selesai' 	=> $mulai['6'],
			);
			$data_waktu = $data_waktu['mulai'].' - '.$data_waktu['selesai'];
		}

		foreach($detail as $total => $uraian) {
			// Uraian Tugas
			$data_uraian[$total] = array(
				'uraian' => $uraian['Uraian_tugas'],
			);
			$dom_uraian = new DOMDocument;
			$dom_uraian->loadHTML($data_uraian[$total]['uraian']);
			
			$replacements[] = array(
				'I' 			=> $total,
				'Tahun'  		=> $data_waktu,
				'Nama' 			=> @$uraian['Nama_kegiatan'],
				'Lokasi' 		=> @$uraian['Lokasi_kegiatan'],
				'Pengguna' 		=> @$uraian['Pengguna_jasa'],
				'Perusahaan' 	=> @$uraian['Nama_perusahaan'],
				'Waktu' 		=> @$uraian['Waktu_pelaksanaan'],
				'Posisi' 		=> @$uraian['Posisi_penugasan'],
				'Status' 		=> @$uraian['Status_kepegawaian'],
				'Surat' 		=> @$uraian['Surat_referensi']
				
			);
		}

		// Uraian Tugas
		foreach($dom_uraian->getElementsByTagName('div') as $node_uraian)
		{
			$array_uraian[] = $dom_uraian->saveHTML($node_uraian);
		}
		$Uraian_tugas = preg_replace("/<.+>/sU", "", $array_uraian);
		foreach ($Uraian_tugas as $row1 => $row_tugas) {
			$data_tugas[$row1] = array(
				'Tugas' 	   => $row_tugas,
			);
		}
		
		// Pendidikan formal
		foreach($dom_pend->getElementsByTagName('div') as $node_pendidikan)
		{
			$array_pendidikan[] = $dom_pend->saveHTML($node_pendidikan);
		}
		$Pendidikan = preg_replace("/<.+>/sU", "", $array_pendidikan);
		// $total_pendidikan = count($Pendidikan);
		// if ($total_pendidikan < 0):
		foreach ($Pendidikan as $row4 => $row_pendidikan){
			$data_pendidikan[$row4] = array(
				'Pendidikan' => $row_pendidikan,
			);
		}
		// endif;		

		// echo "<pre>";
		// print_r($data_pendidikan); exit();
		// echo "</pre>";

		$templateProcessor->cloneBlock('group1', count($data_pendidikan), true, false, $data_pendidikan);
		
		// Pendidikan Non formal
		foreach($dom_pend_non->getElementsByTagName('div') as $node_pendidikan_non)
		{
			$array_pendidikan_non[] = $dom_pend_non->saveHTML($node_pendidikan_non);
		}
		$Pendidikan_non = preg_replace("/<.+>/sU", "", $array_pendidikan_non);
		// $total_pendidikan_non = count($Pendidikan_non);
		// if ($total_pendidikan_non < 0):
		foreach ($Pendidikan_non as $row3 => $row_pendidikan_non){
			$data_pendidikan_non[$row3] = array(
				'Pendidikan_non_formal' => $row_pendidikan_non,
			);
		}
		// endif;

		// echo "<pre>";
		// print_r($data_pendidikan_non); exit();
		// // echo "</pre>";

		$templateProcessor->cloneBlock('group1', count($data_pendidikan), true, false, $data_pendidikan);
		$templateProcessor->cloneBlock('group2', count($data_pendidikan_non), true, false, $data_pendidikan_non);
		$templateProcessor->cloneBlock('group3', count($data_tugas), true, false, $data_tugas);
		// $templateProcessor->cloneRowAndSetValues('Tugas', $data_tugas);	
		$templateProcessor->cloneBlock('block_group', count($replacements), true, false, $replacements);
		
		// echo "<pre>";
		// print_r($templateProcessor); exit();
		// echo "</pre>";
		
		$pathToSave = 'file/word/'.$ID.'.docx';
		$templateProcessor->saveAs($pathToSave);

		// $templateProcessor->saveAs('php://output');
		
		exit;
		
	}
	
	
	public function export_word($p1=""){
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

		// $where 	= array("ID" => $ID);
		// $cek 	= $this->api->get_one_row("mt_konstruksi", "ID",$where);


		// $ID 	= $cek->ID;

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

	public function template_import(){
		$this->konstruksi->export('template');
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
		$ID 		= $this->session->ID;
		if(in_array($HakAksesType, array(1,2))):
			$ID 		= $this->input->post('Company');
		endif;
		$folder = $this->main->create_folder_general('import_konstruksi');

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
	    	$arrCode 	= array();
	    	for ($row = 2; $row <= $highestRow; $row++){
	    		$total_data += 1;
	    		$rowData 		= $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

	    		if(count($rowData[0]) == 2):
	    			$Message 		= '';

	    			$status_product = true;
	    			$status_data 	= "insert";
	    			$Code 			= $this->main->checkInputData($rowData[0][0]);
	    			$Name 			= $this->main->checkInputData($rowData[0][1]);

	    			$ck_code = $this->db->count_all("mt_konstruksi where ID = '$ID' and Code = '$Code'");
	    			if(!$Code):
	    				$status_product = false;
	    				$Message .= "- ".$this->lang->line('lb_code_null')."<br>";
	    			elseif($ck_code>0):
	    				$status_product = false;
	    				$Message .= "- ".$this->lang->line('lb_code_already')."<br>";
	    			elseif(in_array($Code,$arrCode)):
	    				$status_product = false;
	    				$Message .= "- "."Duplicate Code"."<br>";
	    			elseif(strlen($Code)<3):
	    				$status_product = false;
	    				$Message .= "- ".$this->lang->line('lb_code_max')."<br>";
	    			endif;
	    			array_push($arrCode,$Code);

	    			if(!$Name):
	    				$status_product = false;
	    				$Message .= "- ".$this->lang->line('lb_name_null')."<br>";
	    			endif;

	    			$h = array(
	    				"status"		=> $status_product,
	    				"status_data"	=> $status_data,
	    				"Name"  		=> $Name,
	    				"Code"			=> $Code,
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
	    		"ID"		=> $ID,
	    	);
	    endif;

	    $this->main->echoJson($output);
	}

	private function proccess_save_import(){
		$ID 		= $this->input->post('ID');
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
			$arrCode 	= array();
			for ($row = 2; $row <= $highestRow; $row++){
				$total_data += 1;
				$rowData 		= $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

				if(count($rowData[0]) == 2):
					$status_product = true;
					$status_data 	= "insert";
					$Code 			= $this->main->checkInputData($rowData[0][0]);
					$Name 			= $this->main->checkInputData($rowData[0][1]);

					$ck_code = $this->db->count_all("mt_konstruksi where ID = '$ID' and Code = '$Code'");
					if(!$Code):
						$status_product = false;
					elseif($ck_code>0):
						$status_product = false;
					elseif(in_array($Code,$arrCode)):
						$status_product = false;
					elseif(strlen($Code)<3):
						$status_product = false;
					endif;
					array_push($arrCode,$Code);

					if(!$Name):
						$status_product = false;
					endif;


					if($status_product):
						$data_import = array(
							'ID'		=> $ID,
							'Name'			=> $Name,
							"Code"			=> $Code,
							"Status"		=> 1,
						);
						$this->main->general_save("mt_konstruksi", $data_import);
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
}