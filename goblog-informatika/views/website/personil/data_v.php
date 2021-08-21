<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />

<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $bg_personil ?>);">
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
		<div class="row" id="galeriKu">
			<?php 
			foreach ($personil->result() as $row):
				$file = file_exists(base_url('./uploads/personil/'.$row->foto));
				if (!$file && empty($row->foto)) {
					$src = get_gravatar($row->email);
					// $src = base_url('dists/images/no-img.png');
				}else{
					$src = base_url('./uploads/personil/'.$row->foto);
				}
				?>				
				<div class="col-md-3 text-center">
					<div class="staff">
						<a href="<?= $src ?>" class="item">
							<img src="<?= $src ?>" class="staff-img img-fluid img-circle">
						</a>
						<span><?= $row->jenis_fungsi ?></span>
						<h3>
							<a href="<?= site_url('personil/'.$row->username) ?>"><?= $row->full_name ?></a>
						</h3>
						<p><?= strip_tags(word_limiter($row->personil_info, 30)) ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="text-center">
			<?= $pagination ?>
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
		$("#galeriKu").lightGallery({
			selector: '.item',
			counter:true,
			html:true 
		});
	});

	var owl = $('.owl-carousel');
	owl.owlCarousel({
		items:1,
		loop:true,
		margin:10,
		autoHeight:true,
		autoplay:true,
		autoplayTimeout:5000,
		autoplayHoverPause:true
	});
</script>