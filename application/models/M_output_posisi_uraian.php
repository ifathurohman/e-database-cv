<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class M_output_posisi_uraian extends CI_Model {
	var $table = 'mt_posisi_uraian';
	var $column = array("mt_posisi_uraian.ID","mt_posisi_uraian.Posisi","mt_posisi_uraian.Uraian_tugas"); //set column field database for order and search
	var $order = array('mt_posisi_uraian.ID' => 'asc'); // default order 

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        // $this->load->library(array('PHPExcel','IOFactory'));
    }

    private function _get_datatables_query_uraian()
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
            $table.Uraian_tugas,
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

	function get_datatables_uraian()
	{
		$this->_get_datatables_query_uraian();
		if($this->input->post('length') != -1)
		$this->db->limit($this->input->post('length'), $this->input->post('start'));
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered_uraian()
	{
		$this->_get_datatables_query_uraian();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_uraian()
	{
		$HakAksesType   = $this->session->HakAksesType;
		$ID 		    = $this->session->ID;

		$this->db->where("mt_posisi_uraian.ID", $ID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id_uraian($p1){

		$table 		= $this->table;

        $this->db->select("
            $table.ID,
            $table.Posisi,
            $table.Uraian_tugas,
            $table.Status,
        ");
        $this->db->from($this->table);
        $this->db->where("$table.ID", $p1);
		$query = $this->db->get();

		return $query->row();
	}

}