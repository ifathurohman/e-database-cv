<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	function __construct() {
        parent::__construct();
    }

    public function index()
    {
        if(!$this->session->bahasa):
            $this->session->set_userdata("bahasa","english");
            redirect($this->agent->referrer());
        endif;
        if($this->session->login):
            if($this->session->HakAksesType == 1):
                redirect('dashboard');
            else:
                redirect('dashboard');
            endif;
        endif;
        $data["title"]      = $this->lang->line('lb_login');
        $this->load->view('backend/page/login',$data);
    }

    public function login()
    {
        if(!$this->session->bahasa):
            $this->session->set_userdata("bahasa","english");
            redirect($this->agent->referrer());
        endif;
        if($this->session->login):
            if($this->session->HakAksesType == 1):
                redirect('dashboard');
            else:
                redirect('dashboard');
            endif;
        endif;
        $data["title"]      = $this->lang->line('lb_login');
        $this->load->view('backend/page/login',$data);
    }

    public function home()
    {
        if(!$this->session->bahasa):
            $this->session->set_userdata("bahasa","english");
            redirect($this->agent->referrer());
        endif;
        if($this->session->login):
            if($this->session->HakAksesType == 1):
                redirect('dashboard');
            else:
                redirect('dashboard');
            endif;
        endif;
        $data["title"]      = $this->lang->line('lb_login');
        // $this->load->view('backend/page/login',$data);
        $this->load->view('frontend/index',$data);
    }

	public function forgot_password(){
		$id = $this->input->get('id');
		$ck_user 		= $this->db->count_all("ut_user where Token = '$id'");

		if($ck_user<=0):
            $this->session->set_flashdata('msg', 'Invalid Url');
			redirect('');
		endif;

		$data["title"] 		= $this->lang->line('lb_login');
		$data['id'] 		= $id;
		$this->load->view('backend/page/forgot_password',$data);
	}

    public function verification(){
		$id             = $this->input->get('id');
		$ck_user 		= $this->db->count_all("ut_user where Token = '$id'");

		$data["title"] 		= $this->lang->line('lb_login');
		$data['id'] 		= $id;
		// $this->load->view('backend/page/verification',$data);
		$this->load->view('backend/page/verification',$data);
	}

	public function error_404(){
		$this->main->check_session();
		$data["title"] 		= "404";
		$data['content'] 	= 'backend/page/error_404';
		$this->load->view('backend/index',$data);
	}

	public function error_403(){
		$this->main->check_session();
		$data["title"] 		= "403";
		$data['content'] 	= 'backend/page/error_403';
		$this->load->view('backend/index',$data);
	}

	public function logout(){
		$this->main->logout();
	}

	public function menu_shorting(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "role";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		if($read_menu->update>0): 
			$btn_add = $this->main->button('action2'); 
		endif;

		$data["title"] 		= $this->lang->line('menu_shorting');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/page/menu_shorting';
		$data['btn_add'] 	= $btn_add;
		$this->load->view('backend/index',$data);
	}

	public function menu_shorting_save(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);

		$this->main->check_session('out',"update", $read_menu->update);

		$ID = $this->input->post("ID");

		$this->db->update("ut_menu", array("Index" => null));
		foreach ($ID as $k => $v) {
			$data = array("Index" => $k);
			$this->main->general_update("ut_menu", $data, array("MenuID" => $ID[$k]));
		}
		$response = array(
			"status"	=> true,
			"message"	=> "Success",
		);
		$this->main->echoJson($response);
	}

	public function general_setting($page){
		$this->main->check_session();
		$url                = "page-settings/general";
		$modul 			    = $url;
		$MenuID 			= $this->api->get_menuID($url);
        $menu_name          = $this->api->GetMenuName($page);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		if($read_menu->update>0): 
			$btn_add = $this->main->button('action2'); 
		endif;

		$data["title"] 		= $menu_name;
		$data['content'] 	= 'backend/page/general_setting';
        $data['modul']      = $modul;
        $data['page']       = $page;
        $data['url']        = $url;
		$this->load->view('backend/index',$data);
	}

	public function general_setting_save(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);

		$this->main->check_session('out',"update", $read_menu->update);

		$ID = $this->input->post("ID");

		$this->db->update("ut_general", array("Index" => null));
		foreach ($ID as $k => $v) {
			$data = array("Index" => $k);
			$this->main->general_update("ut_general", $data, array("GeneralID" => $ID[$k]));
		}
		$response = array(
			"status"	=> true,
			"message"	=> "Success",
		);
		$this->main->echoJson($response);
	}

	public function get_setting($modul = "")
    { 
        $post       = $this->input->post();
        $ListData   = array(); 
        $CodeArray  = array();

        if($modul == "slideshow"):
            $ListData = $this->api->slideshow('list_data');
        else:
            foreach($post as $key => $a):
                $CodeArray[] = $key;
            endforeach;
            foreach($_FILES as $key => $a):
                $CodeArray[] = $key;
            endforeach;
            if(count($CodeArray) > 0):
                $this->db->where_in("Code",$CodeArray);
                $query = $this->db->get("ut_general");
                $Listdatax = $query->result();
                foreach($Listdatax as $a):
                    $ListData[] = array(
                        "Code"  => $a->Code,
                        "Value" => $a->Value,
                    );
                endforeach;
            endif;
        endif;
        $output     = array(
            "HakAkses"  => $this->session->HakAkses,
            "Status"    => TRUE,
            "ListData"  => $ListData
        );
        $this->main->echoJson($output);
    }
    public function save_setting($modul = "")
    {
        $post   	= $this->input->post();
        $postar 	= array();
        $data   	= array();
        $PostName 	= array();
        
        if($modul == "main-menu"):
            $Value          = array();
            $Code           = "MainMenu";
            $cek            = $this->db->count_all("ut_general where Code='$Code' ");
            $ContentID      = $this->input->post("ContentID");
            $ContentIDFix   = $this->input->post("ContentIDFix");
            $ContentName    = $this->input->post("ContentName");
            $ContentUrl     = $this->input->post("ContentUrl");
            $ContentType    = $this->input->post("ContentType");
            if(count($ContentIDFix) > 0):
                foreach($ContentID as $key => $a):
                    if(in_array($a, $ContentIDFix)):
                        $Value[] = array(
                            "ContentID" => $ContentID[$key],
                            "Name"      => $ContentName[$key],
                            "Url"       => $ContentUrl[$key],
                            "Type"      => $ContentType[$key],
                            "Sub"       => array()
                        );
                    endif;
                endforeach;
                $Value = json_encode($Value);
                $this->save_setting_db($cek,$Code,$Value);
            endif;
        else:
            foreach($post as $key => $a):
            	$PostName[] = $key;
                #$postar[$key] = $this->input->post($key);
                $Code   = $key;
                $Value  = $this->input->post($Code);
                if(in_array($Code, array("ContactUsBandungList","ContactUsJakartaList","ContactUsSemarangList"))):
                    $Value = trim(preg_replace('/\s+/', ' ', $Value));
                endif;
                #data------------------------------------------------------------
                $cek    = $this->db->count_all("ut_general where Code='$Code' ");
                $this->save_setting_db($cek,$Code,$Value);
            endforeach;

            foreach($_FILES as $key => $a):
            	$PostName[] = $key;
                $Code   	= $key;
    	        $cek    	= $this->db->count_all("ut_general where Code='$Code' ");
    	        #data------------------------------------------------------------
    	        if($Code == "Logo" || $Code == "Icon"):
    	        	$nmfile 					= 'Rumah singgah ibu hamil-Rumah aman ibu hamil-'.$Code."_".time();
    				$config['upload_path'] 		= './img/general'; //path folder 
    				$config['allowed_types'] 	= 'gif|jpg|png|jpeg|bmp|PNG|JPG'; //type yang dapat diakses bisa anda sesuaikan 
    				$config['max_size'] 		= '99999'; //maksimum besar file 2M 
    				$config['max_width'] 		= '99999'; //lebar maksimum 1288 px 
    				$config['max_height'] 		= '99999'; //tinggi maksimu 768 px 
    				$config['file_name'] 		= $nmfile; //nama yang terupload nantinya 
    				$this->upload->initialize($config); 
    				$upload	= $this->upload->do_upload($Code);
    				$gbr 	= $this->upload->data();
    				if($upload): 		
    					$image 	= "img/general/".$gbr['file_name'];
    					$Value 	= $image;
    					if($cek > 0):
    						$this->main->hapus_gambar('ut_general','Value',array('Code' => $Code));
    					endif;
    		            $this->save_setting_db($cek,$Code,$Value);
    				endif;
    	        endif;
            endforeach;
        endif;
        $output = array(
            "HakAkses"  => $this->session->HakAkses,
            "Status"    => TRUE,
            "Modul"     => $modul,
            "Post" 		=> $PostName,
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

    #theme
    public function ThemeSetting(){
        $this->main->check_session();
        $url                = $this->uri->segment(1);
        $module             = "role";
        $MenuID             = $this->api->get_menuID($url);
        $read_menu          = $this->api->read_menu($MenuID);
        if($read_menu->view<=0): redirect('403_override'); endif;
        $btn_add = '';
        if($read_menu->update>0): 
            $btn_add = $this->main->button('action2'); 
        endif;

        $data["title"]      = $this->lang->line('lb_theme_setting');
        $data['url']        = $url;
        $data['module']     = $module;
        $data['content']    = 'backend/page/theme_setting';
        $data['btn_add']    = $btn_add;
        $data['data']       = $this->main->Theme();
        $this->load->view('backend/index',$data);
    }

    public function ThemeSettingSave(){
        $url                = $this->input->post('page_url');
        $module             = $this->input->post('page_module');
        $MenuID             = $this->api->get_menuID($url);
        $read_menu          = $this->api->read_menu($MenuID);

        $CompanyID  = $this->session->CompanyID;
        $p3         = $read_menu->update;
        $this->main->check_session('out',"update", $p3);

        $Theme = $this->input->post('Theme');

        $arrTheme = array(1,2,3);
        if(!in_array($Theme, $arrTheme)):
            $Theme = 1;
        endif;

        $data = array(
            "Theme" => $Theme,
        );

        $message = $this->lang->line('lb_success_update');
        $this->main->general_update("ut_user", $data, array("UserID" => $CompanyID));

        $data = array(
            'CompanyTheme'  => $Theme,
        );
        $this->session->set_userdata($data);

        $response = array(
            "status"    => true,
            "message"   => $message,
        );
        $this->main->echoJson($response);
    }

    public function Dashboard(){
        $this->main->check_session();
        $this->main->SetParent2();

        $url    = "dashboard";
        $module = "dashboard";

        $data["title"]      = "Dashboard";
        $data['url']        = $url;
        $data['module']     = $module;
        $data['content']    = 'backend/page/dashboard';
        $data['form']       = 'backend/page/form';
        $data['b_form']     = 'backend/page/breadcumb-form';
        $data['filter']		= 'backend/page/filter';
        $data['filter2']	= 'backend/page/filter2';
        $data['filter3']	= 'backend/page/filter3';
        $this->load->view('backend/index',$data);
    }

    public function frame(){
        // $this->main->cek_session();
        $page       = $this->input->post("page");
        $ID         = $this->main->generate_code_proyek();
        $folder     = 'file/temp'.$ID.'/';
        if (!is_dir($folder)) {
            mkdir('./'.$folder, 0777, TRUE);
        }
        $files = glob('./'.$folder.'*.*');
        foreach($files as $file){
            if(is_file($file))
                unlink($file);
        }

        $frame      = $this->input->post("frame");
        $filename   = $this->input->post("filename");
        $type       = $this->input->post("type");
        $typenya    = array('png','jpg','jpeg');
        $patch      = '';
        $style      = '';

        if(!$frame):
            $frame = site_url();
        else:
            if($page != "show"):
                $frame  = str_replace('[removed]', "", $frame);
                $file   = substr($frame, strpos($frame,"base64,"));
                $decoded=base64_decode($file);
                file_put_contents($folder.$filename,$decoded);
            else:
                $folder = '';
                $filename = $frame;
            endif;
            $filename;
            if(!in_array($type,$typenya)):
                $frame = 'https://docs.google.com/viewerng/viewer?url='.site_url($folder.$filename).'&embedded=true';
                $style = '<style>embed{width: 100%;height: 100%}</style>';
                $frame = '<embed src="'.$frame.'"></embed>';
            else:
                $frame = $folder.$filename;
                $frame = '<img src="'.$frame.'"/>';
            endif;
            $patch = $folder.$filename;
        endif;
        // $url = 'https://docs.google.com/viewerng/viewer?url='.site_url('file/SampelProduct20190703_092515.xls');
        $data['title']  = "Attachment";
        $data['frame']  = $frame;
        $data['style']  = $style;
        $this->load->view('backend/page/frame',$data);
    }

}