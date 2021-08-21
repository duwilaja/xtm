
<nav class="main-header navbar navbar-expand navbar-dark navbar-info">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <!--li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li-->
    </ul>

    <!-- SEARCH FORM --
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $s_NAME?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_password">
            <i class="fas fa-lock mr-2"></i> Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="logout<?php echo $ext?>" class="dropdown-item">
            <i class="fas fa-power-off mr-2"></i> Logout
          </a>
          <div class="dropdown-divider"></div>
  <?php if($s_ACCESS=='S'){?>
          <a href="users<?php echo $ext?>" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Users
          </a>
          <div class="dropdown-divider"></div>
  <?php }?>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link navbar-info" style="text-align: center;">
      <img src="AdminLTELogo.png"
           class="brand-image img-circle elevation-3"
           style="opacity: 1">
      <span class="brand-text font-weight-light" style="color:white;"><?php echo $app?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header"></li>
		  <li class="nav-item">
            <a href="home<?php echo $ext?>" class="nav-link home">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>
		  <li class="dropdown-divider"></li>
	<?php if($s_ACCESS!="U"){?>
		  <li class="nav-item has-treeview cust serv prob">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-database"></i>
              <p>Master Data <i class="fas fa-angle-left right"></i></p>
            </a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a class="nav-link cust" href="customers<?php echo $ext?>">
						<i class="nav-icon fas fa-angle-right"></i><p>Customers</p>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link serv" href="services<?php echo $ext?>">
						<i class="nav-icon fas fa-angle-right"></i><p>Services</p>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link prob" href="problems<?php echo $ext?>">
						<i class="nav-icon fas fa-angle-right"></i><p>Problems</p>
					</a>
				</li>
				<!--li class="dropdown-divider"></li>
				<li class="nav-item">
					<a class="nav-link" href="toko<?php echo $ext?>">
						<i class="nav-icon fas fa-angle-right"></i><p>Toko</p>
					</a>
				</li-->
				
			</ul>
          </li>
		  <li class="nav-item has-treeview mingguan bulanan">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-excel"></i>
              <p>Reports <i class="fas fa-angle-left right"></i></p>
            </a>
			<ul class="nav nav-treeview">
				<li class="nav-item">
					<a class="nav-link rsummary" href="rsummary<?php echo $ext?>">
						<i class="nav-icon fas fa-angle-right"></i><p>Summary</p>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link rticket" href="rtickets<?php echo $ext?>">
						<i class="nav-icon fas fa-angle-right"></i><p>Ticket</p>
					</a>
				</li>
			</ul>
          </li>
		  <li class="dropdown-divider"></li>
	<?php }?>
		  <li class="nav-item">
            <a href="tickets<?php echo $ext?>" class="nav-link ticket">
              <i class="nav-icon fas fa-ticket-alt"></i>
              <p>Tickets</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
