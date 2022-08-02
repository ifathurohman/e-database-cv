<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class M_dashboard extends CI_Model {
	var $table  	= 'mt_sdm';
	var $table2 	= 'biodata';
	var $column 	= array("mt_sdm.ID","mt_sdm.Nama_personil","mt_sdm.Status_pegawai","mt_sdm.Nama_perusahaan"); 
	var $column2 	= array("biodata.ID","biodata.Nama_personil","biodata.Pendidikan","biodata.Pendidikan_non_formal"); 
	// var $order  = array('mt_sdm.Nama_personil' => 'asc'); // default order 

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        // $this->load->library(array('PHPExcel','IOFactory'));
    }

    private function _get_datatables_query()
	{
		$table 			    = $this->table;
		// $HakAksesType    = $this->session->HakAksesType;
		// $ID 		        = $this->session->ID;
		// $Companyx 		= $this->input->post('Companyx');
		$searchx 		    = $this->input->post('Searchx');

		// if(in_array($HakAksesType, array(1,2))):
		// 	$ID = $Companyx;
		// endif;

		$this->db->select("
			$table.ID,
			$table.Nama_personil,
			$table.Status_pegawai,
			$table.Proyek,
			$table.Nama_perusahaan,
			$table.Periode_proyek_mulai,
			$table.Periode_proyek_selesai,
			$table.Status_sdm,
			$table.Status,
		");
		$this->db->from($this->table);
        $this->db->where("$table.Status_sdm", 1);
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

    private function _get_datatables_query_non()
	{
		$table 			    = $this->table;
		// $HakAksesType    = $this->session->HakAksesType;
		// $ID 		        = $this->session->ID;
		// $Companyx 		= $this->input->post('Companyx');
		$searchx 		    = $this->input->post('Searchx');

		// if(in_array($HakAksesType, array(1,2))):
		// 	$ID = $Companyx;
		// endif;

		$this->db->select("
			$table.ID,
			$table.Nama_personil,
			$table.Status_pegawai,
			$table.Proyek,
			$table.Nama_perusahaan,
			$table.Periode_proyek_mulai,
			$table.Periode_proyek_selesai,
			$table.Status_sdm,
			$table.Status,
		");
		$this->db->from($this->table);
        $this->db->where("$table.Status_sdm", 2);
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

	private function _get_datatables_query_ahli()
	{
		$table2 			= $this->table2;
		// $HakAksesType    = $this->session->HakAksesType;
		// $ID 		        = $this->session->ID;
		// $Companyx 		= $this->input->post('Companyx');
		$searchx 		    = $this->input->post('Searchx');

		// if(in_array($HakAksesType, array(1,2))):
		// 	$ID = $Companyx;
		// endif;

		$this->db->select("
			$table2.ID,
	        $table2.Posisi,
	        $table2.Nama_personil,
	        $table2.Nama_perusahaan,
	        $table2.Tempat_tanggal_lahir,
	        $table2.Pendidikan,
	        $table2.Pendidikan_non_formal,
	        $table2.Nomor_hp,
	        $table2.Email,
	        $table2.Status,
		");
		$this->db->from($table2);
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

	function get_datatables_non()
	{
		$this->_get_datatables_query_non();
		if($this->input->post('length') != -1)
		$this->db->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_ahli()
	{
		$this->_get_datatables_query_ahli();
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

		$this->db->where("mt_sdm.ID", $ID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

    //non

    function count_filtered_non()
	{
		$this->_get_datatables_query_non();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_non()
	{
		$HakAksesType   = $this->session->HakAksesType;
		$ID 		    = $this->session->ID;
		$Companyx 		= $this->input->post('Companyx');
		$searchx 		= $this->input->post('Searchx');

		if(in_array($HakAksesType, array(1,2))):
			$ID = $Companyx;
		endif;

		$this->db->where("mt_sdm.ID", $ID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	//ahli

	function count_filtered_ahli()
	{
		$this->_get_datatables_query_ahli();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_ahli()
	{
		$HakAksesType   = $this->session->HakAksesType;
		$ID 		    = $this->session->ID;
		$Companyx 		= $this->input->post('Companyx');
		$searchx 		= $this->input->post('Searchx');

		if(in_array($HakAksesType, array(1,2))):
			$ID = $Companyx;
		endif;

		$this->db->where("biodata.ID", $ID);
		$this->db->from("biodata");
		return $this->db->count_all_results();
	}

	public function get_by_id($p1){

		$table 			    = $this->table;

		$this->db->select("
			$table.ID,
			$table.Nama_personil,
			$table.Status_pegawai,
			$table.Proyek,
			$table.Nama_perusahaan,
			$table.Periode_proyek_mulai,
			$table.Periode_proyek_selesai,
			$table.Status,
		");
		$this->db->from($this->table);
		$this->db->where("$table.Status", 1);
		$query = $this->db->get();

		return $query->row();
	}

}