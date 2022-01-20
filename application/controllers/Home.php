<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
			parent::__construct();
			$this->load->model('ModelScanner');
		    if(!$this->ion_auth->is_admin()){
				redirect('auth','refresh');
			}
	   }
	public function index()
	{
		$data['user'] = $this->ion_auth->user()->row();
		$data['id_user'] 	  = $data['user']->username;
		$id_user = $data['user']->id;
		$data['tiket'] = $this->ModelScanner->getTiket();
		$data['main'] = 'tiket/index';
		$this->load->view('template/template', $data, FALSE);
	}

	public function addSnack()
	{
    	$this->form_validation->set_rules('id_tiket', 'ID Scanner','trim|required');
    	$this->form_validation->set_rules('userscanner', 'Username','trim|required');
    	$this->form_validation->set_rules('kegiatan', 'Activitas','trim|required');
    	if ($this->form_validation->run() == TRUE) {
        	 $data = array(
        	'id_tiket' => $this->input->post('id_tiket'),
        	'userscanner'=> $this->input->post('userscanner'),
        	'kegiatan'=> $this->input->post('kegiatan'),
        	'waktu'=> $this->input->post('waktu'),
        	);
    	$cek = $this->ModelScanner->addData($data);
    	if ($cek) {
      	$this->session->set_flashdata('info', 'Tambah Data sukses');
      	redirect('home/detail','refresh');
    	}else{
      	$this->session->set_flashdata('info', 'Tambah Data Gagal');
      	redirect('home/detail','refresh');
    	} 
    	}else{
      	$this->session->set_flashdata('info', 'Tambah Data Gagal');
      	redirect('home/detail','refresh');
   	 	}
  	}

  	public function addMasuk()
	{
    	$this->form_validation->set_rules('id_tiket', 'ID Scanner','trim|required');
    	$this->form_validation->set_rules('userscanner', 'Username','trim|required');
    	$this->form_validation->set_rules('kegiatan', 'Activitas','trim|required');
    	if ($this->form_validation->run() == TRUE) {
        	 $data = array(
        	'id_tiket' => $this->input->post('id_tiket'),
        	'userscanner'=> $this->input->post('userscanner'),
        	'kegiatan'=> $this->input->post('kegiatan'),
        	'waktu'=> $this->input->post('waktu'),
        	);
    	$cek = $this->ModelScanner->addData($data);
    	if ($cek) {
      	$this->session->set_flashdata('info', 'Tambah Data sukses');
      	redirect('home','refresh');
    	}else{
      	$this->session->set_flashdata('info', 'Tambah Data Gagal');
      	redirect('home','refresh');
    	} 
    	}else{
      	$this->session->set_flashdata('info', 'Tambah Data Gagal');
      	redirect('home','refresh');
   	 	}
  	}


	public function detail()
	{
		$data['user'] 		= $this->ion_auth->user()->row();
		$data['id_user'] 	  = $data['user']->username;
		$data['main']		= 'home/detail';
		$this->load->view('template/template',$data);
	}

 	public function profil(){
		$data['user'] = $this->ion_auth->user()->row();
		$data['id_user'] 	  = $data['user']->username;
		$id_user 	  = $data['user']->id;
		$data['main'] = 'home/profil';
		$this->load->view('template/template',$data);
	}

	public function changeProfil($id=null){
		if($id==null){
			$this->session->set_flashdata('info', 'Gagal Simpan Perubahan!');
			redirect('admin/profil','refresh');
		}
		$this->form_validation->set_rules('username', 'Username','required',	
			array(	'required'		=> 'Username Tidak Boleh Kosong'));
		
		if ($this->form_validation->run() == TRUE) {
			$username = strtolower($this->input->post('username'));
			$data = array(
					'username'	=> $username,
					'hari'		 => $this->input->post('hari'),
					'aktivitas'		 => $this->input->post('aktivitas'),
				);

			$sql = $this->ion_auth->update($id,$data);
			if($sql){
				$this->session->set_flashdata('info', 'Sukses Simpan Perubahan!');
				redirect('home/profil','refresh');
			} else{
				$this->session->set_flashdata('info', 'Gagal Simpan Perubahan!');
				redirect('home/profil','refresh');
			}
		} else {
			$data['user'] = $this->ion_auth->user()->row();
			$data['id_user'] 	  = $data['user']->username;
			$id_user = $data['user']->id;
			$data['main'] = 'home/profil';
			$this->load->view('template/template',$data);
		}
	}



	public function tiket()
	{
		$data['user'] = $this->ion_auth->user()->row();
		$data['id_user'] 	  = $data['user']->username;
		$id_user = $data['user']->id;
		$data['tiket'] = $this->ModelScanner->getTiket();
		$data['main'] = 'tiket/index';
		$this->load->view('template/template', $data, FALSE);
	}

	public function add()
	{
		$data['user'] = $this->ion_auth->user()->row();
		$data['id_user'] 	  = $data['user']->username;
		$id_user = $data['user']->id;
		$data['main'] = 'tiket/create';
		$this->load->view('template/template', $data, FALSE);
	}


	public function create()
	{
       	$this->load->helper('string');
        $this->ModelScanner->tambah();
    }

    public function detailTiket($id=null)
    {
    	if($id==null){
	    $this->session->set_flashdata('info', 'Gagal Edit Data!');
	    redirect('home/tiket','refresh');
		}
		$data['user'] = $this->ion_auth->user()->row();
		$data['id_user'] 	  = $data['user']->username;
		$id_user = $data['user']->id;
		$data['tiket'] = $this->ModelScanner->getTiketById($id);
		$id_pic = $data['tiket']->id_pic;
		$myTicket = "SELECT pic.*,'10000'+tiket.id as tiket_id, tiket.id as id_tiket, tiket.id_pic,tiket.random_code,summary_tiket.* from pic
				join tiket on pic.id = tiket.id_pic
			join summary_tiket on pic.id = summary_tiket.id_pic
			where pic.id='$id_pic'";
      
        
        $myTicket = $this->ModelScanner->getQuery($myTicket);
       
						// foreach($myTicket as $ticket){ 
      //                       $codeTicket =  $ticket['order_id'] . $ticket['random_code'] . $ticket["tiket_id"];
     
      //                   }
        $data['statusTicket'] = $myTicket;
      	// $d = $this->ModelScanner->getActivity($id);
      	$c  = "SELECT pic.*, tiket.id as id_tiket, tiket.id_pic,tiket.random_code	,activity.* from pic
				join tiket on pic.id = tiket.id_pic
			-- join summary_tiket on pic.id = summary_tiket.id_pic
			join activity on activity.id_tiket = tiket.id
			where pic.id='$id_pic'";
      	$data['activity'] = $this->ModelScanner->getQuery($c);
      	// print_r($data);
		$data['main'] = 'tiket/detail';
		$this->load->view('template/template', $data); 
    }

   public function generateRandomString($length = 4)
	{	
	  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	  $charactersLength = strlen($characters);
	  $randomString = '';
	  for ($i = 0; $i < $length; $i++) {
	    $randomString .= $characters[rand(0, $charactersLength - 1)];
	  }
	  return $randomString;
	}

	public function tenan()
	{
		$data['user'] 		= $this->ion_auth->user()->row();
		$data['id_user'] 	  = $data['user']->username;
		$data['main']		= 'tenan/detail';
		$this->load->view('template/template',$data);
	}

	// public function addTenan2()
	// {
	// 	//set validasi
 //        $this->form_validation->set_rules('id_tenan','Id Tenan','required');
 //        $this->form_validation->set_rules('nama','Nama','required');

 //        if($this->form_validation->run() == TRUE){

 //            $data = array(
 //                'id_tenan' => $this->input->post("id_tenan"),
 //                'nama'     => $this->input->post("nama"),
 //            );

 //            $simpan = $this->ModelScanner->AddTenan($data);

 //            if($simpan) {

 //                header('Content-Type: application/json');
 //                echo json_encode(
 //                    array(
 //                        'success' => true,
 //                        'message' => 'Data Berhasil Disimpan!'
 //                    )
 //                );

 //            } else{
 //                header('Content-Type: application/json');
 //                echo json_encode(
 //                    array(
 //                        'success' => false,
 //                        'message' => 'Data Gagal Disimpan!'
 //                    )
 //                );
 //            }

 //        }else{
 //            header('Content-Type: application/json');
 //            echo json_encode(
 //                array(
 //                    'success'    => false,
 //                    'message'    => validation_errors()
 //                )
 //            );

 //        }
	// }

	public function addTenan()
	{
    	$this->form_validation->set_rules('id_tenan', 'ID Scanner','trim|required');
    	$this->form_validation->set_rules('userscanner', 'Username','trim|required');
    	$this->form_validation->set_rules('kegiatan', 'Activitas','trim|required');
    	if ($this->form_validation->run() == TRUE) {
        	 $data = array(
        	'id_tenan' => $this->input->post('id_tenan'),
        	'userscanner'=> $this->input->post('userscanner'),
        	'nama'=> $this->input->post('nama'),
        	'kegiatan'=> $this->input->post('kegiatan'),
        	'waktu'=> $this->input->post('waktu'),
        	);
    	$cek = $this->ModelScanner->AddTenan($data);
    	if ($cek) {
      	$this->session->set_flashdata('info', 'Tambah Data sukses');
      	redirect('home/tenan','refresh');
    	}else{
      	$this->session->set_flashdata('info', 'Tambah Data Gagal');
      	redirect('home/tenan','refresh');
    	} 
    	}else{
      	$this->session->set_flashdata('info', 'Tambah Data Gagal');
      	redirect('home/tenan','refresh');
   	 	}
  	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */