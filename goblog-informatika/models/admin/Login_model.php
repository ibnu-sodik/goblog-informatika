<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function update_last_login($id_personil)
	{
		$tanggal = date('Y-m-d H:i:s');
		$object = array('last_login' => $tanggal);
		$this->db->where('id', $id_personil);
		$this->db->update('tb_personil', $object);
	}

	public function validasi($username)
	{
		$result = $this->db->query("SELECT * FROM tb_personil WHERE (email = '$username' OR username='$username')");
		return $result;
	}

}

/* End of file Login_model.php */
/* Location: ./application/models/admin/Login_model.php */ ?>