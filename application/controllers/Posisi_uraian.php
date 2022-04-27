<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Posisi_uraian extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_pengalaman","pengalaman");
        $this->load->library('word');
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$ID					= $this->main->generate_code_pengalaman();
		$module 			= "pengalaman";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;
		
		$ID = $this->main->generate_code_pengalaman();

		$data["title"] 				= $this->lang->line('lb_pengalaman');
		$data['url']				= $url;
		$data['module']				= $module;
		$data['id']					= $ID;

		$data['upload2']			= 'backend/pengalaman/upload_uraian2';

		$data['btn_add']			= $btn_add;
		$data['btn_import']			= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->pengalaman->get_datatables();
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
			$row[] 	= $a->Nama_kegiatan;
			$row[] 	= $a->Lokasi_kegiatan;
			$row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->pengalaman->count_all(),
			"recordsFiltered" 	=> $this->pengalaman->count_filtered(),
			"data" 				=> $data,
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
		$list 		= $this->pengalaman->get_by_id($ID);

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
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);

	}
	
	public function template_import(){
		$this->pengalaman->export2('template');
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

		// $this->validation->user_company_import();
		
		$folder = $this->main->create_folder_general('import_posisi_uraian');

		$nmfile                     = "upload_posisi_uraian".date("ymdHis");
	    $config['upload_path']      = './'.$folder; //path folder
	    $config['file_name']      	= $nmfile;
		$config['allowed_types']  	= 'xls|xlsx|csv|ods|ots';
		$config['max_size']       	= 10000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file_posisi')):
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


				if(count($rowData[0]) == 3):
					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";

					$No 						= $this->main->checkInputData($rowData[0][0]);
					$Posisi						= $this->main->checkInputData($rowData[0][1]);
					$Uraian_tugas	 			= $this->main->checkInputData($rowData[0][2]);

					if(!$Posisi):
						$status_product = false;
						$Message .= "- ".'Posisi Penugasan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Uraian_tugas):
						$status_product = false;
						$Message .= "- ".'Uraian Tugas Tidak Boleh Kosong'."<br>";						
					endif;

					array_push($arrCode,$No);

			        $h = array(
				    	"status"			=> $status_product,
				    	"status_data"		=> $status_data,

				    	"No"  				=> $No,
				    	"Posisi"			=> $Posisi,
				    	"Uraian_tugas"		=> $Uraian_tugas,

				    	"Message" 			=> $Message,
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

				if(count($rowData[0]) == 3):
					$Message 		= '';

					$status_product = true;
					$status_data 	= "insert";
					$No 						= $this->main->checkInputData($rowData[0][0]);
					$Posisi						= $this->main->checkInputData($rowData[0][1]);
					$Uraian_tugas	 			= $this->main->checkInputData($rowData[0][2]);

					if(!$Posisi):
						$status_product = false;
						$Message .= "- ".'Posisi Penugasan Tidak Boleh Kosong'."<br>";						
					endif;
					if(!$Uraian_tugas):
						$status_product = false;
						$Message .= "- ".'Uraian Tugas Tidak Boleh Kosong'."<br>";						
					endif;

					array_push($arrCode,$No);

			        if($status_product):
			        	$data_import = array(
			        		'ID'						=> $ID,
							"Posisi"					=> $Posisi,
							"Uraian_tugas"			    => $Uraian_tugas,
			        	);
						$this->main->general_save("mt_posisi_uraian",$data_import);

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