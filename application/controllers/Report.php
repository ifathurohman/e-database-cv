<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_report","report");
        $this->load->library(array('PHPExcel','IOFactory','encrypt'));
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= $url;
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;

		$name = $this->api->get_one_row("ut_menu","Name",array("Url" => $url))->Name;

		$data["title"] 		= $name;
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/report/list';
		$data['filter']		= 'backend/report/filter';
		$this->load->view('backend/index',$data);
	}

	public function Change(){
		$status = $this->report->ReportType();
		$ReportType 	= $this->input->post('ReportType');

		if($status):
			$this->load->view('backend/report/lap_'.$ReportType);
		else:
			$this->load->view('backend/report/not_found');
		endif;
	}

	public function Print(){
		$status = $this->report->ReportType();
		$ReportType 	= $this->input->post('ReportType');
		$Print 			= $this->input->post('Print');
		$Print2 		= $this->input->post('Print2');

		if($status && in_array($Print,array('pdf','excel'))):
			if($Print == 'pdf'):
				$name 	= $this->report->ReportName();
				$co 	= $this->report->GetCompany();

				$data['content'] = 'backend/report/lap_'.$ReportType;
				$data['css'] 	 = 'backend/report/css';
				$data['logo'] 	 = $co->Image;
				$data['Name'] 	 = $name;
				$data['CompanyName'] 	 = $co->Name;
				$this->load->view('backend/report/index',$data);

				$this->load->library('dompdf_gen');
				$html = $this->output->get_output(); 
				$this->dompdf->load_html($html);
				if($Print2 == 'lanscape'):
					$this->dompdf->set_paper('legal', 'landscape');
				endif;
	            $this->dompdf->render();
	            $name = str_replace(" ", "_", $name);
	            $this->dompdf->stream($name."_".date("Ymd_His").".pdf",array('Attachment'=>0));
	        else:
	        	$this->{$ReportType."_excel"}();
			endif;
		else:
			$this->load->view('backend/report/not_found');
		endif;
	}

	private function leave_total_excel(){
		$name 	= $this->report->ReportName();
		$list 	= $this->report->leave_total();
		$jumlah_data  		= count($list); 
		$jumlah_kolom 		= $jumlah_data + 1;
		$column_end 		= 'F';

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))
	            ->setCellValue('B1', $this->lang->line('lb_nik'))
	            ->setCellValue('C1', $this->lang->line('lb_name'))
	            ->setCellValue('D1', $this->lang->line('lb_departement'))
	            ->setCellValue('E1', $this->lang->line('lb_role'))
	            ->setCellValue('F1', $this->lang->line('lb_leave_taken'))
	            ;

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	    if($jumlah_data>0):
	    	$i    = 1;
			$ii   = 2; 
			$no   = 0;
	        foreach ($list as $k => $v) {
	        	$no 	+= 1;
	        	$urut 	= $ii++;
	        	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, $no)
	              ->setCellValue('B'.$urut, $v->Nik)
	              ->setCellValue('C'.$urut, $v->Name)
	              ->setCellValue('D'.$urut, $v->Departement)
	              ->setCellValue('E'.$urut, $v->roleName)
	              ->setCellValue('F'.$urut, $v->Total)
	              ;
	        }
	    else:
	    	$urut 	= 2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, "Data Not Found")->mergeCells('A'.$urut.':F'.$urut);
	    endif;

	    // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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

	private function leave_detail_excel(){
		$name 	= $this->report->ReportName();
		$list 	= $this->report->leave_detail();
		$jumlah_data  		= count($list); 
		$jumlah_kolom 		= $jumlah_data + 1;
		$column_end 		= 'N';

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))
	            ->setCellValue('B1', $this->lang->line('lb_nik'))
	            ->setCellValue('C1', $this->lang->line('lb_name'))
	            ->setCellValue('D1', $this->lang->line('lb_departement'))
	            ->setCellValue('E1', $this->lang->line('lb_role'))
	            ->setCellValue('F1', $this->lang->line('lb_date'))
	            ->setCellValue('G1', $this->lang->line('lb_leave_type'))
	            ->setCellValue('H1', $this->lang->line('lb_leave_start'))
	            ->setCellValue('I1', $this->lang->line('lb_leave_end'))
	            ->setCellValue('J1', $this->lang->line('lb_remark'))
	            ->setCellValue('K1', $this->lang->line('lb_status'))
	            ->setCellValue('L1', $this->lang->line('lb_approval_by'))
	            ->setCellValue('M1', $this->lang->line('lb_approval_date'))
	            ->setCellValue('N1', $this->lang->line('lb_approval_remark'))
	            ;

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	    if($jumlah_data>0):
	    	$i    = 1;
			$ii   = 2; 
			$no   = 0;
			$ID   = '';
	        foreach ($list as $k => $v) {
	        	if($v->EmployeeID != $ID):
					$no += 1;
					$nox = $no;
					$ID = $v->EmployeeID;
				else:
					$nox = '';
				endif;
	        	$urut 	= $ii++;
	        	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, $nox)
	              ->setCellValue('B'.$urut, $v->Nik)
	              ->setCellValue('C'.$urut, $v->EmployeeName)
	              ->setCellValue('D'.$urut, $v->Departement)
	              ->setCellValue('E'.$urut, $v->roleName)
	              ->setCellValue('F'.$urut, $v->Date)
	              ->setCellValue('G'.$urut, $v->leaveName)
	              ->setCellValue('H'.$urut, $v->From)
	              ->setCellValue('I'.$urut, $v->To)
	              ->setCellValue('J'.$urut, $v->Remark)
	              ->setCellValue('K'.$urut, $this->main->label_status_ap($v->ApproveStatus))
	              ->setCellValue('L'.$urut, $v->ApproveBy)
	              ->setCellValue('M'.$urut, $v->ApproveDate)
	              ->setCellValue('M'.$urut, $v->ApproveRemark)
	              ;
	        }
	    else:
	    	$urut 	= 2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, "Data Not Found")->mergeCells('A'.$urut.':N'.$urut);
	    endif;

	    // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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

	private function report_log_excel(){
		$name 	= $this->report->ReportName();
		$list 	= $this->report->log();
		$jumlah_data  		= count($list); 
		$jumlah_kolom 		= $jumlah_data + 1;
		$column_end 		= 'G';

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))
	            ->setCellValue('B1', $this->lang->line('lb_nik'))
	            ->setCellValue('C1', $this->lang->line('lb_name'))
	            ->setCellValue('D1', $this->lang->line('lb_departement'))
	            ->setCellValue('E1', $this->lang->line('lb_date'))
	            ->setCellValue('F1', $this->lang->line('lb_page'))
	            ->setCellValue('G1', $this->lang->line('lb_action'))
	            ;

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	    if($jumlah_data>0):
	    	$i    = 1;
			$ii   = 2; 
			$no   = 0;
			$ID   = '';
	        foreach ($list as $k => $v) {
	        	if($v->EmployeeID != $ID):
					$no += 1;
					$nox = $no;
					$ID = $v->EmployeeID;
				else:
					$nox = '';
				endif;

				$Lables     = $this->main->label_log($v->Type, $v->Page, $v->Content);
				$Page 		= $this->main->label_log2($v->Page);

	        	$urut 	= $ii++;
	        	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, $nox)
	              ->setCellValue('B'.$urut, $v->employeeNik)
	              ->setCellValue('C'.$urut, $v->employeeName)
	              ->setCellValue('D'.$urut, $v->employeeDepartement)
	              ->setCellValue('E'.$urut, $v->DateAdd)
	              ->setCellValue('F'.$urut, $Page)
	              ->setCellValue('G'.$urut, $Lables)
	              ;
	        }
	    else:
	    	$urut 	= 2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, "Data Not Found")->mergeCells('A'.$urut.':G'.$urut);
	    endif;

	    // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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

	private function report_log_company_excel(){
		$name 	= $this->report->ReportName();
		$list 	= $this->report->log_company();
		$jumlah_data  		= count($list); 
		$jumlah_kolom 		= $jumlah_data + 1;
		$column_end 		= 'E';

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))
	            ->setCellValue('B1', $this->lang->line('lb_name'))
	            ->setCellValue('C1', $this->lang->line('lb_date'))
	            ->setCellValue('D1', $this->lang->line('lb_page'))
	            ->setCellValue('E1', $this->lang->line('lb_action'))
	            ;

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	    if($jumlah_data>0):
	    	$i    = 1;
			$ii   = 2; 
			$no   = 0;
			$ID   = '';
	        foreach ($list as $k => $v) {
	        	if($v->EmployeeID != $ID):
					$no += 1;
					$nox = $no;
					$ID = $v->EmployeeID;
				else:
					$nox = '';
				endif;

				$Lables     = $this->main->label_log($v->Type, $v->Page, $v->Content);
				$Page 		= $this->main->label_log2($v->Page);

	        	$urut 	= $ii++;
	        	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, $nox)
	              ->setCellValue('B'.$urut, $v->companyName)
	              ->setCellValue('C'.$urut, $v->DateAdd)
	              ->setCellValue('D'.$urut, $Page)
	              ->setCellValue('E'.$urut, $Lables)
	              ;
	        }
	    else:
	    	$urut 	= 2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, "Data Not Found")->mergeCells('A'.$urut.':E'.$urut);
	    endif;

	    // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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

	private function overtime_form_excel(){
		$name 	= $this->report->ReportName();
		$list 	= $this->report->overtime_form();
		$jumlah_data  		= count($list); 
		$jumlah_kolom 		= $jumlah_data + 1;
		$column_end 		= 'M';

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))
	            ->setCellValue('B1', $this->lang->line('lb_nik'))
	            ->setCellValue('C1', $this->lang->line('lb_name'))
	            ->setCellValue('D1', $this->lang->line('lb_departement'))
	            ->setCellValue('E1', $this->lang->line('lb_role'))
	            ->setCellValue('F1', $this->lang->line('lb_date'))
	            ->setCellValue('G1', $this->lang->line('lb_start'))
	            ->setCellValue('H1', $this->lang->line('lb_end'))
	            ->setCellValue('I1', $this->lang->line('lb_remark'))
	            ->setCellValue('J1', $this->lang->line('lb_status'))
	            ->setCellValue('K1', $this->lang->line('lb_approval_by'))
	            ->setCellValue('L1', $this->lang->line('lb_approval_date'))
	            ->setCellValue('M1', $this->lang->line('lb_approval_remark'))
	            ;

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	    if($jumlah_data>0):
	    	$i    = 1;
			$ii   = 2; 
			$no   = 0;
			$ID   = '';
	        foreach ($list as $k => $v) {
	        	if($v->EmployeeID != $ID):
					$no += 1;
					$nox = $no;
					$ID = $v->EmployeeID;
				else:
					$nox = '';
				endif;
	        	$urut 	= $ii++;
	        	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, $nox)
	              ->setCellValue('B'.$urut, $v->Nik)
	              ->setCellValue('C'.$urut, $v->EmployeeName)
	              ->setCellValue('D'.$urut, $v->Departement)
	              ->setCellValue('E'.$urut, $v->roleName)
	              ->setCellValue('F'.$urut, $v->Date)
	              ->setCellValue('G'.$urut, $v->From)
	              ->setCellValue('H'.$urut, $v->To)
	              ->setCellValue('I'.$urut, $v->Remark)
	              ->setCellValue('J'.$urut, $this->main->label_status_ap($v->ApproveStatus))
	              ->setCellValue('K'.$urut, $v->ApproveBy)
	              ->setCellValue('L'.$urut, $v->ApproveDate)
	              ->setCellValue('M'.$urut, $v->ApproveRemark)
	              ;
	        }
	    else:
	    	$urut 	= 2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, "Data Not Found")->mergeCells('A'.$urut.':M'.$urut);
	    endif;

	    // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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

	private function attendance_report_excel(){
		$name 	= $this->report->ReportName();
		$list 	= $this->report->attendance_report();
		$jumlah_data  		= count($list); 
		$jumlah_kolom 		= $jumlah_data + 1;
		$column_end 		= 'M';

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))
	            ->setCellValue('B1', $this->lang->line('lb_nik'))
	            ->setCellValue('C1', $this->lang->line('lb_name'))
	            ->setCellValue('D1', $this->lang->line('lb_date'))
	            ->setCellValue('E1', $this->lang->line('lb_check_in'))
	            ->setCellValue('F1', $this->lang->line('lb_check_out'))
	            ->setCellValue('G1', $this->lang->line('lb_check_in_duration'))
	            ->setCellValue('H1', $this->lang->line('lb_break_start'))
	            ->setCellValue('I1', $this->lang->line('lb_break_end'))
	            ->setCellValue('J1', $this->lang->line('lb_break_start_duration'))
	            ->setCellValue('K1', $this->lang->line('lb_overtime_in'))
	            ->setCellValue('L1', $this->lang->line('lb_overtime_out'))
	            ->setCellValue('M1', $this->lang->line('lb_overtimes_duration'))
	            ;

	    $StatusData = false;
	    if($jumlah_data>0):
	    	$i    = 1;
			$ii   = 2; 
			$no   = 0;
			$ID   = '';

			$d = $list;
			$jumlah_kolom = 1;
	        foreach ($d as $k2 => $v2) {

	        	$CompanyID = $this->session->ReportCompany;
				$StartDate = $this->session->ReportStartDate;
				$EndDate   = $this->session->ReportEndDate;

				$list = $this->api->HistoryAttendaceAndroid($CompanyID,$v2,$StartDate,$EndDate,"report");
	        	foreach ($list as $k => $v) {
	        		$StatusData = true;
	        		$jumlah_kolom += 1;
		        	if($v->EmployeeID != $ID):
						$no += 1;
						$nox = $no;
						$ID = $v->EmployeeID;
					else:
						$nox = '';
					endif;

					$DurationCheckIn = "-";
		            if($v->CheckOut):
		                $DurationCheckIn = $this->main->time_elapsed_string($v->CheckIn,true,$v->CheckOut,"duration");
		            else:
		                $v->CheckOut     = "-";
		            endif;
		            $v->DurationCheckIn = $DurationCheckIn;

		            $DurationBreakStart = "-";
		            if($v->BreakStart && $v->BreakEnd):
		                $DurationBreakStart = $this->main->time_elapsed_string($v->BreakStart,true,$v->BreakEnd,"duration");
		            endif;
		            $v->DurationBreakStart = $DurationBreakStart;
		            if($v->BreakStart):
		            else:
		                $v->BreakStart     = "-";
		            endif;
		            if($v->BreakEnd):
		            else:
		                $v->BreakEnd     = "-";
		            endif;

		            $DurationOvertime = "-";
		            if($v->OvertimeIn && $v->OvertimeOut):
		                $DurationOvertime = $this->main->time_elapsed_string($v->OvertimeIn,true,$v->OvertimeOut,"duration");
		            endif;
		            $v->DurationOvertime = $DurationOvertime;
		            if($v->OvertimeIn):
		            else:
		                $v->OvertimeIn     = "-";
		            endif;
		            if($v->OvertimeOut):
		            else:
		                $v->OvertimeOut     = "-";
		            endif;

		        	$urut 	= $ii++;
		        	$objPHPExcel->setActiveSheetIndex(0)
		              ->setCellValue('A'.$urut, $nox)
		              ->setCellValue('B'.$urut, $v->Nik)
		              ->setCellValue('C'.$urut, $v->EmployeeName)
		              ->setCellValue('D'.$urut, $v->WorkDate)
		              ->setCellValue('E'.$urut, $v->CheckIn)
		              ->setCellValue('F'.$urut, $v->CheckOut)
		              ->setCellValue('G'.$urut, $v->DurationCheckIn)
		              ->setCellValue('H'.$urut, $v->BreakStart)
		              ->setCellValue('I'.$urut, $v->BreakEnd)
		              ->setCellValue('J'.$urut, $v->DurationBreakStart)
		              ->setCellValue('K'.$urut, $v->OvertimeIn)
		              ->setCellValue('L'.$urut, $v->OvertimeOut)
		              ->setCellValue('M'.$urut, $v->DurationOvertime)
		              ;
		        }
	        }
	    endif;

	    if(!$StatusData):
	    	$urut 	= 2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, "Data Not Found")->mergeCells('A'.$urut.':M'.$urut);
	    endif;

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	    // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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

	private function attendance_visit_excel(){
		$name 	= $this->report->ReportName();
		$list 	= $this->report->attendance_visit();
		$arrVisitIn     = array();
	    $arrVisitOut    = array();
	    $arrID 			= array();

	    foreach ($list as $k => $v) {
	    	if(!in_array($v->EmployeeID, $arrID)):
	    		array_push($arrID, $v->EmployeeID);
	    	endif;
	       	if($v->Type == 5):
	            array_push($arrVisitIn,$v);
	        else:
	            array_push($arrVisitOut,$v);
	        endif;
	    }

		$jumlah_data  		= count($arrVisitIn); 
		$jumlah_kolom 		= $jumlah_data + 1;
		$column_end 		= 'K';

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));
        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))
	            ->setCellValue('B1', $this->lang->line('lb_nik'))
	            ->setCellValue('C1', $this->lang->line('lb_name'))
	            ->setCellValue('D1', $this->lang->line('lb_date'))
	            ->setCellValue('E1', $this->lang->line('lb_visit_type'))
	            ->setCellValue('F1', $this->lang->line('lb_visit_in'))
	            ->setCellValue('G1', $this->lang->line('lb_visit_in_remark'))
	            ->setCellValue('H1', $this->lang->line('lb_visit_out'))
	            ->setCellValue('I1', $this->lang->line('lb_visit_out_remark'))
	            ->setCellValue('J1', $this->lang->line('lb_visit_duration'))
	            ->setCellValue('K1', $this->lang->line('lb_location'))
	            ;

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$jumlah_kolom)->applyFromArray($border_style);

	    if($jumlah_data>0):
	    	$i    = 1;
			$ii   = 2; 
			$no   = 0;
			$ID   = '';
	        
	        foreach ($arrID as $k => $v) {
	        	foreach ($arrVisitIn as $k2 => $v2) {
	        		if($v == $v2->EmployeeID):
	        			if($v2->EmployeeID != $ID):
							$no += 1;
							$nox = $no;
							$ID = $v2->EmployeeID;
						else:
							$nox = '';
						endif;

						$key = array_search($v2->Code, array_column($arrVisitOut, 'ParentCodeVisit'));
						if(strlen($key)>0):
	                        $VisitOut       = $arrVisitOut[$key]->CheckIn;
	                        $DurationVisit  = $this->main->time_elapsed_string($v2->CheckIn,true,$VisitOut,"duration");
	                        $v2->VisitOut 	= $VisitOut;
	                        $v2->DurationVisit = $DurationVisit;
	                        $v2->RemarkOut = $arrVisitOut[$key]->Note;
	                    else:
	                        $v2->VisitOut     	= "-";
	                        $v2->DurationVisit 	= "-";
	                        $v2->RemarkOut 		= "-";
	                    endif;

	                    if($v2->Latitude && $v2->Longitude):
	                    	$v2->Latlng = $v2->Latitude.",".$v2->Longitude;
	                    else:
	                    	$v2->Latlng = "-";
	                    endif;

	                    $urut 	= $ii++;
			        	$objPHPExcel->setActiveSheetIndex(0)
			              ->setCellValue('A'.$urut, $nox)
			              ->setCellValue('B'.$urut, $v2->Nik)
			              ->setCellValue('C'.$urut, $v2->EmployeeName)
			              ->setCellValue('D'.$urut, $v2->WorkDate)
			              ->setCellValue('E'.$urut, $v2->VisitType)
			              ->setCellValue('F'.$urut, $v2->CheckIn)
			              ->setCellValue('G'.$urut, $v2->Note)
			              ->setCellValue('H'.$urut, $v2->VisitOut)
			              ->setCellValue('I'.$urut, $v2->RemarkOut)
			              ->setCellValue('J'.$urut, $v2->DurationVisit)
			              ->setCellValue('K'.$urut, $v2->Latlng)
			              ;

	        		endif;
	        	}
	        }
	    else:
	    	$urut 	= 2;
	    	$objPHPExcel->setActiveSheetIndex(0)
	              ->setCellValue('A'.$urut, "Data Not Found")->mergeCells('A'.$urut.':K'.$urut);
	    endif;

	    // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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

	private function attendance_report_h_excel(){
		$status = true;
	
		$StartDate      = $this->input->post('StartDate');
	    $EndDate        = $this->input->post('EndDate');
	    if(!$StartDate): $StartDate = '1998-01-01'; endif;
	    if(!$EndDate): $EndDate = date('Y-m-d'); endif;
	    $totalDays = $this->main->DayDifference($StartDate,$EndDate);
	    if($totalDays>31):
	    	$status = false;
	        echo $message = ""."A maximum of 31 days";
	    	exit();
	    endif;

	    $name 	= $this->report->ReportName();
		$list 	= $this->report->attendance_report();
		$CompanyID = $this->session->ReportCompany;
		$StartDate = $this->session->ReportStartDate;
		$EndDate   = $this->session->ReportEndDate;

		$arrEmployee = array();
		if(count($list>0)):
			$ParentID = implode(",", $list);
			$employee = $this->db->query("select Nik,Name as EmployeeName, EmployeeID from mt_employee where CompanyID = '$CompanyID' and EmployeeID in ($ParentID)")->result();
			foreach ($employee as $k => $v) {
				$h['Nik']		    = $v->Nik;
				$h['EmployeeName']	= $v->EmployeeName;
				$h['EmployeeID']	= $v->EmployeeID;

				array_push($arrEmployee,$h);
			}
		endif;
		$arrEmployee = json_encode($arrEmployee);
		$arrEmployee = json_decode($arrEmployee);

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("PIPESYS APPLICATION MANAGEMENT")
                    ->setLastModifiedBy("PIPESYS APPLICATION MANAGEMENT")
                    ->setTitle("Office 2003 XLS Test Document")
                    ->setSubject("Office 2003 XLS Test Document")
                    ->setDescription("Dokumen ini dari aplikasi PIPESYS")
                    ->setKeywords("office 2003 openxml php")
                    ->setCategory("Template Excel Driver");
        $border_style = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('argb' => '000000'),)));

        $total_column = 2;
        $total_data	  = 2;
        $column_end   = "C";
        $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', $this->lang->line('lb_no'))->mergeCells('A1:A2')
	            ->setCellValue('B1', $this->lang->line('lb_nik'))->mergeCells('B1:B2')
	            ->setCellValue('C1', $this->lang->line('lb_name'))->mergeCells('C1:C2')
	            ;

	   	$begin  = new DateTime($StartDate);
        $end    = new DateTime($EndDate);
        $end    = $end->modify( '+1 days'); 

        $interval = DateInterval::createFromDateString('1 days');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $dt) {
            $date = $dt->format("Y-m-d");

            $total_column += 1;
            $column_name = $this->main->column_excell($total_column);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($column_name.'2', $this->lang->line('lb_check_in'))
	            ;

	       	$total_column += 1;
            $column_name2 = $this->main->column_excell($total_column);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($column_name2.'2', $this->lang->line('lb_check_out'))
	            ;

	        $total_column += 1;
            $column_name3 = $this->main->column_excell($total_column);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($column_name3.'2', $this->lang->line('lb_break_start'))
	            ;

	        $total_column += 1;
            $column_name4 = $this->main->column_excell($total_column);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($column_name4.'2', $this->lang->line('lb_break_end'))
	            ;

	        $total_column += 1;
            $column_name5 = $this->main->column_excell($total_column);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($column_name5.'2', $this->lang->line('lb_overtime_in'))
	            ;

	        $total_column += 1;
            $column_name6 = $this->main->column_excell($total_column);
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($column_name6.'2', $this->lang->line('lb_overtime_out'))
	            ;

            // date
            $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($column_name.'1', $date)->mergeCells($column_name.'1:'.$column_name6.'1')
	            ;
        }

        $total_column += 1;
        $column_name = $this->main->column_excell($total_column);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($column_name.'2', $this->lang->line('lb_check_in_duration'))
            ;

        $total_column += 1;
        $column_name2 = $this->main->column_excell($total_column);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($column_name2.'2', $this->lang->line('lb_break_start_duration'))
            ;

        $total_column += 1;
        $column_end = $this->main->column_excell($total_column);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($column_end.'2', $this->lang->line('lb_overtimes_duration'))
            ;

        // SUM
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($column_name.'1', "SUM")->mergeCells($column_name.'1:'.$column_end.'1')
            ;

        foreach(range('A',$column_end) as $columnID):
	        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	    endforeach;

        // data employee
        $no = 0;
        foreach ($arrEmployee as $k => $v) {
        	$no 		+= 1;
        	$total_data += 1;
        	$urut = $total_data;

        	$total_column = 0;
        	$column_name = $this->main->column_excell($total_column);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $no);

        	$total_column += 1; $column_name = $this->main->column_excell($total_column);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v->Nik);

        	$total_column += 1; $column_name = $this->main->column_excell($total_column);
        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v->EmployeeName);

        	$totalDurationCheckin 	= 0;
			$totalDurationBreak 	= 0;
			$totalDurationOvertime 	= 0;

			$begin  = new DateTime($StartDate);
	        $end    = new DateTime($EndDate);
	        $end    = $end->modify( '+1 days'); 
	        $interval = DateInterval::createFromDateString('1 days');
	        $period = new DatePeriod($begin, $interval, $end);

	        foreach ($period as $dt) {
	            $date = $dt->format("Y-m-d");
	            $status = false;

	            $item_dt2 = '';
	            $list = $this->api->HistoryAttendaceAndroid($CompanyID,$v->EmployeeID,$StartDate,$EndDate,"report");
	            foreach ($list as $k2 => $v2) {
	            	if($v2->EmployeeID == $v->EmployeeID && $date == $v2->WorkDate):
	            		$status = true;

	            		if($v2->CheckOut):
			                $diff = strtotime($v2->CheckOut) - strtotime($v2->CheckIn);
                        	$totalDurationCheckin += $diff;
			            else:
			                $v2->CheckOut     = "-";
			            endif;

			            if($v2->BreakStart && $v2->BreakEnd):
			                $diff = strtotime($v2->BreakEnd) - strtotime($v2->BreakStart);
                        	$totalDurationBreak += $diff;
			            endif;
			            if($v2->BreakStart):
			            else:
			                $v2->BreakStart     = "-";
			            endif;
			            if($v2->BreakEnd):
			            else:
			                $v2->BreakEnd     = "-";
			            endif;

			            if($v2->OvertimeIn && $v2->OvertimeOut):
			                $diff = strtotime($v2->OvertimeOut) - strtotime($v2->OvertimeIn);
                        	$totalDurationOvertime += $diff;
			            endif;
			            if($v2->OvertimeIn):
			            else:
			                $v2->OvertimeIn     = "-";
			            endif;
			            if($v2->OvertimeOut):
			            else:
			                $v2->OvertimeOut     = "-";
			            endif;

			            $total_column += 1; $column_name = $this->main->column_excell($total_column);
        				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v2->CheckIn);

        				$total_column += 1; $column_name = $this->main->column_excell($total_column);
        				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v2->CheckOut);

        				$total_column += 1; $column_name = $this->main->column_excell($total_column);
        				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v2->BreakStart);

        				$total_column += 1; $column_name = $this->main->column_excell($total_column);
        				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v2->BreakEnd);

        				$total_column += 1; $column_name = $this->main->column_excell($total_column);
        				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v2->OvertimeIn);

        				$total_column += 1; $column_name = $this->main->column_excell($total_column);
        				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, $v2->OvertimeOut);

	            	endif;
	            }

	            if(!$status):
	            	$total_column += 1; $column_name = $this->main->column_excell($total_column);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, "-");

    				$total_column += 1; $column_name = $this->main->column_excell($total_column);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, "-");

    				$total_column += 1; $column_name = $this->main->column_excell($total_column);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, "-");

    				$total_column += 1; $column_name = $this->main->column_excell($total_column);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, "-");

    				$total_column += 1; $column_name = $this->main->column_excell($total_column);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, "-");

    				$total_column += 1; $column_name = $this->main->column_excell($total_column);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, "-");
	            endif;
	        }

	        $total_column += 1; $column_name = $this->main->column_excell($total_column);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, ucwords($this->main->convert_seconds($totalDurationCheckin,true,"duration")));

			$total_column += 1; $column_name = $this->main->column_excell($total_column);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, ucwords($this->main->convert_seconds($totalDurationBreak,true,"duration")));

			$total_column += 1; $column_name = $this->main->column_excell($total_column);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($column_name.$urut, ucwords($this->main->convert_seconds($totalDurationOvertime,true,"duration")));
        }

	    $objPHPExcel->getActiveSheet()->getStyle("A1:".$column_end.$total_data)->applyFromArray($border_style);

        // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($name);
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		$name = str_replace(" ", "_", $name);
		header('Content-Disposition: attachment;filename="'.$name."_".date("Ymd_His").'.xls"');
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