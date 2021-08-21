<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Kontak_model extends CI_Model {

	public function kirim_pesan($fname, $lname, $email, $subject, $message)
	{
		$object = array(
			'nama_depan' 	=> $fname,
			'nama_belakang' => $lname,
			'alamat_email' 	=> $email,
			'subjek_pesan' 	=> $subject,
			'isi_pesan' 	=> $message 
		);
		$this->db->insert('tb_pesan', $object);
	}

	public function get_kontak_data()
	{
		$this->db->select('*');
		$this->db->from('tb_konten_kontak');
		$this->db->limit(1);
		$result = $this->db->get();
		return $result;
	}	

}

/* End of file Kontak_model.php */
/* Location: ./application/models/Kontak_model.php */

?>