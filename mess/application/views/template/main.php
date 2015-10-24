<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php if (isset($heading)) {
                    echo $heading;
                } ?>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <?php
    if (isset($page)) {
        $this->load->view('include/' . $page);
    }
    ?>


</div>

</div>
<!-- /#wrapper -->