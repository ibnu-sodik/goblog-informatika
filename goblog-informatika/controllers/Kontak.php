<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kontak_model', 'kontak_model');
		$this->visitor_model->hitung_visitor();
	}

	public function kirim()
	{
		
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('fname', 'Nama Depan', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('lname', 'Nama Belakang', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('email', 'Alamat Email', 'trim|required');
		$this->form_validation->set_rules('subject', 'Subjek Pesan', 'trim|required');
		$this->form_validation->set_rules('message', 'Isi Pesan', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run() === FALSE) {
			$this->index();
		} else {
			$fname 		= $this->input->post('fname', TRUE);
			$lname 		= $this->input->post('lname', TRUE);
			$email 		= $this->input->post('email', TRUE);
			$subject 	= $this->input->post('subject', TRUE);
			$message 	= $this->input->post('message', TRUE);

			$this->kontak_model->kirim_pesan($fname, $lname, $email, $subject, $message);
			$text = "Pesan terkirim.";
			$this->session->set_flashdata('pesan_sukses', $text);
			redirect(site_url('kontak'),'refresh');

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
		$data['title'] 				= "Kontak";
		$data['sm_text']			= "Pelayanan kami sederhana namun level dunia.";

		$data['data_konten'] 		= $this->kontak_model->get_kontak_data();
		$data['form_action']		= site_url('kontak/kirim');

		$this->template->load('website/template', 'website/kontak_v', $data);
	}

}

/* End of file Kontak.php */
/* Location: ./application/controllers/Kontak.php */

?>