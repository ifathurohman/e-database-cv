<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Simpleexcel2 {
    private $data           = [];
    private $title          = [];
    private $flname         = '';
    private $thead          = [];
    private $head           = [];
    private $group_head     = [];
    private $alias          = [];
    private $col_excel      = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

    private $list_data      = null;
    private $list_array     = [];
    private $jml_per_sheet  = [];
    private $border         = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];

    function __construct($config=array()) {
        if(isset($config['data']) || isset($config['title']) || isset($config['header'])) {
            if(isset($config['data'])){ $this->data[] = $config['data']; }else{ $this->data[] = array(); }
            if(isset($config['title'])){ $this->title[] = $config['title']; }else{ $this->title[] = 'unknown'; }
            if(isset($config['header'])){ $this->thead[] = $config['header']; }else{ $this->thead[] = array(); }
            if(isset($config['alias'])){ $this->alias[] = $config['alias']; }else{ $this->alias[] = ''; }
            if(isset($config['group_header'])){ $this->group_head[] = $config['group_header']; }else{ $this->group_head[] = array(); }
        } else {
            foreach($config as $conf) {
                if(isset($conf['data'])){ $ldata[] = $conf['data']; }else{ $ldata[] = array(); }
                if(isset($conf['title'])){ $ltitle[] = $conf['title']; }else{ $ltitle[] = 'unknown'; }
                if(isset($conf['header'])){ $lheader[] = $conf['header']; }else{ $lheader[] = array(); }
                if(isset($conf['alias'])){ $lalias[] = $conf['alias']; }else{ $lalias[] = ''; }
                if(isset($conf['group_header'])){ $lgroup_head[] = $conf['group_header']; }else{ $lgroup_head[] = array(); }
            }
            if(isset($ldata)) {
                $this->data         = $ldata;
                $this->title        = $ltitle;
                $this->thead        = $lheader;
                $this->alias        = $lalias;
                $this->group_head   = $lgroup_head;
            }
        }
        $col_excel      = $col_excel2 = $this->col_excel;
        foreach($col_excel as $ce1) {
            foreach($col_excel2 as $ce2) {
                $col_excel[] = $ce1.$ce2;
            }
        }
        $this->col_excel = $col_excel;
    }
    
    function filename($filename='') {
        $this->flname = $filename;
    }

    function export(){
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
        ->setCreator("Muhamad Wildan")
        ->setLastModifiedBy("Muhamad Wildan")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription(
            "Test document for Office 2007 XLSX, generated using PHP classes."
        )
        ->setKeywords("office 2007 openxml php");

        for($z=0; $z < count($this->title); $z++) {
            if($z > 0) $spreadsheet->createSheet();
            $objset = $spreadsheet->setActiveSheetIndex($z);
            $objget = $spreadsheet->getActiveSheet();
            $objget->setTitle(str_replace('template_import_','',$this->title[$z]));

            $thead = $this->thead[$z];
            if(count($thead) == 0) {
                if(count($this->data[$z]) > 0) {
                    foreach($this->data[$z][0] as $key => $value) {
                        $thead[] = $key.'>>'.$key;
                    }
                }
            } else {
                $thead = array();
                foreach($this->thead[$z] as $key => $value) {
                    $thead[] = $key.'>>'.$value;
                }
            }

            $i = $ii = 1;
            foreach($this->head as $kh => $vh) {
                if($vh){ $val = $vh; }else{ $val = '-'; }
                $objset->setCellValue('A'.$i, $kh);
                $spreadsheet->getActiveSheet()->getStyle("A".$i)->getFont()->setBold( true );
                $spreadsheet->getActiveSheet()->mergeCells("A".$i.":B".$i);
                $objset->setCellValue('C'.$i, $val);
                $i++;
            }

            if(count($this->head) > 0) $i++;
            if(isset($this->col_excel[count($thead)-1])) {
                $objset->getStyle('A'.$i.':'.$this->col_excel[count($thead)-1].$i)->applyFromArray($this->border);
                $objset->getStyle("A".$i.":".$this->col_excel[count($thead)-1].$i)->getFont()->setBold( true );
                $objset->getStyle("A".$i.":".$this->col_excel[count($thead)-1].$i)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('EEEEEE');
            }

            if(count($this->group_head[$z]) == 0) {
                foreach($thead as $k => $a) {
                    $content   = explode('>>', $a);
                    $h_ttl     = str_replace(array('-b','-d','-c','-p','-s'), '', $content[1] );
                    $objset->setCellValue($this->col_excel[$k].$i, strtoupper($h_ttl));
                }
                $i++;
            } else {
                $list_grouped   = array();
                foreach ($this->group_head[$z] as $gh => $a_gh) {
                    if(is_array($a_gh)) {
                        $first_key  = 0;
                        $last_key   = 0;
                        $w = 0;
                        foreach ($this->thead[$z] as $th => $v_th) {
                            if($th == $a_gh[0]) $first_key = $w;
                            if($th == $a_gh[count($a_gh)-1]) $last_key = $w;
                            $w++;
                        }
                        if($first_key != $last_key) {
                            $objset->setCellValue($this->col_excel[$first_key].$i, $gh);
                            $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$first_key].$i)->getFont()->setBold( true );
                            $spreadsheet->getActiveSheet()->mergeCells($this->col_excel[$first_key].$i.':'.$this->col_excel[$last_key].$i);
                            $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$first_key].$i.':'.$this->col_excel[$last_key].$i)->applyFromArray(array(
                                    'alignment' => array(
                                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                    )
                                ));
                            foreach($a_gh as $agh) {
                                $list_grouped[] = $agh;
                            }
                        }
                    }
                }
                $i++;

                $spreadsheet->getActiveSheet()->getStyle("A".$i.":".$this->col_excel[count($thead)-1].$i)->applyFromArray(
                    array(
                        'borders' => array(
                            'allborders' => array(
                                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => array('rgb' => '777777')
                            )
                        )
                    )
                );
                $spreadsheet->getActiveSheet()->getStyle("A".$i.":".$this->col_excel[count($thead)-1].$i)->getFont()->setBold( true );
                $spreadsheet->getActiveSheet()
                    ->getStyle("A".$i.":".$this->col_excel[count($thead)-1].$i)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,)
                    ->getStartColor()
                    ->setRGB('EEEEEE');

                $w = 0;
                foreach ($this->thead[$z] as $th => $v_th) {
                    $merge = true;
                    foreach($list_grouped as $lg) {
                        if($th == $lg) $merge = false;
                    }
                    $v_th = str_replace(array('-b','-d','-c','-p'), '', $v_th );
                    if($merge) {
                        $n = $i - 1;
                        $spreadsheet->getActiveSheet()->mergeCells($this->col_excel[$w].$n.':'.$this->col_excel[$w].$i);
                        $objset->setCellValue($this->col_excel[$w].$n, strtoupper($v_th));
                    } else {
                        $objset->setCellValue($this->col_excel[$w].$i, strtoupper($v_th));
                    }
                    $w++;
                }
                $i++;
            }
            $ii = $i - 1;
            foreach($this->data[$z] as $r) {
                $objset->getStyle('A'.$i.':'.$this->col_excel[count($thead)-1].$i)->applyFromArray($this->border);
                foreach($thead as $k => $a) {
                    $content = explode('>>', $a);
                    if(isset($this->alias[$z][$content[0]][$r[$content[0]]])){
                        $konten = $this->alias[$z][$content[0]][$r[$content[0]]]; 
                    }else{ 
                        $konten = $r[$content[0]];
                    }
                    
                    if(strpos($thead[$k],'>>-d') !== false || strpos($thead[$k], '>>-b') || strpos($thead[$k], '>>-s') !== false || strpos($thead[$k], '>>-c') !== false || strpos($thead[$k], '>>-p') !== false) {
                        
                        if(strpos($thead[$k], '>>-b') !== false) {
                            $objset->setCellValue($this->col_excel[$k].$i, $konten);
                            $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getFont()->setBold( true );
                        } 

                        if(strpos($thead[$k], '-d') !== false) {
                            $c = $konten;
                            if(strlen($c) == 8) {
                                $c = substr($c, 0, 4).'-'.substr($c, 4, 2).'-'.substr($c, 6, 2);
                            }
                            if($c == '0000-00-00' || $c == '0000-00-00 00:00:00' || !$c) {
                                $objset->setCellValue($this->col_excel[$k].$i, '');
                            } else {
                                $objset->setCellValue($this->col_excel[$k].$i, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($c));
                                if (strpos($c, ':') !== false) {
                                    $formatCode = 'dd/mm/yyyy h:mm';
                                } else {
                                    $formatCode = 'dd/mm/yyyy';
                                }
                                $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getNumberFormat()->setFormatCode($formatCode);
                            }
                        } elseif(strpos($thead[$k], '-s') !== false) {
                            $objset->setCellValueExplicit($this->col_excel[$k].$i, str_replace(array('-b','-c','-p','-s'), '', $konten),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                        } elseif(strpos($thead[$k], '-c') !== false) {
                            $objset->setCellValue($this->col_excel[$k].$i, str_replace(array('-b','-c','-p','-s'), '', $konten));
                            $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY);
                        } elseif(strpos($thead[$k], '-p') !== false) {
                            $objset->setCellValue($this->col_excel[$k].$i, str_replace(array('-b','-c','-p','-s'), '', $konten));
                            $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
                        }
                        if(strpos($konten,'-b') !== false) {
                            $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getFont()->setBold( true );
                        }
                    } else {
                        if(substr($konten, 0, 2) == '-m') {
                            $merge_start = $merge_end = str_replace('-m', '', $konten);
                            if($this->col_excel[$k+1] == $merge_end) {
                                $merge_start = $this->col_excel[$k];
                            } elseif($this->col_excel[$k-1] == $merge_start) {
                                $merge_end = $this->col_excel[$k];
                            }
                            $spreadsheet->getActiveSheet()->mergeCells($merge_start.$i.":".$merge_end.$i);
                            $objset->setCellValue($this->col_excel[$k].$i, '');
                        } else {
                            if(strpos($konten,'-s') !== false) {
                                $objset->setCellValueExplicit($this->col_excel[$k].$i, str_replace(array('-b','-c','-p','-s'), '', $konten),\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                            } else {
                                $objset->setCellValue($this->col_excel[$k].$i, str_replace(array('-b','-c','-p','-s'), '', $konten));
                            }
                            if(strpos($konten,'-b') !== false) {
                                $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getFont()->setBold( true );
                            }
                            if(strpos($konten,'-c') !== false && is_numeric($konten)) {
                                $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY);
                            } elseif(strpos($konten,'-s') !== false && is_float($konten)) {
                                $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                            } elseif(strpos($konten,'-p') !== false && is_float($konten)) {
                                $spreadsheet->getActiveSheet()->getStyle($this->col_excel[$k].$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
                            }
                        }                        
                    }
                }
                $i++;
            }
            for($j = 0; $j < count($thead); $j++) {
                $objget->getColumnDimension($this->col_excel[$j])->setAutoSize(true);
            }
        }
        
        if($this->flname){ $filename = $this->flname; }else{ $filename = $this->title[0]; }
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
    }

    function define_column($array) {
        $this->list_array = $array;
    }

    function read($file) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        try {
            $spreadsheet = $reader->load($file);
        } catch(Exception $e) {
            die('Error loading file :' . $e->getMessage());
        }
        $sheet_count    = $spreadsheet->getSheetCount();
        $worksheet      = array();
        $numRows        = array();
        for($i = 0; $i < $sheet_count; $i++) {
            $worksheet[$i]      = $spreadsheet->getSheet($i)->toArray(null,true,true,true);
            $numRows[$i]        = count($worksheet[$i]);
        }
        $this->list_data        = $worksheet;
        $this->jml_per_sheet    = $numRows;
        return $numRows;
    }

    function parsing($i,$j) {
        $data   = array();
        $row    = $this->list_data[$i][$j];
        foreach($this->list_array as $k => $a) {
            if(isset($row[$this->col_excel[$k]])) {
                if($row[$this->col_excel[$k]] == null){ $data[$a] = ''; }else{ $data[$a] = $row[$this->col_excel[$k]]; }
            } else {
                $data[$a] = '';
            }
            $check_date = explode('/',$data[$a]);
            if(strlen($data[$a]) >= 8 && strlen($data[$a]) <= 10 && count($check_date) == 3) {
                $orig = $data[$a];
                $data[$a] = date('Y-m-d',strtotime(str_replace('/','-',$data[$a])));
                if($data[$a] == '1970-01-01') {
                    $data[$a] = date('Y-m-d',strtotime($orig));
                }
            }
        }
        return $data;
    }
}

