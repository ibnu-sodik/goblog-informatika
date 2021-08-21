<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Sambutan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Sambutan_model', 'sambutan_model');
		$this->load->library('upload');
		$this->load->helper('text');
		if ($this->session->userdata('access')!=1) {
			$text = 'Terdapat batasan hak akses pada halaman ini.';
			$this->session->set_flashdata('pesan_error', $text);
			redirect('admin', 'refresh');
		}
	}

	public function update($id_sambutan)
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('konten_sambutan', 'Konten Kontak', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {

			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['encrypt_name'] = TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				$data = $this->sambutan_model->get_sambutan_data_by_id($id_sambutan)->row();
				$gambar_lama = 'uploads/background/'.$data->gambar_sambutan;
				unlink($gambar_lama);

				if ($this->upload->do_upload('filefoto')) {
					$img 			= $this->upload->data();
					$image 			= $img['file_name'];
					$konten_sambutan 	= $this->input->post('konten_sambutan');

					$this->compress_tinify($image);
					$this->sambutan_model->update_sambutan($id_sambutan, $image, $konten_sambutan);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$this->log_model->save_log($this->session->userdata('id'), 3, 'Update Data Kata sambutan');

					$foto_lama = './uploads/images/'.$image;
					unlink($foto_lama);
					
					$text = "Update data berhasil.";
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/sambutan');
				} else {
					$text = "Update gagal.";
					$this->session->set_flashdata('pesan_error', $text);
					redirect('admin/sambutan');
				}
			} else {
				$konten_sambutan 	= $this->input->post('konten_sambutan');

				$this->sambutan_model->update_sambutan_no_img($id_sambutan, $konten_sambutan);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$this->log_model->save_log($this->session->userdata('id'), 3, 'Update Data Kata sambutan');

				$text = "Update data berhasil.";
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/sambutan');
			}

		}
	}

	public function simpan()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('konten_sambutan', 'Kata Sambutan', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->tambah_data_sambutan();
		} else {

			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['encrypt_name'] = TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				if ($this->upload->do_upload('filefoto')) {
					$img 			= $this->upload->data();
					$image 			= $img['file_name'];
					$konten_sambutan 	= $this->input->post('konten_sambutan');

					$this->compress_tinify($image);
					$this->sambutan_model->simpan_konten($image, $konten_sambutan);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$this->log_model->save_log($this->session->userdata('id'), 2, 'Menambah Data Baru Kata sambutan');

					$foto_lama = './uploads/images/'.$image;
					unlink($foto_lama);
					
					$text = "Data baru konten sambutan berhasil disimpan.";
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/sambutan');
				} else {
					$text = "Gagal menyimpan data.";
					$this->session->set_flashdata('pesan_error', $text);
					redirect('admin/sambutan');
				}
			} else {
				redirect('admin/sambutan','refresh');
			}

		}
	}

	public function tambah_data_sambutan()
	{	
		$data_sambutan 				= $this->sambutan_model->get_sambutan_data();
		if ($data_sambutan->num_rows() > 0) {
			$text = "Dilarang mengakses halaman ini.";
			$this->session->set_flashdata('pesan_error', $text);
			redirect('admin/sambutan');
		}	
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site 						= $this->site_model->get_site_data()->row_array();
		$data['site_title'] 		= $site['site_title'];
		$data['site_name'] 			= $site['site_name'];
		$data['site_keywords'] 		= $site['site_keywords'];
		$data['site_author'] 		= $site['site_author'];
		$data['site_logo'] 			= $site['site_logo'];
		$data['site_description'] 	= $site['site_description'];
		$data['site_favicon'] 		= $site['site_favicon'];
		$data['tahun_buat'] 		= $site['tahun_buat'];
		$data['bc_menu'] 			= "Kata Sambutan";
		$data['bc_aktif'] 			= "Tambah Kata Sambutan";
		$data['title'] 				= "Tambah Kata Sambutan";

		$data['form_action'] 		= site_url('admin/sambutan/simpan');

		$this->template->load('admin/template', 'admin/sambutan/tambah_v', $data);
	}

	public function index()
	{
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site 						= $this->site_model->get_site_data()->row_array();
		$data['site_title'] 		= $site['site_title'];
		$data['site_name'] 			= $site['site_name'];
		$data['site_keywords'] 		= $site['site_keywords'];
		$data['site_author'] 		= $site['site_author'];
		$data['site_logo'] 			= $site['site_logo'];
		$data['site_description'] 	= $site['site_description'];
		$data['site_favicon'] 		= $site['site_favicon'];
		$data['tahun_buat'] 		= $site['tahun_buat'];
		$data['bc_aktif'] 			= "Kata Sambutan";
		$data['title'] 				= "Kata Sambutan";

		$data_sambutan 				= $this->sambutan_model->get_sambutan_data();
		if ($data_sambutan->num_rows() == 0) {
			$this->tambah_data_sambutan();
		} else {
			$data['form_action'] 	= site_url('admin/sambutan/update');
			$data['data_sambutan'] 	= $this->sambutan_model->get_sambutan_data();
			$this->template->load('admin/template', 'admin/sambutan/data_v', $data);			
		}
	}

	public function compress_tinify($gambar_asli)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$sumber = './uploads/images/'.$gambar_asli;
		$menuju = './uploads/background/'.$gambar_asli;

		$this->tiny_png->fileCompress($sumber, $menuju);
	}

}

/* End of file Sambutan.php */
/* Location: ./application/controllers/admin/Sambutan.php */

?>