<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Galeri_model', 'galeri_model');
		$this->load->library('upload');
		$this->load->helper('text');
		if ($this->session->userdata('access')!=1) {
			$text = 'Terdapat batasan hak akses pada halaman ini.';
			$this->session->set_flashdata('pesan_error', $text);
			redirect('admin', 'refresh');
		}
	}

	public function hapus_album($id_album)
	{
		$query_a 	= $this->galeri_model->get_album_by_id($id_album);
		$data_a 	= $query_a->row_array();

		$query_g 	= $this->galeri_model->get_galeri_by_album($id_album);
		$data_g		= $query_g->row_array();
		$jumlah 	= $query_g->num_rows();
		if ($jumlah > 0) {
			// maka akan hapus album beserta fotonya
		} else {
			// hapus album nya saja
			$this->galeri_model->hapus_album($id_album);
			// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
			$this->log_model->save_log($this->session->userdata('id'), 4, 'Menghapus album '.$data_a['nama_album']);

			$text = $data_a['nama_album'].' Berhasil Dihapus.!';
			$this->session->set_flashdata('pnotify', $text);
			redirect('admin/galeri/album');
		}
	}

	public function update_album()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('album2', 'Nama Album', 'trim|required|min_length[3]|is_unique[tb_album.nama_album]');
		$this->form_validation->set_error_delimiters('<p class="text-default">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->album();
		} else {
			$id_album 	= $this->input->post('id_album',TRUE);
			$album 		= strip_tags(htmlspecialchars($this->input->post('album2',TRUE),ENT_QUOTES));
			$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $album);
			$trim     	= trim($string);
			$slug     	= strtolower(str_replace(" ", "-", $trim));

			$data_album = $this->galeri_model->get_album_by_id($id_album)->row_array();
			$this->galeri_model->_update_album($id_album, $album, $slug);

			// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
			$this->log_model->save_log($this->session->userdata('id'), 3, 'Merubah album '.$data_album['nama_album'].' menjadi '.$album);
			$text = $album. ' Berhasil Diubah.!';
			$this->session->set_flashdata('pnotify', $text);
			redirect('admin/galeri/album');
		}
	}

	public function simpan_album()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('album', 'Nama Album', 'trim|required|min_length[3]|is_unique[tb_album.nama_album]');
		$this->form_validation->set_error_delimiters('<p class="text-default">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->album();
		} else {
			$album 		= strip_tags(htmlspecialchars($this->input->post('album',TRUE),ENT_QUOTES));
			$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $album);
			$trim     	= trim($string);
			$slug     	= strtolower(str_replace(" ", "-", $trim));
			$this->galeri_model->_simpan_album($album, $slug);

			// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
			$this->log_model->save_log($this->session->userdata('id'), 2, 'Menambah album '.$album);
			$text = 'Berhasil Menambah Album '.$album;
			$this->session->set_flashdata('pnotify', $text);
			redirect('admin/galeri/album');
		}
	}

	public function album()
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
		$data['bc_aktif'] 			= "Album";
		$data['title'] 				= "Album";

		$data['data_album']			= $this->galeri_model->get_album();
		$data['form_add_action'] 	= site_url('admin/galeri/simpan-album');
		$data['form_edit_action'] 	= site_url('admin/galeri/update-album');

		$this->template->load('admin/template', 'admin/galeri/album_v', $data);
	}

	public function hapus($id_galeri)
	{
		$data 		= $this->galeri_model->get_galeri_by_id($id_galeri)->row();
		$image 		= $data->foto_galeri;
		$data_album = $this->galeri_model->get_album_by_id($data->id_album_galeri)->row_array();
		$slug_album = $data_album['slug_album'];

		$galeri_lama = "./uploads/galeri/".$slug_album."/".$image;
		unlink($galeri_lama);

		$this->galeri_model->hapus($id_galeri);

		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, 'Menghapus gambar '.$image.' pada galeri album '.$slug_album);

		$text = $data->nama_galeri.' Berhasil dihapus.!';
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/galeri');
	}

	public function update($id_galeri)
	{
		
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('id_album', 'Album', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-default">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id_galeri);
		}else{

			if (!empty($_FILES['filefoto']['name'])) {

				$data 		= $this->galeri_model->get_galeri_by_id($id_galeri)->row();
				$data_album = $this->galeri_model->get_album_by_id($data->id_album_galeri)->row_array();
				$slug_album = $data_album['slug_album'];

				$galeri_lama = "./uploads/galeri/".$slug_album."/".$data->foto_galeri;
				unlink($galeri_lama);

				$id_album 	= $this->input->post('id_album', TRUE);
				$q_alBaru 	= $this->galeri_model->get_album_by_id($id_album)->row_array();
				$new_album 	= $q_alBaru['slug_album'];

				$path = './uploads/galeri/'.$dnew_album;
				if (!file_exists($path)) {
					mkdir($path);
				}

				$config['upload_path'] 		= './uploads/galeri/';
				$config['allowed_types'] 	= 'jpg|png|jpeg';
				$config['encrypt_name'] 	= TRUE;

				$this->upload->initialize($config);

				if ($this->upload->do_upload('filefoto')) {
					$img 			= $this->upload->data();
					$image 			= $img['file_name'];
					$nama_galeri 	= $this->input->post('nama_galeri', TRUE);

					$this->compress_tinify($new_album, $image);

					$this->galeri_model->update($id_galeri, $id_album, $nama_galeri, $image);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$this->log_model->save_log($this->session->userdata('id'), 3, 'Merubah gambar '.$image.' pada galeri album '.$new_album);

					$foto_lama = './uploads/galeri/'.$image;
					unlink($foto_lama);

					$text = "Galeri Berhasil Disimpan.";
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/galeri');
				} else {
					$text = 'Gagal mengupload gambar';
					$this->session->set_flashdata('pesan_error', $text);
					redirect('admin/galeri','refresh');
				}
			} else {
				$nama_galeri 	= $this->input->post('nama_galeri', TRUE);
				$id_album 		= $this->input->post('id_album', TRUE);

				$data 		= $this->galeri_model->get_galeri_by_id($id_galeri)->row();
				$data_album = $this->galeri_model->get_album_by_id($data->id_album_galeri)->row_array();
				$slug_album = $data_album['slug_album'];

				// ambil file lama
				$oldname = "./uploads/galeri/".$slug_album."/".$data->foto_galeri;

				// direktori baru
				$q_alBaru 	= $this->galeri_model->get_album_by_id($id_album)->row_array();
				$new_album 	= $q_alBaru['slug_album'];
				$newname = "./uploads/galeri/".$new_album."/".$data->foto_galeri;
				// pindah
				rename($oldname, $newname);

				$this->galeri_model->update_no_img($id_galeri, $id_album, $nama_galeri);
				// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$this->log_model->save_log($this->session->userdata('id'), 3, 'Merubah galeri '.$nama_galeri.' tanpa gambar');

				$text = "Galeri Berhasil Disimpan.";
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/galeri','refresh');
			}
		}
	}

	public function edit($id_galeri)
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
		$data['bc_menu'] 			= "Galeri";
		$data['bc_aktif'] 			= "Edit Galeri";
		$data['title'] 				= "Edit Galeri";

		$data['fil_album']			= $this->galeri_model->get_album();
		$data['data_galeri']		= $this->galeri_model->get_galeri_by_id($id_galeri);
		$data['form_action_edit'] 	= site_url('admin/galeri/update');

		$this->template->load('admin/template', 'admin/galeri/edit_v', $data);
	}

	public function simpan()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('id_album', 'Album', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-default">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {

			$id_album = $this->input->post('id_album', TRUE);
			$data_album = $this->galeri_model->get_album_by_id($id_album)->row_array();
			$slug_album = $data_album['slug_album'];

			$path = './uploads/galeri/'.$slug_album;
			if (!file_exists($path)) {
				mkdir($path);
			}

			$config['upload_path'] 		= './uploads/galeri/';
			$config['allowed_types'] 	= 'jpg|png|jpeg';
			$config['encrypt_name'] 	= TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				if ($this->upload->do_upload('filefoto')) {
					$img 			= $this->upload->data();
					$image 			= $img['file_name'];
					$nama_galeri 	= $this->input->post('nama_galeri', TRUE);

					$this->compress_tinify($slug_album, $image);

					$this->galeri_model->simpan($id_album, $nama_galeri, $image);
					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$this->log_model->save_log($this->session->userdata('id'), 2, 'Menambah gambar '.$image.' pada galeri album '.$slug_album);

					$foto_lama = './uploads/galeri/'.$image;
					unlink($foto_lama);
					
					$text = "Galeri Berhasil Disimpan.";
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/galeri');
				} else {
					$text = 'Gagal mengupload gambar';
					$this->session->set_flashdata('pesan_error', $text);
					redirect('admin/galeri','refresh');
				}
			} else {
				$text = 'Gambar Harus diisi';
				$this->session->set_flashdata('pesan_error', $text);
				redirect('admin/galeri','refresh');
			}

		}
	}

	public function get_data()
	{
		sleep(1);
		$site 		= $this->site_model->get_site_data()->row_array();
		$album 		= $this->input->post('album');
		$jumlah 	= $this->galeri_model->hitung_data($album);
		$limit 		= $site['limit_gambar'];

		$config = array();
		$config['base_url']			= '#';
		$config['total_rows']		= $jumlah;
		$config['per_page']			= $site['limit_gambar'];
		$config['uri_segment']		= 4;
		$config['use_page_numbers'] = TRUE;

		$config["full_tag_open"] 	= '<ul class="pagination">';
		$config["full_tag_close"]	= '</ul>';
		$config["first_tag_open"] 	= '<li>';
		$config["first_tag_close"] 	= '</li>';
		$config["last_tag_open"] 	= '<li>';
		$config["last_tag_close"] 	= '</li>';
		$config['next_link'] 		= '&gt;';
		$config["next_tag_open"] 	= '<li>';
		$config["next_tag_close"] 	= '</li>';
		$config["prev_link"] 		= "&lt;";
		$config["prev_tag_open"] 	= "<li>";
		$config["prev_tag_close"] 	= "</li>";
		$config["cur_tag_open"] 	= "<li class='active'><a href='#'>";
		$config["cur_tag_close"] 	= "</a></li>";
		$config["num_tag_open"] 	= "<li>";
		$config["num_tag_close"] 	= "</li>";

		$config['prev_link'] 		= 'Sebelumnya';
		$config['next_link'] 		= 'Selanjutnya';
		$config['last_link'] 		= 'Terakhir';
		$config['first_link'] 		= 'Pertama';

		$this->pagination->initialize($config);
		$page 		= $this->uri->segment('4');
		$offset 	= ($page - 1) * $config['per_page'];

		$hasil = array(
			'pagination_link'	=> $this->pagination->create_links(),
			'daftar_galeri' 	=> $this->galeri_model->gabungkan_data($offset, $limit, $album)
		);

		echo json_encode($hasil);
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
		$data['bc_aktif'] 			= "Galeri";
		$data['title'] 				= "Galeri";

		$data['fil_album']			= $this->galeri_model->get_album();
		$data['form_action_add'] 	= site_url('admin/galeri/simpan');

		$this->template->load('admin/template', 'admin/galeri/galeri_v', $data);
	}

	public function compress_tinify($slug_album, $gambar_asli)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$sumber = './uploads/galeri/'.$gambar_asli;
		$menuju = './uploads/galeri/'.$slug_album.'/'.$gambar_asli;

		$this->tiny_png->fileCompress($sumber, $menuju);
	}

}

/* End of file Galeri.php */
/* Location: ./application/controllers/admin/Galeri.php */

?>