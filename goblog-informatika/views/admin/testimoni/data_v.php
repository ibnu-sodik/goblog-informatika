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
	<div class="table-responsive konten-testimoni">
		<div id="pesan"></div>
		<table class="table table-hover table-bordered" id="tabelKu">
			<thead>
				<tr>
					<th class="text-center">Foto Pengirim</th>
					<th class="text-center">Nama Pengirim</th>
					<th class="text-center">Profesi</th>
					<th class="text-center">Tanggal Kirim</th>
					<th class="text-center">Tampilkan</th>
					<th class="text-center">Opsi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($data_testimoni->result() as $row):
					$gambar = base_url('uploads/testimoni/').$row->foto_testimoni;
					$thumbs = base_url('uploads/testimoni/thumbs/').$row->foto_testimoni;
					if ($row->dilihat == 0) {
						$warna = "purple";
					}else{
						$warna = '';
					}
					?>
					<tr style="cursor: pointer;" class="<?= $warna ?>">
						<td class="text-center">
							<div class="ace-thumbnails clearfix">
								<a href="<?= $gambar ?>" data-rel="colorbox">
									<img src="<?= $thumbs ?>" width="50" height="50" alt="<?= $row->nama_testimoni ?>" class="img-thumbnail img-responsive img-fluid img-circle">
								</a>
							</div>
						</td>
						<td data-id="<?= $row->id_testimoni ?>" class="text-left"><?= $row->nama_testimoni ?></td>
						<td data-id="<?= $row->id_testimoni ?>" class="text-center"><?= $row->profesi_testimoni ?></td>
						<td data-id="<?= $row->id_testimoni ?>" class="text-center"><?= tanggal_indo($row->tgl_kirim) ?></td>
						<td class="text-center">
							<label>
								<input data-id="<?= $row->id_testimoni ?>" name="tampil" class="ace ace-switch" type="checkbox" <?= $row->tampil == 1 ? 'checked' : ''; ?>>
								<span class="lbl" data-lbl="YA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TIDAK"></span>
							</label>
						</td>
						<td class="text-center">
							<a onclick="conf_hapus()" class="red" id="tombolHapus" href="<?= site_url('admin/testimoni/hapus/').$row->id_testimoni ?>">
								<i class="ace-icon fa fa-trash bigger-130"></i>
							</a>
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
				<h4 class="modal-title">Detail Testimoni</h4>
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

		$('.ace-switch').change(function() {
			var id 		= $(this).data('id');
			var status 	= $(this).prop('checked') === true ? 1 : 0;

			$.ajax({
				type : "GET",
				dataType : "JSON",
				url : "<?= site_url('admin/testimoni/ubah_tampil/') ?>"+id,
				data : {
					'status' : status
				},
				success: function(data){
					var tipe = data.tipe;

					toastr.options.closeButton = true;
					toastr.options.closeMethod = 'fadeOut';
					toastr.options.closeDuration = 100;
					Command: toastr[tipe](data.pesan, 'Berhasil.!');
				}
			});
		});

		$('.konten-testimoni table tr td').not(":first-child, :last-child, :nth-child(5)").on('click', function(e) {
			e.stopPropagation();
			e.preventDefault();
			var id = $(this).data('id');
			$('#detailModal #showData').html('<div id="loading"></div>');

			$.ajax({
				url : "<?= site_url('admin/testimoni/detail/') ?>"+id,
				method : "POST",
				dataType : "JSON",
				data : {},
				success : function(data)
				{
					$('#detailModal #showData').html(data.detail_testimoni);
				}
			});
			$('#detailModal').modal('show');
		});

		$('#tabelKu').dataTable();

	});

	function conf_hapus() {
		event.preventDefault();
		var a 		= document.getElementById('tombolHapus');
		const href 	= a.getAttribute('href');
		swal({
			title: "Apakah Anda Yakin?",
			text: "Data Ini Akan Saya Hapus!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			closeOnConfirm: false,
			closeOnCancel: false,
			showCancelButton: true
		}).then((willDelete) => {
			if (willDelete) {
				document.location.href = href;
			}else{
				swal("Batal", "Data tidak kami hapus :)", "error");
			}
		});
	}
</script>