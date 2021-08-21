<?php 
foreach($data_bg->result() as $row){
	$bg_umum 		= base_url('uploads/background/'.$row->bg_umum);
	$bg_artikel 	= base_url('uploads/background/'.$row->bg_artikel);
	$bg_berita 		= base_url('uploads/background/'.$row->bg_berita);
	$bg_agenda 		= base_url('uploads/background/'.$row->bg_agenda);
	$bg_halaman 	= base_url('uploads/background/'.$row->bg_halaman);
	$bg_testimoni 	= base_url('uploads/background/'.$row->bg_testimoni);
	$bg_personil 	= base_url('uploads/background/'.$row->bg_personil);
	$bg_tentang 	= base_url('uploads/background/'.$row->bg_tentang);
	$bg_galeri 		= base_url('uploads/background/'.$row->bg_galeri);
}

$noImg = base_url('dists/images/no-img.png');
?>
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
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_umum">Background Utama</label>
				<div class="col-sm-9">
					<input type="file" name="bg_umum" id="bg_umum" class="dropify" data-default-file="<?= $bg_umum; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_artikel">Background Artikel</label>
				<div class="col-sm-9">
					<input type="file" name="bg_artikel" id="bg_artikel" class="dropify" data-default-file="<?= $bg_artikel; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_agenda">Background Agenda</label>
				<div class="col-sm-9">
					<input type="file" name="bg_agenda" id="bg_agenda" class="dropify" data-default-file="<?= $bg_agenda; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_berita">Background Berita</label>
				<div class="col-sm-9">
					<input type="file" name="bg_berita" id="bg_berita" class="dropify" data-default-file="<?= $bg_berita; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_halaman">Background Halaman</label>
				<div class="col-sm-9">
					<input type="file" name="bg_halaman" id="bg_halaman" class="dropify" data-default-file="<?= $bg_halaman; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_testimoni">Background Testimoni</label>
				<div class="col-sm-9">
					<input type="file" name="bg_testimoni" id="bg_testimoni" class="dropify" data-default-file="<?= $bg_testimoni; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_personil">Background Personil</label>
				<div class="col-sm-9">
					<input type="file" name="bg_personil" id="bg_personil" class="dropify" data-default-file="<?= $bg_personil; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_tentang">Background Tentang</label>
				<div class="col-sm-9">
					<input type="file" name="bg_tentang" id="bg_tentang" class="dropify" data-default-file="<?= $bg_tentang; ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="bg_galeri">Background Galeri</label>
				<div class="col-sm-9">
					<input type="file" name="bg_galeri" id="bg_galeri" class="dropify" data-default-file="<?= $bg_galeri; ?>" />
				</div>
			</div>
		</div>

		<div class="col-md-4 col-sm-6 col-xs-12">			
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" aria-hidden="true"></label>
				<div class="col-sm-9">
					<button type="submit" name="submit" class="btn btn-block btn-primary">Simpan <i class="fa fa-send"></i></button>
				</div>
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