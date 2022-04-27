<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_page_setting	 extends CI_Model {
	var $table = 'ut_page_setting';
	var $column = array("ut_page_setting.PageID","ut_page_setting.ParentID","ut_page_setting.Name","ut_page_setting.Summary","ut_page_setting.Status","ut_page_setting.Description"); //set column field database for order and search
	var $order = array('Name' => 'asc'); // default order 

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }

    private function _get_datatables_query()
	{
		$table 			= $this->table;
		$HakAksesType   = $this->session->HakAksesType;
		$CompanyID 		= $this->session->CompanyID;
		$Companyx 		= $this->input->post('Companyx');
		$searchx 		= $this->input->post('Searchx');

		if(in_array($HakAksesType, array(1,2))):
			$CompanyID = $Companyx;
		endif;

		$this->db->select("
			$table.PageID,
			$table.ParentID,
			$table.Name,
			$table.Summary,
			$table.Status,
			$table.Description,
			$table.Type
			");
		$this->db->from($this->table);
		$this->db->where("$table.CompanyID", $CompanyID);

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
		$CompanyID 		= $this->session->CompanyID;
		$Companyx 		= $this->input->post('Companyx');
		$searchx 		= $this->input->post('Searchx');

		if(in_array($HakAksesType, array(1,2))):
			$CompanyID = $Companyx;
		endif;

		$this->db->where("ut_page_setting.CompanyID", $CompanyID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($p1){
		$CompanyID 		= $this->session->CompanyID;
		$HakAksesType   = $this->session->HakAksesType;

		$this->db->select("
			ut_page_setting.PageID as ID,
			ut_page_setting.ParentID,
			ut_page_setting.Type,
			ut_page_setting.Name,
			ut_page_setting.Summary,
			ut_page_setting.Description,
			ut_page_setting.Status,
		");
		$this->db->from($this->table);
		$this->db->where("ut_page_setting.PageID", $p1);
		$query = $this->db->get();

		return $query->row();
	}
	
}