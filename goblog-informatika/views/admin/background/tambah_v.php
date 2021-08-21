<link href="<?= base_url() ?>dists/dropify/dropify.min.css" rel="stylesheet">

<div class="page-header">
	<h1>
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
	<form class="form-horizontal" method="POST" enctype="multipart/form-data" role="form" action="<?= $form_action; ?>">
		<div class="form-group">
			<label class="col-sm-3 no-padding-right control-label" for="bg_umum">Background Utama</label>
			<div class="col-sm-9">
				<input type="file" name="bg_umum" id="bg_umum" class="dropify" required />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 no-padding-right control-label" aria-hidden="true"></label>
			<div class="col-sm-9">
				<button type="submit" name="submit" class="btn btn-block btn-primary">Simpan <i class="fa fa-send"></i></button>
			</div>
		</div>

	</form>
</div>

<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
<script type="text/javascript">
	$('.dropify').dropify({
		maxFileSize 			: '2M',
		minWidth 				: '600',
		minHeight 				: '200',
		errorsPosition 			: 'outside',
		allowedFormats 			: 'landscape',
		allowedFileExtensions 	: 'jpg png jpeg',
		maxFileSizePreview 		: '2M',		
		messages: {
			default: 'Gambar akan dijadikan background halaman',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'Yuhuuu, ada yang salah nih.'
		},
		error: {
			'fileSize': 'Ukuran gambar terlalu besar ({{ value }} maksimal).',
			'minWidth': 'Lebar gambar terlalu kecil ({{ value }}}px minimal).',
			'maxWidth': 'Lebar gambar terlalu besar ({{ value }}}px maksimal).',
			'minHeight': 'Tinggi gambar terlalu rendah ({{ value }}}px minimal).',
			'maxHeight': 'Tinggi gambar terlalu berlebihan ({{ value }}px maksimal).',
			'imageFormat': 'Format gambar yang diizinkan adalah ({{ value }} hanya).'
		}
	});
</script>