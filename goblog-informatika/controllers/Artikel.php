<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Artikel_model', 'artikel_model');
		$this->visitor_model->hitung_visitor();
	}

	public function balas_komentar()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_komentar', 'Nama', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('email_komentar', 'Alamat Email', 'trim|required');
		$this->form_validation->set_rules('konten_komentar', 'Isi Komentar', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$slug = $this->input->post('slug', TRUE);

		if ($this->form_validation->run() === FALSE) {
			$this->detail($slug);
		}else{
			$id_komentar 			= $this->input->post('id_komentar', TRUE);
			$id_komentar_artikel 	= $this->input->post('id_komentar_artikel2', TRUE);
			$id_author_artikel 		= $this->input->post('id_author_artikel2', TRUE);
			$nama_komentar 			= $this->input->post('nama_komentar', TRUE);
			$email_komentar 		= $this->input->post('email_komentar', TRUE);
			$website 				= $this->input->post('website', TRUE);
			$konten_komentar 		= $this->input->post('konten_komentar', TRUE);

			$this->artikel_model->simpan_komentar($id_komentar_artikel, $id_author_artikel, $nama_komentar, $email_komentar, $website, $konten_komentar, $id_komentar);

			$text = "Komentar balasan berhasil terkirim.";
			$this->session->set_flashdata('pesan_sukses', $text);
			redirect(site_url('artikel/'.$slug), 'refresh');

		}
	}

	public function kirim_komentar()
	{
		$this->load->helper(array('form', 'html'));

		$this->form_validation->set_rules('nama_komentar', 'Nama', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('email_komentar', 'Alamat Email', 'trim|required');
		$this->form_validation->set_rules('konten_komentar', 'Isi Komentar', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		$slug = $this->input->post('slug', TRUE);

		if ($this->form_validation->run() === FALSE) {
			$this->detail($slug);
		}else{
			$id_komentar_artikel 	= $this->input->post('id_komentar_artikel', TRUE);
			$id_author_artikel 		= $this->input->post('id_author_artikel', TRUE);
			$nama_komentar 			= $this->input->post('nama_komentar', TRUE);
			$email_komentar 		= $this->input->post('email_komentar', TRUE);
			$website 				= $this->input->post('website', TRUE);
			$konten_komentar 		= $this->input->post('konten_komentar', TRUE);

			$this->artikel_model->simpan_komentar($id_komentar_artikel, $id_author_artikel, $nama_komentar, $email_komentar, $website, $konten_komentar);

			$text = "Komentar terkirim.";
			$this->session->set_flashdata('pesan_sukses', $text);
			redirect(site_url('artikel/'.$slug), 'refresh');

		}
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
		$data['bc_title']			= "Artikel";
		$data['bc_link']			= site_url('artikel');

		$query = $this->artikel_model->get_data_by_slug($slug);
		if ($query->num_rows() > 0) {
			$value = $query->row();
			
			$id_artikel 		= $value->id_artikel;
			$this->artikel_model->hitung_views($id_artikel);
			$data['id_artikel'] = $value->id_artikel;
			$data['url'] 		= site_url('artikel/'.$value->slug_artikel);
			$data['canonical'] 	= site_url('artikel/'.$value->slug_artikel);
			$data['title'] 		= $value->judul_artikel;
			$data['konten']		= $value->konten_artikel;
			$data['slug']		= $value->slug_artikel;
			$data['bc_aktif']	= $value->judul_artikel;
			if (!empty($value->deskripsi_artikel)) {
				$data['description'] = strip_tags(word_limiter($value->deskripsi_artikel), 15);
			}else{
				$data['description'] 	= strip_tags(word_limiter($value->konten_artikel), 15);
			}
			$data['gambar'] 			= base_url('uploads/artikel/'.$value->gambar_artikel);
			$data['post_date'] 			= $value->tanggal_up_artikel;
			$data['post_update'] 		= $value->terakhir_update_artikel;
			$data['jumlah_komentar'] 	= $value->jumlah_komentar;
			$data['views_artikel'] 		= $value->views_artikel;
			$data['id_author']			= $value->id_author;
			
			$data['author']				= $value->full_name;
			$data['username']			= $value->username;
			$data['foto']				= $value->foto;

			$data['nama_kategori']		= $value->nama_kategori;
			$data['slug_kategori']		= $value->slug_kategori;
			$data['labels']				= $value->label_artikel;

			$data['komentar']			= $value->jumlah_komentar;
			$data['data_komentar']		= $this->artikel_model->get_komentar_artikel($id_artikel);

			$data['artikel_sebelumnya'] = $this->artikel_model->get_data_sebelumnya($id_artikel);
			$data['artikel_selanjutnya'] = $this->artikel_model->get_data_selanjutnya($id_artikel);

			$data['artikel_populer'] 	= $this->artikel_model->get_artikel_populer($site['limit_post']);
			$data['artikel_review'] 	= $this->artikel_model->get_artikel_review($site['limit_post']);

			$this->template->load('website/template', 'website/artikel/detail_v', $data);
		}else{
			redirect('artikel','refresh');
		}
	}

	public function index()
	{
		$data['timestamp'] 			= strtotime(date('Y-m-d H:i:s'));
		$site 						= $this->site_model->get_site_data()->row_array();

		$jumlah 					= $this->artikel_model->get_artikel();
		$halaman 					= $this->uri->segment(3);
		if (!$halaman) {
			$mati = 0;
		}else{
			$mati = $halaman;
		}
		$limit 						= $site['limit_post'];
		$offset 					= $mati > 0 ? (($mati - 1) * $limit) : $mati;
		$config['base_url'] 		= base_url().'artikel/halaman/';		
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
		$data['artikel']			= $this->artikel_model->get_data_perpage($offset, $limit);

		if (empty($this->uri->segment(3))) {
			$next_page = 2;
			$data['canonical'] 	= site_url('artikel');
			$data['url'] 		= site_url('artikel');
			$data['url_prev'] 	= "";
		}elseif ($this->uri->segment(3)=='1') {
			$next_page = 2;
			$data['canonical'] 	= site_url('artikel');
			$data['url'] 		= site_url('artikel');
			$data['url_prev'] 	= site_url('artikel');
		}elseif ($this->uri->segment(3)=='2') {
			$next_page 			= $this->uri->segment(3)+1;
			$data['canonical'] 	= site_url('artikel/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('artikel/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('artikel');
		}else{
			$next_page 			= $this->uri->segment(3)+1;
			$prev_page 			= $this->uri->segment(3)-1;
			$data['canonical'] 	= site_url('artikel/halaman/'.$this->uri->segment(3));
			$data['url'] 		= site_url('artikel/halaman/'.$this->uri->segment(3));
			$data['url_prev'] 	= site_url('artikel/halaman/'.$prev_page);
		}
		$data['url_next'] 		= site_url('artikel/halaman/'.$next_page);

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
		$data['bc_title']			= "Artikel";
		$data['bc_link']			= site_url('artikel');

		$data['title']				= "Artikel";
		$data['sm_text'] 			= "Sebenarnya disini ada text nya";

		$background 				= $this->background_model->get_data()->row_array();
		$data['bg_artikel'] 		= base_url('uploads/background/'.$background['bg_artikel']);

		$this->template->load('website/template', 'website/artikel/data_v', $data);
	}

}


/* End of file Artikel.php */
/* Location: ./application/controllers/Artikel.php */

?>