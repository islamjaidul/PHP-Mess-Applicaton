<?php
if (isset($_SESSION['msg'])) {
?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-check-square-o"></i>
    <?php echo $_SESSION['msg']; ?>
</div>
<?php } ?>

<?php
if (isset($_SESSION['alert-msg'])) {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-exclamation-triangle"></i>
    <?php echo $_SESSION['alert-msg']; ?>
</div>
<?php } ?>

<!--Delete Div Start-->
<div class="modal fade" id="confirm-delete">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>

            <div class="modal-body">
                <p>You are about to permanently delete, this procedure is irreversible.</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="#" class="btn btn-danger danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<!--Delete Div End-->

<div class="box box-info">
    <div class="box-body">
        <div style="margin-bottom:10px"><a href="<?php echo base_url('dashboard/accounts/new') ?>" class="label label-success"><i class="fa fa-plus"></i> Add New</a></div>

        <?php
        //If any data available of the current month.
        if ($last_month == (int)date('m')) {
            ?>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php
                foreach ($rows as $row) {
                    if($row->amount != 0) {
                        ?>
                        <tr>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->amount; ?></td>
                            <td><?php echo $row->created_at; ?></td>
                            <td>
                                <a href="<?php echo base_url('dashboard/accounts/edit/'.$row->id.'')?>" id="<?php echo $row->id?>" class="label label-info"><i class="fa fa-pencil-square-o"></i></a>
                                <a data-href="<?php echo base_url('dashboard/accounts/delete/'.$this->encrypt->encode($row->id).'')?>" id="<?php echo $row->id?>" data-toggle="modal" data-target="#confirm-delete" href="#" class="label label-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php }} ?>
            </table>
        <?php } else {
            echo '<h4 style="color:red; text-align: left;">Please click (Add New) to add your cash</h4>';
        }?>

    </div><!-- /.box-body -->

</div>


<script>
    $(document).ready(function(){
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.danger').attr('href', $(e.relatedTarget).data('href'));

        });
    });
</script>
