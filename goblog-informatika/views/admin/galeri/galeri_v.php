<link href="<?= base_url() ?>dists/dropify/dropify.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>dists/css/select2.min.css" />

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

<?php if(validation_errors()): ?>
	<div class="row">
		<div class="col-xs-12 col-md-6 col-md-offset-3">
			<div class="alert alert-block alert-warning">
				<button type="button" class="close" data-dismiss="alert">
					<i class="ace-icon fa fa-times"></i>
				</button>
				<?= form_error('id_album') ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-md-3 col-xs-12 col-sm-12">
		<div class="control-group">
			<label class="form-control-label bolder blue">Filter Berdasarkan Album</label>
			<?php foreach($fil_album->result() as $row): ?>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="album" class="fil_selector album ace ace-checkbox-2" value="<?= $row->id_album; ?>" />
						<span class="lbl"> <?= $row->nama_album; ?></span>
					</label>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="col-md-9 col-xs-12 col-sm-12">
		<div>
			<ul class="ace-thumbnails clearfix" id="filter_data">

			</ul>
		</div>
		<div id="pagination_link"></div>
	</div>
</div>

<!-- modal add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modalGaleri" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Tambah Galeri</h4>
			</div>
			<form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?= $form_action_add; ?>">
				<div class="modal-body">
					<div class="form-group">
						<label for="gambar_galeri" class="col-sm-3 control-label no-padding-right">Gambar</label>
						<div class="col-sm-9">
							<input type="file" name="filefoto" id="gambar_galeri" data-height="200" class="dropify">
						</div>
					</div>
					<div class="form-group">
						<label for="nama_galeri" class="col-sm-3 control-label no-padding-right">Judul</label>
						<div class="col-sm-9">
							<input type="text" name="nama_galeri" id="nama_galeri" placeholder="Judul" class="form-control" autofocus>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 no-padding-right control-label" for="id_album">Album</label>
						<div class="col-sm-9">
							<select name="id_album" class="form-control select2">
								<option value="">--- Pilih Album ---</option>
								<?php foreach ($fil_album->result() as $row): ?>
									<option value="<?= $row->id_album ?>"><?= $row->nama_album ?></option>
								<?php endforeach ?>
							</select>
						</div>
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

<div id="img" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<div id="nama"></div>
			</div>
			<div class="modal-body" id="modal-gambar">
				<div style="padding-bottom: 5px;">
					<center>
						<img src="" id="pict" alt="" class="img-responsive img-thumbnail">
					</center>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup <i class="fa fa-fw fa-remove"></i></button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
<script src="<?= base_url() ?>dists/js/select2.min.js"></script>
<script type="text/javascript">

	$(document).on("click", "#show_foto", function() {
		var id 		= $(this).data('id');
		var album 	= $(this).data('album');
		var nama 	= $(this).data('nama');
		var ft 		= $(this).data('foto');

		$("#nama").html('<h4 class="modal-title">'+nama+'</h4>');
		$("#modal-gambar #pict").attr("src", "<?= base_url('uploads/galeri/') ?>"+album+"/"+ft);
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

	$(".select2").select2({
    	width: '100%', // need to override the changed default
    	theme: "classic"
    });

	$('.dropify').dropify({
		messages: {
			default: 'Drag atau drop gambar disni',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'error'
		}
	});


	$(document).ready(function() {

		filter_data(1);


		function filter_data(page)
		{
			$('#filter_data').html('<div id="loading"></div>');
			var action 	= 'get_data';
			var album 	= filtrasi('album');
			$.ajax({
				url : "<?= base_url('admin/galeri/get_data/') ?>"+page,
				method : "POST",
				dataType : "JSON",
				data : {
					action : action,
					album : album
				},
				success : function(data)
				{
					$('#filter_data').html(data.daftar_galeri);
					$('#pagination_link').html(data.pagination_link);
				}
			});
		}

		function filtrasi(class_name) {
			var filter = [];
			$('.' + class_name + ':checked').each(function() {
				filter.push($(this).val());
			});
			return filter;
		}

		$(document).on("click", ".pagination li a", function(event) {
			event.preventDefault();
			var page = $(this).data("ci-pagination-page");
			filter_data(page);
		});

		$('.fil_selector').click(function() {
			filter_data(1);
		});

	});
</script>