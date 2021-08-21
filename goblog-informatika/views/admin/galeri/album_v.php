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

<a href="#" class="btn btn-primary tombol-layang tombol-modal" data-toggle="modal" data-target="#addModal"><i class="fa fa-fw fa-plus fa-1x"></i></a>

<div class="row">
	<div class="col-md-12 col-xs-12">
		
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		<?php if(validation_errors()): ?>
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<div class="alert alert-block alert-warning">
						<button type="button" class="close" data-dismiss="alert">
							<i class="ace-icon fa fa-times"></i>
						</button>

						<?= (( form_error('album') ) ? form_error('album') : form_error('album2')) ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div>
			<table id="dynamic-table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center">Nomor</th>
						<th>Nama Album</th>
						<th class="text-center">Jumlah Foto</th>
						<th class="text-center">Opsi</th>
					</tr>
				</thead>

				<tbody>
					<?php 
					$no = 0;
					foreach ($data_album->result() as $row):
						$query = $this->db->query("SELECT * FROM tb_galeri WHERE id_album_galeri = '$row->id_album'");
						$jumlah_foto = $query->num_rows();
						$no++;
						?>
						<tr>
							<td class="text-center"><?= $no; ?></td>
							<td><?= $row->nama_album; ?></td>
							<td class="text-center"><?= (($jumlah_foto == '') ? 'Belum ada Foto' : $jumlah_foto ); ?></td>

							<td class="text-center">
								<a href="javascript:void(0);" title="Edit" data-id="<?=$row->id_album; ?>" data-album="<?=$row->nama_album; ?>" class="green edit-album">
									<i class="ace-icon fa fa-edit bigger-130"></i>
								</a>

								<a class="red tombol-hapus-album" href="<?=site_url('admin/galeri/hapus-album/'.$row->id_album); ?>">
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

<!-- modal add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalAlbum" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Tambah Album</h4>
			</div>
			<form method="post" action="<?= $form_add_action; ?>">
				<div class="modal-body">
					<div class="form-group">
						<label for="album">Nama Album</label>
						<input type="text" name="album" id="album" required placeholder="Nama Album" class="form-control" autofocus>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modalAlbum" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Edit Album</h4>
			</div>
			<form method="post" action="<?= $form_edit_action ?>">
				<div class="modal-body">
					<div class="form-group">
						<label for="album2">Nama Album</label>
						<input type="hidden" name="id_album">
						<input type="text" name="album2" id="album2" required autofocus placeholder="Nama Album" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Simpan</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="<?= base_url() ?>dists/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.flash.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>dists/js/buttons.colVis.min.js"></script>
<script src="<?= base_url() ?>dists/js/dataTables.select.min.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">

	$('.tombol-hapus-album').on('click', function(e) {
		e.preventDefault();
		const href = $(this).attr('href');
		swal({
			title: "Apakah Anda Yakin?",
			text: "Foto yang berada pada album ini juga akan dihapus!?",
			icon: "warning",
			buttons: true,
			dangerMode: true
		}).then((willDelete) => {
			if (willDelete) {
				document.location.href = href;
			}
		});
	});
	jQuery(function($) {

	 // album script
	 $('.edit-album').on('click', function() {
	 	var id = $(this).data('id');
	 	var name = $(this).data('album');
	 	$('[name="id_album"]').val(id);
	 	$('[name="album2"]').val(name);
	 	$('#editModal').modal('show');
	 });

	//initiate dataTables plugin
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

				////

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
			})
		</script>