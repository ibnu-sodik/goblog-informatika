<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni_model extends CI_Model {

	public function simpan($image, $nama_testimoni, $konten_testimoni, $profesi_testimoni)
	{
		$object = array(
			'nama_testimoni' 	=> $nama_testimoni,
			'profesi_testimoni' => $profesi_testimoni,
			'konten_testimoni' 	=> $konten_testimoni,
			'foto_testimoni' 	=> $image,
		);
		$this->db->insert('tb_testimoni', $object);
	}

	public function get_data($limit = '')
	{
		if ($limit != '') {			
			$query = $this->db->query("SELECT * FROM tb_testimoni WHERE tampil = 1 ORDER BY RAND() LIMIT $limit");
		}else{
			$query = $this->db->query("SELECT * FROM tb_testimoni WHERE tampil = 1 ORDER BY tgl_kirim DESC");
		}
		return $query;
	}	

}

/* End of file Testimoni_model.php */
/* Location: ./application/models/Testimoni_model.php */

?>