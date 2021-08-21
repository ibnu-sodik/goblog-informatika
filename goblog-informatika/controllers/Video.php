<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Video_model', 'video_model');
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
		$data['bc_title']			= "Video";
		$data['bc_link']			= site_url('video');

		$query = $this->video_model->get_data_by_slug($slug);
		if ($query->num_rows() > 0) {
			$value = $query->row();

			$id_video 			= $value->id_video;
			$this->video_model->hitung_views($id_video);
			$data['url'] 		= site_url('video/'.$value->slug_video);
			$data['canonical'] 	= site_url('video/'.$value->slug_video);
			$data['title'] 		= $value->nama_video;
			$data['slug']		= $value->slug_video;
			$data['link']		= $value->link_video;
			$data['bc_aktif']	= $value->nama_video;
			$data['konten']		= $value->deskripsi_video;
			if (!empty($value->deskripsi_video)) {
				$data['description'] = strip_tags(word_limiter($value->deskripsi_video), 15);
			}else{
				$data['description'] = strip_tags(word_limiter($value->nama_video), 15);
			}

			$youtubeID = getYouTubeVideoId($value->link_video);
			$thumbURL = 'https://img.youtube.com/vi/' . $youtubeID . '/mqdefault.jpg';

			$data['gambar'] 		= $thumbURL;
			$data['tgl_upload'] 	= $value->tgl_upload;
			$data['views_video']	= $value->views_video;

			$data['video_populer']		= $this->video_model->get_populer_video($site['limit_post']);
			$data['video_last_view']	= $this->video_model->get_video_terakhir_dilihat($site['limit_post']);

			$this->template->load('website/template', 'website/video/detail_v', $data);
		}else{
			redirect('video','refresh');
		}
	}

	public function index()
	{
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site 						= $this->site_model->get_site_data()->row_array();

		$jumlah 					= $this->video_model->get_data_video();
		$halaman 					= $this->uri->segment(3);
		if (!$halaman) {
			$mati = 0;
		}else{
			$mati = $halaman;
		}
		$limit 						= $site['limit_post'];
		$offset 					= $mati > 0 ? (($mati - 1) * $limit) : $mati;
		$config['base_url'] 		= base_url().'video/halaman/';		
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
		$data['video']				= $this->video_model->get_data_perpage($offset, $limit);

		if (empty($this->uri->segment(3))) {
			$next_page = 2;
			$data['canonical'] 	= site_url('video');
			$data['url'] 		= site_url('video');
			$data['url_prev'] 	= "";
		}elseif ($this->uri->segment(3)=='1') {
			$next_page = 2;
			$data['canonical'] 	= site_url('video');
			$data['url'] 		= site_url('video');
			$data['url_prev'] 	= site_url('video');
		}elseif ($this->uri->segment(3)=='2') {
			$next_page 			= $this->uri->segment(3)+1;
			$data['canonical'] 	= site_url('video/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('video/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('video');
		}else{
			$next_page 			= $this->uri->segment(3)+1;
			$prev_page 			= $this->uri->segment(3)-1;
			$data['canonical'] 	= site_url('video/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('video/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('video/halaman/'.$prev_page);
		}
		$data['url_next'] 		= site_url('video/halaman/'.$next_page);

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
		$data['bc_title']			= "Video";
		$data['bc_link']			= site_url('artikel');

		$data['title']				= "Video";
		$data['sm_text'] 			= "Sebenarnya disini ada text nya";

		$background 				= $this->background_model->get_data()->row_array();
		$data['bg_umum'] 			= base_url('uploads/background/'.$background['bg_umum']);

		$this->template->load('website/template', 'website/video/data_v', $data);
	}

}

/* End of file Video.php */
/* Location: ./application/controllers/Video.php */

?>