<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel_model extends CI_Model {

	public function get_data_by_author($id_author)
	{
		$query = $this->db->get_where('tb_artikel', array('id_author' => $id_author));
		return $query;
	}

	function hapus_artikel($id_artikel)
	{
		$this->db->where('id_artikel', $id_artikel);
		$this->db->delete('tb_artikel');
	}

	function get_artikel_by_id($id_artikel)
	{
		$result = $this->db->query("SELECT * FROM tb_artikel WHERE id_artikel = '$id_artikel'");
		return $result;
	}

	public function update_artikel($id_artikel, $judul, $konten, $kategori, $slug, $image, $labels, $deskripsi)
	{
		$tgl_update = date('Y-m-d H:i:s');
		$object = array(
			'judul_artikel' 			=> $judul,
			'konten_artikel' 			=> $konten,
			'deskripsi_artikel' 		=> $deskripsi,
			'gambar_artikel' 			=> $image,
			'label_artikel' 			=> $labels,
			'slug_artikel' 				=> $slug,
			'publish_artikel' 			=> 1,
			'id_kategori_artikel' 		=> $kategori,
			'terakhir_update_artikel' 	=> $tgl_update,
			'id_author' 				=> $this->session->userdata('id')
		);
		$this->db->where('id_artikel', $id_artikel);
		$this->db->update('tb_artikel', $object);
	}

	public function update_artikel2($id_artikel, $judul, $konten, $kategori, $slug, $labels, $deskripsi)
	{
		$tgl_update = date('Y-m-d H:i:s');
		$object = array(
			'judul_artikel' 			=> $judul,
			'konten_artikel' 			=> $konten,
			'deskripsi_artikel' 		=> $deskripsi,
			'label_artikel' 			=> $labels,
			'slug_artikel' 				=> $slug,
			'publish_artikel' 			=> 1,
			'id_kategori_artikel' 		=> $kategori,
			'terakhir_update_artikel' 	=> $tgl_update,
			'id_author' 				=> $this->session->userdata('id')
		);
		$this->db->where('id_artikel', $id_artikel);
		$this->db->update('tb_artikel', $object);
	}

	public function simpan_artikel($judul, $konten, $kategori, $slug, $image, $labels, $deskripsi)
	{
		$object = array(
			'judul_artikel' 		=> $judul,
			'konten_artikel' 		=> $konten,
			'deskripsi_artikel' 	=> $deskripsi,
			'gambar_artikel' 		=> $image,
			'label_artikel' 		=> $labels,
			'slug_artikel' 			=> $slug,
			'publish_artikel' 		=> 1,
			'id_kategori_artikel' 	=> $kategori,
			'id_author' 			=> $this->session->userdata('id')
		);
		$this->db->insert('tb_artikel', $object);
	}
	
	public function hapus_label($id_label)
	{
		$this->db->where('id_label', $id_label);
		$this->db->delete('tb_label_artikel');
	}

	public function _update_label($id, $label, $slug)
	{
		$object = array(
			'nama_label' => $label,
			'slug_label' => $slug
		);
		$this->db->where('id_label', $id);
		$this->db->update('tb_label_artikel', $object);
	}

	public function _simpan_label($label, $slug, $user_id)
	{
		$object = array(
			'nama_label' => $label,
			'slug_label' => $slug,
			'user_id_label' => $user_id
		);
		$this->db->insert('tb_label_artikel', $object);
	}

	public function get_label_artikel_by_user_id($user_id)
	{
		$this->db->select('*');
		$this->db->from('tb_label_artikel');
		$this->db->where('user_id_label', $user_id);
		$query = $this->db->get();
		return $query;
	}

	public function get_label_artikel_by_id($id_label)
	{
		$this->db->select('*');
		$this->db->from('tb_label_artikel');
		$this->db->where('id_label', $id_label);
		$query = $this->db->get();
		return $query;
	}
	
	function hapus_kategori($id_kategori)
	{
		$this->db->where('id_kategori', $id_kategori);
		$this->db->delete('tb_kategori_artikel');
	}

	public function _update_kategori($id, $kategori, $slug)
	{
		$object = array(
			'nama_kategori' => $kategori,
			'slug_kategori' => $slug
		);
		$this->db->where('id_kategori', $id);
		$this->db->update('tb_kategori_artikel', $object);
	}

	public function _simpan_kategori($kategori, $slug, $user_id)
	{
		$object = array(
			'nama_kategori' => $kategori,
			'slug_kategori' => $slug,
			'user_id_kategori' => $user_id
		);
		$this->db->insert('tb_kategori_artikel', $object);
	}

	public function get_kategori_artikel_by_user_id($user_id)
	{
		$this->db->select('*');
		$this->db->from('tb_kategori_artikel');
		$this->db->where('user_id_kategori', $user_id);
		$query = $this->db->get();
		return $query;
	}

	public function get_kategori_artikel_by_id($id_kategori)
	{
		$this->db->select('*');
		$this->db->from('tb_kategori_artikel');
		$this->db->where('id_kategori', $id_kategori);
		$query = $this->db->get();
		return $query;
	}

	public function buat_query($id_author, $kategori)
	{
		$query = "SELECT tb_artikel.*, tb_kategori_artikel.* FROM tb_artikel LEFT JOIN tb_kategori_artikel ON tb_artikel.id_kategori_artikel = tb_kategori_artikel.id_kategori WHERE id_author = '$id_author' AND publish_artikel = '1' ";

		if (isset($kategori) && !empty($kategori)) {
			$kategori_filter = implode("','", $kategori);
			$query .= " AND id_kategori_artikel IN('".$kategori_filter."') ";
		}

		return $query;
	}

	public function gabungkan_data($id_author, $offset, $limit, $kategori)
	{
		$query = $this->buat_query($id_author, $kategori);
		$query .= ' LIMIT '.$offset.', ' .$limit;
		$data = $this->db->query($query);

		$hasil = '';
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {
				$hasil .= '
				<div class="col-xs-12 col-sm-4 widget-container-col" id="widget-container-col-4">
				<div class="widget-box" id="widget-box-4">
				<div class="widget-header widget-header-large">
				<h5 class="widget-title">'.batasi_kata($row->judul_artikel, 7).'...</h5>

				<div class="widget-toolbar">

				<a href="'.site_url('admin/artikel/edit/'.$row->id_artikel).'" title="Edit">
				<i class="ace-icon fa fa-pencil"></i>
				</a>

				<a href="#" data-action="collapse">
				<i class="ace-icon fa fa-chevron-up"></i>
				</a>

				<a href="'.site_url('admin/artikel/hapus/'.$row->id_artikel).'" id="tombolHapus" title="Hapus" onclick="conf_hapus()">
				<i class="ace-icon fa fa-times"></i>
				</a>
				</div>
				</div>

				<div class="widget-body">
				<div class="widget-main">
				<div class="col">
				<div class="card">
				';
				$file = file_exists(base_url('uploads/artikel/'.$row->gambar_artikel));

				if (!$file && !empty($row->gambar_artikel)){
					$hasil .= '<img src="'. base_url('uploads/artikel/'.$row->gambar_artikel) .'" class="card-img-top img-thumbnail img-responsive" alt="'. $row->judul_artikel .'">';
				} else {
					$hasil .= '<img src="'. base_url('dists/images/no-img.png') .'" class="card-img-top img-thumbnail img-responsive" alt="'. $row->judul_artikel .'">';
				}
				$hasil .= '
				<div class="card-body">
				<p class="card-text">'. strip_tags(word_limiter($row->konten_artikel, 15)) .'...</p>
				</div>
				<div class="card-footer">
				<label class="label label-info arrowed-right label-pink">'.$row->nama_kategori.'</label>
				';

				if ($row->terakhir_update_artikel != NULL){
					$hasil .= '
					<small class="text-muted pull-right">Terakhir Update '. waktu_berlalu($row->terakhir_update_artikel).'</small>
					';
				}

				$hasil .= '
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				</div>
				';
			}
		}else{
			$hasil = '
			<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">
			<i class="ace-icon fa fa-times"></i>
			</button>

			<strong>
			<i class="ace-icon fa fa-times"></i>
			Oops...!
			</strong>
			Data tidak ditemukan.
			<br />
			</div>
			';
		}
		return $hasil;
	}

	public function get_artikel_per_page($id_author, $offset, $limit, $kategori)
	{
		$this->db->select('tb_artikel.*, tb_kategori_artikel.*');
		$this->db->from('tb_artikel');
		$this->db->join('tb_kategori_artikel', 'id_kategori_artikel = id_kategori', 'left');
		$kon_arr = array('publish_artikel' => 1, 'id_author' => $id_author);
		$this->db->where($kon_arr);
		$this->db->order_by('id_artikel', 'desc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}

	public function hitung_data($id_author, $kategori)
	{
		$query = $this->buat_query($id_author, $kategori);
		$data = $this->db->query($query);
		return $data->num_rows();
	}

}

/* End of file Artikel_model.php */
/* Location: ./application/models/admin/Artikel_model.php */
?>