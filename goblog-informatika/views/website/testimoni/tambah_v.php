<link href="<?= base_url() ?>dists/dropify/dropify.min.css" rel="stylesheet">

<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $bg_testimoni ?>);" >
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
			<div class="col-md-6">
				<div id="fh5co-testimonial" style="background-image: url(<?= $bg_umum ?>); background-repeat: no-repeat; background-position: center;">
				<div class="overlay"></div>
				<div class="container">
					<div class="row">
						<?php if ($data_testimoni->num_rows() > 0): ?>
							<div class="col-md-6">
								<div class="row animate-box">
									<div class="text-center fh5co-heading">
										<h2><span>Kata Mereka</span></h2>
									</div>
								</div>
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
						<?php endif ?>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="animate-box text-center fadeInUp animated-fast">
				<form enctype="multipart/form-data" action="<?= $form_action ?>" method="post">
					<div class="row form-group">
						<div class="col-md-12">
							<input type="file" name="filefoto" class="dropify" required>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<input type="text" name="nama_testimoni" autocomplete="off" class="form-control" placeholder="Nama Lengkap" value="<?= set_value('nama_testimoni'); ?>">
							<?= form_error('nama_testimoni'); ?>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<input type="text" name="profesi_testimoni" autocomplete="off" class="form-control" placeholder="Profesi Anda" value="<?= set_value('profesi_testimoni') ?>">
							<?= form_error('profesi_testimoni'); ?>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12" id="hitung">
							<textarea name="konten_testimoni" id="konten_testimoni" rows="4" class="form-control" placeholder="Tulis ulasan anda kepada kami..."><?= set_value('konten_testimoni') ?></textarea>
							<?= form_error('konten_testimoni'); ?>
							<p id="pesan"></p>
							Total karakter : <span id="current_count">0</span>
							<span id="maximum_count">/ 200</span>

						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Kirim <i class="fa fa-send"></i></button>
					</div>

				</form>	
			</div>
		</div>
	</div>
</div>
</div>



<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
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

		$("#owl-testimoni").owlCarousel({
			center: true,
			items:2,
			loop:true,
			margin:10,
		});

	});

	var maks_char = 200;
	$('#konten_testimoni').keyup(function(e) {    
		var characterCount = $(this).val().length,
		current_count = $('#current_count'),
		maximum_count = $('#maximum_count'),
		count = $('#hitung');    
		current_count.text(characterCount);
		if (characterCount > maks_char) {
			$('#pesan').html('<span class="text-danger">Batas karakter telah dicapai.</span>');
			return false;
		}      
	});

	$('.dropify').dropify({
		messages: {
			default: 'Foto profil anda',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'error'
		}
	});
</script>