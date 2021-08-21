<?php 
if (isset($canonical) && isset($url)) {
	$canonical = $canonical;
	$url = $url;
}else{
	$canonical = site_url('');
	$url = site_url('');
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<?php if(isset($title)): ?>
		<title><?=$title?> | <?= $site_title; ?></title>
		<meta property="og:title" content="<?= $title;?>" /><?php else: ?>
		<title><?= $site_title; ?></title>
		<meta property="og:title" content="<?= $site_title;?>" />
	<?php endif; ?>

	<meta name="keywords" content="<?= $site_keywords; ?>">

	<?php if (isset($description)): ?>
		<meta name="description" content="<?= $description; ?>" />
		<meta property="og:description" content="<?= $description;?>" /><?php else: ?>
		<meta name="description" content="<?= $site_description; ?>" />
		<meta property="og:description" content="<?= $site_description;?>" />
	<?php endif; ?>

	<?php if (isset($author)): ?>
		<meta name="author" content="<?= $author; ?>"><?php else: ?>
		<meta name="author" content="<?= $site_author; ?>">
	<?php endif; ?>

	<meta property="og:locale" content="id_ID" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?= $url; ?>" />
	<meta property="og:site_name" content="<?= $site_name;?>" />
	
	<?php if (isset($gambar)): ?>		
		<meta property="og:image" content="<?= $gambar; ?>" />
		<meta property="og:image:secure_url" content="<?= $gambar; ?>" /><?php else: ?>
		<meta property="og:image" content="<?= base_url('assets/images/'.$site_favicon); ?>" />
		<meta property="og:image:secure_url" content="<?= base_url('assets/images/'.$site_favicon); ?>" />
	<?php endif; ?>
	<meta property="og:image:width" content="560" />
	<meta property="og:image:height" content="315" />

	<link rel="canonical" href="<?= $canonical; ?>">
	<?php if(isset($url_prev)): ?>
		<link rel="prev" href="<?= $url_prev;?>" />
	<?php endif; ?>
	<?php if (isset($url_next)): ?>
		<link rel="next" href="<?= $url_next;?>" />
	<?php endif; ?>

	<!-- Facebook and Twitter integration -->
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />


	<link rel="shortcut icon" href="<?= base_url('assets/images/'.$site_favicon) ?>" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<?= base_url('assets/images/'.$site_favicon) ?>">

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/icomoon.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/bootstrap.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/magnific-popup.css">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/owl.carousel.min.css">
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/owl.theme.default.min.css">

	<!-- Flexslider  -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/flexslider.css">

	<!-- Pricing -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/pricing.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="<?= base_url('assets/') ?>css/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>dists/font-awesome/4.5.0/css/font-awesome.min.css" />

	<!-- jQuery -->
	<script src="<?= base_url('assets/') ?>js/jquery.min.js"></script>

	<script src="<?= base_url('assets/') ?>js/owl.carousel.min.js"></script>
	<!-- Modernizr JS -->
	<script src="<?= base_url('assets/') ?>js/modernizr-2.6.2.min.js"></script>
	<script src="<?= base_url('assets/') ?>js/smooth-scroll.polyfills.min.js"></script>
	
	<!-- FOR IE9 below -->
	<script src="<?= base_url('assets/') ?>js/respond.min.js"></script>

</head>
<body>

	<div class="w-load" style="background: url(<?= base_url('assets/images/'.$site_favicon) ?>) center no-repeat;">
		<div class="fh5co-loader" style="background: url(<?= base_url('assets/images/'.$site_favicon) ?>) center no-repeat;"></div>	
	</div>

	<div id="page">
		<nav class="fh5co-nav" role="navigation">
			<div class="top">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 text-right">
							<p class="site">
								<a href="mailto:<?= $site_email; ?>"><i class="fa fa-envelope"></i> &nbsp;<?= $site_email; ?></a>
							</p>
							<p class="num">
								Hubungi : <a href="tel:<?= $site_telp; ?>">&nbsp;<i class="fa fa-phone"></i>&nbsp;<?= $site_telp; ?></a>
							</p>
							<ul class="fh5co-social">
								<?php 
								$sql_query = $this->db->query("SELECT * FROM tb_sosmedweb ORDER BY nama_sosmed ASC");
								foreach($sql_query->result() as $row):
									?>
									<li>
										<a href="<?= $row->link_sosmed ?>" target="_blank" title="<?= $row->nama_sosmed ?>">
											<i class="<?= $row->ikon_sosmed ?>"></i>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="top-menu">
				<div class="container">
					<div class="row">
						<div class="col-xs-4">
							<div id="fh5co-logo">
								<a href="<?= site_url('') ?>" class="navbar-brand">
									<?php 
									$file = file_exists(base_url('assete/images/'.$site_logo));
									if (isset($file) && $site_logo != ""): ?>
										<img class="img-fluid" style="max-height: 75px; max-width: 75px;" src="<?= base_url('assets/images/'.$site_logo); ?>" alt="<?= $site_name ?>">
										<?php else: ?>
											<?= $site_name; ?>
										<?php endif ?>
									</a>
								</div>
							</div>
							<div class="col-xs-8 text-right menu-1">
								<ul>
									<?php 

									$sql_m1 = $this->db->query("SELECT * FROM tb_menu WHERE kategori_menu = 'main' AND parent_id = '0' ORDER BY urut");
									if($sql_m1->num_rows() > 0):
										foreach ($sql_m1->result() as $row):
											$id_menu = $row->id_menu;
											$sql_m2 = $this->db->query("SELECT * FROM tb_menu WHERE kategori_menu = 'main' AND parent_id = '$id_menu' ORDER BY urut");
											if($sql_m2->num_rows() > 0):

												?>
												<li class="has-dropdown">
													<a href="<?= $row->link; ?>"><?= strtoupper($row->judul) ?></a>
													<ul class="dropdown">
														<?php foreach ($sql_m2->result() as $row2): ?>
															<li><a href="<?= $row2->link; ?>"><?= $row2->judul; ?></a></li>
														<?php endforeach ?>
													</ul>
												</li>
												<?php else: ?>
													<li><a href="<?= $row->link ?>"><?= strtoupper($row->judul) ?></a></li>
													<?php 
												endif;
											endforeach;
										endif;
										?>
										
										<!-- <li class="btn-cta"><a href="javascript:void(0)"><span>Login</span></a></li>
											<li class="btn-cta"><a href="javascript:void(0)"><span>Create a Course</span></a></li> -->
										</ul>
									</div>
								</div>

							</div>
						</div>
					</nav>

					<?php 

					if ($contents) {
						echo $contents;
					}

					?>

					<div class="pesan-admin" data-flashdata="<?= $this->session->flashdata('pesan_sukses'); ?>"></div>

					<footer id="fh5co-footer" role="contentinfo" style="background-image: url(<?= base_url('assets/') ?>images/img_bg_4.jpg);">
						<div class="overlay"></div>
						<div class="container">
							<div class="row row-pb-md">
								<div class="col-md-2 col-sm-4 col-xs-6 fh5co-widget">
									<?php 
									if (isset($file) && !empty($site_logo)): ?>
										<img class="img-responsive" src="<?= base_url('assets/images/'.$site_logo); ?>">
								<?php endif ?>
							</div>
							<div class="col-md-3 fh5co-widget">
								<h3>Tentang <?= $site_name; ?></h3>
								<p><?= $site_description; ?></p>
							</div>

							<?php 

							$sql_m2 = $this->db->query("SELECT * FROM tb_menu WHERE kategori_menu = 'second' AND parent_id = '0' ORDER BY urut");
							foreach ($sql_m2->result() as $row):

								?>
								<div class="col-md-2 col-sm-4 col-xs-6 col-md-push-1 fh5co-widget">
									<h3><?= $row->judul; ?></h3>
									<ul class="fh5co-footer-links">
										<?php 
										$id_menu = $row->id_menu;
										$query = $this->db->query("SELECT * FROM tb_menu WHERE kategori_menu = 'second' AND parent_id = '$id_menu' ORDER BY urut");
										foreach($query->result() as $sub):
											?>
											<li><a href="<?= $sub->link ?>"><?= $sub->judul ?></a></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endforeach; ?>

						</div>

						<div class="row copyright">
							<div class="col-md-12 text-center">
								<p>
									<?php 
									if (date('Y') > $tahun_buat) {
										$tahun = $tahun_buat.' - '.date('Y');
									}else{
										$tahun = $tahun_buat;
									}
									?>
									<small class="block">&copy; <?= $tahun ?> <?= $site_name ?></small> 
								</p>
							</div>
						</div>

					</div>
				</footer>
			</div>

			<a target="_blank" href="https://api.whatsapp.com/send?phone=<?= $site_nowa ?>&text=<?= $site_pesanTeks ?>" class="tombol-Wa">
				<i class="fa fa-whatsapp i-wa"></i>
			</a>

			<div class="gototop js-top">
				<a href="javascript:void(0)" class="js-gotop"><i class="icon-arrow-up"></i></a>
			</div>

			<!-- jQuery Easing -->
			<script src="<?= base_url('assets/') ?>js/jquery.easing.1.3.js"></script>
			<!-- Bootstrap -->
			<script src="<?= base_url('assets/') ?>js/bootstrap.min.js"></script>
			<!-- sweetalert -->
			<script src="<?= base_url() ?>dists/js/sweetalert.min.js"></script>
			<!-- Waypoints -->
			<script src="<?= base_url('assets/') ?>js/jquery.waypoints.min.js"></script>
			<!-- Stellar Parallax -->
			<script src="<?= base_url('assets/') ?>js/jquery.stellar.min.js"></script>
			<!-- Carousel -->
			<!-- Flexslider -->
			<script src="<?= base_url('assets/') ?>js/jquery.flexslider-min.js"></script>
			<!-- countTo -->
			<script src="<?= base_url('assets/') ?>js/jquery.countTo.js"></script>
			<!-- Magnific Popup -->
			<script src="<?= base_url('assets/') ?>js/jquery.magnific-popup.min.js"></script>
			<script src="<?= base_url('assets/') ?>js/magnific-popup-options.js"></script>
			<!-- Main -->
			<script src="<?= base_url('assets/') ?>js/main.js"></script>
			<script src="<?= base_url() ?>dists/js/notifikasi.js"></script>
		</body>
		</html>

