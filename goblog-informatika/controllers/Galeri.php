<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Galeri_model', 'galeri_model');
		$this->visitor_model->hitung_visitor();
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
		$config['uri_segment']		= 3;
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
		$page 		= $this->uri->segment('3');
		$offset 	= ($page - 1) * $config['per_page'];

		$hasil = array(
			'pagination_link'	=> $this->pagination->create_links(),
			'daftar_galeri' 	=> $this->galeri_model->gabung_data($offset, $limit, $album)
		);

		echo json_encode($hasil);
	}

	public function index()
	{
		$site 						= $this->site_model->get_site_data()->row_array();
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
		$data['bc_title']			= "Galeri";
		$data['bc_link']			= site_url('galeri');
		$data['url']				= site_url('galeri');
		$data['canonical']			= site_url('galeri');

		$data['title']				= "Galeri";
		$data['sm_text'] 			= "Sebenarnya disini ada text nya";

		$data['fil_album']			= $this->galeri_model->get_album();
		
		$background 				= $this->background_model->get_data()->row_array();
		$data['bg_galeri'] 			= base_url('uploads/background/'.$background['bg_galeri']);

		$this->template->load('website/template', 'website/galeri/data_v', $data);
	}

}

/* End of file Galeri.php */
/* Location: ./application/controllers/Galeri.php */

?>