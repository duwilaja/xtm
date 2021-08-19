  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark navbar-info">
    <div class="container">
      <a href="home<?php echo $ext?>" class="navbar-brand" style="padding:0px">
        <img src="belitar.png" alt="<?php echo $sub?>" class="brand-image img-circle elevation-3"
             style="opacity: .8; height: 45px;">
        <span class="brand-text font-weight-light"><b><?php echo $app?></b></span>
      </a>
	<?php if($s_ACCESS!='T'){?>
	  <a style="border: none;" class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </a>
	<?php }?>
	  
		<div class="collapse navbar-collapse order-1" id="navbarCollapse">
		  <!-- Top navbar links -->
		  <ul class="navbar-nav">
			<li class="nav-item">&nbsp;</li>
	<?php if($s_ACCESS!='T'){?>
			<li class="nav-item dropdown d-sm-inline-block">
			
				<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Master Data</a>
				<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				  <li><a href="barang<?php  echo $ext?>" class="dropdown-item">Barang </a></li>
				  <li><a href="kategori<?php  echo $ext?>" class="dropdown-item">Kategori</a></li>
				  <li><a href="jenismerk<?php  echo $ext?>" class="dropdown-item">Jenis/Merk</a></li>
				  <li><a href="unit<?php  echo $ext?>" class="dropdown-item">Unit</a></li>
				  <li class="dropdown-divider"></li>
				  <li><a href="toko<?php  echo $ext?>" class="dropdown-item">Toko</a></li>
				</ul>
			  
			</li>
			<li class="nav-item d-sm-inline-block">
			  <a href="transaksi<?php echo $ext?>" class="nav-link">Stok Barang</a>
			</li>
			<li class="nav-item d-sm-inline-block">
			  <a href="laporan<?php echo $ext?>" class="nav-link">Laporan</a>
			</li>
	<?php }?>
			<li class="nav-item d-sm-inline-block">
			
				<a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><?php echo $s_NAME?></a>
				<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
				   <li><a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_password">Ubah Password</a></li>
				   <li><a href="logout<?php echo $ext?>" class="dropdown-item">Logout</a></li>
				</ul>
				
			</li>
			
		  </ul>
		</div>
		
      <!-- Right navbar links -->
      <ul class="order-md-3 navbar-nav navbar-no-expand ml-auto">
<?php if($s_ACCESS=='S'){?>
		<!-- Messages Dropdown Menu --
        <li class="nav-item dropdown">
          <a class="nav-link" href="vehicles<?php echo $ext?>">
            <i class="fas fa-bus"></i>
            <!--span class="badge badge-danger navbar-badge">8</span--
          </a>
        </li-->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a title="Pengguna" class="nav-link" href="users<?php echo $ext?>">
            <i class="far fa-user"></i>
            <!--span class="badge badge-warning navbar-badge">15</span-->
          </a>
        </li>
<?php }?>
        <!--li class="nav-item">
          <a title="Password" class="nav-link" href="#" data-toggle="modal" data-target="#modal_password"><i
              class="fas fa-lock"></i></a>
        </li>
        <li class="nav-item">
          <a title="Logout" class="nav-link" href="logout<?php echo $ext?>"><i
              class="fas fa-power-off"></i></a>
        </li-->
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->
  