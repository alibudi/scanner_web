
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Setting
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin/member');?>"><i class="fa fa-user"></i>Profile</a></li>
      <!--<li class="active">Here</li>-->
    </ol>
  </section>

 <!-- Main content -->
  <section class="content container-fluid">

    <div class="col-md-12">
      <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Setting</h3>

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
                echo form_open('home/changeProfil/'.$user->id,$name);
            ?>

               <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Hari</label>
                <div class="col-sm-9">
                  <input type="text" name="hari" value="<?php echo $user->hari ?>" class="form-control" placeholder="Hari">
                </div>
                
              </div>
              <div class="form-group">
                <label for="username" class="col-sm-3 control-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" name="username" value="<?php echo $user->username;?>" class="form-control" placeholder="Hari">
                  <?php echo form_error('username');?>
                </div>
                
              </div>

           

              <div class="form-group">
                <label for="lastname" class="col-sm-3 control-label">Aktivitas</label>
                 <div class="col-sm-9">
                   <select class="form-control" name="aktivitas" >
                          <?php if ($user->aktivitas == 'Masuk') { ?>
                              <option selected value="Masuk">Masuk</option>
                              <option  value="Snack">Snack</option>
                              <option value="Marcedes">Marcedes</option>
                          <?php } else if ($user->aktivitas == 'Snack') { ?>
                                <option value="Masuk">Masuk</option>
                              <option selected value="Snack">Snack</option>
                              <option value="Marcedes">Marcedes</option>
                              <?php } else { ?>
                             <option value="Masuk">Masuk</option>
                              <option  value="Snack">Snack</option>
                              <option selected value="Marcedes">Marcedes</option>
                          <?php } ?>
                      </select>
                </div>
              </div>

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
    $("#menu-profil").addClass("active");
  });
</script>