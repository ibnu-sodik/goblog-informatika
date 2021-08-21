<aside id="fh5co-hero">
	<div class="flexslider">
		<ul class="slides">
			<li style="background-image: url(<?= $bg_agenda ?>);">
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
		<div class="row">
			<?php foreach ($agenda->result() as $row): ?>
				<div class="col-md-4 animate-box">
					<div class="fh5co-event">
						<div class="date text-center"><span><?= $row->tanggal ?><br><?= bulan_indo($row->bulan) ?></span></div>
						<h3>
							<!-- <a href="<?= site_url('agenda/'.$row->slug_agenda) ?>"> -->
								<?= $row->nama_agenda ?>								
								<!-- </a> -->
							</h3>
							<p><?= strip_tags(word_limiter($row->konten_agenda, 30)) ?></p>
							<p><a href="<?= site_url('agenda/'.$row->slug_agenda) ?>">Selengkapnya...</a></p>
						</div>
					</div>			
				<?php endforeach; ?>
			</div>
			<div class="text-center">
				<?= $pagination ?>
			</div>
		</div>
	</div>