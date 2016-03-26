<!-- Content Wrapper. Contains page content -->
      <div style="display:none;" class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php if (isset($heading)) {
                    echo $heading;
                } 
	    ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Your Page Content Here -->
	
				<?php
				    if (isset($page)) {
					$this->load->view('include/' . $page);
				    }
		    		?>
			
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<script>
    $(document).ready(function() {
        $(".content-wrapper").fadeIn(1000);
    })
</script>
