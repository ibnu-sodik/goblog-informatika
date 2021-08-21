<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Berita_model', 'berita_model');
		$this->load->model('Artikel_model', 'artikel_model');
		$this->load->model('Agenda_model', 'agenda_model');
		$this->visitor_model->hitung_visitor();
		$this->load->helper('text');
	}

	public function detail($slug)
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
		$data['site_email'] 		= $site['site_email'];
		$data['site_telp'] 			= $site['site_telp'];
		$data['site_nowa'] 			= $site['site_nowa'];
		$data['site_pesanTeks'] 	= $site['site_pesanTeks'];
		$data['tahun_buat'] 		= $site['tahun_buat'];
		$data['limit_post']			= $site['limit_post'];
		$data['bc_title']			= "Berita";
		$data['bc_link']			= site_url('berita');

		$data['artikel']			= $this->artikel_model->get_all_artikel($site['limit_post']);
		$data['agenda']				= $this->agenda_model->get_all_agenda($site['limit_post']);
		$data['berita']				= $this->berita_model->get_all_berita($site['limit_post']);

		$query = $this->berita_model->get_data_by_slug($slug);
		if ($query->num_rows() > 0) {
			$value = $query->row();

			$id_berita 			= $value->id_berita;
			$data['url'] 		= site_url('berita/'.$value->slug_berita);
			$data['canonical'] 	= site_url('berita/'.$value->slug_berita);
			$data['title'] 		= $value->nama_berita;
			$data['konten']		= $value->konten_berita;
			$data['slug']		= $value->slug_berita;
			$data['bc_aktif']	= $value->nama_berita;
			if (!empty($value->deskripsi_berita)) {
				$data['description'] = strip_tags(word_limiter($value->deskripsi_berita), 15);
			}else{
				$data['description'] = strip_tags(word_limiter($value->konten_berita), 15);
			}
			$data['gambar'] 		= base_url('uploads/berita/'.$value->gambar_berita);
			$data['post_date'] 		= $value->berita_postdate;
			$data['post_update'] 	= $value->berita_update;

			$this->template->load('website/template', 'website/berita/detail_v', $data);

		}else{
			redirect('berita','refresh');
		}
	}

	public function index()
	{		
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site 						= $this->site_model->get_site_data()->row_array();

		$jumlah 					= $this->berita_model->get_all_berita();
		$halaman 					= $this->uri->segment(3);
		if (!$halaman) {
			$mati = 0;
		}else{
			$mati = $halaman;
		}
		$limit 						= $site['limit_post'];
		$offset 					= $mati > 0 ? (($mati - 1) * $limit) : $mati;
		$config['base_url'] 		= base_url().'berita/halaman/';		
		$config['total_rows'] 		= $jumlah->num_rows();
		$config['per_page'] 		= $limit;
		$config['uri_segment'] 		= 3;
		$config['use_page_numbers']	= TRUE;

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

		$data['pagination']			= $this->pagination->create_links();
		$data['berita']				= $this->berita_model->get_data_perpage($offset, $limit);

		if (empty($this->uri->segment(3))) {
			$next_page = 2;
			$data['canonical'] 	= site_url('berita');
			$data['url'] 		= site_url('berita');
			$data['url_prev'] 	= "";
		}elseif ($this->uri->segment(3)=='1') {
			$next_page = 2;
			$data['canonical'] 	= site_url('berita');
			$data['url'] 		= site_url('berita');
			$data['url_prev'] 	= site_url('berita');
		}elseif ($this->uri->segment(3)=='2') {
			$next_page 			= $this->uri->segment(3)+1;
			$data['canonical'] 	= site_url('berita/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('berita/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('berita');
		}else{
			$next_page 			= $this->uri->segment(3)+1;
			$prev_page 			= $this->uri->segment(3)-1;
			$data['canonical'] 	= site_url('berita/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('berita/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('berita/halaman/'.$prev_page);
		}
		$data['url_next'] 		= site_url('berita/halaman/'.$next_page);

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
		$data['bc_title']			= "Berita";
		$data['bc_link']			= site_url('berita');

		$data['title']				= "Berita";
		$data['sm_text'] 			= "Sebenarnya disini ada text nya";

		$background 				= $this->background_model->get_data()->row_array();
		$data['bg_berita'] 			= base_url('uploads/background/'.$background['bg_berita']);

		$this->template->load('website/template', 'website/berita/data_v', $data);
	}

}

/* End of file Berita.php */
/* Location: ./application/controllers/Berita.php */

?>