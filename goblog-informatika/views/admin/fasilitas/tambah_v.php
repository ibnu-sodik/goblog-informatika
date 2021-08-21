<link href="<?= base_url() ?>dists/dropify/dropify.min.css" rel="stylesheet">

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
	<form class="form-horizontal" method="POST" action="<?= $form_action ?>" enctype="multipart/form-data" role="form">
		<div class="col-md-8 col-xs-12">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="nama_fasilitas">Nama Fasilitas</label>
				<div class="col-sm-9">
					<input type="text" name="nama_fasilitas" id="nama_fasilitas" class="form-control" placeholder="Nama Fasilitas" value="<?= set_value('nama_fasilitas') ?>">
					<?= form_error('nama_fasilitas'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="deskripsi_fasilitas">Deskripsi Fasilitas</label>
				<div class="col-sm-9">
					<textarea class="form-control" rows="5" placeholder="Deskripsi Fasilitas" id="deskripsi_fasilitas" name="deskripsi_fasilitas"><?= set_value('deskripsi_fasilitas') ?></textarea>
					<?= form_error('deskripsi_fasilitas'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="gambar_fasilitas">Gambar Fasilitas</label>
				<div class="col-sm-9">
					<input type="file" name="filefoto" id="gambar_fasilitas" class="form-control dropify" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" for="ikon_fasilitas">Ikon Fasilitas</label>
				<div class="col-sm-9">
					<div class="input-group">
						<input type="text" name="ikon_fasilitas" id="ikon_fasilitas" class="form-control" placeholder="fa fa-nama-ikon" value="" data-rel="tooltip" >
						<span style="cursor: pointer;" class="input-group-addon" data-toggle="modal" data-target="#modalPetunjuk">?</span>
					</div>
					<?= form_error('ikon_fasilitas'); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" aria-hidden="true"></label>
				<div class="col-sm-9">
					<button type="submit" class="btn-block btn-primary btn">Simpan <i class="fa fa-send"></i></button>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- modal add -->
<div class="modal fade" id="modalPetunjuk" tabindex="-1" role="dialog" aria-labelledby="modalCategory" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Cara Menggunakan Font Awesome</h4>
			</div>
			<div class="modal-body">
				<div class="text-justify">
					<ol>
						<li>Kunjungi website resmi <a href="https://fontawesome.com/icons?d=gallery&p=2" target="_blank">Font Awesome</a></li>
						<li>Cari ikon dengan kata kunci yang sesuai</li>
						<li>Pilih ikon dengan cara menyeleksi kata lalu copy</li>
						<li>Kembali ke halaman ini</li>
						<li>Ketik kata <strong class="bg-info">fa </strong> lalu pastekan nama ikon yang telah anda copy</li>
						<li>Contoh hasil jadi <strong class="bg-info">fa fa-bank</strong> akan menghasilkan ikon seperti ini <i class="fa fa-bank"></i></li>
						<li><strong class="bg-info">fa</strong> spasi <strong class="bg-info">fa-nama-ikon</strong></li>
					</ol>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
<script type="text/javascript">
	$('.dropify').dropify({
		messages: {
			default: 'Gambar Fasilitas...',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'error'
		}
	});
</script>