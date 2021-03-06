<div class="page-header">
	<h1>
		<?= $bc_aktif; ?>
		<?php if (isset($sm_text)): ?>
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				<?= $sm_text; ?>
			</small>			
		<?php endif ?>
	</h1>
</div>

<div class="row">
	<div class="col-xs-12 col-md-6">
		<div class="tabbable">
			<ul id="mytab" class="nav nav-tabs">
				<li class="active">
					<a href="<?= site_url('admin/menu') ?>">
						<i class="green ace-icon fa fa-list bigger-120"></i>
						Header Menu
					</a>
				</li>

				<li>
					<a href="<?= site_url('admin/menu/second') ?>" >
						<i class="purple ace-icon fa fa-list-alt bigger-120"></i>
						Footer Menu
					</a>
				</li>
			</ul>

			<div class="tab-content">
				<div class="tab-pane fade in active">					
					<a href="<?=site_url('admin/menu/tambah');?>" class="btn btn-primary tombol-layang tombol-modal"><i class="fa fa-fw fa-plus fa-1x"></i></a>
					<div class="row">
						<?php if ($main_menu->num_rows() == 0): ?>
							<div class="col-md-12 text-center">
								<div class="alert alert-info">
									<h4> PERHATIAN</h4> 
									<hr />
									<i class="fa fa-warning fa-4x"></i>
									<p>
										Belum Ada Menu <br>
										Silahkan Menambahkan Menu dengan Klik Tombol Dibawah
									</p>
									<hr />
									<a href="<?=site_url('admin/menu/tambah');?>" class="btn btn-info">Tambah Menu</a> 
								</div>
								</div><?php else: ?>

								<?php foreach ($main_menu->result() as $row): ?>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="btn-block">
											<button data-toggle="dropdown" class="btn btn-block btn-success dropdown-toggle">
												<?= strtoupper($row->judul) ?>
												<i class="ace-icon fa fa-angle-down icon-on-right"></i>
											</button>

											<ul class="dropdown-menu dropdown-success dropdown-menu-right">
												<li><a href="<?= site_url('admin/menu/edit/'.$row->id_menu); ?>">Edit</a></li>
												<?php 
												// tidak bisa hapus jjka ada submenu
												$id_menu = $row->id_menu;
												$query = $this->db->query("SELECT * FROM tb_menu WHERE parent_id = '$id_menu' ");
												$jumlah = $query->num_rows();
												if ($jumlah <= 0):
													?>
													<li><a class="tombol-hapus" href="<?= site_url('admin/menu/delete/'.$row->id_menu); ?>">Delete</a></li>
												<?php endif; ?>
											</ul>
										</div>
										<div class="space-4"></div>
									</div>
									<?php 
									$id_menu = $row->id_menu;
									$query = $this->db->query("SELECT * FROM tb_menu WHERE parent_id = '$id_menu' ORDER BY urut");
									foreach($query->result() as $sub):
										?>
										<div class="col-md-11 col-md-offset-1 col-sm-11 col-sm-offset-1 col-xs-11 col-xs-offset-1">
											<div class="btn-group btn-block">
												<button data-toggle="dropdown" class="btn btn-block btn-primary btn-lg dropdown-toggle">
													<?= strtoupper($sub->judul) ?>
													<i class="ace-icon fa fa-angle-down icon-on-right"></i>
												</button>

												<ul class="dropdown-menu dropdown-primary dropdown-menu-right">
													<li><a href="<?= site_url('admin/menu/edit/'.$sub->id_menu); ?>">Edit</a></li>
													<li><a class="tombol-hapus" href="<?= site_url('admin/menu/delete/'.$sub->id_menu); ?>">Delete</a></li>
												</ul>
											</div>
											<div class="space-4"></div>
										</div>
										<?php 
									endforeach;
								endforeach;
								?>

							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>