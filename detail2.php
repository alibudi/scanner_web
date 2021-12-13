
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

              <?php
                $name = array(
                    'name'=>'profil',
                    'class'=>'form-horizontal'
                    );  
                echo form_open('home/detailTiket/'.$tiket->id,$name);
            ?>

               <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" name="nama" value="<?php echo $tiket->nama ?>"  class="form-control" placeholder="Nama" disabled>
                </div>
                
              </div>
              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" name="email"  class="form-control" value="<?php echo $tiket->email ?>" placeholder="Email" disabled>
                  <?php echo form_error('Email');?>
                </div>                
              </div>

               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">No Hp</label>
                <div class="col-sm-9">
                  <input type="text" name="nohp" value="<?php echo $tiket->nohp ?>" class="form-control" placeholder="No Hp" disabled>
                  <?php echo form_error('No Hp');?>
                </div>                
              </div>
               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Harga</label>
                <div class="col-sm-9">
                  <input type="text" name="nohp" value="<?php echo $tiket->total_harga ?>" class="form-control" placeholder="No Hp" disabled>
                  <?php echo form_error('No Hp');?>
                </div>                
              </div>

               <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Jumlah Tiket Hari ke 1</label>
                <div class="col-sm-9">
                  <input type="text" name="nohp" value="<?php echo $tiket->note_1 ?>" class="form-control" placeholder="No Hp" disabled>
                  <?php echo form_error('No Hp');?>
                </div>                
              </div>

<div class="form-group">
                <label for="username" class="col-sm-3 control-label">Jumlah Tiket Hari ke 2</label>
                <div class="col-sm-9">
                  <input type="text" name="nohp" value="<?php echo $tiket->note_2 ?>" class="form-control" placeholder="0" disabled>
                  <?php echo form_error('No Hp');?>
                </div>                
              </div>

<div class="form-group">
                <label for="username" class="col-sm-3 control-label">Jumlah Tiket Hari ke </label>
                <div class="col-sm-9">
                  <input type="text" name="nohp" value="<?php echo $tiket->note_3 ?>" class="form-control" placeholder="0" disabled>
                  <?php echo form_error('No Hp');?>
                </div>                
              </div>

             
            </form>             
          </div>
          <!-- /.box-body -->
      </div>
      <!-- /.col -->
    </div>

    <?php
      $hilangnyaBackslash = stripslashes($qrnya);
      $ubahLinknya = str_replace('/var/www/html/panitia//', '', $hilangnyaBackslash);
      $srcLink = base_url() . $ubahLinknya;
    ?>
    <?php echo $srcLink ?>
<!-- <?php print_r($statusTicket) ?>  -->

    <div class="col-md-12">
      <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Data</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div> 
      <!-- Default box -->
        <div class="box-body">
        <?php if($this->session->flashdata('info')){ ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo $this->session->flashdata('info'); ?>
                </div>
            <?php } ?>
            <br /><br />
            <div class="table-responsive">
             <?php if($statusTicket!=null){?>
              <table width="100%" class="table table-striped table-bordered table-hover" id="table">
                    <?php } else { ?>
              <table width="100%" class="table table-striped table-bordered table-hover">
            <?php } ?>
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Kode Barcode</th>
                          <th>Hari 1</th>
                          <th>Hari 2</th>
                          <th>Hari 3</th>
                          <th>Waktu Pembelian</th>
                          <th>Barcode</th>
                          <!-- <th>Foto</th> -->
                          <!-- <th style="text-align: center;">Aksi</th> -->
                      </tr>
                  </thead>
                  <tbody>
                     <?php 
                  $no = 1;
                  if($statusTicket!=null){
                    foreach($statusTicket as $d){                  
                  ?>
                  <tr>
                       <td><?php echo $no++ ?></td>
                       <td><?php echo $d['order_id']?><?php echo $d['random_code'] ?><?php echo $d['tiket_id'] ?></td>
                       <td><?php echo $d['note_1'] ?></td>
                       <td><?php echo $d['note_2'] ?></td>
                       <td><?php echo $d['note_3'] ?></td>
                        <td><?php echo $d['waktu_pembelian'] ?></td>
                     <td> <a href="<?php echo "https://hops.id/muslimafest/".$d['order_id'].$d['random_code'].$d['tiket_id'].".pdf"?>"><i class="fa fa-eye"></i></a></td>
                  </tr>
                  <?php }
                    } else { ?>
                    <tr>
                      <td class="text-center" colspan="9"><i>Tidak Ada Data</i></td>
                    </tr>
                  <?php } ?>
            </tbody>
              </table>
              </div>
              </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function(){
    $("#menu-tiket").addClass("active");
  });
</script>
