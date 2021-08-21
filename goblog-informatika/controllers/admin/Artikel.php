<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Artikel_model', 'artikel_model');		
		$this->load->model('admin/Log_model', 'log_model');
		$this->load->library('upload');
		$this->load->helper('text');
	}

	public function edit($id_artikel)
	{
		$user_edit					= $this->artikel_model->get_artikel_by_id($id_artikel)->row_array();
		$id_user = $this->session->userdata('id');

		if ($user_edit['id_author'] != $id_user) {
			$text = 'Anda tidak punya akses ke halaman ini';
			$this->session->set_flashdata('pnotify_error', $text);
			redirect('admin/artikel');
		}

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
		$data['bc_menu'] 			= "Artikel";
		$data['bc_aktif'] 			= "Edit Artikel";
		$data['title'] 				= "Edit Artikel";

		$data['form_action']		= site_url('admin/artikel/update');
		$data['label'] 				= $this->artikel_model->get_label_artikel_by_user_id($this->session->userdata('id'));
		$data['kategori'] 			= $this->artikel_model->get_kategori_artikel_by_user_id($this->session->userdata('id'));
		$data['data']				= $this->artikel_model->get_artikel_by_id($id_artikel);

		$this->template->load('admin/template', 'admin/artikel/edit_v', $data);
		// $this->template->load('admin/template', 'admin/artikel/edit_v', $data);
	}

	public function hapus($id_artikel)
	{
		$id_user = $this->session->userdata('id');
		$data = $this->artikel_model->get_artikel_by_id($id_artikel)->row();
		if ($data->id_author != $id_user) {
			$text = 'Anda tidak punya akses ke halaman ini';
			$this->session->set_flashdata('pnotify_error', $text);
			redirect('admin/artikel');
		}
		$thumbs3 = "./uploads/artikel/".$data->gambar_artikel;
		unlink($thumbs3);

		$text = $data->judul_artikel.' Berhasil dihapus dari artikel.!';
		$this->artikel_model->hapus_artikel($id_artikel);
		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, 'Menghapus artikel '.$data->judul_artikel);
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/artikel');
	}

	public function update($id_artikel)
	{
		error_reporting(0);
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id_artikel);
		} else {

			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['encrypt_name'] = TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				$id_user = $this->session->userdata('id');
				$data = $this->artikel_model->get_artikel_by_id($id_artikel)->row();
				if ($data->id_author != $id_user) {
					$text = 'Anda tidak punya akses ke halaman ini';
					$this->session->set_flashdata('pnotify_error', $text);
					redirect('admin/artikel');
				}
				$thumbs3 = "./uploads/artikel/".$data->gambar_artikel;
				unlink($thumbs3);

				if ($this->upload->do_upload('filefoto')) {
					$img = $this->upload->data();

					$config['image_library'] = 'gd2';
					$config['source_image'] = './uploads/images/'.$img['file_name'];
					$config['create_thumb'] = false;
					$config['maintain_ratio'] = false;
					$config['quality'] = '100%';
					$config['width'] = 800;
					$config['height'] = 460;
					$config['new_image'] = './uploads/images/'.$img['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();


					$id_artikel = $this->input->post('id_artikel', TRUE);
					$image 		= $img['file_name'];
					$judul 		= strip_tags(htmlspecialchars($this->input->post('judul', true), ENT_QUOTES));
					$konten 	= $this->input->post('konten');
					$kategori 	= $this->input->post('kategori', true);
					$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
					$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
					$trim 		= trim($string);
					$praslug 	= strtolower(str_replace(" ", "-", $trim));
					// $query 		= $this->db->get_where('tb_artikel', array('slug_artikel'=>$praslug));
					$query 		= $this->db->query("SELECT * FROM tb_artikel WHERE slug_artikel = '$praslug' AND id_artikel != '$id_artikel' ");

					if ($query->num_rows() > 0) {
						$unique_string = rand();
						$slug = $praslug.'-'.$unique_string;
					}else{
						$slug = $praslug;
					}

					$xlabels[] = $this->input->post('label');
					foreach ($xlabels as $label) {
						$labels = @implode(",", $label);
					}

					$deskripsi = htmlspecialchars($this->input->post('deskripsi', true));

					$this->artikel_model->update_artikel($id_artikel, $judul, $konten, $kategori, $slug, $image, $labels, $deskripsi);
					$this->compress_tinify($image);
					$foto_lama = "./uploads/images/".$image;
					unlink($foto_lama);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$id_author = $this->session->userdata('id');
					$this->log_model->save_log($id_author, 2, 'Menambah artikel dengan judul '.$judul);

					// $this->send_email();

					$text = $judul.' Berhasil Disimpan.!';
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/artikel');

				} else {
					redirect('admin/artikel');
				}
				// jika foto tidak diganti
			} else {

				$id_artikel = $this->input->post('id_artikel', TRUE);
				$judul 		= strip_tags(htmlspecialchars($this->input->post('judul', true), ENT_QUOTES));
				$konten 	= $this->input->post('konten');
				$kategori 	= $this->input->post('kategori', true);
				$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
				$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
				$trim 		= trim($string);
				$praslug 	= strtolower(str_replace(" ", "-", $trim));
				$query 		= $this->db->query("SELECT * FROM tb_artikel WHERE slug_artikel = '$praslug' AND id_artikel != '$id_artikel' ");

					echo $query->num_rows();


				if ($query->num_rows() > 0) {
					$unique_string = rand();
					$slug = $praslug.'-'.$unique_string;
				}else{
					$slug = $praslug;
				}

				$xlabels[] = $this->input->post('label');
				foreach ($xlabels as $label) {
					$labels = @implode(",", $label);
				}

				$deskripsi = htmlspecialchars($this->input->post('deskripsi', true));;

				$this->artikel_model->update_artikel2($id_artikel, $judul, $konten, $kategori, $slug, $labels, $deskripsi);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$id_author = $this->session->userdata('id');
				$this->log_model->save_log($id_author, 3, 'Update artikel dengan judul '.$judul);

				$text = $judul.' Berhasil Disimpan.!';
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/artikel');
			}

		}
	}

	public function simpan()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->tambah();
		} else {

			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$config['encrypt_name'] = TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				if ($this->upload->do_upload('filefoto')) {
					$img = $this->upload->data();

					$config['image_library'] = 'gd2';
					$config['source_image'] = './uploads/images/'.$img['file_name'];
					$config['create_thumb'] = false;
					$config['maintain_ratio'] = false;
					$config['quality'] = '100%';
					$config['width'] = 800;
					$config['height'] = 460;
					$config['new_image'] = './uploads/images/'.$img['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();

					$image 		= $img['file_name'];
					$judul 		= strip_tags(htmlspecialchars($this->input->post('judul', true), ENT_QUOTES));
					$konten 	= $this->input->post('konten');
					$kategori 	= $this->input->post('kategori', true);
					$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
					$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
					$trim 		= trim($string);
					$praslug 	= strtolower(str_replace(" ", "-", $trim));
					$query 		= $this->db->get_where('tb_artikel', array('slug_artikel'=>$praslug));

					if ($query->num_rows() > 0) {
						$unique_string = rand();
						$slug = $praslug.'-'.$unique_string;
					}else{
						$slug = $praslug;
					}

					$xlabels[] = $this->input->post('label');
					foreach ($xlabels as $label) {
						$labels = @implode(",", $label);
					}

					$deskripsi = htmlspecialchars($this->input->post('deskripsi', true));;

					$this->artikel_model->simpan_artikel($judul, $konten, $kategori, $slug, $image, $labels, $deskripsi);
					$this->compress_tinify($image);
					$foto_lama2 = "./uploads/images/".$image;
					unlink($foto_lama2);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$id_author = $this->session->userdata('id');
					$this->log_model->save_log($id_author, 2, 'Menambah artikel dengan judul '.$judul);

					// $this->send_email();

					$text = $judul.' Berhasil Dipublish.!';
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/artikel');

				} else{
					redirect('admin/artikel');
				}
			} else {
				redirect('admin/artikel');
			}

		}

	}

	public function tambah()
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
		$data['bc_menu'] 			= "Artikel";
		$data['bc_aktif'] 			= "Tambah Artikel";
		$data['title'] 				= "Tambah Artikel";

		$data['form_action']		= site_url('admin/artikel/simpan');
		$data['label'] 				= $this->artikel_model->get_label_artikel_by_user_id($this->session->userdata('id'));
		$data['kategori'] 			= $this->artikel_model->get_kategori_artikel_by_user_id($this->session->userdata('id'));

		$this->template->load('admin/template', 'admin/artikel/tambah_v', $data);
	}

	public function hapus_label($id_label)
	{
		$label_lama		= $this->artikel_model->get_label_artikel_by_id($id_label)->row_array();
		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, 'Menghapus label '.$label_lama['nama_label']);

		$this->artikel_model->hapus_label($id_label);
		$text = 'Label Berhasil Dihapus.!';
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/artikel/label');
	}

	public function update_label()
	{
		$id 		= $this->input->post('id_label',TRUE);
		$label 		= strip_tags(htmlspecialchars($this->input->post('label2',TRUE),ENT_QUOTES));
		$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $label);
		$trim     	= trim($string);
		$slug     	= strtolower(str_replace(" ", "-", $trim));
		$this->artikel_model->_update_label($id, $label, $slug);

		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 3, 'Merubah label menjadi '.$label);
		$text = $label. ' Berhasil Diubah.!';
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/artikel/label');
	}

	public function simpan_label()
	{
		$user_id 	= $this->input->post('user_id', TRUE);
		$label 	= strip_tags(htmlspecialchars($this->input->post('label',TRUE),ENT_QUOTES));
		$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $label);
		$trim     	= trim($string);
		$slug     	= strtolower(str_replace(" ", "-", $trim));
		$this->artikel_model->_simpan_label($label, $slug, $user_id);

		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 2, 'Menambah label '.$label);
		$text = 'Berhasil Menambah Label '.$label;
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/artikel/label');
	}

	public function label()
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
		$data['bc_menu'] 			= "Artikel";
		$data['bc_aktif'] 			= "Label Artikel";
		$data['title'] 				= "Label Artikel";

		$data['data_label']		= $this->artikel_model->get_label_artikel_by_user_id($this->session->userdata('id'));

		$this->template->load('admin/template', 'admin/artikel/label_v', $data);
	}

	public function hapus_kategori($id_kategori)
	{
		$kategori_lama		= $this->artikel_model->get_kategori_artikel_by_id($id_kategori)->row_array();
		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, 'Menghapus kategori '.$kategori_lama['nama_kategori']);

		$this->artikel_model->hapus_kategori($id_kategori);
		$text = 'Kategori Berhasil Dihapus.!';
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/artikel/kategori');
	}

	public function update_kategori()
	{
		$id = $this->input->post('id_kategori',TRUE);
		$kategori = strip_tags(htmlspecialchars($this->input->post('kategori2',TRUE),ENT_QUOTES));
		$string   = preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $kategori);
		$trim     = trim($string);
		$slug     = strtolower(str_replace(" ", "-", $trim));
		$this->artikel_model->_update_kategori($id, $kategori, $slug);

		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 3, 'Merubah kategori menjadi '.$kategori);
		$text = $kategori. ' Berhasil Diubah.!';
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/artikel/kategori');
	}

	public function simpan_kategori()
	{
		$user_id 	= $this->input->post('user_id', TRUE);
		$kategori 	= strip_tags(htmlspecialchars($this->input->post('kategori',TRUE),ENT_QUOTES));
		$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $kategori);
		$trim     	= trim($string);
		$slug     	= strtolower(str_replace(" ", "-", $trim));
		$this->artikel_model->_simpan_kategori($kategori, $slug, $user_id);

		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 2, 'Menambah kategori '.$kategori);
		$text = 'Berhasil Menambah Kategori '.$kategori;
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/artikel/kategori');
	}

	public function kategori()
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
		$data['bc_menu'] 			= "Artikel";
		$data['bc_aktif'] 			= "Kategori Artikel";
		$data['title'] 				= "Kategori Artikel";

		$data['data_kategori']		= $this->artikel_model->get_kategori_artikel_by_user_id($this->session->userdata('id'));

		$this->template->load('admin/template', 'admin/artikel/kategori_v', $data);
	}

	public function get_data()
	{
		sleep(2);
		$site 		= $this->site_model->get_site_data()->row_array();
		$kategori 	= $this->input->post('kategori');
		$id_user 	= $this->session->userdata('id');
		$jumlah 	= $this->artikel_model->hitung_data($id_user, $kategori);
		$limit 		= $site['limit_post'];

		$config = array();
		$config['base_url']			= '#';
		$config['total_rows']		= $jumlah;
		$config['per_page']			= $site['limit_post'];
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
		// echo $page;die();

		$hasil = array(
			'pagination_link'	=> $this->pagination->create_links(),
			'daftar_artikel' 	=> $this->artikel_model->gabungkan_data($id_user, $offset, $limit, $kategori)
		);

		echo json_encode($hasil);
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
		$data['bc_aktif'] 			= "Artikel";
		$data['title'] 				= "Artikel";


		$id_user = $this->session->userdata('id');
		$data['fil_kategori'] 		= $this->artikel_model->get_kategori_artikel_by_user_id($id_user);

		$this->template->load('admin/template', 'admin/artikel/data_v', $data);
	}

	public function resize_tinify($image, $folder, $mode = 'thumb', $lebar, $tinggi)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$path 		= './uploads/images/'.$image;
		$new_path 	= './uploads/thumbs/'.$folder.'/'.$image;
		$method 	= $mode;
		$width 		= $lebar;
		$height 	= $tinggi;

		// $method (string) method of resize image: 'scale', 'fit', 'cover', 'thumb' 
		$this->tiny_png->fileResize($path, $new_path, $method, $width, $height);
	}

	public function compress_tinify($gambar_asli)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$sumber = './uploads/images/'.$gambar_asli;
		$menuju = './uploads/artikel/'.$gambar_asli;

		$this->tiny_png->fileCompress($sumber, $menuju);
	}

	function upload_image()
	{
		if (isset($_FILES['file']['name'])) {
			$config['upload_path'] = './uploads/images/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('file')) {
				$this->upload->display_errors();
				return FALSE;
			}else{
				$data = $this->upload->data();
		            //Compress Image
				$config['image_library']='gd2';
				$config['source_image']='./uploads/images/'.$data['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= TRUE;
				$config['quality']= '60%';
				$config['width']= 800;
				$config['height']= 800;
				$config['new_image']= './uploads/images/'.$data['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				echo base_url().'uploads/images/'.$data['file_name'];
			}
		}
	}

	function _create_thumbs($file_name)
	{
		$config = array(
			array(
				'image_library' => 'GD2',
				'source_image' => './uploads/images/'.$file_name,
				'maintain_ratio' => false,
				'width' => 600,
				'height' => 500,
				'new_image' => './uploads/thumbs/600x500/'.$file_name
			)
		);

		$this->load->library('image_lib', $config[0]);
		foreach ($config as $item) {
			$this->image_lib->initialize($item);
			if (!$this->image_lib->resize()) {
				return false;
			}
			$this->image_lib->clear();
		}
	}

	function _create_thumbs_2($file_name)
	{
		$config = array(
			array(
				'image_library' => 'GD2',
				'source_image' => './uploads/images/'.$file_name,
				'maintain_ratio' => false,
				'width' => 394,
				'height' => 449,
				'new_image' => './uploads/thumbs/394x449/'.$file_name
			)
		);

		$this->load->library('image_lib', $config[0]);
		foreach ($config as $item) {
			$this->image_lib->initialize($item);
			if (!$this->image_lib->resize()) {
				return false;
			}
			$this->image_lib->clear();
		}
	}

	function _thumb_artikel($file_name)
	{
		$config = array(
			array(
				'image_library' => 'GD2',
				'source_image' => './uploads/images/'.$file_name,
				'maintain_ratio' => false,
				'width' => 800,
				'height' => 460,
				'new_image' => './uploads/artikel/'.$file_name
			)
		);

		$this->load->library('image_lib', $config[0]);
		foreach ($config as $item) {
			$this->image_lib->initialize($item);
			if (!$this->image_lib->resize()) {
				return false;
			}
			$this->image_lib->clear();
		}
	}

}

/* End of file Artikel.php */
/* Location: ./application/controllers/admin/Artikel.php */
?>