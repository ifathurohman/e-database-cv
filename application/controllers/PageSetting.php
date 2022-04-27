<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageSetting extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->model("M_page_setting","page_setting");
    }

    public function index(){
    	$this->main->check_session();
		$url 				= $this->uri->segment(1);
		$module 			= "page_setting";
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		if($read_menu->view<=0): redirect('403_override'); endif;
		$btn_add = '';
		if($read_menu->insert>0): $btn_add = $this->main->button('add_new'); endif;

		$data["title"] 		= $this->lang->line('lb_page_setting');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/page_setting/policy_page_setting';
		$data['form']		= 'backend/page_setting/form';
		$data['btn_add']	= $btn_add;
		$this->load->view('backend/index',$data);
	}

	public function policy_page_setting_edit(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		$this->main->check_session('out', 'update', $read_menu->update);
		$data["title"] 		= $this->lang->line('lb_edit_data');
		$data['url']		= $url;
		$data['module']		= $module;
		$data['content'] 	= 'backend/page_setting/policy_page_setting_edit';

		$this->load->view('backend/index',$data);
	}

	public function policy_page_setting_save(){
		$url 				= $this->input->post('page_url');
		$module 			= $this->input->post('page_module');
		$MenuID 			= $this->api->get_menuID($url);
		$read_menu 			= $this->api->read_menu($MenuID);
		$CompanyID 			= $this->session->CompanyID;

		$Crud 	= "update";
		$p3 	= $read_menu->update;

		$this->main->check_session('out',$Crud, $p3);
		$this->validation->page_setting();

		$ID 				= $this->input->post("ID");
		$ParentID			= $this->input->post("ParentID");
		$Name 				= $this->input->post("Name");
		$Nameterm 			= $this->input->post("Nameterm");
		$Summary 			= $this->input->post("Summary");
		$Summaryterm 		= $this->input->post("Summaryterm");
		$Description		= $this->input->post("Description");
		$Descriptionterm	= $this->input->post("Descriptionterm");
		$Type				= $this->input->post("Type");
		$Typeterm			= $this->input->post("Typeterm");

		$data = array(
			"Name"				=> $Name,
			"Summary"			=> $Summary,
			"Description" 		=> $Description,
			"Type" 				=> 1,
			"Status" 			=> 1,
		);

		print_r($data); exit;

		$data_term = array(
			"Name"			=> $Nameterm,
			"Summary"		=> $Summaryterm,
			"Description" 	=> $Descriptionterm,
			"Type" 			=> 2,
			"Status"		=> 1,
		);

		$message = $this->lang->line('lb_success_update');

		$this->main->general_update("ut_page_setting", $data, array("PageID" => $ID));
		$insert	= $this->main->general_save("ut_page_setting",$data);

		$ID_term = $this->input->post("ID_term");
		if($ID_term):
			$this->main->general_update("ut_page_setting", $data, array("PageID" => $ParentID));
		else:
			$data_term['ParentID'] = $ID;
			$insert = $this->main->general_save("ut_page_setting",$data_term);
		endif;

		// $this->main->general_update("ut_page_setting", $data, array("PageID" => $ID));
		// $ParentID = $this->main->general_save("ut_page_setting", $data_term, array("PageID" => $ID));
		
		$this->main->set_session_page($data);

		$response = array(
			"status"	=> true,
			"message"	=> $message,
		);
		$this->main->echoJson($response);
	}

}