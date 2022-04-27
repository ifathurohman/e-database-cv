<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	function __construct() {
      parent::__construct();
      $this->load->model("M_dashboard","dashboard");
      $this->main->check_session('out');
  }

  public function list(){

    $arrLabel 		  	= array();
    $arrData 		  	= array();

    $total_tersedia     = $this->db->query("SELECT SUM(mt.Status_pegawai = 'Tersedia') as tersedia FROM (SELECT Status_pegawai FROM mt_sdm WHERE Status ='1') as mt")->result();
    $total_terkontrak   = $this->db->query("SELECT SUM(mt.Status_pegawai = 'Terkontrak') as terkontrak FROM (SELECT Status_pegawai FROM mt_sdm WHERE Status ='1') as mt")->result();
    $total_tender       = $this->db->query("SELECT SUM(mt.Status_pegawai = 'Tender') as tender FROM (SELECT Status_pegawai FROM mt_sdm WHERE Status ='1') as mt")->result();

    $total_peg          = $this->db->query("SELECT COUNT(*) AS total_pegawaian FROM biodata where Status = '1'")->result();
    $total_peg_bulan    = $this->db->query("SELECT MONTH(bio.DateAdd) AS bulan, COUNT(*) AS total_pegawaian FROM biodata AS bio where bio.Status = '1' GROUP BY MONTH(bio.DateAdd)")->result();
    
    $total_proyek       = $this->db->query("SELECT YEAR(pro.Tanggal_tender) AS tahun, COUNT(*) AS jumlah_proyek FROM proyek AS pro GROUP BY YEAR(pro.Tanggal_tender) ORDER BY YEAR(pro.Tanggal_tender) DESC")->result();

    $total_pegawai      = $this->db->query("SELECT YEAR(bio.DateAdd) AS tahun, COUNT(*) AS jumlah_pegawai FROM biodata AS bio GROUP BY YEAR(bio.DateAdd) ORDER BY YEAR(bio.DateAdd) desc")->result();

    $response = array(
      "status"			            => true,
      "message"			            => $this->lang->line('lb_success'),
      "list"				            => $arrData,
      "Label"				            => $arrLabel,

      "tersedia"		            => $total_tersedia[0],
      "terkontrak"              => $total_terkontrak[0],
      "tender"  		            => $total_tender[0],

      "total_peg"               => $total_peg[0],
      "total_peg_bulan"         => $total_peg_bulan[0],

      "total_proyek"            => $total_proyek,
      "total_pegawai"           => $total_pegawai,

      "biodata"                 => $this->biodata(),
      "sdm_pt"                  => $this->sdm_pt(),
      "sdm_non_pt"              => $this->sdm_non_pt(),
      "top_status_pegawai"      => $this->top_status_pegawai(),
    );

    $this->main->echoJson($response);
    	
  }

    public function list_sdm(){
		$data 	    = array();
    	$list_sdm 	= $this->dashboard->get_datatables();
		$i 		      = $this->input->post('start');

		$url 		    = $this->input->post('page_url');
		$module 	  = $this->input->post('page_module');
		$MenuID 	  = $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);

		foreach ($list_sdm as $a):
			$no = $i++;
			$no += 1;
			$txt_status = $this->main->label_pegawai_pt($a->Status_sdm);
			$tg_data = ' data-id="'.$a->ID.'" ';
			$tg_data .= ' data-status="'.$a->Status.'" ';

			$btn_array = array();
			$btn_status = false;
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

			$date_selesai = '';
			$date 		  = date("Y-m-d");

			if($a->Periode_proyek_selesai < $date){
				$date_selesai = '<span style="color:red;font-weight:bold;text-decoration: line-through 2px;">'.$this->main->tanggal_indo($a->Periode_proyek_selesai).'</span>';;
			}else{
				$date_selesai = '<span style="color:#25ae3c;font-weight:bold;">'.$this->main->tanggal_indo($a->Periode_proyek_selesai).'</span>';
			}
			
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= '<div class="iffyTip hideText3">'.$a->Nama_personil.'</div>';
      		$row[] 	= $this->main->label_background_pegawai_pt($a->Status_pegawai);
			$row[] 	= '<div class="iffyTip hideText3">'.$a->Nama_perusahaan.'</div>';
			$row[] 	= '<div class="iffyTip hideText1">'.$a->Proyek.'</div>';
			$row[] 	= $this->main->tanggal_indo($a->Periode_proyek_mulai);
			$row[] 	= $date_selesai;
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				    => $this->input->post('draw'),
      		"recordsTotal" 			=> $this->dashboard->count_all(),
			"recordsFiltered" 		=> $this->dashboard->count_filtered(),
			"data" 				    => $data,
		);

		$this->main->echoJson($response);
	}

    public function list_non(){
		$data 	    = array();
    	$list_non 	= $this->dashboard->get_datatables_non();
		$i 		      = $this->input->post('start');

		$url 		    = $this->input->post('page_url');
		$module 	  = $this->input->post('page_module');
		$MenuID 	  = $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);

		foreach ($list_non as $a):
			$no = $i++;
			$no += 1;
			$txt_status = $this->main->label_pegawai_non_pt($a->Status_sdm);
			$tg_data = ' data-id="'.$a->ID.'" ';
			$tg_data .= ' data-status="'.$a->Status.'" ';

			$btn_array = array();
			$btn_status = false;
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
			
			$date_selesai = '';
			$date 		  = date("Y-m-d");

			if($a->Periode_proyek_selesai < $date){
				$date_selesai = '<span style="color:red;font-weight:bold;text-decoration: line-through 2px;">'.$this->main->tanggal_indo($a->Periode_proyek_selesai).'</span>';
				$data_status  = 'selesai';
			}else{
				$date_selesai = '<span style="color:#25ae3c;font-weight:bold;">'.$this->main->tanggal_indo($a->Periode_proyek_selesai).'</span>';
			}
			
			$row = array();
			$row[] 	= $btn.$temp;
			$row[] 	= '<div class="iffyTip hideText3">'.$a->Nama_personil.'</div>';
      		$row[] 	= $this->main->label_background_pegawai_pt($a->Status_pegawai);
			$row[] 	= '<div class="iffyTip hideText3">'.$a->Nama_perusahaan.'</div>';
			$row[] 	= '<div class="iffyTip hideText1">'.$a->Proyek.'</div>';
			$row[] 	= $this->main->tanggal_indo($a->Periode_proyek_mulai);
			$row[] 	= $date_selesai;
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				    => $this->input->post('draw'),
      "recordsTotal" 		=> $this->dashboard->count_all_non(),
			"recordsFiltered" => $this->dashboard->count_filtered_non(),
			"data" 				    => $data,
		);

		$this->main->echoJson($response);
	}

	public function list_ahli(){
		$data 	    = array();
    	$list_non 	= $this->dashboard->get_datatables_ahli();
		$i 		      = $this->input->post('start');

		$url 		    = $this->input->post('page_url');
		$module 	  = $this->input->post('page_module');
		$MenuID 	  = $this->api->get_menuID($url);
		$read_menu 	= $this->api->read_menu($MenuID);

		foreach ($list_non as $a):
			$no = $i++;
			$no += 1;
			$tg_data = ' data-id="'.$a->ID.'" ';
			$tg_data .= ' data-status="'.$a->Status.'" ';

			$btn_array = array();
			$btn_status = false;
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
			$row[] 	= $a->Nama_personil;
			$row[] 	= '<div class="iffyTip hideText2">'.$a->Pendidikan.'</div>';
			$row[] 	= '<div class="iffyTip hideText2">'.$a->Pendidikan_non_formal.'</div>';
			$data[] = $row;
		endforeach;

		$response = array(
			"draw" 				    => $this->input->post('draw'),
     		"recordsTotal" 			=> $this->dashboard->count_all_ahli(),
			"recordsFiltered" 		=> $this->dashboard->count_filtered_ahli(),
			"data" 				    => $data,
		);

		$this->main->echoJson($response);
	}

  public function save_sdm(){
		$url 				  = $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 		= $this->api->read_menu($MenuID);

		$Crud 		= $this->input->post("crud");
		if($Crud == "insert"): $p3 = $read_menu->insert;
		elseif($Crud == "update"): $p3 = $read_menu->update;
		else: $p3 = 0;
		endif;

		// $this->main->check_session('out',$Crud, $p3);
		$this->validation->sdm_pegawai_ciriajasa();

		$ID 							      = $this->input->post("ID");

		$Nama 				          = $this->input->post("Nama");
		$Status_pegawai 				= $this->input->post("Status_pegawai");
		$Nama_perusahaan 				= $this->input->post("Nama_perusahaan");
		$Proyek 						    = $this->input->post("Proyek");

		$Peride_proyek_mulai 		= $this->input->post("Peride_proyek_mulai");
		$Peride_proyek_selesai 	= $this->input->post("Peride_proyek_selesai");
        
		$data_detail = array(	
			"ID" 						=> $ID,	
			"Nama_personil"           	=> $Nama,
			"Status_pegawai" 			=> $Status_pegawai,
			"Nama_perusahaan" 		    => $Nama_perusahaan,
			"Proyek" 					=> $Proyek,
			"Periode_proyek_mulai" 		=> $Peride_proyek_mulai,
			"Periode_proyek_selesai" 	=> $Peride_proyek_selesai,
		);		

		$this->main->general_update("mt_sdm", $data_detail, array("ID" => $ID));

		$data_biodata = array(	
			"SDMID" 					=> $data_detail['ID'],	
			"Nama_personil"           	=> $Nama,
		);

		$this->main->general_update("biodata", $data_biodata, array("SDMID" => $ID));		
		
		$message = $this->lang->line('lb_success_insert');
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

  public function save_sdm_non(){
		$url 				  = $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 		= $this->api->read_menu($MenuID);

		$Crud 		= $this->input->post("crud");
		if($Crud == "insert"): $p3 = $read_menu->insert;
		elseif($Crud == "update"): $p3 = $read_menu->update;
		else: $p3 = 0;
		endif;

		// $this->main->check_session('out',$Crud, $p3);
		$this->validation->sdm_pegawai_non_ciriajasa();

		$ID 							= $this->input->post("ID");

		$Nama 				          	= $this->input->post("Nama");
		$Status_pegawai 				= $this->input->post("Status_pegawai");
		$Nama_perusahaan 				= $this->input->post("Nama_perusahaan");
		$Proyek 						= $this->input->post("Proyek");

		$Peride_proyek_mulai 			= $this->input->post("Peride_proyek_mulai");
		$Peride_proyek_selesai 			= $this->input->post("Peride_proyek_selesai");
        
		$data_detail = array(	
			"ID" 						=> $ID,	
			"Nama_personil"           	=> $Nama,
			"Status_pegawai" 			=> $Status_pegawai,
			"Nama_perusahaan" 		    => $Nama_perusahaan,
			"Proyek" 					=> $Proyek,
			"Periode_proyek_mulai" 		=> $Peride_proyek_mulai,
			"Periode_proyek_selesai" 	=> $Peride_proyek_selesai,
		);		

		$this->main->general_update("mt_sdm", $data_detail, array("ID" => $ID));	

		$data_biodata = array(	
			"SDMID" 					=> $data_detail['ID'],	
			"Nama_personil"           	=> $Nama,
		);

		$this->main->general_update("biodata", $data_biodata, array("SDMID" => $ID));	
		
		$message = $this->lang->line('lb_success_insert');
		
		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

  private function biodata(){

    $this->db->select("
        ID,
        Posisi,
        Nama_personil,
        Nama_perusahaan,
        Tempat_tanggal_lahir,
        Pendidikan,
        Pendidikan_non_formal,
        Nomor_hp,
        Email,
        Status,
    ");

    $this->db->from('biodata');
    $this->db->where("Status", 1);
    // $this->db->limit(10);

    $biodata = $this->db->get();
    
    return $biodata->result();
    
  }

  private function top_status_pegawai(){

    $this->db->select("
        ID,
        Nama_personil,
        Status_pegawai,
        Nama_perusahaan,
        Proyek,
        Periode_proyek_mulai,
        Periode_proyek_selesai,
        Status_sdm,
        Status,
    ");

    $this->db->from('mt_sdm');

    $top_status_pegawai = $this->db->get();
    
    return $top_status_pegawai->result();
    
  }

  private function sdm_non_pt(){

    $this->db->select("
        ID,
        Nama_personil,
        Status_pegawai,
        Nama_perusahaan,
        Proyek,
        Periode_proyek_mulai,
        Periode_proyek_selesai,
        Status_sdm,
        Status,
    ");

    $this->db->from('mt_sdm');
    $this->db->where("Status_sdm", 2);
    // $this->db->limit(10);

    $sdm_non_pt = $this->db->get();

    
    return $sdm_non_pt->result();
    
  }

  private function sdm_pt(){

    $this->db->select("
        ID,
        Nama_personil,
        Status_pegawai,
        Nama_perusahaan,
        Proyek,
        Periode_proyek_mulai,
        Periode_proyek_selesai,
        Status_sdm,
        Status,
    ");

    $this->db->from('mt_sdm');
    $this->db->where("Status_sdm", 1);
    // $this->db->limit(10);

    $sdm_pt = $this->db->get();

    return $sdm_pt->result();

  }

}