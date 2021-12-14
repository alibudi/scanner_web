<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>assets/img/user.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $id_user ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
      <!--   <li id="menu-beranda"><a href="<?php echo base_url('admin')?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
        <li id="menu-redem"><a href="<?php echo base_url('admin/total_redem');?>"><i class="fa fa-book"></i> Data Redeem</a></li>
        <li id="menu-trafic"><a href="<?php echo base_url('admin/total');?>"><i class="fa fa-users"></i> Data User</a></li>-->
        <li id="menu-tiket"><a href="<?php echo base_url('home/tiket');?>"><i class="fa fa-users"></i> Tiket
        </a></li> 
        <li id="menu-profil"><a href="<?php echo base_url('lomba');?>"><i class="fa fa-book"></i> Lomba
        </a></li> 
        <li id="menu-profil"><a href="<?php echo base_url('home/profil');?>"><i class="fa fa-users"></i> Profil
        </a></li> 
        <li id="menu-scanner"><a href="<?php echo base_url('home/detail')?>"><i class="fa fa-user"></i> <span>Scanner</span></a></li>
        <li id="menu-tenan"><a href="<?php echo base_url('home/tenan')?>"><i class="fa fa-user"></i> <span>Tenan</span></a></li>
        <li><a href="<?php echo base_url('auth/logout');?>"><i class="fa fa-sign-out"></i> <span>Keluar</span></a></li>
   
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
