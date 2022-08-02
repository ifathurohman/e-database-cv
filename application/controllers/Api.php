<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->dbforge();
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
    }

    public function login(){
    	$this->main->login();
    }

    public function register(){
    	$this->main->register();
    }

    public function verification(){
    	$this->main->verification_save();
    }

    public function forgot_password(){
        $this->main->forgot_password();
    }

    public function forgot_password_save(){
        $this->main->forgot_password_save();
    }

    public function php_info(){
        phpinfo();
    }
    public function menu(){
    	$this->main->check_session('out');
        $HakAksesType = $this->session->HakAksesType;
    	$list 	      = $this->api->menu();
        $HakAksesList = $this->api->role("my_role");
        $view         = json_decode($HakAksesList->View);

        $data = array();

        foreach ($list as $k => $v) {
            if($v->Level != 1):
                if(in_array($v->ID, $view) && $HakAksesType != 1):
                    array_push($data, $v);
                elseif($HakAksesType == 1):
                    array_push($data, $v);

                endif;
            else:
                array_push($data, $v);
            endif;

        }

        $list = $data;

		$response = array(
			"status"	=> true,
			"message"	=> $this->lang->line('lb_success'),
			"list"		=> $list,
		);

		$this->main->echoJson($response);

    }

    public function serverSide(){

        $page = $this->input->post('page');
        $p1   = $this->input->post('p1');
        $data = array();
        $list = $this->main->serverSide();
        $i      = $this->input->post('start');

        foreach ($list->data as $k => $v):

            $row = array();
            $no = $i++;
            $no += 1;

            if($page == 'role'):

                $type    = $this->main->label_role_type($v->Type);
                $tg_data = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" ';                
                $tg_data .= ' data-name="'.$v->Name.'" ';

                $onclick = ' onclick="choose_modal_role(this)" ';

                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Name.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$type.'</div>';

                $data[] = $row;

            elseif($page == "company"):
                $txt_status = $this->main->label_active($v->Status);
                $tg_data = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" ';                
                $tg_data .= ' data-name="'.$v->Name.'" ';

                $onclick = ' onclick="choose_modal_company(this)" ';

                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Name.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Email.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$txt_status.'</div>';

                $data[] = $row;

            elseif($page == "pattern"):
                $tg_data = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" ';                
                $tg_data .= ' data-name="'.$v->Name.'" ';

                $onclick = ' onclick="choose_modal_pattern(this)" ';

                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Name.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Days.'</div>';

                $data[] = $row;

            elseif($page == "user_company"):
                $tg_data = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" ';                
                $tg_data .= ' data-name="'.$v->Name.'" ';

                $onclick = ' onclick="choose_modal_user_company(this)" ';

                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Name.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Email.'</div>';

                $data[] = $row;
        
            elseif($page == 'riwayat'):
                $tg_data  = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" '; 
                $tg_data .= ' data-posisi="'.$v->Posisi.'" '; 
                $tg_data .= ' data-name="'.$v->Nama_perusahaan.'" ';
                $tg_data .= ' data-personil="'.$v->Nama_personil.'" ';
                $tg_data .= ' data-tanggal_lahir="'.$v->Tempat_tanggal_lahir.'" ';
                $tg_data .= ' data-pendidikan="'.$v->Pendidikan.'" ';
                $tg_data .= ' data-pendidikan_non="'.$v->Pendidikan_non_formal.'" ';

                $onclick = ' onclick="choose_modal_riwayat(this)" ';

                $row[] = '<div '.$onclick.$tg_data.'>'.'<i class="fa fa-user-plus" aria-hidden="true"></i>'.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Posisi.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Nama_personil.'</div>';

                $data[] = $row;
                
            elseif($page == 'pengalaman'):
                    
                $mulai   = $this->main->tanggal_indo(date('Y-m-d',strtotime($v->Waktu_pelaksanaan_mulai)));
                $selesai = $this->main->tanggal_indo(date('Y-m-d',strtotime($v->Waktu_pelaksanaan_selesai)));
                $bulan   = $this->main->count_mount($v->Waktu_pelaksanaan_mulai, $v->Waktu_pelaksanaan_selesai);

                $tg_data  = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" '; 
                $tg_data .= ' data-pel_id="'.$v->PelID.'" '; 
                $tg_data .= ' data-nama_kegiatan="'.$v->Nama_kegiatan.'" '; 
                $tg_data .= ' data-lokasi_kegiatan="'.$v->Lokasi_kegiatan.'" ';
                $tg_data .= ' data-pengguna="'.$v->Pengguna_jasa.'" ';
                $tg_data .= ' data-nama_perusahaan="'.$v->Nama_perusahaan.'" ';
                $tg_data .= ' data-waktu_pelaksanaan="'.$mulai. ' - ' .$selesai. ' ('.$bulan.' Bulan)" ';

                $onclick = ' onclick="choose_modal_pengalaman(this)" ';
                

                $row[] = '<div '.$onclick.$tg_data.'>'.'<i class="fa fa-user-plus" aria-hidden="true"></i>'.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Nama_kegiatan.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$mulai. ' - ' .$selesai. ' ('.$bulan.' Bulan)</div>';

                $data[] = $row;

            elseif($page == 'biodata'):
                    
                $tg_data  = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" '; 
                $tg_data .= ' data-personil="'.$v->Nama_personil.'" '; 
                $tg_data .= ' data-tempat_tanggal_lahir="'.$v->Tempat_tanggal_lahir.'" ';
                $tg_data .= ' data-pendidikan="'.$v->Pendidikan.'" ';
                $tg_data .= ' data-pendidikan_non="'.$v->Pendidikan_non_formal.'" ';
                $tg_data .= ' data-nomor_hp="'.$v->Nomor_hp.'" ';
                $tg_data .= ' data-email="'.$v->Email.'" ';

                $onclick = ' onclick="choose_modal_biodata(this)" ';
                

                $row[] = '<div '.$onclick.$tg_data.'>'.'<i class="fa fa-user-plus" aria-hidden="true"></i>'.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Nama_personil.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Pendidikan.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Pendidikan_non_formal.'</div>';

                $data[] = $row;

            elseif($page == 'penugasan'):
                $tg_data  = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" '; 
                $tg_data .= ' data-posisi_penugasan="'.$v->Posisi.'" '; 
                $tg_data .= ' data-uraian_tugas="'.$v->Uraian_tugas.'" ';

                $onclick = ' onclick="choose_modal_penugasan(this)" ';

                $row[] = '<div '.$onclick.$tg_data.'>'.'<i class="fa fa-user-plus" aria-hidden="true"></i>'.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Posisi.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Uraian_tugas.'</div>';

                $data[] = $row;
                
            elseif($page == 'non_pt'):
                $tg_data  = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" '; 
                $tg_data .= ' data-nama="'.$v->Nama_personil.'" '; 
                $tg_data .= ' data-nama_perusahaan="'.$v->Nama_perusahaan.'" '; 
                $tg_data .= ' data-status_pegawai="'.$v->Status_pegawai.'" ';
                $tg_data .= ' data-proyek="'.$v->Proyek.'" ';
                $tg_data .= ' data-periode_proyek_mulai="'.$v->Periode_proyek_mulai.'" ';
                $tg_data .= ' data-periode_proyek_selesai="'.$v->Periode_proyek_selesai.'" ';

                $onclick = ' onclick="choose_modal_non_pt(this)" ';

                $Status_pegawai = $this->main->label_pegawai_non_pt($v->Status_pegawai);
                $Status_pegawai = $this->main->label_background_pegawai_non_pt($Status_pegawai);

                $row[] = '<div '.$onclick.$tg_data.'>'.'<i class="fa fa-user-plus" aria-hidden="true"></i>'.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Nama_personil.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$Status_pegawai.'</div>';
                $row[] = '<div class="iffyTip hideText1"'.$onclick.$tg_data.'>'.$v->Nama_perusahaan.'</div>';
                $row[] = '<div class="iffyTip hideText1"'.$onclick.$tg_data.'>'.$v->Proyek.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Periode_proyek_mulai.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Periode_proyek_selesai.'</div>';

                $data[] = $row;

            elseif($page == 'sdm_pt'):
                $tg_data  = ' data-p1="'.$p1.'" ';                
                $tg_data .= ' data-id="'.$v->ID.'" '; 
                $tg_data .= ' data-nama="'.$v->Nama_personil.'" '; 
                $tg_data .= ' data-nama_perusahaan="'.$v->Nama_perusahaan.'" '; 
                $tg_data .= ' data-status_pegawai="'.$v->Status_pegawai.'" ';
                $tg_data .= ' data-proyek="'.$v->Proyek.'" ';
                $tg_data .= ' data-periode_proyek_mulai="'.$v->Periode_proyek_mulai.'" ';
                $tg_data .= ' data-periode_proyek_selesai="'.$v->Periode_proyek_selesai.'" ';

                $onclick = ' onclick="choose_modal_sdm_pt(this)" ';

                $Status_pegawai = $this->main->label_pegawai_pt($v->Status_pegawai);
                $Status_pegawai = $this->main->label_background_pegawai_pt($Status_pegawai);

                $row[] = '<div '.$onclick.$tg_data.'>'.'<i class="fa fa-user-plus" aria-hidden="true"></i>'.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$no.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Nama_personil.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$Status_pegawai.'</div>';
                $row[] = '<div class="iffyTip hideText3'.$onclick.$tg_data.'>'.$v->Nama_perusahaan.'</div>';
                $row[] = '<div class="iffyTip hideText1'.$onclick.$tg_data.'>'.$v->Proyek.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Periode_proyek_mulai.'</div>';
                $row[] = '<div '.$onclick.$tg_data.'>'.$v->Periode_proyek_selesai.'</div>';

                $data[] = $row;
            endif;
        endforeach;

        $response = array(
            "draw"              => $this->input->post('draw'),
            "recordsTotal"      => $list->total,
            "recordsFiltered"   => $list->total,
            "data"              => $data,
            'ss'                => $this->input->post('search'),
        );

        $this->main->echoJson($response);
    }

    public function backup(){
        $mydb   = $this->db->database;
        $backup = $this->dbutil->backup();
        $config = array(
            'format'    => 'zip',
            'filename'  => ''.$mydb.'.sql'
        );
        
        $backup =& $this->dbutil->backup($config);
        force_download('mybackup'.'-'.date("Y-m-d").'.rar', $backup);
    }

    public function log_info(){
        $this->main->check_session('out');
        $list = $this->api->log();
        $data = array();
        foreach ($list as $k => $v) {
            $Image      = base_url('img/image_default.png');
            $Lables     = $this->main->label_log($v->Type, $v->Page, $v->Content);
            $Date       = $this->main->time_elapsed_string($v->DateAdd, true);
            if(in_array($v->HakAksesType, array(1,2,3))):
                $Name = $v->companyName;
                if($v->companyImage):
                    $Image = base_url($v->companyImage);
                endif;
            else:
                $Name = $v->employeeName;
                if($v->employeeImage):
                    $Image = base_url($v->employeeImage);
                endif;
            endif;

            $content = '<a href="javascript:void(0)">
                <div class="user-img"> <img src="'.$Image.'" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                <div class="mail-contnet">
                    <h5>'.$Name.'</h5> <span class="mail-desc white-space">'.$Lables.'</span> <span class="time">'.$Date.'</span> </div>
            </a>';
            $h = array(
                "Name"      => $Name,
                "Image"     => $Image,
                "Lables"    => $Lables,
                "Date"      => $Date,
                "Content"   => $content,
            );

            array_push($data,$h);
        }

        $this->main->echoJson($data);
    }

    public function get_setting($page = "")
    { 
        $arrPage    = array('policy-page-setting','term-and-condition','general');
        $post       = $this->input->post();
        $ListData   = array(); 
        $CodeArray  = array();

        if(in_array($page, $arrPage)):
            $ListData = $this->api->general_setting($page);
        endif;
        $output     = array(
            "HakAkses"  => $this->session->HakAkses,
            "Status"    => TRUE,
            "ListData"  => $ListData
        );
        $this->main->echoJson($output);
    }
    public function save_setting($page = "")
    {
        $arrPage    = array('policy-page-setting','term-and-condition');
        $post       = $this->input->post();
        $postar     = array();
        $data       = array();
        // $dataeng    = array();
        $PostName   = array();
        
        if(in_array($page,$arrPage)):
            $Value          = array();
            $Code           = $page;
            foreach ($post as $k => $v) {
                $Name   = $k;
                $Value  = $v;

                $data = array(
                    'Code'  => $Code,
                    'Name'  => $Name,
                    'Value' => $Value,
                );

                $cek_dt = $this->db->count_all("ut_general where Code = '$Code' and Name = '$Name'");
                //jika data lebih dari 0 maka update else nya insert
                if($cek_dt>0):
                    $this->main->general_update("ut_general",$data,array('Code' => $Code, 'Name' => $Name));
                else:
                    $this->main->general_save("ut_general",$data);
                endif;

            }
        else:
            foreach($post as $key => $a):
                $PostName[] = $key;
                #$postar[$key] = $this->input->post($key);
                $Name       = $key;
                $Code       = $page;
                $Value  = $this->input->post($Name);
                #data------------------------------------------------------------
                $cek        = $this->db->count_all("ut_general where Code='$Code' and Name = '$Name'");

                $data_value = array(
                    'Code'  => $Code,
                    'Name'  => $Name,
                    'Value' => $Value,
                );

                if($cek > 0):
                    $this->main->general_update('ut_general',$data_value,array('Code'=> $Code,'Name'=>$Name));
                else:
                    $this->main->general_save('ut_general',$data_value);
                endif;
            endforeach;

            foreach($_FILES as $key => $a):
                $PostName[] = $key;
                $Name       = $key;
                $Code       = $page;
                $cek        = $this->db->count_all("ut_general where Code='$Code' and Name = '$Name'");
                #data------------------------------------------------------------
                if($Name == "SiteLogo"):
                    $nmfile                     = $this->main->clean_file_name($Name);
                    $nmfile                     = "alpa_".$nmfile."_general_".time();
                    $config['upload_path']      = './img/attachment'; //path folder 
                    $config['allowed_types']    = 'gif|jpg|png|jpeg|bmp|PNG|JPG'; //type yang dapat diakses bisa anda sesuaikan 
                    $config['max_size']         = '99999'; //maksimum besar file 2M 
                    $config['max_width']        = '99999'; //lebar maksimum 1288 px 
                    $config['max_height']       = '99999'; //tinggi maksimu 768 px 
                    $config['file_name']        = $nmfile; //nama yang terupload nantinya 
                    $this->upload->initialize($config); 
                    $upload = $this->upload->do_upload($Name);
                    $gbr    = $this->upload->data();
                    if($upload):        
                        $image  = "img/attachment/".$gbr['file_name'];
                        $Value  = $image;
                        
                        $data_value = array(
                            'Code'  => $Code,
                            'Name'  => $Name,
                            'Value' => $Value,
                        );

                        if($cek > 0):
                            $this->main->remove_file("ut_general","Value",array("Code" => $Code, "Name" => $Name));
                            $this->main->general_update('ut_general',$data_value,array('Code'=> $Code,'Name'=>$Name));
                        else:
                            $this->main->general_save('ut_general',$data_value);
                        endif;
                    endif;
                endif;
            endforeach;
            $this->main->create_general_file();
        endif;
        $output = array(
            "HakAkses"  => $this->session->HakAkses,
            "Status"    => TRUE,
            "Modul"     => $page,
            "Post"      => $PostName,
            "Data"      => $data
        );
        $this->main->echoJson($output);
    }
    public function save_setting_db($cek,$Code,$Value){
        $data["Value"]  = $Value;
        if($cek > 0):
            $data["UserCh"] = $this->session->Name;
            $data["DateCh"] = date("Y-m-d H:i:s");
            $this->db->where("Code",$Code);
            $this->db->update("ut_general",$data);
        else:
            $data["Code"]    = $Code;
            $data["UserAdd"] = $this->session->Name;
            $data["DateAdd"] = date("Y-m-d H:i:s");
            $this->db->insert("ut_general",$data);
        endif;
    }

    public function AttendanceDetail(){
        $url                = $this->input->post('page_url');
        $module             = $this->input->post('page_module');
        $MenuID             = $this->api->get_menuID($url);
        $read_menu          = $this->api->read_menu($MenuID);
        $this->main->check_session('out', 'view', $read_menu->view);
        
        $this->load->library(array('encrypt'));
        $p1 = $this->input->post('p1'); $p1 = $this->encrypt->decode($p1,'report');
        $p2 = $this->input->post('p2'); $p2 = $this->encrypt->decode($p2,'report');
        $p3 = $this->input->post('p3'); $p3 = $this->encrypt->decode($p3,'report');
        $p4 = $this->input->post('p4'); $p4 = $this->encrypt->decode($p4,'report');
        $p5 = $this->input->post('p5'); $p5 = $this->encrypt->decode($p5,'report');
        $p6 = $this->input->post('p6'); $p6 = $this->encrypt->decode($p6,'report');
        $p7 = $this->input->post('p7'); $p7 = $this->encrypt->decode($p7,'report');
        $p8 = $this->input->post('p8'); $p8 = $this->encrypt->decode($p8,'report');

        $where = array('CompanyID' => $p5, "EmployeeID" => $p6, "Code"  => $p2, "Type" => 1);
        $ck_checkin = $this->api->get_one_row('t_attendance',"Note,ifnull(Picture,'[]') as Picture",$where);
        $dt_checkin = array();
        if($ck_checkin):
            $ck_checkin->Picture     = json_decode($ck_checkin->Picture);
            $dt_checkin = $ck_checkin;
        endif;

        $dt_checkout = array();
        if($p3):
            $where = array('CompanyID' => $p5, "EmployeeID" => $p6, "Code"  => $p3, "Type" => 2);
            $dt = $this->api->get_one_row('t_attendance',"Note,ifnull(Picture,'[]') as Picture",$where);
            if($dt):
                $dt->Picture     = json_decode($dt->Picture);
                $dt_checkout = $dt;
            endif;
        endif;

        $dt_overtime_out = array();
        if($p4):
            $where = array('CompanyID' => $p5, "EmployeeID" => $p6, "Code"  => $p4, "Type" => 8);
            $dt = $this->api->get_one_row('t_attendance',"Code,Note,ifnull(Picture,'[]') as Picture, ifnull(Attachment,'[]') as File",$where);
            if($dt):
                $dt->Picture     = json_decode($dt->Picture);
                $dt->File        = json_decode($dt->File);
                $dt_overtime_out = $dt;
            endif;
        endif;

        $dt_break = array();
        if($p7):
            $where = array('CompanyID' => $p5, "EmployeeID" => $p6, "Code"  => $p7, "Type" => 3);
            $dt = $this->api->get_one_row('t_attendance',"ifnull(Picture,'[]') as Picture",$where);
            if($dt):
                $dt->Picture     = json_decode($dt->Picture);
                $dt_break = $dt;
            endif;
        endif;
        $dt_break_end = array();
        if($p8):
            $where = array('CompanyID' => $p5, "EmployeeID" => $p6, "Code"  => $p8, "Type" => 4);
            $dt = $this->api->get_one_row('t_attendance',"ifnull(Picture,'[]') as Picture",$where);
            if($dt):
                $dt->Picture     = json_decode($dt->Picture);
                $dt_break_end = $dt;
            endif;
        endif;

        $response = array(
            "status"        => true,
            "checkin"       => $dt_checkin,
            "checkout"      => $dt_checkout,
            "overtime_out"  => $dt_overtime_out,
            "break"         => $dt_break,
            "break_end"     => $dt_break_end,
            "message"       => $this->lang->line('lb_success'),
        );

        $this->main->echoJson($response);
    }

    public function delete(){
        $mydb  = $this->db->database;
        if ($this->dbforge->drop_database($mydb)){
            echo 'Sukses!';
        }
    }

    public function getcode(){
        $data  = $this->main->generate_code_pengalaman();
        $this->main->echoJson($data);
    }

    public function test(){
        $this->main->send_email("register",19,"ya");
        // $this->main->echoJson($data);
    }

    // public function upload_file(){

    //     $folder 		            = $this->main->create_folder_general('import_pengalaman');
    //     $nmfile                     = "pengalaman_".date("ymdHis");
    //     $config['upload_path']      = './'.$folder; 
    //     $config['file_name']      	= $nmfile;
    //     $config['allowed_types']  	= 'xls|xlsx|csv|ods|ots';
    //     $config['max_size']       	= 10000;
    //     $this->load->library('upload', $config);
    // }

    public function upload_file(){
    
        $folder 		                = $this->main->create_folder_general('import_pengalaman');
        $config['upload_path']          = './'.$folder;
        $config['allowed_types']  	    = 'xls|xlsx|csv|ods|ots';
        $config['max_size']       	    = 10000;
    
        $this->load->library('upload', $config);
    }

    public function upload_file_database(){
    
        $folder 		                = $this->main->create_folder_general('import_database');
        $config['upload_path']          = './'.$folder;
        $config['allowed_types']  	    = 'xls|xlsx|csv|ods|ots';
        $config['max_size']       	    = 10000;
    
        $this->load->library('upload', $config);
    }

    public function getDataKonstruksi(){
        $data_konstruksi  = $this->api->getDataKonstruksi();
        $this->main->echoJson($data_konstruksi);
    }
    public function getDataNonKonstruksi(){
        $data_non_konstruksi  = $this->api->getDataNonKonstruksi();
        $this->main->echoJson($data_non_konstruksi);
    }
    public function show_attachment(){
        // $this->main->cek_session();
        $status  = false;
        $message = 'Data not found';
        $data    = array();

        $ID     = $this->input->post("ID");
        $modul  = $this->input->post("modul");

        if($ID):
            $ID = str_replace("-", "/", $ID);
            $status = true;
            $message= "success";
            $data = $this->main->attachment_show($modul,$ID);
        endif;

        $output = array(
            "status"    => $status,
            "message"   => $message,
            "attach"    => $data,
        );

        $this->main->echoJson($output);
    }

    public function reset_data_master(){
        $reset_data_master = $this->api->reset_data_master();
        $this->main->echoJson($reset_data_master);
    }
}