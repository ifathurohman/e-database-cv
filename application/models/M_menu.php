<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model {
	var $table = 'ut_menu';
	var $column = array("ut_menu.MenuID","ut_menu.Name","ut_menu.Url","ut_menu.Root","ut_menu.Type","ut_menu.Level","parent.Name"); //set column field database for order and search
	var $order = array('Name' => 'asc'); // default order 
	public function __construct()
	{
		parent::__construct();
	}
	private function _get_datatables_query()
	{
		$table = $this->table;
		$this->db->select("
			$table.MenuID,
			$table.Url,
			$table.Root,
			$table.Name,
			$table.Type,
			$table.Level,
			parent.Name as parentName,
			");

		$this->db->from($this->table);
		$this->db->join("ut_menu as parent", "parent.MenuID = $table.ParentID", "left");

		$i = 0;
	
		foreach ($this->column as $item) // loop column 
		{
			if($this->input->post("search")) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
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
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function type($type){
		$type 		= json_decode($type);
		$count 		= count($type);
		$str_type 	= '';
		if($count>0):
			foreach ($type as $k => $v):
				$koma = ',';
				$no = $k + 1;
				if($no == $count): $koma = ''; endif;
				$str_type .= $v.$koma;
			endforeach;
		endif;

		return $str_type;
	}

	public function get_by_id($id){
		$table = $this->table;
		$this->db->select("
			$table.MenuID,
			$table.Name,
			$table.Url,
			$table.Root,
			$table.Level,
			$table.Type,
			$table.ParentID,
			$table.Role,
			$table.Icon,
			parent.Name as parentName,
		");
		$this->db->where("$table.MenuID", $id);
		$this->db->join("ut_menu as parent", "parent.MenuID = $table.ParentID", "left");
		$query = $this->db->get($this->table);

		return $query->row();
	}
}