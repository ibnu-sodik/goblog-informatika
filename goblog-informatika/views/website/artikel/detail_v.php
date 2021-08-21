<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/komentar.css') ?>">

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
							<i class="fa fa-calendar-o"></i> <?= tanggal_indo($post_date) ?>
						</span>
						&nbsp;
						<span>
							<i class="fa fa-clock-o"></i> <?= hanya_jam($post_date) ?>
						</span>
						&nbsp;
						<span>
							<a class="text-muted" href="<?= site_url('kategori/'.$slug_kategori) ?>" title="Kategori">
								<i class="fa fa-tag"> <?= $nama_kategori ?></i>
							</a>
						</span>
						&nbsp;
						<span>
							<a class="text-muted" href="<?= site_url('personil/'.$username) ?>" title="Author">
								<i class="fa fa-user"> <?= $author ?></i>
							</a>
						</span>
						<?php if ($jumlah_komentar > 0): ?>
							&nbsp;
							<span>
								<i class="fa fa-comment"></i> <?= $jumlah_komentar ?> Komentar
							</span>						
						<?php endif; ?>
						<?php if ($views_artikel > 0): ?>
							&nbsp;
							<span>
								<i class="fa fa-eye"></i> Dibaca <?= $views_artikel ?> x
							</span>						
						<?php endif ?>
					</div>


					<img class="img-fluid img-responsive" src="<?= $gambar ?>" alt="<?= $title ?>" />
					<hr>
					<div class="blog-text">
						<?= $konten ?>
					</div>
				</div>

				<div class="animated-box fadeInUp animated-fast">
					<div class="inline">
						<span style="font-size: 18px;">Label : </span>
						<?php 
						$split_labels = explode(",", $labels);
						foreach ($split_labels as $label):
							$query = $this->db->query("SELECT * FROM tb_label_artikel WHERE slug_label = '$label'");
							$data = $query->row();
							?>

							<a href="<?= site_url('label/'.$data->slug_label) ?>">
								<span class="label label-default">
									<?= $data->nama_label ?>
								</span>
								&nbsp;
							</a>
						<?php endforeach; ?>
					</div>
					<div class="invis"></div>
					<div class="post-sharing text-center">
						<h4>Bagikan melalui : </h4>
						<ul class="list-inline">

							<li><a title="LinkedIn" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.linkedin.com/shareArticle?mini=true&url=<?= site_url("artikel/".$slug) ?>');" class="btn-padding lk-button btn btn-primary"><i class="fa fa-linkedin"></i></a></li>

							<li><a title="Twitter" href="javascript:void(0)" onclick="javascript:openSocialShare('http://twitter.com/share?text=<?=$title?>&url=<?=site_url("artikel/".$slug)?>')" class="btn-padding tw-button btn btn-primary"><i class="fa fa-twitter"></i></a></li>

							<li><a title="Gmail" href="javascript:void(0)" onclick="javascript:openSocialShare('https://mail.google.com/mail/u/0/?ui=2&view=cm&fs=1&tf=1&su=<?= $title ?>&body=<?= site_url("artikel/".$slug) ?>');" class="btn-padding gm-button btn btn-primary"><i class="fa fa-envelope"></i></a></li>

							<li><a title="Facebook" href="javascript:void(0)" onclick="javascript:openSocialShare('https://www.facebook.com/sharer.php?u=<?= site_url("artikel/".$slug) ?>');" class="btn-padding fb-button btn btn-primary"><i class="fa fa-facebook"></i></a></li>

							<li><a title="Telegram" href="javascript:void(0)" onclick="javascript:openSocialShare('https://telegram.me/share/url?url=<?= site_url("artikel/".$slug) ?>');" class="btn-padding tl-button btn btn-primary"><i class="fa fa-send"></i></a></li>

							<li><a title="WhatsApp" href="javascript:void(0)" onclick="javascript:openSocialShare('https://wa.me/?text=<?= $title.' | '.site_url("artikel/".$slug) ?>')" data-action="share/whatsapp/share" class="btn-padding wa-button btn btn-primary"><i class="fa fa-whatsapp"></i></a></li>

						</ul>
					</div>

					<?php 
					$prev = $artikel_sebelumnya;
					$next = $artikel_selanjutnya;
					if (($prev->num_rows() > 0) OR ($next->num_rows() > 0)):
						?>
					<div class="invis"></div>
					<div class="row text-center">
						<div class="col-md-6">
							<h4>Artikel Sebelumnya</h4>
							<?php if ($prev->num_rows() > 0): ?>
								<?php foreach ($prev->result() as $row): ?>
									<a href="<?= site_url('artikel/'.$row->slug_artikel) ?>">
										<span class="text-muted">
											<i class="fa fa-caret-left"></i>
											&nbsp;
											<?= $row->judul_artikel; ?>
										</span>
									</a>
								<?php endforeach;
								else: ?>
									<span class="text-muted">
										<i class="fa fa-exclamation-triangle"></i>
										&nbsp;
										Akhir dari artikel
									</span>
								<?php endif; ?>
							</div>
							<div class="col-md-6">
								<h4>Artikel Selanjutnya</h4>
								<?php if ($next->num_rows() > 0): ?>
									<?php foreach ($next->result() as $row): ?>
										<a href="<?= site_url('artikel/'.$row->slug_artikel) ?>">
											<span class="text-muted">
												<?= $row->judul_artikel; ?>
												&nbsp;
												<i class="fa fa-caret-right"></i>
											</span>
										</a>
									<?php endforeach;
									else: ?>
										<span class="text-muted">
											Akhir dari artikel
											&nbsp;
											<i class="fa fa-exclamation-triangle"></i>
										</span>
									<?php endif; ?>
								</div>
							</div>					
						<?php endif; ?>
					</div>


					<div class="invis"></div>
					<?php if ($komentar > 0): ?>

						<div class="animate-box fadeInUp animated-fast">
							<div class="komentar clearfix">
								<h3><?= $komentar ?> Komentar</h3>
								<div class="row">
									<div class="col-lg-12">
										<div class="comments-list">

											<?php 
											foreach ($data_komentar->result() as $row):
												$q_author = $this->db->get_where('tb_personil', array('email' => $row->email_komentar));
												$data_personil = $q_author->row();
												if ($q_author->num_rows() > 0 && !empty($data_personil->foto) && file_exists('uploads/personil/'.$data_personil->foto)) {
													$link_foto = base_url('uploads/personil/'.$data_personil->foto);
												}else{
													$link_foto = get_gravatar($row->email_komentar);
												}
												?>
												<li class="comments" style="list-style: none;">
													<div class="media">
														<span class="media-left">
															<img src="<?= $link_foto ?>" alt="<?= $row->nama_komentar ?>" class="img-fluid img-rounded">
														</span>
														<div class="media-body">
															<h4 class="media-heading"><?= $row->nama_komentar ?> <small><?= waktu_berlalu($row->tanggal_komentar) ?></small></h4>
															<span><i class="fa fa-calendar"></i> <?= tanggal_indo($row->tanggal_komentar) ?></span>
															&nbsp;
															<span><i class="fa fa-clock-o"></i> <?= hanya_jam($row->tanggal_komentar) ?></span>
															<p><?= nl2br($row->konten_komentar) ?></p>
															<a href="javascript:void(0)" class="btn-reply text-muted" 
															data-id_komentar="<?= $row->id_komentar ?>" 
															data-id_komentar_artikel="<?= $row->id_komentar_artikel ?>"
															data-id_author_artikel="<?= $row->id_author_artikel ?>"><i class="fa fa-reply"></i> Balas</a>
														</div>
													</div>
													<?php 
													$id_komentar = $row->id_komentar;
													$query = $this->db->query("SELECT * FROM tb_komentar WHERE status_komentar = 1 AND parent_komentar = '$id_komentar' ORDER BY id_komentar DESC");
													foreach($query->result() as $rowBal):
														$q_author2 = $this->db->get_where('tb_personil', array('email' => $rowBal->email_komentar));
														$data_personil2 = $q_author2->row();
														if ($q_author2->num_rows() > 0 && !empty($data_personil2->foto) && file_exists('uploads/personil/'.$data_personil2->foto)) {
															$link_foto = base_url('uploads/personil/'.$data_personil2->foto);
														}else{
															$link_foto = get_gravatar($rowBal->email_komentar);
														}
														?>
														<ul class="last-child">
															<li class="comments" style="list-style: none;">
																<div class="media">
																	<span class="media-left">
																		<img src="<?= $link_foto ?>" alt="<?= $rowBal->nama_komentar ?>" class="img-fluid img-rounded">
																	</span>
																	<div class="media-body">
																		<h4 class="media-heading"><?= $rowBal->nama_komentar ?> <small><?= waktu_berlalu($rowBal->tanggal_komentar) ?></small></h4>
																		<span><i class="fa fa-calendar"></i> <?= tanggal_indo($rowBal->tanggal_komentar) ?></span>
																		&nbsp;
																		<span><i class="fa fa-clock-o"></i> <?= hanya_jam($rowBal->tanggal_komentar) ?></span>
																		<p><?= nl2br($rowBal->konten_komentar) ?></p>
																		<a href="javascript:void(0)" class="btn-reply text-muted" 
																		data-id_komentar="<?= $rowBal->id_komentar ?>" 
																		data-id_komentar_artikel="<?= $rowBal->id_komentar_artikel ?>"
																		data-id_author_artikel="<?= $rowBal->id_author_artikel ?>"><i class="fa fa-reply"></i> Balas</a>
																	</div>
																</div>
																<?php 
																$id_komentar = $rowBal->id_komentar;
																$query = $this->db->query("SELECT * FROM tb_komentar WHERE status_komentar = 1 AND parent_komentar = '$id_komentar' ORDER BY id_komentar DESC");
																foreach($query->result() as $rowTri):
																	$q_author3 = $this->db->get_where('tb_personil', array('email' => $rowTri->email_komentar));
																	$data_personil3 = $q_author3->row();
																	if ($q_author3->num_rows() > 0 && !empty($data_personil3->foto) && file_exists('uploads/personil/'.$data_personil3->foto)) {
																		$link_foto = base_url('uploads/personil/'.$data_personil3->foto);
																	}else{
																		$link_foto = get_gravatar($rowTri->email_komentar);
																	}
																	?>
																	<ul class="last-child">
																		<li class="comments" style="list-style: none;">
																			<div class="media">
																				<span class="media-left">
																					<img src="<?= $link_foto ?>" alt="<?= $rowTri->nama_komentar ?>" class="img-fluid img-rounded">
																				</span>
																				<div class="media-body">
																					<h4 class="media-heading"><?= $rowTri->nama_komentar ?> <small><?= waktu_berlalu($rowTri->tanggal_komentar) ?></small></h4>
																					<span><i class="fa fa-calendar"></i> <?= tanggal_indo($rowTri->tanggal_komentar) ?></span>
																					&nbsp;
																					<span><i class="fa fa-clock-o"></i> <?= hanya_jam($rowTri->tanggal_komentar) ?></span>
																					<p><?= nl2br($rowTri->konten_komentar) ?></p>
																				</div>
																			</div>
																		</li>
																	</ul>
																<?php endforeach; ?>
															</li>
														</ul>
													<?php endforeach; ?>
												</li>
											<?php endforeach; ?>

										</div>
									</div>
								</div>
							</div>
						</div>

					<?php endif; ?>
					<div id="balasKomentar" style="display: none; position: all;">
						<div class="animate-box fadeInUp animated-fast">
							<div class="komentar clearfix">
								<h3>Balas Komentar</h3>
								<form action="<?= site_url('balas-komentar') ?>" method="post">									
									<div class="row form-group">
										<div class="col-md-12">
											<input type="text" name="nama_komentar" id="nama_komentar" autocomplete="off" class="form-control" placeholder="Nama" value="<?= set_value('nama_komentar'); ?>">
											<?= form_error('nama_komentar'); ?>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-md-12">
											<input type="email" name="email_komentar" id="email_komentar" autocomplete="off" class="form-control" placeholder="Alamat Email" value="<?= set_value('email_komentar'); ?>">
											<?= form_error('email_komentar'); ?>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-md-12">
											<input type="text" name="website" id="website" autocomplete="off" class="form-control" placeholder="Link Website (opsinoal)" value="<?= set_value('website'); ?>">
											<?= form_error('website'); ?>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-md-12">
											<textarea name="konten_komentar" id="konten_komentar" cols="10" rows="5" class="form-control" placeholder="Tulis komentar anda..."><?= set_value('konten_komentar') ?></textarea>
											<?= form_error('konten_komentar'); ?>
										</div>
									</div>

									<div class="form-group">
										<input type="hidden" name="id_komentar" required>
										<input type="hidden" name="id_komentar_artikel2" required>
										<input type="hidden" name="id_author_artikel2" required>
										<input type="hidden" name="slug" value="<?= $slug ?>">
										<div class="row">
											<div class="col-md-6">												
												<button type="button" class="btn btn-block btn-default btn-close">Batal <i class="fa fa-times"></i></button>
											</div>
											<div class="col-md-6">												
												<button type="submit" class="btn btn-block btn-primary">Kirim Komentar <i class="fa fa-send"></i></button>
											</div>
										</div>
									</div>

								</form>		
							</div>
						</div>
					</div>

					<div id="beriKomentar">
						<div class="animate-box fadeInUp animated-fast">
							<div class="komentar clearfix">
								<h3>Beri Komentar</h3>
								<form action="<?= site_url('kirim-komentar') ?>" method="post">
									<div class="row form-group">
										<div class="col-md-12">
											<input type="text" name="nama_komentar" id="nama_komentar" autocomplete="off" class="form-control" placeholder="Nama" value="<?= set_value('nama_komentar'); ?>">
											<?= form_error('nama_komentar'); ?>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-md-12">
											<input type="email" name="email_komentar" id="email_komentar" autocomplete="off" class="form-control" placeholder="Alamat Email" value="<?= set_value('email_komentar'); ?>">
											<?= form_error('email_komentar'); ?>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-md-12">
											<input type="text" name="website" id="website" autocomplete="off" class="form-control" placeholder="Link Website (opsinoal)" value="<?= set_value('website'); ?>">
											<?= form_error('website'); ?>
										</div>
									</div>

									<div class="row form-group">
										<div class="col-md-12">
											<textarea name="konten_komentar" id="konten_komentar" cols="10" rows="5" class="form-control" placeholder="Tulis komentar anda..."><?= set_value('konten_komentar') ?></textarea>
											<?= form_error('konten_komentar'); ?>
										</div>
									</div>

									<div class="form-group">
										<input type="hidden" name="id_komentar_artikel" value="<?= $id_artikel ?>" required>
										<input type="hidden" name="id_author_artikel" value="<?= $id_author ?>" required>
										<input type="hidden" name="slug" value="<?= $slug ?>">
										<button type="submit" class="btn btn-primary btn-block">Kirim Komentar <i class="fa fa-send"></i></button>
									</div>

								</form>		
							</div>
						</div>
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

	<script type="text/javascript">
		function openSocialShare(url){
			window.open(url,'sharer','toolbar=0,status=0,width=900,height=695');
			return true;
		}
		
		$(document).ready(function() {
			$('.btn-reply').click(function() {
				var id_komentar 		= $(this).data('id_komentar');
				var id_komentar_artikel = $(this).data('id_komentar_artikel');
				var id_author_artikel 	= $(this).data('id_author_artikel');
				$('#beriKomentar').hide();
				$('#balasKomentar').show();
				$('[name="id_komentar"]').val(id_komentar);
				$('[name="id_komentar_artikel2"]').val(id_komentar_artikel);
				$('[name="id_author_artikel2"]').val(id_author_artikel);
			})

			$('.btn-close').click(function() {
				$('#beriKomentar').show();
				$('#balasKomentar').hide();
			})
		})
	</script>