<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Halaman_404 extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->visitor_model->hitung_visitor();
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
		$data['bc_aktif'] 			= "Eror 404";
		$data['title'] 				= "Eror 404";
		$data['url'] 				= site_url('error-404');
		$data['canonical']			= site_url('error-404');

		$this->load->view('errors/404.php', $data, FALSE);
	}

}

/* End of file Halaman_404.php */
/* Location: ./application/controllers/Halaman_404.php */

 ?>