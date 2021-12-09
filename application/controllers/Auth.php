<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(){
		if($this->ion_auth->logged_in()){
			redirect('auth/cek_login','refresh');
		} else{
			$this->load->view('login');
		}
	}

	public function login(){
		if($this->ion_auth->logged_in()){
			redirect('auth/cek_login','refresh');
		} else{
			$this->load->view('login');
		}
	}

	public function proses_login(){
		$this->session->set_flashdata('info', 'Gagal Login! Silahkan Masukan username dan password!');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$identity = $this->input->post('username');
			$password = $this->input->post('password');
			$remember = TRUE;
			$login = $this->ion_auth->login($identity, $password, $remember);
			if($login){
				redirect('auth/cek_login');
			} else{
				$this->session->set_flashdata('info', 'Gagal Login! Silahkan cek username dan password!');
				redirect('auth/login','refresh');
			}

		} else {
			$this->load->view('login');
		}		
	}

	public function cek_login(){
		if($this->ion_auth->logged_in()){
			if($this->ion_auth->is_admin()){
				$this->session->set_flashdata('info', 'Login Berhasil!');
				redirect('home/profil','refresh');
			} else if($this->ion_auth->in_group(2)){
			 	redirect('operator','refresh');
			} else if($this->ion_auth->in_group(3)){
				$this->session->set_userdata('KD_PDM','A004');
				redirect('koordinator','refresh');
			}  else{
				$this->ion_auth->logout();
				redirect('login','refresh');
			}
		} else{
			redirect('login','refresh');
		}
	}

	public function logout(){
		if(!$this->ion_auth->logged_in()){
			redirect('auth/login','refresh');
		} else{
			$this->ion_auth->logout();
			redirect('auth','refresh');
		}
	}
function forgot_password()
	{

		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
			);

			if ( $this->config->item('identity', 'ion_auth') == 'username' ){
				$this->data['identity_label'] = 'Username';
			}
			else
			{
				$this->data['identity_label'] = 'Email';
			}

			//set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->load->view('forgot_password', $this->data);
		}
		else
		{
			// get identity for that email
			$config_tables = $this->config->item('tables', 'ion_auth');
			$identity = $this->db->where('email', $this->input->post('email'))->limit('1')->get($config_tables['users'])->row();

			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{

			 $config = [
               'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_user' => 'budiali0709@gmail.com',    // Ganti dengan email gmail kamu
               'smtp_pass' => 'ditaputri',      // Password gmail kamu
               'smtp_port' => 465,
               // 'crlf'      => "\r\n",
               // 'newline'   => "\r\n"
           ];
           $data = array(
           	'identity'=>$forgotten['identity'],
           	'forgotten_password_code' => $forgotten['forgotten_password_code'],
           );
           $this->load->library('email');
           $this->email->initialize($config);
           $this->email->set_newline("\r\n");

           $this->email->from('budiali07099@gmail.com');
           $this->email->to($data['identity']);
         
           
           $this->email->subject('forgot password');
           $body = $this->load->view('auth/email/forgot_password.tpl.php', $data, TRUE);
           $this->email->message($body);
           
           if ($this->email->send()) {
           	$this->session->set_flashdata('info', 'Reset Password Sukses');
				redirect("auth/login", 'refresh'); 
           }
           
           echo $this->email->print_debugger();

				//if there were no errors
				// $this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->session->set_flashdata('info', 'Reset Password Sukses');
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			//if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');

			if ($this->form_validation->run() == false)
			{
				//display the form

				//set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
				'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name' => 'new_confirm',
					'id'   => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				//render
				$this->_render_page('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					//something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error('This form post did not pass our security checks.');

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						//if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						$this->logout();
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			//if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	}
