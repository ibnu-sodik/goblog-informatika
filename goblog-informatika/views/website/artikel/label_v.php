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
		<div class="text-center fh5co-heading">
			<h2><?= $bc_title ?></h2>
			<p><?= $sm_text ?></p>
		</div>
		<div class="row">
			<?php foreach($label->result() as $row): ?>
				<div class="col-lg-4 col-md-4">
					<div class="fh5co-blog animate-box fadeInUp animated-fast">
						<a href="<?= base_url('uploads/artikel/'.$row->gambar_artikel) ?>" class="blog-img-holder" style="background-image: url(<?= base_url('uploads/artikel/'.$row->gambar_artikel) ?>);">
							
						</a>
						<div class="blog-text">
							<h3>
								<a title="<?= $row->judul_artikel ?>" href="<?= site_url('artikel/'.$row->slug_artikel) ?>"><?= $row->judul_artikel ?></a>
							</h3>							
							<span class="posted_on">
								<i class="fa fa-calendar"></i> <?= tanggal_indo($row->tanggal_up_artikel) ?>
								&nbsp;
								<a class="text-muted" href="<?= site_url('personil/'.$row->username) ?>" title="Ditulis oleh <?= $row->full_name ?>">
									<i class="fa fa-user"></i> <?= $row->full_name ?>
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