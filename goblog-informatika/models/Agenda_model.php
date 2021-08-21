<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda_model extends CI_Model {

	public function get_data_by_slug($slug)
	{
		$this->db->select('*');
		$this->db->from('tb_agenda');
		$this->db->where('slug_agenda', $slug);
		$query = $this->db->get();
		return $query;
	}

	public function get_data_perpage($offset, $limit)
	{
		$query = $this->db->query("SELECT tb_agenda.*, DATE_FORMAT(agenda_postdate, '%d') AS tanggal, DATE_FORMAT(agenda_postdate, '%M') AS bulan FROM tb_agenda ORDER BY id_agenda DESC LIMIT $offset, $limit");
		return $query;
	}

	public function get_all_agenda($limit = '')
	{
		if ($limit == '') {
			$query = $this->db->query("SELECT tb_agenda.*, DATE_FORMAT(agenda_postdate, '%d') AS tanggal, DATE_FORMAT(agenda_postdate, '%M') AS bulan FROM tb_agenda ORDER BY id_agenda DESC");
			return $query;
		}else{
			$query = $this->db->query("SELECT tb_agenda.*, DATE_FORMAT(agenda_postdate, '%d') AS tanggal, DATE_FORMAT(agenda_postdate, '%M') AS bulan FROM tb_agenda ORDER BY id_agenda DESC LIMIT $limit");
			return $query;
		}
	}

}

/* End of file Agenda_model.php */
/* Location: ./application/models/Agenda_model.php */

 ?>