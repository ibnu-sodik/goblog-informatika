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

		<div class="row">
			<div class="row-padded-mb">
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

					<div class="blog-text">
						<?= $konten ?>
					</div>

					<div class="post-sharing text-center">
						<h4>Bagikan melalui : </h4>
						<ul class="list-inline">

							<li><a title="LinkedIn" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.linkedin.com/shareArticle?mini=true&url=<?= site_url("halaman/".$slug) ?>');" class="btn-padding lk-button btn btn-primary"><i class="fa fa-linkedin"></i></a></li>

							<li><a title="Twitter" href="javascript:void(0)" onclick="javascript:openSocialShare('http://twitter.com/share?text=<?=$title?>&url=<?=site_url("halaman/".$slug)?>')" class="btn-padding tw-button btn btn-primary"><i class="fa fa-twitter"></i></a></li>

							<li><a title="Gmail" href="javascript:void(0)" onclick="javascript:openSocialShare('https://mail.google.com/mail/u/0/?ui=2&view=cm&fs=1&tf=1&su=<?= $title ?>&body=<?= site_url("halaman/".$slug) ?>');" class="btn-padding gm-button btn btn-primary"><i class="fa fa-envelope"></i></a></li>

							<li><a title="Facebook" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.facebook.com/sharer.php?u=<?= site_url("halaman/".$slug) ?>');" class="btn-padding fb-button btn btn-primary"><i class="fa fa-facebook"></i></a></li>

							<li><a title="Telegram" href="javascript:void(0)" onclick="javascript:openSocialShare('https://telegram.me/share/url?url=<?= site_url("halaman/".$slug) ?>');" class="btn-padding tl-button btn btn-primary"><i class="fa fa-send"></i></a></li>

							<li><a title="WhatsApp" href="javascript:void(0)" onclick="javascript:openSocialShare('https://wa.me/?text=<?= $title.' | '.site_url("halaman/".$slug) ?>')" data-action="share/whatsapp/share" class="btn-padding wa-button btn btn-primary"><i class="fa fa-whatsapp"></i></a></li>

						</ul>
					</div>
				</div>

				<div class="col-md-4">
					<div class="animate-box fadeInUp animated-fast">
						<div class="text-center fh5co-heading">
							<h3>Baca Juga</h3>
						</div>

						<div>
							<ul class="nav nav-tabs" role="tablist">
								<li role="presentation" class="active">
									<button type="button" class="btn btn-default" data-target="#artikelPopuler" aria-controls="artikelPopuler" role="tab" data-toggle="tab">Artikel Populer</button>
								</li>
								<li role="presentation">
									<button type="button" class="btn btn-default" data-target="#recentViews" aria-controls="recentViews" role="tab" data-toggle="tab">Terakhir Dilihat</button>
								</li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="artikelPopuler">
									<div style="margin-bottom:7px;"></div>
									<?php foreach ($artikel_populer->result() as $row): ?>
										<div class="fh5co-blog animate-box fadeInUp animated-fast">
											<div class="blog-text">
												<h3>
													<a title="<?= $row->judul_artikel ?>" href="<?= site_url('artikel/'.$row->slug_artikel) ?>">
														<?= $row->judul_artikel ?>
													</a>
												</h3>
												<span class="posted_on">
													<i class="fa fa-calendar"></i> <?= tanggal_indo($row->tanggal_up_artikel) ?>
												</span>
												<?php if ($row->views_artikel > 0): ?>
													<span class="comment">
														<a href="javascript:void(0)" title="Dibaca <?= $row->views_artikel ?> x">
															<?= $row->views_artikel ?>
															<i class="fa fa-eye"></i>
														</a>
													</span>
													<p><?= strip_tags(word_limiter($row->konten_artikel, 15)) ?></p>
												<?php endif ?>
											</div>
										</div>
									<?php endforeach ?>
								</div>

								<div role="tabpanel" class="tab-pane fade" id="recentViews">
									<div style="margin-bottom:7px;"></div>
									<?php foreach ($artikel_review->result() as $row): ?>
										<div class="fh5co-blog animate-box fadeInUp animated-fast">
											<div class="blog-text">
												<h3>
													<a title="<?= $row->judul_artikel ?>" href="<?= site_url('artikel/'.$row->slug_artikel) ?>">
														<?= $row->judul_artikel ?>
													</a>
												</h3>
												<span class="posted_on">
													<i class="fa fa-calendar"></i> <?= tanggal_indo($row->tanggal_up_artikel) ?>
												</span>
												<?php if ($row->views_artikel > 0): ?>
													<span class="comment">
														<a href="javascript:void(0)" title="Dibaca <?= $row->views_artikel ?> x">
															<?= $row->views_artikel ?>
															<i class="fa fa-eye"></i>
														</a>
													</span>
													<p><?= strip_tags(word_limiter($row->konten_artikel, 15)) ?></p>
												<?php endif ?>
											</div>
										</div>
									<?php endforeach ?>
								</div>
							</div>
							
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