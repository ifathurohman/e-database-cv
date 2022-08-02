<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Writer\Word2007;

class M_konstruksi extends CI_Model {
	var $table = 'mt_konstruksi';
	var $column = array("mt_konstruksi.ID","mt_konstruksi.Posisi","mt_konstruksi.Nama_perusahaan1","mt_konstruksi.Nama_personil"); //set column field database for order and search
	var $order = array('mt_konstruksi.Nama_personil' => 'asc'); // default order 

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        // $this->load->library(array('PHPExcel','IOFactory'));
    }

    private function _get_datatables_query()
	{
		$table 			    = $this->table;
		// $HakAksesType   = $this->session->HakAksesType;
		// $ID 		        = $this->session->ID;
		// $Companyx 		= $this->input->post('Companyx');
		$searchx 		= $this->input->post('Searchx');

		// if(in_array($HakAksesType, array(1,2))):
		// 	$ID = $Companyx;
		// endif;

		$this->db->select("
			$table.ID,
			$table.Posisi,
			$table.Nama_perusahaan1,
			$table.Nama_personil,
			$table.Tempat_tanggal_lahir,
			$table.Pendidikan,
			$table.Pendidikan_non_formal,

			$table.Penguasaan_bahasa_indo,

			$table.Penguasaan_bahasa_inggris,

			$table.Penguasaan_bahasa_setempat,

			$table.Status_kepegawaian2,
			$table.Pernyataan,
			$table.Status,
		");
		$this->db->from($this->table);
		$this->db->where("$table.Status", 1);

		$i = 0;
	
		foreach ($this->column as $item) // loop column 
		{
			if($searchx) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
					$this->db->like($item, $searchx);
				}
				else
				{
					$this->db->or_like($item, $searchx);
				}

				if(count($this->column) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$column[$i] = $item; // set column array variable to order processing
			$i++;
		}
		
		if($this->input->post('order')) // here order processing
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($this->input->post('length') != -1)
		$this->db->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$HakAksesType   = $this->session->HakAksesType;
		$ID 		    = $this->session->ID;
		$Companyx 		= $this->input->post('Companyx');
		$searchx 		= $this->input->post('Searchx');

		if(in_array($HakAksesType, array(1,2))):
			$ID = $Companyx;
		endif;

		$this->db->where("mt_konstruksi.ID", $ID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($p1){

		$table 			    = $this->table;

		$this->db->select("
            $table.ID,
            $table.Posisi,
            $table.Nama_perusahaan1,
            $table.Nama_personil,
            $table.Tempat_tanggal_lahir,
            $table.Pendidikan,
            $table.Pendidikan_non_formal,

            $table.Penguasaan_bahasa_indo,

            $table.Penguasaan_bahasa_inggris,

            $table.Penguasaan_bahasa_setempat,

            $table.Status_kepegawaian2,
            $table.Pernyataan,
            $table.Status,
		");
		$this->db->from($this->table);
		$this->db->where("$table.Status", 1);
		$query = $this->db->get();

		return $query->row();
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
		$templateProcessor 				= new \PhpOffice\PhpWord\TemplateProcessor('Tamplate/Template-konstruksi-docs.docx');
	
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
		
		// print_r($ID);
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		$pathToSave = 'file/word/'.$ID.'.docx';
		$templateProcessor->saveAs($pathToSave);
		
		exit;
		
	}
}