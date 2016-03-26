<aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
        

          <!-- search form (Optional) -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <?php
                if($_SESSION['role'] == 'M') {
            ?>
                <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                <li><a href="<?php echo base_url('dashboard/member') ?>"><i class="fa fa-user"></i> Member</a></li>
                <li>
                    <a href="<?php echo base_url('dashboard/accounts') ?>"><i class="fa fa-money"></i> Mess Accounts</a>

                </li>

                <li>
                    <a href="<?php echo base_url('dashboard/expenditure')?>"><i class="fa fa-shopping-cart"></i> Expenditure</a>

                </li>


                <li id="meal"><a href="<?php echo base_url('dashboard/meal')?>"><i class="fa fa-cutlery"></i> Meal</a></li>

                <li><a href="<?php echo base_url('dashboard/userpanel')?>"><i class="fa fa-user-plus"></i> User Panel</a></li>

                <li><a href="<?php echo base_url('dashboard/report')?>"><i class="fa fa-pie-chart"></i></i> Report</a></li>
                <li><a href="<?php echo base_url('dashboard/user-guide')?>"><i class="fa fa-book"></i> Documentation</a></li>
                <?php
                } elseif($_SESSION['role'] == 'U') {
                    ?>
                    <li><a href="<?php echo base_url('dashboard/panel')?>"><i class="fa fa-home"></i> Panel</a></li>
                    <?php
                } else {
            ?>
                    <li><a href="<?php echo base_url('dashboard/test') ?>"><i class="fa fa-tachometer"></i>

            <?php }?>

	<!-- /.Multilevel Menu
            <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li><a href="#">Link in level 2</a></li>
                <li><a href="#">Link in level 2</a></li>
              </ul>
            </li>
	-->
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
