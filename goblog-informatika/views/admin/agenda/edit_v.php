<?php $row = $data->row_array(); ?>
<link href="<?= base_url() ?>dists/summernote/summernote.css" rel="stylesheet">
<link href="<?= base_url() ?>dists/dropify/dropify.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>dists/css/bootstrap-datepicker3.min.css" />
<div class="page-header">
	<h1>
		<a href="javascript:void(0)" onclick="kembali()"><span class="label label-lg label-primary arrowed">Kembali</span></a>
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
	<form class="form-horizontal" method="POST" enctype="multipart/form-data" role="form" action="<?= $form_action.'/'.$row['id_agenda']; ?>">
		<div class="col-md-8 col-xs-12">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="nama_agenda">Nama Agenda</label>

				<div class="col-sm-9">
					<input type="text" id="nama_agenda" placeholder="Nama Agenda" name="nama_agenda" class="form-control judul"  value="<?= $row['nama_agenda'] ?>" />
					<?= form_error('nama_agenda'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="slug"></label>

				<div class="col-sm-9">
					<input type="text" id="slug" placeholder="Permalink" name="slug" value="<?= $row['slug_agenda'] ?>" class="form-control slug" readonly />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="konten">Konten</label>

				<div class="col-sm-9">
					<textarea class="form-control" name="konten" id="summernote"><?= $row['konten_agenda'] ?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="image"> Gambar </label>

				<div class="col-sm-9">
					<input type="file" name="filefoto" id="image" class="dropify" data-height="190" data-default-file="<?= base_url('uploads/agenda/'.$row['gambar_agenda']) ?>" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="tgl_pelaksanaan"> Tanggal Pelaksanaan </label>
				<div class="col-sm-9">
					<div class="input-group">
						<input class="form-control date-picker" value="<?= $row['tgl_pelaksanaan'] ?>" id="tgl_pelaksanaan" name="tgl_pelaksanaan" type="text" data-date-format="yyyy-mm-dd" placeholder="Tanggal Pelaksanaan" />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
					<?= form_error('tgl_pelaksanaan'); ?>
				</div>
			</div>

			<div class="form-group">									
				<label class="col-sm-3 control-label no-padding-right" for="durasi"> Durasi (hari)</label>
				<div class="col-sm-9">
					<div class="input-group">
						<select name="durasi" id="durasi" class="form-control chosen-select">
							<option value="">--- Durasi ---</option>
							<?php 
							for ($i=1; $i <= 31 ; $i++):
								if ($row['durasi'] == $i) {
									$cek = 'selected';
								}else{
									$cek = '';
								}
								?>
								<option value="<?= $i; ?>" <?= $cek ?>><?= $i; ?></option>
							<?php endfor; ?>
						</select>
						<span class="input-group-addon">
							<i class="fa fa-clock-o bigger-110"></i>
						</span>
					</div>
					<?= form_error('durasi'); ?>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3 no-padding-right" for="meta-deskripsi">Meta Deskripsi</label>
				<div class="col-sm-9">
					<textarea placeholder="Meta Deskripsi" name="deskripsi" for="meta-deskripsi" class="form-control" rows="10"><?= $row['deskripsi_agenda'] ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3 no-padding-right"></label>
				<div class="col-sm-9">
					<input type="hidden" name="id_agenda" value="<?= $row['id_agenda'] ?>">
					<button type="submit" name="submit" class="btn btn-block btn-primary">Publish <i class="fa fa-send"></i></button>
				</div>
			</div>
		</div>
	</form>
</div>

<script src="<?= base_url() ?>dists/dropify/dropify.min.js"></script>
<script src="<?= base_url() ?>dists/summernote/summernote.js"></script>
<script src="<?= base_url() ?>dists/summernote/lang/summernote-id-ID.js"></script>
<script src="<?= base_url() ?>dists/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>dists/js/form.js"></script>

<script type="text/javascript">
	$('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true
	})
</script>