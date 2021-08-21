<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />

<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $bg_artikel ?>);">
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
		<div class="animate-box fadeInUp animated-fast"></div>
		<div class="row" id="galeriKu">
			<?php foreach($artikel->result() as $row): ?>
				<div class="col-lg-4 col-md-4">
					<div class="fh5co-blog animate-box fadeInUp animated-fast">
						<a href="<?= base_url('uploads/artikel/'.$row->gambar_artikel) ?>" class="blog-img-holder" style="background-image: url(<?= base_url('uploads/artikel/'.$row->gambar_artikel) ?>);">
							<img src="<?= base_url('uploads/artikel/'.$row->gambar_artikel) ?>" style="display: none;">
						</a>
						<div class="blog-text">
							<h3>
								<a title="<?= $row->judul_artikel ?>" href="<?= site_url('artikel/'.$row->slug_artikel) ?>"><?= $row->judul_artikel ?></a>
							</h3>							
							<span class="posted_on">
								<i class="fa fa-calendar"></i> <?= tanggal_indo($row->tanggal_up_artikel) ?>
								&nbsp;
								<a class="text-muted" href="<?= site_url('kategori/'.$row->slug_kategori) ?>" title="Kategori <?= $row->nama_kategori ?>">
										<i class="fa fa-tag"></i> <?= $row->nama_kategori ?>
									</a>
							</span>
							<p><?= strip_tags(word_limiter($row->konten_artikel, 15)) ?></p>
						</div> 
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
			selector: '.blog-img-holder',
			counter:true,
			html:true 
		});
	});
</script>