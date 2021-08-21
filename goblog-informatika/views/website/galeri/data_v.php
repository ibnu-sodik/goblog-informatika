<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />

<style type="text/css">
	#loading
	{
		margin: auto;
		text-align:center; 
		z-index: 9999;
		-webkit-animation: lds-heart 1.2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
		animation: lds-heart 1.2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
		background: url(<?= base_url('assets/images/'.$site_logo) ?>) no-repeat center; 
		height: 150px;
	}
</style>

<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $bg_galeri ?>);">
				<div class="overlay-gradient"></div>
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-md-offset-2 text-center slider-text">
							<div class="slider-text-inner">
								<h1 class="heading-section"><?= $title ?></h1>
								<?php if (isset($sm_text)): ?>
									<h2 style="color: rgba(0, 0, 0, 0.1);"><?= $sm_text ?></h2>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</aside>

<div id="fh5co-staff">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<h3>Pilih album</h3>
				<?php foreach($fil_album->result() as $row): ?>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="album" class="fil_selector album ace ace-checkbox-2" value="<?= $row->id_album; ?>" />
							<span class="lbl"> <?= $row->nama_album; ?></span>
						</label>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="col-md-9">
				<div class="row" id="filter_data" style="overflow-x: hidden; overflow-y: auto; max-height: 100vh;">

				</div>
				<div class="text-center">
					<div id="pagination_link"></div>
				</div>
			</div>
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

	$(document).ready(function() {

		// $(document).on('click', '.staff', function(e) {
		// 	e.preventDefault();
		// 	$(".galeri").lightGallery({
		// 		selector: 'this',
		// 		counter:true,
		// 		html:true 
		// 	});
		// });

		filter_data(1);


		function filter_data(page)
		{
			$('#filter_data').html('<div id="loading"></div>');
			var action 	= 'get_data';
			var album 	= filtrasi('album');
			$.ajax({
				url : "<?= base_url('galeri/get_data/') ?>"+page,
				method : "POST",
				dataType : "JSON",
				data : {
					action : action,
					album : album
				},
				success : function(data)
				{
					$('#filter_data').html(data.daftar_galeri);
					$('#pagination_link').html(data.pagination_link);
					$('#filter_data').lightGallery({
						selector: '.galeri',
						counter:true,
						html:true 
					});
				}
			});
		}

		function filtrasi(class_name) {
			var filter = [];
			$('.' + class_name + ':checked').each(function() {
				filter.push($(this).val());
			});
			return filter;
		}

		$(document).on("click", ".pagination li a", function(event) {
			event.preventDefault();
			var page = $(this).data("ci-pagination-page");
			filter_data(page);
		});

		$('.fil_selector').click(function() {
			filter_data(1);
		});

	});
</script>