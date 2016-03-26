<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                </div>
                <!-- /input-group -->
            </li>


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
                <li><a href="<?php echo base_url('dashboard/user-guide')?>"><i class="fa fa-book"></i> User Guide</a></li>
                <?php
                } elseif($_SESSION['role'] == 'U') {
                    ?>
                    <li><a href=""><i class="fa fa-tachometer"></i> Dashboard</a></li>
                    <li><a href="<?php echo base_url('dashboard/panel')?>"><i class="fa fa-home"></i> Panel</a></li>
                    <?php
                } else {
            ?>
                    <li><a href="<?php echo base_url('dashboard/test') ?>"><i class="fa fa-tachometer"></i>

            <?php }?>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>

