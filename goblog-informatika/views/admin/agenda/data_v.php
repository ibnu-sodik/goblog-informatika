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
	<div class="col-md-12 col-xs-12">		
		
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>

		<div class="table-responsive">
			<table id="dynamic-table" class="table table-hover table-striped table-bordered">
				<thead>
					<tr>
						<th class="text-center">Nomor</th>
						<th class="text-center">Nama Agenda</th>
						<th class="text-center">Tanggal Pelaksanaan</th>
						<th class="text-center">Durasi (Hari)</th>
						<th class="text-center">Status</th>
						<th class="text-center">Gambar</th>
						<th class="text-center">Opsi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					foreach ($data_agenda->result() as $row):
						$no++;

						if ($row->arsip == 0) {
							$status = 'Akan dilaksanakan';
							$class = 'label label-sm label-inverse arrowed-in';
						}else{
							$status = 'Terlaksana';
							$class = 'label label-sm label-success arrowed-right';
						}
						$ch = hanya_tanggal($row->tgl_pelaksanaan) + $row->durasi;
						$bt = date('Y-m-');
						$tanggal_saat_ini = date('Y-m-d');
						$gab_t = $bt.$ch;
						$ubah = '';
						$id_agenda = $row->id_agenda;

						if ($tanggal_saat_ini > $gab_t) {
							$object = array('arsip' => 1 );
							$this->db->where('id_agenda', $id_agenda);
							$this->db->update('tb_agenda', $object);
						}

						?>
						<tr>
							<td class="text-center"><?= $no; ?></td>
							<td class="text-left"><?= $row->nama_agenda; ?></td>
							<td class="text-center"><?= tanggal_indo($row->tgl_pelaksanaan); ?></td>
							<td class="text-center"><?= $row->durasi; ?></td>
							<td class="text-center"><label class="<?= $class; ?>"><?= $status; ?></label></td>
							<td class="text-center">
								<?php 
								$file = file_exists(base_url('uploads/agenda/'.$row->gambar_agenda));
								if (isset($file) && !empty($row->gambar_agenda)) {
									$gambar = base_url('uploads/agenda/'.$row->gambar_agenda);
								}else{
									$gambar = base_url('dists/images/no-img.png');
								}
								?>
								<div class="ace-thumbnails clearfix">
									<a href="<?= $gambar; ?>" data-rel="colorbox">
										<img width="50" height="50" alt="<?= $row->nama_agenda ?>" src="<?= $gambar; ?>" class="img-circle img-thumbnail" >
									</a>
								</div>
							</td>
							<td class="text-center">
								<a class="green" href="<?= site_url('admin/agenda/edit/'.$row->id_agenda) ?>" title="Edit">
									<i class="ace-icon fa fa-edit bigger-130"></i>
								</a>

								<a class="red tombol-hapus" href="<?= site_url('admin/agenda/hapus/'.$row->id_agenda); ?>">
									<i class="ace-icon fa fa-trash bigger-130"></i>
								</a>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>

	</div>
</div>

<script src="<?= base_url() ?>dists/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.flash.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.colVis.min.js"></script>
<script src="<?= base_url() ?>dists/js/dataTables.select.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {

		var myTable = $('#dynamic-table').DataTable();

		$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

		new $.fn.dataTable.Buttons( myTable, {
			buttons: [
			{
				"extend": "colvis",
				"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
				"className": "btn btn-white btn-primary btn-bold",
				columns: ':not(:last)'
			},
			{
				"extend": "copy",
				"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
				"className": "btn btn-white btn-primary btn-bold"
			},
			{
				"extend": "csv",
				"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
				"className": "btn btn-white btn-primary btn-bold"
			},
			{
				"extend": "excel",
				"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
				"className": "btn btn-white btn-primary btn-bold"
			},
			{
				"extend": "pdf",
				"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
				"className": "btn btn-white btn-primary btn-bold"
			},
			{
				"extend": "print",
				"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
				"className": "btn btn-white btn-primary btn-bold",
				autoPrint: false,
				message: '<hr> Print menggunakan DataTable'
			}		  
			]
		} );
		myTable.buttons().container().appendTo( $('.tableTools-container') );
		//style the message box
		var defaultCopyAction = myTable.button(1).action();
		myTable.button(1).action(function (e, dt, button, config) {
			defaultCopyAction(e, dt, button, config);
			$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
		});


		var defaultColvisAction = myTable.button(0).action();
		myTable.button(0).action(function (e, dt, button, config) {

			defaultColvisAction(e, dt, button, config);


			if($('.dt-button-collection > .dropdown-menu').length == 0) {
				$('.dt-button-collection')
				.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
				.find('a').attr('href', '#').wrap("<li />")
			}
			$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
		});
		setTimeout(function() {
			$($('.tableTools-container')).find('a.dt-button').each(function() {
				var div = $(this).find(' > div').first();
				if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
				else $(this).tooltip({container: 'body', title: $(this).text()});
			});
		}, 500);

		$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
			e.stopImmediatePropagation();
			e.stopPropagation();
			e.preventDefault();
		});

		/********************************/
		//add tooltip for small view action buttons in dropdown menu
		$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

		//tooltip placement on right or left
		function tooltip_placement(context, source) {
			var $source = $(source);
			var $parent = $source.closest('table')
			var off1 = $parent.offset();
			var w1 = $parent.width();

			var off2 = $source.offset();
			//var w2 = $source.width();

			if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
			return 'left';
		}

	});
</script>