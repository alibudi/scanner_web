<?php 
date_default_timezone_set("Asia/Jakarta");
$sekarang=date('Y-m-d H:i:s');
 ?>
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

    
            <form class="form-horizontal" method="post" action="<?php echo site_url('home/addSnack') ?>">
              <div class="form-group">
                <div id="qr-reader"></div>
                <div id="qr-reader-results"></div> 
                <div id="result" hidden>Result Here</div>
        </div>

              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">ID tiket</label>
                <div class="col-sm-9">
                  <input id="codee" type="text" name="id_tiket"   class="form-control" placeholder="Id Tiket" disabled>
                </div>                
              </div>

              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" name="userscanner" value="<?php echo $id_user ?>"   class="form-control" placeholder="Username" disabled>
                </div>
              </div>

               <div  class="form-group">
                    <label for="kategori" class="col-sm-3 control-label"> Aktivitas</label>
                <div class="col-sm-9">
                        <select name="kegiatan" class="form-control">
                            <option value="">-- Pilih Aktivitas --</option>
                            <option  value="Masuk">Masuk</option>
                            <option  value="Snack">Snack</option>
                            <option value="Mercedes">Marcedes</option>
                        </select>
                        <?php echo form_error('activitas');?>
                </div>
              </div>

              <input type="text" name="waktu" value=" <?php echo $sekarang ?>"hidden>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-2">
                  <button type="submit" name="submit" value="submit" class="btn btn-success">Simpan</button>
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
    $("#menu-snack").addClass("active");
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
          console.log("test");
          console.log("test :"+decodedText);
          console.log("test :"+decodedResult);
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                // document.getElementById('code').innerHTML = '<p class="result">' + decodedText + '</p>';
                var codee =  document.getElementById('result').innerHTML = decodedText;
                // console.log(codee.slice(codee.length - 1));
                var jumlah = codee.slice(codee.length - 5) - 10000;
                console.log(jumlah);
                document.getElementById('codee').value = jumlah
                // var codee = document.getElementById('result').innerText;
                // document.getElementById('codee').value = codee;
                // console.log(`Scan result ${decodedText}`, decodedResult);

                var xhr = new XMLHttpRequest();
                xhr.withCredentials = true;

                xhr.addEventListener("readystatechange", function() {
                  if(this.readyState === 4) {
                    console.log(this.responseText);
                    
                  }
                });

              xhr.open("GET", "http://localhost/muslima/api/tiket.php?id="+codee);

              xhr.send();
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    });
</script>