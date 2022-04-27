<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sdm_pegawai_ciriajasa extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_sdm_pegawai","sdm_pegawai_ciriajasa");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "sdm_pegawai_ciriajasa";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		$btn_import = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); $btn_import = 'import'; endif;

		$SDMID = $this->api->get_one_row("mt_sdm","ID",array("Status" => 1));
		if($SDMID):
            $SDMID = $SDMID->ID;
        endif;

		$data["title"] 		= $this->lang->line('lb_sdm_pegawai_ciriajasa');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['id']			= $SDMID;
		$data['content'] 	= 'backend/sdm_pegawai_ciriajasa/list';
		$data['form']		= 'backend/sdm_pegawai_ciriajasa/form';
		$data['filter']		= 'backend/sdm_pegawai_ciriajasa/filter';
		$data['import']		= 'backend/sdm_pegawai_ciriajasa/import';
		$data['btn_add']	= $btn_add;
		$data['btn_import']	= $btn_import;
		$this->load->view('backend/index',$data);
	}

	public function list(){
		$data 	= array();
		$list 	= $this->sdm_pegawai_ciriajasa->get_datatables();
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
			$row[] 	= $this->main->label_background($txt_status);
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				=> $this->input->post('draw'),
			"recordsTotal" 		=> $this->sdm_pegawai_ciriajasa->count_all(),
			"recordsFiltered" 	=> $this->sdm_pegawai_ciriajasa->count_filtered(),
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
		$this->validation->sdm_pegawai_ciriajasa();

		$ID 							= $this->input->post("ID");

		$Status_pegawai 				= $this->input->post("Status_pegawai");
		$Nama_perusahaan 				= $this->input->post("Nama_perusahaan");
		$Proyek 						= $this->input->post("Proyek");

		$Peride_proyek_mulai 			= $this->input->post("Peride_proyek_mulai");
		$Peride_proyek_selesai 			= $this->input->post("Peride_proyek_selesai");
        
		$data_detail = array(	
			"ID" 							=> $ID,	
			"Status_pegawai" 				=> $Status_pegawai,
			"Nama_perusahaan" 				=> $Nama_perusahaan,
			"Proyek" 						=> $Proyek,
			"Periode_proyek_mulai" 			=> $Peride_proyek_mulai,
			"Periode_proyek_selesai" 		=> $Peride_proyek_selesai,
			"Status_sdm" 					=> 1,
		);		
		
		
		$message = $this->lang->line('lb_success_insert');
		$this->main->general_update("mt_sdm", $data_detail, array("ID" => $ID));	
		
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
		// $this->main->check_session('out', 'update', $read_menu->update);
		$ID 		= $this->input->post('ID');
		$list 		= $this->sdm_pegawai_ciriajasa->get_by_id($ID);

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
			$this->main->general_update("mt_sdm_pegawai_ciriajasa", $data, array("sdm_pegawai_ciriajasaID" => $ID, "CompanyID" => $CompanyID));
		else:
			$this->main->general_update("mt_sdm_pegawai_ciriajasa", $data, array("sdm_pegawai_ciriajasaID" => $ID));
		endif;

		if($Active == 1):
			$this->main->inser_log(1,6,'sdm_pegawai_ciriajasa', $ID);//$LogType,$Type,$Page,$Content=""
		else:
			$this->main->inser_log(1,7,'sdm_pegawai_ciriajasa', $ID);//$LogType,$Type,$Page,$Content=""
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
		$CompanyID 		= $this->session->CompanyID;
		$HakAksesType   = $this->session->HakAksesType;
	    
	    $image = '';
	    if($upload):
	    	$image 	= "img/employee/".$gbr['file_name'];
	    	if($Crud == "update"):
	    		if(in_array($HakAksesType,array(1,2))):
	    			$this->main->remove_file("mt_employee","Image",array("EmployeeID" => $ID));
	    		else:
	    			$this->main->remove_file("mt_employee","Image",array("EmployeeID" => $ID, "CompanyID" => $CompanyID));
	    		endif;
	    	endif;
	    endif;

	    return $image;
	}

	public function export(){
		$this->sdm_pegawai->export();
	}

	public function template_import(){
		$this->sdm_pegawai->export('template');
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
		$CompanyID 		= $this->session->CompanyID;
		if(in_array($HakAksesType, array(1,2))):
			$CompanyID 		= $this->input->post('Company');
		endif;
		$folder = $this->main->create_folder_general('import_sdm_pegawai');

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

					$ck_code = $this->db->count_all("mt_sdm_pegawai where CompanyID = '$CompanyID' and Code = '$Code'");
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
				"CompanyID"		=> $CompanyID,
			);
		endif;

		$this->main->echoJson($output);
	}

	private function proccess_save_import(){
		$CompanyID 		= $this->input->post('CompanyID');
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

					$ck_code = $this->db->count_all("mt_sdm_pegawai where CompanyID = '$CompanyID' and Code = '$Code'");
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
			        		'CompanyID'		=> $CompanyID,
			        		'Name'			=> $Name,
			        		"Code"			=> $Code,
			        		"Status"		=> 1,
			        	);
			        	$this->main->general_save("mt_sdm_pegawai", $data_import);
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