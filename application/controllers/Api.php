<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
public function __construct(){
            parent::__construct();
            $this->load->model('ModelScanner');
            // if(!$this->ion_auth->is_admin()){
            //     redirect('auth','refresh');
            // }
       }
    public function index()
    {
        $siswa = $this->ModelScanner->getTenan();
        $response = array();

        foreach($siswa as $hasil) {

            $response[] = array(
                'id'    => $hasil->id,
                'random_code' => $hasil->random_code,
                'code_tenan'     => $hasil->code_tenan,     
            );

        }
        
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'success' => true,
                'message' => 'Get All Data Tenan',
                'data'    => $response  
            )
        );

    }

    public function addTenan()
    {
        //set validasi
        $this->form_validation->set_rules('id_tenan','Id Tenan','required');
        $this->form_validation->set_rules('nama','Nama','required');

        if($this->form_validation->run() == TRUE){

            $data = array(
                'id_tenan' => $this->input->post("id_tenan"),
                'nama'     => $this->input->post("nama"),
            );

            $simpan = $this->ModelScanner->AddTenan($data);

            if($simpan) {

                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Data Berhasil Disimpan!'
                    )
                );

            } else{
                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Data Gagal Disimpan!'
                    )
                );
            }

        }else{
            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'success'    => false,
                    'message'    => validation_errors()
                )
            );

        }
    }

    public function detailTenan($id)
    {
        $id = $this->uri->segment(3);
        $data['tenan'] = $this->ModelScanner->getTenanById($id)->result();
         // $data=[];
         header('Content-Type: application/json');
         
        echo json_encode($data); 
         // echo json_encode(
          
         //    $data[
         //         'random_code' => $tenan->random_code,
         //     ],
         // );
        // if ($tenan) {
        //     header('Content-Type: application/json');
        //     echo json_encode(
        //         array(
        //             'success' => true,
        //             'data'    => array(
        //                 'random_code' => $tenan->random_code,
        //                 'code_tenan'     => $tenan->code_tenan   
        //             )  ,
        //         )
        //     );
        // } else {
        //      header('Content-Type: application/json');
        //     echo json_encode(
        //         array(
        //             'success' => false,
        //             'message' => 'Data Siswa Tidak Ditemukan!'
        //         )
        //     );
        // }
    }

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */