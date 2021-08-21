<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Label extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Label_model', 'label_model');
	}

	public function index()
	{
		redirect('artikel','refresh');
	}

	public function detail($label)
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
		$data['bc_title']			= "Label";
		$data['bc_link']			= site_url('label');

		$data_label = $this->label_model->get_artikel_by_label($label);
		if ($data_label->num_rows() > 0) {
			$value = $data_label->row();

			$jumlah 					= $data_label->num_rows();
			$halaman 					= $this->uri->segment(3);
			if (!$halaman) {
				$mati = 0;
			}else{
				$mati = $halaman;
			}
			$limit 						= $site['limit_post'];
			$offset 					= $mati > 0 ? (($mati - 1) * $limit) : $mati;
			$config['base_url'] 		= base_url().'label/'.$label.'/';		
			$config['total_rows'] 		= $jumlah;
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

			$data['pagination']		= $this->pagination->create_links();
			$data['label']			= $this->label_model->get_label_artikel_perpage($offset, $limit, $label);

			$data['url'] 			= site_url('label/'.$label);
			$data['canonical'] 		= site_url('label/'.$label);
			$data['bc_link']		= site_url('artikel');

			$d_label 				= $this->label_model->get_label_by_slug($label)->row();
			$data['title']			= "Label";
			$data['bc_title']		= "Label $d_label->nama_label";
			$data['sm_text'] 		= "$jumlah artikel dari label $d_label->nama_label";

			$background 			= $this->background_model->get_data()->row_array();
			$data['bg_artikel'] 	= base_url('uploads/background/'.$background['bg_artikel']);

			$this->template->load('website/template', 'website/artikel/label_v', $data);

		}else{
			redirect('artikel','refresh');
		}
	}

}

/* End of file Label.php */
/* Location: ./application/controllers/Label.php */

?>