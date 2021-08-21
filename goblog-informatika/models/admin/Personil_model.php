<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Personil_model extends CI_Model {

	public function hapus_multi($id, $tabel, $kolom)
	{
		$this->db->where($kolom, $id);
		$this->db->delete($tabel);
	}

	public function update($id, $full_name, $username, $email, $jenis_fungsi, $level)
	{
		$object = array(
			'full_name' 	=> $full_name,
			'username' 		=> $username,
			'email' 		=> $email,
			'jenis_fungsi' 	=> $jenis_fungsi,
			'level' 		=> $level
		);
		$this->db->where('id', $id);
		$this->db->update('tb_personil', $object);
	}

	public function cek($field, $value, $id)
	{
		$query = $this->db->query("SELECT * FROM tb_personil WHERE $field = '$value' AND id != '$id'");
		return $query;
	}

	public function update_profil($id, $field, $value)
	{
		$object = array($field => $value);
		$this->db->where('id', $id);
		$this->db->update('tb_personil', $object);
	}

	public function lock($id)
	{
		$object = array('status' => '0');
		$this->db->where('id', $id);
		$this->db->update('tb_personil', $object);
	}

	public function unlock($id)
	{
		$object = array('status' => '1');
		$this->db->where('id', $id);
		$this->db->update('tb_personil', $object);
	}

	public function get_data_personil_by_username($username)
	{
		$this->db->select('*');
		$this->db->from('tb_personil');
		$this->db->where('username', $username);
		$query = $this->db->get();
		return $query;
	}

	public function get_data_by_id($id_personil)
	{
		$this->db->select('*');
		$this->db->from('tb_personil');
		$this->db->where('id', $id_personil);
		$query = $this->db->get();
		return $query;
	}

	public function get_all_data()
	{
		$query = $this->db->query("SELECT * FROM tb_personil");
		return $query;
	}

	public function get_max_id()
	{
		$query = $this->db->query("SELECT MAX(id) AS id_personil FROM tb_personil");
		return $query;
	}

	public function tambah_data($username, $password, $full_name, $email)
	{
		$object = array(
			'full_name' => $full_name, 
			'email' 	=> $email, 
			'username' 	=> $username, 
			'password' 	=> $password
		);
		$this->db->insert('tb_personil', $object);
	}

	public function get_info_username($username)
	{
		$this->db->where('username',$username);
		$this->db->limit(1);
		$query = $this->db->get('tb_personil');
		return ($query->num_rows() > 0) ? $query->row() : FALSE;
	}

	public function save_aktivasi($email, $kode_aktivasi)
	{
		$object = array(
			'email' => $email,
			'kode' => $kode_aktivasi,
		);
		$this->db->insert('tb_aktivasi', $object);
	}

	public function get_data_aktivasi($kode_aktivasi)
	{
		$query = $this->db->query("SELECT * FROM tb_aktivasi WHERE kode = '$kode_aktivasi'");
		return $query;
	}

	public function aktivasi($email)
	{
		$object = array('status' => '1');
		$this->db->where('email', $email);
		$this->db->update('tb_personil', $object);
	}

	public function hapus_kode_aktivasi($kode_aktivasi)
	{
		$this->db->where('kode', $kode_aktivasi);
		$this->db->delete('tb_aktivasi');
	}

}

/* End of file Personil_model.php */
/* Location: ./application/models/admin/Personil_model.php */

?>