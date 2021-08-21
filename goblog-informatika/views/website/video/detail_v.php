<link type="text/css" rel="stylesheet" href="<?= base_url('assets/light-gallery/dist/css/lightgallery.min.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/lg-video.css') ?>">

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
			<div class="col-md-8">
				<div class="animated-box fadeInUp animated-fast">
					<div class="text-left fh5co-heading">
						<h2><?= $title ?></h2>
						<span>
							<i class="fa fa-calendar-o"></i> <?= tanggal_indo($tgl_upload) ?>
						</span>
						&nbsp;
						<span>
							<i class="fa fa-clock-o"></i> <?= hanya_jam($tgl_upload) ?>
						</span>
						&nbsp;
						<span>
							<i class="fa fa-user"> <?= $site_name ?></i>
						</span>
						<?php if ($views_video > 0): ?>
							&nbsp;
							<span>
								<i class="fa fa-eye"></i> Ditonton <?= $views_video ?> x
							</span>						
						<?php endif ?>
					</div>
					<div class="blog-text">
						<div class="responsive-iframe">
							<iframe title="<?= $title ?>" width="100%" height="420" src="<?= getYoutubeEmbedUrl($link) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
						</div>
						<?= $konten ?>
					</div>

					<div class="invis"></div>
					<div class="post-sharing text-center">
						<h4>Bagikan melalui : </h4>
						<ul class="list-inline">

							<li><a title="LinkedIn" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.linkedin.com/shareArticle?mini=true&url=<?= site_url("video/".$slug) ?>');" class="btn-padding lk-button btn btn-primary"><i class="fa fa-linkedin"></i></a></li>

							<li><a title="Twitter" href="javascript:void(0)" onclick="javascript:openSocialShare('http://twitter.com/share?text=<?=$title?>&url=<?=site_url("video/".$slug)?>')" class="btn-padding tw-button btn btn-primary"><i class="fa fa-twitter"></i></a></li>

							<li><a title="Gmail" href="javascript:void(0)" onclick="javascript:openSocialShare('https://mail.google.com/mail/u/0/?ui=2&view=cm&fs=1&tf=1&su=<?= $title ?>&body=<?= site_url("video/".$slug) ?>');" class="btn-padding gm-button btn btn-primary"><i class="fa fa-envelope"></i></a></li>

							<li><a title="Facebook" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.facebook.com/sharer.php?u=<?= site_url("video/".$slug) ?>');" class="btn-padding fb-button btn btn-primary"><i class="fa fa-facebook"></i></a></li>

							<li><a title="Telegram" href="javascript:void(0)" onclick="javascript:openSocialShare('https://telegram.me/share/url?url=<?= site_url("video/".$slug) ?>');" class="btn-padding tl-button btn btn-primary"><i class="fa fa-send"></i></a></li>

							<li><a title="WhatsApp" href="javascript:void(0)" onclick="javascript:openSocialShare('https://wa.me/?text=<?= $title.' | '.site_url("video/".$slug) ?>')" data-action="share/whatsapp/share" class="btn-padding wa-button btn btn-primary"><i class="fa fa-whatsapp"></i></a></li>

						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="animate-box fadeInUp animated-fast">
					<div class="text-center fh5co-heading">
						<h3>Tonton Juga</h3>
					</div>

					<div>						
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active">
								<button type="button" class="btn btn-default" data-target="#videoPopuler" aria-controls="videoPopuler" role="tab" data-toggle="tab">Video Populer</button>
							</li>
							<li role="presentation">
								<button type="button" class="btn btn-default" data-target="#recentViews" aria-controls="recentViews" role="tab" data-toggle="tab">Terakhir Dilihat</button>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane fade in active" id="videoPopuler" role="tabpanel">
								<div style="margin-top: 7px;"></div>
								<?php 
								foreach ($video_populer->result() as $row):
									$youtubeID = getYouTubeVideoId($row->link_video);
									$thumbURL = 'https://img.youtube.com/vi/' . $youtubeID . '/mqdefault.jpg';
									?>
									<div class="animate-box fadeInUp animated-fast">
										<div class="services">
											<h4>
												<a class="text-muted" id="kapsion<?= $row->id_video ?>" href="<?= site_url('video/'.$row->slug_video) ?>">
													<?= $row->nama_video ?>
												</a>
											</h4>
											<a href="<?= $row->link_video ?>" class="item" data-sub-html="#kapsion<?= $row->id_video ?>">
												<img src="<?= $thumbURL ?>" class="img-fluid img-thumbnail">
												<div class="play-button">
													<img class="play-but" src="<?= base_url('assets/images/play-button.png') ?>">
												</div>
											</a>						
										</div>
									</div>
								<?php endforeach ?>
							</div>

							<div class="fade tab-pane" id="recentViews" role="tabpanel">
								<div style="margin-top: 7px;"></div>
								<?php 
								foreach ($video_last_view->result() as $row):
									$youtubeID = getYouTubeVideoId($row->link_video);
									$thumbURL = 'https://img.youtube.com/vi/' . $youtubeID . '/mqdefault.jpg';
									?>
									
									<div class="animated-box fadeInUp animated-fast">
										<div class="services">
											<h4>
												<a class="text-muted" id="kapsion<?= $row->id_video ?>" href="<?= site_url('video/'.$row->slug_video) ?>">
													<?= $row->nama_video ?>
												</a>
											</h4>
											<a href="<?= $row->link_video ?>" class="item" data-sub-html="#kapsion<?= $row->id_video ?>">
												<img src="<?= $thumbURL ?>" class="img-fluid img-thumbnail">
												<div class="play-button">
													<img class="play-but" src="<?= base_url('assets/images/play-button.png') ?>">
												</div>
											</a>						
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
	function openSocialShare(url){
		window.open(url,'sharer','toolbar=0,status=0,width=900,height=695');
		return true;
	}
	

	$(document).ready(function() {
		$("#videoPopuler").lightGallery({
			selector: '.item',
			counter:true,
			html:true 
		});
	});
</script>