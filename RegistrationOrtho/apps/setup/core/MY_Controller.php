<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class MY_Controller extends MX_Controller
	{

		public function __construct()
		{
			parent::__construct();
			// Load
			// $this->load->library('member/member_library');

			// defined
			// $this->session->set_userdata('user_uid', 1);

			// $this->member_library->_hasChkLoggedin();
			

			

		}

		// Set Current URL for security website
		private function currentUrl()
		{
			$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			/*
				if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443){
					$protocol = 'https://';
				}else{
					$protocol = 'http://';
				}
			*/

			$current = $_SERVER['HTTP_HOST'] . '/' . APPNAME . '/';

			return $protocol . $current;
		}



	}