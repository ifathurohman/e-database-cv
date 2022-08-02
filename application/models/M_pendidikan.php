<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

class M_pendidikan extends CI_Model {
	var $table = 'biodata';
	var $column = array("biodata.ID","biodata.Nama_personil","biodata.Tempat_tanggal_lahir"); //set column field database for order and search
	var $order = array('biodata.Nama_personil' => 'asc'); // default order 

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
			$table.Nama_personil,
			$table.Tempat_tanggal_lahir,
			$table.Pendidikan,
			$table.Pendidikan_non_formal,
			$table.Nomor_hp,
			$table.Email,
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

		$this->db->where("biodata.ID", $ID);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($p1){

		$table 			    = $this->table;

        $this->db->select("
            $table.ID,
            $table.Nama_personil,
            $table.Tempat_tanggal_lahir,
            $table.Pendidikan,
            $table.Pendidikan_non_formal,
            $table.Nomor_hp,
            $table.Email,
            $table.Status,
        ");
		$this->db->from($this->table);
		$this->db->where("$table.Status", 1);
		$query = $this->db->get();

		return $query->row();
	}

	public function export($p1=""){
		if($p1 == 'template'):
			$file_name 	= "Template-pengalaman".date("Ymd_His").".xls";
			$title 		= "Template-pengalaman";
			$column_end = 'B';
		else:
			$file_name 	= "Pengalaman".date("Ymd_His").".xls";
			$title 		= "Pengalaman";
			$column_end = 'B';

			$lap_data     		= $this->api->pengalaman("export");
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

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_code'))
	            ->setCellValue('B1', $this->lang->line('lb_name'))
	            ;

		if($p1 == 'template'):
			
		else:
			$objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	        $i    = 1;
			$ii   = 2; 
	        foreach ($lap_data as $k => $v) {
	        	$urut = $ii++;

	        	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, $v->Code)
	              ->setCellValue('B'.$urut, $v->Name)
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