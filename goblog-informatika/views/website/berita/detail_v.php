<div id="fh5co-blog">
	<div class="container">

		<nav aria-label="breadcrumb" class="animate-box fadeInUp animated-fast">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= site_url('') ?>"><i class="fa fa-home"></i>&nbsp;Beranda</a></li>
				<?php if (isset($bc_aktif)): ?>					
					<li class="breadcrumb-item"><a href="<?= $bc_link ?>"><?= $bc_title ?></a></li>
					<li class="breadcrumb-item active" aria-current="page"><?= $bc_aktif ?></li><?php else: ?>
					<li class="breadcrumb-item active"><a href="<?= $bc_link ?>"><?= $bc_title ?></a></li>
				<?php endif; ?>
			</ol>
		</nav>

		<div class="row row-padded-mb">
			<div class="col-md-8 animate-box fadeInUp animated-fast">
				<div class="text-left fh5co-heading">
					<h2><?= $title ?></h2>
					<span>
						<i class="fa fa-calendar-o"></i> <?= tanggal_indo($post_date) ?>
					</span>
					&nbsp;
					<span>
						<i class="fa fa-clock-o"></i> <?= hanya_jam($post_date) ?>
					</span>
					&nbsp;
					<span>
						<i class="fa fa-user"> <?= $site_name ?></i>
					</span>
				</div>

				<img class="img-fluid img-responsive" src="<?= $gambar ?>" alt="<?= $title ?>" />
				<hr>
				<div class="blog-text">
					<?= $konten ?>
				</div>

				<div class="post-sharing text-center">
					<h4>Bagikan melalui : </h4>
					<ul class="list-inline">

						<li><a title="LinkedIn" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.linkedin.com/shareArticle?mini=true&url=<?= site_url("berita/".$slug) ?>');" class="btn-padding lk-button btn btn-primary"><i class="fa fa-linkedin"></i></a></li>

						<li><a title="Twitter" href="javascript:void(0)" onclick="javascript:openSocialShare('http://twitter.com/share?text=<?=$title?>&url=<?=site_url("berita/".$slug)?>')" class="btn-padding tw-button btn btn-primary"><i class="fa fa-twitter"></i></a></li>

						<li><a title="Gmail" href="javascript:void(0)" onclick="javascript:openSocialShare('https://mail.google.com/mail/u/0/?ui=2&view=cm&fs=1&tf=1&su=<?= $title ?>&body=<?= site_url("berita/".$slug) ?>');" class="btn-padding gm-button btn btn-primary"><i class="fa fa-envelope"></i></a></li>

						<li><a title="Facebook" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.facebook.com/sharer.php?u=<?= site_url("berita/".$slug) ?>');" class="btn-padding fb-button btn btn-primary"><i class="fa fa-facebook"></i></a></li>

						<li><a title="Telegram" href="javascript:void(0)" onclick="javascript:openSocialShare('https://telegram.me/share/url?url=<?= site_url("berita/".$slug) ?>');" class="btn-padding tl-button btn btn-primary"><i class="fa fa-send"></i></a></li>

						<li><a title="WhatsApp" href="javascript:void(0)" onclick="javascript:openSocialShare('https://wa.me/?text=<?= $title.' | '.site_url("berita/".$slug) ?>')" data-action="share/whatsapp/share" class="btn-padding wa-button btn btn-primary"><i class="fa fa-whatsapp"></i></a></li>

					</ul>
				</div>
			</div>

			<div class="col-md-4 animate-box fadeInUp animated-fast">
				<div class="text-center fh5co-heading">
					<h3>Baca Juga</h3>
				</div>
				<div>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<button type="button" class="btn btn-default" data-target="#artikel" aria-controls="artikel" role="tab" data-toggle="tab">Artikel</button>
						</li>
						<li role="presentation">
							<button type="button" class="btn btn-default" data-target="#agenda" aria-controls="agenda" role="tab" data-toggle="tab">Agenda</button>
						</li>
						<li role="presentation">
							<button type="button" class="btn btn-default" data-target="#berita" aria-controls="berita" role="tab" data-toggle="tab">Berita</button>
						</li>
					</ul>
					<div class="tab-content">

						<div role="tabpanel" class="tab-pane fade in active" id="artikel">
							<div style="margin-bottom:7px;"></div>
							<?php foreach ($artikel->result() as $row): ?>			
								<div class="fh5co-blog animate-box fadeInUp animated-fast">
									<a href="javascript:void(0)" class="blog-img-holder" style="background-image: url(<?= base_url('uploads/artikel/'.$row->gambar_artikel) ?>);"></a>
									<div class="blog-text">
										<h3>
											<a title="<?= $row->judul_artikel ?>" href="<?= site_url('artikel/'.$row->slug_artikel) ?>"><?= $row->judul_artikel ?></a>
										</h3>
										<span class="posted_on">
											<i class="fa fa-calendar"></i> <?= tanggal_indo($row->tanggal_up_artikel) ?>
										</span>
										<?php if ($row->jumlah_komentar > 0): ?>
											<span class="comment">
												<a href="javascript:void(0)" title="<?= $row->jumlah_komentar ?> Komentar">
													<?= $row->jumlah_komentar ?>
													<i class="icon-speech-bubble"></i>
												</a>&nbsp;
											</span>
										<?php endif ?>
										<br>
										<span class="kategori">
											<a href="<?= site_url('kategori/'.$row->slug_kategori) ?>" title="Kategori <?= $row->nama_kategori ?>">
												<i class="fa fa-tag"></i> <?= $row->nama_kategori ?>
											</a>
										</span>
									</div> 
								</div>
							<?php endforeach; ?>
						</div>

						<div role="tabpanel" class="tab-pane fade" id="agenda">
							<div style="margin-bottom:7px;"></div>
							<?php foreach ($agenda->result() as $row): ?>
								<div class="fh5co-event animate-box fadeInUp animated-fast">
									<div class="date text-center">
										<span><?= $row->tanggal ?>
										<br><?= bulan_indo($row->bulan) ?></span>
									</div>
									<h3>
										<a href="<?= site_url('agenda/'.$row->slug_agenda) ?>"><?= $row->nama_agenda ?></a>
									</h3>
									<p>
										<a href="<?= site_url('agenda/'.$row->slug_agenda) ?>">Selengkapnya...</a>
									</p>
								</div>
							<?php endforeach ?>
						</div>

						<div role="tabpanel" class="tab-pane fade" id="berita">
							<div style="margin-bottom:7px;"></div>
							<?php foreach ($berita->result() as $row): ?>					
								<div class="fh5co-blog animate-box fadeInUp animated-fast">
									<a href="javascript:void(0)" class="blog-img-holder" style="background-image: url(<?= base_url('uploads/berita/'.$row->gambar_berita) ?>);"></a>
									<div class="blog-text">
										<h3>
											<a href="<?= site_url('berita/'.$row->slug_berita) ?>"><?= $row->nama_berita ?></a>
										</h3>
										<span class="posted_on">
											<i class="fa fa-calendar"></i>
											<?= tanggal_indo($row->berita_postdate); ?>
										</span>
										<span class="posted_on">
											<i class="fa fa-user"></i> <?= $site_name ?>
										</span>
									</div> 
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<script type="text/javascript" async >
	function openSocialShare(url){
		window.open(url,'sharer','toolbar=0,status=0,width=900,height=695');
		return true;
	}
</script>