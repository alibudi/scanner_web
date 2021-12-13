<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelScanner extends CI_Model
{

	public function getData()
	{
		$sql = $this->db->get('tiket');
		return $sql->result();
	}

	public function addData($data)
	{
		$sql = $this->db->insert('activity', $data);
		if ($sql) {
			return true;
		} else {
			return false;
		}
	}

	public function getTiket()
	{
		// $sql = $this->db->get('pic');
		// return $sql->result();
		$this->db->select('pic.*,summary_tiket.*');
		$this->db->order_by('summary_tiket.waktu_pembelian', 'desc');
		$this->db->from('pic');
		$this->db->join('summary_tiket', 'pic.id = summary_tiket.id_pic', 'left');
		return $this->db->get()->result();
	}

	

	public function getTiketByIdPic($idPic)
	{
		$this->db->select('*');
		$this->db->from('tiket');
		$this->db->where('id_pic', $idPic);
		return $this->db->get()->row();
	}

	
	public function getTiketandSummaryByIdSummary($idSummary)
	{
		$this->db->select('pic.*,summary_tiket.*');
		$this->db->order_by('summary_tiket.waktu_pembelian', 'desc');
		$this->db->from('pic');
		$this->db->join('summary_tiket', 'pic.id = summary_tiket.id_pic', 'left');
		$this->db->where('summary_tiket.id', $idSummary);
		return $this->db->get()->row();
	}

	public function getTiketById($id)
	{
		$this->db->select('pic.*,summary_tiket.*');
		$this->db->order_by('summary_tiket.waktu_pembelian', 'desc');
		$this->db->from('pic');
		$this->db->join('summary_tiket', 'pic.id = summary_tiket.id_pic', 'left');
		$this->db->where('summary_tiket.id', $id);
		return $this->db->get()->row();
	}

	public function create_package($package, $total_harga)
	{
		$this->db->trans_start();
		//INSERT TO PACKAGE
		date_default_timezone_set("Asia/Bangkok");
		$data  = array(
			'nama' => $package,
			'email' => $this->input->post('email'),
			'nohp' => $this->input->post('nohp'),
			// 'package_created_at' => date('Y-m-d H:i:s') 
		);
		$this->db->insert('pic', $data);
		//GET ID PACKAGE
		$package_id = $this->db->insert_id();
		$result = array();
		foreach ($total_harga as $key => $val) {
			$result[] = array(
				'id_pic'   => $package_id,
				'total_harga'   => $_POST['total_harga'][$key]
			);
		}
		//MULTIPLE INSERT TO DETAIL TABLE
		$this->db->insert_batch('summary_tiket', $result);
		$this->db->trans_complete();
	}

	public function tambah()
	{
		$nama=$this->input->post('nama', true);
		$email=$this->input->post('email', true);
		$nohp=$this->input->post('nohp', true);


		$this->db->trans_start();
		$pic = [
			'nama' => $nama,
			'email' => $email,
			'nohp' => $nohp,
		];
		$this->db->insert('pic', $pic);
		$pic_id = $this->db->insert_id();
		// var_dump($pic_id);
		$tikett = [
			'id_pic' => $pic_id,
			'total_harga' => $this->input->post('total_harga', true),
			'info_1' => $this->input->post('info_1', true),
			'info_2' => $this->input->post('info_2', true),
			'info_3' => $this->input->post('info_3', true),
			'note_1' => $this->input->post('note_1', true),
			'note_2' => $this->input->post('note_2', true),
			'note_3' => $this->input->post('note_3', true),
			'statuspembayaran' => $this->input->post('statuspembayaran', true),
			'diskon' => $this->input->post('diskon', true),
			'kode_promo' => $this->input->post('kode_promo', true),
			'order_id' => $this->input->post('order_id', true),
			'waktu_pembelian' => $this->input->post('waktu_pembelian', true),
		];
		$this->db->insert('summary_tiket', $tikett);
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_port' => '587',
			'smtp_crypto' => 'tls',
			'smtp_user' => 'tiket@hops.id',
			'smtp_pass' => 'H0psmed!a',
			'mailtype'  => 'text', 
			'smtp_timeout' =>'5',
			'charset'   => 'utf-8'
		);
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");

		$this->email->from('tiket@hops.id', 'Muslima Fest');
		$this->email->to($email);
	
		$this->email->subject('Tiket Muslima Fest 2021');
		$this->email->message('
		Terima kasih,
		Bukti pembayaran tiket sudah kami terima.
		Kami sertakan tiket Muslima Fest pada email ini. 
		Tunjukkan QR Code saat datang.
		Kami tunggu kehadiran kamu di lokasi.');  
		$harike='1';
		$backgroundcolor="darkseagreen";
		$tanggal="17 Desember 2021";
		$this->generateTiket($pic_id,$this->input->post('info_1', true), $harike, $this->input->post('order_id', true), $tanggal, $backgroundcolor,$this->email);

		$harike='2';
		$backgroundcolor="lightpink";
		$tanggal="18 Desember 2021";
		$this->generateTiket($pic_id,$this->input->post('info_2', true), $harike, $this->input->post('order_id', true), $tanggal, $backgroundcolor,$this->email);
		$harike='3';
		$backgroundcolor="lightblue";
		$tanggal="19 Desember 2021";
		$this->generateTiket($pic_id,$this->input->post('info_3', true), $harike, $this->input->post('order_id', true), $tanggal, $backgroundcolor,$this->email);

		$this->db->trans_complete();





		$result=$this->getTiketByIdPic($pic_id);
		print_r($result);






		
		$this->load->library('pdf');
		$qrcode = "<html><head><style>
		@page {
			margin: 0;
		}
		
		body {
			padding: 0;
			margin: 0;
		}
		</style></head><body>";
		$qrcode .= "<table style='font-family: monospace; background-color: ;text-align: center; vertical-align: middle;'>";
		$qrcode .= "<tr><td><img width='200' height='100' src= /> <br /></td></tr>";
		$qrcode .= "<tr><td><br /></td></tr>";
		$qrcode .= "<tr><td>Tunjukkan QR Code ini Saat di Lokasi<br /></td></tr>";
		$qrcode .= "<tr><td>-------------------------------------<br /></td></tr>";
		$qrcode .= "<tr><td><img width='150' height='150' src= /> <br /></td></tr>";
		$qrcode .= "<tr><td></td></tr>";
		$qrcode .= "<tr><td></td></tr>";
		$qrcode .= "<tr><td>Gedung SMESCO Indonesia</td></tr>";
		$qrcode .= "<tr><td>Organized By</td></tr>";
		$qrcode .= "<tr><td>Hops Media</td></tr>";
		$qrcode .= "</table></body></html>";
  
	  $this->pdf->setPaper(array(0, 0, 265.00, 328.00), 'portrait');
	  $this->pdf->loadHtml($qrcode);
	  $this->pdf->render();
	  $file = $this->pdf->output();
	  $file_name = '';
	  $file_name = '/var/www/html/tiket/abc.pdf';
	  file_put_contents($file_name, $file);
	  $this->email->attach($file_name);
		

	
		$this->email->send();

		// echo $this->email->print_debugger();
	




		// die();



		if ($this->db->trans_status() == false) {
			// echo "rollback";
			redirect('home/tiket', 'refresh');
		} else {
			// echo "comite";
			redirect('home/tiket', 'refresh');
		}
	}

	public function getUser($table_name) //PERHATIKAN getUser
	{
		$get_user = $this->db->get($table_name); //get_user ?
		return $get_user->result_array();
	}

	public function getQuery($query) //PERHATIKAN getQuery
	{
		$get_user = $this->db->query($query);
		return $get_user->result_array();
	}

	public function generateTiket($pic_id,$totalTiket, $harike, $orderId, $tanggal, $backgroundcolor,$email)
	{
		$i = 0;
		$imagemuslimafest = file_get_contents('https://www.hops.id/muslimafest/assets/images/logo-muslima-fest-2021.png');
		$base64 = 'data:image/;base64,' . base64_encode($imagemuslimafest);

		while ($i < $totalTiket) {
			$randomCode = $this->generateRandomString(2);
			// echo "i".$i;

			// echo "totalTiket".$totalTiket;

			$detailtiket = [
				// 'id' => $pic_id,
				'id_pic' => $pic_id,
				'info' => $harike,
				'status' => 'CREATED',
				'random_code' => $randomCode,
				'order_id' => $orderId
			];


			$this->db->insert('tiket', $detailtiket);

			$i++;

		}
	}


	public function generateRandomString($length = 2)
	{
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		// echo $randomString;
		return $randomString;
	}
}

/* End of file ModelScanner.php */
/* Location: ./application/models/ModelScanner.php */