<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Fasilitas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Fasilitas_model', 'fasilitas_model');
		$this->load->library('upload');
		$this->load->helper('text');
		if ($this->session->userdata('access')!=1) {
			$text = 'Terdapat batasan hak akses pada halaman ini.';
			$this->session->set_flashdata('pesan_error', $text);
			redirect('admin', 'refresh');
		}
	}

	public function hapus($id_failitas)
	{
		$data 			= $this->fasilitas_model->get_data_by_id($id_failitas)->row();
		$foto_lama 		= 'uploads/fasilitas/'.$data->gambar_fasilitas;
		$thumbs_lama 	= 'uploads/fasilitas/thumbs/'.$data->gambar_fasilitas;
		unlink($foto_lama);
		unlink($thumbs_lama);
		$this->fasilitas_model->hapus($id_failitas);
		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, "Menghapus $data->nama_fasilitas dari tabel fasilitas");
		$text = "Fasilitas $data->nama_fasilitas berhasil dihapus.";
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/fasilitas');
	}

	public function update($id_failitas)
	{		
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_fasilitas', 'Nama Fasilitas', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('deskripsi_fasilitas', 'Deskripsi Fasilitas', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('ikon_fasilitas', 'Ikon Fasilitas', 'trim');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id_failitas);
		} else {
			$nama_fasilitas 		= sanitize($this->input->post('nama_fasilitas', TRUE));
			$deskripsi_fasilitas 	= $this->input->post('deskripsi_fasilitas');
			$ikon_fasilitas			= sanitize($this->input->post('ikon_fasilitas', TRUE));

			if (!empty($_FILES['filefoto']['name'])) {
				$data 	= $this->fasilitas_model->get_data_by_id($id_failitas)->row();
				$foto_lama = 'uploads/fasilitas/'.$data->gambar_fasilitas;
				$thumbs_lama = 'uploads/fasilitas/thumbs/'.$data->gambar_fasilitas;
				unlink($foto_lama);
				unlink($thumbs_lama);

				$config['upload_path'] 		= './uploads/images/';
				$config['allowed_types'] 	= 'jpg|png|jpeg';
				$config['encrypt_name'] 	= TRUE;

				$this->upload->initialize($config);

				if ($this->upload->do_upload('filefoto')) {
					$img 			= $this->upload->data();
					$image 			= $img['file_name'];

				// compres gambar
					$this->compress_tinify($image);
				// ubah ukuruan mjd 150x150
					$this->resize_tinify($image);
				// hapus gambar lama
					$foto_lama = './uploads/images/'.$image;
					unlink($foto_lama);

					$this->fasilitas_model->update($id_failitas, $image, $nama_fasilitas, $deskripsi_fasilitas, $ikon_fasilitas);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$this->log_model->save_log($this->session->userdata('id'), 2, "Merubah $nama_fasilitas pada tabel fasilitas");

					$text = "Fasilitas $nama_fasilitas berhasil disimpan.";
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/fasilitas');

				} else {
					$text = "Upload gambar gagal.";
					$this->session->set_flashdata('pesan_error', $text);
					redirect('admin/fasilitas/edit/'.$id_failitas);
				}
			} else {
				$this->fasilitas_model->update_no_img($id_failitas, $nama_fasilitas, $deskripsi_fasilitas, $ikon_fasilitas);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$this->log_model->save_log($this->session->userdata('id'), 2, "Merubah $nama_fasilitas pada tabel fasilitas");

				$text = "Fasilitas $nama_fasilitas berhasil disimpan.";
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/fasilitas');
			}
		}
	}

	public function edit($id_failitas)
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
		$data['bc_menu'] 			= "Fasilitas";
		$data['bc_aktif'] 			= "Edit Fasilitas";
		$data['title'] 				= "Edit Fasilitas";

		$data['form_action']		= site_url('admin/fasilitas/update/'.$id_failitas);
		$data['data_fasilitas'] 	= $this->fasilitas_model->get_data_by_id($id_failitas);


		$this->template->load('admin/template', 'admin/fasilitas/edit_v', $data);
	}

	public function detail($id_failitas)
	{
		sleep(1);
		$hasil = '';
		$data = $this->fasilitas_model->get_data_by_id($id_failitas)->row();
		$src = base_url('uploads/fasilitas/'.$data->gambar_fasilitas);
		$hasil .= '<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
		<h4 class="blue">
		<span class="middle">'.$data->nama_fasilitas.'</span>
		</h4>

		<div class="profile-user-info">
		<div class="profile-info-row">
		<div class="profile-info-name"> Nama Fasilitas </div>

		<div class="profile-info-value">
		<span>'.$data->nama_fasilitas.'</span>
		</div>
		</div>

		<div class="profile-info-row">
		<div class="profile-info-name"> Deskripsi Fasilitas </div>

		<div class="profile-info-value">
		<span>'.$data->deskripsi_fasilitas.'</span>
		</div>
		</div>

		<div class="profile-info-row">
		<div class="profile-info-name"> Gambar Fasilitas </div>

		<div class="profile-info-value">
		<span>
		<img src="'.$src.'" class="img-fluid img-responsive img-thumbnail">
		</span>
		</div>
		</div>

		<div class="profile-info-row">
		<div class="profile-info-name"> Ikon Fasilitas </div>

		<div class="profile-info-value">
		<i class="middle ace-icon '.$data->ikon_fasilitas.' bigger-150 blue"></i>
		</div>
		</div>
		</div>

		</div>
		</div>';
		$data = array(
			'detail_fasilitas' => $hasil
		);
		echo json_encode($data);
	}

	public function simpan()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_fasilitas', 'Nama Fasilitas', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('deskripsi_fasilitas', 'Deskripsi Fasilitas', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('ikon_fasilitas', 'Ikon Fasilitas', 'trim');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->tambah();
		} else {
			$nama_fasilitas 		= sanitize($this->input->post('nama_fasilitas', TRUE));
			$deskripsi_fasilitas 	= $this->input->post('deskripsi_fasilitas');
			$ikon_fasilitas			= sanitize($this->input->post('ikon_fasilitas', TRUE));

			$config['upload_path'] 		= './uploads/images/';
			$config['allowed_types'] 	= 'jpg|png|jpeg';
			$config['encrypt_name'] 	= TRUE;

			$this->upload->initialize($config);
			if ($this->upload->do_upload('filefoto')) {
				$img 			= $this->upload->data();
				$image 			= $img['file_name'];

				// compres gambar
				$this->compress_tinify($image);
				// ubah ukuruan mjd 150x150
				$this->resize_tinify($image);
				// hapus gambar lama
				$foto_lama = './uploads/images/'.$image;
				unlink($foto_lama);

				$this->fasilitas_model->simpan($image, $nama_fasilitas, $deskripsi_fasilitas, $ikon_fasilitas);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$this->log_model->save_log($this->session->userdata('id'), 2, "Menambah $nama_fasilitas pada tabel fasilitas");

				$text = "Fasilitas $nama_fasilitas berhasil disimpan.";
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/fasilitas');

			} else {
				$text = "Upload gambar gagal.";
				$this->session->set_flashdata('pesan_error', $text);
				redirect('admin/fasilitas/tambah');
			}

		}
	}

	public function tambah()
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
		$data['bc_menu'] 			= "Fasilitas";
		$data['bc_aktif'] 			= "Tambah Fasilitas";
		$data['title'] 				= "Tambah Fasilitas";

		$data['form_action']		= site_url('admin/fasilitas/simpan');

		$this->template->load('admin/template', 'admin/fasilitas/tambah_v', $data);
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
		$data['bc_aktif'] 			= "Fasilitas";
		$data['title'] 				= "Fasilitas";

		$data['action_add']			= site_url('admin/fasilitas/tambah');
		$data['data_fasilitas'] 	= $this->fasilitas_model->get_data();

		$this->template->load('admin/template', 'admin/fasilitas/data_v', $data);
	}

	public function resize_tinify($image)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$path 		= './uploads/images/'.$image;
		$new_path 	= './uploads/fasilitas/thumbs/'.$image;
		$method 	= 'thumb';
		$width 		= 150;
		$height 	= 150;

		// $method (string) method of resize image: 'scale', 'fit', 'cover', 'thumb' 
		$this->tiny_png->fileResize($path, $new_path, $method, $width, $height);
	}

	public function compress_tinify($gambar_asli)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$sumber = './uploads/images/'.$gambar_asli;
		$menuju = './uploads/fasilitas/'.$gambar_asli;

		$this->tiny_png->fileCompress($sumber, $menuju);
	}

}

/* End of file Fasilitas.php */
/* Location: ./application/controllers/admin/Fasilitas.php */

?>