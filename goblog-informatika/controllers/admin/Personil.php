<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Personil extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Site_model', 'site_model');		
		$this->load->model('admin/Personil_model', 'personil_model');		
		$this->load->model('admin/Artikel_model', 'artikel_model');		
		$this->load->model('admin/Log_model', 'log_model');
		$this->load->helper('text');
	}

	public function hapus($id)
	{
		error_reporting(0);
		$data_p = $this->personil_model->get_data_by_id($id);
		if ($data_p->num_rows() > 0) {
			$data = $data_p->row();
			$foto_p = "uploads/personil/".$data->foto;
			chmod('uploads/personil/', 0777);
			unlink($foto_p);
		}
		$data_a = $this->artikel_model->get_data_by_author($id);
		if ($data_a->num_rows() > 0) {
			$data = $data_a->row();
			$jumlah = $data_a->num_rows();
			foreach ($data_a->result() as $row) {				
				$foto_a = "uploads/artikel/".$row->gambar_artikel;
				chmod($foto_a, 0777);
				unlink($foto_a);
			}
		}

		$pilihan = array(
			'tb_personil' 			=> 'id',
			'tb_artikel' 			=> 'id_author',
			'tb_label_artikel' 		=> 'user_id_label',
			'tb_kategori_artikel' 	=> 'user_id_kategori',
			'tb_log' 				=> 'log_userid',
			'tb_sosmed_personil' 	=> 'id_personil_sosmed',
		);
		foreach ($pilihan as $table => $kolom) {
			$this->personil_model->hapus_multi($id, $table, $kolom);
		}

		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$id_author = $this->session->userdata('id');					
		$this->log_model->save_log($id_author, 4, 'Hapus seluruh data '.$data_p->full_name);

		$text = "Data Artikel, Label, Kategori dan Profil $full_name berhasil dihapus.";
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/personil', 'refresh');
	}

	public function update($id)
	{
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'html'));
		$this->form_validation->set_rules('full_name', 'Nama Lengkap','required|strip_tags|min_length[3]');
		$this->form_validation->set_rules('jenis_fungsi', 'Fungsi/ Jabatan','required|strip_tags|trim');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id);
		}else{
			$errors = array();
			$username 		= $this->input->post('username', TRUE);
			$email 			= $this->input->post('email', TRUE);
			$full_name 		= $this->input->post('full_name', TRUE);
			$jenis_fungsi 	= $this->input->post('jenis_fungsi', TRUE);
			$level 	= $this->input->post('level', TRUE);

			if (empty($username)) {
				$errors[] = "Username harus diisi.";
			}
			$cek_us = $this->db->query("SELECT * FROM tb_personil WHERE username = '$username' AND id != '$id'");
			if ($cek_us->num_rows() > 0) {
				$errors[] = "Username $username sudah digunakan.";
			}
			if (empty($email)) {
				$errors[] = "Email harus diisi.";
			}
			$cek_us = $this->db->query("SELECT * FROM tb_personil WHERE email = '$email' AND id != '$id'");
			if ($cek_us->num_rows() > 0) {
				$errors[] = "Email $email sudah digunakan.";
			}

			if (!empty($errors)) {
				foreach ($errors as $error) {
					$this->session->set_flashdata('pesan_error', $error);
					redirect('admin/personil/edit/'.$id, 'refresh');
				}
			}else{
				$this->personil_model->update($id, $full_name, $username, $email, $jenis_fungsi, $level);
				// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$id_author = $this->session->userdata('id');					
				$this->log_model->save_log($id_author, 3, 'Update data personil '.$full_name);
				$text = "Data $full_name berhasil disimpan.";
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/personil', 'refresh');
			}

		}
	}

	public function edit($id)
	{
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site = $this->site_model->get_site_data()->row_array();
		$data['site_title'] 		= $site['site_title'];
		$data['site_name'] 			= $site['site_name'];
		$data['site_keywords'] 		= $site['site_keywords'];
		$data['site_author'] 		= $site['site_author'];
		$data['site_logo'] 			= $site['site_logo'];
		$data['site_description'] 	= $site['site_description'];
		$data['site_favicon'] 		= $site['site_favicon'];
		$data['tahun_buat'] 		= $site['tahun_buat'];
		$data['bc_menu'] 			= "Personil";
		$data['bc_aktif'] 			= "Edit Personil";
		$data['title'] 				= "Personil";
		$data['data'] 				= $this->personil_model->get_data_by_id($id);
		$data['form_action'] 		= site_url('admin/personil/update');

		$this->template->load('admin/template', 'admin/personil/edit_v', $data);
	}

	public function lock($id)
	{
		$data = $this->personil_model->get_data_by_id($id);
		if ($data->num_rows() < 0) {
			$text = "Data tidak ditemukan.";
			$this->session->set_flashdata('pesan_error', $text);
			redirect('admin/personil');
		}else{
			$row = $data->row();
			$this->personil_model->lock($id);

			$text = $row->full_name." berhasil di nonaktifkan.";
			$this->session->set_flashdata('pnotify', $text);
			redirect('admin/personil');
		}
	}

	public function unlock($id)
	{
		$data = $this->personil_model->get_data_by_id($id);
		if ($data->num_rows() < 0) {
			$text = "Data tidak ditemukan.";
			$this->session->set_flashdata('pesan_error', $text);
			redirect('admin/personil');
		}else{
			$row = $data->row();
			$this->personil_model->unlock($id);

			$text = $row->full_name." berhasil aktif.";
			$this->session->set_flashdata('pnotify', $text);
			redirect('admin/personil');
		}
	}

	public function save()
	{
		$this->form_validation->set_rules('full_name', 'Nama Lengkap','required|strip_tags|min_length[3]');
		$this->form_validation->set_rules('email', 'Email','required|strip_tags|valid_email|min_length[3]|is_unique[tb_personil.email]');
		$this->form_validation->set_rules('username', 'Username','required|strip_tags|is_unique[tb_personil.username]|min_length[3]');
		$this->form_validation->set_rules('password', 'Password','required|strip_tags|min_length[6]');

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		$this->form_validation->set_message('username', 'Username %s sudah digunakan.');
		$this->form_validation->set_message('email', 'Email %s sudah terdaftar.');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			
			$username = $this->input->post('username', true);
			$password 	= sha1(md5($this->input->post('password', true)));
			$full_name 	= $this->input->post('full_name', true);
			$email 		= $this->input->post('email', true);

			$password_text = $this->input->post('password', true);

			$kode_aktivasi = $this->get_code();
			$this->send_email_notif($email, $kode_aktivasi, $full_name, $username, $password_text);

			$simpan = $this->personil_model->tambah_data($username, $password, $full_name, $email);

			// $this->personil_model->save_aktivasi($email, $kode_aktivasi);

			$text = $full_name." berhasil disimpan pada data Personil. Silahkan cek email untuk mengaktifkan akun.";
			$this->session->set_flashdata('pesan', $text);
			redirect('admin/personil');
		}
	}

	public function index()
	{
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site = $this->site_model->get_site_data()->row_array();
		$data['site_title'] 		= $site['site_title'];
		$data['site_name'] 			= $site['site_name'];
		$data['site_keywords'] 		= $site['site_keywords'];
		$data['site_author'] 		= $site['site_author'];
		$data['site_logo'] 			= $site['site_logo'];
		$data['site_description'] 	= $site['site_description'];
		$data['site_favicon'] 		= $site['site_favicon'];
		$data['tahun_buat'] 		= $site['tahun_buat'];
		$data['bc_aktif'] 			= "Personil";
		$data['title'] 				= "Personil";

		$data['data_personil']		= $this->personil_model->get_all_data();

		$this->template->load('admin/template', 'admin/personil/data_v', $data);
	}

	public function send_email_notif($email, $kode_aktivasi, $full_name, $username, $password_text)
	{
		$this->load->config('email');
		$this->load->library('email');
		$site = $this->site_model->get_site_data()->row_array();

		$subjek 				= "Personil Baru Pada ".$site['site_name'];
		$data['subjek'] 		= $subjek;
		$data['url_aktivasi']	= site_url('admin/aktivasi/'.$kode_aktivasi);
		$data['site_name']		= $site['site_name'];
		$data['tahun_buat'] 	= $site['tahun_buat'];
		$data['kode_aktivasi']	= $kode_aktivasi;
		$data['full_name']		= $full_name;
		$data['username']		= $username;
		$data['password']		= $password_text;
		$this->email->from($this->config->item('smtp_user'), 'admin@'.$site['site_name']);
		$this->email->to($email);

		$this->email->subject($subjek);
		$this->email->message($this->load->view('email/aktivasi_user_v', $data, TRUE));
		// $this->email->message("Email isi disini");

		if ($this->email->send()) {
			// simpan data pada db
			$this->personil_model->save_aktivasi($email, $kode_aktivasi);
			// echo $this->email->print_debugger();
			// $text = "Kode aktivasi akun telaha dikirim ke ".$email;
			// $this->session->set_flashdata('pnotify', $text);
			// $url = site_url('admin/personil');
			// redirect($url);
		}else{
			// echo $this->email->print_debugger();
			$text = "Gagal mengirim email";
			$this->session->set_flashdata('pesan_error', $text);
			$url = site_url('admin/personil');
			redirect($url);
		}
	}

	public function get_code()
	{
		$this->load->helper('string');
		$string = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		return substr(str_shuffle($string), 0, 43);
		// return random_string('alnum', 42);
	}

}

/* End of file Personil.php */
/* Location: ./application/controllers/admin/Personil.php */

?>