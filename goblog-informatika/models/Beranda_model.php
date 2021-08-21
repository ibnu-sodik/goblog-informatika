<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda_model extends CI_Model {

	public function get_populer_video()
	{
		$query = $this->db->query("SELECT * FROM tb_video ORDER BY views_video DESC LIMIT 1");
		return $query;
	}

	public function get_new_video()
	{
		$query = $this->db->query("SELECT * FROM tb_video ORDER BY id_video DESC LIMIT 1");
		return $query;
	}

	public function get_testimoni($limit = '')
	{
		if ($limit != '') {			
			$query = $this->db->query("SELECT * FROM tb_testimoni WHERE tampil = 1 ORDER BY RAND() LIMIT $limit");
		}else{
			$query = $this->db->query("SELECT * FROM tb_testimoni WHERE tampil = 1 ORDER BY tgl_kirim DESC");
		}
		return $query;
	}

	public function get_fasilitas()
	{
		$query = $this->db->query("SELECT * FROM tb_fasilitas ORDER BY nama_fasilitas ASC");
		return $query;
	}

	public function get_sambutan()
	{
		$query = $this->db->query("SELECT * FROM tb_sambutan");
		return $query;
	}

	public function get_berita($limit)
	{
		$query = $this->db->query("SELECT tb_berita.*, DATE_FORMAT(berita_postdate, '%d') AS tanggal, DATE_FORMAT(berita_postdate, '%M') AS bulan FROM tb_berita ORDER BY id_berita DESC LIMIT $limit");
		return $query;
	}

	public function get_agenda($limit)
	{
		$query = $this->db->query("SELECT tb_agenda.*, DATE_FORMAT(tgl_pelaksanaan, '%d') AS tanggal, DATE_FORMAT(tgl_pelaksanaan, '%M') AS bulan FROM tb_agenda ORDER BY id_agenda DESC LIMIT $limit");
		return $query;
	}

	public function get_banner()
	{
		$query = $this->db->query("SELECT * FROM tb_banner ORDER BY status_aktif DESC ");
		return $query;
	}

	public function get_artikel($limit)
	{
		$query = $this->db->query("SELECT tb_artikel.*, tb_personil.*, count(id_komentar) AS jumlah_komentar, tb_kategori_artikel.* FROM tb_artikel 
			LEFT JOIN tb_personil ON id_author = id 
			LEFT JOIN tb_komentar ON id_artikel = id_komentar_artikel 
			LEFT JOIN tb_kategori_artikel ON id_kategori_artikel = id_kategori 
			WHERE publish_artikel = 1 GROUP BY id_artikel ORDER BY id_artikel DESC LIMIT $limit");
		return $query;
	}

}

/* End of file Beranda_model.php */
/* Location: ./application/models/Beranda_model.php */

 ?>