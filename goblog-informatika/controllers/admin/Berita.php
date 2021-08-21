<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Berita_model', 'berita_model');
		$this->load->library('upload');
		$this->load->helper('text');
	}

	public function hapus($id_berita)
	{
		$data 				= $this->berita_model->get_berita_by_id($id_berita)->row();		
		$images 			= "./uploads/images/".$data->gambar_berita;
		$img_berita 		= "./uploads/berita/".$data->gambar_berita;
		unlink($images);
		unlink($img_berita);

		$text = $data->nama_berita.' Berhasil dihapus dari berita.!';
		$this->berita_model->hapus_berita($id_berita);
		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, 'Menghapus berita '.$data->nama_berita);
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/berita');
	}

	public function update($id_berita)
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_berita', 'Nama Agenda', 'trim|required|min_length[5]');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id_berita);
		} else {
			$config['upload_path'] 		= './uploads/images/';
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['encrypt_name'] 	= TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				// error_reporting(0);
				$data 				= $this->berita_model->get_berita_by_id($id_berita)->row();		
				$images 			= "./uploads/images/".$data->gambar_berita;
				$img_berita 		= "./uploads/berita/".$data->gambar_berita;
				unlink($images);
				unlink($img_berita);

				if ($this->upload->do_upload('filefoto')) {
					$img = $this->upload->data();
					
					$config['image_library'] 	= 'gd2';
					$config['source_image'] 	= './uploads/images/'.$img['file_name'];
					$config['create_thumb'] 	= false;
					$config['maintain_ratio'] 	= false;
					$config['quality'] 			= '100%';
					$config['width'] 			= 800;
					$config['height'] 			= 570;
					$config['new_image'] 		= './uploads/images/'.$img['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$id_berita 			= $this->input->post('id_berita', TRUE);
					$image 				= $img['file_name'];
					$nama_berita 		= strip_tags(htmlspecialchars($this->input->post('nama_berita', true), ENT_QUOTES));
					$konten 	= $this->input->post('konten');
					$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
					$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
					$trim 		= trim($string);
					$praslug 	= strtolower(str_replace(" ", "-", $trim));
					$query 		= $this->db->query("SELECT * FROM tb_berita WHERE slug_berita = '$praslug' AND id_berita != '$id_berita' ");

					if ($query->num_rows() > 0) {
						$unique_string = rand();
						$slug = $praslug.'-'.$unique_string;
					}else{
						$slug = $praslug;
					}
					$deskripsi 			= htmlspecialchars($this->input->post('deskripsi', true));

					$this->berita_model->update_berita($id_berita, $nama_berita, $konten, $image, $slug, $deskripsi);
					$this->compress_tinify($image);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$id_author = $this->session->userdata('id');
					$this->log_model->save_log($id_author, 3, 'Update berita dengan judul '.$nama_berita);

					$text = $nama_berita.' Berhasil Disimpan.!';
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/berita');

				} else {
					redirect('admin/berita','refresh');
				}

			} else {
				$id_berita 			= $this->input->post('id_berita', TRUE);
				$nama_berita 		= strip_tags(htmlspecialchars($this->input->post('nama_berita', true), ENT_QUOTES));
				$konten 	= $this->input->post('konten');
				$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
				$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
				$trim 		= trim($string);
				$praslug 	= strtolower(str_replace(" ", "-", $trim));
				$query 		= $this->db->query("SELECT * FROM tb_berita WHERE slug_berita = '$praslug' AND id_berita != '$id_berita' ");

				if ($query->num_rows() > 0) {
					$unique_string = rand();
					$slug = $praslug.'-'.$unique_string;
				}else{
					$slug = $praslug;
				}

				$deskripsi 			= htmlspecialchars($this->input->post('deskripsi', true));

				$this->berita_model->update_berita_no_img($id_berita, $nama_berita, $konten, $slug, $deskripsi);

				// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$id_author = $this->session->userdata('id');
				$this->log_model->save_log($id_author, 3, 'Update berita dengan judul '.$nama_berita);

				$text = $nama_berita.' Berhasil Disimpan.!';
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/berita');
			}

		}
	}

	public function edit($id_berita)
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
		$data['bc_menu'] 			= "Berita";
		$data['bc_aktif'] 			= "Edit Berita";
		$data['title'] 				= "Edit Berita";

		$data['form_action'] 		= site_url('admin/berita/update');
		$data['data']				= $this->berita_model->get_berita_by_id($id_berita);

		$this->template->load('admin/template', 'admin/berita/edit_v', $data);
	}

	public function simpan()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_berita', 'Judul Berita', 'trim|required|min_length[5]');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->tambah();
		} else {

			$config['upload_path'] 		= './uploads/images/';
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['encrypt_name'] 	= TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				if ($this->upload->do_upload('filefoto')) {
					$img = $this->upload->data();

					$config['image_library'] 	= 'gd2';
					$config['source_image'] 	= './uploads/images/'.$img['file_name'];
					$config['create_thumb'] 	= false;
					$config['maintain_ratio'] 	= false;
					$config['quality'] 			= '100%';
					$config['width'] 			= 800;
					$config['height'] 			= 570;
					$config['new_image'] 		= './uploads/images/'.$img['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$image 				= $img['file_name'];
					$nama_berita 		= strip_tags(htmlspecialchars($this->input->post('nama_berita', true), ENT_QUOTES));
					$konten 	= $this->input->post('konten');
					$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
					$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
					$trim 		= trim($string);
					$praslug 	= strtolower(str_replace(" ", "-", $trim));
					$query 		= $this->db->get_where('tb_berita', array('slug_berita'=>$praslug));

					if ($query->num_rows() > 0) {
						$unique_string = rand();
						$slug = $praslug.'-'.$unique_string;
					}else{
						$slug = $praslug;
					}
					$deskripsi 			= htmlspecialchars($this->input->post('deskripsi', true));

					$this->berita_model->simpan_berita($nama_berita, $konten, $slug, $image, $deskripsi);
					$this->compress_tinify($image);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$id_author = $this->session->userdata('id');
					$this->log_model->save_log($id_author, 2, 'Menambah berita '.$nama_berita);

					$text = $nama_berita.' Berhasil Dipublish.!';
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/berita');

				} else {
					redirect('admin/berita','refresh');
				}

			} else {
				redirect('admin/berita','refresh');
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
		$data['bc_menu'] 			= "Berita";
		$data['bc_aktif'] 			= "Tambah Berita";
		$data['title'] 				= "Tambah Berita";

		$data['form_action'] 		= site_url('admin/berita/simpan');

		$this->template->load('admin/template', 'admin/berita/tambah_v', $data);
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
		$data['bc_aktif'] 			= "Berita";
		$data['title'] 				= "Berita";

		$data['data_berita'] 		= $this->berita_model->get_all_berita();

		$this->template->load('admin/template', 'admin/berita/data_v', $data);
	}

	public function compress_tinify($gambar_asli)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$sumber = './uploads/images/'.$gambar_asli;
		$menuju = './uploads/berita/'.$gambar_asli;

		$this->tiny_png->fileCompress($sumber, $menuju);
	}

}

/* End of file Berita.php */
/* Location: ./application/controllers/admin/Berita.php */

?>