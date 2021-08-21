<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Agenda_model', 'agenda_model');
		$this->load->library('upload');
		$this->load->helper('text');
	}

	public function hapus($id_agenda)
	{
		$data 				= $this->agenda_model->get_agenda_by_id($id_agenda)->row();		
		$images 			= "./uploads/images/".$data->gambar_agenda;
		$img_agenda 		= "./uploads/agenda/".$data->gambar_agenda;
		unlink($images);
		unlink($img_agenda);

		$text = $data->nama_agenda.' Berhasil dihapus dari agenda.!';
		$this->agenda_model->hapus_agenda($id_agenda);
		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, 'Menghapus agenda '.$data->nama_agenda);
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/agenda');
	}

	public function update($id_agenda)
	{
		// error_reporting(0);
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_agenda', 'Nama Agenda', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('tgl_pelaksanaan', 'Tanggal Pelaksanaan', 'trim|required');
		$this->form_validation->set_rules('durasi', 'Durasi', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->edit($id_agenda);
		} else {
			$id_agenda 			= $this->input->post('id_agenda', TRUE);
			$nama_agenda 		= strip_tags(htmlspecialchars($this->input->post('nama_agenda', true), ENT_QUOTES));
			$konten 	= $this->input->post('konten');
			$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
			$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
			$trim 		= trim($string);
			$praslug 	= strtolower(str_replace(" ", "-", $trim));
			$query 		= $this->db->query("SELECT * FROM tb_agenda WHERE slug_agenda = '$praslug' AND id_agenda != '$id_agenda' ");

			if ($query->num_rows() > 0) {
				$unique_string = rand();
				$slug = $praslug.'-'.$unique_string;
			}else{
				$slug = $praslug;
			}
			$tgl_pelaksanaan 	= $this->input->post('tgl_pelaksanaan', TRUE);
			$durasi 			= $this->input->post('durasi', TRUE);
			$deskripsi 			= htmlspecialchars($this->input->post('deskripsi', true));

			$config['upload_path'] 		= './uploads/images/';
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['encrypt_name'] 	= TRUE;

			$this->upload->initialize($config);

			if (!empty($_FILES['filefoto']['name'])) {
				$data 				= $this->agenda_model->get_agenda_by_id($id_agenda)->row();		
				$images 			= "./uploads/images/".$data->gambar_agenda;
				$img_agenda 		= "./uploads/agenda/".$data->gambar_agenda;
				unlink($images);
				unlink($img_agenda);

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

					$this->agenda_model->update_agenda($id_agenda, $nama_agenda, $konten, $image, $slug, $tgl_pelaksanaan, $durasi, $deskripsi);
					$this->compress_tinify($image);
					$foto_lama = "./uploads/images/".$image;
					unlink($foto_lama);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$id_author = $this->session->userdata('id');					
					$this->log_model->save_log($id_author, 3, 'Update agenda dengan nama '.$nama_agenda);

					$text = $nama_agenda.' Berhasil Disimpan.!';
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/agenda');

				} else {
					redirect('admin/agenda','refresh');
				}

			} else {
				
				$this->agenda_model->update_agenda_no_img($id_agenda, $nama_agenda, $konten, $slug, $tgl_pelaksanaan, $durasi, $deskripsi);

				// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
				$id_author = $this->session->userdata('id');
				$this->log_model->save_log($id_author, 3, 'Update agenda dengan nama '.$nama_agenda);

				$text = $nama_agenda.' Berhasil Disimpan.!';
				$this->session->set_flashdata('pnotify', $text);
				redirect('admin/agenda');
			}

		}
	}

	public function edit($id_agenda)
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
		$data['bc_menu'] 			= "Agenda";
		$data['bc_aktif'] 			= "Edit Agenda";
		$data['title'] 				= "Edit Agenda";

		$data['form_action'] 		= site_url('admin/agenda/update');
		$data['data']				= $this->agenda_model->get_agenda_by_id($id_agenda);

		$this->template->load('admin/template', 'admin/agenda/edit_v', $data);
	}

	public function simpan()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_agenda', 'Nama Agenda', 'trim|required|min_length[5]');
		$this->form_validation->set_rules('tgl_pelaksanaan', 'Tanggal Pelaksanaan', 'trim|required');
		$this->form_validation->set_rules('durasi', 'Durasi', 'trim|required');
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
					$nama_agenda 		= strip_tags(htmlspecialchars($this->input->post('nama_agenda', true), ENT_QUOTES));
					$konten 	= $this->input->post('konten');
					$preslug 	= strip_tags(htmlspecialchars($this->input->post('slug', true), ENT_QUOTES));
					$string   	= preg_replace('/[^a-zA-Z0-9 \&%|{.}=,?!*()"-_+$@;<>\']/', '', $preslug);
					$trim 		= trim($string);
					$praslug 	= strtolower(str_replace(" ", "-", $trim));
					$query 		= $this->db->get_where('tb_agenda', array('slug_agenda'=>$praslug));

					if ($query->num_rows() > 0) {
						$unique_string = rand();
						$slug = $praslug.'-'.$unique_string;
					}else{
						$slug = $praslug;
					}
					$tgl_pelaksanaan 	= $this->input->post('tgl_pelaksanaan', TRUE);
					$durasi 			= $this->input->post('durasi', TRUE);
					$deskripsi 			= htmlspecialchars($this->input->post('deskripsi', true));

					$this->agenda_model->simpan_agenda($nama_agenda, $konten, $slug, $image, $tgl_pelaksanaan, $durasi, $deskripsi);
					$this->compress_tinify($image);
					$foto_lama = "./uploads/images/".$image;
					unlink($foto_lama);

					// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
					$id_author = $this->session->userdata('id');
					$this->log_model->save_log($id_author, 2, 'Menambah agenda '.$nama_agenda);

					$text = $nama_agenda.' Berhasil Dipublish.!';
					$this->session->set_flashdata('pnotify', $text);
					redirect('admin/agenda');

				} else {
					redirect('admin/agenda','refresh');
				}

			} else {
				redirect('admin/agenda','refresh');
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
		$data['bc_menu'] 			= "Agenda";
		$data['bc_aktif'] 			= "Tambah Agenda";
		$data['title'] 				= "Tambah Agenda";

		$data['form_action'] 		= site_url('admin/agenda/simpan');

		$this->template->load('admin/template', 'admin/agenda/tambah_v', $data);
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
		$data['bc_aktif'] 			= "Agenda";
		$data['title'] 				= "Agenda";

		$data['data_agenda'] 		= $this->agenda_model->get_all_agenda();

		$this->template->load('admin/template', 'admin/agenda/data_v', $data);
	}

	public function compress_tinify($gambar_asli)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$sumber = './uploads/images/'.$gambar_asli;
		$menuju = './uploads/agenda/'.$gambar_asli;

		$this->tiny_png->fileCompress($sumber, $menuju);
	}

}

/* End of file Agenda.php */
/* Location: ./application/controllers/admin/Agenda.php */

?>