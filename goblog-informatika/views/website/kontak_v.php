<?php 
$data = $data_konten->row();
$src = base_url('uploads/background/'.$data->gambar_kontak);
?>

<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $src ?>);">
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

<div id="fh5co-contact">
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-md-push-1 animate-box">

				<?= $data->konten_kontak ?>

			</div>
			<div class="col-md-6 animate-box">
				<h3>Get In Touch</h3>
				<form action="<?= $form_action ?>" method="post">
					<div class="row form-group">
						<div class="col-md-12">
							<!-- <label for="fname">First Name</label> -->
							<input type="text" name="fname" id="fname" autocomplete="off" class="form-control" placeholder="Nama Depan" value="<?= set_value('fname'); ?>">
							<?= form_error('fname'); ?>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<!-- <label for="lname">Last Name</label> -->
							<input type="text" name="lname" id="lname" autocomplete="off" class="form-control" placeholder="Nama Belakang" value="<?= set_value('lname'); ?>">
							<?= form_error('lname'); ?>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<!-- <label for="email">Email</label> -->
							<input type="email" name="email" id="email" autocomplete="off" class="form-control" placeholder="Alamat Email" value="<?= set_value('email') ?>">
							<?= form_error('email'); ?>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<!-- <label for="subject">Subject</label> -->
							<input type="text" name="subject" id="subject" autocomplete="off" class="form-control" placeholder="Subjek Pesan" value="<?= set_value('subject') ?>">
							<?= form_error('subject'); ?>
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-12">
							<!-- <label for="message">Message</label> -->
							<textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Tulis sesuatu untuk kami..."><?= set_value('message') ?></textarea>
							<?= form_error('message'); ?>
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
<div class="fh5co-map">
	<?= $data->konten_peta; ?>
</div>