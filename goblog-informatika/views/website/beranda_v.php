<?php 
$set_hp = $data_homepage->row();
?>
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />
<link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/lg-video.css') ?>" />

<?php if($data_banner->num_rows() > 0): ?>
	<aside id="fh5co-hero">
		<div class="flexslider">
			<ul class="slides">
				<?php foreach ($data_banner->result() as $row): ?>
					<li style="background-image: url(<?= base_url('uploads/banner/'.$row->gambar_banner) ?>);">
						<div class="overlay-gradient"></div>
						<div class="container">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 text-center slider-text">
									<div class="slider-text-inner">
										<?php if (isset($row->judul_banner)): ?>
											<h1><?= $row->judul_banner; ?></h1>
										<?php endif; ?>
										<?php if (isset($row->konten_banner)): ?>
											<h2><?= $row->konten_banner; ?></h2>	
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</aside>
<?php endif; ?>

<?php 
if($set_hp->hp_sambutan == 1):
	if($data_sambutan->num_rows() > 0):
		foreach($data_sambutan->result() as $row):
			$src = base_url('uploads/background/'.$row->gambar_sambutan);
			?>

			<div id="fh5co-course-categories">
				<div id="salam-pembuka"></div>
				<div class="container">
					<div class="row animate-box">
						<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
							<h2>Salam Pembuka</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5 col-sm-6 text-center animate-box">
							<div class="services">
								<img src="<?= $src ?>" class="img-responsive img-rounded">
							</div>
						</div>
						<div class="col-md-7 col-sm-6 animate-box text-justify">
							<?= $row->konten_sambutan; ?>
						</div>
					</div>
				</div>
			</div>
			<?php 
		endforeach;
	endif;
endif;
?>

<?php
if($set_hp->hp_fasilitas == 1):
	if($data_fasilitas->num_rows() > 0):
		$jumlah = $data_fasilitas->num_rows();
		?>
		<div id="fh5co-course-categories">
			<div class="container">
				<div class="row animate-box">
					<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
						<h2>Ada apa di <?= $site_name ?></h2>
						<p><?= $jumlah ?> alasan mengapa kamu harus memilih <?= $site_name; ?></p>
					</div>
				</div>
				<div class="row" id="galeriKu">
					<?php 
					foreach($data_fasilitas->result() as $row):
						$src_asli 	= base_url('uploads/fasilitas/'.$row->gambar_fasilitas);
						$src 		= base_url('uploads/fasilitas/thumbs/'.$row->gambar_fasilitas);
						?>
						<div class="col-md-3 col-sm-6 text-center animate-box">
							<div class="services">
								<a href="<?= $src_asli; ?>" class="galeri" data-sub-html="#kapsion<?= $row->id_fasilitas ?>">
									<img src="<?= $src ?>" class="img-fluid img-circle img-thumbnail">
								</a>
								<div class="desc" id="kapsion<?= $row->id_fasilitas ?>">
									<h4><?= $row->nama_fasilitas ?></h4>
									<p><?= $row->deskripsi_fasilitas ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<?php 
	endif;
endif;
?>

<?php if($data_berita->num_rows() > 0): ?>
	<div id="fh5co-course" style="background-image: url(<?= base_url('assets/images/img_bg_4.jpg') ?>);">
		<div class="overlay"></div>
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
					<h2>Berita</h2>
				</div>
			</div>
			<div class="row" id="galeriBerita">
				<?php foreach($data_berita->result() as $row): ?>
					<div class="col-md-5 col-md-offset-1 animate-box">
						<div class="course">
							<a href="<?= base_url('uploads/berita/'.$row->gambar_berita) ?>" class="course-img" style="background-image: url(<?= base_url('uploads/berita/'.$row->gambar_berita) ?>);">
								<img src="<?= base_url('uploads/berita/'.$row->gambar_berita) ?>" style="display: none;">
							</a>
							<div class="desc">
								<h3><a href="<?= site_url('berita/'.$row->slug_berita) ?>"><?= $row->nama_berita; ?></a></h3>
								<p><?= word_limiter($row->konten_berita, 25); ?></p>

								<span><a href="<?= site_url('berita/'.$row->slug_berita) ?>" class="btn btn-primary btn-sm btn-course">Baca</a></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if($data_berita->num_rows() >= $limit_post): ?>	
				<div class="text-center">				
					<a href="<?= site_url('berita') ?>" class="btn btn-primary animate-box btn-course">Lihat Berita</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<?php if($data_agenda->num_rows() > 0 or $data_artikel->num_rows() > 0): ?>
