<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class M_database_pengalaman extends CI_Model {
	var $table  = 'biodata';
	var $column = array("biodata.ID","biodata.Nama_personil","biodata.Tempat_tanggal_lahir"); //set column field database for order and search
	var $order  = array('biodata.Nama_personil' => 'asc'); // default order 

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
			$file_name 	= "Template-database-pengalaman".date("Ymd_His").".xls";
			$title 		= "Template-database-pengalaman";
			$column_end 	= 'I';

			$lap_data   	= $this->api->biodata("export");
			$jumlah_data  	= count($lap_data); 
			$jumlah_kolom 	= $jumlah_data + 1;
		else:
			$file_name 		= "Pengalaman".date("Ymd_His");
			$title 			= "Pengalaman";
			$column_end 	= 'I';
		endif;

		if($p1 == 'template'):
			$spreadsheet = new Spreadsheet();
			$sheet 		 = $spreadsheet->getActiveSheet();
			
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'Nama Kegiatan-8.1');
            $sheet->setCellValue('C1', 'Lokasi Kegiatan-8.1');
            $sheet->setCellValue('D1', 'Pengguna Jasa-8.1');
            $sheet->setCellValue('E1', 'Nama Perusahaan-8.1');
            $sheet->setCellValue('F1', 'Uraian Tugas-8.1');
            $sheet->setCellValue('G1', 'Waktu Pelaksanaan mulai-8.1');
            $sheet->setCellValue('H1', 'Waktu Pelaksanaan selesai-8.1');
            $sheet->setCellValue('I1', 'Posisi Penugasan-8.1');

			$no = 1;
			$x 	= 2;
			foreach($lap_data as $row)
			{
				$sheet->setCellValue('A'.$x, $no++);

				$x++;
			}
		else:
		
		endif;

		$writer = new Xlsx($spreadsheet);
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $file_name .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
}