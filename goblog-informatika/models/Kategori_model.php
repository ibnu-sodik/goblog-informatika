<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {

	public function get_kategori()
	{
		$this->db->select('*');
		$this->db->from('tb_kategori_artikel');
		$this->db->group_by('slug_kategori');
		$query = $this->db->get();
		return $query;
	}

	public function get_artikel_by_kategori($slug)
	{
		$this->db->select('tb_artikel.*, tb_kategori_artikel.*, tb_personil.*');
		$this->db->from('tb_artikel');
		$this->db->join('tb_kategori_artikel', 'id_kategori_artikel = id_kategori', 'left');
		$this->db->join('tb_personil', 'id_author = id', 'left');
		$this->db->where(array('slug_kategori' => $slug, 'publish_artikel' => 1));
		$this->db->group_by('slug_kategori');
		$query = $this->db->get();
		return $query;
	}

	public function get_kategori_artikel_perpage($offset, $limit, $id_kategori)
	{
		$this->db->select('tb_artikel.*, tb_kategori_artikel.*, tb_personil.*');
		$this->db->from('tb_artikel');
		$this->db->join('tb_kategori_artikel', 'id_kategori_artikel = id_kategori', 'left');
		$this->db->join('tb_personil', 'id_author = id', 'left');
		$this->db->where(array('id_kategori' => $id_kategori, 'publish_artikel' => 1));
		$this->db->group_by('slug_kategori');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}

}

/* End of file Kategori_model.php */
/* Location: ./application/models/Kategori_model.php */

 ?>