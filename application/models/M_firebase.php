<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_firebase extends CI_Model
{
	var $table = "FirebaseUser";
	public function __construct()
	{
		parent::__construct();
	}

	public function LastLocation($CompanyID){
		$this->db->select("FCM");
		$this->db->where("CompanyID", $CompanyID);
		$this->db->where("Status", 1);
		$this->db->where("FCM !=", null);
		$this->db->from("mt_employee");
		$query = $this->db->get()->result();
		if($query):
			$tokens 	= array();
			foreach ($query as $k => $v) {
				$tokens[] 	= $v->FCM;
			}
			$message 		= array(
				"title"		=> "Last Location",
				"message"	=> "Admin mencari lokasi Anda",
				"page"		=> "LastLocation",
			);
			$message_status = $this->send_notification($tokens, $message);
		endif;
	}

	public function send_notification($tokens, $message)
	{
		$url 	= 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
		'registration_ids' 	=> $tokens,
		'data' 				=> $message
		);
		$headers = array(
			'Authorization: key='.$this->config->item("firebase_api"),
			'Content-Type: application/json'
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);           
		if ($result === FALSE) {
		   die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}
}