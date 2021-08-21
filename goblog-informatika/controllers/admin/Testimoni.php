<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Testimoni_model', 'testimoni_model');
		$this->load->library('upload');
		$this->load->helper('text');
		if ($this->session->userdata('access')!=1) {
			$text = 'Terdapat batasan hak akses pada halaman ini.';
			$this->session->set_flashdata('pesan_error', $text);
			redirect('admin', 'refresh');
		}		
	}

	public function ubah_tampil($id_testimoni)
	{
		$data 	= $this->testimoni_model->get_data_by_id($id_testimoni)->row_array();

		$status = $this->input->get('status', TRUE);
		$this->testimoni_model->ubah_tampil($id_testimoni, $status);

		if ($status == 1) {
			$text = "Testimoni milik ".$data['nama_testimoni']." berhasil ditampilkan.";
			$type = "success";
		}else{
			$text = "Testimoni milik ".$data['nama_testimoni']." berhasil dimatikan.";
			$type = "info";
		}

		$data = array('pesan' => $text, 'tipe' => $type);
		echo json_encode($data);
	}

	public function hapus($id_testimoni)
	{
		$data 	= $this->testimoni_model->get_data_by_id($id_testimoni)->row();
		$gambar = 'uploads/testimoni/'.$data->foto_testimoni;
		$thumb 	= 'uploads/testimoni/thumbs'.$data->foto_testimoni;
		unlink($gambar);
		unlink($thumb);
		$this->testimoni_model->hapus($id_testimoni);
		// 0=login, 1=logout, 2=create, 3=update, 4=delete, 5=resetPass, 6=reply
		$this->log_model->save_log($this->session->userdata('id'), 4, "Menghapus Testimoni dari $data->nama_testimoni");
		$text = "Testimoni dari $data->nama_testimoni berhasil dihapus.";
		$this->session->set_flashdata('pnotify', $text);
		redirect('admin/testimoni');
	}

	public function detail($id_testimoni)
	{
		sleep(1);
		$this->db->query("UPDATE tb_testimoni SET dilihat = 1 WHERE id_testimoni = '$id_testimoni'");
		$hasil = '';
		$data 	= $this->testimoni_model->get_data_by_id($id_testimoni)->row();
		$src = base_url('uploads/testimoni/'.$data->foto_testimoni);
		$hasil .= '<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
		<h4 class="blue">
		<span class="middle">'.$data->nama_testimoni.'</span>
		</h4>

		<div class="profile-info-row">
		<div class="profile-info-name"> Foto Pengirim </div>

		<div class="profile-info-value">
		<span>
		<img src="'.$src.'" class="img-fluid img-responsive img-thumbnail" style="max-width:150px;">
		</span>
		</div>
		</div>

		<div class="profile-user-info">
		<div class="profile-info-row">
		<div class="profile-info-name"> Nama Pengirim </div>

		<div class="profile-info-value">
		<span>'.$data->nama_testimoni.'</span>
		</div>
		</div>

		<div class="profile-info-row">
		<div class="profile-info-name"> Testimoni Pengirim </div>

		<div class="profile-info-value">
		<span>'.$data->konten_testimoni.'</span>
		</div>
		</div>

		<div class="profile-info-row">
		<div class="profile-info-name"> Profesi Pengirim </div>

		<div class="profile-info-value">
		<span>'.$data->profesi_testimoni.'</span>
		</div>
		</div>
		</div>

		</div>
		</div>';
		$data = array(
			'detail_testimoni' => $hasil
		);
		echo json_encode($data);
	}

	public function get_data()
	{
		$data_testimoni 	= $this->testimoni_model->get_data_baru();
		$hasil 	= '';
		if ($data_testimoni->num_rows() > 0) {
			foreach ($data_testimoni->result() as $row) {
				$gambar = base_url('uploads/testimoni/').$row->foto_testimoni;
				$thumbs = base_url('uploads/testimoni/thumbs/').$row->foto_testimoni;
				$hasil .= '
				<tr>
					<td class="text-center">
						<div class="ace-thumbnails clearfix">
							<img src="'.$thumbs.'" width="50" height="50" alt="'.$row->nama_testimoni.'" class="img-thumbnail img-responsive img-fluid img-circle">
						</div>
					</td>
					<td class="text-left">'.$row->nama_testimoni.'</td>
					<td class="text-center">'.$row->profesi_testimoni.'</td>
					<td class="text-center">'.tanggal_indo($row->tgl_kirim).'</td>
				</tr>
				';
			}
		} else {
			$hasil .= '<tr>
			<td class="text-center" colspan="5">Tidak ada data ditemukan</td>
			</tr>';
		}

		$jumlah = $data_testimoni->num_rows();
		if ($jumlah > 0) {
			$badge = '<span class="badge badge-success">'.$jumlah.'</span>';
		}

		$data = array(
			'data_testimoni' => $hasil,
			'badge' => $badge,
		);

		echo json_encode($data);
	}

	public function index()
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
		$data['tahun_buat'] 		= $site['tahun_buat'];
		$data['bc_aktif'] 			= "Testimoni";
		$data['title'] 				= "Testimoni";

		$data['data_testimoni'] 	= $this->testimoni_model->get_data();

		$this->template->load('admin/template', 'admin/testimoni/data_v', $data);
	}

}

/* End of file Testimoni.php */
/* Location: ./application/controllers/admin/Testimoni.php */

?>