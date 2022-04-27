<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class M_output_pengalaman extends CI_Model {
	var $table = 'mt_daftar_riwayat';
	var $column = array("mt_daftar_riwayat.PelID","mt_daftar_riwayat.Nama_kegiatan","mt_daftar_riwayat.Lokasi_kegiatan"); //set column field database for order and search
	var $order = array('mt_daftar_riwayat.PelID' => 'asc'); // default order 

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        // $this->load->library(array('PHPExcel','IOFactory'));
    }

    private function _get_datatables_query()
	{
		$table 			= $this->table;
		$searchx 		= $this->input->post('Searchx');

		$this->db->select("
            $table.PelID,
            $table.Nama_kegiatan,
            $table.Lokasi_kegiatan,
            $table.Pengguna_jasa,
            $table.Nama_perusahaan,
            $table.Waktu_pelaksanaan_mulai,
            $table.Waktu_pelaksanaan_selesai,
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

		$this->db->where("mt_daftar_riwayat.PelID", $ID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($p1){

		$table 		= $this->table;

        $this->db->select("
            $table.PelID,
            $table.Nama_kegiatan,
            $table.Lokasi_kegiatan,
            $table.Pengguna_jasa,
            $table.Nama_perusahaan,
            $table.Waktu_pelaksanaan_mulai,
            $table.Waktu_pelaksanaan_selesai,
            $table.Status,
        ");
        $this->db->from($this->table);
        $this->db->where("$table.PelID", $p1);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_by_id_uraian($p1){

        $this->db->select("
            mt_posisi_uraian.ID,
            mt_posisi_uraian.Posisi,
            mt_posisi_uraian.Uraian_tugas,
            mt_posisi_uraian.Status,
        ");
        $this->db->from('mt_posisi_uraian');
        $this->db->where("mt_posisi_uraian.ID", $p1);
		$query = $this->db->get();

		return $query->row();
	}

}