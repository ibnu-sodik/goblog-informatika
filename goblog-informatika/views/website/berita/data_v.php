<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />

<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $bg_berita ?>);">
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

<div id="fh5co-blog">
	<div class="container">
		<div class="row animate-box fadeInUp animated-fast"></div>
		<div class="row" id="galeriBerita">
			<?php foreach ($berita->result() as $row): ?>
				<div class="col-sm-5 col-sm-offset-1 animate-box fadeInUp animated-fast">
					<div class="course">
						<a href="<?= base_url('uploads/berita/'.$row->gambar_berita) ?>" class="course-img" style="background-image: url(<?= base_url('uploads/berita/'.$row->gambar_berita) ?>);">
							<img src="<?= base_url('uploads/berita/'.$row->gambar_berita) ?>" style="display: none;">
						</a>
						<div class="desc">
							<h3><a href="<?= site_url('berita/'.$row->slug_berita) ?>"><?= $row->nama_berita; ?></a></h3>
							<p><?= batasi_kata($row->konten_berita, 12); ?></p>
							<span>
								<a href="<?= site_url('berita/'.$row->slug_berita) ?>" class="btn btn-primary btn-sm btn-course">Baca</a>
							</span>
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
		$("#galeriBerita").lightGallery({
			selector: '.course-img',
			counter:true,
			html:true 
		}); 
	});
</script>