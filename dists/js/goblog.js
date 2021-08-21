
const flashData = $('.flash-data').data('flashdata');
if (flashData) {

	swal({
		title: "Oops!",
		text: flashData,
		icon: "warning",
		button: false
	});

}

const pesanSukses = $('.pesan-sukses').data('flashdata');
if (pesanSukses) {

	swal({
		title: "Berhasil!",
		text: pesanSukses,
		icon: "success",
		button: false
	});

}