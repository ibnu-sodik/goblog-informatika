<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Aktivasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Personil_model', 'personil_model');
	}

	public function index($kode_aktivasi)
	{
		$query = $this->personil_model->get_data_aktivasi($kode_aktivasi);
		if ($query->num_rows() > 0) {
			$data = $query->row();
			$this->personil_model->aktivasi($data->email);
			$this->personil_model->hapus_kode_aktivasi($kode_aktivasi);

			$text = "Aktivasi akun sukses. Silahkan login.";
			$this->session->set_flashdata('pesanSukses', $text);
			$url = site_url('admin');
			redirect($url,'refresh');
		}else{
			$text = "Kode aktivasi tidak ditemukan.";
			$this->session->set_flashdata('pesan', $text);
			$url = site_url('admin');
			redirect($url,'refresh');
		}
	}

}

/* End of file Aktivasi.php */
/* Location: .//C/xampp/htdocs/goblog-informatika/goblog-informatika/controllers/admin/Aktivasi.php */

?>