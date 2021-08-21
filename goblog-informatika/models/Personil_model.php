<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Personil_model extends CI_Model {

	public function get_sosmed_by_id($id_personil)
	{
		$this->db->select('*');
		$this->db->from('tb_sosmed_personil');
		$this->db->where('id_personil_sosmed', $id_personil);
		$this->db->order_by('id_sosmed', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function get_artikel_by_personil($limit, $offset, $id)
	{
		$this->db->select('tb_artikel.*, tb_kategori_artikel.*, tb_personil.*');
		$this->db->from('tb_artikel');
		$this->db->join('tb_kategori_artikel', 'id_kategori_artikel = id_kategori', 'left');
		$this->db->join('tb_personil', 'id_author = id', 'left');
		$this->db->where(array('id_author' => $id, 'publish_artikel' => 1));
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}

	public function get_data_by_username($username)
	{
		$query = $this->db->query("SELECT * FROM tb_personil WHERE username = '$username' AND status = 1 ");
		return $query;
	}

	public function get_data_perpage($offset, $limit)
	{
		$this->db->select('*');
		$this->db->from('tb_personil');
		$this->db->where('status', 1);
		$this->db->order_by('id', 'desc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}

	public function get_personil()
	{
		$query = $this->db->get_where('tb_personil', array('status' => 1));
		return $query;
	}

}

/* End of file Personil_model.php */
/* Location: ./application/models/Personil_model.php */

 ?>