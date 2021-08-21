<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Testimoni_model', 'testimoni_model');
		$this->load->library('upload');
		$this->load->helper('text');
		$this->visitor_model->hitung_visitor();
	}

	public function simpan()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_testimoni', 'Nama', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('konten_testimoni', 'Ulasan', 'trim|required|max_length[200]');
		$this->form_validation->set_rules('profesi_testimoni', 'Profesi', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			$nama_testimoni 		= sanitize($this->input->post('nama_testimoni', TRUE));
			$konten_testimoni 		= $this->input->post('konten_testimoni');
			$profesi_testimoni		= sanitize($this->input->post('profesi_testimoni', TRUE));

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

				$this->testimoni_model->simpan($image, $nama_testimoni, $konten_testimoni, $profesi_testimoni);

				$text = "Terimakasih telah mengisi testimoni.";
				$this->session->set_flashdata('pesan_sukses', $text);
				redirect(site_url('testimoni'));

			} else {
				$text = "Upload foto gagal.";
				$this->session->set_flashdata('pesan_error', $text);
				redirect(site_url('testimoni'));
			}

		}
	}

	public function index()
	{
		$link 						= $this->uri->segment(1);
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site 						= $this->site_model->get_site_data()->row_array();
		$data['url'] 				= site_url($link);
		$data['canonical'] 			= site_url($link);
		$data['site_title'] 		= $site['site_title'];
		$data['site_name'] 			= $site['site_name'];
		$data['site_keywords'] 		= $site['site_keywords'];
		$data['site_author'] 		= $site['site_author'];
		$data['site_logo'] 			= $site['site_logo'];
		$data['site_description'] 	= $site['site_description'];
		$data['site_favicon'] 		= $site['site_favicon'];
		$data['site_email'] 		= $site['site_email'];
		$data['site_telp'] 			= $site['site_telp'];
		$data['site_nowa'] 			= $site['site_nowa'];
		$data['site_pesanTeks'] 	= $site['site_pesanTeks'];
		$data['tahun_buat'] 		= $site['tahun_buat'];
		$data['limit_post']			= $site['limit_post'];
		$data['title']				= "Testimoni";
		$data['sm_text']			= "Penilaian anda menjadi bahan ajar auntuk kami.";

		$background 				= $this->background_model->get_data()->row_array();
		$data['bg_testimoni'] 		= base_url('uploads/background/'.$background['bg_testimoni']);
		$data['bg_umum'] 			= base_url('uploads/background/'.$background['bg_umum']);

		$data['data_testimoni'] 	= $this->testimoni_model->get_data($site['limit_post']);
		$data['form_action']		= site_url('testimoni/simpan');

		$this->template->load('website/template', 'website/testimoni/tambah_v', $data);
	}

	public function resize_tinify($image)
	{
		$site = $this->site_model->get_site_data()->row_array();
		$this->load->library('tiny_png', array('api_key' => $site['api_tinify']));

		$path 		= './uploads/images/'.$image;
		$new_path 	= './uploads/testimoni/thumbs/'.$image;
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
		$menuju = './uploads/testimoni/'.$gambar_asli;

		$this->tiny_png->fileCompress($sumber, $menuju);
	}

}

/* End of file Testimoni.php */
/* Location: ./application/controllers/Testimoni.php */

 ?>