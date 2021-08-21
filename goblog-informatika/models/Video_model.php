<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Video_model extends CI_Model {

	public function get_video_terakhir_dilihat($limit)
	{
		$this->db->select('*');
		$this->db->from('tb_video');
		$this->db->order_by('terakhir_dilihat', 'desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query;
	}

	public function get_populer_video($limit)
	{
		$this->db->select('tb_video.*');
		$this->db->from('tb_video');
		$this->db->order_by('views_video', 'desc');
		$this->db->limit($limit);
		$query = $this->db->get();
		return $query;
	}

	public function get_data_by_slug($slug)
	{
		$query = $this->db->query("SELECT * FROM tb_video WHERE slug_video = '$slug'");
		return $query;
	}

	public function get_data_video()
	{
		$this->db->select('*');
		$this->db->from('tb_video');
		$query = $this->db->get();
		return $query;
	}	

	public function get_data_perpage($offset, $limit)
	{
		$this->db->select('*');
		$this->db->from('tb_video');
		$this->db->order_by('tgl_upload', 'desc');
		$this->db->limit($limit, $offset);
		$query = $this->db->get();
		return $query;
	}

	public function hitung_views($id_video)
	{
		$visitor_ip = $_SERVER['REMOTE_ADDR'];
		$cek_ip 	= $this->db->query("SELECT * FROM tb_video_views WHERE view_ip = '$visitor_ip' AND view_video_id = '$id_video' AND DATE(view_date) = CURDATE() ");
		if ($cek_ip->num_rows() <= 0) {
			$this->db->trans_start();
			$this->db->query("INSERT INTO tb_video_views SET view_ip = '$visitor_ip', view_video_id = '$id_video'");
			$this->db->query("UPDATE tb_video SET views_video = views_video+1, terakhir_dilihat = NOW() WHERE id_video = '$id_video'");
			$this->db->trans_complete();
			if ($this->db->trans_status() == TRUE) {
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

}

/* End of file Video_model.php */
/* Location: ./application/models/Video_model.php */

?>