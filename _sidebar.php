
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<a class="sidebar-brand d-flex align-items-center" href="<?php echo BASEURL;?>backoffice/dashboard/">
				<img src="<?php echo BASEURL;?>backoffice/images/logo_bo.png" style="max-width: 100%; max-height: 40px;">
			</a>

			<hr class="sidebar-divider ">

			<div class="sidebar-heading">Menu</div>

			<li class="nav-item <?php if( $section=="dashboard" ) echo "active";?>">
				<a class="nav-link" href="<?php echo BASEURL;?>backoffice/dashboard/">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
			</li>

			<li class="nav-item <?php if( $section=="startup_list" ) echo "active";?>">
				<a class="nav-link" href="<?php echo BASEURL;?>backoffice/startup_list/">
					<i class="far fa-fw fa-building"></i>
					<span>Startup list</span></a>
			</li>

			<li class="nav-item <?php if( $section=="main_founders" ) echo "active";?>">
				<a class="nav-link" href="<?php echo BASEURL;?>backoffice/main_founders/">
					<i class="fas fa-fw fa-user-friends"></i>
					<span>Main founders</span></a>
			</li>

			<li class="nav-item <?php if( $section=="co_founders" ) echo "active";?>">
				<a class="nav-link" href="<?php echo BASEURL;?>backoffice/co_founders/">
					<i class="fas fa-fw fa-users"></i>
					<span>Co-founders</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="<?php echo BASEURL;?>backoffice/startup_portfolios/">
					<i class="fas fa-fw fa-book-open"></i>
					<span>Startup portfolio</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="<?php echo BASEURL;?>backoffice/export_all/">
					<i class="fas fa-fw fa-download"></i>
					<span>Export founders</span></a>
			</li>

			<li class="nav-item">
				<a class="nav-link" href="<?php echo BASEURL;?>backoffice/logout/">
					<i class="fas fa-fw fa-power-off"></i>
					<span>Log Out</span></a>
			</li>

			<hr class="sidebar-divider d-none d-md-block">

			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

		</ul>
