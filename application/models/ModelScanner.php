<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelScanner extends CI_Model {

	public function getData()
	{
		$sql = $this->db->get('tiket');
		return $sql->result();
	}

	public function addData($data)
	{
		$sql = $this->db->insert('activity',$data);
		if($sql){
			return true;
		} else{
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

	public function getTiketById($id)
	{
		$this->db->select('pic.*,summary_tiket.*');
		$this->db->order_by('summary_tiket.waktu_pembelian', 'desc');
		$this->db->from('pic');
		$this->db->join('summary_tiket', 'pic.id = summary_tiket.id_pic', 'left');
		$this->db->where('summary_tiket.id', $id);
		return $this->db->get()->row();
	}

	public function create_package($package,$total_harga){
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
                foreach($total_harga AS $key => $val){
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
    	$this->db->trans_start();
    	$pic = [
    		'nama' => $this->input->post('nama',true),
    		'email' => $this->input->post('email',true),
    		'nohp' => $this->input->post('nohp',true),
    	];
    	$this->db->insert('pic', $pic);
    	$pic_id = $this->db->insert_id();
    	// var_dump($pic_id);
    	$tikett = [
    		'id_pic' => $pic_id,
    		'total_harga' => $this->input->post('total_harga',true),
    		'info_1' => $this->input->post('info_1',true),
    		'info_2' => $this->input->post('info_2',true),
    		'info_3' => $this->input->post('info_3',true),
    		'note_1' => $this->input->post('note_1',true),
    		'note_2' => $this->input->post('note_2',true),
    		'note_3' => $this->input->post('note_3',true),
    		'statuspembayaran' => $this->input->post('statuspembayaran',true),
    		'diskon' => $this->input->post('diskon',true),
    		'kode_promo' => $this->input->post('kode_promo',true),
    		'order_id' => $this->input->post('order_id',true),
    		'waktu_pembelian' => $this->input->post('waktu_pembelian',true),
    	];
    	$this->db->insert('summary_tiket',$tikett);

    	$data2 = [
    		'id_pic' => $pic_id,
    		'random_code' => $this->input->post('random_code',true),
    		'info'	=> $this->input->post('info',true),
    		'status' => $this->input->post('status',true),
    		'order_id' => $this->input->post('order_id',true),
    	];
    	$this->db->insert('tiket',$data2);
    	$this->db->trans_complete();

    	if ($this->db->trans_status() == false) {
    		// echo "rollback";
    		redirect('home/tiket','refresh');
    	} else{
    		// echo "comite";
    		redirect('home/tiket','refresh');
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
}

/* End of file ModelScanner.php */
/* Location: ./application/models/ModelScanner.php */