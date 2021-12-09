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
		$data['user'] 		= $this->ion_auth->user()->row();
		$id_user 	  = $data['user']->username;
		$this->load->view('home/index',$data);	
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
		// var_dump($data['tiket']);
		// die();
		$id_pic = $data['tiket']->id_pic;
		 // $myTicket = "SELECT tiket.id,tiket.id_pic,tiket.order_id,tiket.random_code,pic.nama,pic.email,'10000'+tiket.id from tiket
   //       inner join activity on tiket.id =  activity.id_tiket
   //       inner join pic on tiket.id_pic = pic.id 
   //       where tiket.id='".$id_pic."'";
		$myTicket = "SELECT summary_tiket.*,tiket.random_code,'10000'+tiket.id from summary_tiket
join tiket on summary_tiket.order_id = tiket.order_id
";
      
        
        $myTicket = $this->ModelScanner->getQuery($myTicket);
       
						foreach($myTicket as $ticket){ 
                            $codeTicket =  $ticket['order_id'] . $ticket['random_code'] . $ticket["'10000'+tiket.id"];
     
                        }
        $data['statusTicket'] = $myTicket;
        // var_dump($myTicket);
        // die;
        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = '/assets/images/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $image_name=$codeTicket.'.png'; //buat name dari qr code sesuai dengan nim
        $allData = $codeTicket;
        $params['data'] = $codeTicket; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $data['qrnya'] = $this->ciqrcode->generate($params);
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

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */