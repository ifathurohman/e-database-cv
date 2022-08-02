<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class M_non_konstruksi extends CI_Model {
	var $table = 'mt_non_konstruksi';
	var $column = array("mt_non_konstruksi.ID","mt_non_konstruksi.Posisi","mt_non_konstruksi.Nama_perusahaan1","mt_non_konstruksi.Nama_personil"); //set column field database for order and search
	var $order = array('mt_non_konstruksi.Nama_personil' => 'asc'); // default order 

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

		$this->db->where("mt_non_konstruksi.ID", $ID);
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
		// if($p1 == 'template'):
		// 	$file_name 	= "Template-leave".date("Ymd_His").".xls";
		// 	$title 		= "Template-leave";
		// 	$column_end = 'B';
		// else:
			$file_name 	= "Konstruksi".date("Ymd_His").".docx";
		// 	$title 		= "Konstruksi";
		// 	$column_end = 'B';

			$lap_data     		= $this->api->konstruksi("export");
		// 	$jumlah_data  		= count($lap_data); 
		// 	$jumlah_kolom 		= $jumlah_data + 1;
		// endif;
		
		// echo '<pre>';
		// print_r(json_encode($lap_data)); exit();
		// echo '</pre>';
       	$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Tamplate/Template-non-konstruksi-docs.docx');
		foreach ($lap_data as $k => $v) {
			$templateProcessor->setValues([
				'Posisi' 					=> $v->Posisi,
				'Nama_perusahaan1' 			=> $v->Nama_perusahaan1,
				'Nama_personil' 			=> $v->Nama_personil,
				'Tempat_tanggal_lahir' 		=> $v->Tempat_tanggal_lahir,
				'Pendidikan' 				=> $v->Pendidikan,
				'Pendidikan_non_formal' 	=> $v->Pendidikan_non_formal,
				'inggris' 					=> $v->Penguasaan_bahasa_inggris,
				'indonesia'					=> $v->Penguasaan_bahasa_indo,

				'id'						=> $v->PengalamanID,
				'kegiatan'					=> $v->Nama_kegiatan,
				'lokasi'					=> $v->Lokasi_kegiatan,
				'jasa'						=> $v->Pengguna_jasa,
				'perusahaan'				=> $v->Nama_perusahaan,
				'tugas'						=> $v->Uraian_tugas,
				'waktu'						=> $v->Waktu_pelaksanaan,
				'posisi'					=> $v->Posisi_penugasan,
				'status'					=> $v->Status_kepegawaian,
				'surat'						=> $v->Surat_referensi,
			]);
		}


		header('Content-Disposition: attachment;filename="'.$file_name.'"');

		$templateProcessor->saveAs('php://output');
		exit;
	}
}