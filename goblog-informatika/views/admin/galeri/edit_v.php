<?php 
$row = $data_galeri->row_array();
$data_album = $this->db->query("SELECT * FROM tb_album WHERE id_album = '$row[id_album_galeri]'")->row_array();

$file = base_url('uploads/galeri/'.$data_album['slug_album'].'/'.$row['foto_galeri']);

if ($file) {
	$src = base_url('uploads/galeri/'.$data_album['slug_album'].'/'.$row['foto_galeri']);
} else {
	$src = base_url('dists/images/no-img.png');
}
?>
<link href="<?= base_url() ?>dists/dropify/dropify.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>dists/css/select2.min.css" />
<div class="page-header">
	<h1>
		<a href="javascript:void(0)" onclick="kembali()"><span class="label label-lg label-primary arrowed">Kembali</span></a>
		<?= $bc_aktif; ?>
		<?php if (isset($sm_text)): ?>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?= $sm_text; ?>
			</small>			
		<?php endif ?>
	</h1>
</div>

<div class="row">
	<form class="form-horizontal" method="POST" enctype="multipart/form-data" role="form" action="<?= $form_action_edit.'/'.$row['id_galeri']; ?>">
		<div class="col-md-8 col-xs-12">
			<div class="form-group">
				<label for="gambar_galeri" class="col-sm-3 control-label no-padding-right">Gambar</label>
				<div class="col-sm-9">
					<input type="file" name="filefoto" id="gambar_galeri" data-height="200" class="dropify" data-default-file="<?= $src; ?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="nama_galeri" class="col-sm-3 control-label no-padding-right">Judul</label>
				<div class="col-sm-9">
					<input type="text" name="nama_galeri" id="nama_galeri" value="<?= $row['nama_galeri'] ?>" placeholder="Judul" class="form-control" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="id_album">Album</label>
				<div class="col-sm-9">
					<select name="id_album" class="form-control select2">
						<option value="">--- Pilih Album ---</option>
						<?php 
						foreach ($fil_album->result() as $row2):
							if ($row2->id_album == $row['id_album_galeri']) {
								$cek = "selected";
							}else{
								$cek = "";
							}
							?>
							<option value="<?= $row2->id_album ?>" <?= $cek ?>><?= $row2->nama_album ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3 no-padding-right"></label>
				<div class="col-sm-9">
					<button type="submit" name="submit" class="btn btn-block btn-primary">Publish <i class="fa fa-send"></i></button>
				</div>
			</div>
		</div>
	</form>
</div>
<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
<script src="<?= base_url() ?>dists/js/select2.min.js"></script>
<script type="text/javascript">
	$('.dropify').dropify({
		messages: {
			default: 'Drag atau drop gambar disni',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'error'
		}
	});

	$(".select2").select2({
    	width: '100%', // need to override the changed default
    	theme: "classic"
    });
</script>