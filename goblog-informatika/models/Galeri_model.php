<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri_model extends CI_Model {

	public function get_album()
	{
		$this->db->select('*');
		$this->db->from('tb_album');
		$this->db->order_by('id_album', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function buat_query($album)
	{
		$query = "SELECT tb_album.*, tb_galeri.* FROM tb_galeri LEFT JOIN tb_album ON tb_galeri.id_album_galeri = tb_album.id_album ";

		if (isset($album) && !empty($album)) {
			$album_filter = implode("','", $album);
			$query .= " WHERE id_album_galeri IN('".$album_filter."') ";
		}

		return $query;
	}

	public function hitung_data($album)
	{
		$query 	= $this->buat_query($album);
		$data 	= $this->db->query($query);
		return $data->num_rows();
	}

	public function gabung_data($offset, $limit, $album)
	{
		$query = $this->buat_query($album);
		$query .= ' LIMIT '.$offset.', ' .$limit;
		$data = $this->db->query($query);

		$hasil = '';
		if ($data->num_rows() > 0) {
		foreach ($data->result() as $row) {
				$file = file_exists('uploads/galeri/'.$row->slug_album.'/'.$row->foto_galeri);
				if ($file && !empty($row->foto_galeri)) {
					$src = base_url('uploads/galeri/'.$row->slug_album.'/'.$row->foto_galeri);
				}else{
					$src = base_url('dists/images/no-img.png');
				}
				$hasil .= '
				<div class="col-md-5 col-md-offset-1 col-sm-6 col-xs-12 text-center">
					<div class="staff">						
						<a href="'.$src.'" class="galeri" data-sub-html="#kapsion'.$row->id_galeri.'">
							<img src="'. $src .'" class="staff-img img-fluid img-rounded">
						</a>
						<div class="desc" id="kapsion'.$row->id_galeri.'">
							<h4>'. $row->nama_galeri .'</h4>
							<p>'. $row->nama_album .'</p>
						</div>
					</div>
				</div>
				';
			}
		}else{
			$hasil = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">
					<i class="ace-icon fa fa-times"></i>
				</button>

				<strong>
					<i class="ace-icon fa fa-times"></i>
					Oops...!
				</strong>
					Data tidak ditemukan.
				<br />
			</div>
			';
		}

		return $hasil;
	}

}

/* End of file Galeri_model.php */
/* Location: ./application/models/Galeri_model.php */

 ?>