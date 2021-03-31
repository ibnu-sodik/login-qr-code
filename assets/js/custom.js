$(document).ready(function() {
	
	$('.tombol-hapus').on('click', function(e) {
    e.preventDefault();
    const href = $(this).attr('href');
    swal({
     title: "Apakah Anda Yakin?",
     text: "Data Ini Akan Saya Hapus!",
     icon: "warning",
     buttons: true,
     dangerMode: true
   }).then((willDelete) => {
    if (willDelete) {
      document.location.href = href;
    }
  });
 });

  $('#tabelKu').DataTable();

  $('.pilih2').select2();

});