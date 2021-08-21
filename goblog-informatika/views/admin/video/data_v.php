<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lg-video.css') ?>">

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
	<div class="col-md-5">
		<form class="form-horizontal" role="form" method="POST" action="<?= $form_action ?>">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="link_video"> Link Video </label>

				<div class="col-sm-9">
					<input type="text" id="link_video" name="link_video" placeholder="Url" class="form-control" value="<?= set_value('link_video') ?>" />
					<?php echo form_error('link_video') ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="nama_video"> Judul Video </label>

				<div class="col-sm-9">
					<input type="text" id="nama_video" name="nama_video" placeholder="Judul Video" class="form-control judul"  value="<?= set_value('nama_video') ?>"/>
					<?php echo form_error('nama_video') ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right"></label>

				<div class="col-sm-9">
					<input type="text" id="slug" name="slug" placeholder="Permalink" class="form-control slug" readonly />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="deskripsi_video"> Deskripsi Video</label>

				<div class="col-sm-9">
					<textarea class="form-control" rows="6" name="deskripsi_video" id="deskripsi_video" placeholder="Deskripsi Video"><?= set_value('deskripsi_video') ?></textarea>
					<?php echo form_error('deskripsi_video') ?>
				</div>
			</div>

			<div class="clearfix form-actions">
				<div class="col-md-offset-3 col-md-9">
					<button class="btn btn-info" type="submit">
						<i class="ace-icon fa fa-check bigger-110"></i>
						Submit
					</button>

					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="reset">
						<i class="ace-icon fa fa-undo bigger-110"></i>
						Reset
					</button>
				</div>
			</div>
		</form>
	</div>

	<div class="col-md-7">
		<div class="row" id="galeriKu">
			<?php 
			foreach ($data_video->result() as $row):
				$youtubeID = getYouTubeVideoId($row->link_video);
				$thumbURL = 'https://img.youtube.com/vi/' . $youtubeID . '/mqdefault.jpg';
				?>
				<div class="col-xs-12 col-sm-6 widget-container-col ui-sortable" id="widget-container-col-1">
					<div class="widget-box ui-sortable-handle" id="widget-box-1">
						<div class="widget-header">
							<h5 class="widget-title"><?= word_limiter($row->nama_video, 5) ?></h5>

							<div class="widget-toolbar">

								<a href="javascript:void(0)" class="green tombol-edit" data-id = "<?= $row->id_video ?>" data-nama = "<?= $row->nama_video ?>" data-link = "<?= $row->link_video ?>" data-deskripsi = "<?= $row->deskripsi_video ?>" data-slug="<?= $row->slug_video ?>">
									<i class="ace-icon fa fa-edit"></i>
								</a>

								<a href="#" data-action="collapse">
									<i class="ace-icon fa fa-chevron-up"></i>
								</a>

								<a class="tombol-hapus red" href="<?= site_url('admin/video/hapus/'.$row->id_video) ?>">
									<i class="ace-icon fa fa-times"></i>
								</a>
							</div>
						</div>

						<div class="widget-body">
							<div class="widget-main">
								<div class="services text-center">
									<a href="<?= $row->link_video ?>" class="item" data-sub-html="#kapsion<?= $row->id_video ?>">
										<img src="<?= $thumbURL ?>" class="img-fluid">
										<div class="play-button">
											<img class="play-but" src="<?= base_url('assets/images/play-button.png') ?>">
										</div>
									</a>
								</div>
							</div>
						</div>
						<div class="widget-footer">
							<div class="widget-main">
								<p>
									<?= word_limiter($row->deskripsi_video, 15); ?>
								</p>
							</div>						
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
		<div class="text-center">
			<?= $pagination ?>
		</div>
	</div>

</div>

<!-- modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalVideo" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Edit Video</h4>
			</div>
			<form class="form-horizontal" method="post" action="<?=site_url('admin/video/update')?>">
				<div class="modal-body">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="link_video2"> Link Video </label>

						<div class="col-sm-9">
							<input type="text" id="link_video2" name="link_video2" placeholder="Url" class="form-control" value="<?= set_value('link_video2') ?>" />
							<?php echo form_error('link_video2') ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="nama_video2"> Judul Video </label>

						<div class="col-sm-9">
							<input type="text" id="nama_video2" name="nama_video2" placeholder="Judul Video" class="form-control judul"  value="<?= set_value('nama_video2') ?>"/>
							<?php echo form_error('nama_video2') ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right"></label>

						<div class="col-sm-9">
							<input type="text" id="slug" name="slug2" placeholder="Permalink" class="form-control slug" readonly />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="deskripsi_video2"> Deskripsi Video</label>

						<div class="col-sm-9">
							<textarea class="form-control" rows="6" name="deskripsi_video2" id="deskripsi_video2" placeholder="Deskripsi Video"><?= set_value('deskripsi_video2') ?></textarea>
							<?php echo form_error('deskripsi_video2') ?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id_video" required>
					<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>



<!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
<script src="<?= base_url('assets/light-gallery/lib/jquery.mousewheel.min.js') ?>"></script>

<script src="<?= base_url('assets/light-gallery/dist/js/lightgallery.min.js'); ?>"></script>

<!-- lightgallery plugins -->
<script src="<?= base_url('assets/light-gallery/modules/lg-autoplay.min.js'); ?>"></script>
<script src="<?= base_url('assets/light-gallery/modules/lg-share.min.js'); ?>"></script>
<script src="<?= base_url('assets/light-gallery/modules/lg-video.min.js'); ?>"></script>
<script src="<?= base_url('assets/light-gallery/modules/lg-zoom.min.js'); ?>"></script>
<script src="<?= base_url('assets/light-gallery/modules/lg-thumbnail.min.js'); ?>"></script>
<script src="<?= base_url('assets/light-gallery/modules/lg-fullscreen.min.js'); ?>"></script>

<script type="text/javascript">

	$('.tombol-edit').on('click', function(){
		var id 			= $(this).data('id');
		var nama 		= $(this).data('nama');
		var link 		= $(this).data('link');
		var slug 		= $(this).data('slug');
		var deskripsi 	= $(this).data('deskripsi');

		$('#editModal').modal('show');

		$('[name="id_video"]').val(id);
		$('[name="nama_video2"]').val(nama);
		$('[name="link_video2"]').val(link);
		$('[name="slug2"]').val(slug);
		$('[name="deskripsi_video2"]').val(deskripsi);
	});

	$(document).ready(function() {

		$("#galeriKu").lightGallery({
			selector: '.item',
			counter:true,
			html:true 
		});
	});
</script>