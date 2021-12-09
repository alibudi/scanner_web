<?php 
date_default_timezone_set("Asia/Jakarta");
$sekarang=date('Y-m-d H:i:s');
 ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
 <!-- Main content -->
  <section class="content container-fluid">

    <div class="col-md-12">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Scanner</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
             <?php if($this->session->flashdata('info')){ ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $this->session->flashdata('info'); ?>
                </div>
            <?php } ?>

<!-- <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
             type: "POST",
             crossOrigin: true,
             url: 'https://localhost/muslima/api/a.php',
             data: {
              id_tiket : <?php echo $author_id ?>,
              userscanner : <?php echo $id_artikel ?>,
              waktu : "<?php echo $datee ?>"
              kegiatan :
             },
             // dataType:"json",   
              dataType: 'JSON',
             success: function(data){
                console.log(data);
             
             }
        });
        })
        </script> -->
    
            <form class="form-horizontal" method="post" action="<?php echo site_url('home/addSnack') ?>">
              <div class="form-group">
                <div id="qr-reader"></div>
                <div id="qr-reader-results"></div> 
                <div id="result" hidden>Result Here</div>
        </div>

              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">ID tiket</label>
                <div class="col-sm-9">
                  <input id="codee" type="text" name="id_tiket"   class="form-control" placeholder="Id Tiket" >
                </div>                
              </div>

              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" name="nama" id="nama"  class="form-control" placeholder="Nama" disabled>
                </div>
              </div>

             <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Masuk</label>
                <div class="col-sm-9">
                  <input type="text" name="kegiatan" value="<?php echo $user->aktivitas ?>" id="masuk"  class="form-control" placeholder="Masuk" >
                </div>
              </div>
              <input type="text" name="userscanner" value="<?php echo $user->username ?>" hidden>
               <div  class="form-group">
                    <label for="kategori" class="col-sm-3 control-label"> Status</label>
                <div class="col-sm-9">
                      <input type="text" name="status" id="status" class="form-control" placeholder="staus">
                        <?php echo form_error('activitas');?>
                </div>
              </div>

              <input type="text" name="waktu" value=" <?php echo $sekarang ?>"hidden>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-2">
                  <button type="submit" name="submit" value="submit" class="btn btn-success">Simpan & Scan Lagi</button>
                </div>
              </div>
            </form>             
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.col -->
    </div>

   

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function(){
    $("#menu-scanner").addClass("active");
  });
</script>

<script src="https://unpkg.com/html5-qrcode@2.1.2/html5-qrcode.min.js"></script>

<script>
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        function onScanSuccess(decodedText, decodedResult) {
          // console.log("test");
          console.log("test :"+decodedText);
          // console.log("test :"+decodedResult);
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                var codee =  document.getElementById('result').innerHTML = decodedText;
                var jumlah = codee.slice(codee.length - 5) - 10000;
                // console.log(jumlah);
                document.getElementById('codee').value = jumlah
      
                // fetch('https://muslim.hops.id/api/tiket.php?id='+codee)
                // .then(response => response.json())
                // .then(data => console.log(data));

                var xhr = new XMLHttpRequest();
                var url = "http://localhost/panitia/api/insert.php?id=";
                var url2 = "&kegiatan=masuk";
                xhr.withCredentials = true;
                console.log("cek");
                xhr.addEventListener("readystatechange", function() {
                  if(this.readyState === 4) {
                    console.log(this.responseText);
                      // console.log(json.parse(this.responseText));
                      // console.log();
                      let tiket = JSON.parse(this.responseText);
                      let nama = "";
                      let status = "";
                      console.log(tiket);
                      tiket.forEach(function(daftar){
                        nama +=`${daftar.nama}`;
                        status +=`${daftar.status}`;
                        console.log(nama);
                        console.log(status);
                      });
                      // var b = JSON.parse(this.responseText[0].nama);
                      // console.log(b);
                    document.getElementById('nama').value = nama;
                    document.getElementById('status').value = status;
                  }
                });

              xhr.open("GET", url+jumlah+url2);

              xhr.send();
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    });
</script>