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
					<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-12">
							<?php 
							$file = "uploads/personil/".$foto;
							if (!file_exists($file) && empty($foto)) {
								$link_foto = get_gravatar($emial);
							}else{
								$link_foto = base_url('uploads/personil/'.$foto);
							}
							?>
							<div class="staff">
								<img alt="<?= $full_name ?>" class="staff-img img-thumbnail img-fluid" src="<?= $link_foto ?>" style="max-height: 300px;max-width: 300px;">
							</div>
						</div>
						<div class="col-md-8 col-sm-6 col-xs-12">
							<h4><?= $full_name ?></h4>
							<p><?= nl2br($personil_info); ?></p>

							<div class="post-sharing text-center">
								<ul class="list-inline">
									<?php foreach ($sosmed_personil->result() as $row): ?>
										<li><a class="btn-padding lk-button btn btn-primary" target="_blank" href="<?= $row->link_sosmed ?>" title="<?= $row->nama_sosmed ?>">
											<i class="<?= $row->ikon_sosmed ?>"></i>
										</a></li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="text-center fh5co-heading">
						<h2><?= $jumlah ?> artikel dari <?= $full_name ?></h2>
					</div>
					<?php foreach ($artikel_personil->result() as $row): ?>
						
						<div class="col-lg-6 col-md-6">
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
										<a class="text-muted" href="<?= site_url('kategori/'.$row->slug_kategori) ?>" title="Kategori <?= $row->nama_kategori ?>">
											<i class="fa fa-tag"></i> <?= $row->nama_kategori ?>
										</a>
									</span>
									<p><?= strip_tags(word_limiter($row->konten_artikel, 15)) ?></p>
								</div> 
							</div>
						</div>
					<?php endforeach ?>
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