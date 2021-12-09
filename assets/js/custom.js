$(document).ready(function() {
    $('#table').DataTable({
        responsive: true
    });
});

$(document).ready(function() {
    $('#tablejadwal').DataTable( {
        responsive: true,
        "order": [[ 1, "desc" ]]
    } );
});

$(document).ready(function() {
    $('#tabledarurat').DataTable( {
        responsive: true,
        "order": [[ 2, "desc" ]]
    } );
});

function functionTerima(url){
    swal({
      title: 'Apakah Anda Yakin?',
      text: "Anda akan menerima pergantian jadwal!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, terima!',
      cancelButtonText: 'Tidak, gagalkan!',
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false
    }).then(function () {
        swal("Terima!", "Anda telah menerima jadwal!", "success");
        window.location = url;

    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        swal("Cancelled", "Anda tidak jadi menerima jadwal!", "error")
      }

    });
}




function functionTolak(url){
    swal({
      title: 'Apakah Anda Yakin?',
      text: "Anda akan menolak jadwal pekan ini!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, tolak!',
      cancelButtonText: 'Tidak, gagalkan!',
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false
    }).then(function () {
        swal("Tertolak!", "Anda telah menolak jadwal!", "success");
        window.location = url;

    }, function (dismiss) {
      // dismiss can be 'cancel', 'overlay',
      // 'close', and 'timer'
      if (dismiss === 'cancel') {
        swal("Cancelled", "Anda tidak jadi menolak jadwal!", "error")
      }

    });
}