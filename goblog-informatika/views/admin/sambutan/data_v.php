<?php
$data = $data_sambutan->row();
$src = base_url('uploads/background/'.$data->gambar_sambutan);
?>

<link href="<?= base_url() ?>dists/summernote/summernote.css" rel="stylesheet">
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
	<form class="form-horizontal" method="POST" enctype="multipart/form-data" role="form" action="<?= $form_action.'/'.$data->id_sambutan; ?>">
		<div class="col-md-4 col-xs-12">
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="gambar_sambutan">Gambar Kontak</label>
				<div class="col-sm-9">
					<input type="file" name="filefoto" id="gambar_sambutan" class="dropify" data-height="300" data-default-file="<?= $src ?>" />
				</div>
			</div>
		</div>
		<div class="col-md-8 col-xs-12">
			<div class="form-group">
				<label class="col-sm-3 no-padding-right control-label" for="konten_sambutan">Konten Kontak
					<?= form_error('konten_sambutan') ?>
				</label>
				<div class="col-sm-9">
					<textarea name="konten_sambutan" class="form-control" id="konten_sambutan"><?= $data->konten_sambutan ?></textarea>
					<button type="submit" name="submit" class="btn btn-block btn-primary">Update <i class="fa fa-send"></i></button>
				</div>
			</div>
		</div>
	</form>
</div>

<script src="<?= base_url() ?>dists/summernote/summernote.js"></script>
<script src="<?= base_url() ?>dists/summernote/lang/summernote-id-ID.js"></script>
<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
<script type="text/javascript">
	
	$('.dropify').dropify({
		messages: {
			default: 'Tarik file disini...',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'error'
		}
	});

	$('#konten_sambutan').summernote({
		lang: 'id-ID',
		height : 500,
		placeholder: 'Tulis kata sambutan...',
		onImageUpload : function(files, editor, welEditable) {
			sendFile(files[0], editor, welEditable);
		}
	});

	function sendFile(file, editor, welEditable) {
		data = new FormData();
		data.append("file", file);
		$.ajax({
			data: data,
			type: "POST",
			url: "<?= site_url('admin/artikel/upload_image') ?>",
			cache: false,
			contentType: false,
			processData: false,
			success: function(url){
				editor.insertImage(welEditable, url);
			}
		});
	}
</script>