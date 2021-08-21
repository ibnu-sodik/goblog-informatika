<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel_model extends CI_Model {

	public function get_komentar_artikel($id_artikel)
	{
		$query = $this->db->query("SELECT * FROM tb_komentar WHERE id_komentar_artikel = '$id_artikel' AND status_komentar = '1' AND parent_komentar = '0' ORDER BY id_komentar DESC");
		return $query;
	}

	public function get_data_selanjutnya($id_artikel)
	{
		$query = $this->db->query("SELECT * FROM tb_artikel WHERE id_artikel > '$id_artikel' AND NOT id_artikel = '$id_artikel' ORDER BY id_artikel ASC limit 1 ");
		return $query;
	}

	public function get_data_sebelumnya($id_artikel)
	{
		$query = $this->db->query("SELECT * FROM tb_artikel WHERE id_artikel < '$id_artikel' AND NOT id_artikel = '$id_artikel' ORDER BY id_artikel ASC limit 1 ");
		return $query;
	}

	public function get_artikel_populer($limit)
	{			
		$this->db->select('tb_artikel.*');
		$this->db->from('tb_artikel');
		$this->db->order_by('views_artikel', 'desc');
		$this->db->where('publish_artikel', 1);
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query;
	}

	public function get_artikel_review($limit)
	{
		$this->db->select('tb_artikel.*');
		$this->db->from('tb_artikel');
		$this->db->order_by('terakhir_dilihat', 'desc');
		$this->db->where('publish_artikel', 1);
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query;
	}

	public function get_data_by_slug($slug)
	{
		$query = $this->db->query("SELECT tb_artikel.*, tb_personil.*, count(id_komentar) AS jumlah_komentar, tb_kategori_artikel.* FROM tb_artikel 
			LEFT JOIN tb_personil ON id_author = id 
			LEFT JOIN tb_komentar ON id_artikel = id_komentar_artikel 
			LEFT JOIN tb_kategori_artikel ON id_kategori_artikel = id_kategori 
			where slug_artikel = '$slug' AND publish_artikel = '1' GROUP BY id_artikel LIMIT 1");
		return $query;
	}

	public function get_data_perpage($offset, $limit)
	{		
		$this->db->select('tb_artikel.*, full_name, username, foto, tb_kategori_artikel.*, count(id_komentar) AS jumlah_komentar');
		$this->db->from('tb_artikel');
		$this->db->join('tb_personil', 'id_author = id', 'left');
		$this->db->join('tb_kategori_artikel', 'id_kategori_artikel = id_kategori', 'left');
		$this->db->join('tb_komentar', 'id_artikel = id_komentar_artikel', 'left');
		$this->db->where('publish_artikel', 1);
		$this->db->group_by('id_artikel');
		$this->db->order_by('id_artikel', 'desc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}

	public function get_all_artikel($limit = '')
	{
		if ($limit == '') {
			$query = $this->db->query("SELECT tb_artikel.*, tb_personil.*, count(id_komentar) AS jumlah_komentar, tb_kategori_artikel.* FROM tb_artikel 
				LEFT JOIN tb_personil ON id_author = id 
				LEFT JOIN tb_komentar ON id_artikel = id_komentar_artikel 
				LEFT JOIN tb_kategori_artikel ON id_kategori_artikel = id_kategori 
				WHERE publish_artikel = 1 GROUP BY id_artikel ORDER BY id_artikel DESC");
			return $query;
		}else{
			$query = $this->db->query("SELECT tb_artikel.*, tb_personil.*, count(id_komentar) AS jumlah_komentar, tb_kategori_artikel.* FROM tb_artikel 
				LEFT JOIN tb_personil ON id_author = id 
				LEFT JOIN tb_komentar ON id_artikel = id_komentar_artikel 
				LEFT JOIN tb_kategori_artikel ON id_kategori_artikel = id_kategori 
				WHERE publish_artikel = 1 GROUP BY id_artikel ORDER BY id_artikel DESC LIMIT $limit");
			return $query;
		}
	}

	public function get_artikel()
	{
		$query = $this->db->get_where('tb_artikel', array('publish_artikel' => '1'));
		return $query;
	}

	public function simpan_komentar($id_komentar_artikel, $id_author_artikel, $nama_komentar, $email_komentar, $website, $konten_komentar, $id_komentar = '')
	{
		if (!empty($id_komentar)) {		
			$object = array(
				'id_komentar_artikel' 	=> $id_komentar_artikel,
				'id_author_artikel' 	=> $id_author_artikel,
				'nama_komentar'			=> $nama_komentar,
				'email_komentar'		=> $email_komentar,
				'website_komentar'		=> $website,
				'konten_komentar'		=> $konten_komentar,
				'parent_komentar'		=> $id_komentar
			);
		}else{
			$object = array(
				'id_komentar_artikel' 	=> $id_komentar_artikel,
				'id_author_artikel' 	=> $id_author_artikel,
				'nama_komentar'			=> $nama_komentar,
				'email_komentar'		=> $email_komentar,
				'website_komentar'		=> $website,
				'konten_komentar'		=> $konten_komentar
			);
		}
		$this->db->insert('tb_komentar', $object);
	}

	public function hitung_views($id_artikel)
	{
		$visitor_ip = $_SERVER['REMOTE_ADDR'];
		$cek_ip 	= $this->db->query("SELECT * FROM tb_artikel_views WHERE view_ip = '$visitor_ip' AND view_artikel_id = '$id_artikel' AND DATE(view_date) = CURDATE() ");
		if ($cek_ip->num_rows() <= 0) {
			$this->db->trans_start();
			$this->db->query("INSERT INTO tb_artikel_views SET view_ip = '$visitor_ip', view_artikel_id = '$id_artikel'");
			$this->db->query("UPDATE tb_artikel SET views_artikel = views_artikel+1, terakhir_dilihat = NOW() WHERE id_artikel = '$id_artikel'");
			$this->db->trans_complete();
			if ($this->db->trans_status() == TRUE) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

}

/* End of file Artikel_model.php */
/* Location: ./application/models/Artikel_model.php */

?>