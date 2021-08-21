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

<a href="<?= $action_add ?>" class="btn btn-primary tombol-layang" title="Tambah Data"><i class="fa fa-fw fa-plus fa-1x"></i></a>

<div class="row">
	<div class="table-responsive konten-fasilitas">
		<table class="table table-hover table-bordered" id="tabelku">
			<thead>
				<tr>
					<th class="text-center">Opsi</th>
					<th class="text-center">Nama Fasilitas</th>
					<th class="text-center">Gambar Fasilitas</th>
					<th class="text-center">Ikon Fasilitas</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($data_fasilitas->result() as $row):
					$gambar = base_url('uploads/fasilitas/').$row->gambar_fasilitas;
					$thumbs = base_url('uploads/fasilitas/thumbs/').$row->gambar_fasilitas;
					?>
					<tr style="cursor: pointer;">
						<td class="text-center">
							<a class="green" href="<?= site_url('admin/fasilitas/edit/'.$row->id_fasilitas) ?>" title="Edit">
								<i class="ace-icon fa fa-edit bigger-130"></i>
							</a>
							&nbsp;
							<a class="red tombol-hapus" href="<?= site_url('admin/fasilitas/hapus/'.$row->id_fasilitas); ?>">
								<i class="ace-icon fa fa-trash bigger-130"></i>
							</a>
						</td>
						<td data-id="<?= $row->id_fasilitas; ?>" class="text-left"><?= $row->nama_fasilitas ?></td>
						<td data-id="<?= $row->id_fasilitas; ?>" class="text-center">
							<i class="ace-icon bigger-230 <?= $row->ikon_fasilitas ?>"></i>
						</td>
						<td class="text-center">
							<div class="ace-thumbnails clearfix">
								<a href="<?= $gambar ?>" data-rel="colorbox">
									<img width="50" height="50" alt="<?= $row->nama_fasilitas ?>" src="<?= $thumbs ?>" class="img-thumbnail img-responsive img-fluid img-circle">
								</a>
							</div>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<!-- modal detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalCategory" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Detail Fasilitas</h4>
			</div>
			<div class="modal-body">
				<div id="showData">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$('.konten-fasilitas table tr td').not(":last-child, :first-child").on('click', function(e) {
			e.stopPropagation();
			e.preventDefault();
			$('#detailModal #showData').html('<div id="loading"></div>');
			var id = $(this).data('id');

			$.ajax({
				url : "<?= site_url('admin/fasilitas/detail/') ?>"+id,
				method : "POST",
				dataType : "JSON",
				data : {},
				success : function(data)
				{
					$('#detailModal #showData').html(data.detail_fasilitas);
				}
			});

			$('#detailModal').modal('show');
		});

		$('#tabelku').dataTable();
	});
</script>