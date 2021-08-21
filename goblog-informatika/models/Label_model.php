<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Label_model extends CI_Model {

	public function get_label()
	{
		$this->db->select('*');
		$this->db->from('tb_label_artikel');
		$this->db->group_by('slug_label');
		$query = $this->db->get();
		return $query;
	}

	public function get_label_by_slug($label)
	{
		$query = $this->db->get_where('tb_label_artikel', array('slug_label' => $label));
		return $query;
	}

	public function get_artikel_by_label($label)
	{
		$this->db->select('tb_artikel.*, tb_kategori_artikel.*, tb_personil.*');
		$this->db->from('tb_artikel');
		$this->db->join('tb_kategori_artikel', 'id_kategori_artikel = id_kategori', 'left');
		$this->db->join('tb_personil', 'id_author = id', 'left');
		$this->db->where('publish_artikel', 1);
		$this->db->like('label_artikel', $label, 'BOTH');
		$this->db->group_by('slug_kategori');
		$query = $this->db->get();
		return $query;
	}

	public function get_label_artikel_perpage($offset, $limit, $label)
	{
		$this->db->select('tb_artikel.*, tb_kategori_artikel.*, tb_personil.*');
		$this->db->from('tb_artikel');
		$this->db->join('tb_kategori_artikel', 'id_kategori_artikel = id_kategori', 'left');
		$this->db->join('tb_personil', 'id_author = id', 'left');
		$this->db->where('publish_artikel', 1);
		$this->db->like('label_artikel', $label, 'BOTH');
		$this->db->group_by('slug_kategori');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}	

}

/* End of file Label_model.php */
/* Location: ./application/models/Label_model.php */

 ?>