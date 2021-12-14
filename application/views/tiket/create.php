<?php 
date_default_timezone_set("Asia/Jakarta");
$tomorrow=date('Y-m-d h:i:s');
// echo $tomorrow;
 ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

 <!-- Main content -->
  <section class="content container-fluid">

    <div class="col-md-12">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah Tiket</h3>

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

            <form method="POST" action="<?php echo site_url('home/create') ?>" class="form-horizontal">
               <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" name="nama"  class="form-control" placeholder="Nama">
                </div>
                
              </div>
              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" name="email"  class="form-control" placeholder="Email">
                  <?php echo form_error('Email');?>
                </div>                
              </div>

               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">No Hp</label>
                <div class="col-sm-9">
                  <input type="text" name="nohp"  class="form-control" placeholder="No Hp">
                  <?php echo form_error('No Hp');?>
                </div>                
              </div>

               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Hari 1</label>
                <div class="col-sm-3">
                  <input type="text" name="info_1" id="harga"  class="form-control" placeholder="Hari 1">
                  <?php echo form_error('info_1');?>
                </div>  
                 <label for="username" class="col-sm-2 control-label">Jumlah Tiket</label>
                <div class="col-sm-3">
                  <input type="text" name="note_1" id="jumlah"  maxlength="2" class="form-control" placeholder="Jumlah Tiket">
                  <?php echo form_error('note_1');?>
                </div>                
              </div>

               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Hari 2</label>
                <div class="col-sm-3">
                  <input type="text" name="info_2" id="harga1"  class="form-control" placeholder="Hari 2">
                  <?php echo form_error('info_2');?>
                </div>  
                 <label for="username" class="col-sm-2 control-label">Jumlah Tiket</label>
                <div class="col-sm-3">
                  <input type="text" name="note_2" id="jumlah1" maxlength="2" class="form-control" placeholder="Jumlah Tiket">
                  <?php echo form_error('note_2');?>
                </div>                
              </div>

               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Hari 3</label>
                <div class="col-sm-3">
                  <input type="text" name="info_3" id="harga2"  class="form-control" placeholder="Hari 3">
                  <?php echo form_error('info_3');?>
                </div>  
                 <label for="username" class="col-sm-2 control-label">Jumlah Tiket</label>
                <div class="col-sm-3">
                  <input type="text" name="note_3" id="jumlah2" maxlength="2"  class="form-control" placeholder="Jumlah Tiket">
                  <?php echo form_error('note_3');?>
                </div>                
              </div>

              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Kode Promo</label>
                <div class="col-sm-9">
                  <input type="text" name="kode_promo"  class="form-control" placeholder="kode promo">
                  <?php echo form_error('kode_promo');?>
                </div>                
              </div>

                <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Diskon</label>
                <div class="col-sm-9">
                  <input type="text" name="diskon" id="diskon"  class="form-control" placeholder="Diskon">
                  <?php echo form_error('diskon');?>
                </div>                
              </div>
              <input type="hidden" name="statuspembayaran" value="SUCCESS">
              <input type="hidden" name="waktu_pembelian" value="<?php echo $tomorrow ?>">
<?php 
  $this->load->helper('string');
 ?>
              <input type="hidden" name="random_code" value="<?php echo random_string('alnum',2) ?>">
              <input type="hidden" name="order_id" value="<?php echo random_string('alnum',4) ?>">
               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Total Harga</label>
                <div class="col-sm-9">
                <input type="text" name="total_harga" id="total_harga"  class="form-control" placeholder="Harga" readonly="">
                </div>                
              </div>
                 
               <!--  <input type="hidden" name="total_harga" id="total1"  class="form-control" placeholder="Harga" readonly="">
                 

               <input type="hidden" name="total_harga" id="total2"  class="form-control" placeholder="Harga" readonly="" > -->
                  

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
    $("#menu-tiket").addClass("active");
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
        $("#jumlah, #harga,#jumlah1,#harga1,#jumlah2,#harga2,#diskon").keyup(function() {
          
            var harga  = $("#harga").val();
            var jumlah = $("#jumlah").val();
            var harga1  = $("#harga1").val();
            var jumlah1 = $("#jumlah1").val();
            var harga2  = $("#harga2").val();
            var jumlah2 = $("#jumlah2").val();
            var total,total1,total2,alltotal=0;
            var diskon = 0;
          if(!isNaN(parseInt(harga))&&!isNaN(parseInt(jumlah))&& (harga) && (jumlah) ){
            total = parseInt(harga) * parseInt(jumlah);
          }else{
            total=0;
          }
            // $("#total").val(total);
          if(!isNaN(parseInt(harga1))&&!isNaN(parseInt(jumlah1))&& (harga1) && (jumlah1) ){
            total1 = parseInt(harga1) * parseInt(jumlah1);
          }else{
            total1=0;
          }
            // $("#total1").val(total1);
          if(!isNaN(parseInt(harga2))&&!isNaN(parseInt(jumlah2))&& (harga2) && (jumlah2) ){
            total2 = parseInt(harga2) * parseInt(jumlah2);
          }else{
            total2=0;
          }

          alltotal=total+total1+total2-diskon;

          $("#total_harga").val(alltotal);


        });
    });
</script>