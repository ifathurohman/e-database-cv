<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Database_riwayat extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_database_riwayat","database_riwayat");
        $this->load->library('word');
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "database_riwayat";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;

		$data["title"] 				= $this->lang->line('lb_database');
		$data['url']				= $url;
		$data['module']				= $module;
		$data['content'] 			= 'backend/database_riwayat/list';
		$data['form']				= 'backend/database_riwayat/form';

		$data['upload']				= 'backend/database_riwayat/upload_database_riwayat';
		$data['upload2']			= 'backend/database_riwayat/upload_database_pengalaman';

		$data['filter']				= 'backend/database_riwayat/filter';
		$data['import']				= 'backend/database_riwayat/import';

		$data['b_list']				= 'backend/database_riwayat/breadcumb-list';
		$data['b_form']				= 'backend/database_riwayat/breadcumb-form';

		$data['btn_add']			= $btn_add;
		$data['btn_import']			= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->database_riwayat->get_datatables();
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
			$row[] 	= $a->Nama_personil;
			$row[] 	= $a->Tempat_tanggal_lahir;
			$row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->database_riwayat->count_all(),
			"recordsFiltered" 	=> $this->database_riwayat->count_filtered(),
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
		$this->validation->pengalaman_kerja();

		$ID 							= $this->input->post("ID");

		$PengalamanID 					= $this->input->post("PengalamanID");
		$Nama_kegiatan 					= $this->input->post("Nama_kegiatan");
		$Lokasi_kegiatan 				= $this->input->post("Lokasi_kegiatan");
		$Pengguna_jasa 					= $this->input->post("Pengguna_jasa");
		$Nama_perusahaan 				= $this->input->post("Nama_perusahaan");
		$Waktu_pelaksanaan_mulai 		= $this->input->post("Waktu_pelaksanaan_mulai");
		$Waktu_pelaksanaan_selesai 		= $this->input->post("Waktu_pelaksanaan_selesai");
		$Posisi_penugasan 				= $this->input->post("Posisi_penugasan");
		$Uraian_tugas 					= $this->input->post("Uraian_pengalaman");
        
        $ID 				= $this->main->generate_code_pengalaman();

		$status 			= $this->db->query('SELECT * FROM biodata WHERE Status_bio = 1')->result();

		$update_status_bio 	= array(
			"Status_bio"	=> 0,
		);

		$this->main->general_update("biodata", $update_status_bio, array("ID" => $status[0]->ID));

		$biodata 		= $this->db->query('SELECT * FROM mt_daftar_riwayat WHERE Status_bio = 1')->result();
		$data_detail 	= array(	
			"PelID" 						=> $ID,	
			"Nama_kegiatan" 				=> $Nama_kegiatan,
			"Lokasi_kegiatan" 				=> $Lokasi_kegiatan,
			"Pengguna_jasa" 				=> $Pengguna_jasa,
			"Nama_perusahaan" 				=> $Nama_perusahaan,
			"Waktu_pelaksanaan_mulai" 		=> $Waktu_pelaksanaan_mulai,
			"Waktu_pelaksanaan_selesai" 	=> $Waktu_pelaksanaan_selesai,
			"Posisi"						=> $Posisi_penugasan,
			"Uraian_tugas" 					=> $Uraian_tugas,
			"Status_bio"					=> 0,
		);		

		$this->main->general_save("mt_daftar_riwayat", $data_detail);
		
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
		$list 		= $this->database_riwayat->get_by_id($ID);

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
			$this->main->general_update("mt_pengalaman_kerja", $data, array("ID" => $ID, "ID" => $ID));
		else:
			$this->main->general_update("mt_pengalaman_kerja", $data, array("ID" => $ID));
		endif;

		if($Active == 1):
			$this->main->inser_log(1,6,'pengalaman_kerja', $ID);//$LogType,$Type,$Page,$Content=""
		else:
			$this->main->inser_log(1,7,'pengalaman_kerja', $ID);//$LogType,$Type,$Page,$Content=""
		endif;
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}

	public function template_import(){
		$this->database_riwayat->export('template');
	}
	
	public function save_import(){
		$p1 = $this->input->post('p1');
		if($p1 == 'save'):
			$this->proccess_save_import();
		else:
			$this->upload_import();
		endif;
	}

	public function save_import2(){
		$p1 = $this->input->post('p1');
		if($p1 == 'save'):
			$this->proccess_save_import2();
		else:
			$this->upload_import();
		endif;
	}

	private function upload_import(){
		
		$folder = $this->main->create_folder_general('import_database_riwayat');

		$nmfile                     = "upload_database_riwayat".date("ymdHis");
	    $config['upload_path']      = './'.$folder; //path folder
	    $config['file_name']      	= $nmfile;
		$config['allowed_types']  	= 'xls|xlsx|csv|ods|ots';
		$config['max_size']       	= 10000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file_riwayat')):
			$output = array(
				"status" 	=> false,
				"message"	=> $this->lang->line('lb_excell_empty'),
			);
		else:
			$media 			= $this->upload->data();
			$inputFileName 	= $folder.$media['file_name'];
			try {
				$inputFileType  = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
				$objReader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
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


				if(count($rowData[0]) == 7):
					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";

					$No 						= $this->main->checkInputData($rowData[0][0]);

					$Posisi1 					= $this->main->checkInputData($rowData[0][1]);
					$Nama_perusahaan1 			= $this->main->checkInputData($rowData[0][2]);
					$Nama_personil 				= $this->main->checkInputData($rowData[0][3]);
					$Tempat_tanggal_lahir 		= $this->main->checkInputData($rowData[0][4]);
					$Pendidikan 				= $this->main->checkInputData($rowData[0][5]);
					$Pendidikan_non_formal 		= $this->main->checkInputData($rowData[0][6]);

					if(!$Posisi1):
						$status_product = false;
						$Message .= "- ".'Posisi Yang Diusulkan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Nama_personil):
						$status_product = false;
						$Message .= "- ".'Nama Personil Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Nama_perusahaan1):
						$status_product = false;
						$Message .= "- ".'Nama Perusahaan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Tempat_tanggal_lahir):
						$status_product = false;
						$Message .= "- ".'Tempat & Tanggal Lahir Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Pendidikan):
						$status_product = false;
						$Message .= "- ".'Pendidikan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Pendidikan_non_formal):
						$status_product = false;
						$Message .= "- ".'Pendidikan Non Formal Tidak Boleh Kosong'."<br>";						
					endif;

					array_push($arrCode,$No);

			        $h = array(
				    	"status"					=> $status_product,
				    	"status_data"				=> $status_data,

				    	"No"  						=> $No,
				    	"Posisi1"					=> $Posisi1,
						"Nama_perusahaan1"			=> $Nama_perusahaan1,
						"Nama_personil"				=> $Nama_personil,
						"Tempat_tanggal_lahir"		=> $Tempat_tanggal_lahir,
						"Pendidikan"				=> $Pendidikan,
						"Pendidikan_non_formal"		=> $Pendidikan_non_formal,

				    	"Message" 					=> $Message,
				    );

				    array_push($arrData, $h);

				else:
					$status  = false;
					$message = $this->lang->line('lb_column_not_match');
				endif;
			}

			$sheet2         = $objPHPExcel->getSheet(1);
			$highestRow2    = $sheet2->getHighestRow();
			$highestColumn2 = $sheet2->getHighestColumn();

			$status    = true;
			$message   = "success";

			$arrData2   = array();
			$arrHeader2 = array(); 
			$rowData2   = $sheet2->rangeToArray('A' . 1 . ':' . $highestColumn2 . 1,NULL,TRUE,FALSE);

			if($rowData2): $arrHeader2 = $rowData2; endif;
			$total_data = 0;
			$arrCode2 	= array();
			for ($row1 = 2; $row1 <= $highestRow2; $row1++){
				$total_data += 1;
				$rowData2 		= $sheet2->rangeToArray('A' . $row1 . ':' . $highestColumn2 . $row1,NULL,TRUE,FALSE);


				if(count($rowData2[0]) == 9):
					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";

					$No 						= $this->main->checkInputData($rowData2[0][0]);

					$Nama_kegiatan 				= $this->main->checkInputData($rowData2[0][1]);
					$Lokasi_kegiatan 			= $this->main->checkInputData($rowData2[0][2]);
					$Pengguna_jasa 				= $this->main->checkInputData($rowData2[0][3]);
					$Nama_perusahaan 			= $this->main->checkInputData($rowData2[0][4]);
					$Uraian_tugas 				= $this->main->checkInputData($rowData2[0][5]);
					$Waktu_pelaksanaan_mulai 	= $this->main->checkInputData($rowData2[0][6]);
					$Waktu_pelaksanaan_selesai 	= $this->main->checkInputData($rowData2[0][7]);
					$Posisi 					= $this->main->checkInputData($rowData2[0][8]);

					if(!$Nama_kegiatan):
						$status_product = false;
						$Message .= "- ".'Nama Kegiatan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Lokasi_kegiatan):
						$status_product = false;
						$Message .= "- ".'Lokasi Kegiatan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Pengguna_jasa):
						$status_product = false;
						$Message .= "- ".'Pengguna jasa Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Nama_perusahaan):
						$status_product = false;
						$Message .= "- ".'Nama Perusahaan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Waktu_pelaksanaan_mulai):
						$status_product = false;
						$Message .= "- ".'Waktu Melaksanaan Mulai Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Waktu_pelaksanaan_selesai):
						$status_product = false;
						$Message .= "- ".'Waktu Pelaksanaan Selesai Tidak Boleh Kosong'."<br>";						
					endif;

					if(!$Posisi):
						$status_product = false;
						$Message .= "- ".'Posisi Penugasan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Uraian_tugas):
						$status_product = false;
						$Message .= "- ".'Uraian Tugas Tidak Boleh Kosong'."<br>";						
					endif;

					array_push($arrCode2,$No);

					$h1 = array(
						"status"					=> $status_product,
						"status_data"				=> $status_data,

						"No"  						=> $No,

						"Nama_kegiatan"				=> $Nama_kegiatan,
						"Lokasi_kegiatan"			=> $Lokasi_kegiatan,
						"Pengguna_jasa"				=> $Pengguna_jasa,
						"Nama_perusahaan"			=> $Nama_perusahaan,
						"Uraian_tugas"				=> $Uraian_tugas,
						"Waktu_pelaksanaan_mulai"	=> date('Y-m-d',strtotime($Waktu_pelaksanaan_mulai)),
						"Waktu_pelaksanaan_selesai"	=> date('Y-m-d',strtotime($Waktu_pelaksanaan_selesai)),
						"Posisi"					=> $Posisi,


						"Message" 					=> $Message,
					);

					array_push($arrData2, $h1);

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
				"data2"		 	=> $arrData2,
				"header"	 	=> $arrHeader,
				"header2"	 	=> $arrHeader2,
				"inputFileName" => $inputFileName,
			);
			print_r($output); exit();
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
				$inputFileType  = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
				$objReader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
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
				
				if(count($rowData[0]) == 7):
					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";
					$No 						= $this->main->checkInputData($rowData[0][0]);
					$Posisi1 					= $this->main->checkInputData($rowData[0][1]);
					$Nama_perusahaan1 			= $this->main->checkInputData($rowData[0][2]);
					$Nama_personil 				= $this->main->checkInputData($rowData[0][3]);
					$Tempat_tanggal_lahir 		= $this->main->checkInputData($rowData[0][4]);
					$Pendidikan 				= $this->main->checkInputData($rowData[0][5]);
					$Pendidikan_non_formal 		= $this->main->checkInputData($rowData[0][6]);

					if(!$Posisi1):
						$status_product = false;
						$Message .= "- ".'Posisi Yang Diusulkan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Nama_personil):
						$status_product = false;
						$Message .= "- ".'Nama Personil Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Nama_perusahaan1):
						$status_product = false;
						$Message .= "- ".'Nama Perusahaan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Tempat_tanggal_lahir):
						$status_product = false;
						$Message .= "- ".'Tempat & Tanggal Lahir Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Pendidikan):
						$status_product = false;
						$Message .= "- ".'Pendidikan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Pendidikan_non_formal):
						$status_product = false;
						$Message .= "- ".'Pendidikan Non Formal Tidak Boleh Kosong'."<br>";						
					endif;

					array_push($arrCode,$No);

					$BioID  = $this->main->generate_code_biodata();	
					$SDMID 	= $this->main->generate_code_sdm();

			        if($status_product):
			        	$data_tenaga_ahli = array(
							"ID"						=> $BioID,
							"SDMID"						=> $SDMID,
							"Posisi"					=> $Posisi1,
							"Nama_personil"				=> $Nama_personil,
							"Nama_perusahaan"			=> $Nama_perusahaan1,
							"Tempat_tanggal_lahir"		=> $Tempat_tanggal_lahir,
							"Pendidikan"				=> $Pendidikan,
							"Pendidikan_non_formal"		=> $Pendidikan_non_formal
			        	);

						$cek_data = $this->api->get_one_row("biodata","Posisi,Nama_personil",array("Posisi" => $Posisi1, "Nama_personil" => $Nama_personil));
						if(!$data_tenaga_ahli == $cek_data){
							$BioID = $this->main->general_save("biodata",$data_tenaga_ahli);
						}else{
							$this->main->general_update("biodata", $data_tenaga_ahli, array("ID" => $BioID));
						}

						$data_sdm = array(	
							"ID" 						=> $SDMID,
							"BIOID"						=> $data_tenaga_ahli['ID'],
							"Nama_personil" 			=> $Nama_personil,
						);	
						$cek_data_sdm = $this->api->get_one_row("mt_sdm","Nama_personil",array("Nama_personil" => $Nama_personil));
						if(!$data_sdm == $cek_data_sdm){
							$SDMID = $this->main->general_save('mt_sdm', $data_sdm); 
						}else{
							$this->main->general_update("mt_sdm", $data_sdm, array("ID" => $SDMID));
						}

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

	private function proccess_save_import2(){
		$ID 		= $this->input->post('ID');
		$inputFileName 	= $this->input->post('inputFileName');

		if(is_file("./".$inputFileName)):
			$status  = true;
			$message = $this->lang->line('lb_success_import');

			try {
				$inputFileType  = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
				$objReader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
				$objPHPExcel  	= $objReader->load($inputFileName);
			}
			catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			$sheet2         = $objPHPExcel->getSheet(1);
			$highestRow2    = $sheet2->getHighestRow();
			$highestColumn2 = $sheet2->getHighestColumn();

			$arrData2   = array();
			$arrHeader2 = array(); 
			$rowData2   = $sheet2->rangeToArray('A' . 1 . ':' . $highestColumn2 . 1,NULL,TRUE,FALSE);
			if($rowData2): $arrHeader2 = $rowData2; endif;

			$total_data = 0;
			$arrCode2 	= array();
			for ($row1 = 2; $row1 <= $highestRow2; $row1++){
				$total_data += 1;
				$rowData2 		= $sheet2->rangeToArray('A' . $row1 . ':' . $highestColumn2 . $row1,NULL,TRUE,FALSE);
				
				if(count($rowData2[0]) == 9):
					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";
					$No 						= $this->main->checkInputData($rowData2[0][0]);
					$Nama_kegiatan 				= $this->main->checkInputData($rowData2[0][1]);
					$Lokasi_kegiatan 			= $this->main->checkInputData($rowData2[0][2]);
					$Pengguna_jasa 				= $this->main->checkInputData($rowData2[0][3]);
					$Nama_perusahaan 			= $this->main->checkInputData($rowData2[0][4]);
					$Uraian_tugas 				= $this->main->checkInputData($rowData2[0][5]);
					$Waktu_pelaksanaan_mulai 	= $this->main->checkInputData($rowData2[0][6]);
					$Waktu_pelaksanaan_selesai 	= $this->main->checkInputData($rowData2[0][7]);
					$Posisi 					= $this->main->checkInputData($rowData2[0][8]);

					if(!$Nama_kegiatan):
						$status_product = false;
						$Message .= "- ".'Nama Kegiatan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Lokasi_kegiatan):
						$status_product = false;
						$Message .= "- ".'Lokasi Kegiatan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Pengguna_jasa):
						$status_product = false;
						$Message .= "- ".'Pengguna jasa Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Nama_perusahaan):
						$status_product = false;
						$Message .= "- ".'Nama Perusahaan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Waktu_pelaksanaan_mulai):
						$status_product = false;
						$Message .= "- ".'Waktu Melaksanaan Mulai Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Waktu_pelaksanaan_selesai):
						$status_product = false;
						$Message .= "- ".'Waktu Pelaksanaan Selesai Tidak Boleh Kosong'."<br>";						
					endif;

					if(!$Posisi):
						$status_product = false;
						$Message .= "- ".'Posisi Penugasan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Uraian_tugas):
						$status_product = false;
						$Message .= "- ".'Uraian Tugas Tidak Boleh Kosong'."<br>";						
					endif;

					array_push($arrCode2,$No);

					$PelID  = $this->main->generate_code_pengalaman();

					if($status_product):
						$data_import = array(
							'PelID'						=> $PelID,
							"Nama_kegiatan"				=> $Nama_kegiatan,
							"Lokasi_kegiatan"			=> $Lokasi_kegiatan,
							"Pengguna_jasa"				=> $Pengguna_jasa,
							"Nama_perusahaan"			=> $Nama_perusahaan,
							"Waktu_pelaksanaan_mulai"	=> $Waktu_pelaksanaan_mulai,
							"Waktu_pelaksanaan_selesai"	=> $Waktu_pelaksanaan_selesai,
						);
						
						$cek_data = $this->api->get_one_row("mt_daftar_riwayat","PelID",array("PelID" => $PelID, "Nama_kegiatan" => $Nama_kegiatan));
						if(!$data_import == $cek_data){
							$PelID = $this->main->general_save("mt_daftar_riwayat",$data_import);
						}

						$data_uraian = array(
							"Posisi"					=> $Posisi,
							"Uraian_tugas"				=> $Uraian_tugas,
						);

						$cek_data_uraian = $this->api->get_one_row("mt_posisi_uraian","ID",array("Posisi" => $Posisi));
						if(!$data_uraian == $cek_data_uraian){
							$this->main->general_save('mt_posisi_uraian', $data_uraian); 
						}

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