<div id="fh5co-blog">
	<div class="container">
		<div class="row animate-box">
			<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
				<h2>Agenda &amp; Artikel</h2>
			</div>
		</div>

		<?php if($data_agenda->num_rows() > 0): ?>
			<div class="row">
				<?php foreach ($data_agenda->result() as $row): ?>
					<div class="col-md-4 animate-box">
						<div class="fh5co-event">
							<div class="date text-center"><span><?= $row->tanggal ?><br><?= bulan_indo($row->bulan) ?></span></div>
							<h3>
								<?= $row->nama_agenda ?>								
							</h3>
							<p><?= strip_tags(word_limiter($row->konten_agenda, 30)) ?></p>
							<p><a href="<?= site_url('agenda/'.$row->slug_agenda) ?>">Selengkapnya...</a></p>
						</div>
					</div>			
				<?php endforeach; ?>
			</div>
			<?php if($data_agenda->num_rows() >= $limit_post): ?>
				<div class="text-center">				
					<a href="<?= site_url('agenda') ?>" class="btn btn-primary animate-box">Semua Agenda</a>
				</div>
				<hr>
			<?php endif; ?>
		<?php endif; ?>

		<?php if($data_artikel->num_rows() > 0): ?>
			<div class="row" id="galeriArtikel">
				<?php foreach($data_artikel->result() as $row): ?>
					<div class="col-lg-4 col-md-4">
						<div class="fh5co-blog animate-box">
							<a href="<?= base_url('uploads/artikel/'.$row->gambar_artikel) ?>" style="background-image: url(<?= base_url('uploads/artikel/'.$row->gambar_artikel); ?>)" class="blog-img-holder">
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
			<?php if($data_artikel->num_rows() >= $limit_post): ?>
				<div class="text-center">				
					<a href="<?= site_url('artikel') ?>" class="btn btn-primary animate-box">Semua Artikel</a>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>

<?php 
if($set_hp->hp_testimoni == 1):
	if($data_testimoni->num_rows() > 0):
		?>
		<div id="fh5co-testimonial" style="background-image: url(<?= base_url('uploads/background/'.$background->bg_umum) ?>);">
			<div class="overlay"></div>
			<div class="container">
				<div class="row animate-box">
					<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
						<h2><span>Apa Kata Mereka</span></h2>
					</div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="row animate-box">
							<div class="owl-carousel owl-carousel-fullwidth">
								<?php 
								foreach ($data_testimoni->result() as $row):
									$thumb = base_url('uploads/testimoni/thumbs/'.$row->foto_testimoni);
									?>
									<div class="item">
										<div class="testimony-slide active text-center">
											<div class="user" style="background-image: url(<?= $thumb ?>);"></div>
											<span><?= $row->nama_testimoni ?></span>
											<small><?= $row->profesi_testimoni ?></small>
											<blockquote>
												<p>&ldquo;<?= $row->konten_testimoni ?>&rdquo;</p>
											</blockquote>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
	endif;
endif;
?>

<?php if($set_hp->hp_video == 1): ?>
	<div id="fh5co-course-categories">
		<div class="container">
			<div class="row animate-box">
				<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
					<h2><?= $site_name ?> Official</h2>
					<p>Saluran YouTube Resmi <?= $site_name ?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 text-center animate-box">
					<div class="services">
						<h3 class="text-left">Video Terbaru <?= $site_name ?></h3>
						<?php foreach ($video_baru->result() as $row): ?>						
							<div class="responsive-iframe">
								<iframe title="" width="100%" height="281" src="<?= getYoutubeEmbedUrl($row->link_video) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
							</div>
						<?php endforeach ?>
					</div>
				</div>
				<div class="col-md-6 text-center animate-box">
					<div class="services">
						<h3 class="text-left">Video Hits Milik <?= $site_name ?></h3>
						<?php foreach ($video_populer->result() as $row): ?>				
							<div class="responsive-iframe">
								<iframe title="CAKRA LOKA &quot;Kiprah Lembaga Penelitian dan Pengabdian Kepada Masyarakat (LP2M) UM&quot;" width="100%" height="281" src="<?= getYoutubeEmbedUrl($row->link_video) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

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

	$(document).ready(function() {
		$("#galeriKu").lightGallery({
			selector: '.galeri',
			counter:true,
			html:true 
		}); 
		$("#galeriBerita").lightGallery({
			selector: '.course-img',
			counter:true,
			html:true 
		}); 
		$("#galeriArtikel").lightGallery({
			selector: '.blog-img-holder',
			counter:true,
			html:true 
		}); 
	});
</script>