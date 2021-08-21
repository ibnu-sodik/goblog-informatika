<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_model extends CI_Model {

	public function get_data_perpage($offset, $limit)
	{
		$this->db->select('*');
		$this->db->from('tb_berita');
		$this->db->order_by('id_berita', 'desc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}

	public function get_all_berita($limit = '')
	{
		if ($limit == '') {
			$this->db->select('*');
			$this->db->from('tb_berita');
			$this->db->order_by('id_berita', 'desc');
			$query = $this->db->get();
			return $query;
		}else{
			$this->db->select('*');
			$this->db->from('tb_berita');
			$this->db->order_by('id_berita', 'desc');
			$this->db->limit($limit);
			$query = $this->db->get();
			return $query;
		}
	}

	public function get_data_by_slug($slug)
	{
		$this->db->select('*');
		$this->db->from('tb_berita');
		$this->db->where('slug_berita', $slug);
		$query = $this->db->get();
		return $query;
	}

}

/* End of file Berita_model.php */
/* Location: ./application/models/Berita_model.php */

?>