<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_role extends CI_Model {
	var $table = 'ut_role';
	var $column = array("RoleID","Name"); //set column field database for order and search
	var $order = array('Name' => 'asc'); // default order 

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }

    private function _get_datatables_query()
	{
		$table = $this->table;
		$this->db->select("
			$table.RoleID,
			$table.Name,
			$table.Type,
			$table.Status,
			");

		$this->db->from($this->table);
		$HakAksesType   = $this->session->HakAksesType;
		$CompanyID 		= $this->session->CompanyID;
		if($HakAksesType == 1):
			$this->db->where_in("$table.Type", array(1,2,3));
		elseif($HakAksesType == 2):
			$this->db->where_in("$table.Type", array(2,3));
		else:
			$this->db->where("$table.CompanyID", $CompanyID);
		endif;
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
		$table = $this->table;
		$HakAksesType   = $this->session->HakAksesType;
		$CompanyID 		= $this->session->CompanyID;
		if($HakAksesType == 1):
			$this->db->where_in("$table.Type", array(1,2,3));
		elseif($HakAksesType == 2):
			$this->db->where_in("$table.Type", array(2,3));
		else:
			$this->db->where("$table.CompanyID", $CompanyID);
		endif;
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}