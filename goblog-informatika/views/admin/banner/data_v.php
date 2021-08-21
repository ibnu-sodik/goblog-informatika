<link href="<?= base_url() ?>dists/summernote/summernote.css" rel="stylesheet">
<link href="<?= base_url() ?>dists/dropify/dropify.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>dists/css/colorbox.min.css" />

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

<a href="#" class="btn btn-primary tombol-layang tombol-modal" data-toggle="modal" data-target="#addModal"><i class="fa fa-fw fa-plus fa-1x"></i></a>

<div class="col-md-12 col-xl-12 col-sm-12">
	<!-- <div> -->
		<ul class="ace-thumbnails clearfix">
			<?php foreach ($data_banner->result() as $row): ?>	
				<li>
					<div>
						<?php if (file_exists('uploads/banner/'.$row->gambar_banner) && !empty($row->gambar_banner)): ?>
						<img width="200" height="200" alt="<?= $row->judul_banner ?>" src="<?= base_url('uploads/banner/'.$row->gambar_banner) ?>" /><?php else: ?>
						<img width="200" height="200" alt="<?= $row->judul_banner ?>" src="<?= base_url('dists/images/no-img.png') ?>" />
					<?php endif ?>
					<div class="text">
						<div class="inner">
							<span><?= $row->judul_banner ?></span>

							<br />
							<?php if (file_exists('uploads/banner/'.$row->gambar_banner) && !empty($row->gambar_banner)): ?>
							<a href="<?= base_url('uploads/banner/'.$row->gambar_banner) ?>" data-rel="colorbox"><?php else: ?>
							<a href="<?= base_url('dists/images/no-img.png') ?>" data-rel="colorbox">
							<?php endif; ?>
							<i class="ace-icon fa fa-search-plus"></i>
						</a>

						<a class="edit-banner" href="javascript:void(0)" title="Edit" 
						data-id="<?= $row->id_banner ?>" data-judul="<?= $row->judul_banner ?>" data-konten="<?= sanitize($row->konten_banner) ?>" data-gambar="<?= $row->gambar_banner ?>" >
						<i class="ace-icon fa fa-edit"></i>
					</a>

					<a href="<?= site_url('admin/banner/hapus/'.$row->id_banner) ?>" class="tombol-hapus" title="Hapus">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>
			<div class="tags">
				<?php if($row->status_aktif == 1): ?>
					<a href="<?= site_url('admin/banner/inactive/'.$row->id_banner); ?>">
						<span class="label-holder">
							<span class="label label-info">Tampil Awal</span>
						</span>
					</a>
					<?php else: ?>
						<a href="<?= site_url('admin/banner/active/'.$row->id_banner); ?>">
							<span class="label-holder">
								<span class="label label-danger">Tampil Normal</span>
							</span>
						</a>
					<?php endif; ?>

				</div>
			</div>
		</li>			
	<?php endforeach ?>
</ul>
<!-- </div> -->
</div>

<!-- modal add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalCategory" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Tambah Banner</h4>
			</div>
			<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=site_url('admin/banner/simpan')?>">
				<div class="modal-body">
					<div class="form-group">
						<label for="gambar_banner" class="col-sm-3 control-label no-padding-right">Gambar Banner</label>
						<div class="col-sm-9">
							<input type="file" name="filefoto" id="gambar_banner" data-height="200" required class="dropify">
						</div>
					</div>
					<div class="form-group">
						<label for="judul_banner" class="col-sm-3 control-label no-padding-right">Judul Banner</label>
						<div class="col-sm-9">
							<input type="text" name="judul_banner" id="judul_banner" placeholder="Judul Banner" class="form-control" autofocus>
						</div>
					</div>
					<div class="form-group">
						<label for="konten_banner" class="col-sm-3 control-label no-padding-right">Konten Banner</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="konten_banner" id="summernote2"><?= set_value('konten_banner') ?></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalCategory" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Edit Banner</h4>
			</div>
			<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?=site_url('admin/banner/update')?>">
				<div class="modal-body">
					<div class="form-group">
						<label for="gambar_banner" class="col-sm-3 control-label no-padding-right">Gambar Banner</label>
						<div class="col-sm-3">
							<img src="" id="pict" class="img-thumbnail img-responsive" style="height: 215px;">
						</div>
						<div class="col-sm-6">
							<input type="file" name="filefoto" id="gambar_banner" data-height="200" class="dropify">
						</div>
					</div>
					<div class="form-group">
						<label for="judul_banner2" class="col-sm-3 control-label no-padding-right">Judul Banner</label>
						<div class="col-sm-9">
							<input type="text" name="judul_banner2" id="judul_banner2" placeholder="Judul Banner" class="form-control" autofocus>
						</div>
					</div>
					<div class="form-group">
						<label for="konten_banner2" class="col-sm-3 control-label no-padding-right">Konten Banner</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="konten_banner2" id="summernote3"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id_banner">
					<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="<?= base_url() ?>dists/js/jquery.colorbox.min.js"></script>
<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
<script src="<?= base_url() ?>dists/summernote/summernote.js"></script>
<script src="<?= base_url() ?>dists/summernote/lang/summernote-id-ID.js"></script>
<script src="<?= base_url() ?>dists/js/form.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		$('.edit-banner').on('click', function() {
			var id = $(this).data('id');
			var judul = $(this).data('judul');
			var konten = $(this).data('konten');
			var gambar = $(this).data('gambar');

			$('[name="id_banner"]').val(id);
			$('[name="judul_banner2"]').val(judul);
			$('#summernote3').summernote('code', konten);				
			$("#pict").attr("src", "<?= base_url('uploads/banner/') ?>"+gambar);

			$('#editModal').modal('show');
		})
	})
	$('#summernote2').summernote({
		lang: 'id-ID',
		height : 200,
		onImageUpload : function(files, editor, welEditable) {
			sendFile(files[0], editor, welEditable);
		}
	});
	$('#summernote3').summernote({
		lang: 'id-ID',
		height : 200,
		onImageUpload : function(files, editor, welEditable) {
			sendFile(files[0], editor, welEditable);
		}
	});
</script>