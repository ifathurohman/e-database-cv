<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class M_output_cv extends CI_Model {
	var $table 	= 'mt_konstruksi';
	var $table2 = 'mt_non_konstruksi';
	var $column 	= array("mt_konstruksi.ID","mt_konstruksi.Posisi","mt_konstruksi.Nama_perusahaan1","mt_konstruksi.Nama_personil"); //set column field database for order and search
	var $column2 	= array("mt_non_konstruksi.ID","mt_non_konstruksi.Posisi","mt_non_konstruksi.Nama_perusahaan1","mt_non_konstruksi.Nama_personil"); //set column field database for order and search
	var $order 		= array('mt_konstruksi.ID' => 'desc'); // default order 
	var $order2		= array('mt_non_konstruksi.ID' => 'desc'); // default order 

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
    private function _get_datatables_query_non_konstruksi()
	{
		$table2 	    = $this->table2;
		$searchx 		= $this->input->post('Searchx');

		$this->db->select("
			$table2.ID,
			$table2.Posisi,
			$table2.Nama_perusahaan1,
			$table2.Nama_personil,
			$table2.Tempat_tanggal_lahir,
			$table2.Pendidikan,
			$table2.Pendidikan_non_formal,

			$table2.Penguasaan_bahasa_indo,

			$table2.Penguasaan_bahasa_inggris,

			$table2.Penguasaan_bahasa_setempat,

			$table2.Status_kepegawaian2,
			$table2.Pernyataan,
			$table2.Status,
		");
		$this->db->from($this->table2);
		$this->db->where("$table2.Status", 1);

		$i = 0;
	
		foreach ($this->column2 as $item) // loop column2 
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

				if(count($this->column2) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$column2[$i] = $item; // set column2 array variable to order processing
			$i++;
		}
		
		if($this->input->post('order')) // here order processing
		{
			$this->db->order_by($column2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order2))
		{
			$order2 = $this->order2;
			$this->db->order_by(key($order2), $order2[key($order2)]);
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

	function get_datatables_non_konstruksi()
	{
		$this->_get_datatables_query_non_konstruksi();
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

		$this->db->where("mt_konstruksi.ID", $ID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	
	public function count_all_non_konstruksi()
	{
		$ID 	= $this->session->ID;
		$this->db->where("mt_non_konstruksi.ID", $ID);
		$this->db->from("mt_non_konstruksi");
		return $this->db->count_all_results();
	}

	function count_filtered_non_konstuksi()
	{
		$this->_get_datatables_query_non_konstruksi();
		$query = $this->db->get();
		return $query->num_rows();
	}


	public function get_by_id($p1){

		$table 		= $this->table;

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

			det.PengalamanID,
			det.Nama_kegiatan,
			det.Lokasi_kegiatan,
			det.Pengguna_jasa,
			det.Nama_perusahaan,
			det.Uraian_tugas,
			det.Waktu_pelaksanaan,
			det.Posisi_penugasan,
			det.Status_kepegawaian,
			det.Surat_referensi,
		");
		$this->db->from($this->table);
		$this->db->join("mt_konstruksi_det det", "$table.ID = det.ID");
		$this->db->where("$table.ID", $p1);
		$query = $this->db->get();

		return $query->result_array();
	}

	public function get_by_id2($p1){

		$table2 	= $this->table2;

		$this->db->select("
            $table2.ID,
            $table2.Posisi,
            $table2.Nama_perusahaan1,
            $table2.Nama_personil,
            $table2.Tempat_tanggal_lahir,
            $table2.Pendidikan,
            $table2.Pendidikan_non_formal,
            $table2.Penguasaan_bahasa_indo,
            $table2.Penguasaan_bahasa_inggris,
            $table2.Penguasaan_bahasa_setempat,
            $table2.Status_kepegawaian2,
            $table2.Pernyataan,
            $table2.Status,

			det_non.PengalamanID,
			det_non.Nama_kegiatan,
			det_non.Lokasi_kegiatan,
			det_non.Pengguna_jasa,
			det_non.Nama_perusahaan,
			det_non.Uraian_tugas,
			det_non.Waktu_pelaksanaan,
			det_non.Posisi_penugasan,
			det_non.Status_kepegawaian,
			det_non.Surat_referensi,
		");
		$this->db->from($this->table2);
		$this->db->join("mt_non_konstruksi_det det_non", "$table2.ID = det_non.ID");
		$this->db->where("$table2.ID", $p1);
		$query = $this->db->get();

		return $query->result_array();
	}

}