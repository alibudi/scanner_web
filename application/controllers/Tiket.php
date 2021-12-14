<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket extends CI_Controller {
	public function __construct(){
			parent::__construct();
			$this->load->model('ModelScanner');
		    if(!$this->ion_auth->is_admin()){
				redirect('auth','refresh');
			}
	   }
	public function index()
	{
		$data['user'] 		= $this->ion_auth->user()->row();
		$id_user 	  = $data['user']->username;
        echo "Test";die();
		$this->load->view('tiket/index',$data);	
	}

}