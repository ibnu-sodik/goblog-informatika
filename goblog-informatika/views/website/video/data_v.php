<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lg-video.css') ?>">

<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $bg_umum ?>);">
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

<?php 
?>
<div id="fh5co-staff">
	<div class="container">
		<div class="row" id="galeriKu">
			<?php 
			foreach ($video->result() as $row):
				$youtubeID = getYouTubeVideoId($row->link_video);
				$thumbURL = 'https://img.youtube.com/vi/' . $youtubeID . '/mqdefault.jpg';
				?>				
				<div class="col-md-6 col-sm-3 text-center">
					<div class="services">
						<a href="<?= $row->link_video ?>" class="item" data-sub-html="#kapsion<?= $row->id_video ?>">
							<img src="<?= $thumbURL ?>" class="img-fluid img-thumbnail">
							<div class="play-button">
								<img class="play-but" src="<?= base_url('assets/images/play-button.png') ?>">
							</div>
						</a>						
					</div>
					<a href="<?= site_url('video/'.$row->slug_video) ?>">
						<h4 id="kapsion<?= $row->id_video ?>"><?= $row->nama_video ?></h4>
					</a>
					<p><?= word_limiter($row->deskripsi_video, 15) ?></p>
				</div>
			<?php endforeach ?>
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
</script>