<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Beranda_model', 'beranda_model');
		$this->load->model('admin/Homepage_model', 'homepage_model');
		$this->visitor_model->hitung_visitor();
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

		$data['background'] 		= $this->background_model->get_data()->row();

		$data['data_banner'] 		= $this->beranda_model->get_banner();
		$data['data_artikel'] 		= $this->beranda_model->get_artikel($site['limit_post']);
		$data['data_agenda'] 		= $this->beranda_model->get_agenda($site['limit_post']);
		$data['data_berita'] 		= $this->beranda_model->get_berita($site['limit_post']);
		$data['data_sambutan'] 		= $this->beranda_model->get_sambutan();
		$data['data_fasilitas'] 	= $this->beranda_model->get_fasilitas();
		$data['data_testimoni'] 	= $this->beranda_model->get_testimoni();
		$data['video_baru']			= $this->beranda_model->get_new_video();
		$data['video_populer']		= $this->beranda_model->get_populer_video();
		
		$data['data_homepage']		= $this->homepage_model->get_data();

		$this->template->load('website/template', 'website/beranda_v', $data);
	}
}
