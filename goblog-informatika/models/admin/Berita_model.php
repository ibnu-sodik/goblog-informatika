<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_model extends CI_Model {

	public function update_berita_no_img($id_berita, $nama_berita, $konten, $slug, $deskripsi)
	{
		$tgl_update = date('Y-m-d H:i:s');
		$object = array(
			'nama_berita' 		=> $nama_berita,
			'konten_berita' 	=> $konten,
			'deskripsi_berita' 	=> $deskripsi,
			'slug_berita' 		=> $slug,
			'berita_update'		=> $tgl_update
		);
		$this->db->where('id_berita', $id_berita);
		$this->db->update('tb_berita', $object);
	}

	public function update_berita($id_berita, $nama_berita, $konten, $image, $slug, $deskripsi)
	{
		$tgl_update = date('Y-m-d H:i:s');
		$object = array(
			'nama_berita' 		=> $nama_berita,
			'konten_berita' 	=> $konten,
			'deskripsi_berita' 	=> $deskripsi,
			'gambar_berita' 	=> $image,
			'slug_berita' 		=> $slug,
			'berita_update'		=> $tgl_update
		);
		$this->db->where('id_berita', $id_berita);
		$this->db->update('tb_berita', $object);
	}

	public function hapus_berita($id_berita)
	{
		$this->db->where('id_berita', $id_berita);
		$this->db->delete('tb_berita');
	}

	public function get_berita_by_id($id_berita)
	{
		$result = $this->db->query("SELECT * FROM tb_berita WHERE id_berita = '$id_berita'");
		return $result;
	}	

	public function simpan_berita($nama_berita, $konten, $slug, $image, $deskripsi)
	{
		$object = array(
			'nama_berita' 		=> $nama_berita,
			'konten_berita' 	=> $konten,
			'deskripsi_berita' 	=> $deskripsi,
			'gambar_berita' 	=> $image,
			'slug_berita' 		=> $slug
		);
		$this->db->insert('tb_berita', $object);
	}

	public function get_all_berita()
	{
		$this->db->select('*');
		$this->db->from('tb_berita');
		$this->db->order_by('id_berita', 'desc');
		$query = $this->db->get();
		return $query;
	}

}

/* End of file Berita_model.php */
/* Location: ./application/models/admin/Berita_model.php */

?>