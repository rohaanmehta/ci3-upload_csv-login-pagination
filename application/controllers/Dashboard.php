<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function page()
	{
		$this->load->helper('url');
        $name = $this->session->userdata();
        if(isset($name['id']) && !empty($name['id'])){
			$this->load->view('dashboard');
        }else{
			$this->load->view('login');
		}	
	}
}
