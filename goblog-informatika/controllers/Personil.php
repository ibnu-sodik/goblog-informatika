<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Personil extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Personil_model', 'personil_model');
		$this->load->model('Artikel_model', 'artikel_model');
		$this->visitor_model->hitung_visitor();
	}

	public function detail($username)
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
		$data['bc_title']			= "Personil";
		$data['bc_link']			= site_url('personil');

		$query = $this->personil_model->get_data_by_username($username);
		if ($query->num_rows() > 0) {
			$datap = $query->row();

			$data['full_name'] 	= $datap->full_name;
			$data['email'] 		= $datap->email;
			$data['username'] 	= $datap->username;
			$data['jenis_fungsi'] 	= $datap->jenis_fungsi;
			$data['personil_info'] 	= $datap->personil_info;
			$data['foto'] 			= $datap->foto;
			$data['bc_aktif']		= $datap->full_name;

			$data['url']			= site_url('personil/'.$username);
			$data['canonical']		= site_url('personil/'.$username);

			$datar 			= $this->db->get_where('tb_artikel', array('id_author' => $datap->id, 'publish_artikel' => 1));
			$jumlah 		= $datar->num_rows();
			$data['jumlah'] = $jumlah;
			
			$page = $this->uri->segment(3);
			if (!$page) {
				$mati = 0;
			}else{
				$mati = $page;
			}
			$limit 					= $site['limit_post'];
			$offset 				= $mati > 0 ? (($mati - 1) * $limit) : $mati;
			$config['base_url'] 	= site_url('personil/'.$datap->username.'/');
			$config['total_rows'] 	= $jumlah;
			$config['per_page'] 	= $limit;
			$config['uri_segment'] 	= 3;
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

			$data['pagination']			= $this->pagination->create_links();
			$data['artikel_personil']	= $this->personil_model->get_artikel_by_personil($limit, $offset, $datap->id);

			$data['sosmed_personil']	= $this->personil_model->get_sosmed_by_id($datap->id);

			$data['artikel_populer'] 	= $this->artikel_model->get_artikel_populer($site['limit_post']);
			$data['artikel_review'] 	= $this->artikel_model->get_artikel_review($site['limit_post']);

			$this->template->load('website/template', 'website/personil/detail_v', $data);

		}else{
			redirect('personil','refresh');
		}
	}

	public function index()
	{
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site 						= $this->site_model->get_site_data()->row_array();

		$jumlah 					= $this->personil_model->get_personil();
		$halaman 					= $this->uri->segment(3);
		if (!$halaman) {
			$mati = 0;
		}else{
			$mati = $halaman;
		}
		$limit 						= $site['limit_post'];
		$offset 					= $mati > 0 ? (($mati - 1) * $limit) : $mati;
		$config['base_url'] 		= base_url().'personil/halaman/';		
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
		$data['personil']			= $this->personil_model->get_data_perpage($offset, $limit);

		if (empty($this->uri->segment(3))) {
			$next_page = 2;
			$data['canonical'] 	= site_url('personil');
			$data['url'] 		= site_url('personil');
			$data['url_prev'] 	= "";
		}elseif ($this->uri->segment(3)=='1') {
			$next_page = 2;
			$data['canonical'] 	= site_url('personil');
			$data['url'] 		= site_url('personil');
			$data['url_prev'] 	= site_url('personil');
		}elseif ($this->uri->segment(3)=='2') {
			$next_page 			= $this->uri->segment(3)+1;
			$data['canonical'] 	= site_url('personil/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('personil/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('personil');
		}else{
			$next_page 			= $this->uri->segment(3)+1;
			$prev_page 			= $this->uri->segment(3)-1;
			$data['canonical'] 	= site_url('personil/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('personil/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('personil/halaman/'.$prev_page);
		}
		$data['url_next'] 		= site_url('personil/halaman/'.$next_page);

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
		$data['bc_title']			= "Personil";
		$data['bc_link']			= site_url('personil');

		$data['title']				= "Personil";
		$data['sm_text'] 			= "Sebenarnya disini ada text nya";

		$background 				= $this->background_model->get_data()->row_array();
		$data['bg_personil'] 		= base_url('uploads/background/'.$background['bg_personil']);

		$this->template->load('website/template', 'website/personil/data_v', $data);
	}

}

/* End of file Personil.php */
/* Location: ./application/controllers/Personil.php */

?>