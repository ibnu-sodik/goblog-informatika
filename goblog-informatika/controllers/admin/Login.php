<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Login_model', 'login_model');
		$this->load->model('admin/Log_model', 'log_model');
		$this->load->model('Site_model', 'site_model');

		if ($this->session->userdata('logged_in') == TRUE) {
			$url = base_url('admin/dashboard');
			redirect($url, 'refresh');
		}
	}

	public function index()
	{
		if ($this->site_model->get_site_data()->num_rows() == 0) {
			$text = 'Mohon Atur Website terlebih dahulu.!';
			$this->session->set_flashdata('pesan', $text);
			$url = base_url('admin/add-website');
			redirect($url, 'refresh');
		}else{
			$site 						= $this->site_model->get_site_data()->row_array();
			$data['url'] 				= site_url('login');
			$data['canonical'] 			= site_url('login');
			$data['site_title'] 		= $site['site_title'];
			$data['site_name'] 			= $site['site_name'];
			$data['site_keywords'] 		= $site['site_keywords'];
			$data['site_author'] 		= $site['site_author'];
			$data['site_logo'] 			= $site['site_logo'];
			$data['site_description'] 	= $site['site_description'];
			$data['site_favicon'] 		= $site['site_favicon'];
			$data['tahun_buat'] 		= $site['tahun_buat'];

			$data['title']				= "Login";
			$data['judul']				= "Login";

			$data['form_act_login'] 	= site_url('admin/login/auth');
			$data['form_act_forget'] 	= site_url('admin/send-reset-code');
			$data['flash'] 				= $this->session->flashdata('pesan');

			$this->load->view('admin/login_v', $data);
		}
	}

	public function auth()
	{
		$username = sanitize($this->input->post('username', True));
		$password = sanitize($this->input->post('password', True));
		$validasi = $this->login_model->validasi($username);

		if ($validasi->num_rows() > 0) {
			$user_data = $validasi->row_array();
			$password = sha1(md5($password));
			if ($password != $user_data['password']) {				
				$url = base_url('admin');
				$text = 'Password Salah.!';
				$this->session->set_flashdata('pesan', $text);
				redirect($url, 'refresh');
			}else if($user_data['status'] == 0) {
				$url = base_url('admin');
				$text = 'Akun anda dikunci. Silahkan Hubungi admin!';
				$this->session->set_flashdata('pesan', $text);
				redirect($url, 'refresh');
			}else{
				$this->session->set_userdata('logged_in', TRUE);
				$date = date('Y-m-d H:i:s');
				if ($user_data['level']==1) {
					// Admin
					$this->session->set_userdata('access', '1');
					$id = $user_data['id'];

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$this->log_model->save_log($id, 0, 'Login Website');
					
					$last_login = $user_data['last_login'];
					$this->session->set_userdata('id', $id);
					redirect('admin/dashboard');
				} else {
					// Other access
					$this->session->set_userdata('access', '2');
					$id = $user_data['id'];

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$this->log_model->save_log($id, 0, 'Login Website');
					
					$last_login = $user_data['last_login'];
					$this->session->set_userdata('id', $id);
					redirect('admin/dashboard');
				}
			}
		}else{
			$url = base_url('admin');
			$text = 'Username tidak terdaftar.!';
			$this->session->set_flashdata('pesan', $text);
			redirect($url, 'refresh');
		}
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/admin/Login.php */

?>