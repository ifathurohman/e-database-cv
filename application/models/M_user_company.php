<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_user_company extends CI_Model {
	var $table = 'mt_employee';
	var $column = array("mt_employee.EmployeeID","mt_branch.Name","mt_employee.Name","mt_employee.Gender","mt_employee.Email","ut_role.Name","mt_employee.DeciveID","mt_employee.Status"); //set column field database for order and search
	var $order = array('Name' => 'asc'); // default order 

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->library(array('PHPExcel','IOFactory'));
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
			$table.EmployeeID,
			$table.Name,
			$table.Gender,
			$table.Email,
			$table.Status,
			$table.DeviceID,
			$table.ImeiDefault,
			ut_role.Name as RoleName,
			mt_branch.Name as BranchName,
			");
		$this->db->join("ut_role", "ut_role.RoleID = mt_employee.RoleID");
		$this->db->join("mt_branch", "mt_branch.BranchID = mt_employee.BranchID");
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

		$this->db->join("ut_role", "ut_role.RoleID = mt_employee.RoleID");
		$this->db->where("mt_employee.CompanyID", $CompanyID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($p1){
		$CompanyID 		= $this->session->CompanyID;
		$HakAksesType   = $this->session->HakAksesType;

		$this->db->select("
			mt_employee.EmployeeID,
			mt_employee.Name,
			mt_employee.Email,
			mt_employee.Username,
			mt_employee.Phone,
			mt_employee.PhoneCountry,
			mt_employee.Gender,
			mt_employee.StartWork,
			mt_employee.Imei,
			mt_employee.ImeiDefault,
			mt_employee.Image,
			mt_employee.CompanyID,
			mt_employee.RoleID,
			mt_employee.ParentID,
			mt_employee.WorkPatternID,
			mt_employee.BranchID,
			mt_employee.NameLast,
			mt_employee.Departement,
			mt_employee.Web,
			mt_employee.Nik,
			mt_employee.Position,
			role.Name 		as RoleName,
			company.Name 	as CompanyName,
			parent.Name 	as parentName,
			pattern.Name 	as patternName,
			mt_branch.Name 	as branchName,
		");
		$this->db->from($this->table);
		$this->db->join("ut_role role", "role.RoleID = mt_employee.RoleID and role.CompanyID = mt_employee.CompanyID");
		$this->db->join("mt_employee parent", "mt_employee.ParentID = parent.EmployeeID and parent.CompanyID = mt_employee.CompanyID","left");
		$this->db->join("mt_workpattern pattern", "pattern.WorkPatternID = mt_employee.WorkPatternID and pattern.CompanyID = mt_employee.CompanyID");
		$this->db->join("ut_user company", "company.UserID = mt_employee.CompanyID");
		$this->db->join("mt_branch", "mt_branch.BranchID = mt_employee.BranchID");
		$this->db->where("mt_employee.EmployeeID", $p1);
		if(!in_array($HakAksesType, array(1,2))):
			$this->db->where("mt_employee.CompanyID", $CompanyID);
		endif;
		$query = $this->db->get();

		return $query->row();
	}

	public function export($p1=""){
		if($p1 == 'template'):
			$file_name 	= "Template-users".date("Ymd_His").".xls";
			$title 		= "Template-users";
			$column_end = 'N';
		else:
			$file_name 	= "Users".date("Ymd_His").".xls";
			$title 		= "Users";
			$column_end = 'M';

			$lap_data     		= $this->api->employee("users");
			$jumlah_data  		= count($lap_data); 
			$jumlah_kolom 		= $jumlah_data + 1;
		endif;

		$objPHPExcel 		= new PHPExcel();
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("PIPESYS")
		            ->setLastModifiedBy("PIPESYS")
		            ->setTitle("Office 2003 XLS Test Document")
		            ->setSubject("Office 2003 XLS Test Document")
		            ->setDescription("PIPESYS")
		            ->setKeywords("office 2003 openxml php")
		            ->setCategory("PIPESYS");
		$border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));

		foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

		if($p1 == 'template'):
			$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_nik'))
	            ->setCellValue('B1', $this->lang->line('lb_name'))
	            ->setCellValue('C1', $this->lang->line('lb_gender'))
	            ->setCellValue('D1', $this->lang->line('lb_email'))
	            ->setCellValue('E1', $this->lang->line('lb_start_work_date'))
	            ->setCellValue('F1', $this->lang->line('lb_iso_country'))
	            ->setCellValue('G1', $this->lang->line('lb_phone_number'))
	            ->setCellValue('H1', $this->lang->line('lb_work_pattern'))
	            ->setCellValue('I1', $this->lang->line('lb_parent'))
	            ->setCellValue('J1', $this->lang->line('lb_username'))
	            ->setCellValue('K1', $this->lang->line('lb_password'))
	            ->setCellValue('L1', $this->lang->line('lb_role'))
	            ->setCellValue('M1', $this->lang->line('lb_mandatory_imei'))
	            ->setCellValue('N1', $this->lang->line('lb_branch'))
	            ;
		else:
			$objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);
		
		    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_nik'))
	            ->setCellValue('B1', $this->lang->line('lb_name'))
	            ->setCellValue('C1', $this->lang->line('lb_gender'))
	            ->setCellValue('D1', $this->lang->line('lb_email'))
	            ->setCellValue('E1', $this->lang->line('lb_start_work_date'))
	            ->setCellValue('F1', $this->lang->line('lb_iso_country'))
	            ->setCellValue('G1', $this->lang->line('lb_phone_number'))
	            ->setCellValue('H1', $this->lang->line('lb_work_pattern'))
	            ->setCellValue('I1', $this->lang->line('lb_parent'))
	            ->setCellValue('J1', $this->lang->line('lb_username'))
	            ->setCellValue('K1', $this->lang->line('lb_role'))
	            ->setCellValue('L1', $this->lang->line('lb_mandatory_imei'))
	            ->setCellValue('M1', $this->lang->line('lb_branch'))
	            ;

	        $i    = 1;
			$ii   = 2; 
	        foreach ($lap_data as $k => $v) {
	        	$urut = $ii++;

	        	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, $v->Nik)
	              ->setCellValue('B'.$urut, $v->Name)
	              ->setCellValue('C'.$urut, $this->main->label_gender($v->Email))
	              ->setCellValue('D'.$urut, $v->Email)
	              ->setCellValue('E'.$urut, $v->StartWork)
	              ->setCellValue('F'.$urut, $v->PhoneCountry)
	              ->setCellValue('G'.$urut, $v->Phone)
	              ->setCellValue('H'.$urut, $v->patternName)
	              ->setCellValue('I'.$urut, $v->parentName)
	              ->setCellValue('J'.$urut, $v->Username)
	              ->setCellValue('K'.$urut, $v->RoleName)
	              ->setCellValue('L'.$urut, $this->main->label_default_imei($v->ImeiDefault))
	              ->setCellValue('M'.$urut, $v->branchName)
	              ;
	        }
		endif;

       	// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($title);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$file_name.'"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}